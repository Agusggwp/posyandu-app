<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;

use App\Models\Nifas;
use App\Models\PemeriksaanNifas;
use Illuminate\Http\Request;

class PemeriksaanNifasController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanNifas::with('nifas')->latest()->paginate(10);
        return view('pemeriksaan.nifas.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $nifases = Nifas::latest()->get();
        return view('pemeriksaan.nifas.create', compact('nifases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nifas_identitas_id' => 'required|exists:nifas_identitas,id',
            'waktu_kunjungan' => 'nullable|string|max:50',
            'berat_badan' => 'nullable|numeric|min:0',
            'naik_turun' => 'nullable|string|max:10',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'lila' => 'nullable|numeric|min:0',
            'status_gizi' => 'nullable|string|max:10',
            'sistole' => 'nullable|integer|min:0',
            'diastole' => 'nullable|integer|min:0',
            'tekanan_darah_status' => 'nullable|string|max:20',
            'batuk' => 'nullable|string|max:5',
            'demam' => 'nullable|string|max:5',
            'bb_turun' => 'nullable|string|max:5',
            'kontak_tbc' => 'nullable|string|max:5',
            'vitamin_a' => 'nullable|string|max:5',
            'menyusui' => 'nullable|string|max:5',
            'kb' => 'nullable|string|max:50',
            'edukasi' => 'nullable|string',
            'rujukan' => 'nullable|string|max:100',
        ]);

        PemeriksaanNifas::create($validated);

        return redirect()->route('pemeriksaan-nifas.index')->with('success', 'Pemeriksaan nifas berhasil ditambahkan');
    }

    public function show(PemeriksaanNifas $pemeriksaan_nifas)
    {
        $pemeriksaan_nifas->load('nifas');
        return view('pemeriksaan.nifas.show', ['pemeriksaanNifas' => $pemeriksaan_nifas]);
    }

    public function edit(PemeriksaanNifas $pemeriksaan_nifas)
    {
        $nifases = Nifas::latest()->get();
        return view('pemeriksaan.nifas.edit', ['pemeriksaanNifas' => $pemeriksaan_nifas, 'nifases' => $nifases]);
    }

    public function update(Request $request, PemeriksaanNifas $pemeriksaan_nifas)
    {
        $validated = $request->validate([
            'nifas_identitas_id' => 'required|exists:nifas_identitas,id',
            'waktu_kunjungan' => 'nullable|string|max:50',
            'berat_badan' => 'nullable|numeric|min:0',
            'naik_turun' => 'nullable|string|max:10',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'lila' => 'nullable|numeric|min:0',
            'status_gizi' => 'nullable|string|max:10',
            'sistole' => 'nullable|integer|min:0',
            'diastole' => 'nullable|integer|min:0',
            'tekanan_darah_status' => 'nullable|string|max:20',
            'batuk' => 'nullable|string|max:5',
            'demam' => 'nullable|string|max:5',
            'bb_turun' => 'nullable|string|max:5',
            'kontak_tbc' => 'nullable|string|max:5',
            'vitamin_a' => 'nullable|string|max:5',
            'menyusui' => 'nullable|string|max:5',
            'kb' => 'nullable|string|max:50',
            'edukasi' => 'nullable|string',
            'rujukan' => 'nullable|string|max:100',
        ]);

        $pemeriksaan_nifas->update($validated);

        return redirect()->route('pemeriksaan-nifas.index')->with('success', 'Pemeriksaan nifas berhasil diperbarui');
    }

    public function destroy(PemeriksaanNifas $pemeriksaan_nifas)
    {
        $pemeriksaan_nifas->delete();
        return redirect()->route('pemeriksaan-nifas.index')->with('success', 'Pemeriksaan nifas berhasil dihapus');
    }
}
