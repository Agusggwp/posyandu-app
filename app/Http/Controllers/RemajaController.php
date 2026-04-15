<?php

namespace App\Http\Controllers;

use App\Models\Keluarga;
use App\Models\Remaja;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RemajaController extends Controller
{
    public function index()
    {
        $remajas = Remaja::with('keluarga')->latest()->paginate(10);
        return view('remaja.index', compact('remajas'));
    }

    public function create()
    {
        $keluargas = Keluarga::latest()->get();
        return view('remaja.create', compact('keluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama_anak' => 'required|string|max:100',
            'nik' => 'nullable|string|max:50|unique:remaja_identitas,nik',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ortu' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'riwayat_keluarga' => 'nullable|string',
            'riwayat_diri' => 'nullable|string',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        Remaja::create($validated);

        return redirect()->route('remaja.index')->with('success', 'Data remaja berhasil ditambahkan');
    }

    public function show(Remaja $remaja)
    {
        $remaja->load('keluarga');
        return view('remaja.show', compact('remaja'));
    }

    public function edit(Remaja $remaja)
    {
        $keluargas = Keluarga::latest()->get();
        return view('remaja.edit', compact('remaja', 'keluargas'));
    }

    public function update(Request $request, Remaja $remaja)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama_anak' => 'required|string|max:100',
            'nik' => ['nullable', 'string', 'max:50', Rule::unique('remaja_identitas', 'nik')->ignore($remaja->id)],
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ortu' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'riwayat_keluarga' => 'nullable|string',
            'riwayat_diri' => 'nullable|string',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        $remaja->update($validated);

        return redirect()->route('remaja.index')->with('success', 'Data remaja berhasil diperbarui');
    }

    public function destroy(Remaja $remaja)
    {
        $remaja->delete();
        return redirect()->route('remaja.index')->with('success', 'Data remaja berhasil dihapus');
    }
}
