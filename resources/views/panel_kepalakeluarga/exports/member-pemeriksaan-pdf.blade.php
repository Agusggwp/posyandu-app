<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemeriksaan Anggota</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        h1 { font-size: 18px; margin: 0 0 8px 0; }
        h2 { font-size: 14px; margin: 18px 0 8px 0; }
        .meta { margin-bottom: 10px; }
        .meta p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #d1d5db; padding: 6px; text-align: left; vertical-align: top; }
        th { background: #f3f4f6; }
        .summary { width: 100%; margin-top: 8px; }
        .summary td { border: 1px solid #d1d5db; padding: 6px; }
        .muted { color: #6b7280; }
    </style>
</head>
<body>
    <h1>Laporan Pemeriksaan Anggota</h1>

    <div class="meta">
        <p><strong>Nama:</strong> {{ $memberName }}</p>
        <p><strong>Kategori:</strong> {{ $memberTypeLabel }}</p>
        <p><strong>Dicetak:</strong> {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    <h2>Ringkasan Statistik</h2>
    <table class="summary">
        <tr>
            <td><strong>Total Pemeriksaan</strong></td>
            <td>{{ $totalPemeriksaan }}</td>
            <td><strong>Pemeriksaan Bulan Ini</strong></td>
            <td>{{ $pemeriksaanBulanIni }}</td>
        </tr>
        <tr>
            <td><strong>Pemeriksaan Terakhir</strong></td>
            <td colspan="3">{{ $terakhirPemeriksaan ? \Illuminate\Support\Carbon::parse($terakhirPemeriksaan)->format('d-m-Y H:i') : '-' }}</td>
        </tr>
    </table>

    <h2>Perkembangan</h2>
    @if(empty($perkembangan))
        <p class="muted">Data perkembangan tidak tersedia.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Indikator</th>
                    <th>Status</th>
                    <th>Nilai Sebelumnya</th>
                    <th>Nilai Terbaru</th>
                    <th>Selisih</th>
                </tr>
            </thead>
            <tbody>
                @foreach($perkembangan as $item)
                    <tr>
                        <td>{{ $item['label'] }}</td>
                        <td>{{ ucfirst($item['status']) }}</td>
                        <td>{{ number_format($item['nilai_sebelumnya'], 2, ',', '.') }}</td>
                        <td>{{ number_format($item['nilai_terbaru'], 2, ',', '.') }}</td>
                        <td>{{ ($item['selisih'] > 0 ? '+' : '') . number_format($item['selisih'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>Riwayat Pemeriksaan</h2>
    @if($riwayatPemeriksaan->isEmpty())
        <p class="muted">Belum ada riwayat pemeriksaan.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 170px;">Tanggal</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayatPemeriksaan as $idx => $row)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ !empty($row['tanggal']) ? \Illuminate\Support\Carbon::parse($row['tanggal'])->format('d-m-Y H:i') : '-' }}</td>
                        <td>{{ $row['catatan'] ?: '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
