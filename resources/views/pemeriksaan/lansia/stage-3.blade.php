@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Lansia - Tahap 3</h2>
        <p class="text-gray-600 mt-1">Pelayanan & Pemeriksaan Mata Telinga</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-lansia.index') }}" class="hover:text-teal-600">Pemeriksaan Lansia</a>
            <span class="mx-2">/</span>
            <span>Tahap 3 - Pelayanan</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700">Tahap 3 dari 4</span>
                <span class="text-sm font-semibold text-teal-600">75%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-teal-600 h-2 rounded-full" style="width: 75%"></div>
            </div>
        </div>

        <form action="{{ route('pemeriksaan-lansia.stage-store', 3) }}" method="POST">
            @csrf
            
            <input type="hidden" name="stage" value="3">
            <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">

            <!-- Pemeriksaan Mata -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-eye text-teal-600"></i>
                    Pemeriksaan Mata
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mata_kanan" class="block text-sm font-medium text-gray-700 mb-2">Mata Kanan</label>
                        <select name="mata_kanan" id="mata_kanan"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('mata_kanan') border-red-500 @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="Normal" {{ old('mata_kanan', $pemeriksaan->mata_kanan ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Gangguan Penglihatan Ringan" {{ old('mata_kanan', $pemeriksaan->mata_kanan ?? '') == 'Gangguan Penglihatan Ringan' ? 'selected' : '' }}>Gangguan Penglihatan Ringan</option>
                            <option value="Gangguan Penglihatan Sedang" {{ old('mata_kanan', $pemeriksaan->mata_kanan ?? '') == 'Gangguan Penglihatan Sedang' ? 'selected' : '' }}>Gangguan Penglihatan Sedang</option>
                            <option value="Gangguan Penglihatan Berat" {{ old('mata_kanan', $pemeriksaan->mata_kanan ?? '') == 'Gangguan Penglihatan Berat' ? 'selected' : '' }}>Gangguan Penglihatan Berat</option>
                            <option value="Buta" {{ old('mata_kanan', $pemeriksaan->mata_kanan ?? '') == 'Buta' ? 'selected' : '' }}>Buta</option>
                        </select>
                        @error('mata_kanan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mata_kiri" class="block text-sm font-medium text-gray-700 mb-2">Mata Kiri</label>
                        <select name="mata_kiri" id="mata_kiri"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('mata_kiri') border-red-500 @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="Normal" {{ old('mata_kiri', $pemeriksaan->mata_kiri ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Gangguan Penglihatan Ringan" {{ old('mata_kiri', $pemeriksaan->mata_kiri ?? '') == 'Gangguan Penglihatan Ringan' ? 'selected' : '' }}>Gangguan Penglihatan Ringan</option>
                            <option value="Gangguan Penglihatan Sedang" {{ old('mata_kiri', $pemeriksaan->mata_kiri ?? '') == 'Gangguan Penglihatan Sedang' ? 'selected' : '' }}>Gangguan Penglihatan Sedang</option>
                            <option value="Gangguan Penglihatan Berat" {{ old('mata_kiri', $pemeriksaan->mata_kiri ?? '') == 'Gangguan Penglihatan Berat' ? 'selected' : '' }}>Gangguan Penglihatan Berat</option>
                            <option value="Buta" {{ old('mata_kiri', $pemeriksaan->mata_kiri ?? '') == 'Buta' ? 'selected' : '' }}>Buta</option>
                        </select>
                        @error('mata_kiri')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pemeriksaan Telinga -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-ear text-teal-600"></i>
                    Pemeriksaan Telinga
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telinga_kanan" class="block text-sm font-medium text-gray-700 mb-2">Telinga Kanan</label>
                        <select name="telinga_kanan" id="telinga_kanan"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('telinga_kanan') border-red-500 @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="Normal" {{ old('telinga_kanan', $pemeriksaan->telinga_kanan ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Gangguan Pendengaran Ringan" {{ old('telinga_kanan', $pemeriksaan->telinga_kanan ?? '') == 'Gangguan Pendengaran Ringan' ? 'selected' : '' }}>Gangguan Pendengaran Ringan</option>
                            <option value="Gangguan Pendengaran Sedang" {{ old('telinga_kanan', $pemeriksaan->telinga_kanan ?? '') == 'Gangguan Pendengaran Sedang' ? 'selected' : '' }}>Gangguan Pendengaran Sedang</option>
                            <option value="Gangguan Pendengaran Berat" {{ old('telinga_kanan', $pemeriksaan->telinga_kanan ?? '') == 'Gangguan Pendengaran Berat' ? 'selected' : '' }}>Gangguan Pendengaran Berat</option>
                            <option value="Tuli" {{ old('telinga_kanan', $pemeriksaan->telinga_kanan ?? '') == 'Tuli' ? 'selected' : '' }}>Tuli</option>
                        </select>
                        @error('telinga_kanan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telinga_kiri" class="block text-sm font-medium text-gray-700 mb-2">Telinga Kiri</label>
                        <select name="telinga_kiri" id="telinga_kiri"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('telinga_kiri') border-red-500 @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="Normal" {{ old('telinga_kiri', $pemeriksaan->telinga_kiri ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Gangguan Pendengaran Ringan" {{ old('telinga_kiri', $pemeriksaan->telinga_kiri ?? '') == 'Gangguan Pendengaran Ringan' ? 'selected' : '' }}>Gangguan Pendengaran Ringan</option>
                            <option value="Gangguan Pendengaran Sedang" {{ old('telinga_kiri', $pemeriksaan->telinga_kiri ?? '') == 'Gangguan Pendengaran Sedang' ? 'selected' : '' }}>Gangguan Pendengaran Sedang</option>
                            <option value="Gangguan Pendengaran Berat" {{ old('telinga_kiri', $pemeriksaan->telinga_kiri ?? '') == 'Gangguan Pendengaran Berat' ? 'selected' : '' }}>Gangguan Pendengaran Berat</option>
                            <option value="Tuli" {{ old('telinga_kiri', $pemeriksaan->telinga_kiri ?? '') == 'Tuli' ? 'selected' : '' }}>Tuli</option>
                        </select>
                        @error('telinga_kiri')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-xl transition">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Lanjutkan ke Tahap 4
                </button>
                <a href="{{ route('pemeriksaan-lansia.stage', ['stage' => 2, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-3 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
