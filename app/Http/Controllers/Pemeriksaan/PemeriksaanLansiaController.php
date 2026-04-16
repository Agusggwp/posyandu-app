<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;

use App\Models\PemeriksaanLansia;
use App\Models\Lansia;
use Illuminate\Http\Request;

class PemeriksaanLansiaController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanLansia::with('lansia')->orderByDesc('waktu_kunjungan')->paginate(10);
        return view('pemeriksaan.lansia.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $lansias = Lansia::orderBy('nama')->get();
        return view('pemeriksaan.lansia.create', compact('lansias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dewasa_identitas_id' => 'required|exists:dewasa_identitas,id',
            'waktu_kunjungan' => 'required|date',
            'berat_badan' => 'nullable|numeric|min:0',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'imt' => 'nullable|numeric|min:0',
            'lingkar_perut' => 'nullable|numeric|min:0',
            'sistole' => 'nullable|numeric|min:0',
            'diastole' => 'nullable|numeric|min:0',
            'tekanan_darah_status' => 'nullable|string|max:255',
            'gula_darah' => 'nullable|numeric|min:0',
            'jenis_kelamin' => 'nullable|string|max:50',
            'usia_kategori' => 'nullable|string|max:100',
            'skor_merokok' => 'nullable|integer|min:0',
            'skor_puma' => 'nullable|integer|min:0',
            'napas_berat' => 'nullable|boolean',
            'dahak' => 'nullable|boolean',
            'batuk' => 'nullable|boolean',
            'aktivitas_terganggu' => 'nullable|boolean',
            'pemeriksaan_sebelumnya' => 'nullable|string|max:255',
            'batuk_tbc' => 'nullable|boolean',
            'demam' => 'nullable|boolean',
            'bb_turun' => 'nullable|boolean',
            'kontak_tbc' => 'nullable|boolean',
            'edukasi' => 'nullable|string|max:255',
            'rujukan' => 'nullable|string|max:255',
        ]);
        
        PemeriksaanLansia::create($validated);
        return redirect()->route('pemeriksaan-lansia.index')->with('success', 'Data pemeriksaan berhasil ditambahkan');
    }

    public function show(PemeriksaanLansia $pemeriksaanLansia)
    {
        $pemeriksaanLansia->load('lansia');
        $pemeriksaan = $pemeriksaanLansia;
        return view('pemeriksaan.lansia.show', compact('pemeriksaan'));
    }

    public function edit(PemeriksaanLansia $pemeriksaanLansia)
    {
        $lansias = Lansia::orderBy('nama')->get();
        $pemeriksaan = $pemeriksaanLansia;
        return view('pemeriksaan.lansia.edit', compact('pemeriksaan', 'lansias'));
    }

    public function update(Request $request, PemeriksaanLansia $pemeriksaanLansia)
    {
        $validated = $request->validate([
            'dewasa_identitas_id' => 'required|exists:dewasa_identitas,id',
            'waktu_kunjungan' => 'required|date',
            'berat_badan' => 'nullable|numeric|min:0',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'imt' => 'nullable|numeric|min:0',
            'lingkar_perut' => 'nullable|numeric|min:0',
            'sistole' => 'nullable|numeric|min:0',
            'diastole' => 'nullable|numeric|min:0',
            'tekanan_darah_status' => 'nullable|string|max:255',
            'gula_darah' => 'nullable|numeric|min:0',
            'jenis_kelamin' => 'nullable|string|max:50',
            'usia_kategori' => 'nullable|string|max:100',
            'skor_merokok' => 'nullable|integer|min:0',
            'skor_puma' => 'nullable|integer|min:0',
            'napas_berat' => 'nullable|boolean',
            'dahak' => 'nullable|boolean',
            'batuk' => 'nullable|boolean',
            'aktivitas_terganggu' => 'nullable|boolean',
            'pemeriksaan_sebelumnya' => 'nullable|string|max:255',
            'batuk_tbc' => 'nullable|boolean',
            'demam' => 'nullable|boolean',
            'bb_turun' => 'nullable|boolean',
            'kontak_tbc' => 'nullable|boolean',
            'edukasi' => 'nullable|string|max:255',
            'rujukan' => 'nullable|string|max:255',
        ]);

        $pemeriksaanLansia->update($validated);
        return redirect()->route('pemeriksaan-lansia.index')->with('success', 'Data pemeriksaan berhasil diperbarui');
    }

    public function destroy(PemeriksaanLansia $pemeriksaanLansia)
    {
        $pemeriksaanLansia->delete();
        return redirect()->route('pemeriksaan-lansia.index')->with('success', 'Data pemeriksaan berhasil dihapus');
    }
}
