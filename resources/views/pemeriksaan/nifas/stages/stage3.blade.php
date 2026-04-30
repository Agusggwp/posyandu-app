@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Nifas - Tahap 3</h2>
        <p class="text-gray-600 mt-1">Pelayanan Kesehatan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-nifas.index') }}" class="hover:text-emerald-600">Pemeriksaan Nifas</a>
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
            <div class="bg-emerald-600 h-2 rounded-full" style="width: 75%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-nifas.stage-store', 3) }}" method="POST">
            @csrf

            @if($pemeriksaan)
                <input type="hidden" name="nifas_identitas_id" value="{{ $pemeriksaan->nifas_identitas_id }}">
                <input type="hidden" name="tanggal_kunjungan" value="{{ optional($pemeriksaan->tanggal_kunjungan)->format('Y-m-d') ?? $pemeriksaan->tanggal_kunjungan }}">
                <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-green-900 font-medium">Melanjutkan pemeriksaan untuk {{ $pemeriksaan->nifas->nama_ibu ?? '-' }}. Data ibu nifas dan tanggal kunjungan sudah dikunci dari tahap sebelumnya.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nifas_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Ibu Nifas <span class="text-red-500">*</span>
                        </label>
                        <select name="nifas_identitas_id" id="nifas_identitas_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('nifas_identitas_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Ibu Nifas --</option>
                            @foreach($nifases as $nifas)
                                <option value="{{ $nifas->id }}" {{ (old('nifas_identitas_id', $data['nifas_identitas_id'] ?? null)) == $nifas->id ? 'selected' : '' }}>
                                    {{ $nifas->nama_ibu }} - {{ $nifas->nik }}
                                </option>
                            @endforeach
                        </select>
                        @error('nifas_identitas_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                               value="{{ old('tanggal_kunjungan', $data['tanggal_kunjungan'] ?? date('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Tahap 1 & 2 -->
            @if($data)
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-green-900 mb-3">Data dari Tahap Sebelumnya</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                    <div>
                        <p class="text-green-700 font-medium">Berat Badan</p>
                        <p class="text-green-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                    </div>
                    <div>
                        <p class="text-green-700 font-medium">Tekanan Darah</p>
                        <p class="text-green-900">{{ $data['sistole'] ?? '-' }}/{{ $data['diastole'] ?? '-' }} mmHg</p>
                    </div>
                    <div>
                        <p class="text-green-700 font-medium">Status TD</p>
                        <p class="text-green-900">{{ $data['tekanan_darah_status'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-green-700 font-medium">Skrining TBC</p>
                        <p class="text-green-900">{{ $data['status_tbc'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pelayanan Kesehatan</h3>

                <div class="space-y-4">
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="vitamin_a" id="vitamin_a" value="1"
                               {{ ($data['vitamin_a'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500">
                        <label for="vitamin_a" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Pemberian Vitamin A
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="menyusui" id="menyusui" value="1"
                               {{ ($data['menyusui'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500">
                        <label for="menyusui" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Konsultasi & Dukungan Menyusui
                        </label>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg">
                        <label for="kb" class="text-sm font-medium text-gray-700 mb-2 block">
                            Mengikuti KB pasca salin
                        </label>
                        <select name="kb" id="kb"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('kb') border-red-500 @enderror">
                            <option value="">-- Pilih Jenis KB --</option>
                            <option value="Pil" {{ ($data['kb'] ?? null) === 'Pil' ? 'selected' : '' }}>Pil</option>
                            <option value="Kondom" {{ ($data['kb'] ?? null) === 'Kondom' ? 'selected' : '' }}>Kondom</option>
                            <option value="Suntik" {{ ($data['kb'] ?? null) === 'Suntik' ? 'selected' : '' }}>Suntik</option>
                            <option value="IUD" {{ ($data['kb'] ?? null) === 'IUD' ? 'selected' : '' }}>IUD</option>
                            <option value="Implan" {{ ($data['kb'] ?? null) === 'Implan' ? 'selected' : '' }}>Implan</option>
                            <option value="Lain-lain" {{ ($data['kb'] ?? null) === 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                        </select>
                        @error('kb')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3 pt-6 border-t">
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-nifas.stage', ['stage' => 2, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
                    ← Kembali
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg font-medium transition">
                    Simpan Tahap 3
                </button>
                <a href="{{ route('pemeriksaan-nifas.create') }}" class="px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
