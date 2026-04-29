@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Ibu Hamil - Tahap 1</h2>
        <p class="text-gray-600 mt-1">Penimbangan & Pengukuran</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="hover:text-purple-600">Pemeriksaan Ibu Hamil</a>
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
            <div class="bg-purple-600 h-2 rounded-full" style="width: 25%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-ibu-hamil.stage-store', ['stage' => 1, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="ibu_hamil_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Ibu Hamil <span class="text-red-500">*</span>
                    </label>
                    <select name="ibu_hamil_identitas_id" id="ibu_hamil_identitas_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('ibu_hamil_identitas_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Ibu Hamil --</option>
                        @foreach($ibuHamils as $ibuHamil)
                            <option value="{{ $ibuHamil->id }}" {{ ($data['ibu_hamil_identitas_id'] ?? null) == $ibuHamil->id ? 'selected' : '' }}>
                                {{ $ibuHamil->nama }} - {{ $ibuHamil->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('ibu_hamil_identitas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Kunjungan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                           value="{{ $data['tanggal_kunjungan'] ?? date('Y-m-d') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                    @error('tanggal_kunjungan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Pengukuran</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="usia_kehamilan" class="block text-sm font-medium text-gray-700 mb-2">
                            Usia Kehamilan (minggu)
                        </label>
                        <input type="number" name="usia_kehamilan" id="usia_kehamilan"
                               value="{{ $data['usia_kehamilan'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('usia_kehamilan') border-red-500 @enderror"
                               min="0" max="42">
                        @error('usia_kehamilan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat Badan (kg)
                        </label>
                        <input type="number" step="0.01" name="berat_badan" id="berat_badan"
                               value="{{ $data['berat_badan'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror"
                               min="0">
                        @error('berat_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lingkar_lengan" class="block text-sm font-medium text-gray-700 mb-2">
                            LILA / Lingkar Lengan Atas (cm)
                        </label>
                        <input type="number" step="0.01" name="lingkar_lengan" id="lingkar_lengan"
                               value="{{ $data['lingkar_lengan'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('lingkar_lengan') border-red-500 @enderror"
                               min="0">
                        @error('lingkar_lengan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status_bb" class="block text-sm font-medium text-gray-700 mb-2">
                            Status BB (Naik/Tidak)
                        </label>
                        <select name="status_bb" id="status_bb"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('status_bb') border-red-500 @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="Naik" {{ ($data['status_bb'] ?? null) === 'Naik' ? 'selected' : '' }}>Naik</option>
                            <option value="Tidak" {{ ($data['status_bb'] ?? null) === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('status_bb')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status_lila" class="block text-sm font-medium text-gray-700 mb-2">
                            Status LILA
                        </label>
                        <select name="status_lila" id="status_lila"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('status_lila') border-red-500 @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="Hijau" {{ ($data['status_lila'] ?? null) === 'Hijau' ? 'selected' : '' }}>Hijau</option>
                            <option value="Kuning" {{ ($data['status_lila'] ?? null) === 'Kuning' ? 'selected' : '' }}>Kuning</option>
                            <option value="Merah" {{ ($data['status_lila'] ?? null) === 'Merah' ? 'selected' : '' }}>Merah</option>
                        </select>
                        @error('status_lila')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
                <a href="{{ route('pemeriksaan-ibu-hamil.create') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Simpan Tahap 1
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
