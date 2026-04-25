<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Pemeriksaan Anggota - POSYANDU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .nav-btn {
            background-color: transparent !important;
            box-shadow: none !important;
        }

        .nav-btn.active {
            background-color: #8e4682 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3), inset 0 2px 4px rgba(0, 0, 0, 0.2) !important;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen">
        <aside class="fixed h-screen w-64 bg-fuchsia-700 text-white">
            <div class="border-b border-fuchsia-500 p-6 text-white">
                <div class="flex items-center gap-3">
                    <i class="fas fa-home text-3xl"></i>
                    <div>
                        <h1 class="text-xl font-bold">POSYANDU</h1>
                        <p class="text-xs text-fuchsia-100">Kepala Keluarga</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 space-y-2 px-4 py-6">
                <a href="{{ route('kepala-keluarga.dashboard') }}" class="nav-btn active flex w-full items-center gap-3 rounded-lg px-4 py-3 text-left font-medium text-white transition">
                    <i class="fas fa-notes-medical w-5"></i>
                    <span>Statistik Pemeriksaan</span>
                </a>
            </nav>

            <div class="border-t border-fuchsia-500 p-4">
                <form method="POST" action="{{ route('kepala-keluarga.logout') }}">
                    @csrf
                    <button class="flex w-full items-center gap-3 rounded-lg border border-rose-200 bg-white px-4 py-3 text-rose-500 transition hover:bg-rose-50 hover:text-rose-600">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="ml-64 flex-1 overflow-auto">
            <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-200 bg-white px-6 py-6">
                <div>
                    <p class="text-xs font-semibold uppercase text-gray-500">Panel Kepala Keluarga</p>
                    <h2 class="text-2xl font-bold text-gray-800">Riwayat Pemeriksaan</h2>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-700">{{ $memberName }}</p>
                    <p class="text-xs text-gray-500">Kategori: {{ $memberTypeLabel }}</p>
                </div>
            </div>

            <div class="space-y-6 p-8">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('kepala-keluarga.anggota.pemeriksaan.export', ['tipe' => $memberType, 'id' => $member->id, 'format' => 'csv']) }}" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                        <i class="fa-solid fa-file-csv mr-2"></i>Export CSV
                    </a>
                    <a href="{{ route('kepala-keluarga.anggota.pemeriksaan.export', ['tipe' => $memberType, 'id' => $member->id, 'format' => 'pdf']) }}" class="inline-flex items-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">
                        <i class="fa-solid fa-file-pdf mr-2"></i>Export PDF
                    </a>
                    <a href="{{ route('kepala-keluarga.anggota.show', ['tipe' => $memberType, 'id' => $member->id]) }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        <i class="fa-solid fa-eye mr-2"></i>Lihat Detail
                    </a>
                    <a href="{{ route('kepala-keluarga.dashboard') }}" class="inline-flex items-center rounded-lg bg-slate-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali Dashboard
                    </a>
                </div>

                <section class="rounded-lg bg-white p-6 shadow">
                    <h3 class="text-lg font-bold text-gray-800">Ringkasan Statistik</h3>
                    <div class="mt-4 grid gap-4 md:grid-cols-3">
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-5">
                            <p class="text-xs font-semibold uppercase text-gray-500">Total Pemeriksaan</p>
                            <p class="mt-2 text-4xl font-bold text-fuchsia-700">{{ $totalPemeriksaan }}</p>
                        </div>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-5">
                            <p class="text-xs font-semibold uppercase text-gray-500">Bulan Ini</p>
                            <p class="mt-2 text-4xl font-bold text-orange-600">{{ $pemeriksaanBulanIni }}</p>
                        </div>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-5">
                            <p class="text-xs font-semibold uppercase text-gray-500">Pemeriksaan Terakhir</p>
                            <p class="mt-2 text-lg font-bold text-emerald-700">{{ $terakhirPemeriksaan ? \Illuminate\Support\Carbon::parse($terakhirPemeriksaan)->format('d M Y H:i') : '-' }}</p>
                        </div>
                    </div>
                </section>

                <section class="rounded-lg bg-white p-6 shadow">
                    <h3 class="text-lg font-bold text-gray-800">Perkembangan (Perbandingan Riwayat)</h3>

                    @if(! $perbandinganTersedia)
                        <div class="mt-4 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500">
                            Perkembangan belum bisa dihitung. Minimal perlu 2 riwayat pemeriksaan.
                        </div>
                    @elseif(empty($perkembangan))
                        <div class="mt-4 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500">
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
                                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
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

                        <div class="mt-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <p class="mb-3 text-sm font-semibold text-gray-700">Grafik Perkembangan (Selisih Terbaru vs Sebelumnya)</p>
                            <div class="h-72">
                                <canvas id="perkembanganChart"></canvas>
                            </div>
                        </div>
                    @endif
                </section>

                <section class="rounded-lg bg-white p-6 shadow">
                    <h3 class="text-lg font-bold text-gray-800">Riwayat Pemeriksaan Terbaru</h3>
                    @if($riwayatPemeriksaan->isEmpty())
                        <div class="mt-4 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500">
                            Data periksa belum ada.
                        </div>
                    @else
                        <div class="mt-4 overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full border-collapse">
                                <thead class="bg-gray-50 text-gray-600">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Catatan Ringkas</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white text-sm text-gray-700">
                                    @foreach($riwayatPemeriksaan as $idx => $row)
                                        <tr>
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
        </main>
    </div>

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
</body>
</html>
