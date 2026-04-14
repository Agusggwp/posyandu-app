@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-sky-700 to-cyan-900 bg-clip-text text-transparent">Pemeriksaan Remaja</h2>
            <p class="text-slate-600 mt-2">Riwayat pemeriksaan remaja</p>
        </div>
        <a href="{{ route('pemeriksaan-remaja.create') }}" class="bg-gradient-to-r from-sky-700 to-cyan-900 hover:from-sky-800 hover:to-cyan-950 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">+ Tambah Pemeriksaan</a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-sky-700 to-cyan-900 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Nama Remaja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Kunjungan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Berat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Tinggi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pemeriksaans as $index => $item)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $pemeriksaans->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-sm font-semibold">{{ $item->remaja->nama_anak ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->waktu_kunjungan ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->berat_badan ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $item->tinggi_badan ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('pemeriksaan-remaja.show', $item->id) }}" class="inline-flex px-2 py-1 rounded bg-emerald-100 text-emerald-800 hover:bg-emerald-200">Detail</a>
                            <a href="{{ route('pemeriksaan-remaja.edit', $item->id) }}" class="inline-flex px-2 py-1 rounded bg-amber-100 text-amber-800 hover:bg-amber-200">Edit</a>
                            <form action="{{ route('pemeriksaan-remaja.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex px-2 py-1 rounded bg-rose-100 text-rose-800 hover:bg-rose-200">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data pemeriksaan remaja</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50">{{ $pemeriksaans->links() }}</div>
    </div>
</div>
@endsection
