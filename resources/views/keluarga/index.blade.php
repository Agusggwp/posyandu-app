@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Data Keluarga</h2>
            <p class="text-slate-600 mt-2">Manajemen data keluarga</p>
        </div>
        <a href="{{ route('keluarga.create') }}" class="bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            + Tambah Keluarga
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No. KK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Kepala Keluarga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">RT/RW</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($keluargas as $index => $keluarga)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $keluargas->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $keluarga->no_kk }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $keluarga->nama_kepala_keluarga }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $keluarga->alamat }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $keluarga->rt }}/{{ $keluarga->rw }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $keluarga->telepon ?? '-' }}</td>
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
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data keluarga</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50">
            {{ $keluargas->links() }}
        </div>
    </div>
</div>
@endsection
