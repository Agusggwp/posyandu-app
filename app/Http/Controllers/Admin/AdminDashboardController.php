<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Keluarga;
use App\Models\Lansia;
use App\Models\PemeriksaanBalita;
use App\Models\PemeriksaanIbuHamil;
use App\Models\PemeriksaanLansia;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show admin dashboard.
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

        $recentUsers = User::with('role')->latest()->take(5)->get();

        $usersByRole = User::select('role_id', DB::raw('count(*) as total'))
            ->groupBy('role_id')
            ->with('role')
            ->get();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

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
}
