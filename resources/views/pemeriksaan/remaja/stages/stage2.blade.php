@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-cyan-900">Pemeriksaan Remaja - Tahap 2</h2>
        <p class="text-gray-600 mt-1">Pemeriksaan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-remaja.index') }}" class="hover:text-cyan-600">Pemeriksaan Remaja</a>
            <span class="mx-2">/</span>
            <span>Tahap 2</span>
        </nav>
    </div>

    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 2/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-cyan-600 h-2 rounded-full" style="width: 50%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-remaja.stage-store', 2) }}" method="POST">
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
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pemeriksaan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sistole" class="block text-sm font-medium text-gray-700 mb-2">Sistole</label>
                        <input type="number" name="sistole" id="sistole"
                               value="{{ old('sistole', $data['sistole'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('sistole') border-red-500 @enderror"
                               min="0">
                        @error('sistole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="diastole" class="block text-sm font-medium text-gray-700 mb-2">Diastole</label>
                        <input type="number" name="diastole" id="diastole"
                               value="{{ old('diastole', $data['diastole'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('diastole') border-red-500 @enderror"
                               min="0">
                        @error('diastole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tekanan_darah_status" class="block text-sm font-medium text-gray-700 mb-2">Status Tekanan Darah</label>
                        <input type="text" name="tekanan_darah_status" id="tekanan_darah_status"
                               value="{{ old('tekanan_darah_status', $data['tekanan_darah_status'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('tekanan_darah_status') border-red-500 @enderror">
                        @error('tekanan_darah_status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gula_darah" class="block text-sm font-medium text-gray-700 mb-2">Gula Darah</label>
                        <input type="text" name="gula_darah" id="gula_darah"
                               value="{{ old('gula_darah', $data['gula_darah'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('gula_darah') border-red-500 @enderror">
                        @error('gula_darah')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hemoglobin" class="block text-sm font-medium text-gray-700 mb-2">Hemoglobin</label>
                        <input type="text" name="hemoglobin" id="hemoglobin"
                               value="{{ old('hemoglobin', $data['hemoglobin'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('hemoglobin') border-red-500 @enderror">
                        @error('hemoglobin')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="anemia" class="block text-sm font-medium text-gray-700 mb-2">Anemia</label>
                        <select name="anemia" id="anemia"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('anemia') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('anemia', $data['anemia'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('anemia', $data['anemia'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('anemia')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-6 border-t">
                @if($pemeriksaan)
                    <a href="{{ route('pemeriksaan-remaja.stage', ['stage' => 1, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
                        Kembali
                    </a>
                @else
                    <a href="{{ route('pemeriksaan-remaja.create') }}" class="px-6 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
                        Kembali
                    </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg font-medium transition">
                    Simpan Tahap 2
                </button>
            </div>
        </form>
    </div>
</div>
@endsection