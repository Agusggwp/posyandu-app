<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Pemeriksaan Anggota</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #f0ebf8 0%, #f5f7fa 50%, #e8f4f8 100%);
            min-height: 100vh;
        }

        .panel-shell {
            background: linear-gradient(135deg, #ffffff 0%, #f9fbfd 100%);
            border: 1px solid rgba(78, 3, 131, 0.08);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06), 0 2px 8px rgba(78, 3, 131, 0.05);
        }

        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f9fbfd 100%);
            border: 1px solid rgba(78, 3, 131, 0.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .table-head {
            background: linear-gradient(135deg, #4e0383 0%, #6b2ba8 100%);
        }
    </style>
</head>
<body class="text-gray-800">
    <header class="bg-gradient-to-r from-purple-700 via-purple-600 to-purple-500 text-white shadow-lg">
        <div class="mx-auto max-w-6xl px-6 py-8">
            <p class="text-sm text-purple-100">Statistik Pemeriksaan</p>
            <h1 class="mt-2 text-3xl font-bold">{{ $memberName }}</h1>
            <p class="mt-2 text-purple-100">Kategori: {{ $memberTypeLabel }}</p>
        </div>
    </header>

    <div class="mx-auto max-w-6xl p-6">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-2">
            <p class="text-sm text-gray-600">
                <span class="font-semibold text-purple-700">Dashboard</span> / Statistik Pemeriksaan
            </p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('kepala-keluarga.anggota.pemeriksaan.export', ['tipe' => $memberType, 'id' => $member->id, 'format' => 'csv']) }}" class="inline-flex items-center rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                    <i class="fa-solid fa-file-csv mr-2"></i>Export CSV
                </a>
                <a href="{{ route('kepala-keluarga.anggota.pemeriksaan.export', ['tipe' => $memberType, 'id' => $member->id, 'format' => 'pdf']) }}" class="inline-flex items-center rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">
                    <i class="fa-solid fa-file-pdf mr-2"></i>Export PDF
                </a>
                <a href="{{ route('kepala-keluarga.anggota.show', ['tipe' => $memberType, 'id' => $member->id]) }}" class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    <i class="fa-solid fa-eye mr-2"></i>Lihat Detail
                </a>
                <a href="{{ route('kepala-keluarga.dashboard') }}" class="inline-flex items-center rounded-xl bg-slate-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <section class="panel-shell rounded-2xl p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-900">Ringkasan Statistik</h2>
            <div class="mt-4 grid gap-4 md:grid-cols-3">
                <div class="stat-card rounded-2xl border-l-4 border-purple-500 p-5">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Total Pemeriksaan</p>
                    <p class="mt-2 text-4xl font-bold text-purple-700">{{ $totalPemeriksaan }}</p>
                </div>
                <div class="stat-card rounded-2xl border-l-4 border-orange-500 p-5">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Bulan Ini</p>
                    <p class="mt-2 text-4xl font-bold text-orange-600">{{ $pemeriksaanBulanIni }}</p>
                </div>
                <div class="stat-card rounded-2xl border-l-4 border-emerald-500 p-5">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Pemeriksaan Terakhir</p>
                    <p class="mt-2 text-lg font-bold text-emerald-700">
                        {{ $terakhirPemeriksaan ? \Illuminate\Support\Carbon::parse($terakhirPemeriksaan)->format('d M Y H:i') : '-' }}
                    </p>
                </div>
            </div>
        </section>

        <section class="panel-shell mt-6 rounded-2xl p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-900">Perkembangan (Perbandingan Riwayat)</h2>

            @if(! $perbandinganTersedia)
                <div class="mt-4 rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500">
                    Perkembangan belum bisa dihitung. Minimal perlu 2 riwayat pemeriksaan.
                </div>
            @elseif(empty($perkembangan))
                <div class="mt-4 rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500">
                    Data indikator numerik belum cukup untuk dibandingkan.
                </div>
            @else
                <p class="mt-3 text-sm text-gray-600">
                    Dibandingkan dari
                    <span class="font-semibold">{{ \Illuminate\Support\Carbon::parse($tanggalRiwayatSebelumnya)->format('d M Y H:i') }}</span>
                    ke
                    <span class="font-semibold">{{ \Illuminate\Support\Carbon::parse($tanggalRiwayatTerbaru)->format('d M Y H:i') }}</span>
                </p>

                <div class="mt-4 grid gap-3 md:grid-cols-2">
                    @foreach($perkembangan as $item)
                        <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-semibold text-gray-900">{{ $item['label'] }}</p>
                                @if($item['status'] === 'naik')
                                    <span class="rounded-lg bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Naik</span>
                                @elseif($item['status'] === 'turun')
                                    <span class="rounded-lg bg-rose-100 px-2.5 py-1 text-xs font-semibold text-rose-700">Turun</span>
                                @else
                                    <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">Stabil</span>
                                @endif
                            </div>
                            <div class="mt-2 text-sm text-gray-600">
                                <p>Sebelumnya: <span class="font-semibold text-gray-900">{{ number_format($item['nilai_sebelumnya'], 2, ',', '.') }}</span></p>
                                <p>Terbaru: <span class="font-semibold text-gray-900">{{ number_format($item['nilai_terbaru'], 2, ',', '.') }}</span></p>
                                <p>Selisih: <span class="font-semibold text-gray-900">{{ ($item['selisih'] > 0 ? '+' : '') . number_format($item['selisih'], 2, ',', '.') }}</span></p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
                    <p class="mb-3 text-sm font-semibold text-gray-700">Grafik Perkembangan (Selisih Terbaru vs Sebelumnya)</p>
                    <div class="h-72">
                        <canvas id="perkembanganChart"></canvas>
                    </div>
                </div>
            @endif
        </section>

        <section class="panel-shell mt-6 rounded-2xl p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-900">Riwayat Pemeriksaan Terbaru</h2>

            @if($riwayatPemeriksaan->isEmpty())
                <div class="mt-4 rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500">
                    Belum ada data pemeriksaan untuk anggota ini.
                </div>
            @else
                <div class="mt-4 overflow-x-auto rounded-xl border border-gray-100">
                    <table class="min-w-full border-collapse">
                        <thead class="table-head text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Catatan Ringkas</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-sm text-gray-700">
                            @foreach($riwayatPemeriksaan as $idx => $row)
                                <tr class="border-b border-gray-100 hover:bg-purple-50/40">
                                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $idx + 1 }}</td>
                                    <td class="px-4 py-3">
                                        @if(!empty($row['tanggal']))
                                            {{ \Illuminate\Support\Carbon::parse($row['tanggal'])->format('d M Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ $row['catatan'] ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>

    @if($perbandinganTersedia && !empty($perkembangan))
        <script>
            const perkembanganData = @json($perkembangan);
            const labels = perkembanganData.map(item => item.label);
            const values = perkembanganData.map(item => Number(item.selisih));
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
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(148, 163, 184, 0.25)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return Number(value).toFixed(2);
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const val = Number(context.raw);
                                    return `Selisih: ${val > 0 ? '+' : ''}${val.toFixed(2)}`;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endif
</body>
</html>
