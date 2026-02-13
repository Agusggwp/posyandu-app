<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanBalita;
use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeriksaanBalitaController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanBalita::with('balita', 'petugas')->latest()->paginate(10);
        return view('pemeriksaan-balita.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $balitas = Balita::all();
        return view('pemeriksaan-balita.create', compact('balitas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'balita_id' => 'required|exists:balitas,id',
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'lingkar_kepala' => 'nullable|numeric|min:0',
            'imunisasi' => 'nullable|string',
            'vitamin' => 'nullable|string',
            'status_gizi' => 'required|in:normal,kurang,stunting',
            'catatan' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        
        PemeriksaanBalita::create($validated);
        return redirect()->route('pemeriksaan-balita.index')->with('success', 'Data pemeriksaan berhasil ditambahkan');
    }

    public function show(PemeriksaanBalita $pemeriksaanBalita)
    {
        $pemeriksaanBalita->load('balita', 'petugas');
        return view('pemeriksaan-balita.show', compact('pemeriksaanBalita'));
    }

    public function edit(PemeriksaanBalita $pemeriksaanBalita)
    {
        $balitas = Balita::all();
        return view('pemeriksaan-balita.edit', compact('pemeriksaanBalita', 'balitas'));
    }

    public function update(Request $request, PemeriksaanBalita $pemeriksaanBalita)
    {
        $validated = $request->validate([
            'balita_id' => 'required|exists:balitas,id',
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'lingkar_kepala' => 'nullable|numeric|min:0',
            'imunisasi' => 'nullable|string',
            'vitamin' => 'nullable|string',
            'status_gizi' => 'required|in:normal,kurang,stunting',
            'catatan' => 'nullable|string',
        ]);

        $pemeriksaanBalita->update($validated);
        return redirect()->route('pemeriksaan-balita.index')->with('success', 'Data pemeriksaan berhasil diperbarui');
    }

    public function destroy(PemeriksaanBalita $pemeriksaanBalita)
    {
        $pemeriksaanBalita->delete();
        return redirect()->route('pemeriksaan-balita.index')->with('success', 'Data pemeriksaan berhasil dihapus');
    }
}
