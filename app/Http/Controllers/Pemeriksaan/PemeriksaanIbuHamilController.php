<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanIbuHamil;
use App\Models\IbuHamil;
use App\Models\ActivityLog;
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
                    return [
                        $item->ibu_hamil_identitas_id => [
                            'berat_badan' => $item->berat_badan,
                            'tanggal_kunjungan' => optional($item->tanggal_kunjungan)->format('Y-m-d') ?? '-',
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
                } elseif ($validated['berat_badan'] < $previous->berat_badan) {
                    $validated['status_bb'] = 'Turun';
                } else {
                    $validated['status_bb'] = 'Tetap';
                }
            } elseif (!empty($validated['berat_badan'])) {
                $validated['status_bb'] = 'Pertama';
            }
        }

        // Check for duplicate data
        $existing = PemeriksaanIbuHamil::where('ibu_hamil_identitas_id', $validated['ibu_hamil_identitas_id'])
            ->where('tanggal_kunjungan', $validated['tanggal_kunjungan'])
            ->when($pemeriksaanId, fn($q) => $q->where('id', '!=', $pemeriksaanId))
            ->first();

        if ($existing) {
            // Add info message but continue
            session()->flash('info', 'Peringatan: Sudah ada pemeriksaan untuk ibu hamil ini pada tanggal yang sama.');
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

        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model' => 'PemeriksaanIbuHamil',
                'model_id' => $pemeriksaanIbuHamil->id,
                'description' => 'Memperbarui PemeriksaanIbuHamil [' . $pemeriksaanIbuHamil->id . ']',
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

    public function destroy(PemeriksaanIbuHamil $pemeriksaanIbuHamil)
    {
        $id = $pemeriksaanIbuHamil->id;
        $pemeriksaanIbuHamil->delete();

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
                'usia_kehamilan' => 'nullable|integer|min:0|max:60',
                'berat_badan' => 'nullable|numeric|min:0',
                'lingkar_lengan' => 'nullable|numeric|min:0',
                'status_bb' => 'nullable|in:Naik,Tidak',
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