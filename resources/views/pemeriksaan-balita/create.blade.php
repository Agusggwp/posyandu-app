@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Input Pemeriksaan Balita</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-indigo-600 transition-colors">Pemeriksaan Balita</a>
            <span class="mx-2">/</span>
            <span>Tambah</span>
        </nav>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-8 border border-indigo-100">
        <form action="{{ route('pemeriksaan-balita.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="balita_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Balita <span class="text-red-500">*</span></label>
                    <select name="balita_id" id="balita_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('balita_id') border-red-500 @enderror">
                        <option value="">-- Pilih Balita --</option>
                        @foreach($balitas as $balita)
                            <option value="{{ $balita->id }}" {{ old('balita_id') == $balita->id ? 'selected' : '' }}>
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
                           value="{{ old('tanggal_pemeriksaan', date('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('tanggal_pemeriksaan') border-red-500 @enderror">
                    @error('tanggal_pemeriksaan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan (kg) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="berat_badan" id="berat_badan" 
                           value="{{ old('berat_badan') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror">
                    @error('berat_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan (cm) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="tinggi_badan" id="tinggi_badan" 
                           value="{{ old('tinggi_badan') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('tinggi_badan') border-red-500 @enderror">
                    @error('tinggi_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700 mb-2">Lingkar Kepala (cm)</label>
                    <input type="number" step="0.01" name="lingkar_kepala" id="lingkar_kepala" 
                           value="{{ old('lingkar_kepala') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('lingkar_kepala') border-red-500 @enderror">
                    @error('lingkar_kepala')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="imunisasi" class="block text-sm font-medium text-gray-700 mb-2">Imunisasi</label>
                    <input type="text" name="imunisasi" id="imunisasi" 
                           value="{{ old('imunisasi') }}" placeholder="Contoh: BCG, Polio 1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('imunisasi') border-red-500 @enderror">
                    @error('imunisasi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="vitamin" class="block text-sm font-medium text-gray-700 mb-2">Vitamin</label>
                    <input type="text" name="vitamin" id="vitamin" 
                           value="{{ old('vitamin') }}" placeholder="Contoh: Vitamin A"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('vitamin') border-red-500 @enderror">
                    @error('vitamin')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status_gizi" class="block text-sm font-medium text-gray-700 mb-2">Status Gizi <span class="text-red-500">*</span></label>
                    <select name="status_gizi" id="status_gizi" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('status_gizi') border-red-500 @enderror">
                        <option value="">-- Pilih Status --</option>
                        <option value="normal" {{ old('status_gizi') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="kurang" {{ old('status_gizi') == 'kurang' ? 'selected' : '' }}>Kurang</option>
                        <option value="stunting" {{ old('status_gizi') == 'stunting' ? 'selected' : '' }}>Stunting</option>
                    </select>
                    @error('status_gizi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea name="catatan" id="catatan" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-gradient-to-r from-indigo-500  to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Simpan
                </button>
                <a href="{{ route('pemeriksaan-balita.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
