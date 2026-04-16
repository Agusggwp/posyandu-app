@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-1 sm:px-0">
    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Edit Data Balita</h2>
        <p class="text-sm text-gray-600 mt-2">Perbarui data pada tabel balita_identitas.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-8 border border-indigo-100">
        <form action="{{ route('balita.update', $balita->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kepala_keluarga_id" class="block text-sm font-medium text-gray-700 mb-2">Keluarga <span class="text-red-500">*</span></label>
                    <input type="text" class="js-keluarga-search w-full px-4 py-2 mb-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" data-target="#kepala_keluarga_id" placeholder="Cari no KK / nama kepala keluarga...">
                    <select name="kepala_keluarga_id" id="kepala_keluarga_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('kepala_keluarga_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Keluarga --</option>
                        @foreach($keluargas as $keluarga)
                            <option value="{{ $keluarga->id }}" {{ old('kepala_keluarga_id', $balita->kepala_keluarga_id) == $keluarga->id ? 'selected' : '' }}>
                                {{ $keluarga->no_kk }} - {{ $keluarga->nama_kepala_keluarga }}
                            </option>
                        @endforeach
                    </select>
                    @error('kepala_keluarga_id')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nama_bayi" class="block text-sm font-medium text-gray-700 mb-2">Nama Bayi <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_bayi" id="nama_bayi" value="{{ old('nama_bayi', $balita->nama_bayi) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nama_bayi') border-red-500 @enderror" required>
                    @error('nama_bayi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $balita->nik) }}" maxlength="16" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nik') border-red-500 @enderror">
                    @error('nik')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('jenis_kelamin') border-red-500 @enderror" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin', $balita->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $balita->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', optional($balita->tanggal_lahir)->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('tanggal_lahir') border-red-500 @enderror" required>
                    @error('tanggal_lahir')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="berat_badan_lahir" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan Lahir</label>
                    <input type="number" step="0.01" name="berat_badan_lahir" id="berat_badan_lahir" value="{{ old('berat_badan_lahir', $balita->berat_badan_lahir) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('berat_badan_lahir') border-red-500 @enderror">
                    @error('berat_badan_lahir')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="panjang_badan_lahir" class="block text-sm font-medium text-gray-700 mb-2">Panjang Badan Lahir</label>
                    <input type="number" step="0.01" name="panjang_badan_lahir" id="panjang_badan_lahir" value="{{ old('panjang_badan_lahir', $balita->panjang_badan_lahir) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('panjang_badan_lahir') border-red-500 @enderror">
                </div>
                <div>
                    <label for="nama_ortu" class="block text-sm font-medium text-gray-700 mb-2">Nama Orang Tua</label>
                    <input type="text" name="nama_ortu" id="nama_ortu" value="{{ old('nama_ortu', $balita->nama_ortu) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('nama_ortu') border-red-500 @enderror">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $balita->no_hp) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('no_hp') border-red-500 @enderror">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-8">
                <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Update
                </button>
                <a href="{{ route('balita.index') }}" class="w-full sm:w-auto text-center bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
