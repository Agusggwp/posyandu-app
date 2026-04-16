<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;

use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Lansia;
use App\Models\PemeriksaanBalita;
use App\Models\PemeriksaanIbuHamil;
use App\Models\PemeriksaanLansia;
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
        
        $pemeriksaans = PemeriksaanBalita::with('balita', 'petugas')
            ->whereMonth('tanggal_pemeriksaan', $bulan)
            ->whereYear('tanggal_pemeriksaan', $tahun)
            ->orderBy('tanggal_pemeriksaan', 'desc')
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
        
        $pemeriksaans = PemeriksaanIbuHamil::with('ibuHamil', 'petugas')
            ->whereMonth('tanggal_pemeriksaan', $bulan)
            ->whereYear('tanggal_pemeriksaan', $tahun)
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();
        
        return view('reports.laporan.ibu-hamil', compact('pemeriksaans', 'bulan', 'tahun'));
    }

    public function lansia(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        
        $pemeriksaans = PemeriksaanLansia::with('lansia', 'petugas')
            ->whereMonth('tanggal_pemeriksaan', $bulan)
            ->whereYear('tanggal_pemeriksaan', $tahun)
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();
        
        return view('reports.laporan.lansia', compact('pemeriksaans', 'bulan', 'tahun'));
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
