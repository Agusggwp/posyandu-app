@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-cyan-900">Edit Pemeriksaan Remaja</h2>
    </div>

    <div class="bg-white rounded-lg shadow-lg border border-cyan-200 p-6">
        <form action="{{ route('pemeriksaan-remaja.update', $pemeriksaanRemaja->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Remaja</label>
                    <select name="remaja_identitas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        @foreach($remajas as $remaja)
                            <option value="{{ $remaja->id }}" {{ old('remaja_identitas_id', $pemeriksaanRemaja->remaja_identitas_id) == $remaja->id ? 'selected' : '' }}>
                                {{ $remaja->nama_anak }} - {{ $remaja->nik }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Kunjungan</label>
                    <input type="datetime-local" name="waktu_kunjungan" value="{{ old('waktu_kunjungan', $pemeriksaanRemaja->waktu_kunjungan ? \Illuminate\Support\Carbon::parse($pemeriksaanRemaja->waktu_kunjungan)->format('Y-m-d\\TH:i') : '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Berat Badan</label>
                    <input type="number" step="0.01" name="berat_badan" value="{{ old('berat_badan', $pemeriksaanRemaja->berat_badan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan</label>
                    <input type="number" step="0.01" name="tinggi_badan" value="{{ old('tinggi_badan', $pemeriksaanRemaja->tinggi_badan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">IMT Status</label>
                    <input type="text" name="imt_status" value="{{ old('imt_status', $pemeriksaanRemaja->imt_status) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lingkar Perut</label>
                    <input type="number" step="0.01" name="lingkar_perut" value="{{ old('lingkar_perut', $pemeriksaanRemaja->lingkar_perut) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sistole</label>
                    <input type="number" name="sistole" value="{{ old('sistole', $pemeriksaanRemaja->sistole) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Diastole</label>
                    <input type="number" name="diastole" value="{{ old('diastole', $pemeriksaanRemaja->diastole) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Tekanan Darah</label>
                    <input type="text" name="tekanan_darah_status" value="{{ old('tekanan_darah_status', $pemeriksaanRemaja->tekanan_darah_status) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gula Darah</label>
                    <input type="text" name="gula_darah" value="{{ old('gula_darah', $pemeriksaanRemaja->gula_darah) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hemoglobin</label>
                    <input type="text" name="hemoglobin" value="{{ old('hemoglobin', $pemeriksaanRemaja->hemoglobin) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Anemia</label>
                    <select name="anemia" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('anemia', $pemeriksaanRemaja->anemia) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('anemia', $pemeriksaanRemaja->anemia) === false || old('anemia', $pemeriksaanRemaja->anemia) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Batuk</label>
                    <select name="batuk" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('batuk', $pemeriksaanRemaja->batuk) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('batuk', $pemeriksaanRemaja->batuk) === false || old('batuk', $pemeriksaanRemaja->batuk) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Demam</label>
                    <select name="demam" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('demam', $pemeriksaanRemaja->demam) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('demam', $pemeriksaanRemaja->demam) === false || old('demam', $pemeriksaanRemaja->demam) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">BB Turun</label>
                    <select name="bb_turun" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('bb_turun', $pemeriksaanRemaja->bb_turun) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('bb_turun', $pemeriksaanRemaja->bb_turun) === false || old('bb_turun', $pemeriksaanRemaja->bb_turun) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontak TBC</label>
                    <select name="kontak_tbc" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('kontak_tbc', $pemeriksaanRemaja->kontak_tbc) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('kontak_tbc', $pemeriksaanRemaja->kontak_tbc) === false || old('kontak_tbc', $pemeriksaanRemaja->kontak_tbc) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Rumah</label>
                    <input type="text" name="masalah_rumah" value="{{ old('masalah_rumah', $pemeriksaanRemaja->masalah_rumah) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Pendidikan</label>
                    <input type="text" name="masalah_pendidikan" value="{{ old('masalah_pendidikan', $pemeriksaanRemaja->masalah_pendidikan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Makan</label>
                    <input type="text" name="masalah_makan" value="{{ old('masalah_makan', $pemeriksaanRemaja->masalah_makan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Aktivitas</label>
                    <input type="text" name="masalah_aktivitas" value="{{ old('masalah_aktivitas', $pemeriksaanRemaja->masalah_aktivitas) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Obat</label>
                    <input type="text" name="masalah_obat" value="{{ old('masalah_obat', $pemeriksaanRemaja->masalah_obat) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Seksual</label>
                    <input type="text" name="masalah_seksual" value="{{ old('masalah_seksual', $pemeriksaanRemaja->masalah_seksual) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Emosi</label>
                    <input type="text" name="masalah_emosi" value="{{ old('masalah_emosi', $pemeriksaanRemaja->masalah_emosi) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masalah Keamanan</label>
                    <input type="text" name="masalah_keamanan" value="{{ old('masalah_keamanan', $pemeriksaanRemaja->masalah_keamanan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Edukasi</label>
                <textarea name="edukasi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('edukasi', $pemeriksaanRemaja->edukasi) }}</textarea>
            </div>
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rujukan</label>
                <input type="text" name="rujukan" value="{{ old('rujukan', $pemeriksaanRemaja->rujukan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-2 px-6 rounded-xl">Update</button>
                <a href="{{ route('pemeriksaan-remaja.index') }}" class="bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-2 px-6 rounded-xl">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
