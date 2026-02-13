<?php

namespace App\Http\Controllers;

use App\Models\IbuHamil;
use App\Models\Keluarga;
use Illuminate\Http\Request;

class IbuHamilController extends Controller
{
    public function index()
    {
        $ibuHamils = IbuHamil::with('keluarga')->paginate(10);
        return view('ibu-hamil.index', compact('ibuHamils'));
    }

    public function create()
    {
        $keluargas = Keluarga::all();
        return view('ibu-hamil.create', compact('keluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keluarga_id' => 'required|exists:keluargas,id',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:ibu_hamils,nik|max:16',
            'tanggal_lahir' => 'required|date',
            'nama_suami' => 'required|string|max:255',
            'hpht' => 'nullable|date',
            'hpl' => 'nullable|date',
            'hamil_ke' => 'required|integer|min:1',
        ]);

        IbuHamil::create($validated);
        return redirect()->route('ibu-hamil.index')->with('success', 'Data ibu hamil berhasil ditambahkan');
    }

    public function show(IbuHamil $ibuHamil)
    {
        $ibuHamil->load('keluarga', 'pemeriksaans');
        return view('ibu-hamil.show', compact('ibuHamil'));
    }

    public function edit(IbuHamil $ibuHamil)
    {
        $keluargas = Keluarga::all();
        return view('ibu-hamil.edit', compact('ibuHamil', 'keluargas'));
    }

    public function update(Request $request, IbuHamil $ibuHamil)
    {
        $validated = $request->validate([
            'keluarga_id' => 'required|exists:keluargas,id',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:ibu_hamils,nik,' . $ibuHamil->id,
            'tanggal_lahir' => 'required|date',
            'nama_suami' => 'required|string|max:255',
            'hpht' => 'nullable|date',
            'hpl' => 'nullable|date',
            'hamil_ke' => 'required|integer|min:1',
        ]);

        $ibuHamil->update($validated);
        return redirect()->route('ibu-hamil.index')->with('success', 'Data ibu hamil berhasil diperbarui');
    }

    public function destroy(IbuHamil $ibuHamil)
    {
        $ibuHamil->delete();
        return redirect()->route('ibu-hamil.index')->with('success', 'Data ibu hamil berhasil dihapus');
    }
}
