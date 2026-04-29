@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Ibu Hamil - Tahap 4</h2>
        <p class="text-gray-600 mt-1">Edukasi & Rujukan + Ringkasan Data</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="hover:text-purple-600">Pemeriksaan Ibu Hamil</a>
            <span class="mx-2">/</span>
            <span>Tahap 4</span>
        </nav>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 4/4 - Final</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-purple-600 h-2 rounded-full" style="width: 100%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-ibu-hamil.stage-store', ['stage' => 4, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" method="POST">
            @csrf

            <input type="hidden" name="ibu_hamil_identitas_id" value="{{ $pemeriksaan->ibu_hamil_identitas_id ?? ($data['ibu_hamil_identitas_id'] ?? '') }}">
            <input type="hidden" name="tanggal_kunjungan" value="{{ optional($pemeriksaan->tanggal_kunjungan ?? null)->format('Y-m-d') ?? ($data['tanggal_kunjungan'] ?? '') }}">

            <!-- Summary dari Semua Tahap -->
            @if($data)
            <div class="bg-gradient-to-r from-purple-50 to-blue-50 border border-purple-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Ringkasan Data Pemeriksaan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tahap 1 -->
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h4 class="font-semibold text-purple-900 mb-3">Tahap 1: Penimbangan & Pengukuran</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Usia Kehamilan:</span>
                                <span class="font-medium">{{ $data['usia_kehamilan'] ?? '-' }} minggu</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Berat Badan:</span>
                                <span class="font-medium">{{ $data['berat_badan'] ?? '-' }} kg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">LILA:</span>
                                <span class="font-medium">{{ $data['lingkar_lengan'] ?? '-' }} cm</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status BB:</span>
                                <span class="font-medium">{{ $data['status_bb'] ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status LILA:</span>
                                <span class="font-medium">{{ $data['status_lila'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tahap 2 -->
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="font-semibold text-blue-900 mb-3">Tahap 2: Pemeriksaan</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tekanan Darah:</span>
                                <span class="font-medium">{{ $data['tekanan_darah'] ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status TD:</span>
                                <span class="font-medium">{{ $data['status_tekanan_darah'] ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Skrining TBC:</span>
                                <span class="font-medium">{{ $data['tb_skrining_hasil'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tahap 3 -->
                    <div class="border-l-4 border-green-500 pl-4">
                        <h4 class="font-semibold text-green-900 mb-3">Tahap 3: Pelayanan Kesehatan</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tablet Tambah Darah:</span>
                                <span class="font-medium">{{ $data['tablet_tambah_darah'] ? '✓ Ya' : '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">PMT Bumil:</span>
                                <span class="font-medium">{{ $data['pmt_bumil'] ? '✓ Ya' : '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kelas Ibu Hamil:</span>
                                <span class="font-medium">{{ $data['kelas_ibu_hamil'] ? '✓ Ya' : '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Lainnya -->
                    <div class="border-l-4 border-orange-500 pl-4">
                        <h4 class="font-semibold text-orange-900 mb-3">Informasi Tambahan</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Kunjungan:</span>
                                <span class="font-medium">{{ $data['tanggal_kunjungan'] ? \Carbon\Carbon::parse($data['tanggal_kunjungan'])->format('d M Y') : '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Waktu ke Posyandu:</span>
                                <span class="font-medium">{{ $data['waktu_ke_posyandu'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Edukasi & Rujukan</h3>

                <div class="mb-6">
                    <label for="edukasi" class="block text-sm font-medium text-gray-700 mb-2">
                        Edukasi
                    </label>
                    <textarea name="edukasi" id="edukasi" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('edukasi') border-red-500 @enderror"
                              placeholder="Catatan edukasi untuk ibu hamil...">{{ $data['edukasi'] ?? '' }}</textarea>
                    @error('edukasi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rujukan" class="block text-sm font-medium text-gray-700 mb-2">
                        Rujukan
                    </label>
                    <select name="rujukan" id="rujukan"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('rujukan') border-red-500 @enderror">
                        <option value="Tidak" {{ ($data['rujukan'] ?? 'Tidak') === 'Tidak' ? 'selected' : '' }}>Tidak Ada Rujukan</option>
                        <option value="Pustu" {{ ($data['rujukan'] ?? null) === 'Pustu' ? 'selected' : '' }}>Pustu</option>
                        <option value="Puskesmas" {{ ($data['rujukan'] ?? null) === 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                        <option value="Rumah Sakit" {{ ($data['rujukan'] ?? null) === 'Rumah Sakit' ? 'selected' : '' }}>Rumah Sakit</option>
                    </select>
                    @error('rujukan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Data Tambahan -->
            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Tambahan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="denyut_jantung" class="block text-sm font-medium text-gray-700 mb-2">
                            Denyut Jantung
                        </label>
                        <input type="text" name="denyut_jantung" id="denyut_jantung"
                               value="{{ $data['denyut_jantung'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('denyut_jantung') border-red-500 @enderror">
                        @error('denyut_jantung')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kondisi_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                            Kondisi Ibu
                        </label>
                        <input type="text" name="kondisi_ibu" id="kondisi_ibu"
                               value="{{ $data['kondisi_ibu'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('kondisi_ibu') border-red-500 @enderror">
                        @error('kondisi_ibu')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="keluhan" class="block text-sm font-medium text-gray-700 mb-2">
                            Keluhan
                        </label>
                        <input type="text" name="keluhan" id="keluhan"
                               value="{{ $data['keluhan'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('keluhan') border-red-500 @enderror">
                        @error('keluhan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="waktu_ke_posyandu" class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu ke Posyandu
                        </label>
                        <input type="time" name="waktu_ke_posyandu" id="waktu_ke_posyandu"
                               value="{{ $data['waktu_ke_posyandu'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('waktu_ke_posyandu') border-red-500 @enderror">
                        @error('waktu_ke_posyandu')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="petugas" class="block text-sm font-medium text-gray-700 mb-2">
                            Petugas
                        </label>
                        <input type="text" name="petugas" id="petugas"
                               value="{{ $data['petugas'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('petugas') border-red-500 @enderror">
                        @error('petugas')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan
                    </label>
                    <textarea name="catatan" id="catatan" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('catatan') border-red-500 @enderror"
                              placeholder="Catatan tambahan...">{{ $data['catatan'] ?? '' }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
                <a href="{{ route('pemeriksaan-ibu-hamil.create') }}" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
                <a href="{{ route('pemeriksaan-ibu-hamil.stage', ['stage' => 3, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Kembali ke Tahap 3
                </a>
                <button type="submit" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Simpan Tahap 4
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
