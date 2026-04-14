@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-cyan-900">Tambah Data Remaja</h2>
        <p class="text-sm text-gray-600 mt-2">Sesuai struktur tabel remaja_identitas.</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg border border-cyan-200 p-6">
        <form action="{{ route('remaja.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keluarga <span class="text-red-500">*</span></label>
                    <select name="kepala_keluarga_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
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
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dusun</label>
                    <input type="text" name="dusun" value="{{ old('dusun') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Desa</label>
                    <input type="text" name="desa" value="{{ old('desa') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('alamat') }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Riwayat Keluarga</label>
                    <textarea name="riwayat_keluarga" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('riwayat_keluarga') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Riwayat Diri</label>
                    <textarea name="riwayat_diri" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('riwayat_diri') }}</textarea>
                </div>
            </div>
            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-2 px-6 rounded-xl">Simpan</button>
                <a href="{{ route('remaja.index') }}" class="bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-2 px-6 rounded-xl">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
