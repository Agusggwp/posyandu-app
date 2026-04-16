@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Input Pemeriksaan Ibu Hamil</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="hover:text-purple-600">Pemeriksaan Ibu Hamil</a>
            <span class="mx-2">/</span>
            <span>Tambah</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-ibu-hamil.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="ibu_hamil_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Ibu Hamil <span class="text-red-500">*</span></label>
                    <select name="ibu_hamil_identitas_id" id="ibu_hamil_identitas_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('ibu_hamil_identitas_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Ibu Hamil --</option>
                        @foreach($ibuHamils as $ibuHamil)
                            <option value="{{ $ibuHamil->id }}" {{ old('ibu_hamil_identitas_id') == $ibuHamil->id ? 'selected' : '' }}>
                                {{ $ibuHamil->nama }} - {{ $ibuHamil->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('ibu_hamil_identitas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" 
                           value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                    @error('tanggal_kunjungan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan (cm)</label>
                    <input type="number" step="0.01" name="tinggi_badan" id="tinggi_badan"
                           value="{{ old('tinggi_badan') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tinggi_badan') border-red-500 @enderror">
                    @error('tinggi_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tekanan_darah" class="block text-sm font-medium text-gray-700 mb-2">Tekanan Darah</label>
                    <input type="text" name="tekanan_darah" id="tekanan_darah" 
                           value="{{ old('tekanan_darah') }}" placeholder="120/80"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tekanan_darah') border-red-500 @enderror">
                    @error('tekanan_darah')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan (kg)</label>
                    <input type="number" step="0.01" name="berat_badan" id="berat_badan" 
                           value="{{ old('berat_badan') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror">
                    @error('berat_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="lingkar_lengan" class="block text-sm font-medium text-gray-700 mb-2">Lingkar Lengan (cm)</label>
                    <input type="number" step="0.01" name="lingkar_lengan" id="lingkar_lengan" 
                           value="{{ old('lingkar_lengan') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('lingkar_lengan') border-red-500 @enderror">
                    @error('lingkar_lengan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="denyut_jantung" class="block text-sm font-medium text-gray-700 mb-2">Denyut Jantung</label>
                    <input type="text" name="denyut_jantung" id="denyut_jantung" 
                           value="{{ old('denyut_jantung') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('denyut_jantung') border-red-500 @enderror">
                    @error('denyut_jantung')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="waktu_ke_posyandu" class="block text-sm font-medium text-gray-700 mb-2">Waktu ke Posyandu</label>
                    <input type="time" name="waktu_ke_posyandu" id="waktu_ke_posyandu" 
                           value="{{ old('waktu_ke_posyandu') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('waktu_ke_posyandu') border-red-500 @enderror">
                    @error('waktu_ke_posyandu')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="kondisi_ibu" class="block text-sm font-medium text-gray-700 mb-2">Kondisi Ibu</label>
                    <input type="text" name="kondisi_ibu" id="kondisi_ibu" 
                           value="{{ old('kondisi_ibu') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('kondisi_ibu') border-red-500 @enderror">
                    @error('kondisi_ibu')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="petugas" class="block text-sm font-medium text-gray-700 mb-2">Petugas</label>
                    <input type="text" name="petugas" id="petugas" 
                           value="{{ old('petugas') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('petugas') border-red-500 @enderror">
                    @error('petugas')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="keluhan" class="block text-sm font-medium text-gray-700 mb-2">Keluhan</label>
                <textarea name="keluhan" id="keluhan" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('keluhan') border-red-500 @enderror">{{ old('keluhan') }}</textarea>
                @error('keluhan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea name="catatan" id="catatan" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
                <button type="submit" class="bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Simpan
                </button>
                <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
