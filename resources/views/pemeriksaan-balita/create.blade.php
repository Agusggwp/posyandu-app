@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Input Pemeriksaan Balita</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-indigo-600 transition-colors">Pemeriksaan Balita</a>
            <span class="mx-2">/</span>
            <span>Tambah</span>
        </nav>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-8 border border-indigo-100">
        <form action="{{ route('pemeriksaan-balita.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="balita_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Balita <span class="text-red-500">*</span></label>
                    <select name="balita_identitas_id" id="balita_identitas_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('balita_identitas_id') border-red-500 @enderror">
                        <option value="">-- Pilih Balita --</option>
                        @foreach($balitas as $balita)
                            <option value="{{ $balita->id }}" {{ old('balita_identitas_id') == $balita->id ? 'selected' : '' }}>
                                {{ $balita->nama }} - {{ $balita->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('balita_identitas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="waktu_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Waktu Kunjungan <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="waktu_kunjungan" id="waktu_kunjungan" 
                           value="{{ old('waktu_kunjungan', now()->format('Y-m-d\\TH:i')) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('waktu_kunjungan') border-red-500 @enderror">
                    @error('waktu_kunjungan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan (kg) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="berat_badan" id="berat_badan" 
                           value="{{ old('berat_badan') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror">
                    @error('berat_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="panjang_badan" class="block text-sm font-medium text-gray-700 mb-2">Panjang Badan (cm) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="panjang_badan" id="panjang_badan" 
                           value="{{ old('panjang_badan') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('panjang_badan') border-red-500 @enderror">
                    @error('panjang_badan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700 mb-2">Lingkar Kepala (cm)</label>
                    <input type="number" step="0.01" name="lingkar_kepala" id="lingkar_kepala" 
                           value="{{ old('lingkar_kepala') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('lingkar_kepala') border-red-500 @enderror">
                    @error('lingkar_kepala')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="imunisasi" class="block text-sm font-medium text-gray-700 mb-2">Imunisasi</label>
                    <input type="text" name="imunisasi" id="imunisasi" 
                           value="{{ old('imunisasi') }}" placeholder="Contoh: BCG, Polio 1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('imunisasi') border-red-500 @enderror">
                    @error('imunisasi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="vitamin_a" class="block text-sm font-medium text-gray-700 mb-2">Vitamin A</label>
                    <input type="text" name="vitamin_a" id="vitamin_a" 
                           value="{{ old('vitamin_a') }}" placeholder="Contoh: Kapsul biru"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('vitamin_a') border-red-500 @enderror">
                    @error('vitamin_a')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status_pb_u" class="block text-sm font-medium text-gray-700 mb-2">Status PB/U</label>
                    <input type="text" name="status_pb_u" id="status_pb_u" value="{{ old('status_pb_u') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('status_pb_u') border-red-500 @enderror">
                    @error('status_pb_u')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="status_bb_u" class="block text-sm font-medium text-gray-700 mb-2">Status BB/U</label>
                    <input type="text" name="status_bb_u" id="status_bb_u" value="{{ old('status_bb_u') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('status_bb_u') border-red-500 @enderror">
                    @error('status_bb_u')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status_bb_pb" class="block text-sm font-medium text-gray-700 mb-2">Status BB/PB</label>
                    <input type="text" name="status_bb_pb" id="status_bb_pb" value="{{ old('status_bb_pb') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('status_bb_pb') border-red-500 @enderror">
                    @error('status_bb_pb')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="catatan_kesehatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Kesehatan</label>
                    <input type="text" name="catatan_kesehatan" id="catatan_kesehatan" value="{{ old('catatan_kesehatan') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('catatan_kesehatan') border-red-500 @enderror">
                    @error('catatan_kesehatan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <label for="edukasi" class="block text-sm font-medium text-gray-700 mb-2">Edukasi</label>
                <textarea name="edukasi" id="edukasi" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('edukasi') border-red-500 @enderror">{{ old('edukasi') }}</textarea>
                @error('edukasi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="umur" class="block text-sm font-medium text-gray-700 mb-2">Umur</label>
                    <input type="number" name="umur" id="umur" value="{{ old('umur') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('umur') border-red-500 @enderror">
                </div>
                <div>
                    <label for="naik_tidak_naik" class="block text-sm font-medium text-gray-700 mb-2">Naik/Tidak Naik</label>
                    <input type="text" name="naik_tidak_naik" id="naik_tidak_naik" value="{{ old('naik_tidak_naik') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('naik_tidak_naik') border-red-500 @enderror">
                </div>
                <div>
                    <label for="status_lila" class="block text-sm font-medium text-gray-700 mb-2">Status LILA</label>
                    <input type="text" name="status_lila" id="status_lila" value="{{ old('status_lila') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('status_lila') border-red-500 @enderror">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="lingkar_lengan" class="block text-sm font-medium text-gray-700 mb-2">Lingkar Lengan</label>
                    <input type="number" step="0.01" name="lingkar_lengan" id="lingkar_lengan" value="{{ old('lingkar_lengan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('lingkar_lengan') border-red-500 @enderror">
                </div>
                <div>
                    <label for="batuk" class="block text-sm font-medium text-gray-700 mb-2">Batuk</label>
                    <select name="batuk" id="batuk" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('batuk') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('batuk') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="demam" class="block text-sm font-medium text-gray-700 mb-2">Demam</label>
                    <select name="demam" id="demam" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('demam') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('demam') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="bb_turun" class="block text-sm font-medium text-gray-700 mb-2">BB Turun</label>
                    <select name="bb_turun" id="bb_turun" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('bb_turun') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('bb_turun') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="kontak_tbc" class="block text-sm font-medium text-gray-700 mb-2">Kontak TBC</label>
                    <select name="kontak_tbc" id="kontak_tbc" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('kontak_tbc') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('kontak_tbc') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label for="perkembangan" class="block text-sm font-medium text-gray-700 mb-2">Perkembangan</label>
                    <input type="text" name="perkembangan" id="perkembangan" value="{{ old('perkembangan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('perkembangan') border-red-500 @enderror">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="asi_eksklusif" class="block text-sm font-medium text-gray-700 mb-2">ASI Eksklusif</label>
                    <input type="text" name="asi_eksklusif" id="asi_eksklusif" value="{{ old('asi_eksklusif') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('asi_eksklusif') border-red-500 @enderror">
                </div>
                <div>
                    <label for="mpasi" class="block text-sm font-medium text-gray-700 mb-2">MPASI</label>
                    <input type="text" name="mpasi" id="mpasi" value="{{ old('mpasi') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('mpasi') border-red-500 @enderror">
                </div>
                <div>
                    <label for="obat_cacing" class="block text-sm font-medium text-gray-700 mb-2">Obat Cacing</label>
                    <input type="text" name="obat_cacing" id="obat_cacing" value="{{ old('obat_cacing') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('obat_cacing') border-red-500 @enderror">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="mt_pangan" class="block text-sm font-medium text-gray-700 mb-2">MT Pangan</label>
                    <input type="text" name="mt_pangan" id="mt_pangan" value="{{ old('mt_pangan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('mt_pangan') border-red-500 @enderror">
                </div>
                <div>
                    <label for="rujukan" class="block text-sm font-medium text-gray-700 mb-2">Rujukan</label>
                    <input type="text" name="rujukan" id="rujukan" value="{{ old('rujukan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('rujukan') border-red-500 @enderror">
                </div>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-gradient-to-r from-indigo-500  to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Simpan
                </button>
                <a href="{{ route('pemeriksaan-balita.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
