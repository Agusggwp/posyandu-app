@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-cyan-900">Pemeriksaan Remaja - Tahap 1</h2>
        <p class="text-gray-600 mt-1">Penimbangan & Pengukuran</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-remaja.index') }}" class="hover:text-cyan-600">Pemeriksaan Remaja</a>
            <span class="mx-2">/</span>
            <span>Tahap 1</span>
        </nav>
    </div>

    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 1/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-cyan-600 h-2 rounded-full" style="width: 25%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-remaja.stage-store', 1) }}" method="POST">
            @csrf
            <input type="hidden" name="pemeriksaan_id" value="{{ old('pemeriksaan_id', $data['id'] ?? '') }}">

            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <label for="search_remaja" class="block text-sm font-medium text-gray-700 mb-2">
                    Cari Remaja <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" id="search_remaja" placeholder="Ketik nama atau NIK remaja..." autocomplete="off"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent mb-1 @error('remaja_identitas_id') border-red-500 @enderror">
                    <div id="suggestions_remaja" class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden">
                        <!-- suggestions will be populated here -->
                    </div>
                </div>
                @error('remaja_identitas_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-2">Total: <span id="total_remaja">{{ count($remajas) }}</span> remaja</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="hidden">
                    <select name="remaja_identitas_id" id="remaja_identitas_id" required>
                        <option value="">-- Pilih Remaja --</option>
                        @foreach($remajas as $remaja)
                            <option value="{{ $remaja->id }}" {{ old('remaja_identitas_id', $data['remaja_identitas_id'] ?? '') == $remaja->id ? 'selected' : '' }}>
                                {{ $remaja->nama_anak }} - {{ $remaja->nik }}
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
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror"
                           required>
                    @error('tanggal_kunjungan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Penimbangan & Pengukuran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat Badan (kg) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="berat_badan" id="berat_badan"
                               value="{{ old('berat_badan', $data['berat_badan'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror"
                               min="0" required>
                        @error('berat_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tinggi Badan (cm) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="tinggi_badan" id="tinggi_badan"
                               value="{{ old('tinggi_badan', $data['tinggi_badan'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('tinggi_badan') border-red-500 @enderror"
                               min="0" required>
                        @error('tinggi_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="imt_status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status IMT (otomatis)
                        </label>
                        <div id="imt_status_display" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-slate-50 text-gray-800">
                            {{ old('imt_status', $data['imt_status'] ?? 'Akan dihitung otomatis setelah input berat dan tinggi badan') }}
                        </div>
                        <input type="hidden" name="imt_status" id="imt_status" value="{{ old('imt_status', $data['imt_status'] ?? '') }}">
                        <p class="text-xs text-gray-500 mt-1">Sangat Kurus / Kurus / Normal / Gemuk / Obesitas</p>
                    </div>

                    <div>
                        <label for="lingkar_perut" class="block text-sm font-medium text-gray-700 mb-2">
                            Lingkar Perut (cm)
                        </label>
                        <input type="number" step="0.01" name="lingkar_perut" id="lingkar_perut"
                               value="{{ old('lingkar_perut', $data['lingkar_perut'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('lingkar_perut') border-red-500 @enderror"
                               min="0">
                        @error('lingkar_perut')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 col-span-full">
                    <div class="bg-cyan-50 border border-cyan-200 rounded-lg p-4 text-sm text-cyan-800">
                        <div class="font-semibold text-cyan-900 mb-2">Keterangan Status IMT</div>
                        <p><span class="font-semibold">Sangat Kurus:</span> IMT &lt; 17</p>
                        <p><span class="font-semibold">Kurus:</span> IMT 17 - 18.4</p>
                        <p><span class="font-semibold">Normal:</span> IMT 18.5 - 24.9</p>
                        <p><span class="font-semibold">Gemuk:</span> IMT 25 - 29.9</p>
                        <p><span class="font-semibold">Obesitas:</span> IMT ≥ 30</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-remaja.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 text-white bg-cyan-600 hover:bg-cyan-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 2
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Search autocomplete functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search_remaja');
        const selectDropdown = document.getElementById('remaja_identitas_id');
        const totalCount = document.getElementById('total_remaja');
        const suggestionsBox = document.getElementById('suggestions_remaja');

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

    function calculateImtStatus() {
        const weightInput = document.getElementById('berat_badan');
        const heightInput = document.getElementById('tinggi_badan');
        const statusDisplay = document.getElementById('imt_status_display');
        const statusInput = document.getElementById('imt_status');

        const weight = parseFloat(weightInput?.value);
        const heightCm = parseFloat(heightInput?.value);
        const heightM = heightCm ? heightCm / 100 : null;

        let status = 'Akan dihitung otomatis setelah input berat dan tinggi badan';

        if (!isNaN(weight) && heightM && heightM > 0) {
            const bmi = weight / (heightM * heightM);
            if (bmi < 17) {
                status = 'Sangat Kurus';
            } else if (bmi < 18.5) {
                status = 'Kurus';
            } else if (bmi < 25) {
                status = 'Normal';
            } else if (bmi < 30) {
                status = 'Gemuk';
            } else {
                status = 'Obesitas';
            }
        }

        if (statusDisplay) {
            statusDisplay.textContent = status;
        }
        if (statusInput) {
            statusInput.value = status === 'Akan dihitung otomatis setelah input berat dan tinggi badan' ? '' : status;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const beratInput = document.getElementById('berat_badan');
        const tinggiInput = document.getElementById('tinggi_badan');

        if (beratInput) {
            beratInput.addEventListener('input', calculateImtStatus);
        }
        if (tinggiInput) {
            tinggiInput.addEventListener('input', calculateImtStatus);
        }

        calculateImtStatus();
    });
</script>
@endpush
@endsection