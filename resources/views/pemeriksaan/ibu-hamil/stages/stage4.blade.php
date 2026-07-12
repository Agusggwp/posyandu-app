@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Ibu Hamil - Tahap 4</h2>
        <p class="text-gray-600 mt-1">Edukasi & Rujukan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="hover:text-purple-600">Pemeriksaan Ibu Hamil</a>
            <span class="mx-2">/</span>
            <span>Tahap 4</span>
        </nav>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 4/4 - Final</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-purple-600 h-2 rounded-full" style="width: 100%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-ibu-hamil.stage-store', ['stage' => 4, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" method="POST">
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
                        Cari Ibu Hamil <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" id="search_ibu" placeholder="Ketik nama atau NIK ibu hamil..." autocomplete="off"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent mb-1 @error('ibu_hamil_identitas_id') border-red-500 @enderror">
                        <div id="suggestions_ibu" class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden">
                            <!-- suggestions will be populated here -->
                        </div>
                    </div>
                    @error('ibu_hamil_identitas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">Total: <span id="total_ibu">{{ count($ibuHamils) }}</span> ibu hamil</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="hidden">
                        <select name="ibu_hamil_identitas_id" id="ibu_hamil_identitas_id" required>
                            <option value="">-- Pilih Ibu Hamil --</option>
                            @foreach($ibuHamils as $ibuHamil)
                                <option value="{{ $ibuHamil->id }}" {{ (old('ibu_hamil_identitas_id', $data['ibu_hamil_identitas_id'] ?? null)) == $ibuHamil->id ? 'selected' : '' }}>
                                    {{ $ibuHamil->nama }} - {{ $ibuHamil->nik }}
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Semua Tahap -->
            @if($data)
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-purple-900 mb-4">Ringkasan Data Pemeriksaan</h3>
                
                <!-- Tahap 1 -->
                <div class="mb-3 pb-3 border-b border-purple-300">
                    <p class="text-xs font-semibold text-purple-700 mb-2">TAHAP 1: Penimbangan & Pengukuran</p>
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

                <!-- Tahap 2 -->
                <div class="mb-3 pb-3 border-b border-purple-300">
                    <p class="text-xs font-semibold text-purple-700 mb-2">TAHAP 2: Pemeriksaan Tekanan Darah</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-purple-700 font-medium">Tekanan Darah</p>
                            <p class="text-purple-900">{{ $data['tekanan_darah'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Status TD</p>
                            <p class="text-purple-900">{{ $data['status_tekanan_darah'] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Sistole</p>
                            <p class="text-purple-900">{{ $data['sistole'] ?? '-' }} mmHg</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Diastole</p>
                            <p class="text-purple-900">{{ $data['diastole'] ?? '-' }} mmHg</p>
                        </div>
                    </div>
                </div>

                <!-- Tahap 3 -->
                <div>
                    <p class="text-xs font-semibold text-purple-700 mb-2">TAHAP 3: Skrining TBC & Pelayanan Kesehatan</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <p class="text-purple-700 font-medium">Tablet Tambah Darah</p>
                            <p class="text-purple-900">{{ $data['tablet_tambah_darah'] ? 'Ya' : 'Tidak' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">PMT Bumil</p>
                            <p class="text-purple-900">{{ $data['pmt_bumil'] ? 'Ya' : 'Tidak' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Kelas Ibu Hamil</p>
                            <p class="text-purple-900">{{ $data['kelas_ibu_hamil'] ? 'Ya' : 'Tidak' }}</p>
                        </div>
                        <div>
                            <p class="text-purple-700 font-medium">Skrining TBC</p>
                            <p class="text-purple-900">{{ $data['tb_skrining_hasil'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Edukasi & Rujukan</h3>

                <div class="mb-6">
                    <label for="edukasi" class="block text-sm font-medium text-gray-700 mb-2">
                        Edukasi
                    </label>
                    <textarea name="edukasi" id="edukasi" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('edukasi') border-red-500 @enderror"
                              placeholder="Catatan edukasi untuk ibu hamil...">{{ $data['edukasi'] ?? '' }}</textarea>
                    @error('edukasi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rujukan" class="block text-sm font-medium text-gray-700 mb-2">
                        Rujukan
                    </label>
                    <select name="rujukan" id="rujukan"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('rujukan') border-red-500 @enderror">
                        <option value="Tidak" {{ ($data['rujukan'] ?? 'Tidak') === 'Tidak' ? 'selected' : '' }}>Tidak Ada Rujukan</option>
                        <option value="Pustu" {{ ($data['rujukan'] ?? null) === 'Pustu' ? 'selected' : '' }}>Pustu</option>
                        <option value="Puskesmas" {{ ($data['rujukan'] ?? null) === 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                        <option value="Rumah Sakit" {{ ($data['rujukan'] ?? null) === 'Rumah Sakit' ? 'selected' : '' }}>Rumah Sakit</option>
                    </select>
                    @error('rujukan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-ibu-hamil.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                <a href="{{ route('pemeriksaan-ibu-hamil.stage', ['stage' => 3, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 3
                </a>
                <button type="submit" class="px-6 py-2 text-white bg-purple-600 hover:bg-purple-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Selesaikan Pemeriksaan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search autocomplete functionality
        const searchInput = document.getElementById('search_ibu');
        const selectDropdown = document.getElementById('ibu_hamil_identitas_id');
        const totalCount = document.getElementById('total_ibu');
        const suggestionsBox = document.getElementById('suggestions_ibu');

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
