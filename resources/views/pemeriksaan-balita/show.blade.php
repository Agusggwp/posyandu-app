@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Detail Pemeriksaan Balita</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-green-600">Pemeriksaan Balita</a>
            <span class="mx-2">/</span>
            <span>Detail</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Data Balita</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Balita</label>
                <p class="text-lg text-gray-900 font-semibold">{{ $pemeriksaan->balita->nama ?? '-' }}</p>
                <p class="text-sm text-gray-500">{{ $pemeriksaan->balita->nik ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pemeriksaan</label>
                <p class="text-lg text-gray-900">{{ $pemeriksaan->tanggal_pemeriksaan->format('d F Y') }}</p>
            </div>
        </div>

        <div class="border-b border-gray-200 pb-4 mb-6 mt-8">
            <h3 class="text-xl font-semibold text-gray-800">Data Pengukuran</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">Berat Badan</label>
                <p class="text-3xl text-green-600 font-bold">{{ $pemeriksaan->berat_badan ?? '-' }}</p>
                <p class="text-sm text-gray-500">kg</p>
            </div>

            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">Tinggi Badan</label>
                <p class="text-3xl text-blue-600 font-bold">{{ $pemeriksaan->tinggi_badan ?? '-' }}</p>
                <p class="text-sm text-gray-500">cm</p>
            </div>

            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">Lingkar Kepala</label>
                <p class="text-3xl text-purple-600 font-bold">{{ $pemeriksaan->lingkar_kepala ?? '-' }}</p>
                <p class="text-sm text-gray-500">cm</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Imunisasi</label>
                <p class="text-lg text-gray-900">{{ $pemeriksaan->imunisasi ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Vitamin</label>
                <p class="text-lg text-gray-900">{{ $pemeriksaan->vitamin ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-2">Status Gizi</label>
            @if($pemeriksaan->status_gizi)
                <span class="px-4 py-2 text-base font-semibold rounded-full
                    {{ $pemeriksaan->status_gizi == 'Normal' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $pemeriksaan->status_gizi == 'Gizi Kurang' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $pemeriksaan->status_gizi == 'Gizi Buruk' ? 'bg-red-100 text-red-800' : '' }}
                    {{ $pemeriksaan->status_gizi == 'Gizi Lebih' ? 'bg-orange-100 text-orange-800' : '' }}">
                    {{ $pemeriksaan->status_gizi }}
                </span>
            @else
                <p class="text-gray-500">-</p>
            @endif
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-1">Catatan</label>
            <p class="text-lg text-gray-900">{{ $pemeriksaan->catatan ?? '-' }}</p>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-1">Petugas</label>
            <p class="text-lg text-gray-900">{{ $pemeriksaan->petugas->name ?? '-' }}</p>
        </div>

        <div class="flex gap-4 mt-8">
            <a href="{{ route('pemeriksaan-balita.edit', $pemeriksaan->id) }}" class="bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Edit
            </a>
            <a href="{{ route('pemeriksaan-balita.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
