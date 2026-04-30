@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Balita - Tahap 4</h2>
        <p class="text-gray-600 mt-1">Edukasi & Rujukan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-amber-600">Pemeriksaan Balita</a>
            <span class="mx-2">/</span>
            <span>Tahap 4</span>
        </nav>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 4/4 (Final)</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-amber-600 h-2 rounded-full" style="width: 100%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-balita.stage-store', 4) }}" method="POST">
            @csrf

            @if($pemeriksaan)
                <input type="hidden" name="balita_identitas_id" value="{{ $pemeriksaan->balita_identitas_id }}">
                <input type="hidden" name="tanggal_kunjungan" value="{{ optional($pemeriksaan->tanggal_kunjungan)->format('Y-m-d') ?? $pemeriksaan->tanggal_kunjungan }}">
                <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-green-900 font-medium">Melanjutkan pemeriksaan untuk {{ $pemeriksaan->balita->nama_bayi ?? '-' }}. Data balita dan tanggal kunjungan sudah dikunci dari tahap sebelumnya.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="balita_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Balita <span class="text-red-500">*</span>
                        </label>
                        <select name="balita_identitas_id" id="balita_identitas_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('balita_identitas_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Balita --</option>
                            @foreach($balitas as $balita)
                                <option value="{{ $balita->id }}" {{ (old('balita_identitas_id', $data['balita_identitas_id'] ?? null)) == $balita->id ? 'selected' : '' }}>
                                    {{ $balita->nama_bayi }} - {{ $balita->nik }}
                                </option>
                            @endforeach
                        </select>
                        @error('balita_identitas_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                               value="{{ old('tanggal_kunjungan', $data['tanggal_kunjungan'] ?? date('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Semua Tahap -->
            @if($data)
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-amber-900 mb-3">Ringkasan Data Pemeriksaan</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                    <div>
                        <p class="text-amber-700 font-medium">Berat Badan</p>
                        <p class="text-amber-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                    </div>
                    <div>
                        <p class="text-amber-700 font-medium">Status Gizi</p>
                        <p class="text-amber-900">{{ $data['status_bb_u'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-amber-700 font-medium">Status Perkembangan</p>
                        <p class="text-amber-900">{{ $data['perkembangan'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-amber-700 font-medium">Status LILA</p>
                        <p class="text-amber-900">{{ $data['status_lila'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pemberian & Intervensi</h3>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="asi_eksklusif" id="asi_eksklusif" value="1"
                               {{ ($data['asi_eksklusif'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
                        <label for="asi_eksklusif" class="ml-2 text-sm text-gray-700">
                            ASI Eksklusif diberikan
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="mpasi" id="mpasi" value="1"
                               {{ ($data['mpasi'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
                        <label for="mpasi" class="ml-2 text-sm text-gray-700">
                            MP-ASI diberikan
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="imunisasi" id="imunisasi" value="1"
                               {{ ($data['imunisasi'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
                        <label for="imunisasi" class="ml-2 text-sm text-gray-700">
                            Imunisasi lengkap
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="vitamin_a" id="vitamin_a" value="1"
                               {{ ($data['vitamin_a'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
                        <label for="vitamin_a" class="ml-2 text-sm text-gray-700">
                            Vitamin A diberikan
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="obat_cacing" id="obat_cacing" value="1"
                               {{ ($data['obat_cacing'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
                        <label for="obat_cacing" class="ml-2 text-sm text-gray-700">
                            Obat cacing diberikan
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="mt_pangan" id="mt_pangan" value="1"
                               {{ ($data['mt_pangan'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-2 focus:ring-amber-500">
                        <label for="mt_pangan" class="ml-2 text-sm text-gray-700">
                            Makanan Tradisional / Pangan Lokal diberikan
                        </label>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Edukasi</h3>

                <div>
                    <label for="edukasi" class="block text-sm font-medium text-gray-700 mb-2">
                        Materi Edukasi
                    </label>
                    <textarea name="edukasi" id="edukasi" rows="4"
                              placeholder="Catatan edukasi yang diberikan kepada orangtua..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('edukasi') border-red-500 @enderror">{{ $data['edukasi'] ?? '' }}</textarea>
                    @error('edukasi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Catatan & Rujukan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="catatan_kesehatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Kesehatan / Anak Sakit
                        </label>
                        <textarea name="catatan_kesehatan" id="catatan_kesehatan" rows="3"
                                  placeholder="Catatan untuk anak sakit atau keadaan khusus..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('catatan_kesehatan') border-red-500 @enderror">{{ $data['catatan_kesehatan'] ?? '' }}</textarea>
                        @error('catatan_kesehatan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rujukan" class="block text-sm font-medium text-gray-700 mb-2">
                            Rujukan
                        </label>
                        <select name="rujukan" id="rujukan"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('rujukan') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Tidak Ada" {{ ($data['rujukan'] ?? null) === 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                            <option value="Pustu" {{ ($data['rujukan'] ?? null) === 'Pustu' ? 'selected' : '' }}>Pustu (Pos Upaya Terpadu)</option>
                            <option value="Puskesmas" {{ ($data['rujukan'] ?? null) === 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                            <option value="Rumah Sakit" {{ ($data['rujukan'] ?? null) === 'Rumah Sakit' ? 'selected' : '' }}>Rumah Sakit</option>
                        </select>
                        @error('rujukan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3 pt-6 border-t mt-6">
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-balita.stage', ['stage' => 3, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
                    ← Kembali
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-amber-600 hover:bg-amber-700 rounded-lg font-medium transition">
                    ✓ Selesaikan Pemeriksaan
                </button>
                <a href="{{ route('pemeriksaan-balita.create') }}" class="px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
