<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;

use App\Models\PemeriksaanRemaja;
use App\Models\Remaja;
use Illuminate\Http\Request;

class PemeriksaanRemajaController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanRemaja::with('remaja')->latest()->paginate(10);
        return view('pemeriksaan.remaja.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $remajas = Remaja::latest()->get();
        return view('pemeriksaan.remaja.create', compact('remajas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'remaja_identitas_id' => 'required|exists:remaja_identitas,id',
            'waktu_kunjungan' => 'nullable|string|max:50',
            'berat_badan' => 'nullable|numeric|min:0',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'imt_status' => 'nullable|string|max:20',
            'lingkar_perut' => 'nullable|numeric|min:0',
            'sistole' => 'nullable|integer|min:0',
            'diastole' => 'nullable|integer|min:0',
            'tekanan_darah_status' => 'nullable|string|max:20',
            'gula_darah' => 'nullable|string|max:20',
            'hemoglobin' => 'nullable|string|max:20',
            'anemia' => 'nullable|string|max:5',
            'batuk' => 'nullable|string|max:5',
            'demam' => 'nullable|string|max:5',
            'bb_turun' => 'nullable|string|max:5',
            'kontak_tbc' => 'nullable|string|max:5',
            'masalah_rumah' => 'nullable|string|max:5',
            'masalah_pendidikan' => 'nullable|string|max:5',
            'masalah_makan' => 'nullable|string|max:5',
            'masalah_aktivitas' => 'nullable|string|max:5',
            'masalah_obat' => 'nullable|string|max:5',
            'masalah_seksual' => 'nullable|string|max:5',
            'masalah_emosi' => 'nullable|string|max:5',
            'masalah_keamanan' => 'nullable|string|max:5',
            'edukasi' => 'nullable|string',
            'rujukan' => 'nullable|string|max:100',
        ]);

        PemeriksaanRemaja::create($validated);

        return redirect()->route('pemeriksaan-remaja.index')->with('success', 'Pemeriksaan remaja berhasil ditambahkan');
    }

    public function show(PemeriksaanRemaja $pemeriksaan_remaja)
    {
        $pemeriksaan_remaja->load('remaja');
        return view('pemeriksaan.remaja.show', ['pemeriksaanRemaja' => $pemeriksaan_remaja]);
    }

    public function edit(PemeriksaanRemaja $pemeriksaan_remaja)
    {
        $remajas = Remaja::latest()->get();
        return view('pemeriksaan.remaja.edit', ['pemeriksaanRemaja' => $pemeriksaan_remaja, 'remajas' => $remajas]);
    }

    public function update(Request $request, PemeriksaanRemaja $pemeriksaan_remaja)
    {
        $validated = $request->validate([
            'remaja_identitas_id' => 'required|exists:remaja_identitas,id',
            'waktu_kunjungan' => 'nullable|string|max:50',
            'berat_badan' => 'nullable|numeric|min:0',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'imt_status' => 'nullable|string|max:20',
            'lingkar_perut' => 'nullable|numeric|min:0',
            'sistole' => 'nullable|integer|min:0',
            'diastole' => 'nullable|integer|min:0',
            'tekanan_darah_status' => 'nullable|string|max:20',
            'gula_darah' => 'nullable|string|max:20',
            'hemoglobin' => 'nullable|string|max:20',
            'anemia' => 'nullable|string|max:5',
            'batuk' => 'nullable|string|max:5',
            'demam' => 'nullable|string|max:5',
            'bb_turun' => 'nullable|string|max:5',
            'kontak_tbc' => 'nullable|string|max:5',
            'masalah_rumah' => 'nullable|string|max:5',
            'masalah_pendidikan' => 'nullable|string|max:5',
            'masalah_makan' => 'nullable|string|max:5',
            'masalah_aktivitas' => 'nullable|string|max:5',
            'masalah_obat' => 'nullable|string|max:5',
            'masalah_seksual' => 'nullable|string|max:5',
            'masalah_emosi' => 'nullable|string|max:5',
            'masalah_keamanan' => 'nullable|string|max:5',
            'edukasi' => 'nullable|string',
            'rujukan' => 'nullable|string|max:100',
        ]);

        $pemeriksaan_remaja->update($validated);

        return redirect()->route('pemeriksaan-remaja.index')->with('success', 'Pemeriksaan remaja berhasil diperbarui');
    }

    public function destroy(PemeriksaanRemaja $pemeriksaan_remaja)
    {
        $pemeriksaan_remaja->delete();
        return redirect()->route('pemeriksaan-remaja.index')->with('success', 'Pemeriksaan remaja berhasil dihapus');
    }
}
