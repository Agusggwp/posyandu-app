@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Ibu Hamil - Tahap 4</h2>
        <p class="text-gray-600 mt-1">Edukasi & Rujukan</p>
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
                            <div class="flex justify-between">
                                <span class="text-gray-600">Skrining TBC:</span>
                                <span class="font-medium">{{ $data['tb_skrining_hasil'] ?? '-' }}</span>
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

            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-ibu-hamil.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                <a href="{{ route('pemeriksaan-ibu-hamil.stage', ['stage' => 3, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 3
                </a>
                <button type="submit" class="px-6 py-2 text-white bg-purple-600 hover:bg-purple-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Selesaikan Pemeriksaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
