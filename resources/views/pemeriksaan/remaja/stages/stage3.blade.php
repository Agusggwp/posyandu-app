@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-cyan-900">Pemeriksaan Remaja - Tahap 3</h2>
        <p class="text-gray-600 mt-1">Skrining TBC</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-remaja.index') }}" class="hover:text-cyan-600">Pemeriksaan Remaja</a>
            <span class="mx-2">/</span>
            <span>Tahap 3</span>
        </nav>
    </div>

    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 3/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-cyan-600 h-2 rounded-full" style="width: 75%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-remaja.stage-store', 3) }}" method="POST">
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

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Skrining TBC</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="batuk" class="block text-sm font-medium text-gray-700 mb-2">Batuk terus menerus</label>
                        <select name="batuk" id="batuk"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('batuk') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('batuk', $data['batuk'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('batuk', $data['batuk'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('batuk')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="demam" class="block text-sm font-medium text-gray-700 mb-2">Demam kurang 2 minggu</label>
                        <select name="demam" id="demam"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('demam') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('demam', $data['demam'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('demam', $data['demam'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('demam')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bb_turun" class="block text-sm font-medium text-gray-700 mb-2">BB tidak naik atau turun 2 bulan berturut-turut</label>
                        <select name="bb_turun" id="bb_turun"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('bb_turun') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('bb_turun', $data['bb_turun'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('bb_turun', $data['bb_turun'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('bb_turun')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kontak_tbc" class="block text-sm font-medium text-gray-700 mb-2">Kontak erat pasien TBC</label>
                        <select name="kontak_tbc" id="kontak_tbc"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('kontak_tbc') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('kontak_tbc', $data['kontak_tbc'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('kontak_tbc', $data['kontak_tbc'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('kontak_tbc')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-remaja.stage', ['stage' => 2, 'pemeriksaan_id' => old('pemeriksaan_id', $data['id'] ?? '')]) }}" class="px-6 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2 text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg font-medium transition">
                    Simpan Tahap 3
                </button>
            </div>
        </form>
    </div>
</div>
@endsection