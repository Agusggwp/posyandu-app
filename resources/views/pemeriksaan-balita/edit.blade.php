@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Edit Pemeriksaan Balita</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-green-600">Pemeriksaan Balita</a>
            <span class="mx-2">/</span>
            <span>Edit</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-balita.update', $pemeriksaan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="balita_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Balita <span class="text-red-500">*</span></label>
                    <select name="balita_identitas_id" id="balita_identitas_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('balita_identitas_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Balita --</option>
                        @foreach($balitas as $balita)
                            <option value="{{ $balita->id }}" {{ old('balita_identitas_id', $pemeriksaan->balita_identitas_id) == $balita->id ? 'selected' : '' }}>
                                {{ $balita->nama }} - {{ $balita->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('balita_identitas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="umur" class="block text-sm font-medium text-gray-700 mb-2">Umur</label>
                    <input type="number" name="umur" id="umur" value="{{ old('umur', $pemeriksaan->umur) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('umur') border-red-500 @enderror">
                    @error('umur')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="waktu_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Waktu Kunjungan <span class="text-red-500">*</span></label>
                          <input type="date" name="waktu_kunjungan" id="waktu_kunjungan" 
                              value="{{ old('waktu_kunjungan', optional($pemeriksaan->waktu_kunjungan)->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('waktu_kunjungan') border-red-500 @enderror" required>
                    @error('waktu_kunjungan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan (kg)</label>
                    <input type="number" step="0.01" name="berat_badan" id="berat_badan" 
                           value="{{ old('berat_badan', $pemeriksaan->berat_badan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror">
                    @error('berat_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                          <label for="panjang_badan" class="block text-sm font-medium text-gray-700 mb-2">Panjang Badan (cm)</label>
                          <input type="number" step="0.01" name="panjang_badan" id="panjang_badan" 
                              value="{{ old('panjang_badan', $pemeriksaan->panjang_badan) }}"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('panjang_badan') border-red-500 @enderror">
                          @error('panjang_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700 mb-2">Lingkar Kepala (cm)</label>
                    <input type="number" step="0.01" name="lingkar_kepala" id="lingkar_kepala" 
                           value="{{ old('lingkar_kepala', $pemeriksaan->lingkar_kepala) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('lingkar_kepala') border-red-500 @enderror">
                    @error('lingkar_kepala')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="imunisasi" class="block text-sm font-medium text-gray-700 mb-2">Imunisasi</label>
                    <input type="text" name="imunisasi" id="imunisasi" 
                           value="{{ old('imunisasi', $pemeriksaan->imunisasi) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('imunisasi') border-red-500 @enderror">
                    @error('imunisasi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="vitamin_a" class="block text-sm font-medium text-gray-700 mb-2">Vitamin A</label>
                    <select name="vitamin_a" id="vitamin_a" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('vitamin_a') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('vitamin_a', $pemeriksaan->vitamin_a) == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('vitamin_a', $pemeriksaan->vitamin_a) == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('vitamin_a')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="status_pb_u" class="block text-sm font-medium text-gray-700 mb-2">Status PB/U</label>
                    <input type="text" name="status_pb_u" id="status_pb_u" 
                           value="{{ old('status_pb_u', $pemeriksaan->status_pb_u) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('status_pb_u') border-red-500 @enderror">
                    @error('status_pb_u')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="status_bb_u" class="block text-sm font-medium text-gray-700 mb-2">Status BB/U</label>
                    <input type="text" name="status_bb_u" id="status_bb_u" 
                           value="{{ old('status_bb_u', $pemeriksaan->status_bb_u) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('status_bb_u') border-red-500 @enderror">
                    @error('status_bb_u')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="catatan_kesehatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Kesehatan</label>
                <textarea name="catatan_kesehatan" id="catatan_kesehatan" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('catatan_kesehatan') border-red-500 @enderror">{{ old('catatan_kesehatan', $pemeriksaan->catatan_kesehatan) }}</textarea>
                @error('catatan_kesehatan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="naik_tidak_naik" class="block text-sm font-medium text-gray-700 mb-2">Naik/Tidak Naik</label>
                    <input type="text" name="naik_tidak_naik" id="naik_tidak_naik" value="{{ old('naik_tidak_naik', $pemeriksaan->naik_tidak_naik) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('naik_tidak_naik') border-red-500 @enderror">
                </div>
                <div>
                    <label for="status_lila" class="block text-sm font-medium text-gray-700 mb-2">Status LILA</label>
                    <input type="text" name="status_lila" id="status_lila" value="{{ old('status_lila', $pemeriksaan->status_lila) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('status_lila') border-red-500 @enderror">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="lingkar_lengan" class="block text-sm font-medium text-gray-700 mb-2">Lingkar Lengan</label>
                    <input type="number" step="0.01" name="lingkar_lengan" id="lingkar_lengan" value="{{ old('lingkar_lengan', $pemeriksaan->lingkar_lengan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('lingkar_lengan') border-red-500 @enderror">
                </div>
                <div>
                    <label for="batuk" class="block text-sm font-medium text-gray-700 mb-2">Batuk</label>
                    <select name="batuk" id="batuk" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('batuk', $pemeriksaan->batuk) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('batuk', $pemeriksaan->batuk) === false || old('batuk', $pemeriksaan->batuk) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="demam" class="block text-sm font-medium text-gray-700 mb-2">Demam</label>
                    <select name="demam" id="demam" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('demam', $pemeriksaan->demam) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('demam', $pemeriksaan->demam) === false || old('demam', $pemeriksaan->demam) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="bb_turun" class="block text-sm font-medium text-gray-700 mb-2">BB Turun</label>
                    <select name="bb_turun" id="bb_turun" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('bb_turun', $pemeriksaan->bb_turun) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('bb_turun', $pemeriksaan->bb_turun) === false || old('bb_turun', $pemeriksaan->bb_turun) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="kontak_tbc" class="block text-sm font-medium text-gray-700 mb-2">Kontak TBC</label>
                    <select name="kontak_tbc" id="kontak_tbc" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('kontak_tbc', $pemeriksaan->kontak_tbc) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('kontak_tbc', $pemeriksaan->kontak_tbc) === false || old('kontak_tbc', $pemeriksaan->kontak_tbc) === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="perkembangan" class="block text-sm font-medium text-gray-700 mb-2">Perkembangan</label>
                    <select name="perkembangan" id="perkembangan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('perkembangan') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('perkembangan', $pemeriksaan->perkembangan) == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('perkembangan', $pemeriksaan->perkembangan) == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('perkembangan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="asi_eksklusif" class="block text-sm font-medium text-gray-700 mb-2">ASI Eksklusif</label>
                    <select name="asi_eksklusif" id="asi_eksklusif" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('asi_eksklusif') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('asi_eksklusif', $pemeriksaan->asi_eksklusif) == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('asi_eksklusif', $pemeriksaan->asi_eksklusif) == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="mpasi" class="block text-sm font-medium text-gray-700 mb-2">MP-ASI</label>
                    <select name="mpasi" id="mpasi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('mpasi') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('mpasi', $pemeriksaan->mpasi) == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('mpasi', $pemeriksaan->mpasi) == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="obat_cacing" class="block text-sm font-medium text-gray-700 mb-2">Obat Cacing</label>
                    <select name="obat_cacing" id="obat_cacing" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('obat_cacing') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('obat_cacing', $pemeriksaan->obat_cacing) == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('obat_cacing', $pemeriksaan->obat_cacing) == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="mt_pangan" class="block text-sm font-medium text-gray-700 mb-2">MT Pangan Lokal</label>
                    <select name="mt_pangan" id="mt_pangan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('mt_pangan') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('mt_pangan', $pemeriksaan->mt_pangan) == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('mt_pangan', $pemeriksaan->mt_pangan) == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="rujukan" class="block text-sm font-medium text-gray-700 mb-2">Rujukan</label>
                    <input type="text" name="rujukan" id="rujukan" value="{{ old('rujukan', $pemeriksaan->rujukan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('rujukan') border-red-500 @enderror">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
                <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Update
                </button>
                <a href="{{ route('pemeriksaan-balita.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
