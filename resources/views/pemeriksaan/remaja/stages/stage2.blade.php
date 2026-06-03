@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-cyan-900">Pemeriksaan Remaja - Tahap 2</h2>
        <p class="text-gray-600 mt-1">Pemeriksaan Tekanan Darah & Gula Darah</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-remaja.index') }}" class="hover:text-cyan-600">Pemeriksaan Remaja</a>
            <span class="mx-2">/</span>
            <span>Tahap 2</span>
        </nav>
    </div>

    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 2/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-cyan-600 h-2 rounded-full" style="width: 50%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-remaja.stage-store', 2) }}" method="POST">
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
                        Cari Remaja
                    </label>
                    <input type="text" id="search_remaja" placeholder="Ketik nama atau NIK remaja..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent mb-3">
                    <p class="text-xs text-gray-500">Total: <span id="total_remaja">{{ count($remajas) }}</span> remaja</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="remaja_identitas_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Remaja <span class="text-red-500">*</span></label>
                        <select name="remaja_identitas_id" id="remaja_identitas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('remaja_identitas_id') border-red-500 @enderror" required>
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
                        <label for="waktu_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                        <input type="date" name="waktu_kunjungan" id="waktu_kunjungan" value="{{ old('waktu_kunjungan', $data['waktu_kunjungan'] ?? date('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('waktu_kunjungan') border-red-500 @enderror" required>
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
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pemeriksaan Tekanan Darah & Gula Darah</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sistole" class="block text-sm font-medium text-gray-700 mb-2">Sistole</label>
                        <input type="number" name="sistole" id="sistole" value="{{ old('sistole', $data['sistole'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('sistole') border-red-500 @enderror" min="0">
                        @error('sistole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="diastole" class="block text-sm font-medium text-gray-700 mb-2">Diastole</label>
                        <input type="number" name="diastole" id="diastole" value="{{ old('diastole', $data['diastole'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('diastole') border-red-500 @enderror" min="0">
                        @error('diastole')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tekanan_darah_status_display" class="block text-sm font-medium text-gray-700 mb-2">Status Tekanan Darah (Otomatis)</label>
                        <input type="text" id="tekanan_darah_status_display" value="{{ old('tekanan_darah_status', $data['tekanan_darah_status'] ?? 'Akan dihitung otomatis') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-slate-50 text-gray-800" readonly>
                        <input type="hidden" name="tekanan_darah_status" id="tekanan_darah_status" value="{{ old('tekanan_darah_status', $data['tekanan_darah_status'] ?? '') }}">
                        @error('tekanan_darah_status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gula_darah" class="block text-sm font-medium text-gray-700 mb-2">Gula Darah (mg/dL)</label>
                        <input type="number" step="0.1" name="gula_darah" id="gula_darah" value="{{ old('gula_darah', $data['gula_darah'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('gula_darah') border-red-500 @enderror" min="0" max="1000">
                        @error('gula_darah')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Status: <span id="gula_darah_status_display">-</span></p>
                    </div>

                    <div>
                        <label for="hemoglobin" class="block text-sm font-medium text-gray-700 mb-2">Hemoglobin</label>
                        <input type="text" name="hemoglobin" id="hemoglobin" value="{{ old('hemoglobin', $data['hemoglobin'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('hemoglobin') border-red-500 @enderror">
                        @error('hemoglobin')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="anemia" class="block text-sm font-medium text-gray-700 mb-2">Anemia</label>
                        <select name="anemia" id="anemia" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('anemia') border-red-500 @enderror">
                            <option value="">-- Pilih --</option>
                            <option value="Ya" {{ old('anemia', $data['anemia'] ?? '') === 'Ya' ? 'selected' : '' }}>Ya</option>
                            <option value="Tidak" {{ old('anemia', $data['anemia'] ?? '') === 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('anemia')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-remaja.index') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">Batal</a>
                @if($pemeriksaan)
                    <a href="{{ route('pemeriksaan-remaja.stage', ['stage' => 1, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">Kembali ke Tahap 1</a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-cyan-600 hover:bg-cyan-700 font-semibold rounded-xl transition w-full sm:w-auto">Lanjutkan ke Tahap 3</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function calculateTekananDarahStatus() {
        const sistole = parseInt(document.getElementById('sistole')?.value, 10);
        const diastole = parseInt(document.getElementById('diastole')?.value, 10);
        const display = document.getElementById('tekanan_darah_status_display');
        const hidden = document.getElementById('tekanan_darah_status');

        let status = '-';

        if (!isNaN(sistole) && !isNaN(diastole)) {
            if (sistole >= 140 || diastole >= 90) {
                status = 'Tinggi';
            } else if (sistole < 90 || diastole < 60) {
                status = 'Rendah';
            } else {
                status = 'Normal';
            }
        }

        if (display) display.value = status;
        if (hidden) hidden.value = status === '-' ? '' : status;
    }

    function calculateGulaDarahStatus() {
        const gulaDarah = parseFloat(document.getElementById('gula_darah')?.value);
        const display = document.getElementById('gula_darah_status_display');

        let status = '-';

        if (!isNaN(gulaDarah)) {
            if (gulaDarah < 70) {
                status = 'Rendah';
            } else if (gulaDarah <= 140) {
                status = 'Normal';
            } else {
                status = 'Tinggi';
            }
        }

        if (display) display.textContent = status;
    }

    document.addEventListener('DOMContentLoaded', function () {
        ['sistole', 'diastole'].forEach(function (id) {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('input', calculateTekananDarahStatus);
            }
        });

        const gulaInput = document.getElementById('gula_darah');
        if (gulaInput) {
            gulaInput.addEventListener('input', calculateGulaDarahStatus);
        }

        calculateTekananDarahStatus();
        calculateGulaDarahStatus();

        // Search functionality
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
</script>
@endpush
@endsection