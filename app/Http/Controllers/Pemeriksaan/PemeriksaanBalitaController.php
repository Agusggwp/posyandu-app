<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanBalita;
use App\Models\Balita;
use Illuminate\Http\Request;

class PemeriksaanBalitaController extends Controller
{
    public function index()
    {
        $pemeriksaans = PemeriksaanBalita::with('balita')->orderByDesc('tanggal_kunjungan')->paginate(10);
        return view('pemeriksaan.balita.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $balitas = Balita::orderBy('nama_bayi')->get();
        $pemeriksaanBelumSelesai = PemeriksaanBalita::where('tahap_terakhir', '<', 4)->get();
        return view('pemeriksaan.balita.create', compact('balitas', 'pemeriksaanBelumSelesai'));
    }

    public function stage(Request $request, int $stage)
    {
        // Validasi stage
        if (!in_array($stage, [1, 2, 3, 4])) {
            abort(404);
        }

        $balitas = Balita::orderBy('nama_bayi')->get();
        $pemeriksaan = null;
        $data = [];

        // Jika ada pemeriksaan_id, load dari database
        if ($request->has('pemeriksaan_id')) {
            $pemeriksaan = PemeriksaanBalita::find($request->pemeriksaan_id);
            if ($pemeriksaan) {
                $data = $pemeriksaan->toArray();
            }
        }

        return view("pemeriksaan.balita.stages.stage{$stage}", compact('stage', 'balitas', 'pemeriksaan', 'data'));
    }

    public function stageStore(Request $request, int $stage)
    {
        // Validasi stage
        if (!in_array($stage, [1, 2, 3, 4])) {
            abort(404);
        }

        $validated = $request->validate($this->stageRules($stage));

        $pemeriksaanId = $request->input('pemeriksaan_id');

        if (empty($pemeriksaanId)) {
            // Jika tidak ada pemeriksaan_id, buat baru dengan tahap_terakhir = $stage
            $pemeriksaan = PemeriksaanBalita::create([
                'balita_identitas_id' => $validated['balita_identitas_id'],
                'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
                'tahap_terakhir' => $stage,
                ...$validated,
            ]);
        } else {
            // Update pemeriksaan yang ada
            $pemeriksaan = PemeriksaanBalita::find($pemeriksaanId);
            $pemeriksaan->update([
                'tahap_terakhir' => $stage,
                ...$validated,
            ]);
        }

        return redirect()->route('pemeriksaan-balita.create')->with('success', "Tahap {$stage} berhasil disimpan. Lanjutkan ke tahap berikutnya.");
    }

    private function stageRules(int $stage): array
    {
        $baseRules = [
            'balita_identitas_id' => 'required|exists:balita_identitas,id',
            'tanggal_kunjungan' => 'required|date',
        ];

        return match ($stage) {
            1 => array_merge($baseRules, [
                'berat_badan' => 'required|numeric|min:0|max:50',
                'naik_tidak_naik' => 'nullable|string',
                'panjang_badan' => 'required|numeric|min:0|max:150',
                'lingkar_kepala' => 'nullable|numeric|min:0|max:100',
            ]),
            2 => array_merge($baseRules, [
                'status_bb_u' => 'nullable|string',
                'status_pb_u' => 'nullable|string',
                'status_bb_pb' => 'nullable|string',
                'lingkar_lengan' => 'nullable|numeric|min:0|max:50',
                'status_lila' => 'nullable|string',
            ]),
            3 => array_merge($baseRules, [
                'batuk' => 'nullable|boolean',
                'demam' => 'nullable|boolean',
                'bb_turun' => 'nullable|boolean',
                'kontak_tbc' => 'nullable|boolean',
                'perkembangan' => 'nullable|string',
            ]),
            4 => array_merge($baseRules, [
                'asi_eksklusif' => 'nullable|string',
                'mpasi' => 'nullable|string',
                'imunisasi' => 'nullable|string',
                'vitamin_a' => 'nullable|string',
                'obat_cacing' => 'nullable|string',
                'mt_pangan' => 'nullable|string',
                'edukasi' => 'nullable|string',
                'catatan_kesehatan' => 'nullable|string',
                'rujukan' => 'nullable|string',
            ]),
            default => $baseRules,
        };
    }

    public function show(PemeriksaanBalita $pemeriksaanBalita)
    {
        $pemeriksaanBalita->load('balita');
        return view('pemeriksaan.balita.show', compact('pemeriksaanBalita'));
    }

    public function edit(PemeriksaanBalita $pemeriksaanBalita)
    {
        $balitas = Balita::orderBy('nama_bayi')->get();
        return view('pemeriksaan.balita.edit', compact('pemeriksaanBalita', 'balitas'));
    }

    public function update(Request $request, PemeriksaanBalita $pemeriksaanBalita)
    {
        $validated = $request->validate([
            'balita_identitas_id' => 'required|exists:balita_identitas,id',
            'tanggal_kunjungan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0',
            'naik_tidak_naik' => 'nullable|string',
            'panjang_badan' => 'required|numeric|min:0',
            'status_bb_u' => 'nullable|string',
            'status_pb_u' => 'nullable|string',
            'status_bb_pb' => 'nullable|string',
            'lingkar_lengan' => 'nullable|numeric|min:0',
            'status_lila' => 'nullable|string',
            'lingkar_kepala' => 'nullable|numeric|min:0',
            'batuk' => 'nullable|boolean',
            'demam' => 'nullable|boolean',
            'bb_turun' => 'nullable|boolean',
            'kontak_tbc' => 'nullable|boolean',
            'perkembangan' => 'nullable|string',
            'asi_eksklusif' => 'nullable|string',
            'mpasi' => 'nullable|string',
            'imunisasi' => 'nullable|string',
            'vitamin_a' => 'nullable|string',
            'obat_cacing' => 'nullable|string',
            'mt_pangan' => 'nullable|string',
            'edukasi' => 'nullable|string',
            'catatan_kesehatan' => 'nullable|string',
            'rujukan' => 'nullable|string',
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
