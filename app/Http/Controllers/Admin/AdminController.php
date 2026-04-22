<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Role;
use App\Models\Keluarga;
use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Lansia;
use App\Models\PemeriksaanBalita;
use App\Models\PemeriksaanIbuHamil;
use App\Models\PemeriksaanLansia;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show admin dashboard
     */
    public function index()
    {
        $dashboardSettings = [
            'title' => Setting::getSetting('admin_dashboard_title', 'Admin Dashboard'),
            'subtitle' => Setting::getSetting('admin_dashboard_subtitle', 'Panel Kontrol Administrasi Sistem'),
            'show_stats_cards' => Setting::getSetting('admin_show_stats_cards', 'active'),
            'show_recent_users' => Setting::getSetting('admin_show_recent_users', 'active'),
            'show_recent_activities' => Setting::getSetting('admin_show_recent_activities', 'active'),
            'show_activity_chart' => Setting::getSetting('admin_show_activity_chart', 'active'),
            'show_role_distribution' => Setting::getSetting('admin_show_role_distribution', 'active'),
            'show_quick_actions' => Setting::getSetting('admin_show_quick_actions', 'active'),
        ];

        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_keluarga' => Keluarga::count(),
            'total_balita' => Balita::count(),
            'total_ibu_hamil' => IbuHamil::count(),
            'total_lansia' => Lansia::count(),
            'total_pemeriksaan_balita' => PemeriksaanBalita::count(),
            'total_pemeriksaan_ibu_hamil' => PemeriksaanIbuHamil::count(),
            'total_pemeriksaan_lansia' => PemeriksaanLansia::count(),
        ];

        // Recent users
        $recentUsers = User::with('role')->latest()->take(5)->get();

        // Users by role
        $usersByRole = User::select('role_id', DB::raw('count(*) as total'))
            ->groupBy('role_id')
            ->with('role')
            ->get();

        // Recent activities
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Stats untuk chart (last 7 days)
        $dailyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyStats[] = [
                'date' => $date->format('M d'),
                'users' => ActivityLog::whereDate('created_at', $date->toDateString())->count(),
            ];
        }

        return view('admin.dashboard', compact('stats', 'recentUsers', 'usersByRole', 'recentActivities', 'dailyStats', 'dashboardSettings'));
    }

    /**
     * Show activity logs
     */
    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->paginate(20)->withQueryString();
        $users = User::query()->select('id', 'name', 'email')->orderBy('name')->get();
        $actions = ActivityLog::query()
            ->select('action')
            ->whereNotNull('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('admin.activity-logs', compact('logs', 'users', 'actions'));
    }

    /**
     * Show system info
     */
    public function systemInfo()
    {
        $info = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database' => config('database.default'),
            'environment' => config('app.env'),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
        ];

        return view('admin.system-info', compact('info'));
    }

    /**
     * Show system settings
     */
    public function settings()
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
            'center_hours_open' => Setting::getSetting('center_hours_open', '08:00'),
            'center_hours_close' => Setting::getSetting('center_hours_close', '16:00'),
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
        ];

        return view('admin.settings', compact('settings'));
    }

    /**
     * Update system settings
     */
    public function updateSettings(Request $request)
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
            'center_hours_open' => 'sometimes|nullable|date_format:H:i',
            'center_hours_close' => 'sometimes|nullable|date_format:H:i',
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
        ]);

        foreach ($validated as $key => $value) {
            Setting::setSetting($key, $value);
        }

        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
