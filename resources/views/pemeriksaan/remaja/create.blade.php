@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-cyan-900">Input Pemeriksaan Remaja</h2>
    </div>

    <div class="bg-white rounded-lg shadow-lg border border-cyan-200 p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-remaja.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Remaja</label>
                    <select name="remaja_identitas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        <option value="">-- Pilih --</option>
                        @foreach($remajas as $remaja)
                        <option value="{{ $remaja->id }}" {{ old('remaja_identitas_id') == $remaja->id ? 'selected' : '' }}>{{ $remaja->nama_anak }} - {{ $remaja->nik }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Kunjungan</label>
                    <input type="date" name="waktu_kunjungan" value="{{ old('waktu_kunjungan', now()->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Berat Badan</label>
                    <input type="number" step="0.01" name="berat_badan" value="{{ old('berat_badan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan</label>
                    <input type="number" step="0.01" name="tinggi_badan" value="{{ old('tinggi_badan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">IMT Status</label>
                    <input type="text" name="imt_status" value="{{ old('imt_status') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lingkar Perut</label>
                    <input type="number" step="0.01" name="lingkar_perut" value="{{ old('lingkar_perut') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sistole</label>
                    <input type="number" name="sistole" value="{{ old('sistole') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Diastole</label>
                    <input type="number" name="diastole" value="{{ old('diastole') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Tekanan Darah</label>
                    <input type="text" name="tekanan_darah_status" value="{{ old('tekanan_darah_status') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gula Darah</label>
                    <input type="text" name="gula_darah" value="{{ old('gula_darah') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hemoglobin</label>
                    <input type="text" name="hemoglobin" value="{{ old('hemoglobin') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Anemia</label>
                    <select name="anemia" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('anemia') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('anemia') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Batuk</label>
                    <select name="batuk" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('batuk') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('batuk') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Demam</label>
                    <select name="demam" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('demam') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('demam') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">BB Turun</label>
                    <select name="bb_turun" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('bb_turun') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('bb_turun') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontak TBC</label>
                    <select name="kontak_tbc" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('kontak_tbc') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('kontak_tbc') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Edukasi</label>
                <textarea name="edukasi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('edukasi') }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Rumah</label>
                    <select name="masalah_rumah" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('masalah_rumah') === 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('masalah_rumah') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Pendidikan</label>
                    <select name="masalah_pendidikan" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('masalah_pendidikan') === 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('masalah_pendidikan') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Makan</label>
                    <select name="masalah_makan" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('masalah_makan') === 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('masalah_makan') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Aktivitas</label>
                    <select name="masalah_aktivitas" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('masalah_aktivitas') === 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('masalah_aktivitas') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Obat</label>
                    <select name="masalah_obat" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('masalah_obat') === 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('masalah_obat') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Seksual</label>
                    <select name="masalah_seksual" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('masalah_seksual') === 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('masalah_seksual') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Emosi</label>
                    <select name="masalah_emosi" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('masalah_emosi') === 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('masalah_emosi') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Keamanan</label>
                    <select name="masalah_keamanan" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('masalah_keamanan') === 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('masalah_keamanan') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rujukan</label>
                <input type="text" name="rujukan" value="{{ old('rujukan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
                <button type="submit" class="bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center">Simpan</button>
                <a href="{{ route('pemeriksaan-remaja.index') }}" class="bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
