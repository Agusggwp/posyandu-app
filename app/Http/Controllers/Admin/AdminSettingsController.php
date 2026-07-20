<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show system settings.
     */
    public function index()
    {
        $settings = [
            'system_app_name' => Setting::getSetting('system_app_name', 'Sistem Informasi Posyandu'),
            'system_app_tagline' => Setting::getSetting('system_app_tagline', 'Layanan kesehatan keluarga yang lebih cepat, rapi, dan terukur.'),
            'main_dashboard_checks_title' => Setting::getSetting('main_dashboard_checks_title', 'Pemeriksaan Bulan Ini'),
            'main_dashboard_nutrition_title' => Setting::getSetting('main_dashboard_nutrition_title', 'Status Gizi'),
            'main_dashboard_quick_actions_title' => Setting::getSetting('main_dashboard_quick_actions_title', 'Quick Actions'),
            'main_dashboard_system_info_title' => Setting::getSetting('main_dashboard_system_info_title', 'Informasi Sistem'),
            'main_dashboard_stat_note' => Setting::getSetting('main_dashboard_stat_note', 'Data aktif'),
            'main_dashboard_show_stats_cards' => Setting::getSetting('main_dashboard_show_stats_cards', 'active'),
            'main_dashboard_show_card_keluarga' => Setting::getSetting('main_dashboard_show_card_keluarga', 'active'),
            'main_dashboard_show_card_balita' => Setting::getSetting('main_dashboard_show_card_balita', 'active'),
            'main_dashboard_show_card_ibu_hamil' => Setting::getSetting('main_dashboard_show_card_ibu_hamil', 'active'),
            'main_dashboard_show_card_nifas' => Setting::getSetting('main_dashboard_show_card_nifas', 'active'),
            'main_dashboard_show_card_remaja' => Setting::getSetting('main_dashboard_show_card_remaja', 'active'),
            'main_dashboard_show_card_lansia' => Setting::getSetting('main_dashboard_show_card_lansia', 'active'),
            'main_dashboard_show_checks_summary' => Setting::getSetting('main_dashboard_show_checks_summary', 'active'),
            'main_dashboard_show_checks_balita' => Setting::getSetting('main_dashboard_show_checks_balita', 'active'),
            'main_dashboard_show_checks_ibu_hamil' => Setting::getSetting('main_dashboard_show_checks_ibu_hamil', 'active'),
            'main_dashboard_show_checks_nifas' => Setting::getSetting('main_dashboard_show_checks_nifas', 'active'),
            'main_dashboard_show_checks_remaja' => Setting::getSetting('main_dashboard_show_checks_remaja', 'active'),
            'main_dashboard_show_checks_lansia' => Setting::getSetting('main_dashboard_show_checks_lansia', 'active'),
            'main_dashboard_show_nutrition' => Setting::getSetting('main_dashboard_show_nutrition', 'active'),
            'main_dashboard_show_quick_actions' => Setting::getSetting('main_dashboard_show_quick_actions', 'active'),
            'main_dashboard_show_action_balita' => Setting::getSetting('main_dashboard_show_action_balita', 'active'),
            'main_dashboard_show_action_ibu_hamil' => Setting::getSetting('main_dashboard_show_action_ibu_hamil', 'active'),
            'main_dashboard_show_action_nifas' => Setting::getSetting('main_dashboard_show_action_nifas', 'active'),
            'main_dashboard_show_action_remaja' => Setting::getSetting('main_dashboard_show_action_remaja', 'active'),
            'main_dashboard_show_action_lansia' => Setting::getSetting('main_dashboard_show_action_lansia', 'active'),
            'main_dashboard_show_system_info' => Setting::getSetting('main_dashboard_show_system_info', 'active'),
            'admin_dashboard_title' => Setting::getSetting('admin_dashboard_title', 'Admin Dashboard'),
            'admin_dashboard_subtitle' => Setting::getSetting('admin_dashboard_subtitle', 'Panel Kontrol Administrasi Sistem'),
            'admin_show_stats_cards' => Setting::getSetting('admin_show_stats_cards', 'active'),
            'admin_show_recent_users' => Setting::getSetting('admin_show_recent_users', 'active'),
            'admin_show_recent_activities' => Setting::getSetting('admin_show_recent_activities', 'active'),
            'admin_show_activity_chart' => Setting::getSetting('admin_show_activity_chart', 'active'),
            'admin_show_role_distribution' => Setting::getSetting('admin_show_role_distribution', 'active'),
            'admin_show_quick_actions' => Setting::getSetting('admin_show_quick_actions', 'active'),
            'kk_registration_status' => Setting::getSetting('kk_registration_status', 'active'),
            'kk_auto_approve' => Setting::getSetting('kk_auto_approve', 'inactive'),
            'center_address' => Setting::getSetting('center_address', ''),
            'center_email' => Setting::getSetting('center_email', ''),
            'center_posyandu_date' => Setting::getSetting('center_posyandu_date', 'Setiap Tanggal 15, Jam 08:00 - 16:00 WIB'),
            'admin_login_title' => Setting::getSetting('admin_login_title', 'Admin Dashboard'),
            'admin_login_subtitle' => Setting::getSetting('admin_login_subtitle', 'Kelola sistem informasi kesehatan keluarga'),
            'admin_login_description' => Setting::getSetting('admin_login_description', 'Silakan masuk ke akun admin Anda untuk mengelola sistem Posyandu'),
            'kk_login_badge' => Setting::getSetting('kk_login_badge', 'Portal Keluarga Posyandu'),
            'kk_login_hero_title' => Setting::getSetting('kk_login_hero_title', 'Pantau kesehatan keluarga lebih mudah.'),
            'kk_login_hero_subtitle' => Setting::getSetting('kk_login_hero_subtitle', 'Satu tempat untuk akses data kunjungan, informasi layanan, dan catatan penting kesehatan keluarga Anda.'),
            'kk_login_feature_1_title' => Setting::getSetting('kk_login_feature_1_title', 'Akses cepat data keluarga'),
            'kk_login_feature_1_desc' => Setting::getSetting('kk_login_feature_1_desc', 'Lihat riwayat pemeriksaan dan status layanan secara real-time.'),
            'kk_login_feature_2_title' => Setting::getSetting('kk_login_feature_2_title', 'Data aman dan privat'),
            'kk_login_feature_2_desc' => Setting::getSetting('kk_login_feature_2_desc', 'Informasi hanya bisa diakses melalui akun terverifikasi.'),
            'kk_login_footer_text' => Setting::getSetting('kk_login_footer_text', 'Posyandu Digital • Layanan Kesehatan Keluarga'),
            'kk_login_form_title' => Setting::getSetting('kk_login_form_title', 'Login Kepala Keluarga'),
            'kk_login_form_subtitle' => Setting::getSetting('kk_login_form_subtitle', 'Masuk untuk melanjutkan ke panel keluarga.'),
            'kk_news_status' => Setting::getSetting('kk_news_status', 'active'),
            'kk_news_title' => Setting::getSetting('kk_news_title', 'Jadwal layanan Posyandu bulan ini'),
            'kk_news_summary' => Setting::getSetting('kk_news_summary', 'Layanan pemeriksaan rutin tersedia sesuai jadwal. Silakan cek detail lengkap pada halaman berita.'),
            'kk_news_content' => Setting::getSetting('kk_news_content', 'Posyandu membuka layanan pemeriksaan keluarga secara berkala. Pastikan data anggota keluarga sudah lengkap agar proses layanan lebih cepat.'),
            'kk_news_link_label' => Setting::getSetting('kk_news_link_label', 'Baca informasi lengkap'),
            'kk_news_link_url' => Setting::getSetting('kk_news_link_url', ''),
            'kk_news_published_at' => Setting::getSetting('kk_news_published_at', now()->format('Y-m-d')),
            
            // Landing Page schedules config
            'sched_balita_title' => Setting::getSetting('sched_balita_title', 'Posyandu Balita & Imunisasi'),
            'sched_balita_desc' => Setting::getSetting('sched_balita_desc', 'Pemeriksaan tumbuh kembang anak, penimbangan berat badan, imunisasi dasar lengkap, pemberian vitamin A, dan konsultasi gizi balita.'),
            'sched_balita_day' => Setting::getSetting('sched_balita_day', 'Senin Pertama & Kedua'),
            'sched_balita_time' => Setting::getSetting('sched_balita_time', '08:00 - 12:00 WIB'),
            
            'sched_bumil_title' => Setting::getSetting('sched_bumil_title', 'Posyandu Ibu Hamil & Menyusui'),
            'sched_bumil_desc' => Setting::getSetting('sched_bumil_desc', 'Pemeriksaan kehamilan rutin, pengukuran tekanan darah, pemberian tablet tambah darah (Fe), imunisasi TT, dan kelas ibu menyusui.'),
            'sched_bumil_day' => Setting::getSetting('sched_bumil_day', 'Setiap Rabu Kedua'),
            'sched_bumil_time' => Setting::getSetting('sched_bumil_time', '09:00 - 12:00 WIB'),
            
            'sched_lansia_title' => Setting::getSetting('sched_lansia_title', 'Posyandu Lansia & Remaja'),
            'sched_lansia_desc' => Setting::getSetting('sched_lansia_desc', 'Pemeriksaan tensi darah, kadar gula darah, kolesterol, asam urat, aktivitas senam lansia, serta konseling kesehatan remaja.'),
            'sched_lansia_day' => Setting::getSetting('sched_lansia_day', 'Setiap Jumat Ketiga'),
            'sched_lansia_time' => Setting::getSetting('sched_lansia_time', '08:00 - 11:30 WIB'),
            
            // Landing Page health tips config
            'edu_balita_title' => Setting::getSetting('edu_balita_title', 'Imunisasi Dasar Lengkap'),
            'edu_balita_desc' => Setting::getSetting('edu_balita_desc', 'Pastikan balita mendapatkan imunisasi BCG, DPT, Polio, Campak, dan Hepatitis B untuk kekebalan tubuh.'),
            
            'edu_bumil_title' => Setting::getSetting('edu_bumil_title', 'Asupan Asam Folat & Fe'),
            'edu_bumil_desc' => Setting::getSetting('edu_bumil_desc', 'Konsumsi makanan bergizi tinggi zat besi, serta tablet Fe secara teratur guna mencegah anemia saat kehamilan.'),
            
            'edu_lansia_title' => Setting::getSetting('edu_lansia_title', 'Aktivitas Fisik Ringan'),
            'edu_lansia_desc' => Setting::getSetting('edu_lansia_desc', 'Sempatkan olahraga ringan seperti jalan kaki 15-30 menit setiap hari untuk menjaga kelenturan sendi dan otot.'),
            
            'edu_umum_title' => Setting::getSetting('edu_umum_title', 'Pola Hidup Bersih & Sehat'),
            'edu_umum_desc' => Setting::getSetting('edu_umum_desc', 'Biasakan mencuci tangan dengan sabun, mengonsumsi air matang, dan membersihkan lingkungan rumah secara teratur.'),
        ];

        return view('admin.settings', compact('settings'));
    }

    /**
     * Update system settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'system_app_name' => 'sometimes|nullable|string|max:120',
            'system_app_tagline' => 'sometimes|nullable|string|max:255',
            'main_dashboard_checks_title' => 'sometimes|nullable|string|max:120',
            'main_dashboard_nutrition_title' => 'sometimes|nullable|string|max:120',
            'main_dashboard_quick_actions_title' => 'sometimes|nullable|string|max:120',
            'main_dashboard_system_info_title' => 'sometimes|nullable|string|max:120',
            'main_dashboard_stat_note' => 'sometimes|nullable|string|max:80',
            'main_dashboard_show_stats_cards' => 'sometimes|in:active,inactive',
            'main_dashboard_show_card_keluarga' => 'sometimes|in:active,inactive',
            'main_dashboard_show_card_balita' => 'sometimes|in:active,inactive',
            'main_dashboard_show_card_ibu_hamil' => 'sometimes|in:active,inactive',
            'main_dashboard_show_card_nifas' => 'sometimes|in:active,inactive',
            'main_dashboard_show_card_remaja' => 'sometimes|in:active,inactive',
            'main_dashboard_show_card_lansia' => 'sometimes|in:active,inactive',
            'main_dashboard_show_checks_summary' => 'sometimes|in:active,inactive',
            'main_dashboard_show_checks_balita' => 'sometimes|in:active,inactive',
            'main_dashboard_show_checks_ibu_hamil' => 'sometimes|in:active,inactive',
            'main_dashboard_show_checks_nifas' => 'sometimes|in:active,inactive',
            'main_dashboard_show_checks_remaja' => 'sometimes|in:active,inactive',
            'main_dashboard_show_checks_lansia' => 'sometimes|in:active,inactive',
            'main_dashboard_show_nutrition' => 'sometimes|in:active,inactive',
            'main_dashboard_show_quick_actions' => 'sometimes|in:active,inactive',
            'main_dashboard_show_action_balita' => 'sometimes|in:active,inactive',
            'main_dashboard_show_action_ibu_hamil' => 'sometimes|in:active,inactive',
            'main_dashboard_show_action_nifas' => 'sometimes|in:active,inactive',
            'main_dashboard_show_action_remaja' => 'sometimes|in:active,inactive',
            'main_dashboard_show_action_lansia' => 'sometimes|in:active,inactive',
            'main_dashboard_show_system_info' => 'sometimes|in:active,inactive',
            'admin_dashboard_title' => 'sometimes|nullable|string|max:120',
            'admin_dashboard_subtitle' => 'sometimes|nullable|string|max:255',
            'admin_show_stats_cards' => 'sometimes|in:active,inactive',
            'admin_show_recent_users' => 'sometimes|in:active,inactive',
            'admin_show_recent_activities' => 'sometimes|in:active,inactive',
            'admin_show_activity_chart' => 'sometimes|in:active,inactive',
            'admin_show_role_distribution' => 'sometimes|in:active,inactive',
            'admin_show_quick_actions' => 'sometimes|in:active,inactive',
            'kk_registration_status' => 'sometimes|in:active,inactive',
            'kk_auto_approve' => 'sometimes|in:active,inactive',
            'center_address' => 'sometimes|nullable|string|max:500',
            'center_email' => 'sometimes|nullable|email|max:255',
            'center_posyandu_date' => 'sometimes|nullable|string|max:255',
            'admin_login_title' => 'sometimes|nullable|string|max:120',
            'admin_login_subtitle' => 'sometimes|nullable|string|max:255',
            'admin_login_description' => 'sometimes|nullable|string|max:500',
            'kk_login_badge' => 'sometimes|nullable|string|max:120',
            'kk_login_hero_title' => 'sometimes|nullable|string|max:200',
            'kk_login_hero_subtitle' => 'sometimes|nullable|string|max:500',
            'kk_login_feature_1_title' => 'sometimes|nullable|string|max:120',
            'kk_login_feature_1_desc' => 'sometimes|nullable|string|max:255',
            'kk_login_feature_2_title' => 'sometimes|nullable|string|max:120',
            'kk_login_feature_2_desc' => 'sometimes|nullable|string|max:255',
            'kk_login_footer_text' => 'sometimes|nullable|string|max:200',
            'kk_login_form_title' => 'sometimes|nullable|string|max:120',
            'kk_login_form_subtitle' => 'sometimes|nullable|string|max:255',
            'kk_news_status' => 'sometimes|in:active,inactive',
            'kk_news_title' => 'sometimes|nullable|string|max:200',
            'kk_news_summary' => 'sometimes|nullable|string|max:500',
            'kk_news_content' => 'sometimes|nullable|string|max:5000',
            'kk_news_link_label' => 'sometimes|nullable|string|max:120',
            'kk_news_link_url' => 'sometimes|nullable|url|max:255',
            'kk_news_published_at' => 'sometimes|nullable|date',
            
            // Landing Page schedules validation
            'sched_balita_title' => 'sometimes|nullable|string|max:150',
            'sched_balita_desc' => 'sometimes|nullable|string|max:500',
            'sched_balita_day' => 'sometimes|nullable|string|max:100',
            'sched_balita_time' => 'sometimes|nullable|string|max:100',
            
            'sched_bumil_title' => 'sometimes|nullable|string|max:150',
            'sched_bumil_desc' => 'sometimes|nullable|string|max:500',
            'sched_bumil_day' => 'sometimes|nullable|string|max:100',
            'sched_bumil_time' => 'sometimes|nullable|string|max:100',
            
            'sched_lansia_title' => 'sometimes|nullable|string|max:150',
            'sched_lansia_desc' => 'sometimes|nullable|string|max:500',
            'sched_lansia_day' => 'sometimes|nullable|string|max:100',
            'sched_lansia_time' => 'sometimes|nullable|string|max:100',
            
            // Landing Page health tips validation
            'edu_balita_title' => 'sometimes|nullable|string|max:120',
            'edu_balita_desc' => 'sometimes|nullable|string|max:500',
            'edu_bumil_title' => 'sometimes|nullable|string|max:120',
            'edu_bumil_desc' => 'sometimes|nullable|string|max:500',
            'edu_lansia_title' => 'sometimes|nullable|string|max:120',
            'edu_lansia_desc' => 'sometimes|nullable|string|max:500',
            'edu_umum_title' => 'sometimes|nullable|string|max:120',
            'edu_umum_desc' => 'sometimes|nullable|string|max:500',
        ]);

        foreach ($validated as $key => $value) {
            Setting::setSetting($key, $value);
        }

        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
