@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                Laporan Pemeriksaan Ibu Hamil
            </h2>
            <p class="text-slate-600 mt-2">
                Filter dan analisis data pemeriksaan ibu hamil
            </p>
        </div>

        <a href="{{ route('laporan.index') }}"
           class="no-print bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md">
            ← Kembali
        </a>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 no-print">
        <form method="GET"
              action="{{ route('laporan.ibu-hamil') }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Bulan
                </label>

                <select name="bulan"
                        class="w-full px-4 py-2 border border-slate-300 rounded-xl">

                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}"
                            {{ $bulan == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor

                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Tahun
                </label>

                <select name="tahun"
                        class="w-full px-4 py-2 border border-slate-300 rounded-xl">

                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}"
                            {{ $tahun == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor

                </select>
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-violet-600 hover:bg-violet-700 text-white py-2 px-4 rounded-xl">
                    🔍 Filter
                </button>
            </div>

            <div class="flex items-end">
                <button type="button"
                        onclick="window.print()"
                        class="w-full bg-slate-600 hover:bg-slate-700 text-white py-2 px-4 rounded-xl">
                    🖨️ Cetak
                </button>
            </div>

        </form>
    </div>

    {{-- Statistik --}}
    @if($pemeriksaans->count() > 0)

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6 print-cards">

        <div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <p class="text-sm opacity-80">Total Pemeriksaan</p>
            <h3 class="text-4xl font-bold mt-2">
                {{ $statistik['total'] ?? 0 }}
            </h3>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <p class="text-sm opacity-80">BB Naik</p>
            <h3 class="text-4xl font-bold mt-2">
                {{ $statistik['bb_naik'] ?? 0 }}
            </h3>
            <p class="text-sm mt-1">Status Berat Badan</p>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <p class="text-sm opacity-80">Tekanan Darah Normal</p>
            <h3 class="text-4xl font-bold mt-2">
                {{ $statistik['td_normal'] ?? 0 }}
            </h3>
            <p class="text-sm mt-1">Sehat</p>
        </div>

        <div class="bg-gradient-to-br from-rose-500 to-red-600 rounded-2xl shadow-lg p-6 text-white card-print">
            <p class="text-sm opacity-80">Tekanan Darah Tinggi</p>
            <h3 class="text-4xl font-bold mt-2">
                {{ $statistik['td_tinggi'] ?? 0 }}
            </h3>
            <p class="text-sm mt-1">Perhatian</p>
        </div>

    </div>

    @endif

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-800">
                Data Pemeriksaan
            </h3>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">
                            No
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">
                            Tanggal
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">
                            Nama Ibu
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">
                            Usia Kehamilan
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">
                            Berat Badan
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">
                            LILA
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">
                            Tekanan Darah
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-700 uppercase">
                            Status
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                    @forelse($pemeriksaans as $index => $p)

                    <tr class="hover:bg-slate-50">

                        <td class="px-6 py-4">
                            {{ $index + 1 }}
                        </td>

                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($p->tanggal_kunjungan)->format('d/m/Y') }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $p->ibuHamil->nama ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $p->usia_kehamilan ? $p->usia_kehamilan . ' Minggu' : '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $p->berat_badan ?? '-' }} Kg
                        </td>

                        <td class="px-6 py-4">
                            {{ $p->lingkar_lengan ?? '-' }} Cm
                        </td>

                        <td class="px-6 py-4">
                            {{ $p->tekanan_darah ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            @if($p->status_bb == 'Naik')
                                <span class="px-3 py-1 text-xs font-semibold text-emerald-800 bg-emerald-100 rounded-full">
                                    Naik
                                </span>
                            @elseif($p->status_bb == 'Tidak')
                                <span class="px-3 py-1 text-xs font-semibold text-rose-800 bg-rose-100 rounded-full">
                                    Tidak Naik
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                                    Pertama
                                </span>
                            @endif
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8"
                            class="text-center py-8 text-slate-500">
                            Tidak ada data pemeriksaan
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