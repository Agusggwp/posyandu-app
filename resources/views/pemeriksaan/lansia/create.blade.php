@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Lansia - Sistem 4 Tahap</h2>
        <p class="text-gray-600 mt-1">Pilih meja/tahap pemeriksaan yang ingin dilanjutkan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-lansia.index') }}" class="hover:text-amber-600">Pemeriksaan Lansia</a>
            <span class="mx-2">/</span>
            <span>Tambah</span>
        </nav>
    </div>

    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 sm:p-5 mb-6">
        <p class="text-sm text-amber-900">
            Pemeriksaan dibagi menjadi 4 meja. Setiap tahap bisa dilanjutkan oleh user berbeda sesuai alur pemeriksaan.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-amber-500">
            <div class="p-6 bg-gradient-to-r from-amber-50 to-orange-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-600 text-white flex items-center justify-center text-xl font-bold">1</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Peninjauan & Pengukuran</h3>
                        <p class="text-sm text-gray-600">Berat badan, tinggi badan, lingkar perut, IMT</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-lansia.stage', 1) }}" class="block w-full text-center bg-amber-600 hover:bg-amber-700 text-white font-semibold py-3 rounded-xl transition">
                    Mulai Tahap 1
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-cyan-500">
            <div class="p-6 bg-gradient-to-r from-cyan-50 to-sky-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-cyan-600 text-white flex items-center justify-center text-xl font-bold">2</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Pemeriksaan Kesehatan</h3>
                        <p class="text-sm text-gray-600">Tekanan darah, gula darah, status kesehatan</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-lansia.stage', 2) }}" class="block w-full text-center bg-cyan-600 hover:bg-cyan-700 text-white font-semibold py-3 rounded-xl transition">
                    Mulai Tahap 2
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-teal-500">
            <div class="p-6 bg-gradient-to-r from-teal-50 to-emerald-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-600 text-white flex items-center justify-center text-xl font-bold">3</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Pelayanan & Mata Telinga</h3>
                        <p class="text-sm text-gray-600">Tes mata, telinga, dan kemampuan kognitif</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-lansia.stage', 3) }}" class="block w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 rounded-xl transition">
                    Mulai Tahap 3
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-purple-500">
            <div class="p-6 bg-gradient-to-r from-purple-50 to-indigo-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-600 text-white flex items-center justify-center text-xl font-bold">4</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Skrining Penyakit & Rujukan</h3>
                        <p class="text-sm text-gray-600">TBC, PUMA, edukasi dan rujukan final</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-lansia.stage', 4) }}" class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-xl transition">
                    Mulai Tahap 4
                </a>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-clipboard-list text-amber-600 mr-2"></i>
                Pemeriksaan yang Belum Selesai
            </h3>
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
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lansia</th>
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
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->lansia->nama ?? $item->dewasa_identitas_id }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    {{ $item->tanggal_kunjungan ? \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    Tahap {{ $item->tahap_terakhir ?: 1 }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <a href="{{ route('pemeriksaan-lansia.stage', ['stage' => $nextStage, 'pemeriksaan_id' => $item->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-amber-600 hover:bg-amber-700 text-white font-medium">
                                        Lanjutkan
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="mt-8">
        <a href="{{ route('pemeriksaan-lansia.index') }}" class="inline-flex items-center gap-2 text-amber-600 hover:text-amber-700 font-medium">
            <i class="fas fa-arrow-left"></i>
            Kembali ke daftar pemeriksaan
        </a>
    </div>
</div>
@endsection
