@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Edit Data Keluarga</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('keluarga.index') }}" class="hover:text-blue-600">Data Keluarga</a>
            <span class="mx-2">/</span>
            <span>Edit</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('keluarga.update', $keluarga->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="no_kk" class="block text-sm font-medium text-gray-700 mb-2">No. KK <span class="text-red-500">*</span></label>
                    <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk', $keluarga->no_kk) }}" maxlength="16"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('no_kk') border-red-500 @enderror" required>
                    @error('no_kk')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_kepala_keluarga" class="block text-sm font-medium text-gray-700 mb-2">Nama Kepala Keluarga <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kepala_keluarga" id="nama_kepala_keluarga" value="{{ old('nama_kepala_keluarga', $keluarga->nama_kepala_keluarga) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_kepala_keluarga') border-red-500 @enderror" required>
                    @error('nama_kepala_keluarga')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                <textarea name="alamat" id="alamat" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('alamat') border-red-500 @enderror" required>{{ old('alamat', $keluarga->alamat) }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                <div>
                    <label for="rt" class="block text-sm font-medium text-gray-700 mb-2">RT <span class="text-red-500">*</span></label>
                    <input type="text" name="rt" id="rt" value="{{ old('rt', $keluarga->rt) }}" maxlength="3"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('rt') border-red-500 @enderror" required>
                    @error('rt')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rw" class="block text-sm font-medium text-gray-700 mb-2">RW <span class="text-red-500">*</span></label>
                    <input type="text" name="rw" id="rw" value="{{ old('rw', $keluarga->rw) }}" maxlength="3"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('rw') border-red-500 @enderror" required>
                    @error('rw')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-2">Kelurahan <span class="text-red-500">*</span></label>
                    <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', $keluarga->kelurahan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kelurahan') border-red-500 @enderror" required>
                    @error('kelurahan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">Kecamatan <span class="text-red-500">*</span></label>
                    <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $keluarga->kecamatan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kecamatan') border-red-500 @enderror" required>
                    @error('kecamatan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">Telepon</label>
                <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $keluarga->telepon) }}" maxlength="15"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telepon') border-red-500 @enderror">
                @error('telepon')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Update
                </button>
                <a href="{{ route('keluarga.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
