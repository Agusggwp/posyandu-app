@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Nifas - Tahap 1</h2>
        <p class="text-gray-600 mt-1">Penimbangan & Pengukuran</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-nifas.index') }}" class="hover:text-rose-600">Pemeriksaan Nifas</a>
            <span class="mx-2">/</span>
            <span>Tahap 1</span>
        </nav>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 1/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-violet-600 h-2 rounded-full" style="width: 25%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-nifas.stage-store', 1) }}" method="POST">
            @csrf

            <!-- Hidden Fields jika lanjut -->
            @if($pemeriksaan)
            <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                <p class="text-green-800 font-semibold">Melanjutkan Pemeriksaan untuk: {{ $pemeriksaan->nifas->nama_ibu }}</p>
                <p class="text-green-700 text-sm mt-2">Data ibu nifas dan tanggal kunjungan sudah dikunci dan tidak dapat diubah.</p>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                @if(!$pemeriksaan)
                <div>
                    <label for="nifas_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Ibu Nifas <span class="text-red-500">*</span>
                    </label>
                    <select name="nifas_identitas_id" id="nifas_identitas_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('nifas_identitas_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Ibu Nifas --</option>
                        @foreach($nifases as $nifas)
                            <option value="{{ $nifas->id }}" {{ ($data['nifas_identitas_id'] ?? null) == $nifas->id ? 'selected' : '' }}>
                                {{ $nifas->nama_ibu }} - {{ $nifas->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('nifas_identitas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                @else
                <input type="hidden" name="nifas_identitas_id" value="{{ $pemeriksaan->nifas_identitas_id }}">
                @endif

                <div>
                    <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Kunjungan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                           value="{{ $pemeriksaan->tanggal_kunjungan ?? ($data['tanggal_kunjungan'] ?? date('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required @if($pemeriksaan) readonly @endif>
                    @error('tanggal_kunjungan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Pengukuran</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat Badan (kg)
                        </label>
                        <input type="number" step="0.1" name="berat_badan" id="berat_badan"
                               value="{{ $pemeriksaan->berat_badan ?? ($data['berat_badan'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror"
                               min="0">
                        @error('berat_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="naik_turun" class="block text-sm font-medium text-gray-700 mb-2">
                            Status BB (Naik/Turun)
                        </label>
                        <select name="naik_turun" id="naik_turun" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                            <option value="">-- Pilih --</option>
                            <option value="Naik" {{ ($pemeriksaan->naik_turun ?? $data['naik_turun'] ?? '') == 'Naik' ? 'selected' : '' }}>Naik</option>
                            <option value="Turun" {{ ($pemeriksaan->naik_turun ?? $data['naik_turun'] ?? '') == 'Turun' ? 'selected' : '' }}>Turun</option>
                            <option value="Tetap" {{ ($pemeriksaan->naik_turun ?? $data['naik_turun'] ?? '') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                        </select>
                    </div>

                    <div>
                        <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tinggi Badan (cm)
                        </label>
                        <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan"
                               value="{{ $pemeriksaan->tinggi_badan ?? ($data['tinggi_badan'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('tinggi_badan') border-red-500 @enderror"
                               min="0">
                        @error('tinggi_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lila" class="block text-sm font-medium text-gray-700 mb-2">
                            LILA / Lingkar Lengan Atas (cm)
                        </label>
                        <input type="number" step="0.1" name="lila" id="lila"
                               value="{{ $pemeriksaan->lila ?? ($data['lila'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent @error('lila') border-red-500 @enderror"
                               min="0" max="100">
                        <p class="text-xs text-gray-500 mt-1">Status: <span id="status_lila">-</span></p>
                        @error('lila')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status_gizi" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Gizi (otomatis)
                        </label>
                        <input type="text" name="status_gizi" id="status_gizi"
                               value="{{ $pemeriksaan->status_gizi ?? ($data['status_gizi'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                               readonly>
                        <p class="text-xs text-gray-500 mt-1">Hijau ≥23.5 | Kuning 23.0-23.4 | Merah &lt;23.0</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-nifas.create') }}" class="px-6 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2 text-white bg-violet-600 hover:bg-violet-700 rounded-lg font-medium transition">
                    Simpan Tahap 1
                </button>
                <a href="{{ route('pemeriksaan-nifas.create') }}" class="px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('lila').addEventListener('input', function() {
    const lila = parseFloat(this.value);
    let status = '-';
    
    if (lila >= 23.5) {
        status = 'Hijau (Normal)';
    } else if (lila >= 23.0) {
        status = 'Kuning (Kurang)';
    } else if (lila > 0) {
        status = 'Merah (Buruk)';
    }
    
    document.getElementById('status_lila').textContent = status;
    document.getElementById('status_gizi').value = status.split(' ')[0] || '';
});
</script>
@endsection
