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
        $pemeriksaanBelumSelesai = PemeriksaanLansia::where('tahap_terakhir', '<', 4)
            ->orWhereNull('tahap_terakhir')
            ->with('lansia')
            ->latest('waktu_kunjungan')
            ->get();
        return view('pemeriksaan.lansia.create', compact('lansias', 'pemeriksaanBelumSelesai'));
    }

    public function stage($stage, Request $request)
    {
        $pemeriksaan_id = $request->query('pemeriksaan_id');
        $lansias = Lansia::orderBy('nama')->get();
        
        if ($pemeriksaan_id) {
            $pemeriksaan = PemeriksaanLansia::findOrFail($pemeriksaan_id);
        } else {
            $pemeriksaan = null;
        }

        return view("pemeriksaan.lansia.stage-{$stage}", compact('stage', 'lansias', 'pemeriksaan'));
    }

    public function store(Request $request)
    {
        $stage = $request->input('stage', 1);
        $pemeriksaan_id = $request->input('pemeriksaan_id');
        
        // Validation based on stage
        $validationRules = [
            'dewasa_identitas_id' => 'required_if:stage,1|exists:dewasa_identitas,id',
            'waktu_kunjungan' => 'required_if:stage,1|date',
        ];

        if ($stage == 1) {
            $validationRules = array_merge($validationRules, [
                'berat_badan' => 'nullable|numeric|min:0',
                'tinggi_badan' => 'nullable|numeric|min:0',
                'lingkar_perut' => 'nullable|numeric|min:0',
                'imt' => 'nullable|numeric|min:0',
            ]);
        } elseif ($stage == 2) {
            $validationRules = array_merge($validationRules, [
                'sistole' => 'nullable|numeric|min:0',
                'diastole' => 'nullable|numeric|min:0',
                'tekanan_darah_status' => 'nullable|string|max:255',
                'gula_darah' => 'nullable|numeric|min:0',
            ]);
        } elseif ($stage == 3) {
            $validationRules = array_merge($validationRules, [
                'mata_kanan' => 'nullable|string|max:255',
                'mata_kiri' => 'nullable|string|max:255',
                'telinga_kanan' => 'nullable|string|max:255',
                'telinga_kiri' => 'nullable|string|max:255',
            ]);
        } elseif ($stage == 4) {
            $validationRules = array_merge($validationRules, [
                'batuk_tbc' => 'nullable|boolean',
                'demam' => 'nullable|boolean',
                'bb_turun' => 'nullable|boolean',
                'kontak_tbc' => 'nullable|boolean',
                'napas_berat' => 'nullable|boolean',
                'dahak' => 'nullable|boolean',
                'batuk' => 'nullable|boolean',
                'aktivitas_terganggu' => 'nullable|boolean',
                'skor_puma' => 'nullable|integer|min:0',
                'skor_merokok' => 'nullable|integer|min:0',
                'pemeriksaan_sebelumnya' => 'nullable|string|max:255',
                'edukasi' => 'nullable|string|max:255',
                'rujukan' => 'nullable|string|max:255',
            ]);
        }

        $validated = $request->validate($validationRules);

        if ($pemeriksaan_id) {
            $pemeriksaan = PemeriksaanLansia::findOrFail($pemeriksaan_id);
            $pemeriksaan->update($validated);
            $pemeriksaan->tahap_terakhir = $stage;
            $pemeriksaan->save();
        } else {
            $validated['tahap_terakhir'] = $stage;
            $pemeriksaan = PemeriksaanLansia::create($validated);
        }

        if ($stage < 4) {
            $nextStage = $stage + 1;
            return redirect()->route('pemeriksaan-lansia.stage', ['stage' => $nextStage, 'pemeriksaan_id' => $pemeriksaan->id])
                ->with('success', "Tahap {$stage} berhasil disimpan. Lanjutkan ke tahap {$nextStage}.");
        }

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
