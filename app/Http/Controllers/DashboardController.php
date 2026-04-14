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
            'total_pemeriksaan_balita' => PemeriksaanBalita::whereMonth('created_at', date('m'))->count(),
            'total_pemeriksaan_ibu_hamil' => PemeriksaanIbuHamil::whereMonth('created_at', date('m'))->count(),
            'total_pemeriksaan_lansia' => PemeriksaanLansia::whereMonth('created_at', date('m'))->count(),
            'balita_stunting' => PemeriksaanBalita::whereIn('status_pb_u', ['SP', 'P'])->distinct('balita_identitas_id')->count(),
        ];
        
        return view('dashboard', compact('data'));
    }
}
