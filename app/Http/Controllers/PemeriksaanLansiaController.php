<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanLansia;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeriksaanLansiaController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanLansia::with('lansia', 'petugas')->latest()->paginate(10);
        return view('pemeriksaan-lansia.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $lansias = Lansia::all();
        return view('pemeriksaan-lansia.create', compact('lansias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lansia_id' => 'required|exists:lansias,id',
            'tanggal_pemeriksaan' => 'required|date',
            'tekanan_darah' => 'nullable|string',
            'berat_badan' => 'nullable|numeric|min:0',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'gula_darah' => 'nullable|integer|min:0',
            'kolesterol' => 'nullable|integer|min:0',
            'keluhan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        
        PemeriksaanLansia::create($validated);
        return redirect()->route('pemeriksaan-lansia.index')->with('success', 'Data pemeriksaan berhasil ditambahkan');
    }

    public function show(PemeriksaanLansia $pemeriksaanLansia)
    {
        $pemeriksaanLansia->load('lansia', 'petugas');
        return view('pemeriksaan-lansia.show', compact('pemeriksaanLansia'));
    }

    public function edit(PemeriksaanLansia $pemeriksaanLansia)
    {
        $lansias = Lansia::all();
        return view('pemeriksaan-lansia.edit', compact('pemeriksaanLansia', 'lansias'));
    }

    public function update(Request $request, PemeriksaanLansia $pemeriksaanLansia)
    {
        $validated = $request->validate([
            'lansia_id' => 'required|exists:lansias,id',
            'tanggal_pemeriksaan' => 'required|date',
            'tekanan_darah' => 'nullable|string',
            'berat_badan' => 'nullable|numeric|min:0',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'gula_darah' => 'nullable|integer|min:0',
            'kolesterol' => 'nullable|integer|min:0',
            'keluhan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $pemeriksaanLansia->update($validated);
        return redirect()->route('pemeriksaan-lansia.index')->with('success', 'Data pemeriksaan berhasil diperbarui');
    }

    public function destroy(PemeriksaanLansia $pemeriksaanLansia)
    {
        $pemeriksaanLansia->delete();
        return redirect()->route('pemeriksaan-lansia.index')->with('success', 'Data pemeriksaan berhasil dihapus');
    }
}
