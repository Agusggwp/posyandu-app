@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-cyan-900">Pemeriksaan Remaja - Tahap 4</h2>
        <p class="text-gray-600 mt-1">Masalah Kesehatan, Edukasi & Rujukan</p>
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

            <div class="bg-slate-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Masalah Kesehatan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="masalah_rumah" class="block text-sm font-medium text-gray-700 mb-2">Masalah Rumah</label>
                        <select name="masalah_rumah" id="masalah_rumah"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('masalah_rumah') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('masalah_rumah', $data['masalah_rumah'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('masalah_rumah', $data['masalah_rumah'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('masalah_rumah')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="masalah_pendidikan" class="block text-sm font-medium text-gray-700 mb-2">Masalah Pendidikan</label>
                        <select name="masalah_pendidikan" id="masalah_pendidikan"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('masalah_pendidikan') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('masalah_pendidikan', $data['masalah_pendidikan'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('masalah_pendidikan', $data['masalah_pendidikan'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('masalah_pendidikan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="masalah_makan" class="block text-sm font-medium text-gray-700 mb-2">Masalah Makan</label>
                        <select name="masalah_makan" id="masalah_makan"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('masalah_makan') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('masalah_makan', $data['masalah_makan'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('masalah_makan', $data['masalah_makan'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('masalah_makan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="masalah_aktivitas" class="block text-sm font-medium text-gray-700 mb-2">Masalah Aktivitas</label>
                        <select name="masalah_aktivitas" id="masalah_aktivitas"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('masalah_aktivitas') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('masalah_aktivitas', $data['masalah_aktivitas'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('masalah_aktivitas', $data['masalah_aktivitas'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('masalah_aktivitas')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="masalah_obat" class="block text-sm font-medium text-gray-700 mb-2">Masalah Obat</label>
                        <select name="masalah_obat" id="masalah_obat"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('masalah_obat') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('masalah_obat', $data['masalah_obat'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('masalah_obat', $data['masalah_obat'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('masalah_obat')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="masalah_seksual" class="block text-sm font-medium text-gray-700 mb-2">Masalah Seksual</label>
                        <select name="masalah_seksual" id="masalah_seksual"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('masalah_seksual') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('masalah_seksual', $data['masalah_seksual'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('masalah_seksual', $data['masalah_seksual'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('masalah_seksual')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="masalah_emosi" class="block text-sm font-medium text-gray-700 mb-2">Masalah Emosi</label>
                        <select name="masalah_emosi" id="masalah_emosi"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('masalah_emosi') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('masalah_emosi', $data['masalah_emosi'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('masalah_emosi', $data['masalah_emosi'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('masalah_emosi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="masalah_keamanan" class="block text-sm font-medium text-gray-700 mb-2">Masalah Keamanan</label>
                        <select name="masalah_keamanan" id="masalah_keamanan"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('masalah_keamanan') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('masalah_keamanan', $data['masalah_keamanan'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('masalah_keamanan', $data['masalah_keamanan'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('masalah_keamanan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

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
                        <input type="text" name="rujukan" id="rujukan"
                               value="{{ old('rujukan', $data['rujukan'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('rujukan') border-red-500 @enderror">
                        @error('rujukan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-remaja.stage', ['stage' => 3, 'pemeriksaan_id' => old('pemeriksaan_id', $data['id'] ?? '')]) }}" class="px-6 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2 text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg font-medium transition">
                    Simpan Tahap 4
                </button>
            </div>
        </form>
    </div>
</div>
@endsection