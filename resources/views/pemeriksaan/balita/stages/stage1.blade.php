@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Balita - Tahap 1</h2>
        <p class="text-gray-600 mt-1">Penimbangan & Pengukuran</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-teal-600">Pemeriksaan Balita</a>
            <span class="mx-2">/</span>
            <span>Tahap 1</span>
        </nav>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 1/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-teal-600 h-2 rounded-full" style="width: 25%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-balita.stage-store', 1) }}" method="POST">
            @csrf

            @if($pemeriksaan)
                <input type="hidden" id="balita_identitas_id" name="balita_identitas_id" value="{{ $pemeriksaan->balita_identitas_id }}">
                <input type="hidden" name="tanggal_kunjungan" value="{{ optional($pemeriksaan->tanggal_kunjungan)->format('Y-m-d') ?? $pemeriksaan->tanggal_kunjungan }}">
                <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-green-900 font-medium">Melanjutkan pemeriksaan untuk {{ $pemeriksaan->balita->nama_bayi ?? '-' }}. Data balita dan tanggal kunjungan sudah dikunci dari tahap sebelumnya.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="balita_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Balita <span class="text-red-500">*</span>
                        </label>
                        <select name="balita_identitas_id" id="balita_identitas_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('balita_identitas_id') border-red-500 @enderror" required>
                            <option value="">-- Pilih Balita --</option>
                            @foreach($balitas as $balita)
                                <option value="{{ $balita->id }}" {{ (old('balita_identitas_id', $data['balita_identitas_id'] ?? null)) == $balita->id ? 'selected' : '' }}>
                                    {{ $balita->nama_bayi }} - {{ $balita->nik }}
                                </option>
                            @endforeach
                        </select>
                        @error('balita_identitas_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                               value="{{ old('tanggal_kunjungan', $data['tanggal_kunjungan'] ?? date('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Penimbangan & Pengukuran</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat Badan (kg) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="berat_badan" id="berat_badan"
                               value="{{ $data['berat_badan'] ?? '' }}" step="0.1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror"
                               required>
                        @error('berat_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="previous_weight" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat Sebelumnya
                        </label>
                        <div id="previous_weight" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-slate-50 text-gray-800">
                            {{ $data['naik_tidak_naik'] ?? 'Pilih balita dan masukkan berat badan untuk melihat akumulasi' }}
                        </div>
                    </div>

                    <div>
                        <label for="panjang_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Panjang Badan (cm) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="panjang_badan" id="panjang_badan"
                               value="{{ $data['panjang_badan'] ?? '' }}" step="0.1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('panjang_badan') border-red-500 @enderror"
                               required>
                        @error('panjang_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700 mb-2">
                            Lingkar Kepala (cm)
                        </label>
                        <input type="number" name="lingkar_kepala" id="lingkar_kepala"
                               value="{{ $data['lingkar_kepala'] ?? '' }}" step="0.1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent @error('lingkar_kepala') border-red-500 @enderror">
                        @error('lingkar_kepala')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-4">
                    <div class="bg-slate-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700">
                        <div class="font-semibold text-gray-800 mb-2">Ringkasan Akumulasi Berat</div>
                        <p id="weight_trend" class="mb-2">Pilih balita dan masukkan berat badan untuk melihat perubahan.</p>
                        <p id="weight_delta" class="mb-1"></p>
                        <p id="weight_previous_date" class="text-sm text-gray-500"></p>
                    </div>

                    <div class="bg-teal-50 border border-teal-200 rounded-lg p-4 text-sm text-teal-800">
                        <div class="font-semibold text-teal-900 mb-2">Keterangan Status Berat</div>
                        <p><span class="font-semibold">Naik:</span> Berat saat ini lebih tinggi dari pemeriksaan sebelumnya.</p>
                        <p><span class="font-semibold">Turun:</span> Berat saat ini lebih rendah dari pemeriksaan sebelumnya.</p>
                        <p><span class="font-semibold">Tetap:</span> Berat saat ini sama dengan pemeriksaan sebelumnya.</p>
                        <p><span class="font-semibold">Pertama:</span> Belum ada data pemeriksaan sebelumnya.</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3 pt-6 border-t">
                <button type="submit" class="px-6 py-2 text-white bg-teal-600 hover:bg-teal-700 rounded-lg font-medium transition">
                    Simpan Tahap 1
                </button>
                <a href="{{ route('pemeriksaan-balita.create') }}" class="px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const balitaSelect = document.getElementById('balita_identitas_id');
        const beratInput = document.getElementById('berat_badan');
        const prevWeightBox = document.getElementById('previous_weight');
        const weightTrend = document.getElementById('weight_trend');
        const weightDelta = document.getElementById('weight_delta');
        const weightPreviousDate = document.getElementById('weight_previous_date');

        const previousWeights = @json($previousWeights ?? []);

        function formatKg(value) {
            return Number(value).toFixed(1).replace(/\.0$/, '') + ' kg';
        }

        function updateAccumulation() {
            const selectedId = balitaSelect ? balitaSelect.value : null;
            const currentWeight = parseFloat(beratInput.value);
            const previous = selectedId ? (previousWeights[selectedId] ?? null) : null;

            if (!selectedId) {
                prevWeightBox.textContent = 'Pilih balita untuk melihat data pemeriksaan sebelumnya.';
                weightTrend.textContent = 'Pilih balita dan masukkan berat badan untuk melihat perubahan.';
                weightDelta.textContent = '';
                weightPreviousDate.textContent = '';
                return;
            }

            if (!previous) {
                prevWeightBox.textContent = 'Belum ada pemeriksaan sebelumnya untuk balita ini.';
                weightTrend.textContent = currentWeight ? 'Ini adalah pengukuran pertama.' : 'Masukkan berat badan untuk menghitung perubahan.';
                weightDelta.textContent = '';
                weightPreviousDate.textContent = '';
                return;
            }

            const previousDate = previous.tanggal_kunjungan || 'tanggal tidak tersedia';
            prevWeightBox.textContent = `Terakhir tercatat ${formatKg(previous.berat_badan)} pada ${previousDate}.`;
            weightPreviousDate.textContent = previous.tanggal_kunjungan ? `Tanggal pemeriksaan sebelumnya: ${previous.tanggal_kunjungan}` : '';

            if (isNaN(currentWeight)) {
                weightTrend.textContent = 'Masukkan berat badan untuk menghitung perubahan terhadap pemeriksaan sebelumnya.';
                weightDelta.textContent = '';
                return;
            }

            const delta = currentWeight - parseFloat(previous.berat_badan);
            const sign = delta > 0 ? '+' : '';
            const trend = delta > 0 ? 'Naik' : delta < 0 ? 'Turun' : 'Tetap';

            weightTrend.textContent = `Perubahan berat: ${trend}.`;
            weightDelta.textContent = `Selisih: ${sign}${delta.toFixed(1)} kg dibanding pemeriksaan sebelumnya.`;
        }

        if (balitaSelect) {
            balitaSelect.addEventListener('change', updateAccumulation);
        }
        if (beratInput) {
            beratInput.addEventListener('input', updateAccumulation);
        }

        updateAccumulation();
    });
</script>
@endpush
@endsection
