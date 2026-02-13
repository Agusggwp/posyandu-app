@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Edit Pemeriksaan Lansia</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-lansia.index') }}" class="hover:text-yellow-600">Pemeriksaan Lansia</a>
            <span class="mx-2">/</span>
            <span>Edit</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('pemeriksaan-lansia.update', $pemeriksaan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="lansia_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Lansia <span class="text-red-500">*</span></label>
                    <select name="lansia_id" id="lansia_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('lansia_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Lansia --</option>
                        @foreach($lansias as $lansia)
                            <option value="{{ $lansia->id }}" {{ old('lansia_id', $pemeriksaan->lansia_id) == $lansia->id ? 'selected' : '' }}>
                                {{ $lansia->nama }} - {{ $lansia->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('lansia_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_pemeriksaan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pemeriksaan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" 
                           value="{{ old('tanggal_pemeriksaan', $pemeriksaan->tanggal_pemeriksaan->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('tanggal_pemeriksaan') border-red-500 @enderror" required>
                    @error('tanggal_pemeriksaan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="tekanan_darah" class="block text-sm font-medium text-gray-700 mb-2">Tekanan Darah</label>
                    <input type="text" name="tekanan_darah" id="tekanan_darah" 
                           value="{{ old('tekanan_darah', $pemeriksaan->tekanan_darah) }}" placeholder="120/80"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('tekanan_darah') border-red-500 @enderror">
                    @error('tekanan_darah')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan (kg)</label>
                    <input type="number" step="0.01" name="berat_badan" id="berat_badan" 
                           value="{{ old('berat_badan', $pemeriksaan->berat_badan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror">
                    @error('berat_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan (cm)</label>
                    <input type="number" step="0.01" name="tinggi_badan" id="tinggi_badan" 
                           value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('tinggi_badan') border-red-500 @enderror">
                    @error('tinggi_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="gula_darah" class="block text-sm font-medium text-gray-700 mb-2">Gula Darah (mg/dL)</label>
                    <input type="number" name="gula_darah" id="gula_darah" 
                           value="{{ old('gula_darah', $pemeriksaan->gula_darah) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('gula_darah') border-red-500 @enderror">
                    @error('gula_darah')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kolesterol" class="block text-sm font-medium text-gray-700 mb-2">Kolesterol (mg/dL)</label>
                    <input type="number" name="kolesterol" id="kolesterol" 
                           value="{{ old('kolesterol', $pemeriksaan->kolesterol) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('kolesterol') border-red-500 @enderror">
                    @error('kolesterol')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="keluhan" class="block text-sm font-medium text-gray-700 mb-2">Keluhan</label>
                <textarea name="keluhan" id="keluhan" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('keluhan') border-red-500 @enderror">{{ old('keluhan', $pemeriksaan->keluhan) }}</textarea>
                @error('keluhan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea name="catatan" id="catatan" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('catatan') border-red-500 @enderror">{{ old('catatan', $pemeriksaan->catatan) }}</textarea>
                @error('catatan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Update
                </button>
                <a href="{{ route('pemeriksaan-lansia.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
