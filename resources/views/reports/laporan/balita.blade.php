@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">Laporan Pemeriksaan Balita</h2>
            <p class="text-slate-600 mt-2">Filter dan analisis data pemeriksaan balita</p>
        </div>
        <a href="{{ route('laporan.index') }}" class="no-print bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
            ← Kembali
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
        <form method="GET" action="{{ route('laporan.balita') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="bulan" class="block text-sm font-medium text-slate-700 mb-2">Bulan</label>
                <select name="bulan" id="bulan" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="tahun" class="block text-sm font-medium text-slate-700 mb-2">Tahun</label>
                <select name="tahun" id="tahun" class="w-full px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
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
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['total'] }}</p>
            <p class="text-indigo-100 text-sm mt-1">Pemeriksaan bulan ini</p>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">Gizi Normal</h3>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['normal'] }}</p>
            <p class="text-emerald-100 text-sm mt-1">Balita sehat</p>
        </div>

        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">Gizi Kurang</h3>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['kurang'] }}</p>
            <p class="text-amber-100 text-sm mt-1">Perlu perhatian</p>
        </div>

        <div class="bg-gradient-to-br from-rose-500 to-red-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-semibold">Stunting</h3>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold">{{ $statistik['stunting'] }}</p>
            <p class="text-rose-100 text-sm mt-1">Memerlukan tindakan</p>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
            <h3 class="text-xl font-bold text-white">Data Pemeriksaan - {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Nama Balita</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">BB (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">PB (cm)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">LK (cm)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Imunisasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Vitamin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Status Gizi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pemeriksaans as $index => $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $p->balita->nama ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->berat_badan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->panjang_badan ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->lingkar_kepala ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->imunisasi ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $p->vitamin_a ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($p->status_gizi == 'normal')
                                <span class="px-3 py-1 text-xs font-semibold text-emerald-800 bg-emerald-100 rounded-full">Normal</span>
                            @elseif($p->status_gizi == 'kurang')
                                <span class="px-3 py-1 text-xs font-semibold text-amber-800 bg-amber-100 rounded-full">Kurang</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold text-rose-800 bg-rose-100 rounded-full">Stunting</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-slate-500">
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
