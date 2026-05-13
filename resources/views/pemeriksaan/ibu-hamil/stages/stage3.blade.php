@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Ibu Hamil - Tahap 3</h2>
        <p class="text-gray-600 mt-1">Skrining TBC & Pelayanan Kesehatan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="hover:text-purple-600">Pemeriksaan Ibu Hamil</a>
            <span class="mx-2">/</span>
            <span>Tahap 3</span>
        </nav>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 3/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-purple-600 h-2 rounded-full" style="width: 75%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-ibu-hamil.stage-store', ['stage' => 3, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" method="POST">
            @csrf

            @if($pemeriksaan)
                <input type="hidden" name="ibu_hamil_identitas_id" value="{{ $pemeriksaan->ibu_hamil_identitas_id }}">
                <input type="hidden" name="tanggal_kunjungan" value="{{ optional($pemeriksaan->tanggal_kunjungan)->format('Y-m-d') ?? $pemeriksaan->tanggal_kunjungan }}">

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-green-900 font-medium">Melanjutkan pemeriksaan untuk {{ $pemeriksaan->ibuHamil->nama ?? '-' }}. Data ibu hamil dan tanggal kunjungan sudah dikunci dari tahap sebelumnya.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="ibu_hamil_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Ibu Hamil <span class="text-red-500">*</span>
                        </label>
                        <select name="ibu_hamil_identitas_id" id="ibu_hamil_identitas_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('ibu_hamil_identitas_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Ibu Hamil --</option>
                            @foreach($ibuHamils as $ibuHamil)
                                <option value="{{ $ibuHamil->id }}" {{ (old('ibu_hamil_identitas_id', $data['ibu_hamil_identitas_id'] ?? null)) == $ibuHamil->id ? 'selected' : '' }}>
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
                               value="{{ old('tanggal_kunjungan', $data['tanggal_kunjungan'] ?? date('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Tahap 1 & 2 -->
            @if($data)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-blue-900 mb-3">Data dari Tahap Sebelumnya</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                    <div>
                        <p class="text-blue-700 font-medium">Usia Kehamilan</p>
                        <p class="text-blue-900">{{ $data['usia_kehamilan'] ?? '-' }} minggu</p>
                    </div>
                    <div>
                        <p class="text-blue-700 font-medium">Berat Badan</p>
                        <p class="text-blue-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                    </div>
                    <div>
                        <p class="text-blue-700 font-medium">Tekanan Darah</p>
                        <p class="text-blue-900">{{ $data['tekanan_darah'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-blue-700 font-medium">Status TD</p>
                        <p class="text-blue-900">{{ $data['status_tekanan_darah'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Skrining TBC</h3>
                <p class="text-sm text-gray-600 mb-4">Jika 2 gejala terpenuhi maka dirujuk ke fasilitas kesehatan.</p>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="tb_skrining_batuk" id="tb_skrining_batuk" value="1"
                               {{ ($data['tb_skrining_batuk'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                        <label for="tb_skrining_batuk" class="ml-2 text-sm text-gray-700">
                            Batuk terus menerus
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="tb_skrining_demam" id="tb_skrining_demam" value="1"
                               {{ ($data['tb_skrining_demam'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                        <label for="tb_skrining_demam" class="ml-2 text-sm text-gray-700">
                            Demam
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="tb_skrining_bb_turun" id="tb_skrining_bb_turun" value="1"
                               {{ ($data['tb_skrining_bb_turun'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                        <label for="tb_skrining_bb_turun" class="ml-2 text-sm text-gray-700">
                            BB turun
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="tb_skrining_kontak" id="tb_skrining_kontak" value="1"
                               {{ ($data['tb_skrining_kontak'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                        <label for="tb_skrining_kontak" class="ml-2 text-sm text-gray-700">
                            Kontak TBC
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="tb_skrining_hasil" class="block text-sm font-medium text-gray-700 mb-2">
                        Hasil Skrining TBC
                    </label>
                    <select name="tb_skrining_hasil" id="tb_skrining_hasil"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tb_skrining_hasil') border-red-500 @enderror">
                        <option value="">-- Pilih Hasil --</option>
                        <option value="Ya" {{ ($data['tb_skrining_hasil'] ?? null) === 'Ya' ? 'selected' : '' }}>Ya (Curiga TBC)</option>
                        <option value="Tidak" {{ ($data['tb_skrining_hasil'] ?? null) === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        <option value="Dirujuk" {{ ($data['tb_skrining_hasil'] ?? null) === 'Dirujuk' ? 'selected' : '' }}>Dirujuk</option>
                    </select>
                    @error('tb_skrining_hasil')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pelayanan Kesehatan</h3>

                <div class="space-y-4">
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="tablet_tambah_darah" id="tablet_tambah_darah" value="1"
                               {{ ($data['tablet_tambah_darah'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                        <label for="tablet_tambah_darah" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Pemberian Tablet Tambah Darah
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="pmt_bumil" id="pmt_bumil" value="1"
                               {{ ($data['pmt_bumil'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                        <label for="pmt_bumil" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            PMT Bumil (Pemakanan Tambahan Ibu Hamil)
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="kelas_ibu_hamil" id="kelas_ibu_hamil" value="1"
                               {{ ($data['kelas_ibu_hamil'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                        <label for="kelas_ibu_hamil" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Ikut Kelas Ibu Hamil
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-ibu-hamil.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-ibu-hamil.stage', ['stage' => 2, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 2
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-purple-600 hover:bg-purple-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 4
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
