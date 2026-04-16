@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-8">
        <div>
            <h2 class="text-2xl sm:text-4xl font-bold bg-gradient-to-r from-rose-700 to-pink-800 bg-clip-text text-transparent">Pemeriksaan Nifas</h2>
            <p class="text-slate-600 mt-1 sm:mt-2 text-sm sm:text-base">Riwayat pemeriksaan nifas</p>
        </div>
        <a href="{{ route('pemeriksaan-nifas.create') }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-rose-700 to-pink-800 hover:from-rose-800 hover:to-pink-900 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">+ Tambah Pemeriksaan</a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden hidden md:block">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-rose-700 to-pink-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Ibu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Kunjungan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Berat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">TD</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pemeriksaans as $index => $item)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $pemeriksaans->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-sm font-semibold">{{ $item->nifas->nama_ibu ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->waktu_kunjungan ? \Illuminate\Support\Carbon::parse($item->waktu_kunjungan)->format('d/m/Y') : '-' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->berat_badan ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->sistole && $item->diastole ? $item->sistole . '/' . $item->diastole : '-' }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('pemeriksaan-nifas.show', $item->id) }}" class="inline-flex px-2 py-1 rounded bg-emerald-100 text-emerald-800 hover:bg-emerald-200">Detail</a>
                            <a href="{{ route('pemeriksaan-nifas.edit', $item->id) }}" class="inline-flex px-2 py-1 rounded bg-amber-100 text-amber-800 hover:bg-amber-200">Edit</a>
                            <form action="{{ route('pemeriksaan-nifas.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex px-2 py-1 rounded bg-rose-100 text-rose-800 hover:bg-rose-200">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data pemeriksaan nifas</td></tr>
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
                        <h3 class="font-semibold text-slate-900">{{ $item->nifas->nama_ibu ?? '-' }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $item->waktu_kunjungan ? \Illuminate\Support\Carbon::parse($item->waktu_kunjungan)->format('d/m/Y') : '-' }}</p>
                    </div>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                    <div><span class="text-slate-500">BB:</span> <span class="font-medium">{{ $item->berat_badan ?? '-' }}</span></div>
                    <div><span class="text-slate-500">TD:</span> <span class="font-medium">{{ $item->sistole && $item->diastole ? $item->sistole . '/' . $item->diastole : '-' }}</span></div>
                </div>

                <div class="mt-4 flex flex-col gap-2">
                    <a href="{{ route('pemeriksaan-nifas.show', $item->id) }}" class="w-full text-center inline-flex justify-center items-center px-3 py-2 bg-emerald-100 text-emerald-800 hover:bg-emerald-200 rounded-lg text-sm font-semibold">Detail</a>
                    <a href="{{ route('pemeriksaan-nifas.edit', $item->id) }}" class="w-full text-center inline-flex justify-center items-center px-3 py-2 bg-amber-100 text-amber-800 hover:bg-amber-200 rounded-lg text-sm font-semibold">Edit</a>
                    <form action="{{ route('pemeriksaan-nifas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center items-center px-3 py-2 bg-rose-100 text-rose-800 hover:bg-rose-200 rounded-lg text-sm font-semibold">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow p-6 text-center text-slate-500">Tidak ada data pemeriksaan nifas</div>
        @endforelse
        <div class="px-2 py-2">{{ $pemeriksaans->links() }}</div>
    </div>
</div>
@endsection
