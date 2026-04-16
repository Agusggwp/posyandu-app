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

        return view('admin.dashboard', compact('stats', 'recentUsers', 'usersByRole', 'recentActivities', 'dailyStats'));
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
            'center_address' => Setting::getSetting('center_address', ''),
            'center_email' => Setting::getSetting('center_email', ''),
            'center_hours_open' => Setting::getSetting('center_hours_open', '08:00'),
            'center_hours_close' => Setting::getSetting('center_hours_close', '16:00'),
        ];

        return view('admin.settings', compact('settings'));
    }

    /**
     * Update system settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'center_address' => 'nullable|string|max:500',
            'center_email' => 'nullable|email|max:255',
            'center_hours_open' => 'nullable|date_format:H:i',
            'center_hours_close' => 'nullable|date_format:H:i',
        ]);

        foreach ($validated as $key => $value) {
            Setting::setSetting($key, $value);
        }

        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
