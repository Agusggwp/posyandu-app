@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Balita - Tahap 3</h2>
        <p class="text-gray-600 mt-1">Skrining TBC, Perkembangan & Pemberian</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-sky-600">Pemeriksaan Balita</a>
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
            <div class="bg-sky-600 h-2 rounded-full" style="width: 75%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-balita.stage-store', 3) }}" method="POST">
            @csrf

            @if($pemeriksaan)
                <input type="hidden" name="balita_identitas_id" value="{{ $pemeriksaan->balita_identitas_id }}">
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent mb-1 @error('balita_identitas_id') border-red-500 @enderror">
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Tahap 1 & 2 -->
            @if($data)
            <div class="bg-sky-50 border border-sky-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-sky-900 mb-4">Data dari Tahap Sebelumnya</h3>
                
                <!-- Tahap 1: Penimbangan & Pengukuran -->
                <div class="mb-3 pb-3 border-b border-sky-300">
                    <p class="text-xs font-semibold text-sky-700 mb-2">TAHAP 1: Penimbangan & Pengukuran</p>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-sm">
                        <div>
                            <p class="text-sky-700 font-medium">Berat Badan</p>
                            <p class="text-sky-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                        </div>
                        <div>
                            <p class="text-sky-700 font-medium">Status BB</p>
                            <p class="text-sky-900">{{ $data['naik_tidak_naik'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sky-700 font-medium">Tinggi Badan</p>
                            <p class="text-sky-900">{{ $data['panjang_badan'] ?? '-' }} cm</p>
                        </div>
                        <div>
                            <p class="text-sky-700 font-medium">Lingkar Kepala</p>
                            <p class="text-sky-900">{{ $data['lingkar_kepala'] ?? '-' }} cm</p>
                        </div>
                        <div>
                            <p class="text-sky-700 font-medium">LILA</p>
                            <p class="text-sky-900">{{ $data['lingkar_lengan'] ?? '-' }} cm</p>
                        </div>
                    </div>
                </div>

                <!-- Tahap 2: Status Gizi -->
                <div>
                    <p class="text-xs font-semibold text-sky-700 mb-2">TAHAP 2: Status Gizi & Pengukuran</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-sky-700 font-medium">Status BB/U</p>
                            <p class="text-sky-900">{{ $data['status_bb_u'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sky-700 font-medium">Status PB/U</p>
                            <p class="text-sky-900">{{ $data['status_pb_u'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sky-700 font-medium">Status BB/PB</p>
                            <p class="text-sky-900">{{ $data['status_bb_pb'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sky-700 font-medium">Status LILA</p>
                            <p class="text-sky-900">{{ $data['status_lila'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Skrining TBC</h3>
                <p class="text-sm text-gray-600 mb-4">Jika 2 gejala terpenuhi maka dirujuk ke Puskesmas</p>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="batuk" id="batuk" value="1"
                               {{ ($data['batuk'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="batuk" class="ml-2 text-sm text-gray-700">
                            Batuk terus-menerus
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="demam" id="demam" value="1"
                               {{ ($data['demam'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="demam" class="ml-2 text-sm text-gray-700">
                            Demam kurang lebih 2 minggu
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="bb_turun" id="bb_turun" value="1"
                               {{ ($data['bb_turun'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="bb_turun" class="ml-2 text-sm text-gray-700">
                            BB tidak naik atau turun dalam 2 bulan berturut-turut
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="kontak_tbc" id="kontak_tbc" value="1"
                               {{ ($data['kontak_tbc'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="kontak_tbc" class="ml-2 text-sm text-gray-700">
                            Kontak erat dengan pasien TBC
                        </label>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Perkembangan</h3>

                <div>
                    <label for="perkembangan" class="block text-sm font-medium text-gray-700 mb-2">
                        Ceklis Perkembangan
                    </label>
                    <select name="perkembangan" id="perkembangan"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('perkembangan') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Lengkap" {{ ($data['perkembangan'] ?? null) === 'Lengkap' ? 'selected' : '' }}>Lengkap</option>
                        <option value="Tidak Lengkap" {{ ($data['perkembangan'] ?? null) === 'Tidak Lengkap' ? 'selected' : '' }}>Tidak Lengkap</option>
                        <option value="Monitor" {{ ($data['perkembangan'] ?? null) === 'Monitor' ? 'selected' : '' }}>Monitor</option>
                    </select>
                    @error('perkembangan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pemberian & Intervensi</h3>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="asi_eksklusif" id="asi_eksklusif" value="1"
                               {{ ($data['asi_eksklusif'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="asi_eksklusif" class="ml-2 text-sm text-gray-700">
                            ASI Eksklusif diberikan
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="mpasi" id="mpasi" value="1"
                               {{ ($data['mpasi'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="mpasi" class="ml-2 text-sm text-gray-700">
                            MP-ASI diberikan
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="imunisasi" id="imunisasi" value="1"
                               {{ ($data['imunisasi'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="imunisasi" class="ml-2 text-sm text-gray-700">
                            Imunisasi lengkap
                        </label>
                    </div>

                    <div class="ml-6">
                        <label for="jenis_imunisasi" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Imunisasi
                        </label>
                        <input type="text" name="jenis_imunisasi" id="jenis_imunisasi"
                               value="{{ $data['jenis_imunisasi'] ?? '' }}"
                               placeholder="Contoh: BCG, Polio, DPT, Hepatitis B, Campak"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-transparent @error('jenis_imunisasi') border-red-500 @enderror">
                        @error('jenis_imunisasi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="vitamin_a" id="vitamin_a" value="1"
                               {{ ($data['vitamin_a'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="vitamin_a" class="ml-2 text-sm text-gray-700">
                            Vitamin A diberikan
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="obat_cacing" id="obat_cacing" value="1"
                               {{ ($data['obat_cacing'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="obat_cacing" class="ml-2 text-sm text-gray-700">
                            Obat cacing diberikan
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="mt_pangan" id="mt_pangan" value="1"
                               {{ ($data['mt_pangan'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-sky-600 border-gray-300 rounded focus:ring-2 focus:ring-sky-500">
                        <label for="mt_pangan" class="ml-2 text-sm text-gray-700">
                            Makanan Tradisional / Pangan Lokal diberikan
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-balita.create') }}#riwayat-belum-selesai" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-balita.stage', ['stage' => 2, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 2
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 4
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
@endpush
@endsection
