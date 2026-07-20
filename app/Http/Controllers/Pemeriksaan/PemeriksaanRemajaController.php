<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;

use App\Models\PemeriksaanRemaja;
use App\Models\Remaja;
use Illuminate\Http\Request;

class PemeriksaanRemajaController extends Controller
{
    public function index(Request $request)
    {
        $query = PemeriksaanRemaja::with('remaja');
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('remaja', function ($q) use ($search) {
                $q->where('nama_anak', 'like', '%' . $search . '%');
            });
        }
        
        $pemeriksaans = $query->latest()->paginate(10);
        return view('pemeriksaan.remaja.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $remajas = Remaja::latest()->get();
        $pemeriksaanBelumSelesai = PemeriksaanRemaja::with('remaja')
            ->where('tahap_terakhir', '<', 4)
            ->orderByDesc('updated_at')
            ->get();

        return view('pemeriksaan.remaja.create', compact('remajas', 'pemeriksaanBelumSelesai'));
    }

    public function stage(Request $request, int $stage = 1)
    {
        if (!in_array($stage, [1, 2, 3, 4], true)) {
            abort(404);
        }

        $remajas = Remaja::latest()->get();
        $pemeriksaan = null;
        $data = [];

        if ($request->filled('pemeriksaan_id')) {
            $pemeriksaan = PemeriksaanRemaja::with('remaja')->find($request->query('pemeriksaan_id'));
            if ($pemeriksaan) {
                $data = $pemeriksaan->toArray();
            }
        }

        return view('pemeriksaan.remaja.stages.stage' . $stage, compact('stage', 'remajas', 'pemeriksaan', 'data'));
    }

    public function stageStore(Request $request, int $stage = 1)
    {
        if (!in_array($stage, [1, 2, 3, 4], true)) {
            abort(404);
        }

        $validated = $request->validate($this->stageRules($stage));

        if ($stage === 2) {
            $sistole = isset($validated['sistole']) ? (int) $validated['sistole'] : null;
            $diastole = isset($validated['diastole']) ? (int) $validated['diastole'] : null;

            if (!is_null($sistole) && !is_null($diastole)) {
                $validated['tekanan_darah_status'] = $this->calculateBloodPressureStatus($sistole, $diastole);
            }
        }

        if ($stage === 2 && isset($validated['gula_darah']) && $validated['gula_darah'] !== '') {
            $validated['gula_darah'] = (string) $validated['gula_darah'];
        }
        $pemeriksaanId = $request->input('pemeriksaan_id');

        $existing = PemeriksaanRemaja::where('remaja_identitas_id', $validated['remaja_identitas_id'])
            ->where('tanggal_kunjungan', $validated['tanggal_kunjungan'])
            ->when($pemeriksaanId, fn($q) => $q->where('id', '!=', $pemeriksaanId))
            ->first();

        if ($existing) {
            return back()->withErrors([
                'tanggal_kunjungan' => 'Peringatan: Sudah ada pemeriksaan untuk remaja ini pada tanggal kunjungan yang sama.'
            ])->withInput();
        }

        if (empty($pemeriksaanId)) {
            $pemeriksaan = PemeriksaanRemaja::create([
                'tahap_terakhir' => $stage,
                ...$validated,
            ]);
        } else {
            $pemeriksaan = PemeriksaanRemaja::findOrFail($pemeriksaanId);
            $pemeriksaan->update([
                'tahap_terakhir' => $stage,
                ...$validated,
            ]);
        }

        $message = 'Tahap ' . $stage . ' berhasil disimpan.';

        if ($stage === 4) {
            return redirect()->route('pemeriksaan-remaja.index')->with('success', 'Pemeriksaan remaja berhasil disimpan.');
        }

        return redirect()->route('pemeriksaan-remaja.create')->with('success', $message);
    }

    private function stageRules(int $stage): array
    {
        $baseRules = [
            'remaja_identitas_id' => 'required|exists:remaja_identitas,id',
            'tanggal_kunjungan' => 'required|date',
        ];

        return match ($stage) {
            1 => array_merge($baseRules, [
                'berat_badan' => 'required|numeric|min:0',
                'tinggi_badan' => 'required|numeric|min:0',
                'imt_status' => 'nullable|string|max:20',
                'lingkar_perut' => 'nullable|numeric|min:0',
            ]),
            2 => array_merge($baseRules, [
                'sistole' => 'nullable|integer|min:0',
                'diastole' => 'nullable|integer|min:0',
                'tekanan_darah_status' => 'nullable|string|max:20',
                'gula_darah' => 'nullable|numeric|min:0|max:1000',
                'hemoglobin' => 'nullable|string|max:20',
                'anemia' => 'nullable|string|max:5',
            ]),
            3 => array_merge($baseRules, [
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
            ]),
            4 => array_merge($baseRules, [
                'edukasi' => 'nullable|string',
                'rujukan' => 'nullable|string|max:100',
            ]),
            default => $baseRules,
        };
    }

