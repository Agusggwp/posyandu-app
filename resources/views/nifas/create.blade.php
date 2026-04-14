@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-rose-800">Tambah Data Nifas</h2>
        <p class="text-sm text-gray-600 mt-2">Sesuai struktur tabel nifas_identitas.</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg border border-rose-200 p-6">
        <form action="{{ route('nifas.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kepala_keluarga_id" class="block text-sm font-medium text-gray-700 mb-2">Keluarga <span class="text-red-500">*</span></label>
                    <select name="kepala_keluarga_id" id="kepala_keluarga_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('kepala_keluarga_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Keluarga --</option>
                        @foreach($keluargas as $keluarga)
                            <option value="{{ $keluarga->id }}" {{ old('kepala_keluarga_id') == $keluarga->id ? 'selected' : '' }}>{{ $keluarga->no_kk }} - {{ $keluarga->nama_kepala_keluarga }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="nama_ibu" class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('nama_ibu') border-red-500 @enderror" required>
                </div>
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('nik') border-red-500 @enderror">
                </div>
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('tanggal_lahir') border-red-500 @enderror">
                </div>
                <div>
                    <label for="umur" class="block text-sm font-medium text-gray-700 mb-2">Umur</label>
                    <input type="number" name="umur" id="umur" value="{{ old('umur') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('umur') border-red-500 @enderror">
                </div>
                <div>
                    <label for="nama_suami" class="block text-sm font-medium text-gray-700 mb-2">Nama Suami</label>
                    <input type="text" name="nama_suami" id="nama_suami" value="{{ old('nama_suami') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('nama_suami') border-red-500 @enderror">
                </div>
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('no_hp') border-red-500 @enderror">
                </div>
                <div>
                    <label for="dusun" class="block text-sm font-medium text-gray-700 mb-2">Dusun</label>
                    <input type="text" name="dusun" id="dusun" value="{{ old('dusun') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('dusun') border-red-500 @enderror">
                </div>
                <div>
                    <label for="desa" class="block text-sm font-medium text-gray-700 mb-2">Desa</label>
                    <input type="text" name="desa" id="desa" value="{{ old('desa') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('desa') border-red-500 @enderror">
                </div>
                <div>
                    <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                    <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('kecamatan') border-red-500 @enderror">
                </div>
                <div>
                    <label for="tanggal_bersalin" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bersalin</label>
                    <input type="date" name="tanggal_bersalin" id="tanggal_bersalin" value="{{ old('tanggal_bersalin') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('tanggal_bersalin') border-red-500 @enderror">
                </div>
                <div>
                    <label for="tempat_bersalin" class="block text-sm font-medium text-gray-700 mb-2">Tempat Bersalin</label>
                    <input type="text" name="tempat_bersalin" id="tempat_bersalin" value="{{ old('tempat_bersalin') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('tempat_bersalin') border-red-500 @enderror">
                </div>
                <div>
                    <label for="anak_ke" class="block text-sm font-medium text-gray-700 mb-2">Anak Ke</label>
                    <input type="number" name="anak_ke" id="anak_ke" value="{{ old('anak_ke') }}" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('anak_ke') border-red-500 @enderror">
                </div>
                <div>
                    <label for="tinggi_badan_ibu" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan Ibu</label>
                    <input type="number" step="0.01" name="tinggi_badan_ibu" id="tinggi_badan_ibu" value="{{ old('tinggi_badan_ibu') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('tinggi_badan_ibu') border-red-500 @enderror">
                </div>
            </div>
            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-rose-700 hover:bg-rose-800 text-white font-semibold py-2 px-6 rounded-xl">Simpan</button>
                <a href="{{ route('nifas.index') }}" class="bg-rose-700 hover:bg-rose-800 text-white font-semibold py-2 px-6 rounded-xl">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
