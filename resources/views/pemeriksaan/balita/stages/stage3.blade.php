@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Balita - Tahap 3</h2>
        <p class="text-gray-600 mt-1">Skrining TBC & Perkembangan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-sky-600">Pemeriksaan Balita</a>
            <span class="mx-2">/</span>
            <span>Tahap 3</span>
        </nav>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 3/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-sky-600 h-2 rounded-full" style="width: 75%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-balita.stage-store', 3) }}" method="POST">
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
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('balita_identitas_id') border-red-500 @enderror" required>
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Tahap 1 & 2 -->
            @if($data)
            <div class="bg-sky-50 border border-sky-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-sky-900 mb-3">Data dari Tahap Sebelumnya</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                    <div>
                        <p class="text-sky-700 font-medium">Berat Badan</p>
                        <p class="text-sky-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                    </div>
                    <div>
                        <p class="text-sky-700 font-medium">Panjang Badan</p>
                        <p class="text-sky-900">{{ $data['panjang_badan'] ?? '-' }} cm</p>
                    </div>
                    <div>
                        <p class="text-sky-700 font-medium">Status Gizi</p>
                        <p class="text-sky-900">{{ $data['status_bb_u'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sky-700 font-medium">Status LILA</p>
                        <p class="text-sky-900">{{ $data['status_lila'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Skrining TBC</h3>
                <p class="text-sm text-gray-600 mb-4">Jika 2 gejala terpenuhi maka dirujuk ke Puskesmas</p>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="batuk" id="batuk" value="1"
                               {{ ($data['batuk'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="batuk" class="ml-2 text-sm text-gray-700">
                            Batuk terus-menerus (Ya/Tidak)
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="demam" id="demam" value="1"
                               {{ ($data['demam'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="demam" class="ml-2 text-sm text-gray-700">
                            Demam kurang lebih 2 minggu (Ya/Tidak)
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="bb_turun" id="bb_turun" value="1"
                               {{ ($data['bb_turun'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="bb_turun" class="ml-2 text-sm text-gray-700">
                            BB tidak naik atau turun dalam 2 bulan berturut-turut (Ya/Tidak)
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="kontak_tbc" id="kontak_tbc" value="1"
                               {{ ($data['kontak_tbc'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="kontak_tbc" class="ml-2 text-sm text-gray-700">
                            Kontak erat dengan pasien TBC (Ya/Tidak)
                        </label>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Perkembangan</h3>

                <div>
                    <label for="perkembangan" class="block text-sm font-medium text-gray-700 mb-2">
                        Ceklis Perkembangan
                    </label>
                    <select name="perkembangan" id="perkembangan"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('perkembangan') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Lengkap" {{ ($data['perkembangan'] ?? null) === 'Lengkap' ? 'selected' : '' }}>Lengkap</option>
                        <option value="Tidak Lengkap" {{ ($data['perkembangan'] ?? null) === 'Tidak Lengkap' ? 'selected' : '' }}>Tidak Lengkap</option>
                        <option value="Monitor" {{ ($data['perkembangan'] ?? null) === 'Monitor' ? 'selected' : '' }}>Monitor</option>
                    </select>
                    @error('perkembangan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3 pt-6 border-t mt-6">
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-balita.stage', ['stage' => 2, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
                    ← Kembali
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-sky-600 hover:bg-sky-700 rounded-lg font-medium transition">
                    Simpan Tahap 3
                </button>
                <a href="{{ route('pemeriksaan-balita.create') }}" class="px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
