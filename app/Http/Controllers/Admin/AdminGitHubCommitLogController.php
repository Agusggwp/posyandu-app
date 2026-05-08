<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $response = $this->getCommits();
        $commits = [];
        $authors = [];
        $stats = [
            'total' => 0,
            'authors' => 0,
            'today' => 0,
            'last_update' => '-',
        ];
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
                ->values();

            $stats = [
                'total' => $filteredCommits->count(),
                'authors' => $filteredCommits->pluck('author')->filter()->unique()->count(),
                'today' => $filteredCommits->where('date_iso', now('Asia/Jakarta')->toDateString())->count(),
                'last_update' => $filteredCommits->first()['datetime'] ?? '-',
            ];

            $commits = $filteredCommits->toArray();
        }

        return view('admin.github-commits', compact('commits', 'status', 'authors', 'stats', 'search', 'authorFilter'));
    }

    public function getCommits()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github+json',
            'User-Agent' => config('app.name'),
        ])->get('https://api.github.com/repos/Agusggwp/posyandu-app/commits', [
            'per_page' => 50,
        ]);

        return [
            'status' => $response->status(),
            'data' => $response->successful() ? $response->json() : [],
        ];
    }
}
