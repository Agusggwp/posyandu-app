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
           class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md">
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        <div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
            <p class="text-sm opacity-80">Total Pemeriksaan</p>
            <h3 class="text-4xl font-bold mt-2">
                {{ $pemeriksaans->count() }}
            </h3>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
            <p class="text-sm opacity-80">Rata-rata Usia Kehamilan</p>
            <h3 class="text-4xl font-bold mt-2">
                {{ number_format($pemeriksaans->avg('usia_kehamilan'),1) }}
            </h3>
            <p class="text-sm">Minggu</p>
        </div>

        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
            <p class="text-sm opacity-80">Rata-rata Berat Badan</p>
            <h3 class="text-4xl font-bold mt-2">
                {{ number_format($pemeriksaans->avg('berat_badan'),1) }}
            </h3>
            <p class="text-sm">Kg</p>
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
                            @else
                                <span class="px-3 py-1 text-xs font-semibold text-amber-800 bg-amber-100 rounded-full">
                                    {{ $p->status_bb ?? '-' }}
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

</div>

<style>
@media print {

    .no-print {
        display: none !important;
    }

    body {
        background: white !important;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
    }
}
</style>

@endsection