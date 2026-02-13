<?php

namespace App\Http\Controllers;

use App\Models\Lansia;
use App\Models\Keluarga;
use Illuminate\Http\Request;

class LansiaController extends Controller
{
    public function index()
    {
        $lansias = Lansia::with('keluarga')->paginate(10);
        return view('lansia.index', compact('lansias'));
    }

    public function create()
    {
        $keluargas = Keluarga::all();
        return view('lansia.create', compact('keluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keluarga_id' => 'required|exists:keluargas,id',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:lansias,nik|max:16',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'riwayat_penyakit' => 'nullable|string',
        ]);

        Lansia::create($validated);
        return redirect()->route('lansia.index')->with('success', 'Data lansia berhasil ditambahkan');
    }

    public function show(Lansia $lansia)
    {
        $lansia->load('keluarga', 'pemeriksaans');
        return view('lansia.show', compact('lansia'));
    }

    public function edit(Lansia $lansia)
    {
        $keluargas = Keluarga::all();
        return view('lansia.edit', compact('lansia', 'keluargas'));
    }

    public function update(Request $request, Lansia $lansia)
    {
        $validated = $request->validate([
            'keluarga_id' => 'required|exists:keluargas,id',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:lansias,nik,' . $lansia->id,
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'riwayat_penyakit' => 'nullable|string',
        ]);

        $lansia->update($validated);
        return redirect()->route('lansia.index')->with('success', 'Data lansia berhasil diperbarui');
    }

    public function destroy(Lansia $lansia)
    {
        $lansia->delete();
        return redirect()->route('lansia.index')->with('success', 'Data lansia berhasil dihapus');
    }
}
