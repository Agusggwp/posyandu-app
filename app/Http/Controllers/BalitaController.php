<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Keluarga;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $balitas = Balita::with('keluarga')->paginate(10);
        return view('balita.index', compact('balitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $keluargas = Keluarga::all();
        return view('balita.create', compact('keluargas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'keluarga_id' => 'required|exists:keluargas,id',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:balitas,nik|max:16',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'berat_lahir' => 'nullable|numeric',
            'tinggi_lahir' => 'nullable|numeric',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
        ]);

        Balita::create($validated);
        return redirect()->route('balita.index')->with('success', 'Data balita berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Balita $balita)
    {
        $balita->load('keluarga', 'pemeriksaans');
        return view('balita.show', compact('balita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Balita $balita)
    {
        $keluargas = Keluarga::all();
        return view('balita.edit', compact('balita', 'keluargas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Balita $balita)
    {
        $validated = $request->validate([
            'keluarga_id' => 'required|exists:keluargas,id',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:balitas,nik,' . $balita->id,
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'berat_lahir' => 'nullable|numeric',
            'tinggi_lahir' => 'nullable|numeric',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
        ]);

        $balita->update($validated);
        return redirect()->route('balita.index')->with('success', 'Data balita berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Balita $balita)
    {
        $balita->delete();
        return redirect()->route('balita.index')->with('success', 'Data balita berhasil dihapus');
    }
}
