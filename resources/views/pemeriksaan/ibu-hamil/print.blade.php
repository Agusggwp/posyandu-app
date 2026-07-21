<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perkembangan Ibu Hamil - {{ optional($pemeriksaan->ibuHamil)->nama_ibu }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary: #0f766e;
            --primary-light: #f0fdfa;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --rose-bg: #fff1f2;
            --rose-text: #e11d48;
            --emerald-bg: #f0fdf4;
            --emerald-text: #16a34a;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: var(--text-dark);
            padding: 40px 20px;
        }

        .no-print {
            display: flex;
            justify-content: space-between;
            max-width: 800px;
            margin: 0 auto 20px auto;
        }

        .btn {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .btn-secondary {
            background-color: white;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: #f8fafc;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0d9488;
        }

        .container {
            background-color: white;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            border: 1px solid var(--border-color);
        }

        /* Kop Surat */
        .letterhead {
            text-align: center;
            border-bottom: 3px double var(--primary);
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .letterhead h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--primary);
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .letterhead p {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .report-title {
            text-align: center;
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 25px;
            letter-spacing: 0.05em;
            color: var(--text-dark);
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--primary);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 6px;
            margin-bottom: 15px;
            margin-top: 25px;
        }

        /* Detail Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-item {
            display: flex;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .info-label {
            width: 140px;
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
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .status-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 15px;
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
            font-size: 15px;
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
    <div class="actions-header no-print" style="flex-wrap: wrap; gap: 10px;">
        <div style="display: flex; gap: 10px;">
            @if(Auth::guard('kepala_keluarga')->check())
                <a href="{{ route('kepala-keluarga.anggota.pemeriksaan', ['tipe' => 'ibu-hamil', 'id' => $pemeriksaan->ibu_hamil_identitas_id]) }}" class="btn btn-secondary">
                    ← Kembali ke Detail
                </a>
            @else
                <a href="{{ route('pemeriksaan-ibu-hamil.show', $pemeriksaan->id) }}" class="btn btn-secondary">
                    ← Kembali ke Detail
                </a>
            @endif
            <button onclick="window.print()" class="btn btn-primary">
                🖨️ Cetak Laporan
            </button>
        </div>
        <div style="font-size: 13px; color: var(--primary); font-weight: 600; display: flex; align-items: center; gap: 6px; background: var(--primary-light); padding: 8px 12px; border-radius: 8px; border: 1px solid #99f6e4;">
            💡 Info: Teks laporan ini dapat diedit langsung di layar sebelum dicetak.
        </div>
    </div>

    <div class="container">
        <!-- Letterhead -->
        <div class="letterhead">
            <h1>Posyandu Ibu Hamil Melati</h1>
            <p>Alamat: Kantor Desa Posyandu, Kecamatan Artdevata, Kabupaten Tabanan, Bali</p>
            <p>Telepon: (0361) 1234567 | Email: info@posyandu-melati.org</p>
        </div>

        <div class="report-title">
            Laporan Perkembangan & Status Kesehatan Ibu Hamil
        </div>

        <!-- Identitas Ibu Hamil -->
        <div class="section-title">Identitas Ibu & Keluarga</div>
        <div class="info-grid">
            <div>
                <div class="info-item">
                    <div class="info-label">Nama Ibu</div>
                    <div class="info-value" contenteditable="true">: {{ optional($pemeriksaan->ibuHamil)->nama_ibu ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">NIK</div>
                    <div class="info-value" contenteditable="true">: {{ optional($pemeriksaan->ibuHamil)->nik ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tanggal Lahir</div>
                    <div class="info-value" contenteditable="true">: {{ optional(optional($pemeriksaan->ibuHamil)->tanggal_lahir)->format('d/m/Y') ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Umur Ibu</div>
                    <div class="info-value" contenteditable="true">: {{ optional($pemeriksaan->ibuHamil)->umur ?? '-' }} Tahun</div>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <div class="info-label">No. Kartu Keluarga</div>
                    <div class="info-value" contenteditable="true">: {{ optional(optional($pemeriksaan->ibuHamil)->keluarga)->no_kk ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Nama Suami</div>
                    <div class="info-value" contenteditable="true">: {{ optional($pemeriksaan->ibuHamil)->nama_suami ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value" contenteditable="true">: {{ optional($pemeriksaan->ibuHamil)->no_hp ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Data Pemeriksaan Terakhir -->
        <div class="section-title">Hasil Pemeriksaan Terakhir (Tanggal Kunjungan: {{ optional($pemeriksaan->tanggal_kunjungan)->format('d/m/Y') ?? '-' }})</div>
        
        <div class="info-grid" style="margin-bottom: 20px;">
            <div>
                <div class="info-item">
                    <div class="info-label">Usia Kehamilan</div>
                    <div class="info-value" contenteditable="true">: {{ $pemeriksaan->usia_kehamilan ?? '-' }} Minggu</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Berat Badan</div>
                    <div class="info-value" contenteditable="true">: {{ $pemeriksaan->berat_badan ?? '-' }} kg (Kenaikan: {{ $pemeriksaan->status_bb ?? '-' }})</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tinggi Fundus (TFU)</div>
                    <div class="info-value" contenteditable="true">: {{ $pemeriksaan->tinggi_fundus ?? '-' }} cm</div>
                </div>
            </div>
            <div>
                <div class="info-item">
                    <div class="info-label">Tekanan Darah</div>
                    <div class="info-value" contenteditable="true">: {{ $pemeriksaan->tekanan_darah ?? '-' }} mmHg</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Lingkar Lengan (LILA)</div>
                    <div class="info-value" contenteditable="true">: {{ $pemeriksaan->lingkar_lengan ?? '-' }} cm</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Detak Jantung Janin</div>
                    <div class="info-value" contenteditable="true">: {{ $pemeriksaan->djj ?? '-' }} bpm (Posisi: {{ $pemeriksaan->letak_janin ?? '-' }})</div>
                </div>
            </div>
        </div>

        <div class="status-grid">
            <div class="status-card">
                <div class="status-card-label">Status LILA (Resiko KEK)</div>
                <div class="status-card-value" contenteditable="true">{{ $pemeriksaan->status_lila === 'Merah' ? '🔴 Beresiko KEK' : '🟢 Normal' }}</div>
            </div>
            <div class="status-card">
                <div class="status-card-label">Status Tekanan Darah</div>
                <div class="status-card-value" contenteditable="true">{{ $pemeriksaan->status_tekanan_darah ?? 'Normal' }}</div>
            </div>
        </div>

        <!-- Status Rujukan -->
        @php
            $isReferral = ($pemeriksaan->rujukan && $pemeriksaan->rujukan !== 'Tidak');
        @endphp

        @if($isReferral)
            <div class="referral-box referral-needed" contenteditable="true">
                <span>⚠️ STATUS RUJUKAN: Perlu Rujukan Pasien (Dirujuk ke: {{ $pemeriksaan->rujukan }})</span>
            </div>
        @else
            <div class="referral-box referral-not-needed" contenteditable="true">
                <span>✓ STATUS RUJUKAN: Tidak Perlu Rujukan (Kondisi Sehat/Normal)</span>
            </div>
        @endif

        <!-- Catatan Kesehatan & Edukasi -->
        <div class="section-title">Catatan Kesehatan & Pelayanan Medis</div>
        <div class="notes-area" contenteditable="true">
            <strong>Tablet Fe (Tambah Darah):</strong> {{ $pemeriksaan->tablet_tambah_darah ? 'Diberikan' : 'Tidak Diberikan' }} | 
            <strong>PMT Bumil:</strong> {{ $pemeriksaan->pmt_bumil ? 'Diberikan' : 'Tidak Diberikan' }} | 
            <strong>Kelas Ibu Hamil:</strong> {{ $pemeriksaan->kelas_ibu_hamil ? 'Mengikuti' : 'Tidak Mengikuti' }}
            <br><br>
            <strong>Catatan Bidan / Keluhan Hamil:</strong><br>
            {{ $pemeriksaan->catatan_kesehatan ?? 'Tidak ada keluhan kesehatan khusus.' }}
            <br><br>
            <strong>Materi Edukasi yang Diberikan:</strong><br>
            {{ $pemeriksaan->edukasi ?? 'Tidak ada catatan materi edukasi.' }}
        </div>

        <!-- Signature -->
        <div class="signature-block">
            <div class="signature-wrapper">
                <p>Mengetahui,</p>
                <p>Bidan Posyandu / Petugas Pemeriksa</p>
                <div class="signature-line" contenteditable="true">Bidan Posyandu</div>
                <p contenteditable="true">NIP. .........................</p>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
