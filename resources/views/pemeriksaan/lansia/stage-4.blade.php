@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Lansia - Tahap 4</h2>
        <p class="text-gray-600 mt-1">Skrining Penyakit & Rujukan Final</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-lansia.index') }}" class="hover:text-purple-600">Pemeriksaan Lansia</a>
            <span class="mx-2">/</span>
            <span>Tahap 4 - Skrining Penyakit</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700">Tahap 4 dari 4 (Final)</span>
                <span class="text-sm font-semibold text-purple-600">100%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-purple-600 h-2 rounded-full" style="width: 100%"></div>
            </div>
        </div>

        <form action="{{ route('pemeriksaan-lansia.stage-store', 4) }}" method="POST">
            @csrf
            
            <input type="hidden" name="stage" value="4">
            @if($pemeriksaan)
                <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="dewasa_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Lansia <span class="text-red-500">*</span></label>
                        <select name="dewasa_identitas_id" id="dewasa_identitas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('dewasa_identitas_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Lansia --</option>
                            @foreach($lansias as $lansia)
                                <option value="{{ $lansia->id }}" {{ old('dewasa_identitas_id', $data['dewasa_identitas_id'] ?? '') == $lansia->id ? 'selected' : '' }}>
                                    {{ $lansia->nama }} - {{ $lansia->nik }}
                                </option>
                            @endforeach
                        </select>
                        @error('dewasa_identitas_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="waktu_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Waktu Kunjungan <span class="text-red-500">*</span></label>
                        <input type="date" name="waktu_kunjungan" id="waktu_kunjungan" value="{{ old('waktu_kunjungan', $data['waktu_kunjungan'] ?? now()->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('waktu_kunjungan') border-red-500 @enderror" required>
                        @error('waktu_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Skrining TBC -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-lungs text-purple-600"></i>
                    Skrining Tuberkulosis (TBC)
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="batuk_tbc" id="batuk_tbc" value="1" 
                               {{ old('batuk_tbc', $pemeriksaan->batuk_tbc ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                        <label for="batuk_tbc" class="ml-3 text-sm font-medium text-gray-700">
                            Batuk > 3 minggu
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="demam" id="demam" value="1" 
                               {{ old('demam', $pemeriksaan->demam ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                        <label for="demam" class="ml-3 text-sm font-medium text-gray-700">
                            Demam > 2 minggu
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="bb_turun" id="bb_turun" value="1" 
                               {{ old('bb_turun', $pemeriksaan->bb_turun ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                        <label for="bb_turun" class="ml-3 text-sm font-medium text-gray-700">
                            Penurunan Berat Badan
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="kontak_tbc" id="kontak_tbc" value="1" 
                               {{ old('kontak_tbc', $pemeriksaan->kontak_tbc ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                        <label for="kontak_tbc" class="ml-3 text-sm font-medium text-gray-700">
                            Kontak dengan Penderita TBC
                        </label>
                    </div>
                </div>
            </div>

            <!-- Gejala Pernapasan -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-wind text-purple-600"></i>
                    Gejala Pernapasan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="napas_berat" id="napas_berat" value="1" 
                               {{ old('napas_berat', $pemeriksaan->napas_berat ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                        <label for="napas_berat" class="ml-3 text-sm font-medium text-gray-700">
                            Napas Berat/Sesak
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="dahak" id="dahak" value="1" 
                               {{ old('dahak', $pemeriksaan->dahak ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                        <label for="dahak" class="ml-3 text-sm font-medium text-gray-700">
                            Dahak
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="batuk" id="batuk" value="1" 
                               {{ old('batuk', $pemeriksaan->batuk ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                        <label for="batuk" class="ml-3 text-sm font-medium text-gray-700">
                            Batuk Biasa
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="aktivitas_terganggu" id="aktivitas_terganggu" value="1" 
                               {{ old('aktivitas_terganggu', $pemeriksaan->aktivitas_terganggu ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                        <label for="aktivitas_terganggu" class="ml-3 text-sm font-medium text-gray-700">
                            Aktivitas Terganggu
                        </label>
                    </div>
                </div>
            </div>

            <!-- Skor PUMA & Merokok -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-line text-purple-600"></i>
                    Skor Risiko Kesehatan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="skor_puma" class="block text-sm font-medium text-gray-700 mb-2">Skor PUMA</label>
                        <input type="number" name="skor_puma" id="skor_puma" 
                               value="{{ old('skor_puma', $pemeriksaan->skor_puma ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('skor_puma') border-red-500 @enderror"
                               placeholder="0-10" min="0" max="10">
                        @error('skor_puma')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="skor_merokok" class="block text-sm font-medium text-gray-700 mb-2">Skor Merokok</label>
                        <input type="number" name="skor_merokok" id="skor_merokok" 
                               value="{{ old('skor_merokok', $pemeriksaan->skor_merokok ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('skor_merokok') border-red-500 @enderror"
                               placeholder="0-10" min="0" max="10">
                        @error('skor_merokok')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pemeriksaan Sebelumnya -->
            <div class="mb-8">
                <label for="pemeriksaan_sebelumnya" class="block text-sm font-medium text-gray-700 mb-2">Riwayat Pemeriksaan Sebelumnya</label>
                <textarea name="pemeriksaan_sebelumnya" id="pemeriksaan_sebelumnya" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('pemeriksaan_sebelumnya') border-red-500 @enderror"
                          placeholder="Catatan hasil pemeriksaan sebelumnya...">{{ old('pemeriksaan_sebelumnya', $pemeriksaan->pemeriksaan_sebelumnya ?? '') }}</textarea>
                @error('pemeriksaan_sebelumnya')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Edukasi -->
            <div class="mb-8">
                <label for="edukasi" class="block text-sm font-medium text-gray-700 mb-2">Edukasi</label>
                <textarea name="edukasi" id="edukasi" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('edukasi') border-red-500 @enderror"
                          placeholder="Edukasi kesehatan yang diberikan...">{{ old('edukasi', $pemeriksaan->edukasi ?? '') }}</textarea>
                @error('edukasi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rujukan -->
            <div class="mb-8">
                <label for="rujukan" class="block text-sm font-medium text-gray-700 mb-2">Rujukan</label>
                <textarea name="rujukan" id="rujukan" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('rujukan') border-red-500 @enderror"
                          placeholder="Rujukan/tindakan lanjutan jika diperlukan...">{{ old('rujukan', $pemeriksaan->rujukan ?? '') }}</textarea>
                @error('rujukan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-xl transition">
                    <i class="fas fa-check mr-2"></i>
                    Selesaikan Pemeriksaan
                </button>
                @if($pemeriksaan)
                    <a href="{{ route('pemeriksaan-lansia.stage', ['stage' => 3, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-3 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                @else
                    <a href="{{ route('pemeriksaan-lansia.index') }}" class="px-6 py-3 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
