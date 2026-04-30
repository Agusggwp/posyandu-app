@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Balita - Tahap 1</h2>
        <p class="text-gray-600 mt-1">Penimbangan & Pengukuran</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-teal-600">Pemeriksaan Balita</a>
            <span class="mx-2">/</span>
            <span>Tahap 1</span>
        </nav>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 1/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-teal-600 h-2 rounded-full" style="width: 25%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-balita.stage-store', 1) }}" method="POST">
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
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('balita_identitas_id') border-red-500 @enderror" required>
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Penimbangan & Pengukuran</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat Badan (kg) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="berat_badan" id="berat_badan"
                               value="{{ $data['berat_badan'] ?? '' }}" step="0.1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror"
                               required>
                        @error('berat_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="naik_tidak_naik" class="block text-sm font-medium text-gray-700 mb-2">
                            Status BB (Naik/Tidak)
                        </label>
                        <select name="naik_tidak_naik" id="naik_tidak_naik"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('naik_tidak_naik') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Naik" {{ ($data['naik_tidak_naik'] ?? null) === 'Naik' ? 'selected' : '' }}>Naik</option>
                            <option value="Tidak Naik" {{ ($data['naik_tidak_naik'] ?? null) === 'Tidak Naik' ? 'selected' : '' }}>Tidak Naik</option>
                            <option value="Tetap" {{ ($data['naik_tidak_naik'] ?? null) === 'Tetap' ? 'selected' : '' }}>Tetap</option>
                        </select>
                        @error('naik_tidak_naik')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="panjang_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Panjang Badan (cm) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="panjang_badan" id="panjang_badan"
                               value="{{ $data['panjang_badan'] ?? '' }}" step="0.1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('panjang_badan') border-red-500 @enderror"
                               required>
                        @error('panjang_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700 mb-2">
                            Lingkar Kepala (cm)
                        </label>
                        <input type="number" name="lingkar_kepala" id="lingkar_kepala"
                               value="{{ $data['lingkar_kepala'] ?? '' }}" step="0.1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('lingkar_kepala') border-red-500 @enderror">
                        @error('lingkar_kepala')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3 pt-6 border-t">
                <button type="submit" class="px-6 py-2 text-white bg-teal-600 hover:bg-teal-700 rounded-lg font-medium transition">
                    Simpan Tahap 1
                </button>
                <a href="{{ route('pemeriksaan-balita.create') }}" class="px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
