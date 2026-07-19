@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Lansia - Tahap 3</h2>
        <p class="text-gray-600 mt-1">Pelayanan & Pemeriksaan Mata Telinga</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-lansia.index') }}" class="hover:text-teal-600">Pemeriksaan Lansia</a>
            <span class="mx-2">/</span>
            <span>Tahap 3 - Pelayanan</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700">Tahap 3 dari 4</span>
                <span class="text-sm font-semibold text-teal-600">75%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-teal-600 h-2 rounded-full" style="width: 75%"></div>
            </div>
        </div>

        <form action="{{ route('pemeriksaan-lansia.stage-store', 3) }}" method="POST">
            @csrf
            
            <input type="hidden" name="stage" value="3">
            @if($pemeriksaan)
                <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">
            @else
                <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <label for="search_lansia" class="block text-sm font-medium text-gray-700 mb-2">
                        Cari Lansia <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" id="search_lansia" placeholder="Ketik nama atau NIK lansia..." autocomplete="off"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent mb-1 @error('dewasa_identitas_id') border-red-500 @enderror">
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
                        <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', $data['tanggal_kunjungan'] ?? now()->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Tahap 1 & 2 -->
            @if($data)
            <div class="bg-teal-50 border border-teal-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-teal-900 mb-4">Data dari Tahap Sebelumnya</h3>
                
                <!-- Tahap 1 -->
                <div class="mb-3 pb-3 border-b border-teal-300">
                    <p class="text-xs font-semibold text-teal-700 mb-2">TAHAP 1: Pengukuran Antropometri</p>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-sm">
                        <div>
                            <p class="text-teal-700 font-medium">Berat Badan</p>
                            <p class="text-teal-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                        </div>
                        <div>
                            <p class="text-teal-700 font-medium">Tinggi Badan</p>
                            <p class="text-teal-900">{{ $data['tinggi_badan'] ?? '-' }} cm</p>
                        </div>
                        <div>
                            <p class="text-teal-700 font-medium">Lingkar Perut</p>
                            <p class="text-teal-900">{{ $data['lingkar_perut'] ?? '-' }} cm</p>
                        </div>
                        <div>
                            <p class="text-teal-700 font-medium">IMT</p>
                            <p class="text-teal-900">{{ $data['imt'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-teal-700 font-medium">Status BB</p>
                            <p class="text-teal-900">{{ $data['status_berat_badan'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tahap 2 -->
                <div>
                    <p class="text-xs font-semibold text-teal-700 mb-2">TAHAP 2: Pemeriksaan Tekanan Darah, Gula Darah, Kolesterol</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-teal-700 font-medium">Tekanan Darah</p>
                            <p class="text-teal-900">{{ $data['sistole'] ?? '-' }}/{{ $data['diastole'] ?? '-' }} mmHg</p>
                        </div>
                        <div>
                            <p class="text-teal-700 font-medium">Status TD</p>
                            <p class="text-teal-900">{{ $data['tekanan_darah_status'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-teal-700 font-medium">Gula Darah</p>
                            <p class="text-teal-900">{{ $data['gula_darah'] ?? '-' }} mg/dL</p>
                        </div>
                        <div>
                            <p class="text-teal-700 font-medium">Kolesterol</p>
                            <p class="text-teal-900">{{ $data['kolesterol'] ?? '-' }} mg/dL</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Pemeriksaan Mata -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-eye text-teal-600"></i>
                    Pemeriksaan Mata
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mata_kanan" class="block text-sm font-medium text-gray-700 mb-2">Mata Kanan</label>
                        <select name="mata_kanan" id="mata_kanan"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('mata_kanan') border-red-500 @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="Normal" {{ old('mata_kanan', $pemeriksaan->mata_kanan ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Gangguan Penglihatan Ringan" {{ old('mata_kanan', $pemeriksaan->mata_kanan ?? '') == 'Gangguan Penglihatan Ringan' ? 'selected' : '' }}>Gangguan Penglihatan Ringan</option>
                            <option value="Gangguan Penglihatan Sedang" {{ old('mata_kanan', $pemeriksaan->mata_kanan ?? '') == 'Gangguan Penglihatan Sedang' ? 'selected' : '' }}>Gangguan Penglihatan Sedang</option>
                            <option value="Gangguan Penglihatan Berat" {{ old('mata_kanan', $pemeriksaan->mata_kanan ?? '') == 'Gangguan Penglihatan Berat' ? 'selected' : '' }}>Gangguan Penglihatan Berat</option>
                            <option value="Buta" {{ old('mata_kanan', $pemeriksaan->mata_kanan ?? '') == 'Buta' ? 'selected' : '' }}>Buta</option>
                        </select>
                        @error('mata_kanan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mata_kiri" class="block text-sm font-medium text-gray-700 mb-2">Mata Kiri</label>
                        <select name="mata_kiri" id="mata_kiri"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('mata_kiri') border-red-500 @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="Normal" {{ old('mata_kiri', $pemeriksaan->mata_kiri ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Gangguan Penglihatan Ringan" {{ old('mata_kiri', $pemeriksaan->mata_kiri ?? '') == 'Gangguan Penglihatan Ringan' ? 'selected' : '' }}>Gangguan Penglihatan Ringan</option>
                            <option value="Gangguan Penglihatan Sedang" {{ old('mata_kiri', $pemeriksaan->mata_kiri ?? '') == 'Gangguan Penglihatan Sedang' ? 'selected' : '' }}>Gangguan Penglihatan Sedang</option>
                            <option value="Gangguan Penglihatan Berat" {{ old('mata_kiri', $pemeriksaan->mata_kiri ?? '') == 'Gangguan Penglihatan Berat' ? 'selected' : '' }}>Gangguan Penglihatan Berat</option>
                            <option value="Buta" {{ old('mata_kiri', $pemeriksaan->mata_kiri ?? '') == 'Buta' ? 'selected' : '' }}>Buta</option>
                        </select>
                        @error('mata_kiri')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pemeriksaan Telinga -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-ear text-teal-600"></i>
                    Pemeriksaan Telinga
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telinga_kanan" class="block text-sm font-medium text-gray-700 mb-2">Telinga Kanan</label>
                        <select name="telinga_kanan" id="telinga_kanan"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('telinga_kanan') border-red-500 @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="Normal" {{ old('telinga_kanan', $pemeriksaan->telinga_kanan ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Gangguan Pendengaran Ringan" {{ old('telinga_kanan', $pemeriksaan->telinga_kanan ?? '') == 'Gangguan Pendengaran Ringan' ? 'selected' : '' }}>Gangguan Pendengaran Ringan</option>
                            <option value="Gangguan Pendengaran Sedang" {{ old('telinga_kanan', $pemeriksaan->telinga_kanan ?? '') == 'Gangguan Pendengaran Sedang' ? 'selected' : '' }}>Gangguan Pendengaran Sedang</option>
                            <option value="Gangguan Pendengaran Berat" {{ old('telinga_kanan', $pemeriksaan->telinga_kanan ?? '') == 'Gangguan Pendengaran Berat' ? 'selected' : '' }}>Gangguan Pendengaran Berat</option>
                            <option value="Tuli" {{ old('telinga_kanan', $pemeriksaan->telinga_kanan ?? '') == 'Tuli' ? 'selected' : '' }}>Tuli</option>
                        </select>
                        @error('telinga_kanan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telinga_kiri" class="block text-sm font-medium text-gray-700 mb-2">Telinga Kiri</label>
                        <select name="telinga_kiri" id="telinga_kiri"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('telinga_kiri') border-red-500 @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="Normal" {{ old('telinga_kiri', $pemeriksaan->telinga_kiri ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Gangguan Pendengaran Ringan" {{ old('telinga_kiri', $pemeriksaan->telinga_kiri ?? '') == 'Gangguan Pendengaran Ringan' ? 'selected' : '' }}>Gangguan Pendengaran Ringan</option>
                            <option value="Gangguan Pendengaran Sedang" {{ old('telinga_kiri', $pemeriksaan->telinga_kiri ?? '') == 'Gangguan Pendengaran Sedang' ? 'selected' : '' }}>Gangguan Pendengaran Sedang</option>
                            <option value="Gangguan Pendengaran Berat" {{ old('telinga_kiri', $pemeriksaan->telinga_kiri ?? '') == 'Gangguan Pendengaran Berat' ? 'selected' : '' }}>Gangguan Pendengaran Berat</option>
                            <option value="Tuli" {{ old('telinga_kiri', $pemeriksaan->telinga_kiri ?? '') == 'Tuli' ? 'selected' : '' }}>Tuli</option>
                        </select>
                        @error('telinga_kiri')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-lansia.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-lansia.stage', ['stage' => 2, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 2
                </a>
                @endif
                <button type="submit" class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 4
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
