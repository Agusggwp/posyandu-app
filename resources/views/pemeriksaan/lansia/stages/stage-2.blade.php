@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Lansia - Tahap 2</h2>
        <p class="text-gray-600 mt-1">Pemeriksaan Kesehatan Vital</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-lansia.index') }}" class="hover:text-cyan-600">Pemeriksaan Lansia</a>
            <span class="mx-2">/</span>
            <span>Tahap 2 - Pemeriksaan Kesehatan</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700">Tahap 2 dari 4</span>
                <span class="text-sm font-semibold text-cyan-600">50%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-cyan-600 h-2 rounded-full" style="width: 50%"></div>
            </div>
        </div>

        <form action="{{ route('pemeriksaan-lansia.stage-store', 2) }}" method="POST">
            @csrf
            
            <input type="hidden" name="stage" value="2">
            @if($pemeriksaan)
                <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">
            @else
                <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <label for="search_lansia" class="block text-sm font-medium text-gray-700 mb-2">
                        Cari Lansia <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" id="search_lansia" placeholder="Ketik nama atau NIK lansia..." autocomplete="off"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent mb-1 @error('dewasa_identitas_id') border-red-500 @enderror">
                        <div id="suggestions_lansia" class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden">
                            <!-- suggestions will be populated here -->
                        </div>
                    </div>
                    @error('dewasa_identitas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">Total: <span id="total_lansia">{{ count($lansias) }}</span> lansia</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="hidden">
                        <select name="dewasa_identitas_id" id="dewasa_identitas_id" required>
                            <option value="">-- Pilih Lansia --</option>
                            @foreach($lansias as $lansia)
                                <option value="{{ $lansia->id }}" {{ old('dewasa_identitas_id', $data['dewasa_identitas_id'] ?? '') == $lansia->id ? 'selected' : '' }}>
                                    {{ $lansia->nama }} - {{ $lansia->nik }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="waktu_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Waktu Kunjungan <span class="text-red-500">*</span></label>
                        <input type="date" name="waktu_kunjungan" id="waktu_kunjungan" value="{{ old('waktu_kunjungan', $data['waktu_kunjungan'] ?? now()->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('waktu_kunjungan') border-red-500 @enderror" required>
                        @error('waktu_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Tahap 1 -->
            @if($data)
            <div class="bg-cyan-50 border border-cyan-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-cyan-900 mb-3">Data dari Tahap 1</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-sm">
                    <div>
                        <p class="text-cyan-700 font-medium">Berat Badan</p>
                        <p class="text-cyan-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                    </div>
                    <div>
                        <p class="text-cyan-700 font-medium">Tinggi Badan</p>
                        <p class="text-cyan-900">{{ $data['tinggi_badan'] ?? '-' }} cm</p>
                    </div>
                    <div>
                        <p class="text-cyan-700 font-medium">Lingkar Perut</p>
                        <p class="text-cyan-900">{{ $data['lingkar_perut'] ?? '-' }} cm</p>
                    </div>
                    <div>
                        <p class="text-cyan-700 font-medium">IMT</p>
                        <p class="text-cyan-900">{{ $data['imt'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-cyan-700 font-medium">Status BB</p>
                        <p class="text-cyan-900">{{ $data['status_berat_badan'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Tekanan Darah -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-heartbeat text-cyan-600"></i>
                    Tekanan Darah
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sistole" class="block text-sm font-medium text-gray-700 mb-2">Sistole <span class="text-cyan-600">(mmHg)</span></label>
                        <input type="number" name="sistole" id="sistole" 
                               value="{{ old('sistole', $pemeriksaan->sistole ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('sistole') border-red-500 @enderror"
                               placeholder="Contoh: 120">
                        @error('sistole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="diastole" class="block text-sm font-medium text-gray-700 mb-2">Diastole <span class="text-cyan-600">(mmHg)</span></label>
                        <input type="number" name="diastole" id="diastole" 
                               value="{{ old('diastole', $pemeriksaan->diastole ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('diastole') border-red-500 @enderror"
                               placeholder="Contoh: 80">
                        @error('diastole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="tekanan_darah_status" class="block text-sm font-medium text-gray-700 mb-2">Status Tekanan Darah</label>
                    <input type="text" id="tekanan_darah_status" name="tekanan_darah_status"
                           value="{{ old('tekanan_darah_status', $pemeriksaan->tekanan_darah_status ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('tekanan_darah_status') border-red-500 @enderror"
                           readonly>
                    @error('tekanan_darah_status')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Gula Darah -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-droplet text-cyan-600"></i>
                    Gula Darah
                </h3>
                
                <div>
                    <label for="gula_darah" class="block text-sm font-medium text-gray-700 mb-2">Gula Darah <span class="text-cyan-600">(mg/dL)</span></label>
                    <input type="number" name="gula_darah" id="gula_darah" 
                           value="{{ old('gula_darah', $pemeriksaan->gula_darah ?? '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('gula_darah') border-red-500 @enderror"
                           placeholder="Contoh: 120">
                    @error('gula_darah')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Normal: 70-100 mg/dL (puasa) | Diabetes: ≥126 mg/dL (puasa)</p>
                </div>
            </div>

            @push('scripts')
            <script>
                const sistoloInput = document.getElementById('sistole');
                const diastoloInput = document.getElementById('diastole');
                const tekananDarahStatusInput = document.getElementById('tekanan_darah_status');

                function calculateTekananDarahStatus() {
                    const sistole = parseFloat(sistoloInput.value) || 0;
                    const diastole = parseFloat(diastoloInput.value) || 0;
                    
                    let status = '';
                    
                    if (sistole === 0 && diastole === 0) {
                        status = '';
                    } else if (sistole < 90 && diastole < 60) {
                        status = 'Hypotension';
                    } else if (sistole < 120 && diastole < 80) {
                        status = 'Normal';
                    } else if (sistole >= 120 && sistole <= 129 && diastole < 80) {
                        status = 'Elevated';
                    } else if (sistole >= 130 && sistole <= 139 && diastole >= 80 && diastole <= 89) {
                        status = 'Stage 1 Hypertension';
                    } else if (sistole >= 140 || diastole >= 90) {
                        status = 'Stage 2 Hypertension';
                    }
                    
                    tekananDarahStatusInput.value = status;
                }

                if (sistoloInput) sistoloInput.addEventListener('input', calculateTekananDarahStatus);
                if (diastoloInput) diastoloInput.addEventListener('input', calculateTekananDarahStatus);
            </script>
            @endpush

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-lansia.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-lansia.stage', ['stage' => 1, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 1
                </a>
                @endif
                <button type="submit" class="px-6 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 3
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
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
</script>
@endpush
@endsection
