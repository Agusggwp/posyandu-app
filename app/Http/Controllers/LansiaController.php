<?php

namespace App\Http\Controllers;

use App\Models\Lansia;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class LansiaController extends Controller
{
    public function index()
    {
        $lansias = Lansia::with('keluarga')->latest()->paginate(10);
        return view('lansia.index', compact('lansias'));
    }

    public function create()
    {
        $keluargas = Keluarga::latest()->get();
        return view('lansia.create', compact('keluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16|unique:dewasa_identitas,nik',
            'tanggal_lahir' => 'required|date',
            'umur' => 'nullable|integer|min:0',
            'no_hp' => 'nullable|string|max:20',
            'status_perkawinan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'riwayat_keluarga' => 'nullable|string',
            'riwayat_diri' => 'nullable|string',
            'merokok' => 'nullable|string|max:5',
            'konsumsi_gula' => 'nullable|string|max:5',
            'konsumsi_garam' => 'nullable|string|max:5',
            'konsumsi_lemak' => 'nullable|string|max:5',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        if (empty($validated['umur']) && ! empty($validated['tanggal_lahir'])) {
            $validated['umur'] = Carbon::parse($validated['tanggal_lahir'])->age;
        }

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
        $keluargas = Keluarga::latest()->get();
        return view('lansia.edit', compact('lansia', 'keluargas'));
    }

    public function update(Request $request, Lansia $lansia)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama' => 'required|string|max:255',
            'nik' => ['nullable', 'string', 'max:16', Rule::unique('dewasa_identitas', 'nik')->ignore($lansia->id)],
            'tanggal_lahir' => 'required|date',
            'umur' => 'nullable|integer|min:0',
            'no_hp' => 'nullable|string|max:20',
            'status_perkawinan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'riwayat_keluarga' => 'nullable|string',
            'riwayat_diri' => 'nullable|string',
            'merokok' => 'nullable|string|max:5',
            'konsumsi_gula' => 'nullable|string|max:5',
            'konsumsi_garam' => 'nullable|string|max:5',
            'konsumsi_lemak' => 'nullable|string|max:5',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        if (empty($validated['umur']) && ! empty($validated['tanggal_lahir'])) {
            $validated['umur'] = Carbon::parse($validated['tanggal_lahir'])->age;
        }

        $lansia->update($validated);
        return redirect()->route('lansia.index')->with('success', 'Data lansia berhasil diperbarui');
    }

    public function destroy(Lansia $lansia)
    {
        $lansia->delete();
        return redirect()->route('lansia.index')->with('success', 'Data lansia berhasil dihapus');
    }
}
