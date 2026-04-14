@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-rose-700 to-pink-800 bg-clip-text text-transparent">Data Nifas</h2>
            <p class="text-slate-600 mt-2">Manajemen data nifas (identitas)</p>
        </div>
        <a href="{{ route('nifas.create') }}" class="bg-gradient-to-r from-rose-700 to-pink-800 hover:from-rose-800 hover:to-pink-900 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            + Tambah Nifas
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
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
        <div class="px-6 py-4 bg-gray-50">{{ $nifases->links() }}</div>
    </div>
</div>
@endsection
