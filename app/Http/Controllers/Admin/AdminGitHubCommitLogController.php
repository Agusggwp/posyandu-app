<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AdminGitHubCommitLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 50);
        if (!in_array($perPage, [25, 50, 100], true)) {
            $perPage = 50;
        }

        $sort = (string) $request->query('sort', 'newest');
        if (!in_array($sort, ['newest', 'oldest'], true)) {
            $sort = 'newest';
        }

        $branch = trim((string) $request->query('branch', ''));
        $fromDate = trim((string) $request->query('from_date', ''));
        $toDate = trim((string) $request->query('to_date', ''));

        $response = $this->getCommits($perPage, $branch);
        $commits = [];
        $authors = [];
        $stats = [
            'total' => 0,
            'authors' => 0,
            'today' => 0,
            'last_update' => '-',
            'this_week' => 0,
            'top_author' => '-',
            'peak_day' => '-',
        ];
        $dailyActivity = [];
        $status = $response['status'];
        $search = trim((string) $request->query('q', ''));
        $authorFilter = trim((string) $request->query('author', ''));

        if ($status === 200) {
            $mappedCommits = collect($response['data'])->map(function ($item) {
                $sha = $item['sha'] ?? '';
                $dateIso = $item['commit']['author']['date'] ?? null;
                $dateTime = $dateIso ? Carbon::parse($dateIso)->setTimezone('Asia/Jakarta') : null;

                return [
                    'hash' => $sha,
                    'short_hash' => $sha ? Str::limit($sha, 10, '') : '',
                    'author' => $item['commit']['author']['name'] ?? $item['author']['login'] ?? 'Unknown',
                    'date_iso' => $dateTime?->toDateString(),
                    'date_timestamp' => $dateTime?->timestamp,
                    'date' => $dateTime ? $dateTime->format('d M Y') : '-',
                    'time' => $dateTime ? $dateTime->format('H:i:s') : '-',
                    'datetime' => $dateTime ? $dateTime->format('d M Y H:i:s') : '-',
                    'relative_time' => $dateTime ? $dateTime->diffForHumans() : '-',
                    'message' => trim((string) ($item['commit']['message'] ?? '')),
                    'message_short' => Str::limit(str_replace(["\r", "\n"], ' ', trim((string) ($item['commit']['message'] ?? ''))), 120),
                    'url' => $item['html_url'] ?? ($sha ? "https://github.com/Agusggwp/posyandu-app/commit/{$sha}" : null),
                ];
            });

            $authors = $mappedCommits
                ->pluck('author')
                ->filter()
                ->unique()
                ->sort()
                ->values()
                ->toArray();

            $filteredCommits = $mappedCommits
                ->when($search !== '', function ($collection) use ($search) {
                    $needle = Str::lower($search);

                    return $collection->filter(function ($commit) use ($needle) {
                        return Str::contains(Str::lower($commit['author']), $needle)
                            || Str::contains(Str::lower($commit['hash']), $needle)
                            || Str::contains(Str::lower($commit['message']), $needle);
                    });
                })
                ->when($authorFilter !== '', function ($collection) use ($authorFilter) {
                    return $collection->filter(function ($commit) use ($authorFilter) {
                        return Str::lower($commit['author']) === Str::lower($authorFilter);
                    });
                })
                ->when($fromDate !== '', function ($collection) use ($fromDate) {
                    return $collection->filter(function ($commit) use ($fromDate) {
                        return !empty($commit['date_iso']) && $commit['date_iso'] >= $fromDate;
                    });
                })
                ->when($toDate !== '', function ($collection) use ($toDate) {
                    return $collection->filter(function ($commit) use ($toDate) {
                        return !empty($commit['date_iso']) && $commit['date_iso'] <= $toDate;
                    });
                })
                ->values();

            $filteredCommits = $sort === 'oldest'
                ? $filteredCommits->sortBy('date_timestamp')->values()
                : $filteredCommits->sortByDesc('date_timestamp')->values();

            $topAuthor = $filteredCommits
                ->pluck('author')
                ->filter()
                ->countBy()
                ->sortDesc()
                ->keys()
                ->first() ?? '-';

            $startOfWeek = now('Asia/Jakarta')->startOfWeek(Carbon::MONDAY)->toDateString();
            $endOfWeek = now('Asia/Jakarta')->endOfWeek(Carbon::SUNDAY)->toDateString();

            $dailyActivity = collect(range(6, 0))
                ->map(function ($offset) use ($filteredCommits) {
                    $date = now('Asia/Jakarta')->subDays($offset);
                    $dateIso = $date->toDateString();
                    $count = $filteredCommits->where('date_iso', $dateIso)->count();

                    return [
                        'date_iso' => $dateIso,
                        'label' => $date->translatedFormat('D, d M'),
                        'count' => $count,
                    ];
                })
                ->values();

            $peakDay = $dailyActivity
                ->sortByDesc('count')
                ->first();

            $stats = [
                'total' => $filteredCommits->count(),
                'authors' => $filteredCommits->pluck('author')->filter()->unique()->count(),
                'today' => $filteredCommits->where('date_iso', now('Asia/Jakarta')->toDateString())->count(),
                'last_update' => $filteredCommits->first()['datetime'] ?? '-',
                'this_week' => $filteredCommits->filter(function ($commit) use ($startOfWeek, $endOfWeek) {
                    return !empty($commit['date_iso'])
                        && $commit['date_iso'] >= $startOfWeek
                        && $commit['date_iso'] <= $endOfWeek;
                })->count(),
                'top_author' => $topAuthor,
                'peak_day' => $peakDay ? ($peakDay['label'] . ' (' . $peakDay['count'] . ')') : '-',
            ];

            if ($request->query('export') === 'csv') {
                return $this->exportCsv($filteredCommits);
            }

            $commits = $filteredCommits->toArray();
        }

        return view('admin.github-commits', compact(
            'commits',
            'status',
            'authors',
            'stats',
            'search',
            'authorFilter',
            'perPage',
            'sort',
            'branch',
            'fromDate',
            'toDate',
            'dailyActivity'
        ));
    }

    private function exportCsv(Collection $commits)
    {
        $fileName = 'github-commit-log-' . now('Asia/Jakarta')->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($commits) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Hash', 'Author', 'Tanggal', 'Jam', 'Pesan Commit', 'URL']);

            foreach ($commits as $commit) {
                fputcsv($handle, [
                    $commit['hash'] ?? '',
                    $commit['author'] ?? '',
                    $commit['date'] ?? '',
                    $commit['time'] ?? '',
                    $commit['message'] ?? '',
                    $commit['url'] ?? '',
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function getCommits(int $perPage = 50, string $branch = '')
    {
        $query = [
            'per_page' => $perPage,
        ];

        if ($branch !== '') {
            $query['sha'] = $branch;
        }

        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github+json',
            'User-Agent' => config('app.name'),
        ])->get('https://api.github.com/repos/Agusggwp/posyandu-app/commits', $query);

        return [
            'status' => $response->status(),
            'data' => $response->successful() ? $response->json() : [],
        ];
    }
}
