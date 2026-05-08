@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Lansia - Tahap 2</h2>
        <p class="text-gray-600 mt-1">Pemeriksaan Kesehatan Vital</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-lansia.index') }}" class="hover:text-cyan-600">Pemeriksaan Lansia</a>
            <span class="mx-2">/</span>
            <span>Tahap 2 - Pemeriksaan Kesehatan</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700">Tahap 2 dari 4</span>
                <span class="text-sm font-semibold text-cyan-600">50%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-cyan-600 h-2 rounded-full" style="width: 50%"></div>
            </div>
        </div>

        <form action="{{ route('pemeriksaan-lansia.stage-store', 2) }}" method="POST">
            @csrf
            
            <input type="hidden" name="stage" value="2">
            <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">

            <!-- Tekanan Darah -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-heartbeat text-cyan-600"></i>
                    Tekanan Darah
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sistole" class="block text-sm font-medium text-gray-700 mb-2">Sistole <span class="text-cyan-600">(mmHg)</span></label>
                        <input type="number" name="sistole" id="sistole" 
                               value="{{ old('sistole', $pemeriksaan->sistole ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('sistole') border-red-500 @enderror"
                               placeholder="Contoh: 120">
                        @error('sistole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="diastole" class="block text-sm font-medium text-gray-700 mb-2">Diastole <span class="text-cyan-600">(mmHg)</span></label>
                        <input type="number" name="diastole" id="diastole" 
                               value="{{ old('diastole', $pemeriksaan->diastole ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('diastole') border-red-500 @enderror"
                               placeholder="Contoh: 80">
                        @error('diastole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="tekanan_darah_status" class="block text-sm font-medium text-gray-700 mb-2">Status Tekanan Darah</label>
                    <select name="tekanan_darah_status" id="tekanan_darah_status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('tekanan_darah_status') border-red-500 @enderror">
                        <option value="">-- Pilih Status --</option>
                        <option value="Normal" {{ old('tekanan_darah_status', $pemeriksaan->tekanan_darah_status ?? '') == 'Normal' ? 'selected' : '' }}>Normal (&lt;120/&lt;80)</option>
                        <option value="Elevated" {{ old('tekanan_darah_status', $pemeriksaan->tekanan_darah_status ?? '') == 'Elevated' ? 'selected' : '' }}>Elevated (120-129/&lt;80)</option>
                        <option value="Stage 1 Hypertension" {{ old('tekanan_darah_status', $pemeriksaan->tekanan_darah_status ?? '') == 'Stage 1 Hypertension' ? 'selected' : '' }}>Stage 1 Hypertension (130-139/80-89)</option>
                        <option value="Stage 2 Hypertension" {{ old('tekanan_darah_status', $pemeriksaan->tekanan_darah_status ?? '') == 'Stage 2 Hypertension' ? 'selected' : '' }}>Stage 2 Hypertension (≥140/≥90)</option>
                        <option value="Hypotension" {{ old('tekanan_darah_status', $pemeriksaan->tekanan_darah_status ?? '') == 'Hypotension' ? 'selected' : '' }}>Hypotension (&lt;90/&lt;60)</option>
                    </select>
                    @error('tekanan_darah_status')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Gula Darah -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-droplet text-cyan-600"></i>
                    Gula Darah
                </h3>
                
                <div>
                    <label for="gula_darah" class="block text-sm font-medium text-gray-700 mb-2">Gula Darah <span class="text-cyan-600">(mg/dL)</span></label>
                    <input type="number" name="gula_darah" id="gula_darah" 
                           value="{{ old('gula_darah', $pemeriksaan->gula_darah ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('gula_darah') border-red-500 @enderror"
                           placeholder="Contoh: 120">
                    @error('gula_darah')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Normal: 70-100 mg/dL (puasa) | Diabetes: ≥126 mg/dL (puasa)</p>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-3 rounded-xl transition">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Lanjutkan ke Tahap 3
                </button>
                <a href="{{ route('pemeriksaan-lansia.stage', ['stage' => 1, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-3 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
