@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Edit Data Ibu Hamil</h2>
        <p class="text-sm text-gray-600 mt-2">Perbarui data pada tabel ibu_hamil_identitas.</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('ibu-hamil.update', $ibuHamil->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kepala_keluarga_id" class="block text-sm font-medium text-gray-700 mb-2">Keluarga <span class="text-red-500">*</span></label>
                    <select name="kepala_keluarga_id" id="kepala_keluarga_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('kepala_keluarga_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Keluarga --</option>
                        @foreach($keluargas as $keluarga)
                            <option value="{{ $keluarga->id }}" {{ old('kepala_keluarga_id', $ibuHamil->kepala_keluarga_id) == $keluarga->id ? 'selected' : '' }}>
                                {{ $keluarga->no_kk }} - {{ $keluarga->nama_kepala_keluarga }}
                            </option>
                        @endforeach
                    </select>
                    @error('kepala_keluarga_id')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nama_ibu" class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu', $ibuHamil->nama_ibu) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nama_ibu') border-red-500 @enderror" required>
                    @error('nama_ibu')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $ibuHamil->nik) }}" maxlength="16" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nik') border-red-500 @enderror">
                    @error('nik')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', optional($ibuHamil->tanggal_lahir)->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_lahir') border-red-500 @enderror" required>
                    @error('tanggal_lahir')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="umur" class="block text-sm font-medium text-gray-700 mb-2">Umur</label>
                    <input type="number" name="umur" id="umur" value="{{ old('umur', $ibuHamil->umur) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('umur') border-red-500 @enderror">
                    @error('umur')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nama_suami" class="block text-sm font-medium text-gray-700 mb-2">Nama Suami</label>
                    <input type="text" name="nama_suami" id="nama_suami" value="{{ old('nama_suami', $ibuHamil->nama_suami) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nama_suami') border-red-500 @enderror">
                    @error('nama_suami')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $ibuHamil->no_hp) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('no_hp') border-red-500 @enderror">
                    @error('no_hp')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="l_ibu_hamil" class="block text-sm font-medium text-gray-700 mb-2">L Ibu Hamil</label>
                    <input type="text" name="l_ibu_hamil" id="l_ibu_hamil" value="{{ old('l_ibu_hamil', $ibuHamil->l_ibu_hamil) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('l_ibu_hamil') border-red-500 @enderror">
                    @error('l_ibu_hamil')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="kehamilan_ke" class="block text-sm font-medium text-gray-700 mb-2">Kehamilan Ke</label>
                    <input type="number" name="kehamilan_ke" id="kehamilan_ke" value="{{ old('kehamilan_ke', $ibuHamil->kehamilan_ke) }}" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('kehamilan_ke') border-red-500 @enderror">
                    @error('kehamilan_ke')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="jarak_anak_sebelumnya" class="block text-sm font-medium text-gray-700 mb-2">Jarak Anak Sebelumnya</label>
                    <input type="text" name="jarak_anak_sebelumnya" id="jarak_anak_sebelumnya" value="{{ old('jarak_anak_sebelumnya', $ibuHamil->jarak_anak_sebelumnya) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('jarak_anak_sebelumnya') border-red-500 @enderror">
                    @error('jarak_anak_sebelumnya')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">Update</button>
                <a href="{{ route('ibu-hamil.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

