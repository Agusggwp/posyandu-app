@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-8">
        <div>
            <h2 class="text-2xl sm:text-4xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">Pemeriksaan Ibu Hamil</h2>
            <p class="text-slate-600 mt-1 sm:mt-2 text-sm sm:text-base">Riwayat pemeriksaan kesehatan ibu hamil</p>
        </div>
        <a href="{{ route('pemeriksaan-ibu-hamil.create') }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            + Tambah Pemeriksaan
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden hidden md:block">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-violet-500 to-purple-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Kunjungan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Ibu Hamil</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tekanan Darah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Berat Badan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Denyut Jantung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Petugas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pemeriksaans as $index => $pemeriksaan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaans->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($pemeriksaan->tanggal_kunjungan)->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pemeriksaan->ibuHamil->nama ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->tekanan_darah ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->berat_badan ? $pemeriksaan->berat_badan . ' kg' : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->denyut_jantung ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->petugas ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('pemeriksaan-ibu-hamil.show', $pemeriksaan->id) }}" class="inline-flex items-center px-3 py-1.5 bg-violet-100 hover:bg-violet-200 text-violet-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                    Detail
                                </a>
                                @can('edit_pemeriksaan')
                                <a href="{{ route('pemeriksaan-ibu-hamil.edit', $pemeriksaan->id) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                    Edit
                                </a>
                                @endcan
                                @can('delete_data')
                                <form action="{{ route('pemeriksaan-ibu-hamil.destroy', $pemeriksaan->id) }}" method="POST" class="inline"
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
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data pemeriksaan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50">
            {{ $pemeriksaans->links() }}
        </div>
    </div>

    <div class="md:hidden space-y-3">
        @forelse($pemeriksaans as $pemeriksaan)
            <div class="bg-white rounded-xl shadow p-4 border border-slate-100">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-slate-900">{{ $pemeriksaan->ibuHamil->nama ?? '-' }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ optional($pemeriksaan->tanggal_kunjungan)->format('d/m/Y') ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                    <div><span class="text-slate-500">TD:</span> <span class="font-medium">{{ $pemeriksaan->tekanan_darah ?? '-' }}</span></div>
                    <div><span class="text-slate-500">BB:</span> <span class="font-medium">{{ $pemeriksaan->berat_badan ? $pemeriksaan->berat_badan . ' kg' : '-' }}</span></div>
                    <div><span class="text-slate-500">Denyut:</span> <span class="font-medium">{{ $pemeriksaan->denyut_jantung ?? '-' }}</span></div>
                    <div><span class="text-slate-500">Petugas:</span> <span class="font-medium">{{ $pemeriksaan->petugas ?? '-' }}</span></div>
                </div>

                <div class="mt-4 flex flex-col gap-2">
                    <a href="{{ route('pemeriksaan-ibu-hamil.show', $pemeriksaan->id) }}" class="w-full text-center inline-flex justify-center items-center px-3 py-2 bg-violet-100 hover:bg-violet-200 text-violet-700 rounded-lg text-sm font-semibold transition-all duration-200">Detail</a>
                    @can('edit_pemeriksaan')
                    <a href="{{ route('pemeriksaan-ibu-hamil.edit', $pemeriksaan->id) }}" class="w-full text-center inline-flex justify-center items-center px-3 py-2 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-lg text-sm font-semibold transition-all duration-200">Edit</a>
                    @endcan
                    @can('delete_data')
                    <form action="{{ route('pemeriksaan-ibu-hamil.destroy', $pemeriksaan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center items-center px-3 py-2 bg-rose-100 hover:bg-rose-200 text-rose-700 rounded-lg text-sm font-semibold transition-all duration-200">Hapus</button>
                    </form>
                    @endcan
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-6 text-center text-slate-500">Tidak ada data pemeriksaan</div>
        @endforelse

        <div class="px-2 py-2">
            {{ $pemeriksaans->links() }}
        </div>
    </div>
</div>
@endsection
