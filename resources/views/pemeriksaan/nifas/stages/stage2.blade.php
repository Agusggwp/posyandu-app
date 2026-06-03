@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Nifas - Tahap 2</h2>
        <p class="text-gray-600 mt-1">Pemeriksaan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-nifas.index') }}" class="hover:text-blue-600">Pemeriksaan Nifas</a>
            <span class="mx-2">/</span>
            <span>Tahap 2</span>
        </nav>
                    <div>
                        <p class="text-blue-700 font-medium">Status LILA</p>
    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 2/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-blue-600 h-2 rounded-full" style="width: 50%"></div>
        </div>
    </div>

    <!-- Info Box jika melanjutkan -->
    @if($pemeriksaan)
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
        <p class="text-green-800 font-semibold">Melanjutkan Pemeriksaan untuk: {{ $pemeriksaan->nifas->nama_ibu }}</p>
        <p class="text-green-700 text-sm mt-2">Data ibu nifas dan tanggal kunjungan sudah dikunci dan tidak dapat diubah.</p>
    </div>
    @endif

    <!-- Summary Tahap 1 -->
    @if($pemeriksaan || (isset($data['berat_badan']) || isset($data['naik_turun'])))
    <div class="mb-6 p-4 bg-purple-50 border-l-4 border-purple-500 rounded">
        <h4 class="font-semibold text-purple-800 mb-3">📊 Ringkasan Tahap 1: Penimbangan & Pengukuran</h4>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm">
            <div>
                <p class="text-gray-600">Berat Badan:</p>
                <p class="font-semibold">{{ $pemeriksaan->berat_badan ?? $data['berat_badan'] ?? '-' }} kg</p>
            </div>
            <div>
                <p class="text-gray-600">Status BB:</p>
                <p class="font-semibold">{{ $pemeriksaan->naik_turun ?? $data['naik_turun'] ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-600">Tinggi Badan:</p>
                <p class="font-semibold">{{ $pemeriksaan->tinggi_badan ?? $data['tinggi_badan'] ?? '-' }} cm</p>
            </div>
            <div>
                <p class="text-gray-600">LILA:</p>
                <p class="font-semibold">{{ $pemeriksaan->lila ?? $data['lila'] ?? '-' }} cm</p>
            </div>
            <div>
                <p class="text-gray-600">Status LILA:</p>
                <p class="font-semibold">{{ $pemeriksaan->status_gizi ?? $data['status_gizi'] ?? '-' }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-nifas.stage-store', 2) }}" method="POST">
            @csrf

            @if($pemeriksaan)
                <input type="hidden" name="nifas_identitas_id" value="{{ $pemeriksaan->nifas_identitas_id }}">
                <input type="hidden" name="tanggal_kunjungan" value="{{ optional($pemeriksaan->tanggal_kunjungan)->format('Y-m-d') ?? $pemeriksaan->tanggal_kunjungan }}">
                <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-green-900 font-medium">Melanjutkan pemeriksaan untuk {{ $pemeriksaan->nifas->nama_ibu ?? '-' }}. Data ibu nifas dan tanggal kunjungan sudah dikunci dari tahap sebelumnya.</p>
                </div>
            @else
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <label for="search_nifas" class="block text-sm font-medium text-gray-700 mb-2">
                        Cari Ibu Nifas
                    </label>
                    <input type="text" id="search_nifas" placeholder="Ketik nama atau NIK ibu nifas..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-3">
                    <p class="text-xs text-gray-500">Total: <span id="total_nifas">{{ count($nifases ?? []) }}</span> ibu nifas</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nifas_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Ibu Nifas <span class="text-red-500">*</span>
                        </label>
                        <select name="nifas_identitas_id" id="nifas_identitas_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nifas_identitas_id') border-red-500 @enderror" required>
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Tahap 1 -->
            @if($data)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-blue-900 mb-3">Data dari Tahap 1</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                    <div>
                        <p class="text-blue-700 font-medium">Berat Badan</p>
                        <p class="text-blue-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                    </div>
                    <div>
                        <p class="text-blue-700 font-medium">LILA</p>
                        <p class="text-blue-900">{{ $data['lila'] ?? '-' }} cm</p>
                    </div>
                    <div>
                        <p class="text-blue-700 font-medium">Status LILA</p>
                        <p class="text-blue-900">{{ $data['status_gizi'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Pemeriksaan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="sistole" class="block text-sm font-medium text-gray-700 mb-2">
                            Sistole (mmHg)
                        </label>
                        <input type="number" name="sistole" id="sistole"
                               value="{{ $data['sistole'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sistole') border-red-500 @enderror"
                               min="0" max="300">
                        @error('sistole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="diastole" class="block text-sm font-medium text-gray-700 mb-2">
                            Diastole (mmHg)
                        </label>
                        <input type="number" name="diastole" id="diastole"
                               value="{{ $data['diastole'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('diastole') border-red-500 @enderror"
                               min="0" max="300">
                        @error('diastole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tekanan_darah_status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Tekanan Darah
                        </label>
                        <input type="text" name="tekanan_darah_status" id="tekanan_darah_status"
                               value="{{ $data['tekanan_darah_status'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                               readonly>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-nifas.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-nifas.stage', ['stage' => 1, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 1
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-rose-600 hover:bg-rose-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 3
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateTekananDarahStatus() {
        const sistole = parseInt(document.querySelector('input[name="sistole"]').value) || 0;
        const diastole = parseInt(document.querySelector('input[name="diastole"]').value) || 0;
        
        let status = '';
        if (sistole < 90 || diastole < 60) {
            status = 'Rendah';
        } else if ((sistole >= 90 && sistole <= 120) || (diastole >= 60 && diastole <= 80)) {
            status = 'Normal';
        } else {
            status = 'Tinggi';
        }
        
        document.querySelector('input[name="tekanan_darah_status"]').value = status;
    }
    
    document.querySelector('input[name="sistole"]')?.addEventListener('input', updateTekananDarahStatus);
    document.querySelector('input[name="diastole"]')?.addEventListener('input', updateTekananDarahStatus);
    
    updateTekananDarahStatus();

    // Search functionality
    const searchInput = document.getElementById('search_nifas');
    const selectDropdown = document.getElementById('nifas_identitas_id');
    const totalCount = document.getElementById('total_nifas');

    if (searchInput && selectDropdown) {
        const allOptions = Array.from(selectDropdown.options).map(opt => ({
            value: opt.value,
            text: opt.text,
            element: opt
        }));

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let visibleCount = 0;

            allOptions.forEach(opt => {
                if (opt.value === '') {
                    opt.element.style.display = '';
                    return;
                }

                const isMatch = opt.text.toLowerCase().includes(searchTerm);
                opt.element.style.display = isMatch ? '' : 'none';
                if (isMatch) visibleCount++;
            });

            totalCount.textContent = visibleCount;
        });
    }
});
</script>
@endsection
