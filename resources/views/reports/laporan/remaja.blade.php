@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">Laporan Pemeriksaan Remaja</h2>
            <p class="text-slate-600 mt-2">Filter dan analisis data pemeriksaan remaja</p>
        </div>
        <a href="{{ route('laporan.index') }}" class="no-print bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            ← Kembali
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <form method="GET" action="{{ route('laporan.remaja') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="bulan" class="block text-sm font-medium text-slate-700 mb-2">Bulan</label>
                <select name="bulan" id="bulan" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="tahun" class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                <select name="tahun" id="tahun" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6 print-cards">
        <div class="bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">Total Pemeriksaan</h3>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['total'] ?? 0 }}</p>
            <p class="text-indigo-100 text-sm mt-1">Bulan ini</p>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">IMT Normal</h3>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['imt_normal'] ?? 0 }}</p>
            <p class="text-emerald-100 text-sm mt-1">Status Gizi Baik</p>
        </div>

        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">IMT Kurus</h3>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['imt_kurus'] ?? 0 }}</p>
            <p class="text-amber-100 text-sm mt-1">Perlu Perhatian</p>
        </div>

        <div class="bg-gradient-to-br from-rose-500 to-red-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">IMT Gemuk/Obesitas</h3>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['imt_gemuk'] ?? 0 }}</p>
            <p class="text-rose-100 text-sm mt-1">Lebih Berat</p>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Data Pemeriksaan - {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Nama Remaja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">BB (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">TB (cm)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">IMT Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Tekanan Darah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Hemoglobin</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pemeriksaans as $index => $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ optional($p->tanggal_kunjungan)->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $p->remaja->nama_anak ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->berat_badan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->tinggi_badan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                            @if($p->imt_status)
                                <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded">{{ $p->imt_status }}</span>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->sistole ? $p->sistole . '/' . $p->diastole : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->hemoglobin ? $p->hemoglobin . ' g/dL' : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-slate-500">
                            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-lg font-medium">Tidak ada data pemeriksaan</p>
                            <p class="text-sm">Belum ada data untuk periode yang dipilih</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
        .card-print p {
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
        .rounded-2xl {
            border-radius: 0 !important;
        }
        .print\:block {
            display: block !important;
        }
    }
</style>
@endsection

