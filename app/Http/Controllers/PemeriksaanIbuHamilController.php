<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanIbuHamil;
use App\Models\IbuHamil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeriksaanIbuHamilController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanIbuHamil::with('ibuHamil', 'petugas')->latest()->paginate(10);
        return view('pemeriksaan-ibu-hamil.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $ibuHamils = IbuHamil::all();
        return view('pemeriksaan-ibu-hamil.create', compact('ibuHamils'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ibu_hamil_id' => 'required|exists:ibu_hamils,id',
            'tanggal_pemeriksaan' => 'required|date',
            'usia_kehamilan' => 'nullable|integer|min:0',
            'tekanan_darah' => 'nullable|string',
            'berat_badan' => 'nullable|numeric|min:0',
            'lingkar_lengan_atas' => 'nullable|string',
            'tinggi_fundus' => 'nullable|string',
            'denyut_jantung_janin' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        
        PemeriksaanIbuHamil::create($validated);
        return redirect()->route('pemeriksaan-ibu-hamil.index')->with('success', 'Data pemeriksaan berhasil ditambahkan');
    }

    public function show(PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $pemeriksaanIbuHamil->load('ibuHamil', 'petugas');
        return view('pemeriksaan-ibu-hamil.show', compact('pemeriksaanIbuHamil'));
    }

    public function edit(PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $ibuHamils = IbuHamil::all();
        return view('pemeriksaan-ibu-hamil.edit', compact('pemeriksaanIbuHamil', 'ibuHamils'));
    }

    public function update(Request $request, PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $validated = $request->validate([
            'ibu_hamil_id' => 'required|exists:ibu_hamils,id',
            'tanggal_pemeriksaan' => 'required|date',
            'usia_kehamilan' => 'nullable|integer|min:0',
            'tekanan_darah' => 'nullable|string',
            'berat_badan' => 'nullable|numeric|min:0',
            'lingkar_lengan_atas' => 'nullable|string',
            'tinggi_fundus' => 'nullable|string',
            'denyut_jantung_janin' => 'nullable|string',
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
