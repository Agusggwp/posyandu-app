@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Laporan Pemeriksaan Ibu Hamil</h2>
        <p class="text-gray-600">Filter dan cetak laporan data ibu hamil</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <form method="GET" action="{{ route('laporan.ibu-hamil') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="bulan" class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                <select name="bulan" id="bulan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <option value="">Semua Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                <select name="tahun" id="tahun" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ request('tahun', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 w-full">
                    Filter
                </button>
            </div>

            <div class="flex items-end">
                <button type="button" onclick="window.print()" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 w-full">
                    Cetak
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Total Ibu Hamil: {{ $pemeriksaans->count() }}</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-violet-500 to-purple-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Usia Kehamilan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tekanan Darah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">BB (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Petugas</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pemeriksaans as $index => $pemeriksaan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pemeriksaan->ibuHamil->nama ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->usia_kehamilan ? $pemeriksaan->usia_kehamilan . ' minggu' : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->tekanan_darah ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->berat_badan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->petugas->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pemeriksaans->count() > 0)
        <div class="mt-6 p-4 bg-purple-50 rounded-lg">
            <h4 class="font-semibold text-purple-800 mb-2">Statistik</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Total Pemeriksaan</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $pemeriksaans->count() }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Rata-rata Usia Kehamilan</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($pemeriksaans->avg('usia_kehamilan'), 1) }} minggu</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Rata-rata Berat Badan</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($pemeriksaans->avg('berat_badan'), 1) }} kg</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection
