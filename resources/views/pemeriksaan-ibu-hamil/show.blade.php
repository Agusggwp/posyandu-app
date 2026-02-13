@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Detail Pemeriksaan Ibu Hamil</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="hover:text-purple-600">Pemeriksaan Ibu Hamil</a>
            <span class="mx-2">/</span>
            <span>Detail</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Data Ibu Hamil</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Ibu Hamil</label>
                <p class="text-lg text-gray-900 font-semibold">{{ $pemeriksaan->ibuHamil->nama ?? '-' }}</p>
                <p class="text-sm text-gray-500">{{ $pemeriksaan->ibuHamil->nik ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pemeriksaan</label>
                <p class="text-lg text-gray-900">{{ $pemeriksaan->tanggal_pemeriksaan->format('d F Y') }}</p>
            </div>
        </div>

        <div class="border-b border-gray-200 pb-4 mb-6 mt-8">
            <h3 class="text-xl font-semibold text-gray-800">Data Pemeriksaan</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">Usia Kehamilan</label>
                <p class="text-3xl text-purple-600 font-bold">{{ $pemeriksaan->usia_kehamilan ?? '-' }}</p>
                <p class="text-sm text-gray-500">minggu</p>
            </div>

            <div class="text-center p-4 bg-pink-50 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">Tekanan Darah</label>
                <p class="text-3xl text-pink-600 font-bold">{{ $pemeriksaan->tekanan_darah ?? '-' }}</p>
                <p class="text-sm text-gray-500">mmHg</p>
            </div>

            <div class="text-center p-4 bg-indigo-50 rounded-lg">
                <label class="block text-sm font-medium text-gray-500 mb-1">Berat Badan</label>
                <p class="text-3xl text-indigo-600 font-bold">{{ $pemeriksaan->berat_badan ?? '-' }}</p>
                <p class="text-sm text-gray-500">kg</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Lingkar Lengan Atas</label>
                <p class="text-lg text-gray-900">{{ $pemeriksaan->lingkar_lengan_atas ? $pemeriksaan->lingkar_lengan_atas . ' cm' : '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tinggi Fundus</label>
                <p class="text-lg text-gray-900">{{ $pemeriksaan->tinggi_fundus ? $pemeriksaan->tinggi_fundus . ' cm' : '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Denyut Jantung Janin</label>
                <p class="text-lg text-gray-900">{{ $pemeriksaan->denyut_jantung_janin ? $pemeriksaan->denyut_jantung_janin . ' bpm' : '-' }}</p>
            </div>
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
            <a href="{{ route('pemeriksaan-ibu-hamil.edit', $pemeriksaan->id) }}" class="bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Edit
            </a>
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
