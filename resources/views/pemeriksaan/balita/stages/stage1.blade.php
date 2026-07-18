@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Balita - Tahap 1</h2>
        <p class="text-gray-600 mt-1">Penimbangan & Pengukuran</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-teal-600">Pemeriksaan Balita</a>
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
            <div class="bg-teal-600 h-2 rounded-full" style="width: 25%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-balita.stage-store', 1) }}" method="POST">
            @csrf

            @if($pemeriksaan)
                <input type="hidden" id="balita_identitas_id" name="balita_identitas_id" value="{{ $pemeriksaan->balita_identitas_id }}">
                <input type="hidden" name="tanggal_kunjungan" value="{{ optional($pemeriksaan->tanggal_kunjungan)->format('Y-m-d') ?? $pemeriksaan->tanggal_kunjungan }}">
                <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-green-900 font-medium">Melanjutkan pemeriksaan untuk {{ $pemeriksaan->balita->nama_bayi ?? '-' }}. Data balita dan tanggal kunjungan sudah dikunci dari tahap sebelumnya.</p>
                </div>
            @else
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <label for="search_balita" class="block text-sm font-medium text-gray-700 mb-2">
                        Cari Balita <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" id="search_balita" placeholder="Ketik nama atau NIK balita..." autocomplete="off"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent mb-1 @error('balita_identitas_id') border-red-500 @enderror">
                        <div id="suggestions_balita" class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden">
                            <!-- suggestions will be populated here -->
                        </div>
                    </div>
                    @error('balita_identitas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">Total: <span id="total_balita">{{ count($balitas) }}</span> balita</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="hidden">
                        <select name="balita_identitas_id" id="balita_identitas_id" required>
                            <option value="">-- Pilih Balita --</option>
                            @foreach($balitas as $balita)
                                <option value="{{ $balita->id }}" {{ (old('balita_identitas_id', $data['balita_identitas_id'] ?? null)) == $balita->id ? 'selected' : '' }}>
                                    {{ $balita->nama_bayi }} - {{ $balita->nik }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                               value="{{ old('tanggal_kunjungan', $data['tanggal_kunjungan'] ?? date('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Penimbangan & Pengukuran</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat Badan (kg) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="berat_badan" id="berat_badan"
                               value="{{ $data['berat_badan'] ?? '' }}" step="0.1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror"
                               required>
                        @error('berat_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="previous_weight" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat Sebelumnya
                        </label>
                        <div id="previous_weight" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-slate-50 text-gray-800">
                            @if($pemeriksaan)
                                @php
                                    $prev = \App\Models\PemeriksaanBalita::where('balita_identitas_id', $pemeriksaan->balita_identitas_id)
                                        ->where('id', '!=', $pemeriksaan->id)
                                        ->whereNotNull('berat_badan')
                                        ->whereNotNull('tanggal_kunjungan')
                                        ->orderByDesc('tanggal_kunjungan')
                                        ->first();
                                @endphp
                                @if($prev)
                                    Terakhir tercatat {{ number_format($prev->berat_badan, 1) }} kg pada {{ \Carbon\Carbon::parse($prev->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                @else
                                    Belum ada pemeriksaan sebelumnya untuk balita ini.
                                @endif
                            @else
                                Pilih balita untuk melihat data pemeriksaan sebelumnya.
                            @endif
                        </div>
                    </div>

                    <div>
                        <label for="panjang_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tinggi Badan (cm) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="panjang_badan" id="panjang_badan"
                               value="{{ $data['panjang_badan'] ?? '' }}" step="0.1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('panjang_badan') border-red-500 @enderror"
                               required>
                        @error('panjang_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700 mb-2">
                            Lingkar Kepala (cm)
                        </label>
                        <input type="number" name="lingkar_kepala" id="lingkar_kepala"
                               value="{{ $data['lingkar_kepala'] ?? '' }}" step="0.1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('lingkar_kepala') border-red-500 @enderror">
                        @error('lingkar_kepala')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lingkar_lengan" class="block text-sm font-medium text-gray-700 mb-2">
                            LILA / Lingkar Lengan Atas (cm)
                        </label>
                        <input type="number" name="lingkar_lengan" id="lingkar_lengan"
                               value="{{ $data['lingkar_lengan'] ?? '' }}" step="0.1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('lingkar_lengan') border-red-500 @enderror">
                        @error('lingkar_lengan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <div class="bg-slate-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700">
                        <div class="font-semibold text-gray-800 mb-2">Ringkasan Akumulasi Berat</div>
                        <p id="weight_trend" class="mb-2">Pilih balita dan masukkan berat badan untuk melihat perubahan.</p>
                        <p id="weight_delta" class="mb-1"></p>
                        <p id="weight_previous_date" class="text-sm text-gray-500"></p>
                    </div>
                </div>

                <div class="mt-6 bg-slate-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700">
                    <div class="font-semibold text-gray-800 mb-2">Ringkasan Status Berat</div>
                    <p><span class="font-semibold">Naik:</span> Berat saat ini lebih tinggi dari pemeriksaan sebelumnya.</p>
                    <p><span class="font-semibold">Turun:</span> Berat saat ini lebih rendah dari pemeriksaan sebelumnya.</p>
                    <p><span class="font-semibold">Tetap:</span> Berat saat ini sama dengan pemeriksaan sebelumnya.</p>
                    <p><span class="font-semibold">Pertama:</span> Belum ada data pemeriksaan sebelumnya.</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-balita.create') }}#riwayat-belum-selesai" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 text-white bg-teal-600 hover:bg-teal-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 2
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Search functionality
    document.addEventListener('DOMContentLoaded', function () {
        // Search autocomplete functionality
        const searchInput = document.getElementById('search_balita');
        const selectDropdown = document.getElementById('balita_identitas_id');
        const totalCount = document.getElementById('total_balita');
        const suggestionsBox = document.getElementById('suggestions_balita');

        if (searchInput && selectDropdown && suggestionsBox) {
            const allOptions = Array.from(selectDropdown.options)
                .filter(opt => opt.value !== '')
                .map(opt => ({
                    value: opt.value,
                    text: opt.text
                }));

            // Sync on page load (e.g. for Laravel validation old() values)
            if (selectDropdown.value) {
                const selectedOpt = Array.from(selectDropdown.options).find(opt => opt.value === selectDropdown.value);
                if (selectedOpt) {
                    searchInput.value = selectedOpt.text.trim();
                }
            }

            function renderSuggestions(searchTerm) {
                suggestionsBox.innerHTML = '';
                const term = searchTerm.toLowerCase().trim();
                const filtered = allOptions.filter(opt => opt.text.toLowerCase().includes(term));
                
                if (totalCount) {
                    totalCount.textContent = filtered.length;
                }

                if (filtered.length === 0) {
                    const noResult = document.createElement('div');
                    noResult.className = 'px-4 py-2 text-gray-500 text-sm';
                    noResult.textContent = 'Tidak ditemukan';
                    suggestionsBox.appendChild(noResult);
                } else {
                    filtered.forEach(opt => {
                        const item = document.createElement('div');
                        item.className = 'px-4 py-2 hover:bg-slate-100 cursor-pointer text-gray-700 text-sm border-b border-gray-100 last:border-0';
                        item.textContent = opt.text;
                        item.addEventListener('click', function() {
                            selectDropdown.value = opt.value;
                            selectDropdown.dispatchEvent(new Event('change'));
                            searchInput.value = opt.text.trim();
                            suggestionsBox.classList.add('hidden');
                        });
                        suggestionsBox.appendChild(item);
                    });
                }
                suggestionsBox.classList.remove('hidden');
            }

            searchInput.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    selectDropdown.value = '';
                    selectDropdown.dispatchEvent(new Event('change'));
                    renderSuggestions('');
                } else {
                    renderSuggestions(this.value);
                }
            });

            searchInput.addEventListener('focus', function() {
                renderSuggestions(this.value);
            });

            // Close suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.classList.add('hidden');
                }
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const balitaSelect = document.getElementById('balita_identitas_id');
        const beratInput = document.getElementById('berat_badan');
        const prevWeightBox = document.getElementById('previous_weight');
        const weightTrend = document.getElementById('weight_trend');
        const weightDelta = document.getElementById('weight_delta');
        const weightPreviousDate = document.getElementById('weight_previous_date');

        const previousWeights = @json($previousWeights ?? []);

        function formatKg(value) {
            return Number(value).toFixed(1).replace(/\.0$/, '') + ' kg';
        }

        function updateAccumulation() {
            const selectedId = balitaSelect ? balitaSelect.value : null;
            const currentWeight = parseFloat(beratInput.value);
            const previous = selectedId ? (previousWeights[selectedId] ?? null) : null;

            if (!selectedId) {
                prevWeightBox.textContent = 'Pilih balita untuk melihat data pemeriksaan sebelumnya.';
                weightTrend.textContent = 'Pilih balita dan masukkan berat badan untuk melihat perubahan.';
                weightDelta.textContent = '';
                weightPreviousDate.textContent = '';
                return;
            }

            if (!previous) {
                prevWeightBox.textContent = 'Belum ada pemeriksaan sebelumnya untuk balita ini.';
                weightTrend.textContent = currentWeight ? 'Ini adalah pengukuran pertama.' : 'Masukkan berat badan untuk menghitung perubahan.';
                weightDelta.textContent = '';
                weightPreviousDate.textContent = '';
                return;
            }

            const previousDate = previous.tanggal_kunjungan || 'tanggal tidak tersedia';
            prevWeightBox.textContent = `Terakhir tercatat ${formatKg(previous.berat_badan)} pada ${previousDate}.`;
            weightPreviousDate.textContent = previous.tanggal_kunjungan ? `Tanggal pemeriksaan sebelumnya: ${previous.tanggal_kunjungan}` : '';

            if (isNaN(currentWeight)) {
                weightTrend.textContent = 'Masukkan berat badan untuk menghitung perubahan terhadap pemeriksaan sebelumnya.';
                weightDelta.textContent = '';
                return;
            }

            const delta = currentWeight - parseFloat(previous.berat_badan);
            const sign = delta > 0 ? '+' : '';
            const trend = delta > 0 ? 'Naik' : delta < 0 ? 'Turun' : 'Tetap';

            weightTrend.textContent = `Perubahan berat: ${trend}.`;
            weightDelta.textContent = `Selisih: ${sign}${delta.toFixed(1)} kg dibanding pemeriksaan sebelumnya.`;
        }

        if (balitaSelect) {
            balitaSelect.addEventListener('change', updateAccumulation);
        }
        if (beratInput) {
            beratInput.addEventListener('input', updateAccumulation);
        }

        updateAccumulation();
    });
</script>
@endpush
@endsection
