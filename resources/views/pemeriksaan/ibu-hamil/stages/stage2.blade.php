@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Ibu Hamil - Tahap 2</h2>
        <p class="text-gray-600 mt-1">Pemeriksaan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="hover:text-purple-600">Pemeriksaan Ibu Hamil</a>
            <span class="mx-2">/</span>
            <span>Tahap 2</span>
        </nav>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 2/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-purple-600 h-2 rounded-full" style="width: 50%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-ibu-hamil.stage-store', ['stage' => 2, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" method="POST">
            @csrf

            @if($pemeriksaan)
                <input type="hidden" name="ibu_hamil_identitas_id" value="{{ $pemeriksaan->ibu_hamil_identitas_id }}">
                <input type="hidden" name="tanggal_kunjungan" value="{{ optional($pemeriksaan->tanggal_kunjungan)->format('Y-m-d') ?? $pemeriksaan->tanggal_kunjungan }}">

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-green-900 font-medium">Melanjutkan pemeriksaan untuk {{ $pemeriksaan->ibuHamil->nama ?? '-' }}. Data ibu hamil dan tanggal kunjungan sudah dikunci dari tahap sebelumnya.</p>
                </div>
            @else
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <label for="search_ibu" class="block text-sm font-medium text-gray-700 mb-2">
                        Cari Ibu Hamil
                    </label>
                    <input type="text" id="search_ibu" placeholder="Ketik nama atau NIK ibu hamil..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent mb-3">
                    <p class="text-xs text-gray-500">Total: <span id="total_ibu">{{ count($ibuHamils) }}</span> ibu hamil</p>
                </div>

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

            <!-- Summary dari Tahap 1 -->
            @if($data)
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-purple-900 mb-3">Data dari Tahap 1</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-sm">
                    <div>
                        <p class="text-purple-700 font-medium">Usia Kehamilan</p>
                        <p class="text-purple-900">{{ $data['usia_kehamilan'] ?? '-' }} minggu</p>
                    </div>
                    <div>
                        <p class="text-purple-700 font-medium">Berat Badan</p>
                        <p class="text-purple-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                    </div>
                    <div>
                        <p class="text-purple-700 font-medium">LILA</p>
                        <p class="text-purple-900">{{ $data['lingkar_lengan'] ?? '-' }} cm</p>
                    </div>
                    <div>
                        <p class="text-purple-700 font-medium">Status BB</p>
                        <p class="text-purple-900">{{ $data['status_bb'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-purple-700 font-medium">Status LILA</p>
                        <p class="text-purple-900">{{ $data['status_lila'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Pemeriksaan</h3>

                @php
                    $tekananDarah = $data['tekanan_darah'] ?? '';
                    $partsTekananDarah = strpos($tekananDarah, '/') !== false ? explode('/', $tekananDarah) : ['', ''];
                    $defaultSistole = trim($partsTekananDarah[0] ?? '');
                    $defaultDiastole = trim($partsTekananDarah[1] ?? '');
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="sistole" class="block text-sm font-medium text-gray-700 mb-2">
                            Sistole (mmHg)
                        </label>
                        <input type="number" name="sistole" id="sistole"
                               value="{{ old('sistole', $defaultSistole) }}" min="50" max="260"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sistole') border-red-500 @enderror">
                        @error('sistole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="diastole" class="block text-sm font-medium text-gray-700 mb-2">
                            Diastole (mmHg)
                        </label>
                        <input type="number" name="diastole" id="diastole"
                               value="{{ old('diastole', $defaultDiastole) }}" min="30" max="180"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('diastole') border-red-500 @enderror">
                        @error('diastole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="status_tekanan_darah_display" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Tekanan Darah (Otomatis)
                    </label>
                    <input type="text" id="status_tekanan_darah_display"
                           value="{{ $data['status_tekanan_darah'] ?? '-' }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700"
                           readonly>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-ibu-hamil.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-ibu-hamil.stage', ['stage' => 1, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 1
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-purple-600 hover:bg-purple-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 3
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sistoleInput = document.getElementById('sistole');
        const diastoleInput = document.getElementById('diastole');
        const statusDisplay = document.getElementById('status_tekanan_darah_display');

        function updateStatusTekananDarah() {
            const sistole = parseInt(sistoleInput.value, 10);
            const diastole = parseInt(diastoleInput.value, 10);

            if (isNaN(sistole) || isNaN(diastole)) {
                statusDisplay.value = '-';
                return;
            }

            if (sistole >= 140 || diastole >= 90) {
                statusDisplay.value = 'Tinggi';
                return;
            }

            if (sistole < 90 || diastole < 60) {
                statusDisplay.value = 'Rendah';
                return;
            }

            statusDisplay.value = 'Normal';
        }

        if (sistoleInput) sistoleInput.addEventListener('input', updateStatusTekananDarah);
        if (diastoleInput) diastoleInput.addEventListener('input', updateStatusTekananDarah);

        updateStatusTekananDarah();

        // Search functionality
        const searchInput = document.getElementById('search_ibu');
        const selectDropdown = document.getElementById('ibu_hamil_identitas_id');
        const totalCount = document.getElementById('total_ibu');

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
@endpush
@endsection
