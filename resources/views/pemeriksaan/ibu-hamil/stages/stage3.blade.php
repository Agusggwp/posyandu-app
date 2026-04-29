@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Ibu Hamil - Tahap 3</h2>
        <p class="text-gray-600 mt-1">Pelayanan Kesehatan</p>
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

            <input type="hidden" name="ibu_hamil_identitas_id" value="{{ $pemeriksaan->ibu_hamil_identitas_id ?? ($data['ibu_hamil_identitas_id'] ?? '') }}">
            <input type="hidden" name="tanggal_kunjungan" value="{{ optional($pemeriksaan->tanggal_kunjungan ?? null)->format('Y-m-d') ?? ($data['tanggal_kunjungan'] ?? '') }}">

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

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
                <a href="{{ route('pemeriksaan-ibu-hamil.create') }}" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Batal
                </a>
                <a href="{{ route('pemeriksaan-ibu-hamil.stage', ['stage' => 2, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Kembali ke Tahap 2
                </a>
                <button type="submit" class="bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                    Simpan Tahap 3
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
