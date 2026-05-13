@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Ibu Hamil - Tahap 1</h2>
        <p class="text-gray-600 mt-1">Penimbangan & Pengukuran</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="hover:text-purple-600">Pemeriksaan Ibu Hamil</a>
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
            <div class="bg-purple-600 h-2 rounded-full" style="width: 25%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-ibu-hamil.stage-store', ['stage' => 1, 'pemeriksaan_id' => $pemeriksaan->id ?? request('pemeriksaan_id')]) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="ibu_hamil_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Ibu Hamil <span class="text-red-500">*</span>
                    </label>
                    <select name="ibu_hamil_identitas_id" id="ibu_hamil_identitas_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('ibu_hamil_identitas_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Ibu Hamil --</option>
                        @foreach($ibuHamils as $ibuHamil)
                            <option value="{{ $ibuHamil->id }}" {{ ($data['ibu_hamil_identitas_id'] ?? null) == $ibuHamil->id ? 'selected' : '' }}>
                                {{ $ibuHamil->nama }} - {{ $ibuHamil->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('ibu_hamil_identitas_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Kunjungan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                           value="{{ $data['tanggal_kunjungan'] ?? date('Y-m-d') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                    @error('tanggal_kunjungan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Data Pengukuran</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="usia_kehamilan" class="block text-sm font-medium text-gray-700 mb-2">
                            Usia Kehamilan (minggu)
                        </label>
                        <input type="number" name="usia_kehamilan" id="usia_kehamilan"
                               value="{{ $data['usia_kehamilan'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('usia_kehamilan') border-red-500 @enderror"
                               min="0" max="42">
                        @error('usia_kehamilan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat Badan (kg)
                        </label>
                        <input type="number" step="0.01" name="berat_badan" id="berat_badan"
                               value="{{ $data['berat_badan'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('berat_badan') border-red-500 @enderror"
                               min="0">
                        @error('berat_badan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lingkar_lengan" class="block text-sm font-medium text-gray-700 mb-2">
                            LILA / Lingkar Lengan Atas (cm)
                        </label>
                        <input type="number" step="0.01" name="lingkar_lengan" id="lingkar_lengan"
                               value="{{ $data['lingkar_lengan'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('lingkar_lengan') border-red-500 @enderror"
                               min="0">
                        @error('lingkar_lengan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status_bb" class="block text-sm font-medium text-gray-700 mb-2">
                            Status BB (Naik/Turun/Tetap)
                        </label>
                        <div id="status_bb_display" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-slate-50 text-gray-800">
                            {{ $data['status_bb'] ?? 'Akan dihitung otomatis dari berat sebelumnya' }}
                        </div>
                        <input type="hidden" name="status_bb" id="status_bb" value="{{ $data['status_bb'] ?? '' }}">
                    </div>
                </div>

                <div class="mt-6 col-span-full">
                    <div class="bg-slate-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700">
                        <div class="font-semibold text-gray-800 mb-2">Ringkasan Akumulasi Berat</div>
                        <p id="status_summary" class="mb-2">Pilih ibu hamil dan masukkan berat badan untuk melihat akumulasi.</p>
                        <p id="summary_previous_weight" class="mb-1 text-sm text-gray-600"></p>
                        <p id="summary_note" class="text-sm text-gray-500"></p>
                    </div>
                </div>

                <div class="mt-4 col-span-full">
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-sm text-purple-800">
                        <div class="font-semibold text-purple-900 mb-2">Keterangan Status Berat</div>
                        <p><span class="font-semibold">Naik:</span> Berat saat ini lebih tinggi dari pemeriksaan sebelumnya.</p>
                        <p><span class="font-semibold">Turun:</span> Berat saat ini lebih rendah dari pemeriksaan sebelumnya.</p>
                        <p><span class="font-semibold">Tetap:</span> Berat saat ini sama dengan pemeriksaan sebelumnya.</p>
                        <p><span class="font-semibold">Pertama:</span> Belum ada data pemeriksaan sebelumnya.</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-ibu-hamil.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 text-white bg-purple-600 hover:bg-purple-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 2
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ibuSelect = document.getElementById('ibu_hamil_identitas_id');
        const beratInput = document.getElementById('berat_badan');
        const statusDisplay = document.getElementById('status_bb_display');
        const statusInput = document.getElementById('status_bb');

        const previousWeights = @json($previousWeights ?? []);

        function formatKg(value) {
            return Number(value).toFixed(2).replace(/\.00$/, '') + ' kg';
        }

        function setSummary(message, previous, note) {
            const summary = document.getElementById('status_summary');
            const previousWeight = document.getElementById('summary_previous_weight');
            const noteText = document.getElementById('summary_note');

            if (summary) summary.textContent = message || '';
            if (previousWeight) previousWeight.textContent = previous || '';
            if (noteText) noteText.textContent = note || '';
        }

        function updateStatus() {
            const selectedId = ibuSelect ? ibuSelect.value : null;
            const currentWeight = parseFloat(beratInput.value);
            const previous = selectedId ? previousWeights[selectedId] ?? null : null;

            if (!selectedId) {
                statusDisplay.textContent = 'Pilih ibu hamil dan masukkan berat badan untuk menghitung status BB.';
                statusInput.value = '';
                setSummary('Pilih ibu hamil dan masukkan berat badan untuk melihat akumulasi.', '', '');
                return;
            }

            if (!previous) {
                statusDisplay.textContent = currentWeight ? 'Pertama kali, status BB akan disimpan sebagai Pertama.' : 'Masukkan berat badan untuk menghitung status BB.';
                statusInput.value = currentWeight ? 'Pertama' : '';
                setSummary(currentWeight ? 'Pengukuran pertama untuk ibu ini.' : 'Masukkan berat badan untuk melihat akumulasi.', '', '');
                return;
            }

            if (isNaN(currentWeight)) {
                statusDisplay.textContent = 'Masukkan berat badan untuk menghitung naik/turun/tetap dibanding pemeriksaan sebelumnya.';
                statusInput.value = '';
                setSummary('Data berat sebelumnya ditemukan.', `Berat sebelumnya: ${formatKg(previous.berat_badan)} pada ${previous.tanggal_kunjungan}.`, 'Masukkan berat badan saat ini untuk melihat perubahan.');
                return;
            }

            const prevWeight = parseFloat(previous.berat_badan);
            let status;
            if (currentWeight > prevWeight) {
                status = 'Naik';
            } else if (currentWeight < prevWeight) {
                status = 'Turun';
            } else {
                status = 'Tetap';
            }

            statusDisplay.textContent = `${status} (sebelumnya ${formatKg(prevWeight)} pada ${previous.tanggal_kunjungan}).`;
            statusInput.value = status;
            setSummary(`Perubahan berat: ${status}.`, `Berat sebelumnya: ${formatKg(prevWeight)} pada ${previous.tanggal_kunjungan}.`, `Selisih: ${(currentWeight - prevWeight).toFixed(2)} kg.`);
        }

        if (ibuSelect) {
            ibuSelect.addEventListener('change', updateStatus);
        }
        if (beratInput) {
            beratInput.addEventListener('input', updateStatus);
        }

        updateStatus();
    });
</script>
@endpush
@endsection
