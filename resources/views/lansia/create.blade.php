@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Tambah Data Lansia</h2>
        <p class="text-sm text-gray-600 mt-2">Sesuai struktur tabel dewasa_identitas.</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('lansia.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kepala_keluarga_id" class="block text-sm font-medium text-gray-700 mb-2">Keluarga <span class="text-red-500">*</span></label>
                    <select name="kepala_keluarga_id" id="kepala_keluarga_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('kepala_keluarga_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Keluarga --</option>
                        @foreach($keluargas as $keluarga)
                            <option value="{{ $keluarga->id }}" {{ old('kepala_keluarga_id') == $keluarga->id ? 'selected' : '' }}>
                                {{ $keluarga->no_kk }} - {{ $keluarga->nama_kepala_keluarga }}
                            </option>
                        @endforeach
                    </select>
                    @error('kepala_keluarga_id')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('nama') border-red-500 @enderror" required>
                    @error('nama')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('nik') border-red-500 @enderror">
                    @error('nik')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('tanggal_lahir') border-red-500 @enderror" required>
                    @error('tanggal_lahir')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="umur" class="block text-sm font-medium text-gray-700 mb-2">Umur</label>
                    <input type="number" name="umur" id="umur" value="{{ old('umur') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('umur') border-red-500 @enderror">
                </div>
                <div>
                    <label for="status_perkawinan" class="block text-sm font-medium text-gray-700 mb-2">Status Perkawinan</label>
                    <input type="text" name="status_perkawinan" id="status_perkawinan" value="{{ old('status_perkawinan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('status_perkawinan') border-red-500 @enderror">
                </div>
                <div>
                    <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-2">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('pekerjaan') border-red-500 @enderror">
                </div>
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('no_hp') border-red-500 @enderror">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="riwayat_keluarga" class="block text-sm font-medium text-gray-700 mb-2">Riwayat Keluarga</label>
                    <textarea name="riwayat_keluarga" id="riwayat_keluarga" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('riwayat_keluarga') border-red-500 @enderror">{{ old('riwayat_keluarga') }}</textarea>
                </div>
                <div>
                    <label for="riwayat_diri" class="block text-sm font-medium text-gray-700 mb-2">Riwayat Diri</label>
                    <textarea name="riwayat_diri" id="riwayat_diri" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('riwayat_diri') border-red-500 @enderror">{{ old('riwayat_diri') }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                <div>
                    <label for="merokok" class="block text-sm font-medium text-gray-700 mb-2">Merokok</label>
                    <select name="merokok" id="merokok" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('merokok') === 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('merokok') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="konsumsi_gula" class="block text-sm font-medium text-gray-700 mb-2">Konsumsi Gula</label>
                    <input type="text" name="konsumsi_gula" id="konsumsi_gula" value="{{ old('konsumsi_gula') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('konsumsi_gula') border-red-500 @enderror">
                </div>
                <div>
                    <label for="konsumsi_garam" class="block text-sm font-medium text-gray-700 mb-2">Konsumsi Garam</label>
                    <input type="text" name="konsumsi_garam" id="konsumsi_garam" value="{{ old('konsumsi_garam') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('konsumsi_garam') border-red-500 @enderror">
                </div>
                <div>
                    <label for="konsumsi_lemak" class="block text-sm font-medium text-gray-700 mb-2">Konsumsi Lemak</label>
                    <input type="text" name="konsumsi_lemak" id="konsumsi_lemak" value="{{ old('konsumsi_lemak') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('konsumsi_lemak') border-red-500 @enderror">
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Simpan
                </button>
                <a href="{{ route('lansia.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
