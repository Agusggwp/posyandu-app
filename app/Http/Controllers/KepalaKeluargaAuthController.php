<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Lansia;
use App\Models\Nifas;
use App\Models\Remaja;
use App\Models\PemeriksaanBalita;
use App\Models\PemeriksaanIbuHamil;
use App\Models\PemeriksaanLansia;
use App\Models\PemeriksaanNifas;
use App\Models\PemeriksaanRemaja;
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

        $guard = Auth::guard('kepala_keluarga');

        if ($guard->attempt($credentials)) {
            $user = $guard->user();

            if (! $user?->email_verified_at) {
                $guard->logout();

                return back()->withErrors([
                    'email' => 'Akun belum diaktivasi melalui email.',
                ])->onlyInput('email');
            }

            if ($user->status !== 'approved') {
                $guard->logout();

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
        if (Setting::getSetting('kk_registration_status', 'active') !== 'active') {
            return redirect()->route('kepala-keluarga.login')
                ->withErrors(['email' => 'Pendaftaran Kepala Keluarga sedang dinonaktifkan oleh admin.']);
        }

        return view('panel_kepalakeluarga.auth.register');
    }

    public function register(Request $request)
    {
        if (Setting::getSetting('kk_registration_status', 'active') !== 'active') {
            return redirect()->route('kepala-keluarga.login')
                ->withErrors(['email' => 'Pendaftaran Kepala Keluarga sedang dinonaktifkan oleh admin.']);
        }

        $autoApprove = Setting::getSetting('kk_auto_approve', 'inactive') === 'active';

        $validated = $request->validate([
            'no_kk' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:kepala_keluarga,no_kk'],
            'nama_lengkap' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:kepala_keluarga,email'],
            'no_nik' => ['nullable', 'string', 'size:16', 'regex:/^[0-9]{16}$/', 'unique:kepala_keluarga,no_nik'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['nullable', 'string', 'between:11,13', 'regex:/^[0-9]{11,13}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'no_kk.required' => 'Nomor KK wajib diisi.',
            'no_kk.size' => 'Masukkan 16 Digit No KK',
            'no_kk.regex' => 'Masukkan 16 Digit No KK',
            'no_kk.unique' => 'Nomor KK sudah terdaftar.',
            
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 30 karakter.',
            'nama_lengkap.regex' => 'Nama lengkap hanya boleh berisi huruf dan spasi.',
            
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar/digunakan.',
            
            'no_nik.size' => 'Masukkan 16 Digit NIK',
            'no_nik.regex' => 'Masukkan 16 Digit NIK',
            'no_nik.unique' => 'NIK sudah terdaftar.',
            
            'no_telepon.between' => 'Nomor telepon harus terdiri dari 11 sampai 13 digit.',
            'no_telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
        ]);

        $keluarga = Keluarga::create([
            'no_kk' => $validated['no_kk'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'no_nik' => $validated['no_nik'] ?? null,
            'alamat' => $validated['alamat'],
            'no_telepon' => $validated['no_telepon'] ?? null,
            'password' => Hash::make($validated['password']),
            'status' => $autoApprove ? 'approved' : 'pending',
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

        $message = $keluarga->status === 'approved'
            ? 'Akun berhasil diaktivasi. Silakan login.'
            : 'Akun berhasil diaktivasi. Menunggu persetujuan admin.';

        return redirect()->route('kepala-keluarga.login')->with('success', $message);
    }

    public function dashboard()
    {
        $kepalaKeluarga = Auth::guard('kepala_keluarga')->user();
        $kepalaKeluarga?->load(['balitas', 'ibuHamils', 'lansias', 'nifases', 'remajas']);
        Carbon::setLocale('id');

        $centerInfo = [
            'email' => Setting::getSetting('center_email', '-'),
            'address' => Setting::getSetting('center_address', '-'),
            'posyandu_date' => Setting::getSetting('center_posyandu_date', 'Setiap Tanggal 15, Jam 08:00 - 16:00 WIB'),
        ];

        $news = [
            'status' => Setting::getSetting('kk_news_status', 'active'),
            'aktif' => Setting::getSetting('kk_news_status', 'active') === 'active',
            'title' => Setting::getSetting('kk_news_title', 'Jadwal layanan Posyandu bulan ini'),
            'judul' => Setting::getSetting('kk_news_title', 'Jadwal layanan Posyandu bulan ini'),
            'summary' => Setting::getSetting('kk_news_summary', 'Layanan pemeriksaan rutin tersedia sesuai jadwal. Silakan cek detail lengkap pada halaman berita.'),
            'content' => Setting::getSetting('kk_news_content', 'Posyandu membuka layanan pemeriksaan keluarga secara berkala. Pastikan data anggota keluarga sudah lengkap agar proses layanan lebih cepat.'),
            'isi' => Setting::getSetting('kk_news_content', 'Posyandu membuka layanan pemeriksaan keluarga secara berkala. Pastikan data anggota keluarga sudah lengkap agar proses layanan lebih cepat.'),
            'gambar' => Setting::getSetting('kk_news_image', ''),
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

        $memberCards = collect();
        $memberDataJs = [];
        $checkupHistoryJs = [];
        $allCheckups = collect();

        foreach ($anggota as $memberMeta) {
            $memberModel = $this->resolveDashboardMemberModel($kepalaKeluarga, $memberMeta['tipe'], (int) $memberMeta['id']);

            if (! $memberModel) {
                continue;
            }

            $checkups = $memberModel->pemeriksaans()
                ->latest('created_at')
                ->limit(24)
                ->get();

            $latest = $checkups->first();
            $latestDate = $latest ? Carbon::parse($this->resolvePemeriksaanDate($latest)) : null;
            $status = $this->resolveHealthStatus($latest);

            $allCheckups = $allCheckups->concat(
                $checkups->map(function ($row) use ($memberMeta) {
                    return [
                        'member_name' => $memberMeta['nama'],
                        'member_type' => $memberMeta['label_tipe'],
                        'date' => Carbon::parse($this->resolvePemeriksaanDate($row)),
                    ];
                })
            );

            $displayDob = ! empty($memberModel->tanggal_lahir)
                ? Carbon::parse($memberModel->tanggal_lahir)->translatedFormat('d F Y')
                : '-';

            $age = $this->resolveMemberAge($memberModel, $memberMeta['tipe']);

            $memberCards->push([
                'name' => $memberMeta['nama'],
                'type' => $memberMeta['tipe'],
                'label' => $memberMeta['label_tipe'],
                'id' => (int) $memberMeta['id'],
                'nik' => $memberModel->nik ?? '-',
                'age' => $age,
                'status' => $status,
                'status_color' => $status === 'Sehat' ? 'green' : ($status === 'Belum Diperiksa' ? 'gray' : 'yellow'),
                'created_at' => $memberModel->created_at,
                'latest_checkup_date' => $latestDate,
                'detail_url' => route('kepala-keluarga.anggota.show', ['tipe' => $memberMeta['tipe'], 'id' => $memberMeta['id']]),
                'checkup_url' => route('kepala-keluarga.anggota.pemeriksaan', ['tipe' => $memberMeta['tipe'], 'id' => $memberMeta['id']]),
            ]);

            $memberDataJs[$memberMeta['nama']] = [
                'name' => $memberMeta['nama'],
                'nik' => $memberModel->nik ?? '-',
                'dob' => $displayDob,
                'age' => $age,
                'gender' => $memberModel->jenis_kelamin ?? '-',
                'relation' => $memberMeta['label_tipe'],
                'type' => $memberMeta['tipe'],
                'bp' => $this->resolveDisplayBloodPressure($latest),
                'weight' => $this->resolveDisplayWeight($latest),
                'height' => $this->resolveDisplayHeight($latest),
                'cholesterol' => $latest->kolesterol ?? '-',
                'glucose' => isset($latest->gula_darah) && $latest->gula_darah !== null ? $latest->gula_darah . ' mg/dL' : '-',
                'checkupDate' => $latestDate ? $latestDate->translatedFormat('d F Y') : '-',
                'lila' => $latest ? (isset($latest->lingkar_lengan) ? $latest->lingkar_lengan . ' cm' : (isset($latest->lila) ? $latest->lila . ' cm' : '-')) : '-',
                'lingkar_kepala' => $latest ? (isset($latest->lingkar_kepala) ? $latest->lingkar_kepala . ' cm' : '-') : '-',
                'lingkar_perut' => $latest ? (isset($latest->lingkar_perut) ? $latest->lingkar_perut . ' cm' : '-') : '-',
                'usia_kehamilan' => $latest ? (isset($latest->usia_kehamilan) ? $latest->usia_kehamilan . ' minggu' : '-') : '-',
                'djj' => $latest ? (isset($latest->denyut_jantung) ? $latest->denyut_jantung . ' dpm' : '-') : '-',
                'fundus' => $latest ? (isset($latest->tinggi_fundus) ? $latest->tinggi_fundus . ' cm' : '-') : '-',
                'hb' => $latest ? (isset($latest->hemoglobin) ? $latest->hemoglobin . ' g/dL' : '-') : '-',
                'gizi' => $latest ? ($latest->status_gizi ?? $latest->imt_status ?? $latest->status_bb_pb ?? $latest->status_berat_badan ?? '-') : '-',
                'weightHistory' => $checkups
                    ->reverse()
                    ->pluck('berat_badan')
                    ->filter(fn ($v) => $v !== null && $v !== '')
                    ->map(fn ($v) => (float) $v)
                    ->values()
                    ->all(),
                'dateLabels' => $checkups
                    ->reverse()
                    ->map(fn ($row) => Carbon::parse($this->resolvePemeriksaanDate($row))->format('d M'))
                    ->values()
                    ->all(),
            ];

            $historyByMonth = $checkups
                ->groupBy(fn ($row) => Carbon::parse($this->resolvePemeriksaanDate($row))->translatedFormat('F Y'))
                ->map(function ($rows, $monthLabel) use ($memberMeta) {
                    $rows = $rows->sortByDesc(fn ($row) => Carbon::parse($this->resolvePemeriksaanDate($row)))->values();

                    return [
                        'month' => $monthLabel,
                        'checkups' => $rows->map(function ($row) use ($memberMeta) {
                            $checkupData = [
                                'id' => $row->id,
                                'date' => Carbon::parse($this->resolvePemeriksaanDate($row))->translatedFormat('d F Y'),
                                'weight' => $this->resolveDisplayWeight($row),
                                'bp' => $this->resolveDisplayBloodPressure($row),
                                'cholesterol' => $row->kolesterol ?? '-',
                                'glucose' => isset($row->gula_darah) && $row->gula_darah !== null ? $row->gula_darah . ' mg/dL' : '-',
                                'status' => $this->resolveHealthStatus($row),
                                'type' => $memberMeta['tipe'],
                            ];

                            if ($memberMeta['tipe'] === 'balita') {
                                $checkupData['height'] = isset($row->panjang_badan) && $row->panjang_badan !== null ? $row->panjang_badan . ' cm' : '-';
                                $checkupData['lila'] = isset($row->lingkar_lengan) && $row->lingkar_lengan !== null ? $row->lingkar_lengan . ' cm' : '-';
                                $checkupData['lingkar_kepala'] = isset($row->lingkar_kepala) && $row->lingkar_kepala !== null ? $row->lingkar_kepala . ' cm' : '-';
                                $checkupData['status_bb_u'] = $row->status_bb_u ?? '-';
                                $checkupData['status_pb_u'] = $row->status_pb_u ?? '-';
                                $checkupData['status_bb_pb'] = $row->status_bb_pb ?? '-';
                            } elseif ($memberMeta['tipe'] === 'ibu-hamil') {
                                $checkupData['height'] = isset($row->tinggi_badan) && $row->tinggi_badan !== null ? $row->tinggi_badan . ' cm' : '-';
                                $checkupData['lila'] = isset($row->lingkar_lengan) && $row->lingkar_lengan !== null ? $row->lingkar_lengan . ' cm' : '-';
                                $checkupData['usia_kehamilan'] = isset($row->usia_kehamilan) && $row->usia_kehamilan !== null ? $row->usia_kehamilan . ' minggu' : '-';
                                $checkupData['djj'] = isset($row->denyut_jantung) && $row->denyut_jantung !== null ? $row->denyut_jantung . ' dpm' : '-';
                                $checkupData['fundus'] = isset($row->tinggi_fundus) && $row->tinggi_fundus !== null ? $row->tinggi_fundus . ' cm' : '-';
                            } elseif ($memberMeta['tipe'] === 'nifas') {
                                $checkupData['height'] = isset($row->tinggi_badan) && $row->tinggi_badan !== null ? $row->tinggi_badan . ' cm' : '-';
                                $checkupData['lila'] = isset($row->lila) && $row->lila !== null ? $row->lila . ' cm' : '-';
                                $checkupData['status_gizi'] = $row->status_gizi ?? '-';
                            } elseif ($memberMeta['tipe'] === 'remaja') {
                                $checkupData['height'] = isset($row->tinggi_badan) && $row->tinggi_badan !== null ? $row->tinggi_badan . ' cm' : '-';
                                $checkupData['lingkar_perut'] = isset($row->lingkar_perut) && $row->lingkar_perut !== null ? $row->lingkar_perut . ' cm' : '-';
                                $checkupData['hb'] = isset($row->hemoglobin) && $row->hemoglobin !== null ? $row->hemoglobin . ' g/dL' : '-';
                                $checkupData['imt_status'] = $row->imt_status ?? '-';
                            } elseif ($memberMeta['tipe'] === 'lansia') {
                                $checkupData['height'] = isset($row->tinggi_badan) && $row->tinggi_badan !== null ? $row->tinggi_badan . ' cm' : '-';
                                $checkupData['lingkar_perut'] = isset($row->lingkar_perut) && $row->lingkar_perut !== null ? $row->lingkar_perut . ' cm' : '-';
                                $checkupData['imt'] = $row->imt ?? '-';
                                $checkupData['status_bb'] = $row->status_berat_badan ?? '-';
                            }

                            return $checkupData;
                        })->values()->all(),
                        'historicalWeights' => $rows
                            ->sortBy(fn ($row) => Carbon::parse($this->resolvePemeriksaanDate($row)))
                            ->pluck('berat_badan')
                            ->filter(fn ($v) => $v !== null && $v !== '')
                            ->map(fn ($v) => (float) $v)
                            ->values()
                            ->all(),
                        'historicalDates' => $rows
                            ->sortBy(fn ($row) => Carbon::parse($this->resolvePemeriksaanDate($row)))
                            ->map(fn ($row) => Carbon::parse($this->resolvePemeriksaanDate($row))->format('d M'))
                            ->values()
                            ->all(),
                    ];
                })
                ->values()
                ->all();

            $checkupHistoryJs[$memberMeta['nama']] = $historyByMonth;
        }

        $recentMembers = $memberCards
            ->sortByDesc('created_at')
            ->take(2)
            ->values();

        $recentCheckups = $allCheckups
            ->sortByDesc('date')
            ->take(2)
            ->values();

        $pemeriksaanBulanIni = $allCheckups
            ->filter(fn ($row) => $row['date']->greaterThanOrEqualTo(now()->startOfMonth()))
            ->count();

        $latestCheckupDate = $allCheckups->isNotEmpty() ? $allCheckups->sortByDesc('date')->first()['date'] : null;

        $dashboardMetrics = [
            'total_anggota' => $anggota->count(),
            'pemeriksaan_bulan_ini' => $pemeriksaanBulanIni,
            'status_kesehatan' => $memberCards->where('status', 'Perlu Kontrol')->isNotEmpty() ? 'Perlu Kontrol' : 'Baik',
            'jadwal_berikutnya' => $latestCheckupDate ? $latestCheckupDate->copy()->addDays(30)->translatedFormat('d M Y') : '-',
        ];

        return view('panel_kepalakeluarga.dashboard', compact(
            'kepalaKeluarga',
            'anggota',
            'centerInfo',
            'news',
            'dashboardMetrics',
            'recentMembers',
            'recentCheckups',
            'memberCards',
            'memberDataJs',
            'checkupHistoryJs'
        ));
    }

    private function resolveDashboardMemberModel(Keluarga $kepalaKeluarga, string $type, int $id)
    {
        return match ($type) {
            'balita' => $kepalaKeluarga->balitas->firstWhere('id', $id),
            'ibu-hamil' => $kepalaKeluarga->ibuHamils->firstWhere('id', $id),
            'nifas' => $kepalaKeluarga->nifases->firstWhere('id', $id),
            'remaja' => $kepalaKeluarga->remajas->firstWhere('id', $id),
            'lansia' => $kepalaKeluarga->lansias->firstWhere('id', $id),
            default => null,
        };
    }

    private function resolveMemberAge($memberModel, string $type): string
    {
        if (! empty($memberModel->umur)) {
            return $memberModel->umur . ' tahun';
        }

        if (! empty($memberModel->tanggal_lahir)) {
            return Carbon::parse($memberModel->tanggal_lahir)->age . ' tahun';
        }

        return '-';
    }

    private function resolveHealthStatus($latest): string
    {
        if (! $latest) {
            return 'Belum Diperiksa';
        }

        if (! empty($latest->tekanan_darah_status)) {
            return str_contains(strtolower((string) $latest->tekanan_darah_status), 'normal') ? 'Sehat' : 'Perlu Kontrol';
        }

        $flags = [
            $latest->status_bb_u ?? null,
            $latest->status_pb_u ?? null,
            $latest->status_bb_pb ?? null,
            $latest->status_lila ?? null,
        ];

        $filledFlags = array_filter($flags, fn ($v) => $v !== null && $v !== '');

        if (! empty($filledFlags)) {
            foreach ($filledFlags as $flag) {
                if (! str_contains(strtolower((string) $flag), 'normal')) {
                    return 'Perlu Kontrol';
                }
            }

            return 'Sehat';
        }

        return 'Sehat';
    }

    private function resolveDisplayBloodPressure($latest): string
    {
        if (! $latest) {
            return '-';
        }

        if (! empty($latest->tekanan_darah)) {
            return (string) $latest->tekanan_darah;
        }

        if (isset($latest->sistole) && isset($latest->diastole) && $latest->sistole !== null && $latest->diastole !== null) {
            return $latest->sistole . '/' . $latest->diastole . ' mmHg';
        }

        return '-';
    }

    private function resolveDisplayWeight($latest): string
    {
        if (! $latest || ! isset($latest->berat_badan) || $latest->berat_badan === null || $latest->berat_badan === '') {
            return '-';
        }

        return $latest->berat_badan . ' kg';
    }

    private function resolveDisplayHeight($latest): string
    {
        if (! $latest) {
            return '-';
        }

        if (isset($latest->tinggi_badan) && $latest->tinggi_badan !== null && $latest->tinggi_badan !== '') {
            return $latest->tinggi_badan . ' cm';
        }

        if (isset($latest->panjang_badan) && $latest->panjang_badan !== null && $latest->panjang_badan !== '') {
            return $latest->panjang_badan . ' cm';
        }

        return '-';
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
            ->map(function ($item) use ($tipe) {
                $tanggal = $item->created_at;

                if (! empty($item->tanggal_kunjungan)) {
                    $tanggal = $item->tanggal_kunjungan;
                } elseif (! empty($item->waktu_kunjungan)) {
                    $tanggal = $item->waktu_kunjungan;
                }

                return [
                    'id' => $item->id,
                    'tanggal' => $tanggal,
                    'catatan' => $this->buildCheckupRichCatatan($item, $tipe),
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
            ->map(function ($item) use ($tipe) {
                return [
                    'id' => $item->id,
                    'tanggal' => $this->resolvePemeriksaanDate($item),
                    'catatan' => $this->buildCheckupRichCatatan($item, $tipe),
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

    public function printPemeriksaan(string $tipe, int $id)
    {
        $kepalaKeluarga = Auth::guard('kepala_keluarga')->user();

        $memberMap = [
            'balita' => [
                'model' => Balita::class,
                'pemeriksaanModel' => PemeriksaanBalita::class,
                'relation' => 'balita',
                'view' => 'pemeriksaan.balita.print',
                'foreignKey' => 'balita_identitas_id',
                'loadExtra' => ['balita.keluarga', 'balita.pemeriksaans' => function($q) {
                    $q->orderBy('tanggal_kunjungan', 'asc');
                }]
            ],
            'ibu-hamil' => [
                'model' => IbuHamil::class,
                'pemeriksaanModel' => PemeriksaanIbuHamil::class,
                'relation' => 'ibuHamil',
                'view' => 'pemeriksaan.ibu-hamil.print',
                'foreignKey' => 'ibu_hamil_identitas_id',
                'loadExtra' => ['ibuHamil.keluarga']
            ],
            'nifas' => [
                'model' => Nifas::class,
                'pemeriksaanModel' => PemeriksaanNifas::class,
                'relation' => 'nifas',
                'view' => 'pemeriksaan.nifas.print',
                'foreignKey' => 'nifas_identitas_id',
                'loadExtra' => ['nifas.keluarga']
            ],
            'remaja' => [
                'model' => Remaja::class,
                'pemeriksaanModel' => PemeriksaanRemaja::class,
                'relation' => 'remaja',
                'view' => 'pemeriksaan.remaja.print',
                'foreignKey' => 'remaja_identitas_id',
                'loadExtra' => ['remaja.keluarga']
            ],
            'lansia' => [
                'model' => Lansia::class,
                'pemeriksaanModel' => PemeriksaanLansia::class,
                'relation' => 'lansia',
                'view' => 'pemeriksaan.lansia.print',
                'foreignKey' => 'dewasa_identitas_id',
                'loadExtra' => ['lansia.keluarga']
            ],
        ];

        if (! isset($memberMap[$tipe])) {
            abort(404);
        }

        $config = $memberMap[$tipe];

        // 1. Fetch the checkup
        $pemeriksaan = $config['pemeriksaanModel']::findOrFail($id);

        // 2. Fetch the corresponding member and check permission
        $memberId = $pemeriksaan->{$config['foreignKey']};
        $member = $config['model']::where('kepala_keluarga_id', $kepalaKeluarga->id)->findOrFail($memberId);

        // 3. Load relations exactly like the admin print method
        $pemeriksaan->load($config['loadExtra']);

        // 4. Fetch history exactly like the admin print method
        if ($tipe === 'balita') {
            $history = $pemeriksaan->balita->pemeriksaans ?? collect();
        } else {
            $history = $config['pemeriksaanModel']::where($config['foreignKey'], $memberId)
                ->where('tahap_terakhir', 4)
                ->orderBy('tanggal_kunjungan', 'asc')
                ->get();
        }

        // 5. Render the exact same view as admin
        return view($config['view'], compact('pemeriksaan', 'history'));
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

    private function buildCheckupRichCatatan($item, string $tipe): string
    {
        $detailParts = [];
        
        if (isset($item->berat_badan) && $item->berat_badan !== null && $item->berat_badan !== '') {
            $detailParts[] = 'Berat: ' . $item->berat_badan . ' kg';
        }
        
        if ($tipe === 'balita') {
            if (isset($item->panjang_badan) && $item->panjang_badan !== null && $item->panjang_badan !== '') {
                $detailParts[] = 'Tinggi/Panjang: ' . $item->panjang_badan . ' cm';
            }
            if (isset($item->lingkar_lengan) && $item->lingkar_lengan !== null && $item->lingkar_lengan !== '') {
                $detailParts[] = 'LILA: ' . $item->lingkar_lengan . ' cm';
            }
            if (isset($item->lingkar_kepala) && $item->lingkar_kepala !== null && $item->lingkar_kepala !== '') {
                $detailParts[] = 'LK: ' . $item->lingkar_kepala . ' cm';
            }
        } elseif ($tipe === 'ibu-hamil') {
            if (isset($item->tinggi_badan) && $item->tinggi_badan !== null && $item->tinggi_badan !== '') {
                $detailParts[] = 'Tinggi: ' . $item->tinggi_badan . ' cm';
            }
            if (isset($item->tekanan_darah) && $item->tekanan_darah !== null && $item->tekanan_darah !== '') {
                $detailParts[] = 'TD: ' . $item->tekanan_darah;
            }
            if (isset($item->lingkar_lengan) && $item->lingkar_lengan !== null && $item->lingkar_lengan !== '') {
                $detailParts[] = 'LILA: ' . $item->lingkar_lengan . ' cm';
            }
            if (isset($item->usia_kehamilan) && $item->usia_kehamilan !== null && $item->usia_kehamilan !== '') {
                $detailParts[] = 'UK: ' . $item->usia_kehamilan . ' minggu';
            }
            if (isset($item->denyut_jantung) && $item->denyut_jantung !== null && $item->denyut_jantung !== '') {
                $detailParts[] = 'DJJ: ' . $item->denyut_jantung . ' dpm';
            }
        } elseif ($tipe === 'nifas') {
            if (isset($item->tinggi_badan) && $item->tinggi_badan !== null && $item->tinggi_badan !== '') {
                $detailParts[] = 'Tinggi: ' . $item->tinggi_badan . ' cm';
            }
            if (isset($item->sistole) && isset($item->diastole) && $item->sistole !== null && $item->diastole !== null) {
                $detailParts[] = 'TD: ' . $item->sistole . '/' . $item->diastole . ' mmHg';
            }
            if (isset($item->lila) && $item->lila !== null && $item->lila !== '') {
                $detailParts[] = 'LILA: ' . $item->lila . ' cm';
            }
        } elseif ($tipe === 'remaja') {
            if (isset($item->tinggi_badan) && $item->tinggi_badan !== null && $item->tinggi_badan !== '') {
                $detailParts[] = 'Tinggi: ' . $item->tinggi_badan . ' cm';
            }
            if (isset($item->sistole) && isset($item->diastole) && $item->sistole !== null && $item->diastole !== null) {
                $detailParts[] = 'TD: ' . $item->sistole . '/' . $item->diastole . ' mmHg';
            }
            if (isset($item->lingkar_perut) && $item->lingkar_perut !== null && $item->lingkar_perut !== '') {
                $detailParts[] = 'LP: ' . $item->lingkar_perut . ' cm';
            }
            if (isset($item->hemoglobin) && $item->hemoglobin !== null && $item->hemoglobin !== '') {
                $detailParts[] = 'Hb: ' . $item->hemoglobin . ' g/dL';
            }
        } elseif ($tipe === 'lansia') {
            if (isset($item->tinggi_badan) && $item->tinggi_badan !== null && $item->tinggi_badan !== '') {
                $detailParts[] = 'Tinggi: ' . $item->tinggi_badan . ' cm';
            }
            if (isset($item->sistole) && isset($item->diastole) && $item->sistole !== null && $item->diastole !== null) {
                $detailParts[] = 'TD: ' . $item->sistole . '/' . $item->diastole . ' mmHg';
            }
            if (isset($item->lingkar_perut) && $item->lingkar_perut !== null && $item->lingkar_perut !== '') {
                $detailParts[] = 'LP: ' . $item->lingkar_perut . ' cm';
            }
            if (isset($item->gula_darah) && $item->gula_darah !== null && $item->gula_darah !== '') {
                $detailParts[] = 'Gula Darah: ' . $item->gula_darah . ' mg/dL';
            }
            if (isset($item->kolesterol) && $item->kolesterol !== null && $item->kolesterol !== '') {
                $detailParts[] = 'Kolesterol: ' . $item->kolesterol;
            }
        }

        $catatan = $item->catatan
            ?? $item->catatan_kesehatan
            ?? $item->edukasi
            ?? '';

        $detailText = implode(', ', $detailParts);
        if (! empty($catatan) && $catatan !== '-') {
            $detailText .= ($detailText !== '' ? ' | ' : '') . 'Catatan: ' . $catatan;
        }

        return $detailText ?: '-';
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

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:kepala_keluarga,email,' . auth('kepala_keluarga')->id(),
            'alamat' => 'nullable|string|max:500',
        ]);

        $kepalaKeluarga = auth('kepala_keluarga')->user();
        $kepalaKeluarga->update($validated);

        return redirect()->route('kepala-keluarga.dashboard')->with('success', 'Profile berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $kepalaKeluarga = auth('kepala_keluarga')->user();

        if (!Hash::check($request->old_password, $kepalaKeluarga->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
        }

        $kepalaKeluarga->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
