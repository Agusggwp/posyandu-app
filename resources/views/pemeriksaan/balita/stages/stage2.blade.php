@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Balita - Tahap 2</h2>
        <p class="text-gray-600 mt-1">Status Gizi & Pengukuran</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-balita.index') }}" class="hover:text-cyan-600">Pemeriksaan Balita</a>
            <span class="mx-2">/</span>
            <span>Tahap 2</span>
        </nav>
    </div>

    <!-- Progress Bar -->
    <div class="mb-6">
        <div class="flex gap-2 mb-2">
            <span class="text-sm font-medium text-gray-600">Progress: 2/4</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-cyan-600 h-2 rounded-full" style="width: 50%"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <form action="{{ route('pemeriksaan-balita.stage-store', 2) }}" method="POST">
            @csrf

            @if($pemeriksaan)
                <input type="hidden" name="balita_identitas_id" value="{{ $pemeriksaan->balita_identitas_id }}">
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
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('balita_identitas_id') border-red-500 @enderror" required>
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
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('tanggal_kunjungan') border-red-500 @enderror" required>
                        @error('tanggal_kunjungan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Summary dari Tahap 1 -->
            @if($data)
            <div class="bg-teal-50 border border-teal-200 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-teal-900 mb-3">Data dari Tahap 1</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3 text-sm">
                    <div>
                        <p class="text-teal-700 font-medium">Berat Badan</p>
                        <p class="text-teal-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                    </div>
                    <div>
                        <p class="text-teal-700 font-medium">Status BB</p>
                        <p class="text-teal-900">{{ $data['naik_tidak_naik'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-teal-700 font-medium">Tinggi Badan</p>
                        <p class="text-teal-900">{{ $data['panjang_badan'] ?? '-' }} cm</p>
                    </div>
                    <div>
                        <p class="text-teal-700 font-medium">Lingkar Kepala</p>
                        <p class="text-teal-900">{{ $data['lingkar_kepala'] ?? '-' }} cm</p>
                    </div>
                    <div>
                        <p class="text-teal-700 font-medium">LILA</p>
                        <p class="text-teal-900">{{ $data['lingkar_lengan'] ?? '-' }} cm</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Gizi & Pengukuran</h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="status_bb_u_display" class="block text-sm font-medium text-gray-700 mb-2">
                            Status BB/U (Otomatis)
                        </label>
                        <input type="text" id="status_bb_u_display"
                               value="{{ $data['status_bb_u'] ?? '-' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700"
                               readonly>
                    </div>

                    <div>
                        <label for="status_pb_u_display" class="block text-sm font-medium text-gray-700 mb-2">
                            Status TB/U (Otomatis)
                        </label>
                        <input type="text" id="status_pb_u_display"
                               value="{{ $data['status_pb_u'] ?? '-' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700"
                               readonly>
                    </div>

                    <div>
                        <label for="status_bb_pb_display" class="block text-sm font-medium text-gray-700 mb-2">
                            Status BB/TB (Otomatis)
                        </label>
                        <input type="text" id="status_bb_pb_display"
                               value="{{ $data['status_bb_pb'] ?? '-' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700"
                               readonly>
                    </div>

                    <div>
                        <label for="status_lila_display" class="block text-sm font-medium text-gray-700 mb-2">
                            Status LILA (Otomatis)
                        </label>
                        <input type="text" id="status_lila_display"
                               value="{{ $data['status_lila'] ?? '-' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700"
                               readonly>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t">
                <a href="{{ route('pemeriksaan-balita.create') }}" class="px-6 py-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Batal
                </a>
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-balita.stage', ['stage' => 1, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition w-full sm:w-auto text-center">
                    Kembali ke Tahap 1
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-cyan-600 hover:bg-cyan-700 font-semibold rounded-xl transition w-full sm:w-auto">
                    Lanjutkan ke Tahap 3
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
