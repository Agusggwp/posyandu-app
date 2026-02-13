@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Input Pemeriksaan Ibu Hamil</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="hover:text-purple-600">Pemeriksaan Ibu Hamil</a>
            <span class="mx-2">/</span>
            <span>Tambah</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('pemeriksaan-ibu-hamil.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="ibu_hamil_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Ibu Hamil <span class="text-red-500">*</span></label>
                    <select name="ibu_hamil_id" id="ibu_hamil_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('ibu_hamil_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Ibu Hamil --</option>
                        @foreach($ibuHamils as $ibuHamil)
                            <option value="{{ $ibuHamil->id }}" {{ old('ibu_hamil_id') == $ibuHamil->id ? 'selected' : '' }}>
                                {{ $ibuHamil->nama }} - {{ $ibuHamil->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('ibu_hamil_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_pemeriksaan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pemeriksaan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" 
                           value="{{ old('tanggal_pemeriksaan', date('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_pemeriksaan') border-red-500 @enderror" required>
                    @error('tanggal_pemeriksaan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="usia_kehamilan" class="block text-sm font-medium text-gray-700 mb-2">Usia Kehamilan (minggu)</label>
                    <input type="number" name="usia_kehamilan" id="usia_kehamilan" min="0"
                           value="{{ old('usia_kehamilan') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('usia_kehamilan') border-red-500 @enderror">
                    @error('usia_kehamilan')
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
                    <label for="lingkar_lengan_atas" class="block text-sm font-medium text-gray-700 mb-2">Lingkar Lengan Atas (cm)</label>
                    <input type="text" name="lingkar_lengan_atas" id="lingkar_lengan_atas" 
                           value="{{ old('lingkar_lengan_atas') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('lingkar_lengan_atas') border-red-500 @enderror">
                    @error('lingkar_lengan_atas')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tinggi_fundus" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Fundus (cm)</label>
                    <input type="text" name="tinggi_fundus" id="tinggi_fundus" 
                           value="{{ old('tinggi_fundus') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tinggi_fundus') border-red-500 @enderror">
                    @error('tinggi_fundus')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="denyut_jantung_janin" class="block text-sm font-medium text-gray-700 mb-2">Denyut Jantung Janin (bpm)</label>
                    <input type="text" name="denyut_jantung_janin" id="denyut_jantung_janin" 
                           value="{{ old('denyut_jantung_janin') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('denyut_jantung_janin') border-red-500 @enderror">
                    @error('denyut_jantung_janin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea name="catatan" id="catatan" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Simpan
                </button>
                <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
