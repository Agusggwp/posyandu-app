@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-6 sm:mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">GitHub Commit Log</h2>
        <p class="text-gray-600 mt-2">Menampilkan riwayat commit dari repository lokal untuk referensi pengembangan.</p>
    </div>

    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 font-medium">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Admin Dashboard
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">Commit Terbaru</h3>
                <p class="text-sm text-slate-500">Menampilkan hingga 50 commit terbaru dari repository Git.</p>
            </div>
            <a href="{{ route('admin.github-commits') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                <i class="fa-solid fa-sync"></i>
                Refresh
            </a>
        </div>

        @if(isset($status) && $status !== 200)
            <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 text-rose-700">
                Tidak dapat mengambil log Git. Pastikan API GitHub dapat diakses dan konfigurasi repository sudah benar.
            </div>
        @elseif(empty($commits))
            <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4 text-slate-700">
                Commit tidak ditemukan.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-700">Hash</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-700">Author</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-700">Tanggal</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-700">Pesan Commit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($commits as $commit)
                            <tr>
                                <td class="px-4 py-3 font-mono text-slate-700">{{ $commit['hash'] }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $commit['author'] }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $commit['date'] }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $commit['message'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
