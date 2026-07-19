<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;

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
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('reports.laporan.index');
    }

    public function balita(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        
        $pemeriksaans = PemeriksaanBalita::with('balita')
            ->whereMonth('tanggal_kunjungan', $bulan)
            ->whereYear('tanggal_kunjungan', $tahun)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();
            
        $statistik = [
            'total' => $pemeriksaans->count(),
            'normal' => $pemeriksaans->where('status_gizi', 'normal')->count(),
            'kurang' => $pemeriksaans->where('status_gizi', 'kurang')->count(),
            'stunting' => $pemeriksaans->where('status_gizi', 'stunting')->count(),
        ];
        
        return view('reports.laporan.balita', compact('pemeriksaans', 'statistik', 'bulan', 'tahun'));
    }

    public function ibuHamil(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        
        $pemeriksaans = PemeriksaanIbuHamil::with('ibuHamil')
            ->whereMonth('tanggal_kunjungan', $bulan)
            ->whereYear('tanggal_kunjungan', $tahun)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();
            
        $statistik = [
            'total' => $pemeriksaans->count(),
            'bb_naik' => $pemeriksaans->where('status_bb', 'Naik')->count(),
            'td_normal' => $pemeriksaans->where('status_tekanan_darah', 'Normal')->count(),
            'td_tinggi' => $pemeriksaans->where('status_tekanan_darah', 'Tinggi')->count(),
        ];
        
        return view('reports.laporan.ibu-hamil', compact('pemeriksaans', 'statistik', 'bulan', 'tahun'));
    }

    public function lansia(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        
        $pemeriksaans = PemeriksaanLansia::with('lansia')
            ->whereMonth('tanggal_kunjungan', $bulan)
            ->whereYear('tanggal_kunjungan', $tahun)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();
            
        $statistik = [
            'total' => $pemeriksaans->count(),
            'gula_normal' => $pemeriksaans->where('gula_darah', '<', 200)->count(), // Example standard logic or we can just count totals. Let's just pass basic stats if no strict status is there.
        ];
        
        return view('reports.laporan.lansia', compact('pemeriksaans', 'statistik', 'bulan', 'tahun'));
    }

    public function nifas(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        
        $pemeriksaans = PemeriksaanNifas::with('nifas')
            ->whereMonth('tanggal_kunjungan', $bulan)
            ->whereYear('tanggal_kunjungan', $tahun)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();
            
        $statistik = [
            'total' => $pemeriksaans->count(),
            'gizi_baik' => $pemeriksaans->where('status_gizi', 'Hijau')->count(),
            'gizi_kurang' => $pemeriksaans->whereIn('status_gizi', ['Kuning', 'Merah'])->count(),
            'td_normal' => $pemeriksaans->where('tekanan_darah_status', 'Normal')->count(),
        ];
        
        return view('reports.laporan.nifas', compact('pemeriksaans', 'statistik', 'bulan', 'tahun'));
    }

    public function remaja(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        
        $pemeriksaans = PemeriksaanRemaja::with('remaja')
            ->whereMonth('tanggal_kunjungan', $bulan)
            ->whereYear('tanggal_kunjungan', $tahun)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();
            
        $statistik = [
            'total' => $pemeriksaans->count(),
            'imt_normal' => $pemeriksaans->where('imt_status', 'Normal')->count(),
            'imt_kurus' => $pemeriksaans->where('imt_status', 'Kurus')->count(),
            'imt_gemuk' => $pemeriksaans->whereIn('imt_status', ['Gemuk', 'Obesitas'])->count(),
        ];
        
        return view('reports.laporan.remaja', compact('pemeriksaans', 'statistik', 'bulan', 'tahun'));
    }

    public function exportExcel($type)
    {
        // Placeholder untuk export Excel
        return back()->with('info', 'Fitur export Excel dalam pengembangan');
    }

    public function exportPdf($type)
    {
        // Placeholder untuk export PDF
        return back()->with('info', 'Fitur export PDF dalam pengembangan');
    }
}
