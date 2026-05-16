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

            <!-- Summary dari Semua Tahap -->
            @if($data)
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-purple-900 mb-4">Ringkasan Data Pemeriksaan</h3>
                
                <!-- Tahap 1 -->
                <div class="mb-3 pb-3 border-b border-purple-300">
                    <p class="text-xs font-semibold text-purple-700 mb-2">TAHAP 1: Pengukuran Antropometri</p>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-sm">
                        <div>
                            <p class="text-purple-700 font-medium">Berat Badan</p>
                            <p class="text-purple-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Tinggi Badan</p>
                            <p class="text-purple-900">{{ $data['tinggi_badan'] ?? '-' }} cm</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Lingkar Perut</p>
                            <p class="text-purple-900">{{ $data['lingkar_perut'] ?? '-' }} cm</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">IMT</p>
                            <p class="text-purple-900">{{ $data['imt'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Status BB</p>
                            <p class="text-purple-900">{{ $data['status_berat_badan'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tahap 2 -->
                <div class="mb-3 pb-3 border-b border-purple-300">
                    <p class="text-xs font-semibold text-purple-700 mb-2">TAHAP 2: Tekanan Darah, Gula Darah, Kolesterol</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-purple-700 font-medium">Tekanan Darah</p>
                            <p class="text-purple-900">{{ $data['sistole'] ?? '-' }}/{{ $data['diastole'] ?? '-' }} mmHg</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Status TD</p>
                            <p class="text-purple-900">{{ $data['tekanan_darah_status'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Gula Darah</p>
                            <p class="text-purple-900">{{ $data['gula_darah'] ?? '-' }} mg/dL</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Kolesterol</p>
                            <p class="text-purple-900">{{ $data['kolesterol'] ?? '-' }} mg/dL</p>
                        </div>
                    </div>
                </div>

                <!-- Tahap 3 -->
                <div>
                    <p class="text-xs font-semibold text-purple-700 mb-2">TAHAP 3: Pemeriksaan Mata, Telinga, Kesehatan Gigi</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-purple-700 font-medium">Mata Kanan</p>
                            <p class="text-purple-900">{{ $data['mata_kanan'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Mata Kiri</p>
                            <p class="text-purple-900">{{ $data['mata_kiri'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Telinga Kanan</p>
                            <p class="text-purple-900">{{ $data['telinga_kanan'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Telinga Kiri</p>
                            <p class="text-purple-900">{{ $data['telinga_kiri'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif



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
                <select name="rujukan" id="rujukan"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('rujukan') border-red-500 @enderror">
                    <option value="">-- Pilih Rujukan --</option>
                    <option value="Tidak Ada" {{ old('rujukan', $pemeriksaan->rujukan ?? '') === 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                    <option value="Puskesmas" {{ old('rujukan', $pemeriksaan->rujukan ?? '') === 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                    <option value="Rumah Sakit" {{ old('rujukan', $pemeriksaan->rujukan ?? '') === 'Rumah Sakit' ? 'selected' : '' }}>Rumah Sakit</option>
                    <option value="Klinik Khusus" {{ old('rujukan', $pemeriksaan->rujukan ?? '') === 'Klinik Khusus' ? 'selected' : '' }}>Klinik Khusus</option>
                    <option value="Dokter Spesialis" {{ old('rujukan', $pemeriksaan->rujukan ?? '') === 'Dokter Spesialis' ? 'selected' : '' }}>Dokter Spesialis</option>
                    <option value="Rumah Jompo" {{ old('rujukan', $pemeriksaan->rujukan ?? '') === 'Rumah Jompo' ? 'selected' : '' }}>Rumah Jompo</option>
                    <option value="Layanan Sosial" {{ old('rujukan', $pemeriksaan->rujukan ?? '') === 'Layanan Sosial' ? 'selected' : '' }}>Layanan Sosial</option>
                </select>
                @error('rujukan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-lansia.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-lansia.stage', ['stage' => 3, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 3
                </a>
                @endif
                <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition w-full sm:w-auto">
                    Selesaikan Pemeriksaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
