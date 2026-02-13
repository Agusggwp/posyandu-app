<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Lansia;
use App\Models\Keluarga;
use App\Models\PemeriksaanBalita;
use App\Models\PemeriksaanIbuHamil;
use App\Models\PemeriksaanLansia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_keluarga' => Keluarga::count(),
            'total_balita' => Balita::count(),
            'total_ibu_hamil' => IbuHamil::count(),
            'total_lansia' => Lansia::count(),
            'total_pemeriksaan_balita' => PemeriksaanBalita::whereMonth('tanggal_pemeriksaan', date('m'))->count(),
            'total_pemeriksaan_ibu_hamil' => PemeriksaanIbuHamil::whereMonth('tanggal_pemeriksaan', date('m'))->count(),
            'total_pemeriksaan_lansia' => PemeriksaanLansia::whereMonth('tanggal_pemeriksaan', date('m'))->count(),
            'balita_stunting' => PemeriksaanBalita::where('status_gizi', 'stunting')->distinct('balita_id')->count(),
        ];
        
        return view('dashboard', compact('data'));
    }
}
