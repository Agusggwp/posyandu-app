@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-1 sm:px-0">
    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-cyan-900">Tambah Data Remaja</h2>
        <p class="text-sm text-gray-600 mt-2">Sesuai struktur tabel remaja_identitas.</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg border border-cyan-200 p-4 sm:p-6">
        <form action="{{ route('remaja.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keluarga <span class="text-red-500">*</span></label>
                    <input type="text" class="js-keluarga-search w-full px-4 py-2 mb-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent" data-target="#kepala_keluarga_id" placeholder="Cari no KK / nama kepala keluarga...">
                    <select name="kepala_keluarga_id" id="kepala_keluarga_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        <option value="">-- Pilih Keluarga --</option>
                        @foreach($keluargas as $keluarga)
                        <option value="{{ $keluarga->id }}" {{ old('kepala_keluarga_id') == $keluarga->id ? 'selected' : '' }}>{{ $keluarga->no_kk }} - {{ $keluarga->nama_kepala_keluarga }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Anak <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_anak" value="{{ old('nama_anak') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua</label>
                    <input type="text" name="nama_ortu" value="{{ old('nama_ortu') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="riwayat_keluarga" class="block text-sm font-medium text-gray-700 mb-2">Riwayat Keluarga</label>
                    <select name="riwayat_keluarga" id="riwayat_keluarga" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('riwayat_keluarga') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Hipertensi" {{ old('riwayat_keluarga') == 'Hipertensi' ? 'selected' : '' }}>Hipertensi</option>
                        <option value="DM" {{ old('riwayat_keluarga') == 'DM' ? 'selected' : '' }}>DM (Diabetes Melitus)</option>
                        <option value="Stroke" {{ old('riwayat_keluarga') == 'Stroke' ? 'selected' : '' }}>Stroke</option>
                        <option value="Jantung" {{ old('riwayat_keluarga') == 'Jantung' ? 'selected' : '' }}>Jantung</option>
                        <option value="Asma" {{ old('riwayat_keluarga') == 'Asma' ? 'selected' : '' }}>Asma</option>
                        <option value="Kanker" {{ old('riwayat_keluarga') == 'Kanker' ? 'selected' : '' }}>Kanker</option>
                        <option value="Kolesterol Tinggi" {{ old('riwayat_keluarga') == 'Kolesterol Tinggi' ? 'selected' : '' }}>Kolesterol Tinggi</option>
                    </select>
                </div>
                <div>
                    <label for="riwayat_diri" class="block text-sm font-medium text-gray-700 mb-2">Riwayat Diri</label>
                    <select name="riwayat_diri" id="riwayat_diri" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('riwayat_diri') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Hipertensi" {{ old('riwayat_diri') == 'Hipertensi' ? 'selected' : '' }}>Hipertensi</option>
                        <option value="DM" {{ old('riwayat_diri') == 'DM' ? 'selected' : '' }}>DM (Diabetes Melitus)</option>
                        <option value="Stroke" {{ old('riwayat_diri') == 'Stroke' ? 'selected' : '' }}>Stroke</option>
                        <option value="Jantung" {{ old('riwayat_diri') == 'Jantung' ? 'selected' : '' }}>Jantung</option>
                        <option value="Asma" {{ old('riwayat_diri') == 'Asma' ? 'selected' : '' }}>Asma</option>
                        <option value="Kanker" {{ old('riwayat_diri') == 'Kanker' ? 'selected' : '' }}>Kanker</option>
                        <option value="Kolesterol Tinggi" {{ old('riwayat_diri') == 'Kolesterol Tinggi' ? 'selected' : '' }}>Kolesterol Tinggi</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-8">
                <button type="submit" class="w-full sm:w-auto bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-2 px-6 rounded-xl">Simpan</button>
                <a href="{{ route('remaja.index') }}" class="w-full sm:w-auto text-center bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-2 px-6 rounded-xl">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
