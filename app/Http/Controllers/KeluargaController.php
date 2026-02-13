<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use Illuminate\Http\Request;

class KeluargaController extends Controller
{
    public function index()
    {
        $keluargas = Keluarga::paginate(10);
        return view('keluarga.index', compact('keluargas'));
    }

    public function create()
    {
        return view('keluarga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|unique:keluargas,no_kk|max:16',
            'nama_kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:15',
        ]);

        Keluarga::create($validated);
        return redirect()->route('keluarga.index')->with('success', 'Data keluarga berhasil ditambahkan');
    }

    public function show(Keluarga $keluarga)
    {
        $keluarga->load('balitas', 'ibuHamils', 'lansias');
        return view('keluarga.show', compact('keluarga'));
    }

    public function edit(Keluarga $keluarga)
    {
        return view('keluarga.edit', compact('keluarga'));
    }

    public function update(Request $request, Keluarga $keluarga)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|max:16|unique:keluargas,no_kk,' . $keluarga->id,
            'nama_kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:15',
        ]);

        $keluarga->update($validated);
        return redirect()->route('keluarga.index')->with('success', 'Data keluarga berhasil diperbarui');
    }

    public function destroy(Keluarga $keluarga)
    {
        $keluarga->delete();
        return redirect()->route('keluarga.index')->with('success', 'Data keluarga berhasil dihapus');
    }
}
