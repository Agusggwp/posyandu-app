@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Detail Data Lansia</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('lansia.index') }}" class="hover:text-blue-600">Data Lansia</a>
            <span class="mx-2">/</span>
            <span>Detail</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">NIK</label>
                <p class="text-lg text-gray-900">{{ $lansia->nik }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                <p class="text-lg text-gray-900 font-semibold">{{ $lansia->nama }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                <p class="text-lg">
                    @if($lansia->jenis_kelamin == 'L')
                        <span class="px-3 py-1 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full">Laki-laki</span>
                    @else
                        <span class="px-3 py-1 text-sm font-semibold text-pink-800 bg-pink-100 rounded-full">Perempuan</span>
                    @endif
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                <p class="text-lg text-gray-900">{{ $lansia->tanggal_lahir->format('d/m/Y') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Usia</label>
                <p class="text-lg text-gray-900 font-semibold">{{ $lansia->tanggal_lahir->age }} tahun</p>
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-1">Keluarga</label>
            <p class="text-lg text-gray-900">{{ $lansia->keluarga->nama_kepala_keluarga ?? '-' }}</p>
            <p class="text-sm text-gray-500">{{ $lansia->keluarga->no_kk ?? '-' }}</p>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-1">Riwayat Penyakit</label>
            <p class="text-lg text-gray-900">{{ $lansia->riwayat_penyakit ?? '-' }}</p>
        </div>

        <div class="flex gap-4 mt-8">
            <a href="{{ route('lansia.edit', $lansia->id) }}" class="bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Edit
            </a>
            <a href="{{ route('lansia.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Kembali
            </a>
        </div>
    </div>

    <!-- Riwayat Pemeriksaan -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Riwayat Pemeriksaan</h3>
        
        @if($lansia->pemeriksaans && $lansia->pemeriksaans->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-yellow-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tekanan Darah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Gula Darah</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Kolesterol</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Keluhan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($lansia->pemeriksaans->sortByDesc('tanggal_pemeriksaan') as $pemeriksaan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $pemeriksaan->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $pemeriksaan->tekanan_darah ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $pemeriksaan->gula_darah ? $pemeriksaan->gula_darah . ' mg/dL' : '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $pemeriksaan->kolesterol ? $pemeriksaan->kolesterol . ' mg/dL' : '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $pemeriksaan->keluhan ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $pemeriksaan->petugas->name ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 italic">Belum ada riwayat pemeriksaan</p>
        @endif
    </div>
</div>
@endsection
