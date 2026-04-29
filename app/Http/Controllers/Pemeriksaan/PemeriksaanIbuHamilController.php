<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanIbuHamil;
use App\Models\IbuHamil;
use Illuminate\Http\Request;

class PemeriksaanIbuHamilController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanIbuHamil::with('ibuHamil')->orderByDesc('tanggal_kunjungan')->paginate(10);
        return view('pemeriksaan.ibu-hamil.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $ibuHamils = IbuHamil::orderBy('nama_ibu')->get();
        $pemeriksaanBelumSelesai = PemeriksaanIbuHamil::with('ibuHamil')
            ->where('tahap_terakhir', '<', 4)
            ->orderByDesc('updated_at')
            ->get();

        return view('pemeriksaan.ibu-hamil.create', compact('ibuHamils', 'pemeriksaanBelumSelesai'));
    }

    public function stage(Request $request, int $stage = 1)
    {
        if (!in_array($stage, [1, 2, 3, 4], true)) {
            return redirect()->route('pemeriksaan-ibu-hamil.create');
        }

        $ibuHamils = IbuHamil::orderBy('nama_ibu')->get();
        $pemeriksaan = null;

        if ($request->filled('pemeriksaan_id')) {
            $pemeriksaan = PemeriksaanIbuHamil::with('ibuHamil')->findOrFail($request->query('pemeriksaan_id'));
        }

        $data = $pemeriksaan ? $pemeriksaan->toArray() : $request->session()->get('pemeriksaan_ibu_hamil_stage', []);

        return view('pemeriksaan.ibu-hamil.stages.stage' . $stage, compact('stage', 'ibuHamils', 'data', 'pemeriksaan'));
    }

    public function stageStore(Request $request, int $stage = 1)
    {
        if (!in_array($stage, [1, 2, 3, 4], true)) {
            return redirect()->route('pemeriksaan-ibu-hamil.create');
        }

        $validated = $request->validate($this->stageRules($stage));
        $pemeriksaanId = $request->input('pemeriksaan_id');

        if ($stage === 1 && empty($pemeriksaanId)) {
            PemeriksaanIbuHamil::create($validated + ['tahap_terakhir' => 1]);

            return redirect()->route('pemeriksaan-ibu-hamil.create')->with('success', 'Tahap 1 berhasil disimpan.');
        }

        if (empty($pemeriksaanId)) {
            PemeriksaanIbuHamil::create($validated + ['tahap_terakhir' => $stage]);

            return redirect()->route('pemeriksaan-ibu-hamil.create')->with('success', 'Tahap ' . $stage . ' berhasil disimpan.');
        }

        $pemeriksaan = PemeriksaanIbuHamil::findOrFail($pemeriksaanId);
        $pemeriksaan->update(array_merge($pemeriksaan->toArray(), $validated, [
            'tahap_terakhir' => $stage,
        ]));

        if ($stage < 4) {
            return redirect()->route('pemeriksaan-ibu-hamil.create')->with('success', 'Tahap ' . $stage . ' berhasil disimpan.');
        }

        return redirect()->route('pemeriksaan-ibu-hamil.create')->with('success', 'Tahap 4 berhasil disimpan. Pemeriksaan sudah selesai.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ibu_hamil_identitas_id' => 'required|exists:ibu_hamil_identitas,id',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'berat_badan' => 'nullable|numeric|min:0',
            'lingkar_lengan' => 'nullable|numeric|min:0',
            'tekanan_darah' => 'nullable|string|max:255',
            'denyut_jantung' => 'nullable|string|max:255',
            'kondisi_ibu' => 'nullable|string|max:255',
            'keluhan' => 'nullable|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'waktu_ke_posyandu' => 'nullable|date_format:H:i',
            'petugas' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        PemeriksaanIbuHamil::create($validated);
        return redirect()->route('pemeriksaan-ibu-hamil.index')->with('success', 'Data pemeriksaan berhasil ditambahkan');
    }

    public function show(PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $pemeriksaanIbuHamil->load('ibuHamil');
        $pemeriksaan = $pemeriksaanIbuHamil;
        return view('pemeriksaan.ibu-hamil.show', compact('pemeriksaan'));
    }

    public function edit(PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $ibuHamils = IbuHamil::orderBy('nama_ibu')->get();
        $pemeriksaan = $pemeriksaanIbuHamil;
        return view('pemeriksaan.ibu-hamil.edit', compact('pemeriksaan', 'ibuHamils'));
    }

    public function update(Request $request, PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $validated = $request->validate([
            'ibu_hamil_identitas_id' => 'required|exists:ibu_hamil_identitas,id',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'berat_badan' => 'nullable|numeric|min:0',
            'lingkar_lengan' => 'nullable|numeric|min:0',
            'tekanan_darah' => 'nullable|string|max:255',
            'denyut_jantung' => 'nullable|string|max:255',
            'kondisi_ibu' => 'nullable|string|max:255',
            'keluhan' => 'nullable|string|max:255',
            'tanggal_kunjungan' => 'required|date',
            'waktu_ke_posyandu' => 'nullable|date_format:H:i',
            'petugas' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $pemeriksaanIbuHamil->update($validated);
        return redirect()->route('pemeriksaan-ibu-hamil.index')->with('success', 'Data pemeriksaan berhasil diperbarui');
    }

    public function destroy(PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $pemeriksaanIbuHamil->delete();
        return redirect()->route('pemeriksaan-ibu-hamil.index')->with('success', 'Data pemeriksaan berhasil dihapus');
    }

    private function stageRules(int $stage): array
    {
        $baseRules = [
            'ibu_hamil_identitas_id' => 'required|exists:ibu_hamil_identitas,id',
            'tanggal_kunjungan' => 'required|date',
        ];

        return match ($stage) {
            1 => $baseRules + [
                'usia_kehamilan' => 'nullable|integer|min:0|max:60',
                'berat_badan' => 'nullable|numeric|min:0',
                'lingkar_lengan' => 'nullable|numeric|min:0',
                'status_bb' => 'nullable|in:Naik,Tidak',
                'status_lila' => 'nullable|in:Hijau,Kuning,Merah',
            ],
            2 => $baseRules + [
                'tekanan_darah' => 'nullable|string|max:255',
                'status_tekanan_darah' => 'nullable|in:Normal,Tinggi,Rendah',
                'tb_skrining_batuk' => 'nullable|boolean',
                'tb_skrining_demam' => 'nullable|boolean',
                'tb_skrining_bb_turun' => 'nullable|boolean',
                'tb_skrining_kontak' => 'nullable|boolean',
                'tb_skrining_hasil' => 'nullable|in:Ya,Tidak,Dirujuk',
            ],
            3 => $baseRules + [
                'tablet_tambah_darah' => 'nullable|boolean',
                'pmt_bumil' => 'nullable|boolean',
                'kelas_ibu_hamil' => 'nullable|boolean',
            ],
            4 => $baseRules + [
                'edukasi' => 'nullable|string|max:2000',
                'rujukan' => 'nullable|in:Pustu,Puskesmas,Rumah Sakit,Tidak',
                'denyut_jantung' => 'nullable|string|max:255',
                'kondisi_ibu' => 'nullable|string|max:255',
                'keluhan' => 'nullable|string|max:255',
                'waktu_ke_posyandu' => 'nullable|date_format:H:i',
                'petugas' => 'nullable|string|max:255',
                'catatan' => 'nullable|string',
            ],
            default => $baseRules,
        };
    }
}