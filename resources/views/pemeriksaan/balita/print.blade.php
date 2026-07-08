<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perkembangan Balita - {{ $pemeriksaan->balita->nama ?? '-' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary: #0f766e;
            --primary-light: #f0fdfa;
            --text-dark: #0f172a;
            --text-muted: #475569;
            --border-color: #cbd5e1;
            --rose-bg: #fff1f2;
            --rose-text: #9f1239;
            --emerald-bg: #ecfdf5;
            --emerald-text: #065f46;
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            padding: 20px;
            color: var(--text-dark);
            background-color: #f8fafc;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        /* Floating action header in browser */
        .actions-header {
            max-width: 800px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: #0d9488;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #475569;
            transform: translateY(-1px);
        }

        /* Letterhead / Kop Surat */
        .letterhead {
            text-align: center;
            border-bottom: 3px double var(--text-dark);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .letterhead h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.02em;
            text-transform: uppercase;
        }

        .letterhead p {
            margin: 5px 0 0 0;
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .report-title {
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 25px;
            letter-spacing: 0.05em;
            color: var(--text-dark);
        }

        /* Sections and Grids */
        .section-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--primary);
            border-bottom: 2px solid var(--primary);
            padding-bottom: 6px;
            margin-top: 30px;
            margin-bottom: 15px;
            letter-spacing: 0.03em;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .info-item {
            display: flex;
            font-size: 14px;
            line-height: 1.5;
        }

        .info-label {
            width: 140px;
            font-weight: 600;
            color: var(--text-muted);
            flex-shrink: 0;
        }

        .info-value {
            color: var(--text-dark);
            font-weight: 500;
        }

        /* Status Cards */
        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .status-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px;
            text-align: center;
        }

        .status-card-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .status-card-value {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary);
        }

        /* Referral Status Block */
        .referral-box {
            padding: 15px;
            border-radius: 12px;
            border: 1px solid;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .referral-needed {
            background-color: var(--rose-bg);
            border-color: #fecdd3;
            color: var(--rose-text);
        }

        .referral-not-needed {
            background-color: var(--emerald-bg);
            border-color: #a7f3d0;
            color: var(--emerald-text);
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 15px;
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid var(--border-color);
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f1f5f9;
            color: var(--text-dark);
            font-weight: 700;
        }

        td {
            color: var(--text-muted);
            font-weight: 500;
        }

        tr.active-row td {
            font-weight: 600;
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .notes-area {
            background-color: #fafafa;
            border: 1px dashed var(--border-color);
            border-radius: 10px;
            padding: 15px;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Signature block */
        .signature-block {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }

        .signature-wrapper {
            width: 250px;
            text-align: center;
            font-size: 14px;
        }

        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid var(--text-dark);
            font-weight: 700;
            padding-bottom: 4px;
        }

        /* Print Specific Styling */
        @media print {
            body {
                background-color: white !important;
                padding: 0;
            }
            .container {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Actions bar for browser view -->
    <div class="actions-header no-print">
        <a href="{{ route('pemeriksaan-balita.show', $pemeriksaan->id) }}" class="btn btn-secondary">
            ← Kembali ke Detail
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            🖨️ Cetak Laporan
        </button>
    </div>

    <div class="container">
        <!-- Letterhead -->
        <div class="letterhead">
            <h1>Posyandu Balita Sejahtera</h1>
            <p>Alamat: Kantor Desa Posyandu, Kecamatan Artdevata, Kabupaten Tabanan, Bali</p>
            <p>Telepon: (0361) 1234567 | Email: info@posyandu-sejahtera.org</p>
        </div>

        <div class="report-title">
            Laporan Perkembangan & Status Kesehatan Anak
        </div>

        <!-- Identitas Balita -->
        <div class="section-title">Identitas Anak & Keluarga</div>
        <div class="info-grid">
            <div>
                <div class="info-item">
                    <div class="info-label">Nama Balita</div>
                    <div class="info-value">: {{ optional($pemeriksaan->balita)->nama_bayi ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">NIK</div>
                    <div class="info-value">: {{ optional($pemeriksaan->balita)->nik ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Jenis Kelamin</div>
                    <div class="info-value">: {{ (optional($pemeriksaan->balita)->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tanggal Lahir</div>
                    <div class="info-value">: {{ optional(optional($pemeriksaan->balita)->tanggal_lahir)->format('d/m/Y') ?? '-' }}</div>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <div class="info-label">No. Kartu Keluarga</div>
                    <div class="info-value">: {{ optional(optional($pemeriksaan->balita)->keluarga)->no_kk ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Kepala Keluarga</div>
                    <div class="info-value">: {{ optional(optional($pemeriksaan->balita)->keluarga)->nama_lengkap ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Nama Orang Tua</div>
                    <div class="info-value">: {{ optional($pemeriksaan->balita)->nama_ortu ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">: {{ optional($pemeriksaan->balita)->no_hp ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Data Pemeriksaan Terakhir -->
        <div class="section-title">Hasil Pemeriksaan Terakhir (Tanggal Kunjungan: {{ optional($pemeriksaan->tanggal_kunjungan)->format('d/m/Y') ?? '-' }})</div>
        
        <div class="info-grid" style="margin-bottom: 20px;">
            <div>
                <div class="info-item">
                    <div class="info-label">Umur Anak</div>
                    <div class="info-value">: {{ $pemeriksaan->umur ?? '-' }} Bulan</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Berat Badan</div>
                    <div class="info-value">: {{ $pemeriksaan->berat_badan ?? '-' }} kg ({{ $pemeriksaan->naik_tidak_naik ?? '-' }})</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tinggi Badan</div>
                    <div class="info-value">: {{ $pemeriksaan->panjang_badan ?? '-' }} cm</div>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <div class="info-label">Lingkar Kepala</div>
                    <div class="info-value">: {{ $pemeriksaan->lingkar_kepala ?? '-' }} cm</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Lingkar Lengan (LILA)</div>
                    <div class="info-value">: {{ $pemeriksaan->lingkar_lengan ?? '-' }} cm</div>
                </div>
            </div>
        </div>

        <div class="status-grid">
            <div class="status-card">
                <div class="status-card-label">Status BB/U</div>
                <div class="status-card-value">{{ $pemeriksaan->status_bb_u ?? '-' }}</div>
            </div>
            <div class="status-card">
                <div class="status-card-label">Status TB/U</div>
                <div class="status-card-value">{{ $pemeriksaan->status_pb_u ?? '-' }}</div>
            </div>
            <div class="status-card">
                <div class="status-card-label">Status BB/TB</div>
                <div class="status-card-value">{{ $pemeriksaan->status_bb_pb ?? '-' }}</div>
            </div>
            <div class="status-card">
                <div class="status-card-label">Status LILA</div>
                <div class="status-card-value">{{ $pemeriksaan->status_lila ?? '-' }}</div>
            </div>
        </div>

        <!-- Status Rujukan -->
        @php
            $isReferral = ($pemeriksaan->rujukan && $pemeriksaan->rujukan !== 'Tidak Ada');
        @endphp

        @if($isReferral)
            <div class="referral-box referral-needed">
                <span>⚠️ STATUS RUJUKAN: Perlu Rujukan (Dirujuk ke: {{ $pemeriksaan->rujukan }})</span>
            </div>
        @else
            <div class="referral-box referral-not-needed">
                <span>✓ STATUS RUJUKAN: Tidak Perlu Rujukan (Kondisi Sehat/Normal)</span>
            </div>
        @endif

        <!-- Catatan Kesehatan & Edukasi -->
        <div class="section-title">Catatan Kesehatan & Edukasi</div>
        <div class="notes-area">
            <strong>Catatan Kesehatan Anak / Keluhan Sakit:</strong><br>
            {{ $pemeriksaan->catatan_kesehatan ?? 'Tidak ada catatan keluhan kesehatan.' }}
            <br><br>
            <strong>Materi Edukasi yang Diberikan:</strong><br>
            {{ $pemeriksaan->edukasi ?? 'Tidak ada catatan materi edukasi.' }}
        </div>

        <!-- Riwayat Perkembangan -->
        <div class="section-title">Riwayat Perkembangan Anak (Log Pemeriksaan)</div>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Umur (Bulan)</th>
                    <th>Berat (kg)</th>
                    <th>Tinggi (cm)</th>
                    <th>LILA (cm)</th>
                    <th>LK (cm)</th>
                    <th>Status BB/U</th>
                    <th>Rujukan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $idx => $hist)
                    <tr class="{{ $hist->id === $pemeriksaan->id ? 'active-row' : '' }}">
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ optional($hist->tanggal_kunjungan)->format('d/m/Y') ?? '-' }}</td>
                        <td>{{ $hist->umur ?? '-' }}</td>
                        <td>{{ $hist->berat_badan ?? '-' }}</td>
                        <td>{{ $hist->panjang_badan ?? '-' }}</td>
                        <td>{{ $hist->lingkar_lengan ?? '-' }}</td>
                        <td>{{ $hist->lingkar_kepala ?? '-' }}</td>
                        <td>{{ $hist->status_bb_u ?? '-' }}</td>
                        <td>{{ $hist->rujukan ?? 'Tidak Ada' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">Tidak ada riwayat pemeriksaan lain.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Signature -->
        <div class="signature-block">
            <div class="signature-wrapper">
                <p>Mengetahui,</p>
                <p>Petugas Kesehatan / Bidan Posyandu</p>
                <div class="signature-line"></div>
                <p>NIP/Kader ID. .........................</p>
            </div>
        </div>
    </div>

    <script>
        // Automatically open the print dialog when page is loaded
        window.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
