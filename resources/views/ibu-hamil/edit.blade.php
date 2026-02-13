@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Edit Data Ibu Hamil</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('ibu-hamil.index') }}" class="hover:text-blue-600">Data Ibu Hamil</a>
            <span class="mx-2">/</span>
            <span>Edit</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('ibu-hamil.update', $ibuHamil->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="keluarga_id" class="block text-sm font-medium text-gray-700 mb-2">Keluarga <span class="text-red-500">*</span></label>
                    <select name="keluarga_id" id="keluarga_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('keluarga_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Keluarga --</option>
                        @foreach($keluargas as $keluarga)
                            <option value="{{ $keluarga->id }}" {{ old('keluarga_id', $ibuHamil->keluarga_id) == $keluarga->id ? 'selected' : '' }}>
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
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $ibuHamil->nik) }}" maxlength="16"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nik') border-red-500 @enderror" required>
                    @error('nik')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $ibuHamil->nama) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nama') border-red-500 @enderror" required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $ibuHamil->tanggal_lahir->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_lahir') border-red-500 @enderror" required>
                    @error('tanggal_lahir')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="nama_suami" class="block text-sm font-medium text-gray-700 mb-2">Nama Suami <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_suami" id="nama_suami" value="{{ old('nama_suami', $ibuHamil->nama_suami) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nama_suami') border-red-500 @enderror" required>
                    @error('nama_suami')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="hamil_ke" class="block text-sm font-medium text-gray-700 mb-2">Kehamilan Ke <span class="text-red-500">*</span></label>
                    <input type="number" name="hamil_ke" id="hamil_ke" value="{{ old('hamil_ke', $ibuHamil->hamil_ke) }}" min="1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('hamil_ke') border-red-500 @enderror" required>
                    @error('hamil_ke')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="hpht" class="block text-sm font-medium text-gray-700 mb-2">HPHT (Hari Pertama Haid Terakhir)</label>
                    <input type="date" name="hpht" id="hpht" value="{{ old('hpht', $ibuHamil->hpht ? $ibuHamil->hpht->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('hpht') border-red-500 @enderror">
                    @error('hpht')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="hpl" class="block text-sm font-medium text-gray-700 mb-2">HPL (Hari Perkiraan Lahir)</label>
                    <input type="date" name="hpl" id="hpl" value="{{ old('hpl', $ibuHamil->hpl ? $ibuHamil->hpl->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('hpl') border-red-500 @enderror">
                    @error('hpl')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Update
                </button>
                <a href="{{ route('ibu-hamil.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
