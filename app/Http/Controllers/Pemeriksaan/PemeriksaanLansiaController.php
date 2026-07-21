<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;

use App\Models\PemeriksaanLansia;
use App\Models\Lansia;
use Illuminate\Http\Request;

class PemeriksaanLansiaController extends Controller
{
    public function index(Request $request)
    {
        $query = PemeriksaanLansia::with('lansia');
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('lansia', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }
        
        $pemeriksaans = $query->orderByDesc('tanggal_kunjungan')->paginate(10);
        return view('pemeriksaan.lansia.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $lansias = Lansia::orderBy('nama')->get();
        $pemeriksaanBelumSelesai = PemeriksaanLansia::where('tahap_terakhir', '<', 4)
            ->orWhereNull('tahap_terakhir')
            ->with('lansia')
            ->latest('tanggal_kunjungan')
            ->get();
        return view('pemeriksaan.lansia.create', compact('lansias', 'pemeriksaanBelumSelesai'));
    }

    public function stage($stage, Request $request)
    {
        $pemeriksaan_id = $request->query('pemeriksaan_id');
        $lansias = Lansia::orderBy('nama')->get();
        $data = [];
        
        if ($pemeriksaan_id) {
            $pemeriksaan = PemeriksaanLansia::findOrFail($pemeriksaan_id);
            $data = $pemeriksaan->toArray();
        } else {
            $pemeriksaan = null;
        }

        return view("pemeriksaan.lansia.stages.stage-{$stage}", compact('stage', 'lansias', 'pemeriksaan', 'data'));
    }

    public function store(Request $request)
    {
        $stage = $request->input('stage', 1);
        $pemeriksaan_id = $request->input('pemeriksaan_id');
        
        // Validation based on stage
        $validationRules = [
            'dewasa_identitas_id' => 'nullable|exists:dewasa_identitas,id',
            'tanggal_kunjungan' => 'nullable|date',
        ];

        if (!$pemeriksaan_id) {
            $validationRules['dewasa_identitas_id'] = 'required|exists:dewasa_identitas,id';
            $validationRules['tanggal_kunjungan'] = 'required|date';
        }

        if ($stage == 1) {
            $validationRules = array_merge($validationRules, [
                'berat_badan' => 'required|numeric|min:0',
                'tinggi_badan' => 'required|numeric|min:0',
                'lingkar_perut' => 'required|numeric|min:0',
                'imt' => 'nullable|numeric|min:0',
            ]);
        } elseif ($stage == 2) {
            $validationRules = array_merge($validationRules, [
                'sistole' => 'required|numeric|min:0',
                'diastole' => 'required|numeric|min:0',
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

        $checkId = $validated['dewasa_identitas_id'] ?? null;
        $checkDate = $validated['tanggal_kunjungan'] ?? null;

        if ($checkId && $checkDate) {
            $existing = PemeriksaanLansia::where('dewasa_identitas_id', $checkId)
                ->where('tanggal_kunjungan', $checkDate)
                ->when($pemeriksaan_id, fn($q) => $q->where('id', '!=', $pemeriksaan_id))
                ->first();

            if ($existing) {
                return back()->withErrors([
                    'tanggal_kunjungan' => 'Peringatan: Sudah ada pemeriksaan untuk lansia ini pada tanggal kunjungan yang sama.'
                ])->withInput();
            }
        }

        if (isset($validated['berat_badan']) && isset($validated['tinggi_badan'])) {
            $berat = (float) $validated['berat_badan'];
            $tinggi = (float) $validated['tinggi_badan'] / 100;
            if ($berat > 0 && $tinggi > 0) {
                $imt = round($berat / ($tinggi * $tinggi), 1);
                $validated['imt'] = $imt;
                
                if ($imt < 18.5) {
                    $validated['status_berat_badan'] = 'Kurus (Underweight)';
                } elseif ($imt >= 18.5 && $imt < 25) {
                    $validated['status_berat_badan'] = 'Normal';
                } elseif ($imt >= 25 && $imt < 30) {
                    $validated['status_berat_badan'] = 'Kelebihan Berat Badan (Overweight)';
                } else {
                    $validated['status_berat_badan'] = 'Obesitas';
                }
            }
        }
        if (isset($validated['sistole']) && isset($validated['diastole'])) {
            $sistole = (float) $validated['sistole'];
            $diastole = (float) $validated['diastole'];
            
            if ($sistole == 0 && $diastole == 0) {
                $validated['tekanan_darah_status'] = '';
            } elseif ($sistole < 90 && $diastole < 60) {
                $validated['tekanan_darah_status'] = 'Hypotension';
            } elseif ($sistole < 120 && $diastole < 80) {
                $validated['tekanan_darah_status'] = 'Normal';
            } elseif ($sistole >= 120 && $sistole <= 129 && $diastole < 80) {
                $validated['tekanan_darah_status'] = 'Elevated';
            } elseif ($sistole >= 130 && $sistole <= 139 && $diastole >= 80 && $diastole <= 89) {
                $validated['tekanan_darah_status'] = 'Stage 1 Hypertension';
            } elseif ($sistole >= 140 || $diastole >= 90) {
                $validated['tekanan_darah_status'] = 'Stage 2 Hypertension';
            }
        }

        if ($pemeriksaan_id) {
            $pemeriksaan = PemeriksaanLansia::findOrFail($pemeriksaan_id);
            $pemeriksaan->update($validated);
            $pemeriksaan->tahap_terakhir = $stage;
            $pemeriksaan->save();
        } else {
            $validated['tahap_terakhir'] = $stage;
            $pemeriksaan = PemeriksaanLansia::create($validated);
        }

        return redirect()->route('pemeriksaan-lansia.create')->with('success', "Tahap {$stage} berhasil disimpan.");
    }

    public function show(PemeriksaanLansia $pemeriksaan_lansia)
    {
        $pemeriksaan_lansia->load(['lansia.keluarga']);
        $pemeriksaan = $pemeriksaan_lansia;
        return view('pemeriksaan.lansia.show', compact('pemeriksaan'));
    }

    public function print(PemeriksaanLansia $pemeriksaan_lansia)
    {
        $pemeriksaan_lansia->load(['lansia.keluarga']);
        $history = PemeriksaanLansia::where('dewasa_identitas_id', $pemeriksaan_lansia->dewasa_identitas_id)
            ->where('tahap_terakhir', 4)
            ->orderBy('tanggal_kunjungan', 'asc')
            ->get();
        $pemeriksaan = $pemeriksaan_lansia;
        return view('pemeriksaan.lansia.print', compact('pemeriksaan', 'history'));
    }

    public function edit(PemeriksaanLansia $pemeriksaan_lansia)
    {
        $lansias = Lansia::orderBy('nama')->get();
        $pemeriksaan = $pemeriksaan_lansia;
        return view('pemeriksaan.lansia.edit', compact('pemeriksaan', 'lansias'));
    }

    public function update(Request $request, PemeriksaanLansia $pemeriksaan_lansia)
    {
        $validated = $request->validate([
            'dewasa_identitas_id' => 'required|exists:dewasa_identitas,id',
            'tanggal_kunjungan' => 'required|date',
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

        $existing = PemeriksaanLansia::where('dewasa_identitas_id', $validated['dewasa_identitas_id'])
            ->where('tanggal_kunjungan', $validated['tanggal_kunjungan'])
            ->where('id', '!=', $pemeriksaan_lansia->id)
            ->first();

        if ($existing) {
            return back()->withErrors([
                'tanggal_kunjungan' => 'Peringatan: Sudah ada pemeriksaan untuk lansia ini pada tanggal kunjungan yang sama.'
            ])->withInput();
        }

        if (isset($validated['berat_badan']) && isset($validated['tinggi_badan'])) {
            $berat = (float) $validated['berat_badan'];
            $tinggi = (float) $validated['tinggi_badan'] / 100;
            if ($berat > 0 && $tinggi > 0) {
                $imt = round($berat / ($tinggi * $tinggi), 1);
                $validated['imt'] = $imt;
                
                if ($imt < 18.5) {
                    $validated['status_berat_badan'] = 'Kurus (Underweight)';
                } elseif ($imt >= 18.5 && $imt < 25) {
                    $validated['status_berat_badan'] = 'Normal';
                } elseif ($imt >= 25 && $imt < 30) {
                    $validated['status_berat_badan'] = 'Kelebihan Berat Badan (Overweight)';
                } else {
                    $validated['status_berat_badan'] = 'Obesitas';
                }
            }
        }
        if (isset($validated['sistole']) && isset($validated['diastole'])) {
            $sistole = (float) $validated['sistole'];
            $diastole = (float) $validated['diastole'];
            
            if ($sistole == 0 && $diastole == 0) {
                $validated['tekanan_darah_status'] = '';
            } elseif ($sistole < 90 && $diastole < 60) {
                $validated['tekanan_darah_status'] = 'Hypotension';
            } elseif ($sistole < 120 && $diastole < 80) {
                $validated['tekanan_darah_status'] = 'Normal';
            } elseif ($sistole >= 120 && $sistole <= 129 && $diastole < 80) {
                $validated['tekanan_darah_status'] = 'Elevated';
            } elseif ($sistole >= 130 && $sistole <= 139 && $diastole >= 80 && $diastole <= 89) {
                $validated['tekanan_darah_status'] = 'Stage 1 Hypertension';
            } elseif ($sistole >= 140 || $diastole >= 90) {
                $validated['tekanan_darah_status'] = 'Stage 2 Hypertension';
            }
        }

        $pemeriksaan_lansia->update($validated);
        return redirect()->route('pemeriksaan-lansia.index')->with('success', 'Data pemeriksaan berhasil diperbarui');
    }

    public function destroy(PemeriksaanLansia $pemeriksaan_lansia)
    {
        $pemeriksaan_lansia->delete();
        return redirect()->route('pemeriksaan-lansia.index')->with('success', 'Data pemeriksaan berhasil dihapus');
    }
}
