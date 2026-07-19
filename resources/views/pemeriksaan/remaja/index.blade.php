@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-8">
        <div>
            <h2 class="text-2xl sm:text-4xl font-bold bg-gradient-to-r from-sky-700 to-cyan-900 bg-clip-text text-transparent">Pemeriksaan Remaja</h2>
            <p class="text-slate-600 mt-1 sm:mt-2 text-sm sm:text-base">Riwayat pemeriksaan remaja</p>
        </div>
        <a href="{{ route('pemeriksaan-remaja.create') }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-sky-700 to-cyan-900 hover:from-sky-800 hover:to-cyan-950 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">+ Tambah Pemeriksaan</a>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('pemeriksaan-remaja.index') }}" class="mb-6">
        <div class="flex gap-2 flex-col sm:flex-row">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Cari nama remaja..." value="{{ request('search') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-700 focus:border-transparent">
            </div>
            <button type="submit" class="bg-gradient-to-r from-sky-700 to-cyan-900 hover:from-sky-800 hover:to-cyan-950 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">Cari</button>
            @if(request('search'))
            <a href="{{ route('pemeriksaan-remaja.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 text-center">Hapus Filter</a>
            @endif
        </div>
    </form>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden hidden md:block">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-sky-700 to-cyan-900 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">NO</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">UMUR</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">TANGGAL KUNJUNGAN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">NAMA REMAJA</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">BERAT BADAN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">TINGGI BADAN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">STATUS TB/U</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">STATUS BB/U</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pemeriksaans as $index => $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaans->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->remaja && $item->remaja->tanggal_lahir ? (int)\Carbon\Carbon::parse($item->remaja->tanggal_lahir)->diffInYears($item->tanggal_kunjungan) . ' Tahun' : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->tanggal_kunjungan ? \Illuminate\Support\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->remaja->nama_anak ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->berat_badan ? $item->berat_badan . ' kg' : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->tinggi_badan ? $item->tinggi_badan . ' cm' : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">-</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->imt_status ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('pemeriksaan-remaja.show', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                    Detail
                                </a>
                                @can('edit_pemeriksaan')
                                <a href="{{ route('pemeriksaan-remaja.edit', $item->id) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                    Edit
                                </a>
                                @endcan
                                @can('delete_data')
                                <form action="{{ route('pemeriksaan-remaja.destroy', $item->id) }}" method="POST" style="display: contents" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                    <tr><td colspan="9" class="px-6 py-4 text-center text-gray-500">Tidak ada data pemeriksaan remaja</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50">{{ $pemeriksaans->links() }}</div>
    </div>

    <div class="md:hidden space-y-3">
        @forelse($pemeriksaans as $item)
            <div class="bg-white rounded-xl shadow p-4 border border-slate-100">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-slate-900">{{ $item->remaja->nama_anak ?? '-' }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $item->tanggal_kunjungan ? \Illuminate\Support\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') : '-' }}</p>
                    </div>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                    <div><span class="text-slate-500">BB:</span> <span class="font-medium">{{ $item->berat_badan ? $item->berat_badan . ' kg' : '-' }}</span></div>
                    <div><span class="text-slate-500">TB:</span> <span class="font-medium">{{ $item->tinggi_badan ? $item->tinggi_badan . ' cm' : '-' }}</span></div>
                    <div><span class="text-slate-500">Status TB/U:</span> <span class="font-medium">-</span></div>
                    <div><span class="text-slate-500">Status BB/U:</span> <span class="font-medium">{{ $item->imt_status ?? '-' }}</span></div>
                </div>

                <div class="mt-4 flex flex-col gap-2">
                    <a href="{{ route('pemeriksaan-remaja.show', $item->id) }}" class="w-full text-center inline-flex justify-center items-center px-3 py-2 bg-emerald-100 text-emerald-800 hover:bg-emerald-200 rounded-lg text-sm font-semibold">Detail</a>
                    @can('edit_pemeriksaan')
                    <a href="{{ route('pemeriksaan-remaja.edit', $item->id) }}" class="w-full text-center inline-flex justify-center items-center px-3 py-2 bg-amber-100 text-amber-800 hover:bg-amber-200 rounded-lg text-sm font-semibold">Edit</a>
                    @endcan
                    @can('delete_data')
                    <form action="{{ route('pemeriksaan-remaja.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center items-center px-3 py-2 bg-rose-100 text-rose-800 hover:bg-rose-200 rounded-lg text-sm font-semibold">Hapus</button>
                    </form>
                    @endcan
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-6 text-center text-slate-500">Tidak ada data pemeriksaan remaja</div>
        @endforelse
        <div class="px-2 py-2">{{ $pemeriksaans->links() }}</div>
    </div>
</div>
@endsection
