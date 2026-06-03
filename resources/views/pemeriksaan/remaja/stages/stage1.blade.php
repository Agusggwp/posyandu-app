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
                    Cari Remaja
                </label>
                <input type="text" id="search_remaja" placeholder="Ketik nama atau NIK remaja..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent mb-3">
                <p class="text-xs text-gray-500">Total: <span id="total_remaja">{{ count($remajas) }}</span> remaja</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="remaja_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Remaja <span class="text-red-500">*</span>
                    </label>
                    <select name="remaja_identitas_id" id="remaja_identitas_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('remaja_identitas_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Pilih Remaja --</option>
                        @foreach($remajas as $remaja)
                            <option value="{{ $remaja->id }}" {{ old('remaja_identitas_id', $data['remaja_identitas_id'] ?? '') == $remaja->id ? 'selected' : '' }}>
                                {{ $remaja->nama_anak }} - {{ $remaja->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('remaja_identitas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
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
    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search_remaja');
        const selectDropdown = document.getElementById('remaja_identitas_id');
        const totalCount = document.getElementById('total_remaja');

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