    private function calculateBloodPressureStatus(int $sistole, int $diastole): string
    {
        if ($sistole >= 140 || $diastole >= 90) {
            return 'Tinggi';
        }

        if ($sistole < 90 || $diastole < 60) {
            return 'Rendah';
        }

        return 'Normal';
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'remaja_identitas_id' => 'required|exists:remaja_identitas,id',
            'tanggal_kunjungan' => 'nullable|string|max:50',
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

        $checkId = $validated['remaja_identitas_id'] ?? null;
        $checkDate = $validated['tanggal_kunjungan'] ?? null;

        if ($checkId && $checkDate) {
            $existing = PemeriksaanRemaja::where('remaja_identitas_id', $checkId)
                ->where('tanggal_kunjungan', $checkDate)
                ->first();

            if ($existing) {
                return back()->withErrors([
                    'tanggal_kunjungan' => 'Peringatan: Sudah ada pemeriksaan untuk remaja ini pada tanggal kunjungan yang sama.'
                ])->withInput();
            }
        }

        if (isset($validated['berat_badan']) && isset($validated['tinggi_badan'])) {
            $berat = (float) $validated['berat_badan'];
            $tinggi = (float) $validated['tinggi_badan'] / 100;
            if ($berat > 0 && $tinggi > 0) {
                $imt = $berat / ($tinggi * $tinggi);
                if ($imt < 18.5) {
                    $validated['imt_status'] = 'Kurus';
                } elseif ($imt >= 18.5 && $imt < 25) {
                    $validated['imt_status'] = 'Normal';
                } elseif ($imt >= 25 && $imt < 30) {
                    $validated['imt_status'] = 'Gemuk';
                } else {
                    $validated['imt_status'] = 'Obesitas';
                }
            }
        }
        if (isset($validated['sistole']) && isset($validated['diastole'])) {
            $sistole = (int) $validated['sistole'];
            $diastole = (int) $validated['diastole'];
            if ($sistole < 90 || $diastole < 60) {
                $validated['tekanan_darah_status'] = 'Rendah';
            } elseif (($sistole >= 90 && $sistole <= 120) || ($diastole >= 60 && $diastole <= 80)) {
                $validated['tekanan_darah_status'] = 'Normal';
            } else {
                $validated['tekanan_darah_status'] = 'Tinggi';
            }
        }

        PemeriksaanRemaja::create($validated);

        return redirect()->route('pemeriksaan-remaja.index')->with('success', 'Pemeriksaan remaja berhasil ditambahkan');
    }

    public function show(PemeriksaanRemaja $pemeriksaan_remaja)
    {
        $pemeriksaan_remaja->load(['remaja.keluarga']);
        $pemeriksaan = $pemeriksaan_remaja;
        return view('pemeriksaan.remaja.show', compact('pemeriksaan'));
    }

    public function print(PemeriksaanRemaja $pemeriksaan_remaja)
    {
        $pemeriksaan_remaja->load(['remaja.keluarga']);
        $history = PemeriksaanRemaja::where('remaja_identitas_id', $pemeriksaan_remaja->remaja_identitas_id)
            ->where('tahap_terakhir', 4)
            ->orderBy('tanggal_kunjungan', 'asc')
            ->get();
        $pemeriksaan = $pemeriksaan_remaja;
        return view('pemeriksaan.remaja.print', compact('pemeriksaan', 'history'));
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
            'tanggal_kunjungan' => 'nullable|string|max:50',
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

        $checkId = $validated['remaja_identitas_id'] ?? null;
        $checkDate = $validated['tanggal_kunjungan'] ?? null;

        if ($checkId && $checkDate) {
            $existing = PemeriksaanRemaja::where('remaja_identitas_id', $checkId)
                ->where('tanggal_kunjungan', $checkDate)
                ->where('id', '!=', $pemeriksaan_remaja->id)
                ->first();

            if ($existing) {
                return back()->withErrors([
                    'tanggal_kunjungan' => 'Peringatan: Sudah ada pemeriksaan untuk remaja ini pada tanggal kunjungan yang sama.'
                ])->withInput();
            }
        }

        if (isset($validated['berat_badan']) && isset($validated['tinggi_badan'])) {
            $berat = (float) $validated['berat_badan'];
            $tinggi = (float) $validated['tinggi_badan'] / 100;
            if ($berat > 0 && $tinggi > 0) {
                $imt = $berat / ($tinggi * $tinggi);
                if ($imt < 18.5) {
                    $validated['imt_status'] = 'Kurus';
                } elseif ($imt >= 18.5 && $imt < 25) {
                    $validated['imt_status'] = 'Normal';
                } elseif ($imt >= 25 && $imt < 30) {
                    $validated['imt_status'] = 'Gemuk';
                } else {
                    $validated['imt_status'] = 'Obesitas';
                }
            }
        }
        if (isset($validated['sistole']) && isset($validated['diastole'])) {
            $sistole = (int) $validated['sistole'];
            $diastole = (int) $validated['diastole'];
            if ($sistole < 90 || $diastole < 60) {
                $validated['tekanan_darah_status'] = 'Rendah';
            } elseif (($sistole >= 90 && $sistole <= 120) || ($diastole >= 60 && $diastole <= 80)) {
                $validated['tekanan_darah_status'] = 'Normal';
            } else {
                $validated['tekanan_darah_status'] = 'Tinggi';
            }
        }

        $pemeriksaan_remaja->update($validated);

        return redirect()->route('pemeriksaan-remaja.index')->with('success', 'Pemeriksaan remaja berhasil diperbarui');
    }

    public function destroy(PemeriksaanRemaja $pemeriksaan_remaja)
    {
        $pemeriksaan_remaja->delete();
        return redirect()->route('pemeriksaan-remaja.index')->with('success', 'Pemeriksaan remaja berhasil dihapus');
    }
}
