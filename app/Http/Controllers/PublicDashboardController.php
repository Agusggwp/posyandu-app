<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Lansia;
use App\Models\Keluarga;
use App\Models\Remaja;
use App\Models\Setting;
use Illuminate\Http\Request;

class PublicDashboardController extends Controller
{
    /**
     * Show the public dashboard landing page.
     */
    public function index()
    {
        $settings = [
            'app_name' => Setting::getSetting('system_app_name', 'Sistem Informasi Posyandu'),
            'app_tagline' => Setting::getSetting('system_app_tagline', 'Layanan kesehatan keluarga yang lebih cepat, rapi, dan terukur.'),
            'address' => Setting::getSetting('center_address', 'Jl. Mawar Indah No. 12, Kel. Sehat Sejahtera'),
            'email' => Setting::getSetting('center_email', 'info@posyandudigital.id'),
            'posyandu_date' => Setting::getSetting('center_posyandu_date', 'Setiap Tanggal 15, Jam 08:00 - 16:00 WIB'),
            'news_status' => Setting::getSetting('kk_news_status', 'active'),
            'news_title' => Setting::getSetting('kk_news_title', 'Jadwal layanan Posyandu bulan ini'),
            'news_summary' => Setting::getSetting('kk_news_summary', 'Layanan pemeriksaan rutin tersedia sesuai jadwal. Silakan cek detail lengkap pada halaman berita.'),
            'news_content' => Setting::getSetting('kk_news_content', 'Posyandu membuka layanan pemeriksaan keluarga secara berkala. Pastikan data anggota keluarga sudah lengkap agar proses layanan lebih cepat.'),
            'news_published_at' => Setting::getSetting('kk_news_published_at', now()->format('Y-m-d')),
            
            // Health tips configs
            'edu_balita_title' => Setting::getSetting('edu_balita_title', 'Imunisasi Dasar Lengkap'),
            'edu_balita_desc' => Setting::getSetting('edu_balita_desc', 'Pastikan balita mendapatkan imunisasi BCG, DPT, Polio, Campak, dan Hepatitis B untuk kekebalan tubuh.'),
            'edu_bumil_title' => Setting::getSetting('edu_bumil_title', 'Asupan Asam Folat & Fe'),
            'edu_bumil_desc' => Setting::getSetting('edu_bumil_desc', 'Konsumsi makanan bergizi tinggi zat besi, serta tablet Fe secara teratur guna mencegah anemia saat kehamilan.'),
            'edu_lansia_title' => Setting::getSetting('edu_lansia_title', 'Aktivitas Fisik Ringan'),
            'edu_lansia_desc' => Setting::getSetting('edu_lansia_desc', 'Sempatkan olahraga ringan seperti jalan kaki 15-30 menit setiap hari untuk menjaga kelenturan sendi dan otot.'),
            'edu_umum_title' => Setting::getSetting('edu_umum_title', 'Pola Hidup Bersih & Sehat'),
            'edu_umum_desc' => Setting::getSetting('edu_umum_desc', 'Biasakan mencuci tangan dengan sabun, mengonsumsi air matang, dan membersihkan lingkungan rumah secara teratur.'),
        ];

        $stats = [
            'total_keluarga' => Keluarga::count(),
            'total_balita' => Balita::count(),
            'total_ibu_hamil' => IbuHamil::count(),
            'total_remaja' => Remaja::count(),
            'total_lansia' => Lansia::count(),
        ];

        // Dynamic upcoming schedules for posyandu from Settings
        $schedules = [
            [
                'title' => Setting::getSetting('sched_balita_title', 'Posyandu Balita & Imunisasi'),
                'description' => Setting::getSetting('sched_balita_desc', 'Pemeriksaan tumbuh kembang anak, penimbangan berat badan, imunisasi dasar lengkap, pemberian vitamin A, dan konsultasi gizi balita.'),
                'day' => Setting::getSetting('sched_balita_day', 'Senin Pertama & Kedua'),
                'time' => Setting::getSetting('sched_balita_time', '08:00 - 12:00 WIB'),
                'icon' => 'fa-baby',
                'bg_color' => 'bg-blue-50 text-blue-600 border-blue-100',
                'badge' => 'Balita',
            ],
            [
                'title' => Setting::getSetting('sched_bumil_title', 'Posyandu Ibu Hamil & Menyusui'),
                'description' => Setting::getSetting('sched_bumil_desc', 'Pemeriksaan kehamilan rutin, pengukuran tekanan darah, pemberian tablet tambah darah (Fe), imunisasi TT, dan kelas ibu menyusui.'),
                'day' => Setting::getSetting('sched_bumil_day', 'Setiap Rabu Kedua'),
                'time' => Setting::getSetting('sched_bumil_time', '09:00 - 12:00 WIB'),
                'icon' => 'fa-person-pregnant',
                'bg_color' => 'bg-fuchsia-50 text-fuchsia-600 border-fuchsia-100',
                'badge' => 'Ibu Hamil',
            ],
            [
                'title' => Setting::getSetting('sched_lansia_title', 'Posyandu Lansia & Remaja'),
                'description' => Setting::getSetting('sched_lansia_desc', 'Pemeriksaan tensi darah, kadar gula darah, kolesterol, asam urat, aktivitas senam lansia, serta konseling kesehatan remaja.'),
                'day' => Setting::getSetting('sched_lansia_day', 'Setiap Jumat Ketiga'),
                'time' => Setting::getSetting('sched_lansia_time', '08:00 - 11:30 WIB'),
                'icon' => 'fa-person-cane',
                'bg_color' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                'badge' => 'Lansia & Remaja',
            ],
        ];

        return view('public_dashboard', compact('settings', 'stats', 'schedules'));
    }
}
