<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Nifas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class NifasController extends Controller
{
    public function index()
    {
        $nifases = Nifas::with('keluarga')->latest()->paginate(10);
        return view('nifas.index', compact('nifases'));
    }

    public function create()
    {
        $keluargas = Keluarga::latest()->get();
        return view('nifas.create', compact('keluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama_ibu' => 'required|string|max:100',
            'nik' => 'nullable|string|max:50|unique:nifas_identitas,nik',
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'nullable|integer|min:0',
            'nama_suami' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'dusun' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'tanggal_bersalin' => 'nullable|date',
            'tempat_bersalin' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer|min:1',
            'tinggi_badan_ibu' => 'nullable|numeric',
        ]);

        if (empty($validated['umur']) && !empty($validated['tanggal_lahir'])) {
            $validated['umur'] = Carbon::parse($validated['tanggal_lahir'])->age;
        }

        Nifas::create($validated);

        return redirect()->route('nifas.index')->with('success', 'Data nifas berhasil ditambahkan');
    }

    public function show(Nifas $nifas)
    {
        $nifas->load('keluarga');
        return view('nifas.show', compact('nifas'));
    }

    public function edit(Nifas $nifas)
    {
        $keluargas = Keluarga::latest()->get();
        return view('nifas.edit', compact('nifas', 'keluargas'));
    }

    public function update(Request $request, Nifas $nifas)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama_ibu' => 'required|string|max:100',
            'nik' => ['nullable', 'string', 'max:50', Rule::unique('nifas_identitas', 'nik')->ignore($nifas->id)],
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'nullable|integer|min:0',
            'nama_suami' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'dusun' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'tanggal_bersalin' => 'nullable|date',
            'tempat_bersalin' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer|min:1',
            'tinggi_badan_ibu' => 'nullable|numeric',
        ]);

        if (empty($validated['umur']) && !empty($validated['tanggal_lahir'])) {
            $validated['umur'] = Carbon::parse($validated['tanggal_lahir'])->age;
        }

        $nifas->update($validated);

        return redirect()->route('nifas.index')->with('success', 'Data nifas berhasil diperbarui');
    }

    public function destroy(Nifas $nifas)
    {
        $nifas->delete();
        return redirect()->route('nifas.index')->with('success', 'Data nifas berhasil dihapus');
    }
}
