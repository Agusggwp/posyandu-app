<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanIbuHamil;
use App\Models\IbuHamil;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PemeriksaanIbuHamilController extends Controller
{
    public function index(Request $request)
    {
        $query = PemeriksaanIbuHamil::with('ibuHamil');
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('ibuHamil', function ($q) use ($search) {
                $q->where('nama_ibu', 'like', '%' . $search . '%');
            });
        }
        
        $pemeriksaans = $query->orderByDesc('tanggal_kunjungan')->paginate(10);
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
        $previousWeights = [];

        if ($request->filled('pemeriksaan_id')) {
            $pemeriksaan = PemeriksaanIbuHamil::with('ibuHamil')->findOrFail($request->query('pemeriksaan_id'));
        }

        $data = $pemeriksaan ? $pemeriksaan->toArray() : $request->session()->get('pemeriksaan_ibu_hamil_stage', []);

        if ($stage === 1) {
            $previousWeights = PemeriksaanIbuHamil::when($request->filled('pemeriksaan_id'), function ($query) use ($request) {
                    return $query->where('id', '!=', $request->query('pemeriksaan_id'));
                })
                ->whereNotNull('berat_badan')
                ->whereNotNull('ibu_hamil_identitas_id')
                ->orderByDesc('tanggal_kunjungan')
                ->get()
                ->unique('ibu_hamil_identitas_id')
                ->mapWithKeys(function ($item) {
                    \Carbon\Carbon::setLocale('id');
                    $previousDate = '-';
                    if ($item->tanggal_kunjungan) {
                        try {
                            $previousDate = \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d F Y');
                        } catch (\Throwable $e) {
                            $previousDate = (string) $item->tanggal_kunjungan;
                        }
                    }
                    return [
                        $item->ibu_hamil_identitas_id => [
                            'berat_badan' => $item->berat_badan,
                            'lingkar_lengan' => $item->lingkar_lengan,
                            'tanggal_kunjungan' => $previousDate,
                        ],
                    ];
                })
                ->toArray();
        }

        return view('pemeriksaan.ibu-hamil.stages.stage' . $stage, compact('stage', 'ibuHamils', 'data', 'pemeriksaan', 'previousWeights'));
    }

    public function stageStore(Request $request, int $stage = 1)
    {
        if (!in_array($stage, [1, 2, 3, 4], true)) {
            return redirect()->route('pemeriksaan-ibu-hamil.create');
        }

        $validated = $request->validate($this->stageRules($stage));

        if ($stage === 2) {
            $sistole = isset($validated['sistole']) ? (int) $validated['sistole'] : null;
            $diastole = isset($validated['diastole']) ? (int) $validated['diastole'] : null;

            if (!is_null($sistole) && !is_null($diastole)) {
                $validated['tekanan_darah'] = $sistole . '/' . $diastole;
                $validated['status_tekanan_darah'] = $this->calculateBloodPressureStatus($sistole, $diastole);
            }

            unset($validated['sistole'], $validated['diastole']);
        }
        $pemeriksaanId = $request->input('pemeriksaan_id');

        if ($stage === 1 && isset($validated['ibu_hamil_identitas_id'], $validated['berat_badan'])) {
            $previous = PemeriksaanIbuHamil::where('ibu_hamil_identitas_id', $validated['ibu_hamil_identitas_id'])
                ->whereNotNull('berat_badan')
                ->when($pemeriksaanId, fn($q) => $q->where('id', '!=', $pemeriksaanId))
                ->orderByDesc('tanggal_kunjungan')
                ->first();

            if ($previous) {
                if ($validated['berat_badan'] > $previous->berat_badan) {
                    $validated['status_bb'] = 'Naik';
                } else {
                    $validated['status_bb'] = 'Tidak';
                }
            } else {
                $validated['status_bb'] = null;
            }

            // Calculate status_lila
            if (isset($validated['lingkar_lengan']) && $validated['lingkar_lengan'] !== '') {
                $validated['status_lila'] = $validated['lingkar_lengan'] < 23.5 ? 'Merah' : 'Hijau';
            } else {
                $validated['status_lila'] = null;
            }
        }

        // Check for duplicate data
        $existing = PemeriksaanIbuHamil::where('ibu_hamil_identitas_id', $validated['ibu_hamil_identitas_id'])
            ->where('tanggal_kunjungan', $validated['tanggal_kunjungan'])
            ->when($pemeriksaanId, fn($q) => $q->where('id', '!=', $pemeriksaanId))
            ->first();

        if ($existing) {
            return back()->withErrors([
                'tanggal_kunjungan' => 'Peringatan: Sudah ada pemeriksaan untuk ibu hamil ini pada tanggal kunjungan yang sama.'
            ])->withInput();
        }

        if ($stage === 1 && empty($pemeriksaanId)) {
            $pemeriksaan = PemeriksaanIbuHamil::create($validated + ['tahap_terakhir' => 1]);

            try {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'created',
                    'model' => 'PemeriksaanIbuHamil',
                    'model_id' => $pemeriksaan->id,
                    'description' => 'Membuat PemeriksaanIbuHamil [' . $pemeriksaan->id . '] | Tahap: 1',
                    'properties' => [
                        'route' => request()->route()?->getName(),
                        'stage' => 1,
                    ],
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            } catch (\Throwable $e) {
                // do not block on logging
            }

            return redirect()->route('pemeriksaan-ibu-hamil.create')->with('success', 'Tahap 1 berhasil disimpan.');
        }

        if (empty($pemeriksaanId)) {
            $pemeriksaan = PemeriksaanIbuHamil::create($validated + ['tahap_terakhir' => $stage]);

            try {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'created',
                    'model' => 'PemeriksaanIbuHamil',
                    'model_id' => $pemeriksaan->id,
                    'description' => 'Membuat PemeriksaanIbuHamil [' . $pemeriksaan->id . '] | Tahap: ' . $stage,
                    'properties' => [
                        'route' => request()->route()?->getName(),
                        'stage' => $stage,
                    ],
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            } catch (\Throwable $e) {
                // ignore logging errors
            }

            return redirect()->route('pemeriksaan-ibu-hamil.create')->with('success', 'Tahap ' . $stage . ' berhasil disimpan.');
        }

        $pemeriksaan = PemeriksaanIbuHamil::findOrFail($pemeriksaanId);
        $pemeriksaan->update(array_merge($pemeriksaan->toArray(), $validated, [
            'tahap_terakhir' => $stage,
        ]));

        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model' => 'PemeriksaanIbuHamil',
                'model_id' => $pemeriksaan->id,
                'description' => 'Memperbarui PemeriksaanIbuHamil [' . $pemeriksaan->id . '] | Tahap: ' . $stage,
                'properties' => [
                    'route' => request()->route()?->getName(),
                    'stage' => $stage,
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // ignore
        }

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

        $existing = PemeriksaanIbuHamil::where('ibu_hamil_identitas_id', $validated['ibu_hamil_identitas_id'])
            ->where('tanggal_kunjungan', $validated['tanggal_kunjungan'])
            ->first();

        if ($existing) {
            return back()->withErrors([
                'tanggal_kunjungan' => 'Peringatan: Sudah ada pemeriksaan untuk ibu hamil ini pada tanggal kunjungan yang sama.'
            ])->withInput();
        }

        $pemeriksaan = PemeriksaanIbuHamil::create($validated);

        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'model' => 'PemeriksaanIbuHamil',
                'model_id' => $pemeriksaan->id,
                'description' => 'Membuat PemeriksaanIbuHamil [' . $pemeriksaan->id . ']',
                'properties' => [
                    'route' => request()->route()?->getName(),
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // ignore logging errors
        }

        return redirect()->route('pemeriksaan-ibu-hamil.index')->with('success', 'Data pemeriksaan berhasil ditambahkan');
    }

    public function show(PemeriksaanIbuHamil $pemeriksaan_ibu_hamil)
    {
        $pemeriksaan_ibu_hamil->load(['ibuHamil.keluarga']);
        $pemeriksaan = $pemeriksaan_ibu_hamil;
        return view('pemeriksaan.ibu-hamil.show', compact('pemeriksaan'));
    }

    public function print(PemeriksaanIbuHamil $pemeriksaan_ibu_hamil)
    {
        $pemeriksaan_ibu_hamil->load(['ibuHamil.keluarga']);
        $history = PemeriksaanIbuHamil::where('ibu_hamil_identitas_id', $pemeriksaan_ibu_hamil->ibu_hamil_identitas_id)
            ->where('tahap_terakhir', 4)
            ->orderBy('tanggal_kunjungan', 'asc')
            ->get();
        $pemeriksaan = $pemeriksaan_ibu_hamil;
        return view('pemeriksaan.ibu-hamil.print', compact('pemeriksaan', 'history'));
    }

    public function edit(PemeriksaanIbuHamil $pemeriksaan_ibu_hamil)
    {
        $ibuHamils = IbuHamil::orderBy('nama_ibu')->get();
        $pemeriksaan = $pemeriksaan_ibu_hamil;
        return view('pemeriksaan.ibu-hamil.edit', compact('pemeriksaan', 'ibuHamils'));
    }

    public function update(Request $request, PemeriksaanIbuHamil $pemeriksaan_ibu_hamil)
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

        $existing = PemeriksaanIbuHamil::where('ibu_hamil_identitas_id', $validated['ibu_hamil_identitas_id'])
            ->where('tanggal_kunjungan', $validated['tanggal_kunjungan'])
            ->where('id', '!=', $pemeriksaan_ibu_hamil->id)
            ->first();

        if ($existing) {
            return back()->withErrors([
                'tanggal_kunjungan' => 'Peringatan: Sudah ada pemeriksaan untuk ibu hamil ini pada tanggal kunjungan yang sama.'
            ])->withInput();
        }

        if (isset($validated['tekanan_darah']) && str_contains($validated['tekanan_darah'], '/')) {
            $parts = explode('/', $validated['tekanan_darah']);
            if (count($parts) === 2) {
                $sistole = (int) trim($parts[0]);
                $diastole = (int) trim($parts[1]);
                $validated['status_tekanan_darah'] = $this->calculateBloodPressureStatus($sistole, $diastole);
            }
        }

        if (isset($validated['berat_badan']) && isset($validated['ibu_hamil_identitas_id'])) {
            $previous = PemeriksaanIbuHamil::where('ibu_hamil_identitas_id', $validated['ibu_hamil_identitas_id'])
                ->whereNotNull('berat_badan')
                ->where('id', '!=', $pemeriksaan_ibu_hamil->id)
                ->orderByDesc('tanggal_kunjungan')
                ->first();

            if ($previous) {
                $validated['status_bb'] = $validated['berat_badan'] > $previous->berat_badan ? 'Naik' : 'Tidak';
            } else {
                $validated['status_bb'] = null;
            }
        }

        if (isset($validated['lingkar_lengan']) && $validated['lingkar_lengan'] !== '') {
            $validated['status_lila'] = $validated['lingkar_lengan'] < 23.5 ? 'Merah' : 'Hijau';
        } else {
            $validated['status_lila'] = null;
        }

        $pemeriksaan_ibu_hamil->update($validated);

        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model' => 'PemeriksaanIbuHamil',
                'model_id' => $pemeriksaan_ibu_hamil->id,
                'description' => 'Memperbarui PemeriksaanIbuHamil [' . $pemeriksaan_ibu_hamil->id . ']',
                'properties' => [
                    'route' => request()->route()?->getName(),
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // ignore logging errors
        }

        return redirect()->route('pemeriksaan-ibu-hamil.index')->with('success', 'Data pemeriksaan berhasil diperbarui');
    }

    public function destroy(PemeriksaanIbuHamil $pemeriksaan_ibu_hamil)
    {
        $id = $pemeriksaan_ibu_hamil->id;
        $pemeriksaan_ibu_hamil->delete();

        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'model' => 'PemeriksaanIbuHamil',
                'model_id' => $id,
                'description' => 'Menghapus PemeriksaanIbuHamil [' . $id . ']',
                'properties' => [
                    'route' => request()->route()?->getName(),
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // ignore logging errors
        }

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
                'usia_kehamilan' => 'required|integer|min:0|max:60',
                'berat_badan' => 'required|numeric|min:0',
                'lingkar_lengan' => 'required|numeric|min:0',
                'status_bb' => 'nullable|string',
                'status_lila' => 'nullable|in:Hijau,Kuning,Merah',
            ],
            2 => $baseRules + [
                'sistole' => 'required|integer|min:50|max:260',
                'diastole' => 'required|integer|min:30|max:180',
            ],
            3 => $baseRules + [
                'tablet_tambah_darah' => 'nullable|boolean',
                'pmt_bumil' => 'nullable|boolean',
                'kelas_ibu_hamil' => 'nullable|boolean',
                'tb_skrining_batuk' => 'nullable|boolean',
                'tb_skrining_demam' => 'nullable|boolean',
                'tb_skrining_bb_turun' => 'nullable|boolean',
                'tb_skrining_kontak' => 'nullable|boolean',
                'tb_skrining_hasil' => 'nullable|in:Ya,Tidak,Dirujuk',
            ],
            4 => $baseRules + [
                'edukasi' => 'nullable|string|max:2000',
                'rujukan' => 'nullable|in:Pustu,Puskesmas,Rumah Sakit,Tidak',
            ],
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
}