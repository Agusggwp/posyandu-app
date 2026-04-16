<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;

use App\Models\PemeriksaanIbuHamil;
use App\Models\IbuHamil;
use Illuminate\Http\Request;

class PemeriksaanIbuHamilController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanIbuHamil::with('ibuHamil')->orderByDesc('tanggal_kunjungan')->paginate(10);
        return view('pemeriksaan.ibu-hamil.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $ibuHamils = IbuHamil::orderBy('nama_ibu')->get();
        return view('pemeriksaan.ibu-hamil.create', compact('ibuHamils'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ibu_hamil_identitas_id' => 'required|exists:ibu_hamil_identitas,id',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'berat_badan' => 'nullable|numeric|min:0',
            'lingkar_lengan' => 'nullable|numeric|min:0',
            'tekanan_darah' => 'nullable|string|max:255',
            'denyut_jantung' => 'nullable|string|max:255',
            'kondisi_ibu' => 'nullable|string|max:255',
            'keluhan' => 'nullable|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'waktu_ke_posyandu' => 'nullable|date_format:H:i',
            'petugas' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);
        
        PemeriksaanIbuHamil::create($validated);
        return redirect()->route('pemeriksaan-ibu-hamil.index')->with('success', 'Data pemeriksaan berhasil ditambahkan');
    }

    public function show(PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $pemeriksaanIbuHamil->load('ibuHamil');
        $pemeriksaan = $pemeriksaanIbuHamil;
        return view('pemeriksaan.ibu-hamil.show', compact('pemeriksaan'));
    }

    public function edit(PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $ibuHamils = IbuHamil::orderBy('nama_ibu')->get();
        $pemeriksaan = $pemeriksaanIbuHamil;
        return view('pemeriksaan.ibu-hamil.edit', compact('pemeriksaan', 'ibuHamils'));
    }

    public function update(Request $request, PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $validated = $request->validate([
            'ibu_hamil_identitas_id' => 'required|exists:ibu_hamil_identitas,id',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'berat_badan' => 'nullable|numeric|min:0',
            'lingkar_lengan' => 'nullable|numeric|min:0',
            'tekanan_darah' => 'nullable|string|max:255',
            'denyut_jantung' => 'nullable|string|max:255',
            'kondisi_ibu' => 'nullable|string|max:255',
            'keluhan' => 'nullable|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'waktu_ke_posyandu' => 'nullable|date_format:H:i',
            'petugas' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $pemeriksaanIbuHamil->update($validated);
        return redirect()->route('pemeriksaan-ibu-hamil.index')->with('success', 'Data pemeriksaan berhasil diperbarui');
    }

    public function destroy(PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $pemeriksaanIbuHamil->delete();
        return redirect()->route('pemeriksaan-ibu-hamil.index')->with('success', 'Data pemeriksaan berhasil dihapus');
    }
}
