@extends('layouts.kepala-keluarga')

@section('title', 'Statistik Pemeriksaan Anggota')
@section('page-title', 'Statistik Pemeriksaan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('kepala-keluarga.anggota.pemeriksaan.export', ['tipe' => $memberType, 'id' => $member->id, 'format' => 'csv']) }}" class="inline-flex items-center rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-700 shadow-md shadow-emerald-100">
            <i class="fa-solid fa-file-csv mr-2"></i>Export CSV
        </a>
        <a href="{{ route('kepala-keluarga.anggota.pemeriksaan.export', ['tipe' => $memberType, 'id' => $member->id, 'format' => 'pdf']) }}" class="inline-flex items-center rounded-2xl bg-rose-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-rose-700 shadow-md shadow-rose-100">
            <i class="fa-solid fa-file-pdf mr-2"></i>Export PDF
        </a>
        <a href="{{ route('kepala-keluarga.anggota.show', ['tipe' => $memberType, 'id' => $member->id]) }}" class="inline-flex items-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-indigo-700 shadow-md shadow-indigo-100">
            <i class="fa-solid fa-eye mr-2"></i>Lihat Detail
        </a>
        <a href="{{ route('kepala-keluarga.dashboard') }}" class="inline-flex items-center rounded-2xl bg-slate-200 px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-300">
            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali Dashboard
        </a>
    </div>

    <!-- Ringkasan Statistik -->
    <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-100">
        <h3 class="text-lg font-extrabold text-slate-800">Ringkasan Statistik</h3>
        <div class="mt-6 grid gap-4 grid-cols-1 md:grid-cols-3">
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5">
                <p class="text-xs font-bold uppercase text-slate-400 tracking-wider">Total Pemeriksaan</p>
                <p class="mt-2 text-4xl font-extrabold text-indigo-600">{{ $totalPemeriksaan }}</p>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5">
                <p class="text-xs font-bold uppercase text-slate-400 tracking-wider">Bulan Ini</p>
                <p class="mt-2 text-4xl font-extrabold text-amber-500">{{ $pemeriksaanBulanIni }}</p>
            </div>
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-5">
                <p class="text-xs font-bold uppercase text-slate-400 tracking-wider">Pemeriksaan Terakhir</p>
                <p class="mt-2 text-lg font-bold text-emerald-600">
                    {{ $terakhirPemeriksaan ? \Illuminate\Support\Carbon::parse($terakhirPemeriksaan)->format('d M Y H:i') : '-' }}
                </p>
            </div>
        </div>
    </section>

    <!-- Perkembangan (Perbandingan Riwayat) -->
    <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-100">
        <h3 class="text-lg font-extrabold text-slate-800">Perkembangan (Perbandingan Riwayat)</h3>

        @if(! $perbandinganTersedia)
            <div class="mt-6 rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-6 text-center text-sm text-slate-500">
                Perkembangan belum bisa dihitung. Minimal perlu 2 riwayat pemeriksaan.
            </div>
        @elseif(empty($perkembangan))
            <div class="mt-6 rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-6 text-center text-sm text-slate-500">
                Data indikator numerik belum cukup untuk dibandingkan.
            </div>
        @else
            <p class="mt-3 text-sm text-slate-500">
                Dibandingkan dari
                <span class="font-bold text-slate-700">{{ \Illuminate\Support\Carbon::parse($tanggalRiwayatSebelumnya)->format('d M Y H:i') }}</span>
                ke
                <span class="font-bold text-slate-700">{{ \Illuminate\Support\Carbon::parse($tanggalRiwayatTerbaru)->format('d M Y H:i') }}</span>
            </p>

            <div class="mt-6 grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @foreach($perkembangan as $item)
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-4">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-sm font-bold text-slate-800">{{ $item['label'] }}</p>
                            @if($item['status'] === 'naik')
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Naik</span>
                            @elseif($item['status'] === 'turun')
                                <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Turun</span>
                            @else
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Stabil</span>
                            @endif
                        </div>
                        <div class="mt-3 text-xs text-slate-500 space-y-1">
                            <div class="flex justify-between"><span>Sebelumnya:</span><span class="font-bold text-slate-700">{{ number_format($item['nilai_sebelumnya'], 2, ',', '.') }}</span></div>
                            <div class="flex justify-between"><span>Terbaru:</span><span class="font-bold text-slate-700">{{ number_format($item['nilai_terbaru'], 2, ',', '.') }}</span></div>
                            <div class="flex justify-between pt-1 border-t border-slate-100"><span>Selisih:</span><span class="font-bold {{ $item['selisih'] > 0 ? 'text-emerald-600' : ($item['selisih'] < 0 ? 'text-rose-600' : 'text-slate-600') }}">{{ ($item['selisih'] > 0 ? '+' : '') . number_format($item['selisih'], 2, ',', '.') }}</span></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 rounded-2xl border border-slate-100 bg-slate-50/50 p-4">
                <p class="mb-4 text-sm font-bold text-slate-700">Grafik Perkembangan (Selisih Terbaru vs Sebelumnya)</p>
                <div class="h-72">
                    <canvas id="perkembanganChart"></canvas>
                </div>
            </div>
        @endif
    </section>

    <!-- Riwayat Pemeriksaan Terbaru -->
    <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-100">
        <h3 class="text-lg font-extrabold text-slate-800">Riwayat Pemeriksaan Terbaru</h3>
        @if($riwayatPemeriksaan->isEmpty())
            <div class="mt-6 rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-6 text-center text-sm text-slate-500">
                Data periksa belum ada.
            </div>
        @else
            <!-- Mobile list -->
            <div class="mt-6 space-y-3 md:hidden">
                @foreach($riwayatPemeriksaan as $idx => $row)
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-bold uppercase text-slate-400 tracking-wider">Tanggal</p>
                                <p class="text-sm font-bold text-slate-800">
                                    {{ !empty($row['tanggal']) ? \Illuminate\Support\Carbon::parse($row['tanggal'])->format('d M Y H:i') : '-' }}
                                </p>
                            </div>
                            <span class="rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-600">#{{ $idx + 1 }}</span>
                        </div>
                        <div class="mt-3">
                            <p class="text-xs font-bold uppercase text-slate-400 tracking-wider">Catatan Ringkas</p>
                            <p class="mt-1 text-sm text-slate-700 leading-relaxed">{{ $row['catatan'] ?: '-' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop table -->
            <div class="mt-6 hidden overflow-hidden rounded-2xl border border-slate-100 md:block">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3.5 text-left text-xs font-bold uppercase text-slate-400 tracking-wider">No</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold uppercase text-slate-400 tracking-wider">Tanggal</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold uppercase text-slate-400 tracking-wider">Catatan Ringkas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white text-sm text-slate-700">
                        @foreach($riwayatPemeriksaan as $idx => $row)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $idx + 1 }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-600">
                                    {{ !empty($row['tanggal']) ? \Illuminate\Support\Carbon::parse($row['tanggal'])->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-slate-600 leading-relaxed">{{ $row['catatan'] ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Highlight active sidebar item
        document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active-section-btn'));
        const activeBtn = document.querySelector('[data-section-btn="riwayat-pemeriksaan"]');
        if (activeBtn) {
            activeBtn.classList.add('active-section-btn');
        }
    });
</script>

@if($perbandinganTersedia && !empty($perkembangan))
    <script>
        const perkembanganData = @json($perkembangan);
        const labels = perkembanganData.map((item) => item.label);
        const values = perkembanganData.map((item) => Number(item.selisih));
        const colors = values.map((v) => {
            if (v > 0) return 'rgba(16, 185, 129, 0.75)';
            if (v < 0) return 'rgba(244, 63, 94, 0.75)';
            return 'rgba(100, 116, 139, 0.75)';
        });

        const ctx = document.getElementById('perkembanganChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Selisih',
                    data: values,
                    backgroundColor: colors,
                    borderColor: colors.map((c) => c.replace('0.75', '1')),
                    borderWidth: 1,
                    borderRadius: 8,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback(value) {
                                return Number(value).toFixed(2);
                            },
                        },
                    },
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label(context) {
                                const val = Number(context.raw);
                                return `Selisih: ${val > 0 ? '+' : ''}${val.toFixed(2)}`;
                            },
                        },
                    },
                },
            },
        });
    </script>
@endif
@endpush
