@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-cyan-900">Pemeriksaan Remaja - Tahap 4</h2>
        <p class="text-gray-600 mt-1">Edukasi & Rujukan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-remaja.index') }}" class="hover:text-cyan-600">Pemeriksaan Remaja</a>
            <span class="mx-2">/</span>
            <span>Tahap 4</span>
        </nav>
    </div>

    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 4/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-cyan-600 h-2 rounded-full" style="width: 100%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-remaja.stage-store', 4) }}" method="POST">
            @csrf
            <input type="hidden" name="pemeriksaan_id" value="{{ old('pemeriksaan_id', $data['id'] ?? '') }}">

            @if($pemeriksaan)
                <input type="hidden" name="remaja_identitas_id" value="{{ $pemeriksaan->remaja_identitas_id }}">
                <input type="hidden" name="waktu_kunjungan" value="{{ $pemeriksaan->waktu_kunjungan }}">

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-green-900 font-medium">Melanjutkan pemeriksaan untuk {{ $pemeriksaan->remaja->nama_anak ?? '-' }}. Data remaja dan tanggal kunjungan sudah dikunci dari tahap sebelumnya.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="remaja_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Remaja <span class="text-red-500">*</span>
                        </label>
                        <select name="remaja_identitas_id" id="remaja_identitas_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('remaja_identitas_id') border-red-500 @enderror"
                                required>
                            <option value="">-- Pilih Remaja --</option>
                            @foreach($remajas as $remaja)
                                <option value="{{ $remaja->id }}" {{ old('remaja_identitas_id', $data['remaja_identitas_id'] ?? '') == $remaja->id ? 'selected' : '' }}>
                                    {{ $remaja->nama_anak }} - {{ $remaja->nik }}
                                </option>
                            @endforeach
                        </select>
                        @error('remaja_identitas_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="waktu_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="waktu_kunjungan" id="waktu_kunjungan"
                               value="{{ old('waktu_kunjungan', $data['waktu_kunjungan'] ?? date('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('waktu_kunjungan') border-red-500 @enderror"
                               required>
                        @error('waktu_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Semua Tahap -->
            @if($data)
            <div class="bg-cyan-50 border border-cyan-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-cyan-900 mb-4">Ringkasan Data Pemeriksaan</h3>
                
                <!-- Tahap 1 -->
                <div class="mb-3 pb-3 border-b border-cyan-300">
                    <p class="text-xs font-semibold text-cyan-700 mb-2">TAHAP 1: Penimbangan & Pengukuran</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-cyan-700 font-medium">Berat Badan</p>
                            <p class="text-cyan-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Tinggi Badan</p>
                            <p class="text-cyan-900">{{ $data['tinggi_badan'] ?? '-' }} cm</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Status IMT</p>
                            <p class="text-cyan-900">{{ $data['imt_status'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Lingkar Perut</p>
                            <p class="text-cyan-900">{{ $data['lingkar_perut'] ?? '-' }} cm</p>
                        </div>
                    </div>
                </div>

                <!-- Tahap 2 -->
                <div class="mb-3 pb-3 border-b border-cyan-300">
                    <p class="text-xs font-semibold text-cyan-700 mb-2">TAHAP 2: Pemeriksaan Tekanan Darah, Gula Darah, Hemoglobin</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-cyan-700 font-medium">Tekanan Darah</p>
                            <p class="text-cyan-900">{{ $data['sistole'] ?? '-' }}/{{ $data['diastole'] ?? '-' }} mmHg</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Status TD</p>
                            <p class="text-cyan-900">{{ $data['tekanan_darah_status'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Gula Darah</p>
                            <p class="text-cyan-900">{{ $data['gula_darah'] ?? '-' }} mg/dL</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Anemia</p>
                            <p class="text-cyan-900">{{ $data['anemia'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tahap 3 -->
                <div>
                    <p class="text-xs font-semibold text-cyan-700 mb-2">TAHAP 3: Skrining TBC & Pemeriksaan Kesehatan</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-cyan-700 font-medium">Batuk</p>
                            <p class="text-cyan-900">{{ $data['batuk'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Kesehatan Mata</p>
                            <p class="text-cyan-900">{{ $data['kesehatan_mata'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Kesehatan Gigi</p>
                            <p class="text-cyan-900">{{ $data['kesehatan_gigi'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Imunisasi</p>
                            <p class="text-cyan-900">{{ $data['imunisasi_status'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Edukasi & Rujukan</h3>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="edukasi" class="block text-sm font-medium text-gray-700 mb-2">Edukasi</label>
                        <textarea name="edukasi" id="edukasi" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('edukasi') border-red-500 @enderror">{{ old('edukasi', $data['edukasi'] ?? '') }}</textarea>
                        @error('edukasi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rujukan" class="block text-sm font-medium text-gray-700 mb-2">Rujukan</label>
                        <select name="rujukan" id="rujukan"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('rujukan') border-red-500 @enderror">
                            <option value="">-- Pilih Rujukan --</option>
                            <option value="Tidak Ada" {{ old('rujukan', $data['rujukan'] ?? '') === 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                            <option value="Puskesmas" {{ old('rujukan', $data['rujukan'] ?? '') === 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                            <option value="Rumah Sakit" {{ old('rujukan', $data['rujukan'] ?? '') === 'Rumah Sakit' ? 'selected' : '' }}>Rumah Sakit</option>
                            <option value="Klinik Khusus" {{ old('rujukan', $data['rujukan'] ?? '') === 'Klinik Khusus' ? 'selected' : '' }}>Klinik Khusus</option>
                            <option value="Dokter Gigi" {{ old('rujukan', $data['rujukan'] ?? '') === 'Dokter Gigi' ? 'selected' : '' }}>Dokter Gigi</option>
                            <option value="Dokter Mata" {{ old('rujukan', $data['rujukan'] ?? '') === 'Dokter Mata' ? 'selected' : '' }}>Dokter Mata</option>
                            <option value="Psikolog" {{ old('rujukan', $data['rujukan'] ?? '') === 'Psikolog' ? 'selected' : '' }}>Psikolog</option>
                            <option value="Lainnya" {{ old('rujukan', $data['rujukan'] ?? '') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('rujukan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-remaja.index') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                <a href="{{ route('pemeriksaan-remaja.stage', ['stage' => 3, 'pemeriksaan_id' => old('pemeriksaan_id', $data['id'] ?? '')]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 3
                </a>
                <button type="submit" class="px-6 py-2 text-white bg-cyan-600 hover:bg-cyan-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Selesaikan Pemeriksaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection