@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-cyan-900">Pemeriksaan Remaja - Sistem 4 Tahap</h2>
        <p class="text-gray-600 mt-1">Pilih tahap pemeriksaan yang ingin dilanjutkan atau lanjutkan pemeriksaan yang masih tertunda.</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-remaja.index') }}" class="hover:text-cyan-600">Pemeriksaan Remaja</a>
            <span class="mx-2">/</span>
            <span>Tambah</span>
        </nav>
    </div>

    <div class="bg-sky-50 border border-sky-200 rounded-lg p-4 sm:p-5 mb-6">
        <p class="text-sm text-sky-900">
            Pemeriksaan dibagi menjadi 4 tahap. Setiap tahap dapat disimpan dan dilanjutkan lagi jika belum selesai.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-cyan-500">
            <div class="p-6 bg-gradient-to-r from-cyan-50 to-sky-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-cyan-600 text-white flex items-center justify-center text-xl font-bold">1</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Pengukuran & IMT</h3>
                        <p class="text-sm text-gray-600">Berat badan, tinggi badan, dan status IMT.</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-remaja.stage', 1) }}" class="block w-full text-center bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-3 rounded-xl transition">Mulai Tahap 1</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-sky-500">
            <div class="p-6 bg-gradient-to-r from-sky-50 to-blue-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-sky-600 text-white flex items-center justify-center text-xl font-bold">2</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Tekanan Darah & Lab</h3>
                        <p class="text-sm text-gray-600">Tekanan darah, gula darah, hemoglobin, dan anemia.</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-remaja.stage', 2) }}" class="block w-full text-center bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 rounded-xl transition">Mulai Tahap 2</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-indigo-500">
            <div class="p-6 bg-gradient-to-r from-indigo-50 to-violet-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-xl font-bold">3</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Skrining & Kesehatan</h3>
                        <p class="text-sm text-gray-600">Skrining TBC dan masalah kesehatan remaja.</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-remaja.stage', 3) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition">Mulai Tahap 3</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-amber-500">
            <div class="p-6 bg-gradient-to-r from-amber-50 to-yellow-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-600 text-white flex items-center justify-center text-xl font-bold">4</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Edukasi & Rujukan</h3>
                        <p class="text-sm text-gray-600">Catatan edukasi dan rujukan akhir.</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-remaja.stage', 4) }}" class="block w-full text-center bg-amber-600 hover:bg-amber-700 text-white font-semibold py-3 rounded-xl transition">Mulai Tahap 4</a>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pemeriksaan yang Belum Selesai</h3>
            <span class="text-sm text-gray-500">{{ $pemeriksaanBelumSelesai->count() }} data</span>
        </div>

        @if($pemeriksaanBelumSelesai->isEmpty())
            <div class="text-center py-10 text-gray-500">
                <i class="fas fa-check-circle text-4xl mb-3 text-green-400"></i>
                <p>Belum ada pemeriksaan yang tertunda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Remaja</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Kunjungan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tahap Terakhir</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pemeriksaanBelumSelesai as $item)
                            @php
                                $nextStage = max(1, min(4, (int) $item->tahap_terakhir + 1));
                            @endphp
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->remaja->nama_anak ?? $item->remaja_identitas_id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $item->tanggal_kunjungan ? \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') : '-' }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Tahap {{ $item->tahap_terakhir ?: 1 }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <a href="{{ route('pemeriksaan-remaja.stage', ['stage' => $nextStage, 'pemeriksaan_id' => $item->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-cyan-600 hover:bg-cyan-700 text-white font-medium">Lanjutkan</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="mt-8">
        <a href="{{ route('pemeriksaan-remaja.index') }}" class="inline-flex items-center gap-2 text-cyan-600 hover:text-cyan-700 font-medium">
            <i class="fas fa-arrow-left"></i>
            Kembali ke daftar pemeriksaan
        </a>
    </div>
</div>
@endsection
