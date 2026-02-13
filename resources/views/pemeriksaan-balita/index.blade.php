@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">Pemeriksaan Balita</h2>
            <p class="text-slate-600 mt-2">Riwayat pemeriksaan kesehatan balita</p>
        </div>
        <a href="{{ route('pemeriksaan-balita.create') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            + Tambah Pemeriksaan
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Balita</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Berat Badan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tinggi Badan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Lingkar Kepala</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status Gizi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Petugas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pemeriksaans as $index => $pemeriksaan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaans->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pemeriksaan->balita->nama ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->berat_badan }} kg</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->tinggi_badan }} cm</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->lingkar_kepala ? $pemeriksaan->lingkar_kepala . ' cm' : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($pemeriksaan->status_gizi == 'normal')
                                <span class="px-3 py-1 text-xs font-semibold text-emerald-800 bg-emerald-100 rounded-full">Normal</span>
                            @elseif($pemeriksaan->status_gizi == 'kurang')
                                <span class="px-3 py-1 text-xs font-semibold text-amber-800 bg-amber-100 rounded-full">Kurang</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold text-rose-800 bg-rose-100 rounded-full">Stunting</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->petugas->name ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('pemeriksaan-balita.show', $pemeriksaan->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                    Detail
                                </a>
                                <a href="{{ route('pemeriksaan-balita.edit', $pemeriksaan->id) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('pemeriksaan-balita.destroy', $pemeriksaan->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-700 rounded-lg text-xs font-semibold transition-all duration-200">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">Tidak ada data pemeriksaan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50">
            {{ $pemeriksaans->links() }}
        </div>
    </div>
</div>
@endsection
