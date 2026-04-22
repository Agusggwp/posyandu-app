<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Lansia;
use App\Models\Nifas;
use App\Models\Remaja;
use App\Models\Keluarga;
use App\Models\PemeriksaanBalita;
use App\Models\PemeriksaanIbuHamil;
use App\Models\PemeriksaanLansia;
use App\Models\PemeriksaanNifas;
use App\Models\PemeriksaanRemaja;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $dashboardSettings = [
            'checks_title' => Setting::getSetting('main_dashboard_checks_title', 'Pemeriksaan Bulan Ini'),
            'nutrition_title' => Setting::getSetting('main_dashboard_nutrition_title', 'Status Gizi'),
            'quick_actions_title' => Setting::getSetting('main_dashboard_quick_actions_title', 'Quick Actions'),
            'system_info_title' => Setting::getSetting('main_dashboard_system_info_title', 'Informasi Sistem'),
            'stat_note' => Setting::getSetting('main_dashboard_stat_note', 'Data aktif'),
            'show_stats_cards' => Setting::getSetting('main_dashboard_show_stats_cards', 'active'),
            'show_card_keluarga' => Setting::getSetting('main_dashboard_show_card_keluarga', 'active'),
            'show_card_balita' => Setting::getSetting('main_dashboard_show_card_balita', 'active'),
            'show_card_ibu_hamil' => Setting::getSetting('main_dashboard_show_card_ibu_hamil', 'active'),
            'show_card_nifas' => Setting::getSetting('main_dashboard_show_card_nifas', 'active'),
            'show_card_remaja' => Setting::getSetting('main_dashboard_show_card_remaja', 'active'),
            'show_card_lansia' => Setting::getSetting('main_dashboard_show_card_lansia', 'active'),
            'show_checks_summary' => Setting::getSetting('main_dashboard_show_checks_summary', 'active'),
            'show_checks_balita' => Setting::getSetting('main_dashboard_show_checks_balita', 'active'),
            'show_checks_ibu_hamil' => Setting::getSetting('main_dashboard_show_checks_ibu_hamil', 'active'),
            'show_checks_nifas' => Setting::getSetting('main_dashboard_show_checks_nifas', 'active'),
            'show_checks_remaja' => Setting::getSetting('main_dashboard_show_checks_remaja', 'active'),
            'show_checks_lansia' => Setting::getSetting('main_dashboard_show_checks_lansia', 'active'),
            'show_nutrition' => Setting::getSetting('main_dashboard_show_nutrition', 'active'),
            'show_quick_actions' => Setting::getSetting('main_dashboard_show_quick_actions', 'active'),
            'show_action_balita' => Setting::getSetting('main_dashboard_show_action_balita', 'active'),
            'show_action_ibu_hamil' => Setting::getSetting('main_dashboard_show_action_ibu_hamil', 'active'),
            'show_action_nifas' => Setting::getSetting('main_dashboard_show_action_nifas', 'active'),
            'show_action_remaja' => Setting::getSetting('main_dashboard_show_action_remaja', 'active'),
            'show_action_lansia' => Setting::getSetting('main_dashboard_show_action_lansia', 'active'),
            'show_system_info' => Setting::getSetting('main_dashboard_show_system_info', 'active'),
        ];

        $data = [
            'total_keluarga' => Keluarga::count(),
            'total_balita' => Balita::count(),
            'total_ibu_hamil' => IbuHamil::count(),
            'total_nifas' => Nifas::count(),
            'total_remaja' => Remaja::count(),
            'total_lansia' => Lansia::count(),
            'total_pemeriksaan_balita' => PemeriksaanBalita::whereMonth('created_at', date('m'))->count(),
            'total_pemeriksaan_ibu_hamil' => PemeriksaanIbuHamil::whereMonth('created_at', date('m'))->count(),
            'total_pemeriksaan_nifas' => PemeriksaanNifas::whereMonth('created_at', date('m'))->count(),
            'total_pemeriksaan_remaja' => PemeriksaanRemaja::whereMonth('created_at', date('m'))->count(),
            'total_pemeriksaan_lansia' => PemeriksaanLansia::whereMonth('created_at', date('m'))->count(),
            'balita_stunting' => PemeriksaanBalita::whereIn('status_pb_u', ['SP', 'P'])->distinct('balita_identitas_id')->count(),
        ];
        
        return view('dashboard', compact('data', 'dashboardSettings'));
    }
}
