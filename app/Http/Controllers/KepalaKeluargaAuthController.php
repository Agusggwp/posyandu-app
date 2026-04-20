<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Lansia;
use App\Models\Nifas;
use App\Models\Remaja;
use App\Models\Setting;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KepalaKeluargaAuthController extends Controller
{
    public function showLoginForm()
    {
        $loginSettings = [
            'badge' => Setting::getSetting('kk_login_badge', 'Portal Keluarga Posyandu'),
            'hero_title' => Setting::getSetting('kk_login_hero_title', 'Pantau kesehatan keluarga lebih mudah.'),
            'hero_subtitle' => Setting::getSetting('kk_login_hero_subtitle', 'Satu tempat untuk akses data kunjungan, informasi layanan, dan catatan penting kesehatan keluarga Anda.'),
            'feature_1_title' => Setting::getSetting('kk_login_feature_1_title', 'Akses cepat data keluarga'),
            'feature_1_desc' => Setting::getSetting('kk_login_feature_1_desc', 'Lihat riwayat pemeriksaan dan status layanan secara real-time.'),
            'feature_2_title' => Setting::getSetting('kk_login_feature_2_title', 'Data aman dan privat'),
            'feature_2_desc' => Setting::getSetting('kk_login_feature_2_desc', 'Informasi hanya bisa diakses melalui akun terverifikasi.'),
            'footer_text' => Setting::getSetting('kk_login_footer_text', 'Posyandu Digital • Layanan Kesehatan Keluarga'),
            'form_title' => Setting::getSetting('kk_login_form_title', 'Login Kepala Keluarga'),
            'form_subtitle' => Setting::getSetting('kk_login_form_subtitle', 'Masuk untuk melanjutkan ke panel keluarga.'),
        ];

        return view('panel_kepalakeluarga.auth.login', compact('loginSettings'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->has('remember');

        if (Auth::guard('kepala_keluarga')->attempt($credentials, $remember)) {
            $user = Auth::guard('kepala_keluarga')->user();

            if (! $user?->email_verified_at) {
                Auth::guard('kepala_keluarga')->logout();

                return back()->withErrors([
                    'email' => 'Akun belum diaktivasi melalui email.',
                ])->onlyInput('email');
            }

            if ($user->status !== 'approved') {
                Auth::guard('kepala_keluarga')->logout();

                return back()->withErrors([
                    'email' => $user->status === 'rejected'
                        ? 'Akun Anda ditolak oleh admin.'
                        : 'Akun Anda masih menunggu persetujuan admin.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('kepala-keluarga.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('panel_kepalakeluarga.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => ['required', 'string', 'max:255', 'unique:kepala_keluarga,no_kk'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:kepala_keluarga,email'],
            'no_nik' => ['nullable', 'string', 'max:16', 'unique:kepala_keluarga,no_nik'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $keluarga = Keluarga::create([
            'no_kk' => $validated['no_kk'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_nik' => $validated['no_nik'] ?? null,
            'alamat' => $validated['alamat'],
            'no_telepon' => $validated['no_telepon'] ?? null,
            'password' => Hash::make($validated['password']),
            'status' => 'pending',
            'email_verified_at' => null,
        ]);

        $activationUrl = URL::temporarySignedRoute(
            'kepala-keluarga.activate',
            Carbon::now()->addDay(),
            [
                'id' => $keluarga->id,
                'hash' => sha1($keluarga->email),
            ]
        );

        Mail::send('emails.kepala-keluarga-activation', [
            'keluarga' => $keluarga,
            'activationUrl' => $activationUrl,
        ], function ($message) use ($keluarga) {
            $message->to($keluarga->email, $keluarga->nama_lengkap)
                ->subject('Aktivasi Akun Kepala Keluarga');
        });

        return redirect()->route('kepala-keluarga.login')->with('success', 'Akun berhasil didaftarkan. Silakan cek email untuk aktivasi akun.');
    }

    public function activate(Request $request, $id, $hash)
    {
        $keluarga = Keluarga::findOrFail($id);

        if (! hash_equals(sha1($keluarga->email), (string) $hash)) {
            abort(403);
        }

        if (! $keluarga->email_verified_at) {
            $keluarga->forceFill([
                'email_verified_at' => now(),
            ])->save();
        }

        return redirect()->route('kepala-keluarga.login')->with('success', 'Akun berhasil diaktivasi. Menunggu persetujuan admin.');
    }

    public function dashboard()
    {
        $kepalaKeluarga = Auth::guard('kepala_keluarga')->user();
        $kepalaKeluarga?->load(['balitas', 'ibuHamils', 'lansias', 'nifases', 'remajas']);

        $centerInfo = [
            'email' => Setting::getSetting('center_email', '-'),
            'address' => Setting::getSetting('center_address', '-'),
            'hours_open' => Setting::getSetting('center_hours_open', '08:00'),
            'hours_close' => Setting::getSetting('center_hours_close', '16:00'),
        ];

        $news = [
            'status' => Setting::getSetting('kk_news_status', 'active'),
            'title' => Setting::getSetting('kk_news_title', 'Jadwal layanan Posyandu bulan ini'),
            'summary' => Setting::getSetting('kk_news_summary', 'Layanan pemeriksaan rutin tersedia sesuai jadwal. Silakan cek detail lengkap pada halaman berita.'),
            'content' => Setting::getSetting('kk_news_content', 'Posyandu membuka layanan pemeriksaan keluarga secara berkala. Pastikan data anggota keluarga sudah lengkap agar proses layanan lebih cepat.'),
            'link_url' => Setting::getSetting('kk_news_link_url', ''),
            'link_label' => Setting::getSetting('kk_news_link_label', 'Baca informasi lengkap'),
            'published_at' => Setting::getSetting('kk_news_published_at', now()->format('Y-m-d')),
        ];

        $anggota = collect();

        if ($kepalaKeluarga) {
            $anggota = $anggota
                ->merge($kepalaKeluarga->balitas->map(fn (Balita $item) => [
                    'tipe' => 'balita',
                    'label_tipe' => 'Balita',
                    'id' => $item->id,
                    'nama' => $item->nama_bayi,
                ]))
                ->merge($kepalaKeluarga->ibuHamils->map(fn (IbuHamil $item) => [
                    'tipe' => 'ibu-hamil',
                    'label_tipe' => 'Ibu Hamil',
                    'id' => $item->id,
                    'nama' => $item->nama_ibu,
                ]))
                ->merge($kepalaKeluarga->nifases->map(fn (Nifas $item) => [
                    'tipe' => 'nifas',
                    'label_tipe' => 'Nifas',
                    'id' => $item->id,
                    'nama' => $item->nama_ibu,
                ]))
                ->merge($kepalaKeluarga->remajas->map(fn (Remaja $item) => [
                    'tipe' => 'remaja',
                    'label_tipe' => 'Remaja',
                    'id' => $item->id,
                    'nama' => $item->nama_anak,
                ]))
                ->merge($kepalaKeluarga->lansias->map(fn (Lansia $item) => [
                    'tipe' => 'lansia',
                    'label_tipe' => 'Lansia',
                    'id' => $item->id,
                    'nama' => $item->nama,
                ]))
                ->filter(fn (array $item) => ! empty($item['nama']))
                ->sortBy('nama', SORT_NATURAL | SORT_FLAG_CASE)
                ->values();
        }

        return view('panel_kepalakeluarga.dashboard', compact('kepalaKeluarga', 'anggota', 'centerInfo', 'news'));
    }

    public function showMemberDetail(string $tipe, int $id)
    {
        $kepalaKeluarga = Auth::guard('kepala_keluarga')->user();

        $memberMap = [
            'balita' => [Balita::class, 'nama_bayi', 'Balita'],
            'ibu-hamil' => [IbuHamil::class, 'nama_ibu', 'Ibu Hamil'],
            'nifas' => [Nifas::class, 'nama_ibu', 'Nifas'],
            'remaja' => [Remaja::class, 'nama_anak', 'Remaja'],
            'lansia' => [Lansia::class, 'nama', 'Lansia'],
        ];

        if (! isset($memberMap[$tipe])) {
            abort(404);
        }

        [$modelClass, $nameField, $typeLabel] = $memberMap[$tipe];

        $member = $modelClass::query()
            ->where('kepala_keluarga_id', $kepalaKeluarga->id)
            ->findOrFail($id);

        $displayAttributes = collect($member->getAttributes())
            ->except(['created_at', 'updated_at'])
            ->mapWithKeys(function ($value, $key) {
                if ($value === null || $value === '') {
                    return [$key => '-'];
                }

                return [$key => (string) $value];
            });

        return view('panel_kepalakeluarga.member-detail', [
            'kepalaKeluarga' => $kepalaKeluarga,
            'member' => $member,
            'memberType' => $tipe,
            'memberName' => $member->{$nameField} ?? '-',
            'memberTypeLabel' => $typeLabel,
            'displayAttributes' => $displayAttributes,
        ]);
    }

    public function showMemberPemeriksaanStats(string $tipe, int $id)
    {
        $kepalaKeluarga = Auth::guard('kepala_keluarga')->user();

        $memberMap = [
            'balita' => [Balita::class, 'nama_bayi', 'Balita'],
            'ibu-hamil' => [IbuHamil::class, 'nama_ibu', 'Ibu Hamil'],
            'nifas' => [Nifas::class, 'nama_ibu', 'Nifas'],
            'remaja' => [Remaja::class, 'nama_anak', 'Remaja'],
            'lansia' => [Lansia::class, 'nama', 'Lansia'],
        ];

        if (! isset($memberMap[$tipe])) {
            abort(404);
        }

        [$modelClass, $nameField, $typeLabel] = $memberMap[$tipe];

        $member = $modelClass::query()
            ->where('kepala_keluarga_id', $kepalaKeluarga->id)
            ->findOrFail($id);

        $query = $member->pemeriksaans();

        $totalPemeriksaan = (clone $query)->count();
        $pemeriksaanBulanIni = (clone $query)
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();

        $terakhir = (clone $query)->latest('created_at')->first();
        $duaRiwayatTerakhir = (clone $query)->latest('created_at')->limit(2)->get();
        $perbandinganTersedia = $duaRiwayatTerakhir->count() >= 2;

        $latestRiwayat = $perbandinganTersedia ? $duaRiwayatTerakhir->first() : null;
        $previousRiwayat = $perbandinganTersedia ? $duaRiwayatTerakhir->skip(1)->first() : null;

        $perkembangan = $perbandinganTersedia
            ? $this->buildPerkembanganFromRiwayat($tipe, $latestRiwayat, $previousRiwayat)
            : [];

        $riwayat = (clone $query)
            ->latest('created_at')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $tanggal = $item->created_at;

                if (! empty($item->tanggal_kunjungan)) {
                    $tanggal = $item->tanggal_kunjungan;
                } elseif (! empty($item->waktu_kunjungan)) {
                    $tanggal = $item->waktu_kunjungan;
                }

                return [
                    'id' => $item->id,
                    'tanggal' => $tanggal,
                    'catatan' => $item->catatan
                        ?? $item->catatan_kesehatan
                        ?? $item->edukasi
                        ?? '-',
                ];
            });

        return view('panel_kepalakeluarga.member-pemeriksaan', [
            'member' => $member,
            'memberType' => $tipe,
            'memberName' => $member->{$nameField} ?? '-',
            'memberTypeLabel' => $typeLabel,
            'totalPemeriksaan' => $totalPemeriksaan,
            'pemeriksaanBulanIni' => $pemeriksaanBulanIni,
            'terakhirPemeriksaan' => $terakhir?->created_at,
            'perbandinganTersedia' => $perbandinganTersedia,
            'tanggalRiwayatTerbaru' => $latestRiwayat ? $this->resolvePemeriksaanDate($latestRiwayat) : null,
            'tanggalRiwayatSebelumnya' => $previousRiwayat ? $this->resolvePemeriksaanDate($previousRiwayat) : null,
            'perkembangan' => $perkembangan,
            'riwayatPemeriksaan' => $riwayat,
        ]);
    }

    public function exportMemberPemeriksaan(string $tipe, int $id, string $format)
    {
        $format = strtolower($format);

        if (! in_array($format, ['csv', 'pdf'], true)) {
            abort(404);
        }

        $kepalaKeluarga = Auth::guard('kepala_keluarga')->user();

        $memberMap = [
            'balita' => [Balita::class, 'nama_bayi', 'Balita'],
            'ibu-hamil' => [IbuHamil::class, 'nama_ibu', 'Ibu Hamil'],
            'nifas' => [Nifas::class, 'nama_ibu', 'Nifas'],
            'remaja' => [Remaja::class, 'nama_anak', 'Remaja'],
            'lansia' => [Lansia::class, 'nama', 'Lansia'],
        ];

        if (! isset($memberMap[$tipe])) {
            abort(404);
        }

        [$modelClass, $nameField, $typeLabel] = $memberMap[$tipe];

        $member = $modelClass::query()
            ->where('kepala_keluarga_id', $kepalaKeluarga->id)
            ->findOrFail($id);

        $query = $member->pemeriksaans();

        $totalPemeriksaan = (clone $query)->count();
        $pemeriksaanBulanIni = (clone $query)
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();
        $terakhir = (clone $query)->latest('created_at')->first();

        $duaRiwayatTerakhir = (clone $query)->latest('created_at')->limit(2)->get();
        $perbandinganTersedia = $duaRiwayatTerakhir->count() >= 2;

        $latestRiwayat = $perbandinganTersedia ? $duaRiwayatTerakhir->first() : null;
        $previousRiwayat = $perbandinganTersedia ? $duaRiwayatTerakhir->skip(1)->first() : null;

        $perkembangan = $perbandinganTersedia
            ? $this->buildPerkembanganFromRiwayat($tipe, $latestRiwayat, $previousRiwayat)
            : [];

        $riwayat = (clone $query)
            ->latest('created_at')
            ->limit(50)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tanggal' => $this->resolvePemeriksaanDate($item),
                    'catatan' => $item->catatan
                        ?? $item->catatan_kesehatan
                        ?? $item->edukasi
                        ?? '-',
                ];
            });

        $fileSafeName = Str::slug($member->{$nameField} ?? 'anggota');
        $fileBase = "laporan-pemeriksaan-{$tipe}-{$fileSafeName}";

        if ($format === 'csv') {
            return $this->exportMemberPemeriksaanCsv(
                "{$fileBase}.csv",
                $typeLabel,
                $member->{$nameField} ?? '-',
                $totalPemeriksaan,
                $pemeriksaanBulanIni,
                $terakhir?->created_at,
                $perkembangan,
                $riwayat
            );
        }

        $pdfHtml = view('panel_kepalakeluarga.exports.member-pemeriksaan-pdf', [
            'memberTypeLabel' => $typeLabel,
            'memberName' => $member->{$nameField} ?? '-',
            'totalPemeriksaan' => $totalPemeriksaan,
            'pemeriksaanBulanIni' => $pemeriksaanBulanIni,
            'terakhirPemeriksaan' => $terakhir?->created_at,
            'perkembangan' => $perkembangan,
            'riwayatPemeriksaan' => $riwayat,
        ])->render();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdfHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileBase . '.pdf"',
        ]);
    }

    private function exportMemberPemeriksaanCsv(
        string $filename,
        string $memberTypeLabel,
        string $memberName,
        int $totalPemeriksaan,
        int $pemeriksaanBulanIni,
        $terakhirPemeriksaan,
        array $perkembangan,
        $riwayatPemeriksaan
    ): StreamedResponse {
        return response()->streamDownload(function () use (
            $memberTypeLabel,
            $memberName,
            $totalPemeriksaan,
            $pemeriksaanBulanIni,
            $terakhirPemeriksaan,
            $perkembangan,
            $riwayatPemeriksaan
        ) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Laporan Pemeriksaan Anggota']);
            fputcsv($handle, ['Nama', $memberName]);
            fputcsv($handle, ['Kategori', $memberTypeLabel]);
            fputcsv($handle, ['Total Pemeriksaan', $totalPemeriksaan]);
            fputcsv($handle, ['Pemeriksaan Bulan Ini', $pemeriksaanBulanIni]);
            fputcsv($handle, ['Pemeriksaan Terakhir', $terakhirPemeriksaan ? Carbon::parse($terakhirPemeriksaan)->format('d-m-Y H:i') : '-']);
            fputcsv($handle, []);

            fputcsv($handle, ['Perkembangan']);
            fputcsv($handle, ['Indikator', 'Status', 'Nilai Sebelumnya', 'Nilai Terbaru', 'Selisih']);

            foreach ($perkembangan as $row) {
                fputcsv($handle, [
                    $row['label'],
                    ucfirst($row['status']),
                    number_format($row['nilai_sebelumnya'], 2, '.', ''),
                    number_format($row['nilai_terbaru'], 2, '.', ''),
                    number_format($row['selisih'], 2, '.', ''),
                ]);
            }

            fputcsv($handle, []);
            fputcsv($handle, ['Riwayat Pemeriksaan']);
            fputcsv($handle, ['No', 'Tanggal', 'Catatan']);

            foreach ($riwayatPemeriksaan as $index => $row) {
                fputcsv($handle, [
                    $index + 1,
                    $row['tanggal'] ? Carbon::parse($row['tanggal'])->format('d-m-Y H:i') : '-',
                    $row['catatan'] ?: '-',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function buildPerkembanganFromRiwayat(string $tipe, $latest, $previous): array
    {
        $metricMap = [
            'balita' => [
                'berat_badan' => 'Berat Badan',
                'panjang_badan' => 'Panjang Badan',
                'lingkar_kepala' => 'Lingkar Kepala',
            ],
            'ibu-hamil' => [
                'berat_badan' => 'Berat Badan',
                'tinggi_badan' => 'Tinggi Badan',
                'lingkar_lengan' => 'Lingkar Lengan',
            ],
            'nifas' => [
                'berat_badan' => 'Berat Badan',
                'tinggi_badan' => 'Tinggi Badan',
                'lila' => 'LILA',
                'sistole' => 'Sistole',
                'diastole' => 'Diastole',
            ],
            'remaja' => [
                'berat_badan' => 'Berat Badan',
                'tinggi_badan' => 'Tinggi Badan',
                'lingkar_perut' => 'Lingkar Perut',
                'sistole' => 'Sistole',
                'diastole' => 'Diastole',
            ],
            'lansia' => [
                'berat_badan' => 'Berat Badan',
                'tinggi_badan' => 'Tinggi Badan',
                'lingkar_perut' => 'Lingkar Perut',
                'sistole' => 'Sistole',
                'diastole' => 'Diastole',
            ],
        ];

        $metrics = $metricMap[$tipe] ?? [];
        $hasil = [];

        foreach ($metrics as $field => $label) {
            $latestValue = $this->toFloatOrNull(data_get($latest, $field));
            $previousValue = $this->toFloatOrNull(data_get($previous, $field));

            if ($latestValue === null || $previousValue === null) {
                continue;
            }

            $delta = $latestValue - $previousValue;
            $status = 'stabil';

            if ($delta > 0.0001) {
                $status = 'naik';
            } elseif ($delta < -0.0001) {
                $status = 'turun';
            }

            $hasil[] = [
                'field' => $field,
                'label' => $label,
                'nilai_terbaru' => $latestValue,
                'nilai_sebelumnya' => $previousValue,
                'selisih' => $delta,
                'status' => $status,
            ];
        }

        return $hasil;
    }

    private function resolvePemeriksaanDate($pemeriksaan)
    {
        if (! empty($pemeriksaan->tanggal_kunjungan)) {
            return $pemeriksaan->tanggal_kunjungan;
        }

        if (! empty($pemeriksaan->waktu_kunjungan)) {
            return $pemeriksaan->waktu_kunjungan;
        }

        return $pemeriksaan->created_at;
    }

    private function toFloatOrNull($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        return null;
    }

    public function logout(Request $request)
    {
        Auth::guard('kepala_keluarga')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('kepala-keluarga.login');
    }
}
