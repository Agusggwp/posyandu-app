@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">Laporan Pemeriksaan Lansia</h2>
            <p class="text-slate-600 mt-2">Filter dan analisis data pemeriksaan lansia</p>
        </div>
        <a href="{{ route('laporan.index') }}" class="no-print bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            ← Kembali
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <form method="GET" action="{{ route('laporan.lansia') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="bulan" class="block text-sm font-medium text-slate-700 mb-2">Bulan</label>
                <select name="bulan" id="bulan" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="tahun" class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                <select name="tahun" id="tahun" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    🔍 Filter
                </button>
            </div>
            <div class="flex items-end">
                <button type="button" onclick="window.print()" class="w-full bg-gradient-to-r from-slate-500 to-slate-600 hover:from-slate-600 hover:to-slate-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    🖨️ Cetak
                </button>
            </div>
        </form>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 print-cards">
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">Total Pemeriksaan</h3>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['total'] ?? 0 }}</p>
            <p class="text-amber-100 text-sm mt-1">Bulan ini</p>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">Rata-rata Gula Darah</h3>
            </div>
            <p class="text-4xl font-bold">{{ $pemeriksaans->count() > 0 ? number_format($pemeriksaans->avg('gula_darah'), 1) : '0' }}</p>
            <p class="text-orange-100 text-sm mt-1">mg/dL</p>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">Gula Darah Normal</h3>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['gula_normal'] ?? 0 }}</p>
            <p class="text-red-100 text-sm mt-1">Lansia Sehat</p>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Data Pemeriksaan - {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</h3>
        </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Total Pemeriksaan Lansia: {{ $pemeriksaans->count() }}</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-amber-500 to-orange-500 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">BB (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">TB (cm)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tekanan Darah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Gula Darah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pemeriksaans as $index => $pemeriksaan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pemeriksaan->lansia->nama ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->berat_badan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->tinggi_badan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->sistole ? $pemeriksaan->sistole . '/' . $pemeriksaan->diastole : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $pemeriksaan->gula_darah ? $pemeriksaan->gula_darah . ' mg/dL' : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    </div>

    <!-- Tanda Tangan Cetak -->
    <div class="hidden print:block mt-16 right-0 w-64 text-center float-right">
        <p class="mb-20">Mengetahui,</p>
        <p class="font-bold border-b border-black pb-1 mb-1">Ketua Posyandu</p>
        <p>NIP. .........................</p>
    </div>
</div>

<style>
    @media print {
        @page { margin: 1.5cm; size: landscape; }
        body { 
            -webkit-print-color-adjust: exact; 
            print-color-adjust: exact; 
            background: white !important;
        }
        .print-cards {
            display: flex !important;
            flex-direction: row !important;
            gap: 1rem !important;
            margin-bottom: 2rem !important;
        }
        .print-cards > div {
            flex: 1 !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        .no-print, nav, footer, form, button, a[href*="kembali"] {
            display: none !important;
        }
        .max-w-7xl {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
        }
        .card-print {
            border: 1px solid #e2e8f0 !important;
            color: black !important;
            background: white !important;
            box-shadow: none !important;
        }
        .card-print p, .card-print h3 {
            color: black !important;
        }
        table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-bottom: 2rem !important;
        }
        th, td {
            border: 1px solid #cbd5e1 !important;
            padding: 8px !important;
        }
        th {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            font-weight: bold !important;
        }
        h2 {
            text-align: center;
            font-size: 24pt !important;
            margin-bottom: 5px !important;
            background: none !important;
            -webkit-text-fill-color: black !important;
            color: black !important;
        }
        h2 + p {
            text-align: center;
            margin-bottom: 20px !important;
        }
        .bg-gradient-to-r {
            background: none !important;
            color: black !important;
        }
        .shadow-lg {
            box-shadow: none !important;
        }
        .rounded-2xl, .rounded-lg {
            border-radius: 0 !important;
        }
        .print\:block {
            display: block !important;
        }
    }
</style>
@endsection
