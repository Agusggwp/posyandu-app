<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanBalita;
use App\Models\Balita;
use Illuminate\Http\Request;

class PemeriksaanBalitaController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanBalita::with('balita')->orderByDesc('waktu_kunjungan')->paginate(10);
        return view('pemeriksaan-balita.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $balitas = Balita::orderBy('nama_bayi')->get();
        return view('pemeriksaan-balita.create', compact('balitas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'balita_identitas_id' => 'required|exists:balita_identitas,id',
            'umur' => 'nullable|integer|min:0',
            'waktu_kunjungan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0',
            'naik_tidak_naik' => 'nullable|string|max:255',
            'status_bb_u' => 'nullable|string|max:255',
            'panjang_badan' => 'required|numeric|min:0',
            'status_pb_u' => 'nullable|string|max:255',
            'status_bb_pb' => 'nullable|string|max:255',
            'lingkar_lengan' => 'nullable|numeric|min:0',
            'status_lila' => 'nullable|string|max:255',
            'lingkar_kepala' => 'nullable|numeric|min:0',
            'batuk' => 'nullable|boolean',
            'demam' => 'nullable|boolean',
            'bb_turun' => 'nullable|boolean',
            'kontak_tbc' => 'nullable|boolean',
            'perkembangan' => 'nullable|string|max:255',
            'asi_eksklusif' => 'nullable|string|max:255',
            'mpasi' => 'nullable|string|max:255',
            'imunisasi' => 'nullable|string',
            'vitamin_a' => 'nullable|string|max:255',
            'obat_cacing' => 'nullable|string|max:255',
            'mt_pangan' => 'nullable|string|max:255',
            'edukasi' => 'nullable|string|max:255',
            'catatan_kesehatan' => 'nullable|string',
            'rujukan' => 'nullable|string|max:255',
        ]);
        
        PemeriksaanBalita::create($validated);
        return redirect()->route('pemeriksaan-balita.index')->with('success', 'Data pemeriksaan berhasil ditambahkan');
    }

    public function show(PemeriksaanBalita $pemeriksaanBalita)
    {
        $pemeriksaanBalita->load('balita');
        $pemeriksaan = $pemeriksaanBalita;
        return view('pemeriksaan-balita.show', compact('pemeriksaan'));
    }

    public function edit(PemeriksaanBalita $pemeriksaanBalita)
    {
        $balitas = Balita::orderBy('nama_bayi')->get();
        $pemeriksaan = $pemeriksaanBalita;
        return view('pemeriksaan-balita.edit', compact('pemeriksaan', 'balitas'));
    }

    public function update(Request $request, PemeriksaanBalita $pemeriksaanBalita)
    {
        $validated = $request->validate([
            'balita_identitas_id' => 'required|exists:balita_identitas,id',
            'umur' => 'nullable|integer|min:0',
            'waktu_kunjungan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0',
            'naik_tidak_naik' => 'nullable|string|max:255',
            'status_bb_u' => 'nullable|string|max:255',
            'panjang_badan' => 'required|numeric|min:0',
            'status_pb_u' => 'nullable|string|max:255',
            'status_bb_pb' => 'nullable|string|max:255',
            'lingkar_lengan' => 'nullable|numeric|min:0',
            'status_lila' => 'nullable|string|max:255',
            'lingkar_kepala' => 'nullable|numeric|min:0',
            'batuk' => 'nullable|boolean',
            'demam' => 'nullable|boolean',
            'bb_turun' => 'nullable|boolean',
            'kontak_tbc' => 'nullable|boolean',
            'perkembangan' => 'nullable|string|max:255',
            'asi_eksklusif' => 'nullable|string|max:255',
            'mpasi' => 'nullable|string|max:255',
            'imunisasi' => 'nullable|string',
            'vitamin_a' => 'nullable|string|max:255',
            'obat_cacing' => 'nullable|string|max:255',
            'mt_pangan' => 'nullable|string|max:255',
            'edukasi' => 'nullable|string|max:255',
            'catatan_kesehatan' => 'nullable|string',
            'rujukan' => 'nullable|string|max:255',
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
