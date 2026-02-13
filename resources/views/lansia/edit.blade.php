@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Edit Data Lansia</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('lansia.index') }}" class="hover:text-blue-600">Data Lansia</a>
            <span class="mx-2">/</span>
            <span>Edit</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('lansia.update', $lansia->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="keluarga_id" class="block text-sm font-medium text-gray-700 mb-2">Keluarga <span class="text-red-500">*</span></label>
                    <select name="keluarga_id" id="keluarga_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('keluarga_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Keluarga --</option>
                        @foreach($keluargas as $keluarga)
                            <option value="{{ $keluarga->id }}" {{ old('keluarga_id', $lansia->keluarga_id) == $keluarga->id ? 'selected' : '' }}>
                                {{ $keluarga->no_kk }} - {{ $keluarga->nama_kepala_keluarga }}
                            </option>
                        @endforeach
                    </select>
                    @error('keluarga_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $lansia->nik) }}" maxlength="16"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('nik') border-red-500 @enderror" required>
                    @error('nik')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $lansia->nama) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('nama') border-red-500 @enderror" required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('jenis_kelamin') border-red-500 @enderror" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin', $lansia->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $lansia->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $lansia->tanggal_lahir->format('Y-m-d')) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('tanggal_lahir') border-red-500 @enderror" required>
                @error('tanggal_lahir')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="riwayat_penyakit" class="block text-sm font-medium text-gray-700 mb-2">Riwayat Penyakit</label>
                <textarea name="riwayat_penyakit" id="riwayat_penyakit" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('riwayat_penyakit') border-red-500 @enderror">{{ old('riwayat_penyakit', $lansia->riwayat_penyakit) }}</textarea>
                @error('riwayat_penyakit')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Update
                </button>
                <a href="{{ route('lansia.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
