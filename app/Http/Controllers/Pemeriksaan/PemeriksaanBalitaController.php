<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use App\Models\PemeriksaanBalita;
use App\Models\Balita;
use App\Models\ActivityLog;
use Carbon\Carbon;
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
        $previousWeights = [];

        // Jika ada pemeriksaan_id, load dari database
        if ($request->has('pemeriksaan_id')) {
            $pemeriksaan = PemeriksaanBalita::find($request->pemeriksaan_id);
            if ($pemeriksaan) {
                $data = $pemeriksaan->toArray();
            }
        }

        if ($stage === 1) {
            $previousWeights = PemeriksaanBalita::when($request->filled('pemeriksaan_id'), function ($query) use ($request) {
                    return $query->where('id', '!=', $request->query('pemeriksaan_id'));
                })
                ->whereNotNull('berat_badan')
                ->whereNotNull('tanggal_kunjungan')
                ->orderByDesc('tanggal_kunjungan')
                ->get()
                ->unique('balita_identitas_id')
                ->mapWithKeys(function ($item) {
                    return [
                        $item->balita_identitas_id => [
                            'berat_badan' => $item->berat_badan,
                            'tanggal_kunjungan' => optional($item->tanggal_kunjungan)->format('Y-m-d') ?? '-',
                        ],
                    ];
                })
                ->toArray();
        }

        return view("pemeriksaan.balita.stages.stage{$stage}", compact('stage', 'balitas', 'pemeriksaan', 'data', 'previousWeights'));
    }

    public function stageStore(Request $request, int $stage)
    {
        // Validasi stage
        if (!in_array($stage, [1, 2, 3, 4])) {
            abort(404);
        }

        $validated = $request->validate($this->stageRules($stage));

        $pemeriksaanId = $request->input('pemeriksaan_id');

        // Check for duplicate data
        $existing = PemeriksaanBalita::where('balita_identitas_id', $validated['balita_identitas_id'])
            ->where('tanggal_kunjungan', $validated['tanggal_kunjungan'])
            ->when($pemeriksaanId, fn($q) => $q->where('id', '!=', $pemeriksaanId))
            ->first();

        if ($existing) {
            // Add info message but continue
            session()->flash('info', 'Peringatan: Sudah ada pemeriksaan untuk balita ini pada tanggal yang sama.');
        }

        if (empty($pemeriksaanId)) {
            // Jika tidak ada pemeriksaan_id, buat baru dengan tahap_terakhir = $stage
            $pemeriksaan = PemeriksaanBalita::create([
                'balita_identitas_id' => $validated['balita_identitas_id'],
                'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
                'tahap_terakhir' => $stage,
                ...$validated,
            ]);

            try {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'created',
                    'model' => 'PemeriksaanBalita',
                    'model_id' => $pemeriksaan->id,
                    'description' => 'Membuat PemeriksaanBalita [' . $pemeriksaan->id . '] | Tahap: ' . $stage,
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
        } else {
            // Update pemeriksaan yang ada
            $pemeriksaan = PemeriksaanBalita::find($pemeriksaanId);
            $pemeriksaan->update([
                'tahap_terakhir' => $stage,
                ...$validated,
            ]);

            try {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'updated',
                    'model' => 'PemeriksaanBalita',
                    'model_id' => $pemeriksaan->id,
                    'description' => 'Memperbarui PemeriksaanBalita [' . $pemeriksaan->id . '] | Tahap: ' . $stage,
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
        }

        // Calculate automatic statuses after saving
        if (in_array($stage, [1, 2])) {
            $this->calculateStatuses($pemeriksaan);
        }

        return redirect()->route('pemeriksaan-balita.create')->with('success', "Tahap {$stage} berhasil disimpan.");
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
                'panjang_badan' => 'required|numeric|min:0|max:150',
                'lingkar_kepala' => 'nullable|numeric|min:0|max:100',
            ]),
            2 => array_merge($baseRules, [
                'status_bb_u' => 'nullable|string',
                'status_pb_u' => 'nullable|string',
                'status_bb_pb' => 'nullable|string',
                'lingkar_lengan' => 'nullable|numeric|min:0|max:50',
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
        $pemeriksaan = $pemeriksaanBalita;
        return view('pemeriksaan.balita.edit', compact('pemeriksaan', 'balitas'));
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
        $id = $pemeriksaanBalita->id;
        $pemeriksaanBalita->delete();

        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'model' => 'PemeriksaanBalita',
                'model_id' => $id,
                'description' => 'Menghapus PemeriksaanBalita [' . $id . ']',
                'properties' => [
                    'route' => request()->route()?->getName(),
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // ignore logging errors
        }

        return redirect()->route('pemeriksaan-balita.index')->with('success', 'Data pemeriksaan berhasil dihapus');
    }

    private function calculateStatuses(PemeriksaanBalita $pemeriksaan)
    {
        $balita = $pemeriksaan->balita;
        if (!$balita || !$pemeriksaan->berat_badan || !$pemeriksaan->panjang_badan || !$pemeriksaan->tanggal_kunjungan) {
            return;
        }

        $ageInMonths = Carbon::parse($balita->tanggal_lahir)->diffInMonths(Carbon::parse($pemeriksaan->tanggal_kunjungan));

        // Calculate status_bb_u (Weight-for-Age)
        $statusBbU = $this->calculateWeightForAge($pemeriksaan->berat_badan, $ageInMonths);

        // Calculate status_pb_u (Height-for-Age)
        $statusPbU = $this->calculateHeightForAge($pemeriksaan->panjang_badan, $ageInMonths);

        // Calculate status_bb_pb (Weight-for-Height)
        $statusBbPb = $this->calculateWeightForHeight($pemeriksaan->berat_badan, $pemeriksaan->panjang_badan);

        // Compare against previous pemeriksaan berat badan
        $previous = PemeriksaanBalita::where('balita_identitas_id', $pemeriksaan->balita_identitas_id)
            ->where('id', '!=', $pemeriksaan->id)
            ->whereNotNull('berat_badan')
            ->orderByDesc('tanggal_kunjungan')
            ->first();

        if ($previous) {
            if ($pemeriksaan->berat_badan > $previous->berat_badan) {
                $weightTrend = 'Naik';
            } elseif ($pemeriksaan->berat_badan < $previous->berat_badan) {
                $weightTrend = 'Turun';
            } else {
                $weightTrend = 'Tetap';
            }
        } else {
            $weightTrend = 'Baru';
        }

        // Update the pemeriksaan
        $pemeriksaan->update([
            'status_bb_u' => $statusBbU,
            'status_pb_u' => $statusPbU,
            'status_bb_pb' => $statusBbPb,
            'naik_tidak_naik' => $weightTrend,
            'umur' => $ageInMonths,
        ]);
    }

    private function calculateWeightForAge(float $weight, int $ageMonths): string
    {
        // Simplified WHO-like thresholds (approximate)
        if ($ageMonths <= 6) {
            if ($weight < 4.5) return 'Sangat Kurang';
            if ($weight < 5.5) return 'Kurang';
            if ($weight > 8.5) return 'Lebih';
        } elseif ($ageMonths <= 12) {
            if ($weight < 6.5) return 'Sangat Kurang';
            if ($weight < 7.5) return 'Kurang';
            if ($weight > 11.5) return 'Lebih';
        } elseif ($ageMonths <= 24) {
            if ($weight < 8.5) return 'Sangat Kurang';
            if ($weight < 9.5) return 'Kurang';
            if ($weight > 14.5) return 'Lebih';
        } else {
            if ($weight < 10.5) return 'Sangat Kurang';
            if ($weight < 11.5) return 'Kurang';
            if ($weight > 18.5) return 'Lebih';
        }
        return 'Normal';
    }

    private function calculateHeightForAge(float $height, int $ageMonths): string
    {
        // Simplified thresholds
        if ($ageMonths <= 6) {
            if ($height < 55) return 'Sangat Pendek';
            if ($height < 60) return 'Pendek';
            if ($height > 70) return 'Tinggi';
        } elseif ($ageMonths <= 12) {
            if ($height < 65) return 'Sangat Pendek';
            if ($height < 70) return 'Pendek';
            if ($height > 80) return 'Tinggi';
        } elseif ($ageMonths <= 24) {
            if ($height < 75) return 'Sangat Pendek';
            if ($height < 80) return 'Pendek';
            if ($height > 95) return 'Tinggi';
        } else {
            if ($height < 85) return 'Sangat Pendek';
            if ($height < 90) return 'Pendek';
            if ($height > 110) return 'Tinggi';
        }
        return 'Normal';
    }

    private function calculateWeightForHeight(float $weight, float $height): string
    {
        // BMI-like calculation for weight-for-height
        $bmi = $weight / (($height / 100) ** 2);
        if ($bmi < 13) return 'Buruk';
        if ($bmi < 15) return 'Kurang';
        if ($bmi > 25) return 'Lebih';
        return 'Normal';
    }
}
