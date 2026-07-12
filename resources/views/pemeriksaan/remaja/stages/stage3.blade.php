@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-cyan-900">Pemeriksaan Remaja - Tahap 3</h2>
        <p class="text-gray-600 mt-1">Skrining TBC & Masalah Kesehatan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-remaja.index') }}" class="hover:text-cyan-600">Pemeriksaan Remaja</a>
            <span class="mx-2">/</span>
            <span>Tahap 3</span>
        </nav>
    </div>

    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 3/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-cyan-600 h-2 rounded-full" style="width: 75%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-remaja.stage-store', 3) }}" method="POST">
            @csrf
            <input type="hidden" name="pemeriksaan_id" value="{{ old('pemeriksaan_id', $data['id'] ?? '') }}">

            @if($pemeriksaan)
                <input type="hidden" name="remaja_identitas_id" value="{{ $pemeriksaan->remaja_identitas_id }}">
                <input type="hidden" name="waktu_kunjungan" value="{{ $pemeriksaan->waktu_kunjungan }}">

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-green-900 font-medium">Melanjutkan pemeriksaan untuk {{ $pemeriksaan->remaja->nama_anak ?? '-' }}. Data remaja dan tanggal kunjungan sudah dikunci dari tahap sebelumnya.</p>
                </div>
            @else
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
                        <label for="waktu_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="waktu_kunjungan" id="waktu_kunjungan"
                               value="{{ old('waktu_kunjungan', $data['waktu_kunjungan'] ?? date('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('waktu_kunjungan') border-red-500 @enderror"
                               required>
                        @error('waktu_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Tahap 1 & 2 -->
            @if($data)
            <div class="bg-cyan-50 border border-cyan-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-cyan-900 mb-4">Data dari Tahap Sebelumnya</h3>
                
                <!-- Tahap 1 -->
                <div class="mb-3 pb-3 border-b border-cyan-300">
                    <p class="text-xs font-semibold text-cyan-700 mb-2">TAHAP 1: Penimbangan & Pengukuran</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-cyan-700 font-medium">Berat Badan</p>
                            <p class="text-cyan-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Tinggi Badan</p>
                            <p class="text-cyan-900">{{ $data['tinggi_badan'] ?? '-' }} cm</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Status IMT</p>
                            <p class="text-cyan-900">{{ $data['imt_status'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Lingkar Perut</p>
                            <p class="text-cyan-900">{{ $data['lingkar_perut'] ?? '-' }} cm</p>
                        </div>
                    </div>
                </div>

                <!-- Tahap 2 -->
                <div>
                    <p class="text-xs font-semibold text-cyan-700 mb-2">TAHAP 2: Pemeriksaan Tekanan Darah, Gula Darah, Hemoglobin</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-cyan-700 font-medium">Tekanan Darah</p>
                            <p class="text-cyan-900">{{ $data['sistole'] ?? '-' }}/{{ $data['diastole'] ?? '-' }} mmHg</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Status TD</p>
                            <p class="text-cyan-900">{{ $data['tekanan_darah_status'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Gula Darah</p>
                            <p class="text-cyan-900">{{ $data['gula_darah'] ?? '-' }} mg/dL</p>
                        </div>
                        <div>
                            <p class="text-cyan-700 font-medium">Anemia</p>
                            <p class="text-cyan-900">{{ $data['anemia'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Skrining TBC</h3>

                <div class="space-y-3">
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="batuk" id="batuk" value="Ya"
                               {{ old('batuk', $data['batuk'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="batuk" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Batuk terus menerus
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="demam" id="demam" value="Ya"
                               {{ old('demam', $data['demam'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="demam" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Demam kurang 2 minggu
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="bb_turun" id="bb_turun" value="Ya"
                               {{ old('bb_turun', $data['bb_turun'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="bb_turun" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            BB tidak naik atau turun 2 bulan berturut-turut
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="kontak_tbc" id="kontak_tbc" value="Ya"
                               {{ old('kontak_tbc', $data['kontak_tbc'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="kontak_tbc" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Kontak erat pasien TBC
                        </label>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Masalah Kesehatan</h3>

                <div class="space-y-3">
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="masalah_rumah" id="masalah_rumah" value="Ya"
                               {{ old('masalah_rumah', $data['masalah_rumah'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="masalah_rumah" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Masalah Rumah
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="masalah_pendidikan" id="masalah_pendidikan" value="Ya"
                               {{ old('masalah_pendidikan', $data['masalah_pendidikan'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="masalah_pendidikan" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Masalah Pendidikan
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="masalah_makan" id="masalah_makan" value="Ya"
                               {{ old('masalah_makan', $data['masalah_makan'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="masalah_makan" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Masalah Makan
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="masalah_aktivitas" id="masalah_aktivitas" value="Ya"
                               {{ old('masalah_aktivitas', $data['masalah_aktivitas'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="masalah_aktivitas" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Masalah Aktivitas
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="masalah_obat" id="masalah_obat" value="Ya"
                               {{ old('masalah_obat', $data['masalah_obat'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="masalah_obat" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Masalah Obat
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="masalah_seksual" id="masalah_seksual" value="Ya"
                               {{ old('masalah_seksual', $data['masalah_seksual'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="masalah_seksual" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Masalah Seksual
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="masalah_emosi" id="masalah_emosi" value="Ya"
                               {{ old('masalah_emosi', $data['masalah_emosi'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="masalah_emosi" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Masalah Emosi
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="masalah_keamanan" id="masalah_keamanan" value="Ya"
                               {{ old('masalah_keamanan', $data['masalah_keamanan'] ?? '') === 'Ya' ? 'checked' : '' }}
                               class="w-4 h-4 text-cyan-600 border-gray-300 rounded focus:ring-2 focus:ring-cyan-500">
                        <label for="masalah_keamanan" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Masalah Keamanan
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-remaja.index') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                <a href="{{ route('pemeriksaan-remaja.stage', ['stage' => 2, 'pemeriksaan_id' => old('pemeriksaan_id', $data['id'] ?? '')]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 2
                </a>
                <button type="submit" class="px-6 py-2 text-white bg-cyan-600 hover:bg-cyan-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 4
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
</script>
@endpush
@endsection