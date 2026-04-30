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
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                    <div>
                        <p class="text-teal-700 font-medium">Berat Badan</p>
                        <p class="text-teal-900">{{ $data['berat_badan'] ?? '-' }} kg</p>
                    </div>
                    <div>
                        <p class="text-teal-700 font-medium">Status BB</p>
                        <p class="text-teal-900">{{ $data['naik_tidak_naik'] ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-teal-700 font-medium">Panjang Badan</p>
                        <p class="text-teal-900">{{ $data['panjang_badan'] ?? '-' }} cm</p>
                    </div>
                    <div>
                        <p class="text-teal-700 font-medium">Lingkar Kepala</p>
                        <p class="text-teal-900">{{ $data['lingkar_kepala'] ?? '-' }} cm</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="border-t pt-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Gizi & Pengukuran</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status_bb_u" class="block text-sm font-medium text-gray-700 mb-2">
                            Status BB/U
                        </label>
                        <select name="status_bb_u" id="status_bb_u"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                            <option value="">-- Pilih --</option>
                            <option value="Sangat Kurang" {{ ($data['status_bb_u'] ?? null) === 'Sangat Kurang' ? 'selected' : '' }}>Sangat Kurang</option>
                            <option value="Kurang" {{ ($data['status_bb_u'] ?? null) === 'Kurang' ? 'selected' : '' }}>Kurang</option>
                            <option value="Normal" {{ ($data['status_bb_u'] ?? null) === 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Lebih" {{ ($data['status_bb_u'] ?? null) === 'Lebih' ? 'selected' : '' }}>Lebih</option>
                        </select>
                        @error('status_bb_u')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status_pb_u" class="block text-sm font-medium text-gray-700 mb-2">
                            Status PB/U
                        </label>
                        <select name="status_pb_u" id="status_pb_u"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                            <option value="">-- Pilih --</option>
                            <option value="Sangat Pendek" {{ ($data['status_pb_u'] ?? null) === 'Sangat Pendek' ? 'selected' : '' }}>Sangat Pendek</option>
                            <option value="Pendek" {{ ($data['status_pb_u'] ?? null) === 'Pendek' ? 'selected' : '' }}>Pendek</option>
                            <option value="Normal" {{ ($data['status_pb_u'] ?? null) === 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Tinggi" {{ ($data['status_pb_u'] ?? null) === 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                        @error('status_pb_u')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status_bb_pb" class="block text-sm font-medium text-gray-700 mb-2">
                            Status BB/PB
                        </label>
                        <select name="status_bb_pb" id="status_bb_pb"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                            <option value="">-- Pilih --</option>
                            <option value="Buruk" {{ ($data['status_bb_pb'] ?? null) === 'Buruk' ? 'selected' : '' }}>Buruk</option>
                            <option value="Kurang" {{ ($data['status_bb_pb'] ?? null) === 'Kurang' ? 'selected' : '' }}>Kurang</option>
                            <option value="Normal" {{ ($data['status_bb_pb'] ?? null) === 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Lebih" {{ ($data['status_bb_pb'] ?? null) === 'Lebih' ? 'selected' : '' }}>Lebih</option>
                        </select>
                        @error('status_bb_pb')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lingkar_lengan" class="block text-sm font-medium text-gray-700 mb-2">
                            LILA / Lingkar Lengan Atas (cm)
                        </label>
                        <input type="number" name="lingkar_lengan" id="lingkar_lengan"
                               value="{{ $data['lingkar_lengan'] ?? '' }}" step="0.1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent @error('lingkar_lengan') border-red-500 @enderror">
                        @error('lingkar_lengan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status_lila" class="block text-sm font-medium text-gray-700 mb-2">
                            Status LILA
                        </label>
                        <select name="status_lila" id="status_lila"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                            <option value="">-- Pilih --</option>
                            <option value="Hijau" {{ ($data['status_lila'] ?? null) === 'Hijau' ? 'selected' : '' }}>Hijau (Normal)</option>
                            <option value="Kuning" {{ ($data['status_lila'] ?? null) === 'Kuning' ? 'selected' : '' }}>Kuning (Kurang)</option>
                            <option value="Merah" {{ ($data['status_lila'] ?? null) === 'Merah' ? 'selected' : '' }}>Merah (Gawat)</option>
                        </select>
                        @error('status_lila')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3 pt-6 border-t">
                @if($pemeriksaan)
                <a href="{{ route('pemeriksaan-balita.stage', ['stage' => 1, 'pemeriksaan_id' => $pemeriksaan->id]) }}" class="px-6 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
                    ← Kembali
                </a>
                @endif
                <button type="submit" class="px-6 py-2 text-white bg-cyan-600 hover:bg-cyan-700 rounded-lg font-medium transition">
                    Simpan Tahap 2
                </button>
                <a href="{{ route('pemeriksaan-balita.create') }}" class="px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
