@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Nifas - Tahap 4</h2>
        <p class="text-gray-600 mt-1">Edukasi & Rujukan + Ringkasan Data</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-nifas.index') }}" class="hover:text-orange-600">Pemeriksaan Nifas</a>
            <span class="mx-2">/</span>
            <span>Tahap 4</span>
        </nav>
    </div>
                        <p class="text-gray-600">Status LILA:</p>
    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 4/4 - Final</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-orange-600 h-2 rounded-full" style="width: 100%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-nifas.stage-store', 4) }}" method="POST">
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
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-600 focus:border-transparent mb-3">
                    <p class="text-xs text-gray-500">Total: <span id="total_nifas">{{ count($nifases ?? []) }}</span> ibu nifas</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nifas_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Ibu Nifas <span class="text-red-500">*</span>
                        </label>
                        <select name="nifas_identitas_id" id="nifas_identitas_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('nifas_identitas_id') border-red-500 @enderror" required>
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Semua Tahap -->
            @if($data)
            <div class="bg-gradient-to-r from-orange-50 to-yellow-50 border border-orange-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Ringkasan Data Pemeriksaan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tahap 1 -->
                    <div class="border-l-4 border-violet-500 pl-4">
                        <h4 class="font-semibold text-violet-900 mb-3">Tahap 1: Penimbangan & Pengukuran</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Berat Badan:</span>
                                <span class="font-medium">{{ $data['berat_badan'] ?? '-' }} kg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Naik/Turun:</span>
                                <span class="font-medium">{{ $data['naik_turun'] ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tinggi Badan:</span>
                                <span class="font-medium">{{ $data['tinggi_badan'] ?? '-' }} cm</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">LILA:</span>
                                <span class="font-medium">{{ $data['lila'] ?? '-' }} cm</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status LILA:</span>
                                <span class="font-medium">{{ $data['status_gizi'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tahap 2 -->
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="font-semibold text-blue-900 mb-3">Tahap 2: Pemeriksaan</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tekanan Darah:</span>
                                <span class="font-medium">{{ $data['sistole'] ?? '-' }}/{{ $data['diastole'] ?? '-' }} mmHg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status TD:</span>
                                <span class="font-medium">{{ $data['tekanan_darah_status'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tahap 3 -->
                    <div class="border-l-4 border-emerald-500 pl-4">
                        <h4 class="font-semibold text-emerald-900 mb-3">Tahap 3: Pelayanan Kesehatan</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Vitamin A:</span>
                                <span class="font-medium">{{ $data['vitamin_a'] ? '✓ Ya' : '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Menyusui:</span>
                                <span class="font-medium">{{ $data['menyusui'] ? '✓ Ya' : '-' }}</span>
                            </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">KB:</span>
                                    <span class="font-medium">{{ $data['kb'] ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Skrining TBC:</span>
                                    <span class="font-medium">{{ $data['status_tbc'] ?? '-' }}</span>
                                </div>
                        </div>
                    </div>

                    <!-- Info Lainnya -->
                    <div class="border-l-4 border-orange-500 pl-4">
                        <h4 class="font-semibold text-orange-900 mb-3">Informasi Tambahan</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Kunjungan:</span>
                                <span class="font-medium">{{ $data['tanggal_kunjungan'] ? \Carbon\Carbon::parse($data['tanggal_kunjungan'])->format('d M Y') : '-' }}</span>
                            </div>
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
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('edukasi') border-red-500 @enderror"
                              placeholder="Catatan edukasi untuk ibu nifas...">{{ $data['edukasi'] ?? '' }}</textarea>
                    @error('edukasi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="rujukan" class="block text-sm font-medium text-gray-700 mb-2">
                        Rujukan
                    </label>
                    <select name="rujukan" id="rujukan"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('rujukan') border-red-500 @enderror">
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

            <!-- Success Message -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-yellow-900 font-medium">
                    ⚠️ Dengan menyimpan tahap ini, semua data pemeriksaan nifas akan disimpan dan dianggap selesai.
                </p>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-nifas.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-nifas.stage', ['stage' => 3, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 3
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-rose-600 hover:bg-rose-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Selesaikan Pemeriksaan
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
