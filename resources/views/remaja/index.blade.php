@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-sky-700 to-cyan-900 bg-clip-text text-transparent">Data Remaja</h2>
            <p class="text-slate-600 mt-2">Manajemen data remaja (identitas)</p>
        </div>
        <a href="{{ route('remaja.create') }}" class="bg-gradient-to-r from-sky-700 to-cyan-900 hover:from-sky-800 hover:to-cyan-950 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            + Tambah Remaja
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-sky-700 to-cyan-900 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Anak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Keluarga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($remajas as $index => $remaja)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $remajas->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $remaja->nama_anak }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $remaja->nik ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $remaja->jenis_kelamin ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $remaja->keluarga->nama_kepala_keluarga ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('remaja.show', $remaja->id) }}" class="inline-flex px-2 py-1 rounded bg-emerald-100 text-emerald-800 hover:bg-emerald-200">Detail</a>
                                <a href="{{ route('remaja.edit', $remaja->id) }}" class="inline-flex px-2 py-1 rounded bg-amber-100 text-amber-800 hover:bg-amber-200">Edit</a>
                                <form action="{{ route('remaja.destroy', $remaja->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex px-2 py-1 rounded bg-rose-100 text-rose-800 hover:bg-rose-200">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data remaja</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50">{{ $remajas->links() }}</div>
    </div>
</div>
@endsection
