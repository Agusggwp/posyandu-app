@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-1 sm:px-0">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
        <div>
            <h2 class="text-2xl sm:text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Data Kepala Keluarga</h2>
            <p class="text-slate-600 mt-2">Master data tabel kepala_keluarga</p>
        </div>
        <a href="{{ route('keluarga.create') }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            + Tambah Data
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
            <input type="text" id="searchInput" placeholder="Cari berdasarkan nama, No KK, NIK, atau email..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <div id="searchResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-white border border-gray-300 rounded-lg shadow-lg z-10 max-h-96 overflow-y-auto"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No. KK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($keluargas as $index => $keluarga)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $keluargas->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $keluarga->no_kk }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $keluarga->nama_lengkap }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $keluarga->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $keluarga->no_nik ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ucfirst($keluarga->status) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('keluarga.show', $keluarga->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                    Detail
                                </a>
                                @can('manage_keluarga')
                                <a href="{{ route('keluarga.edit', $keluarga->id) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                    Edit
                                </a>
                                @endcan
                                @can('delete_data')
                                <form action="{{ route('keluarga.destroy', $keluarga->id) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        Hapus
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data kepala keluarga</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="md:hidden p-4 space-y-4 bg-gray-50">
            @forelse($keluargas as $index => $keluarga)
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <div class="flex justify-between items-start gap-3">
                        <div>
                            <p class="text-xs text-gray-500">No. {{ $keluargas->firstItem() + $index }}</p>
                            <h3 class="text-base font-semibold text-gray-900 break-words">{{ $keluarga->nama_lengkap }}</h3>
                            <p class="text-sm text-gray-600 mt-1 break-words">{{ $keluarga->email }}</p>
                        </div>
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">{{ ucfirst($keluarga->status) }}</span>
                    </div>

                    <div class="mt-3 space-y-1 text-sm text-gray-700">
                        <p><span class="font-medium">No. KK:</span> {{ $keluarga->no_kk }}</p>
                        <p><span class="font-medium">NIK:</span> {{ $keluarga->no_nik ?? '-' }}</p>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <a href="{{ route('keluarga.show', $keluarga->id) }}" class="inline-flex items-center justify-center px-3 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg text-xs font-semibold transition-all duration-200">
                            Detail
                        </a>
                        @can('manage_keluarga')
                        <a href="{{ route('keluarga.edit', $keluarga->id) }}" class="inline-flex items-center justify-center px-3 py-2 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-lg text-xs font-semibold transition-all duration-200">
                            Edit
                        </a>
                        @endcan
                        @can('delete_data')
                        <form action="{{ route('keluarga.destroy', $keluarga->id) }}" method="POST" class="col-span-2" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 bg-rose-100 hover:bg-rose-200 text-rose-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                Hapus
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-xl p-6 text-center text-gray-500">Tidak ada data kepala keluarga</div>
            @endforelse
        </div>

        <div class="px-6 py-4 bg-gray-50">
            {{ $keluargas->links() }}
        </div>
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
            const response = await fetch(`{{ route('api.search.keluarga') }}?q=${encodeURIComponent(query)}`);
            const results = await response.json();

            if (results.length === 0) {
                searchResults.innerHTML = '<div class="px-4 py-3 text-gray-500 text-center">Tidak ada hasil pencarian</div>';
                searchResults.classList.remove('hidden');
                return;
            }

            searchResults.innerHTML = results.map(item => `
                <a href="{{ url('keluarga') }}/${item.id}" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200 last:border-b-0 cursor-pointer">
                    <div class="font-semibold text-gray-900">${item.nama}</div>
                    <div class="text-sm text-gray-500">No KK: ${item.no_kk} | ${item.email} | Status: ${item.status}</div>
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
