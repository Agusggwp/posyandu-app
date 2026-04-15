@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-1 sm:px-0">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
        <div>
            <h2 class="text-2xl sm:text-4xl font-bold bg-gradient-to-r from-rose-700 to-pink-800 bg-clip-text text-transparent">Data Nifas</h2>
            <p class="text-slate-600 mt-2">Manajemen data nifas (identitas)</p>
        </div>
        <a href="{{ route('nifas.create') }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-rose-700 to-pink-800 hover:from-rose-800 hover:to-pink-900 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            + Tambah Nifas
        </a>
    </div>

    <!-- Search Box -->
    <div class="mb-6">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" id="searchInput" placeholder="Cari berdasarkan nama, NIK, atau keluarga..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent">
            <div id="searchResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-white border border-gray-300 rounded-lg shadow-lg z-10 max-h-96 overflow-y-auto"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-rose-700 to-pink-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Ibu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Bersalin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Keluarga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($nifases as $index => $nifas)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $nifases->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $nifas->nama_ibu }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $nifas->nik ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ optional($nifas->tanggal_bersalin)->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $nifas->keluarga->nama_kepala_keluarga ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('nifas.show', $nifas->id) }}" class="inline-flex px-2 py-1 rounded bg-emerald-100 text-emerald-800 hover:bg-emerald-200">Detail</a>
                                <a href="{{ route('nifas.edit', $nifas->id) }}" class="inline-flex px-2 py-1 rounded bg-amber-100 text-amber-800 hover:bg-amber-200">Edit</a>
                                <form action="{{ route('nifas.destroy', $nifas->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex px-2 py-1 rounded bg-rose-100 text-rose-800 hover:bg-rose-200">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data nifas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="md:hidden p-4 space-y-4 bg-gray-50">
            @forelse($nifases as $index => $nifas)
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <div class="flex justify-between items-start gap-3">
                        <div>
                            <p class="text-xs text-gray-500">No. {{ $nifases->firstItem() + $index }}</p>
                            <h3 class="text-base font-semibold text-gray-900 break-words">{{ $nifas->nama_ibu }}</h3>
                            <p class="text-sm text-gray-600 mt-1 break-words">NIK: {{ $nifas->nik ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1 text-sm text-gray-700">
                        <p><span class="font-medium">Tanggal Bersalin:</span> {{ optional($nifas->tanggal_bersalin)->format('d/m/Y') ?? '-' }}</p>
                        <p class="break-words"><span class="font-medium">Keluarga:</span> {{ $nifas->keluarga->nama_kepala_keluarga ?? '-' }}</p>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <a href="{{ route('nifas.show', $nifas->id) }}" class="inline-flex items-center justify-center px-3 py-2 rounded bg-emerald-100 text-emerald-800 hover:bg-emerald-200 text-xs font-semibold">Detail</a>
                        <a href="{{ route('nifas.edit', $nifas->id) }}" class="inline-flex items-center justify-center px-3 py-2 rounded bg-amber-100 text-amber-800 hover:bg-amber-200 text-xs font-semibold">Edit</a>
                        <form action="{{ route('nifas.destroy', $nifas->id) }}" method="POST" class="col-span-2" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 rounded bg-rose-100 text-rose-800 hover:bg-rose-200 text-xs font-semibold">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-xl p-6 text-center text-gray-500">Tidak ada data nifas</div>
            @endforelse
        </div>
        <div class="px-6 py-4 bg-gray-50">{{ $nifases->links() }}</div>
    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    if (!searchInput || !searchResults) {
        return;
    }

    searchInput.addEventListener('input', async function () {
        const query = this.value.trim();

        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }

        try {
            const response = await fetch(`{{ route('api.search.nifas') }}?q=${encodeURIComponent(query)}`);
            const results = await response.json();

            if (results.length === 0) {
                searchResults.innerHTML = '<div class="px-4 py-3 text-gray-500 text-center">Tidak ada hasil pencarian</div>';
                searchResults.classList.remove('hidden');
                return;
            }

            searchResults.innerHTML = results.map(item => `
                <a href="{{ url('nifas') }}/${item.id}" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200 last:border-b-0 cursor-pointer">
                    <div class="font-semibold text-gray-900">${item.nama}</div>
                    <div class="text-sm text-gray-500">NIK: ${item.nik || '-'} | ${item.keluarga}</div>
                </a>
            `).join('');

            searchResults.classList.remove('hidden');
        } catch (error) {
            console.error('Search error:', error);
        }
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#searchInput') && !e.target.closest('#searchResults')) {
            searchResults.classList.add('hidden');
        }
    });
});
</script>
