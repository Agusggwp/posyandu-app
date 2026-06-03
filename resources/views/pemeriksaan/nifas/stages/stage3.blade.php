@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Nifas - Tahap 3</h2>
        <p class="text-gray-600 mt-1">Skrining TBC & Pelayanan Kesehatan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-nifas.index') }}" class="hover:text-emerald-600">Pemeriksaan Nifas</a>
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
            <div class="bg-emerald-600 h-2 rounded-full" style="width: 75%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-nifas.stage-store', 3) }}" method="POST">
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
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent mb-3">
                    <p class="text-xs text-gray-500">Total: <span id="total_nifas">{{ count($nifases ?? []) }}</span> ibu nifas</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nifas_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Ibu Nifas <span class="text-red-500">*</span>
                        </label>
                        <select name="nifas_identitas_id" id="nifas_identitas_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('nifas_identitas_id') border-red-500 @enderror" required>
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Tahap 1 & 2 -->
            @if($data)
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-green-900 mb-3">Data dari Tahap Sebelumnya</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                    <div>
                        <p class="text-green-700 font-medium">Berat Badan</p>
                        <p class="text-green-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                    </div>
                    <div>
                        <p class="text-green-700 font-medium">Tekanan Darah</p>
                        <p class="text-green-900">{{ $data['sistole'] ?? '-' }}/{{ $data['diastole'] ?? '-' }} mmHg</p>
                    </div>
                    <div>
                        <p class="text-green-700 font-medium">Status TD</p>
                        <p class="text-green-900">{{ $data['tekanan_darah_status'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Skrining TBC</h3>

                <div class="space-y-3 mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="batuk" id="batuk" value="1"
                               {{ ($data['batuk'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500">
                        <label for="batuk" class="ml-2 text-sm text-gray-700">
                            Batuk terus-menerus
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="demam" id="demam" value="1"
                               {{ ($data['demam'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500">
                        <label for="demam" class="ml-2 text-sm text-gray-700">
                            Demam kurang lebih 2 minggu
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="bb_turun" id="bb_turun" value="1"
                               {{ ($data['bb_turun'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500">
                        <label for="bb_turun" class="ml-2 text-sm text-gray-700">
                            BB tidak naik atau turun dalam 2 bulan berturut-turut
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="kontak_tbc" id="kontak_tbc" value="1"
                               {{ ($data['kontak_tbc'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500">
                        <label for="kontak_tbc" class="ml-2 text-sm text-gray-700">
                            Kontak erat dengan pasien TBC
                        </label>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg p-4 bg-white">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Hasil Skrining TBC
                    </label>
                    <select name="status_tbc" id="status_tbc"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('status_tbc') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ ($data['status_tbc'] ?? null) === 'Ya' ? 'selected' : '' }}>Ya (Perlu Rujukan)</option>
                        <option value="Tidak" {{ ($data['status_tbc'] ?? null) === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        <option value="Dirujuk" {{ ($data['status_tbc'] ?? null) === 'Dirujuk' ? 'selected' : '' }}>Dirujuk</option>
                    </select>
                    @error('status_tbc')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pelayanan Kesehatan</h3>

                <div class="space-y-4">
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="vitamin_a" id="vitamin_a" value="1"
                               {{ ($data['vitamin_a'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500">
                        <label for="vitamin_a" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Pemberian Vitamin A
                        </label>
                    </div>

                    <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" name="menyusui" id="menyusui" value="1"
                               {{ ($data['menyusui'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500">
                        <label for="menyusui" class="ml-3 text-sm text-gray-700 font-medium cursor-pointer flex-1">
                            Konsultasi & Dukungan Menyusui
                        </label>
                    </div>

                    <div class="p-4 border border-gray-200 rounded-lg bg-violet-50/40">
                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="kb_pasca_persalinan" {{ ($data['kb'] ?? '') !== '' ? 'checked' : '' }} class="mt-1 w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500" disabled>
                            <div class="flex-1">
                                <label for="kb_pasca_persalinan" class="text-sm font-semibold text-gray-800 mb-2 block">
                                    Mengikuti KB Pasca Persalinan
                                </label>
                                <select name="kb" id="kb"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('kb') border-red-500 @enderror">
                                    <option value="">-- Pilih Jenis KB --</option>
                                    <option value="Pil" {{ ($data['kb'] ?? null) === 'Pil' ? 'selected' : '' }}>Pil</option>
                                    <option value="Kondom" {{ ($data['kb'] ?? null) === 'Kondom' ? 'selected' : '' }}>Kondom</option>
                                    <option value="Suntik" {{ ($data['kb'] ?? null) === 'Suntik' ? 'selected' : '' }}>Suntik</option>
                                    <option value="IUD" {{ ($data['kb'] ?? null) === 'IUD' ? 'selected' : '' }}>IUD</option>
                                    <option value="Implan" {{ ($data['kb'] ?? null) === 'Implan' ? 'selected' : '' }}>Implan</option>
                                    <option value="Lain-lain" {{ ($data['kb'] ?? null) === 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                </select>
                                @error('kb')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-nifas.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-nifas.stage', ['stage' => 2, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 2
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-rose-600 hover:bg-rose-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 4
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
@endpush
@endsection
