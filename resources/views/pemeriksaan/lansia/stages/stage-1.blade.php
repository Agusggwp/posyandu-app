@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Lansia - Tahap 1</h2>
        <p class="text-gray-600 mt-1">Peninjauan & Pengukuran</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-lansia.index') }}" class="hover:text-amber-600">Pemeriksaan Lansia</a>
            <span class="mx-2">/</span>
            <span>Tahap 1 - Peninjauan & Pengukuran</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700">Tahap 1 dari 4</span>
                <span class="text-sm font-semibold text-amber-600">25%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-amber-600 h-2 rounded-full" style="width: 25%"></div>
            </div>
        </div>

        <form action="{{ route('pemeriksaan-lansia.stage-store', 1) }}" method="POST">
            @csrf
            
            <input type="hidden" name="stage" value="1">
            @if($pemeriksaan)
                <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">
            @endif

            @if(!$pemeriksaan)
            <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <label for="search_lansia" class="block text-sm font-medium text-gray-700 mb-2">
                    Cari Lansia <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" id="search_lansia" placeholder="Ketik nama atau NIK lansia..." autocomplete="off"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent mb-1 @error('dewasa_identitas_id') border-red-500 @enderror">
                    <div id="suggestions_lansia" class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden">
                        <!-- suggestions will be populated here -->
                    </div>
                </div>
                @error('dewasa_identitas_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-2">Total: <span id="total_lansia">{{ count($lansias) }}</span> lansia</p>
            </div>
            @endif

            <!-- Identitas Lansia -->
            @if(!$pemeriksaan)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-user-circle text-amber-600"></i>
                    Identitas Lansia
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="hidden">
                        <select name="dewasa_identitas_id" id="dewasa_identitas_id" required>
                            <option value="">-- Pilih Lansia --</option>
                            @foreach($lansias as $lansia)
                                <option value="{{ $lansia->id }}" {{ old('dewasa_identitas_id') == $lansia->id ? 'selected' : '' }}>
                                    {{ $lansia->nama }} - {{ $lansia->nik }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="waktu_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Waktu Kunjungan <span class="text-red-500">*</span></label>
                        <input type="date" name="waktu_kunjungan" id="waktu_kunjungan" 
                               value="{{ old('waktu_kunjungan', now()->format('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('waktu_kunjungan') border-red-500 @enderror" required>
                        @error('waktu_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            @endif

            <!-- Pengukuran -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-scale-balanced text-amber-600"></i>
                    Pengukuran Antropometri
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Berat Badan <span class="text-amber-600">(kg)</span></label>
                        <input type="number" step="0.1" name="berat_badan" id="berat_badan" 
                               value="{{ old('berat_badan', $pemeriksaan->berat_badan ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror"
                               placeholder="Contoh: 65.5">
                        @error('berat_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan <span class="text-amber-600">(cm)</span></label>
                        <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan" 
                               value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('tinggi_badan') border-red-500 @enderror"
                               placeholder="Contoh: 165">
                        @error('tinggi_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lingkar_perut" class="block text-sm font-medium text-gray-700 mb-2">Lingkar Perut <span class="text-amber-600">(cm)</span></label>
                        <input type="number" step="0.1" name="lingkar_perut" id="lingkar_perut" 
                               value="{{ old('lingkar_perut', $pemeriksaan->lingkar_perut ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('lingkar_perut') border-red-500 @enderror"
                               placeholder="Contoh: 90">
                        @error('lingkar_perut')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="imt" class="block text-sm font-medium text-gray-700 mb-2">IMT (Indeks Massa Tubuh)</label>
                        <input type="number" step="0.1" name="imt" id="imt" 
                               value="{{ old('imt', $pemeriksaan->imt ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('imt') border-red-500 @enderror"
                               placeholder="Otomatis: BB/(TB)²"
                               readonly>
                        @error('imt')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">IMT akan dihitung otomatis dari berat dan tinggi badan</p>
                    </div>

                    <div>
                        <label for="status_berat_badan" class="block text-sm font-medium text-gray-700 mb-2">Status Berat Badan</label>
                        <input type="text" name="status_berat_badan" id="status_berat_badan" 
                               value="{{ old('status_berat_badan', $pemeriksaan->status_berat_badan ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('status_berat_badan') border-red-500 @enderror"
                               placeholder="Otomatis berdasarkan IMT"
                               readonly>
                        @error('status_berat_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Status akan dihitung otomatis dari nilai IMT</p>
                    </div>
                </div>

                <!-- Keterangan IMT dan Status -->
                <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                    <h4 class="text-sm font-semibold text-amber-900 mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-amber-600"></i>
                        Pedoman Status Berat Badan (berdasarkan IMT)
                    </h4>
                    <div class="space-y-2 text-sm text-amber-800">
                        <p><span class="font-semibold">IMT < 18.5:</span> Kurus (Underweight)</p>
                        <p><span class="font-semibold">IMT 18.5 - 24.9:</span> Normal</p>
                        <p><span class="font-semibold">IMT 25.0 - 29.9:</span> Kelebihan Berat Badan (Overweight)</p>
                        <p><span class="font-semibold">IMT ≥ 30:</span> Obesitas</p>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-lansia.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 2
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search autocomplete functionality
    const searchInput = document.getElementById('search_lansia');
    const selectDropdown = document.getElementById('dewasa_identitas_id');
    const totalCount = document.getElementById('total_lansia');
    const suggestionsBox = document.getElementById('suggestions_lansia');

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

    const beratInput = document.getElementById('berat_badan');
    const tinggiInput = document.getElementById('tinggi_badan');
    const imtInput = document.getElementById('imt');
    const statusInput = document.getElementById('status_berat_badan');

    function getStatusBB(imt) {
        if (imt < 18.5) {
            return 'Kurus (Underweight)';
        } else if (imt >= 18.5 && imt < 25) {
            return 'Normal';
        } else if (imt >= 25 && imt < 30) {
            return 'Kelebihan Berat Badan (Overweight)';
        } else {
            return 'Obesitas';
        }
    }

    function hitungIMT() {
        const berat = parseFloat(beratInput.value);
        const tinggi = parseFloat(tinggiInput.value) / 100;
        
        if (berat && tinggi && tinggi > 0) {
            const imt = (berat / (tinggi * tinggi)).toFixed(1);
            imtInput.value = imt;
            statusInput.value = getStatusBB(parseFloat(imt));
        } else {
            statusInput.value = '';
        }
    }

    beratInput.addEventListener('input', hitungIMT);
    tinggiInput.addEventListener('input', hitungIMT);
});
</script>
@endsection
