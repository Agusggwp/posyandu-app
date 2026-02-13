@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Edit Pemeriksaan Balita</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-green-600">Pemeriksaan Balita</a>
            <span class="mx-2">/</span>
            <span>Edit</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('pemeriksaan-balita.update', $pemeriksaan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="balita_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Balita <span class="text-red-500">*</span></label>
                    <select name="balita_id" id="balita_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('balita_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Balita --</option>
                        @foreach($balitas as $balita)
                            <option value="{{ $balita->id }}" {{ old('balita_id', $pemeriksaan->balita_id) == $balita->id ? 'selected' : '' }}>
                                {{ $balita->nama }} - {{ $balita->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('balita_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_pemeriksaan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pemeriksaan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" 
                           value="{{ old('tanggal_pemeriksaan', $pemeriksaan->tanggal_pemeriksaan->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('tanggal_pemeriksaan') border-red-500 @enderror" required>
                    @error('tanggal_pemeriksaan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan (kg)</label>
                    <input type="number" step="0.01" name="berat_badan" id="berat_badan" 
                           value="{{ old('berat_badan', $pemeriksaan->berat_badan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror">
                    @error('berat_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan (cm)</label>
                    <input type="number" step="0.01" name="tinggi_badan" id="tinggi_badan" 
                           value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('tinggi_badan') border-red-500 @enderror">
                    @error('tinggi_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700 mb-2">Lingkar Kepala (cm)</label>
                    <input type="number" step="0.01" name="lingkar_kepala" id="lingkar_kepala" 
                           value="{{ old('lingkar_kepala', $pemeriksaan->lingkar_kepala) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('lingkar_kepala') border-red-500 @enderror">
                    @error('lingkar_kepala')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="imunisasi" class="block text-sm font-medium text-gray-700 mb-2">Imunisasi</label>
                    <input type="text" name="imunisasi" id="imunisasi" 
                           value="{{ old('imunisasi', $pemeriksaan->imunisasi) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('imunisasi') border-red-500 @enderror">
                    @error('imunisasi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="vitamin" class="block text-sm font-medium text-gray-700 mb-2">Vitamin</label>
                    <input type="text" name="vitamin" id="vitamin" 
                           value="{{ old('vitamin', $pemeriksaan->vitamin) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('vitamin') border-red-500 @enderror">
                    @error('vitamin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="status_gizi" class="block text-sm font-medium text-gray-700 mb-2">Status Gizi</label>
                    <select name="status_gizi" id="status_gizi" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('status_gizi') border-red-500 @enderror">
                        <option value="">-- Pilih Status Gizi --</option>
                        <option value="Normal" {{ old('status_gizi', $pemeriksaan->status_gizi) == 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Gizi Kurang" {{ old('status_gizi', $pemeriksaan->status_gizi) == 'Gizi Kurang' ? 'selected' : '' }}>Gizi Kurang</option>
                        <option value="Gizi Buruk" {{ old('status_gizi', $pemeriksaan->status_gizi) == 'Gizi Buruk' ? 'selected' : '' }}>Gizi Buruk</option>
                        <option value="Gizi Lebih" {{ old('status_gizi', $pemeriksaan->status_gizi) == 'Gizi Lebih' ? 'selected' : '' }}>Gizi Lebih</option>
                    </select>
                    @error('status_gizi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea name="catatan" id="catatan" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('catatan') border-red-500 @enderror">{{ old('catatan', $pemeriksaan->catatan) }}</textarea>
                @error('catatan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Update
                </button>
                <a href="{{ route('pemeriksaan-balita.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
