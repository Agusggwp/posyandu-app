<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $status = $response['status'];

        if ($status === 200) {
            $commits = collect($response['data'])->map(function ($item) {
                return [
                    'hash' => $item['sha'] ?? '',
                    'author' => $item['commit']['author']['name'] ?? $item['author']['login'] ?? 'Unknown',
                    'date' => isset($item['commit']['author']['date']) ? substr($item['commit']['author']['date'], 0, 10) : '',
                    'message' => $item['commit']['message'] ?? '',
                ];
            })->toArray();
        }

        return view('admin.github-commits', compact('commits', 'status'));
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
