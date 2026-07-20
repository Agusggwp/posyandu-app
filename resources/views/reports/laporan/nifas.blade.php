@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">Laporan Pemeriksaan Nifas</h2>
            <p class="text-slate-600 mt-2">Filter dan analisis data pemeriksaan ibu nifas</p>
        </div>
        <a href="{{ route('laporan.index') }}" class="no-print bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            ← Kembali
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <form method="GET" action="{{ route('laporan.nifas') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="bulan" class="block text-sm font-medium text-slate-700 mb-2">Bulan</label>
                <select name="bulan" id="bulan" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="tahun" class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                <select name="tahun" id="tahun" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
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
        <div class="bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">Total Pemeriksaan</h3>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['total'] ?? 0 }}</p>
            <p class="text-rose-100 text-sm mt-1">Bulan ini</p>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">Gizi Baik</h3>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['gizi_baik'] ?? 0 }}</p>
            <p class="text-emerald-100 text-sm mt-1">Sehat</p>
        </div>

        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">Gizi Kurang</h3>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['gizi_kurang'] ?? 0 }}</p>
            <p class="text-amber-100 text-sm mt-1">Perhatian</p>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">TD Normal</h3>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['td_normal'] ?? 0 }}</p>
            <p class="text-blue-100 text-sm mt-1">Tekanan Darah</p>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-rose-500 to-pink-600 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Data Pemeriksaan - {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Nama Ibu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Berat Badan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">LILA</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Tekanan Darah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Status Gizi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pemeriksaans as $index => $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $p->nifas->nama_ibu ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->berat_badan ?? '-' }} kg</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->lila ?? '-' }} cm</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->sistole ? $p->sistole . '/' . $p->diastole : '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($p->status_gizi == 'Hijau')
                                <span class="px-3 py-1 text-xs font-semibold text-emerald-800 bg-emerald-100 rounded-full">Sehat (Hijau)</span>
                            @elseif($p->status_gizi == 'Kuning')
                                <span class="px-3 py-1 text-xs font-semibold text-amber-800 bg-amber-100 rounded-full">Kurang (Kuning)</span>
                            @elseif($p->status_gizi == 'Merah')
                                <span class="px-3 py-1 text-xs font-semibold text-rose-800 bg-rose-100 rounded-full">Malnutrisi (Merah)</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold text-slate-800 bg-slate-100 rounded-full">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">
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
        @page { margin: 1cm; size: landscape; }
        body { 
            -webkit-print-color-adjust: exact; 
            print-color-adjust: exact; 
            background: white !important;
            color: black !important;
        }
        .sidebar, .topbar, .no-print, nav, footer, form, button, a[href*="kembali"], .no-print * {
            display: none !important;
        }
        .app-layout {
            display: block !important;
        }
        .main-panel {
            display: block !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            min-height: 0 !important;
            animation: none !important;
        }
        .max-w-7xl {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
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
        .card-print {
            border: 1px solid #cbd5e1 !important;
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
            -webkit-text-fill-color: #0f766e !important;
            color: #0f766e !important;
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

