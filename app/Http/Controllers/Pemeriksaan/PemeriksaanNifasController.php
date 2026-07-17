<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;

use App\Models\Nifas;
use App\Models\PemeriksaanNifas;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PemeriksaanNifasController extends Controller
{
    public function index(Request $request)
    {
        $query = PemeriksaanNifas::with('nifas');
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('nifas', function ($q) use ($search) {
                $q->where('nama_ibu', 'like', '%' . $search . '%');
            });
        }
        
        $pemeriksaans = $query->latest()->paginate(10);
        return view('pemeriksaan.nifas.index', compact('pemeriksaans'));
    }

    public function create()
    {
        $nifases = Nifas::orderBy('nama_ibu')->get();
        $pemeriksaanBelumSelesai = PemeriksaanNifas::with('nifas')
            ->where('tahap_terakhir', '<', 4)
            ->orderByDesc('updated_at')
            ->get();

        return view('pemeriksaan.nifas.create', compact('nifases', 'pemeriksaanBelumSelesai'));
    }

    public function stage(Request $request, int $stage = 1)
    {
        if (!in_array($stage, [1, 2, 3, 4], true)) {
            return redirect()->route('pemeriksaan-nifas.create');
        }

        $nifases = Nifas::orderBy('nama_ibu')->get();
        $pemeriksaan = null;
        $previousWeights = [];

        if ($request->filled('pemeriksaan_id')) {
            $pemeriksaan = PemeriksaanNifas::with('nifas')->findOrFail($request->query('pemeriksaan_id'));
        }

        $data = $pemeriksaan ? $pemeriksaan->toArray() : $request->session()->get('pemeriksaan_nifas_stage', []);

        if ($stage === 1) {
            $previousWeights = PemeriksaanNifas::when($request->filled('pemeriksaan_id'), function ($query) use ($request) {
                    return $query->where('id', '!=', $request->query('pemeriksaan_id'));
                })
                ->whereNotNull('berat_badan')
                ->whereNotNull('tanggal_kunjungan')
                ->orderByDesc('tanggal_kunjungan')
                ->get()
                ->unique('nifas_identitas_id')
                ->mapWithKeys(function ($item) {
                    return [
                        $item->nifas_identitas_id => [
                            'berat_badan' => $item->berat_badan,
                            'tanggal_kunjungan' => optional($item->tanggal_kunjungan)->format('Y-m-d') ?? '-',
                        ],
                    ];
                })
                ->toArray();
        }

        return view('pemeriksaan.nifas.stages.stage' . $stage, compact('stage', 'nifases', 'data', 'pemeriksaan', 'previousWeights'));
    }

    public function stageStore(Request $request, int $stage = 1)
    {
        if (!in_array($stage, [1, 2, 3, 4], true)) {
            return redirect()->route('pemeriksaan-nifas.create');
        }

        $validated = $request->validate($this->stageRules($stage));
        $pemeriksaanId = $request->input('pemeriksaan_id');

        if ($stage === 1 && isset($validated['nifas_identitas_id'], $validated['berat_badan'])) {
            $previous = PemeriksaanNifas::where('nifas_identitas_id', $validated['nifas_identitas_id'])
                ->whereNotNull('berat_badan')
                ->when($pemeriksaanId, fn($q) => $q->where('id', '!=', $pemeriksaanId))
                ->orderByDesc('tanggal_kunjungan')
                ->first();

            if ($previous) {
                if ($validated['berat_badan'] > $previous->berat_badan) {
                    $validated['naik_turun'] = 'Naik';
                } elseif ($validated['berat_badan'] < $previous->berat_badan) {
                    $validated['naik_turun'] = 'Turun';
                } else {
                    $validated['naik_turun'] = 'Tetap';
                }
            } elseif (!empty($validated['berat_badan'])) {
                $validated['naik_turun'] = 'Pertama';
            }
        }

        if ($stage === 1 && empty($pemeriksaanId)) {
            $pemeriksaan = PemeriksaanNifas::create($validated + ['tahap_terakhir' => 1]);

            try {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'created',
                    'model' => 'PemeriksaanNifas',
                    'model_id' => $pemeriksaan->id,
                    'description' => 'Membuat PemeriksaanNifas [' . $pemeriksaan->id . '] | Tahap: 1',
                    'properties' => [
                        'route' => request()->route()?->getName(),
                        'stage' => 1,
                    ],
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            } catch (\Throwable $e) {
                // do not block flow on logging error
            }

            return redirect()->route('pemeriksaan-nifas.create')->with('success', 'Tahap 1 berhasil disimpan.');
        }

        if (empty($pemeriksaanId)) {
            $pemeriksaan = PemeriksaanNifas::create($validated + ['tahap_terakhir' => $stage]);

            try {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'created',
                    'model' => 'PemeriksaanNifas',
                    'model_id' => $pemeriksaan->id,
                    'description' => 'Membuat PemeriksaanNifas [' . $pemeriksaan->id . '] | Tahap: ' . $stage,
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

            return redirect()->route('pemeriksaan-nifas.create')->with('success', 'Tahap ' . $stage . ' berhasil disimpan.');
        }

        $pemeriksaan = PemeriksaanNifas::findOrFail($pemeriksaanId);
        $pemeriksaan->update(array_merge($pemeriksaan->toArray(), $validated, [
            'tahap_terakhir' => $stage,
        ]));

        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model' => 'PemeriksaanNifas',
                'model_id' => $pemeriksaan->id,
                'description' => 'Memperbarui PemeriksaanNifas [' . $pemeriksaan->id . '] | Tahap: ' . $stage,
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
            return redirect()->route('pemeriksaan-nifas.create')->with('success', 'Tahap ' . $stage . ' berhasil disimpan.');
        }

        return redirect()->route('pemeriksaan-nifas.create')->with('success', 'Tahap 4 berhasil disimpan. Pemeriksaan sudah selesai.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nifas_identitas_id' => 'required|exists:nifas_identitas,id',
            'waktu_kunjungan' => 'nullable|string|max:50',
            'berat_badan' => 'nullable|numeric|min:0',
            'naik_turun' => 'nullable|string|max:10',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'lila' => 'nullable|numeric|min:0',
            'status_gizi' => 'nullable|string|max:10',
            'sistole' => 'nullable|integer|min:0',
            'diastole' => 'nullable|integer|min:0',
            'tekanan_darah_status' => 'nullable|string|max:20',
            'batuk' => 'nullable|string|max:5',
            'demam' => 'nullable|string|max:5',
            'bb_turun' => 'nullable|string|max:5',
            'kontak_tbc' => 'nullable|string|max:5',
            'vitamin_a' => 'nullable|string|max:5',
            'menyusui' => 'nullable|string|max:5',
            'kb' => 'nullable|string|max:50',
            'edukasi' => 'nullable|string',
            'rujukan' => 'nullable|string|max:100',
        ]);

        PemeriksaanNifas::create($validated);

        return redirect()->route('pemeriksaan-nifas.index')->with('success', 'Pemeriksaan nifas berhasil ditambahkan');
    }

    public function show(PemeriksaanNifas $pemeriksaan_nifas)
    {
        $pemeriksaan_nifas->load(['nifas.keluarga']);
        $pemeriksaan = $pemeriksaan_nifas;
        return view('pemeriksaan.nifas.show', compact('pemeriksaan'));
    }

    public function print(PemeriksaanNifas $pemeriksaan_nifas)
    {
        $pemeriksaan_nifas->load(['nifas.keluarga']);
        $history = PemeriksaanNifas::where('nifas_identitas_id', $pemeriksaan_nifas->nifas_identitas_id)
            ->where('tahap_terakhir', 4)
            ->orderBy('tanggal_kunjungan', 'asc')
            ->get();
        $pemeriksaan = $pemeriksaan_nifas;
        return view('pemeriksaan.nifas.print', compact('pemeriksaan', 'history'));
    }

    public function edit(PemeriksaanNifas $pemeriksaan_nifas)
    {
        $nifases = Nifas::latest()->get();
        return view('pemeriksaan.nifas.edit', ['pemeriksaanNifas' => $pemeriksaan_nifas, 'nifases' => $nifases]);
    }

    public function update(Request $request, PemeriksaanNifas $pemeriksaan_nifas)
    {
        $validated = $request->validate([
            'nifas_identitas_id' => 'required|exists:nifas_identitas,id',
            'waktu_kunjungan' => 'nullable|string|max:50',
            'berat_badan' => 'nullable|numeric|min:0',
            'naik_turun' => 'nullable|string|max:10',
            'tinggi_badan' => 'nullable|numeric|min:0',
            'lila' => 'nullable|numeric|min:0',
            'status_gizi' => 'nullable|string|max:10',
            'sistole' => 'nullable|integer|min:0',
            'diastole' => 'nullable|integer|min:0',
            'tekanan_darah_status' => 'nullable|string|max:20',
            'batuk' => 'nullable|string|max:5',
            'demam' => 'nullable|string|max:5',
            'bb_turun' => 'nullable|string|max:5',
            'kontak_tbc' => 'nullable|string|max:5',
            'vitamin_a' => 'nullable|string|max:5',
            'menyusui' => 'nullable|string|max:5',
            'kb' => 'nullable|string|max:50',
            'edukasi' => 'nullable|string',
            'rujukan' => 'nullable|string|max:100',
        ]);

        $pemeriksaan_nifas->update($validated);

        return redirect()->route('pemeriksaan-nifas.index')->with('success', 'Pemeriksaan nifas berhasil diperbarui');
    }

    public function destroy(PemeriksaanNifas $pemeriksaan_nifas)
    {
        $id = $pemeriksaan_nifas->id;
        $pemeriksaan_nifas->delete();

        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'model' => 'PemeriksaanNifas',
                'model_id' => $id,
                'description' => 'Menghapus PemeriksaanNifas [' . $id . ']',
                'properties' => [
                    'route' => request()->route()?->getName(),
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // ignore logging errors
        }

        return redirect()->route('pemeriksaan-nifas.index')->with('success', 'Pemeriksaan nifas berhasil dihapus');
    }

    private function stageRules(int $stage): array
    {
        $baseRules = [
            'nifas_identitas_id' => 'required|exists:nifas_identitas,id',
            'tanggal_kunjungan' => 'required|date',
        ];

        return match ($stage) {
            1 => $baseRules + [
                'berat_badan' => 'nullable|numeric|min:0',
                'naik_turun' => 'nullable|string',
                'tinggi_badan' => 'nullable|numeric|min:0',
                'lila' => 'nullable|numeric|min:0|max:100',
                'status_gizi' => 'nullable|in:Hijau,Kuning,Merah',
            ],
            2 => $baseRules + [
                'sistole' => 'nullable|integer|min:0|max:300',
                'diastole' => 'nullable|integer|min:0|max:300',
                'tekanan_darah_status' => 'nullable|in:Rendah,Normal,Tinggi',
            ],
            3 => $baseRules + [
                'batuk' => 'nullable|boolean',
                'demam' => 'nullable|boolean',
                'bb_turun' => 'nullable|boolean',
                'kontak_tbc' => 'nullable|boolean',
                'status_tbc' => 'nullable|in:Ya,Tidak,Dirujuk',
                'vitamin_a' => 'nullable|boolean',
                'menyusui' => 'nullable|boolean',
                'kb' => 'nullable|in:Pil,Kondom,Suntik,IUD,Implan,Lain-lain',
            ],
            4 => $baseRules + [
                'edukasi' => 'nullable|string|max:2000',
                'rujukan' => 'nullable|in:Pustu,Puskesmas,Rumah Sakit,Tidak',
            ],
            default => $baseRules,
        };
    }
}
