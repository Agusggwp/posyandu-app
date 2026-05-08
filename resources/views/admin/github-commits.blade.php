@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-6 sm:mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">GitHub Commit Log</h2>
        <p class="text-gray-600 mt-2">Menampilkan riwayat commit dari GitHub API untuk referensi pengembangan.</p>
    </div>

    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 font-medium">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Admin Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-slate-500">Total Commit</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-slate-500">Author Aktif</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['authors'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-slate-500">Commit Hari Ini</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['today'] ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
            <p class="text-xs uppercase tracking-wide text-slate-500">Update Terakhir</p>
            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $stats['last_update'] ?? '-' }}</p>
            <p class="text-xs text-slate-500 mt-1">WIB (Asia/Jakarta)</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6">
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">Commit Terbaru</h3>
                <p class="text-sm text-slate-500">Menampilkan hingga 50 commit terbaru, termasuk jam dan waktu relatif.</p>
            </div>
            <a href="{{ route('admin.github-commits') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                <i class="fa-solid fa-sync"></i>
                Refresh
            </a>
        </div>

        <form method="GET" action="{{ route('admin.github-commits') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-6">
            <div class="md:col-span-8">
                <label for="q" class="block text-xs font-semibold text-slate-600 mb-1">Cari Commit</label>
                <input type="text" id="q" name="q" value="{{ $search ?? '' }}" placeholder="Cari hash, author, atau pesan commit..."
                       class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-slate-400 focus:ring-0">
            </div>
            <div class="md:col-span-2">
                <label for="author" class="block text-xs font-semibold text-slate-600 mb-1">Filter Author</label>
                <select id="author" name="author" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-slate-400 focus:ring-0">
                    <option value="">Semua Author</option>
                    @foreach(($authors ?? []) as $author)
                        <option value="{{ $author }}" {{ ($authorFilter ?? '') === $author ? 'selected' : '' }}>{{ $author }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2 flex items-end gap-2">
                <button type="submit" class="w-full rounded-xl bg-slate-800 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-900">
                    Terapkan
                </button>
                <a href="{{ route('admin.github-commits') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>

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
                            <th class="px-4 py-3 text-left font-semibold text-slate-700">Jam</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-700">Pesan Commit</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($commits as $commit)
                            <tr>
                                <td class="px-4 py-3 font-mono text-slate-700">{{ $commit['short_hash'] ?? $commit['hash'] }}</td>
                                <td class="px-4 py-3 text-slate-700">
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                        {{ $commit['author'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ $commit['date'] }}</td>
                                <td class="px-4 py-3 text-slate-700">
                                    <div>{{ $commit['time'] ?? '-' }}</div>
                                    <div class="text-xs text-slate-500">{{ $commit['relative_time'] ?? '-' }}</div>
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ $commit['message_short'] ?? $commit['message'] }}</td>
                                <td class="px-4 py-3 text-slate-700">
                                    <div class="flex flex-wrap gap-2">
                                        <button type="button" class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50" onclick="copyHash('{{ $commit['hash'] }}')">
                                            <i class="fa-solid fa-copy"></i>
                                            Copy
                                        </button>
                                        @if(!empty($commit['url']))
                                            <a href="{{ $commit['url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                                <i class="fa-solid fa-up-right-from-square"></i>
                                                Buka
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function copyHash(hash) {
    if (!hash) return;
    navigator.clipboard.writeText(hash).then(function () {
        showToast('Hash commit berhasil disalin');
    }).catch(function () {
        showToast('Gagal menyalin hash commit', true);
    });
}

function showToast(message, isError) {
    let toast = document.getElementById('commit-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'commit-toast';
        toast.className = 'fixed bottom-4 right-4 z-50 rounded-xl px-4 py-3 text-sm font-semibold shadow-xl transition opacity-0 translate-y-2';
        document.body.appendChild(toast);
    }

    toast.textContent = message;
    toast.classList.remove('opacity-0', 'translate-y-2', 'bg-emerald-600', 'bg-rose-600', 'text-white');
    toast.classList.add('text-white', isError ? 'bg-rose-600' : 'bg-emerald-600');

    requestAnimationFrame(function () {
        toast.classList.add('opacity-100');
        toast.classList.remove('translate-y-2');
    });

    clearTimeout(window.__commitToastTimer);
    window.__commitToastTimer = setTimeout(function () {
        toast.classList.remove('opacity-100');
        toast.classList.add('opacity-0', 'translate-y-2');
    }, 1800);
}
</script>
@endpush
@endsection
