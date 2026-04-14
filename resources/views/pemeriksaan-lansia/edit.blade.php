@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Edit Pemeriksaan Lansia</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-lansia.index') }}" class="hover:text-yellow-600">Pemeriksaan Lansia</a>
            <span class="mx-2">/</span>
            <span>Edit</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('pemeriksaan-lansia.update', $pemeriksaan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="dewasa_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Lansia <span class="text-red-500">*</span></label>
                    <select name="dewasa_identitas_id" id="dewasa_identitas_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('dewasa_identitas_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Lansia --</option>
                        @foreach($lansias as $lansia)
                            <option value="{{ $lansia->id }}" {{ old('dewasa_identitas_id', $pemeriksaan->dewasa_identitas_id) == $lansia->id ? 'selected' : '' }}>
                                {{ $lansia->nama }} - {{ $lansia->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('dewasa_identitas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="waktu_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Waktu Kunjungan <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="waktu_kunjungan" id="waktu_kunjungan" 
                           value="{{ old('waktu_kunjungan', optional($pemeriksaan->waktu_kunjungan)->format('Y-m-d\\TH:i')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('waktu_kunjungan') border-red-500 @enderror" required>
                    @error('waktu_kunjungan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="sistole" class="block text-sm font-medium text-gray-700 mb-2">Sistole</label>
                    <input type="number" name="sistole" id="sistole" 
                           value="{{ old('sistole', $pemeriksaan->sistole) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('sistole') border-red-500 @enderror">
                    @error('sistole')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="diastole" class="block text-sm font-medium text-gray-700 mb-2">Diastole</label>
                    <input type="number" name="diastole" id="diastole" 
                           value="{{ old('diastole', $pemeriksaan->diastole) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('diastole') border-red-500 @enderror">
                    @error('diastole')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan (kg)</label>
                    <input type="number" step="0.01" name="berat_badan" id="berat_badan" 
                           value="{{ old('berat_badan', $pemeriksaan->berat_badan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror">
                    @error('berat_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan (cm)</label>
                    <input type="number" step="0.01" name="tinggi_badan" id="tinggi_badan" 
                           value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('tinggi_badan') border-red-500 @enderror">
                    @error('tinggi_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="gula_darah" class="block text-sm font-medium text-gray-700 mb-2">Gula Darah (mg/dL)</label>
                    <input type="number" name="gula_darah" id="gula_darah" 
                           value="{{ old('gula_darah', $pemeriksaan->gula_darah) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('gula_darah') border-red-500 @enderror">
                    @error('gula_darah')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="lingkar_perut" class="block text-sm font-medium text-gray-700 mb-2">Lingkar Perut (cm)</label>
                    <input type="number" step="0.01" name="lingkar_perut" id="lingkar_perut" 
                           value="{{ old('lingkar_perut', $pemeriksaan->lingkar_perut) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('lingkar_perut') border-red-500 @enderror">
                    @error('lingkar_perut')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="tekanan_darah_status" class="block text-sm font-medium text-gray-700 mb-2">Status Tekanan Darah</label>
                <input type="text" name="tekanan_darah_status" id="tekanan_darah_status" 
                       value="{{ old('tekanan_darah_status', $pemeriksaan->tekanan_darah_status) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('tekanan_darah_status') border-red-500 @enderror">
                @error('tekanan_darah_status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="edukasi" class="block text-sm font-medium text-gray-700 mb-2">Edukasi</label>
                <textarea name="edukasi" id="edukasi" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('edukasi') border-red-500 @enderror">{{ old('edukasi', $pemeriksaan->edukasi) }}</textarea>
                @error('edukasi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="rujukan" class="block text-sm font-medium text-gray-700 mb-2">Rujukan</label>
                <input type="text" name="rujukan" id="rujukan" 
                       value="{{ old('rujukan', $pemeriksaan->rujukan) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('rujukan') border-red-500 @enderror">
                @error('rujukan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="imt" class="block text-sm font-medium text-gray-700 mb-2">IMT</label>
                    <input type="number" step="0.01" name="imt" id="imt" value="{{ old('imt', $pemeriksaan->imt) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('imt') border-red-500 @enderror">
                </div>
                <div>
                    <label for="mata_kanan" class="block text-sm font-medium text-gray-700 mb-2">Mata Kanan</label>
                    <input type="text" name="mata_kanan" id="mata_kanan" value="{{ old('mata_kanan', $pemeriksaan->mata_kanan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('mata_kanan') border-red-500 @enderror">
                </div>
                <div>
                    <label for="mata_kiri" class="block text-sm font-medium text-gray-700 mb-2">Mata Kiri</label>
                    <input type="text" name="mata_kiri" id="mata_kiri" value="{{ old('mata_kiri', $pemeriksaan->mata_kiri) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('mata_kiri') border-red-500 @enderror">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="telinga_kanan" class="block text-sm font-medium text-gray-700 mb-2">Telinga Kanan</label>
                    <input type="text" name="telinga_kanan" id="telinga_kanan" value="{{ old('telinga_kanan', $pemeriksaan->telinga_kanan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('telinga_kanan') border-red-500 @enderror">
                </div>
                <div>
                    <label for="telinga_kiri" class="block text-sm font-medium text-gray-700 mb-2">Telinga Kiri</label>
                    <input type="text" name="telinga_kiri" id="telinga_kiri" value="{{ old('telinga_kiri', $pemeriksaan->telinga_kiri) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('telinga_kiri') border-red-500 @enderror">
                </div>
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin', $pemeriksaan->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $pemeriksaan->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="usia_kategori" class="block text-sm font-medium text-gray-700 mb-2">Usia Kategori</label>
                    <input type="text" name="usia_kategori" id="usia_kategori" value="{{ old('usia_kategori', $pemeriksaan->usia_kategori) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('usia_kategori') border-red-500 @enderror">
                </div>
                <div>
                    <label for="skor_merokok" class="block text-sm font-medium text-gray-700 mb-2">Skor Merokok</label>
                    <input type="number" name="skor_merokok" id="skor_merokok" value="{{ old('skor_merokok', $pemeriksaan->skor_merokok) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('skor_merokok') border-red-500 @enderror">
                </div>
                <div>
                    <label for="skor_puma" class="block text-sm font-medium text-gray-700 mb-2">Skor PUMA</label>
                    <input type="number" name="skor_puma" id="skor_puma" value="{{ old('skor_puma', $pemeriksaan->skor_puma) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('skor_puma') border-red-500 @enderror">
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                <div>
                    <label for="napas_berat" class="block text-sm font-medium text-gray-700 mb-2">Napas Berat</label>
                    <select name="napas_berat" id="napas_berat" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('napas_berat', $pemeriksaan->napas_berat) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('napas_berat', $pemeriksaan->napas_berat) === false || old('napas_berat', $pemeriksaan->napas_berat) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="dahak" class="block text-sm font-medium text-gray-700 mb-2">Dahak</label>
                    <select name="dahak" id="dahak" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('dahak', $pemeriksaan->dahak) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('dahak', $pemeriksaan->dahak) === false || old('dahak', $pemeriksaan->dahak) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="batuk" class="block text-sm font-medium text-gray-700 mb-2">Batuk</label>
                    <select name="batuk" id="batuk" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('batuk', $pemeriksaan->batuk) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('batuk', $pemeriksaan->batuk) === false || old('batuk', $pemeriksaan->batuk) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="aktivitas_terganggu" class="block text-sm font-medium text-gray-700 mb-2">Aktivitas Terganggu</label>
                    <select name="aktivitas_terganggu" id="aktivitas_terganggu" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('aktivitas_terganggu', $pemeriksaan->aktivitas_terganggu) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('aktivitas_terganggu', $pemeriksaan->aktivitas_terganggu) === false || old('aktivitas_terganggu', $pemeriksaan->aktivitas_terganggu) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="pemeriksaan_sebelumnya" class="block text-sm font-medium text-gray-700 mb-2">Pemeriksaan Sebelumnya</label>
                    <input type="text" name="pemeriksaan_sebelumnya" id="pemeriksaan_sebelumnya" value="{{ old('pemeriksaan_sebelumnya', $pemeriksaan->pemeriksaan_sebelumnya) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('pemeriksaan_sebelumnya') border-red-500 @enderror">
                </div>
                <div>
                    <label for="batuk_tbc" class="block text-sm font-medium text-gray-700 mb-2">Batuk TBC</label>
                    <select name="batuk_tbc" id="batuk_tbc" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('batuk_tbc', $pemeriksaan->batuk_tbc) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('batuk_tbc', $pemeriksaan->batuk_tbc) === false || old('batuk_tbc', $pemeriksaan->batuk_tbc) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="demam" class="block text-sm font-medium text-gray-700 mb-2">Demam</label>
                    <select name="demam" id="demam" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('demam', $pemeriksaan->demam) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('demam', $pemeriksaan->demam) === false || old('demam', $pemeriksaan->demam) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="bb_turun" class="block text-sm font-medium text-gray-700 mb-2">BB Turun</label>
                    <select name="bb_turun" id="bb_turun" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('bb_turun', $pemeriksaan->bb_turun) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('bb_turun', $pemeriksaan->bb_turun) === false || old('bb_turun', $pemeriksaan->bb_turun) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="kontak_tbc" class="block text-sm font-medium text-gray-700 mb-2">Kontak TBC</label>
                    <select name="kontak_tbc" id="kontak_tbc" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('kontak_tbc', $pemeriksaan->kontak_tbc) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('kontak_tbc', $pemeriksaan->kontak_tbc) === false || old('kontak_tbc', $pemeriksaan->kontak_tbc) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Update
                </button>
                <a href="{{ route('pemeriksaan-lansia.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
