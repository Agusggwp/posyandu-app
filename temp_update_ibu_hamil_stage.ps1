$controllerPath = 'c:\Users\AGUS\Desktop\TA\demo\posyandu-app\app\Http\Controllers\Pemeriksaan\PemeriksaanIbuHamilController.php'
$controllerContent = @'
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
        return view('pemeriksaan.ibu-hamil.create-new', compact('ibuHamils'));
    }

    public function stage(Request $request, int $stage = 1)
    {
        if (!in_array($stage, [1, 2, 3, 4], true)) {
            return redirect()->route('pemeriksaan-ibu-hamil.create');
        }

        $ibuHamils = IbuHamil::orderBy('nama_ibu')->get();
        $data = $request->session()->get('pemeriksaan_ibu_hamil_stage', []);
        $pemeriksaan = null;

        return view('pemeriksaan.ibu-hamil.stages.stage' . $stage, compact('stage', 'ibuHamils', 'data', 'pemeriksaan'));
    }

    public function stageStore(Request $request, int $stage = 1)
    {
        if (!in_array($stage, [1, 2, 3, 4], true)) {
            return redirect()->route('pemeriksaan-ibu-hamil.create');
        }

        $validated = $request->validate($this->stageRules($stage));
        $sessionData = array_merge($request->session()->get('pemeriksaan_ibu_hamil_stage', []), $validated);
        $request->session()->put('pemeriksaan_ibu_hamil_stage', $sessionData);

        if ($stage < 4) {
            return redirect()->route('pemeriksaan-ibu-hamil.stage', $stage + 1);
        }

        PemeriksaanIbuHamil::create($sessionData + ['tahap_terakhir' => 4]);
        $request->session()->forget('pemeriksaan_ibu_hamil_stage');

        return redirect()->route('pemeriksaan-ibu-hamil.index')->with('success', 'Data pemeriksaan berhasil disimpan.');
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
'@
Set-Content -Path $controllerPath -Value $controllerContent -NoNewline

$routePath = 'c:\Users\AGUS\Desktop\TA\demo\posyandu-app\routes\web.php'
$routeContent = Get-Content $routePath -Raw
$routeContent = $routeContent.Replace("        Route::get('pemeriksaan-ibu-hamil/create', [PemeriksaanIbuHamilController::class, 'create'])->name('pemeriksaan-ibu-hamil.create');`r`n        Route::post('pemeriksaan-ibu-hamil', [PemeriksaanIbuHamilController::class, 'store'])->name('pemeriksaan-ibu-hamil.store');", "        Route::get('pemeriksaan-ibu-hamil/create', [PemeriksaanIbuHamilController::class, 'create'])->name('pemeriksaan-ibu-hamil.create');`r`n        Route::get('pemeriksaan-ibu-hamil/stage/{stage}', [PemeriksaanIbuHamilController::class, 'stage'])->name('pemeriksaan-ibu-hamil.stage');`r`n        Route::post('pemeriksaan-ibu-hamil/stage/{stage}', [PemeriksaanIbuHamilController::class, 'stageStore'])->name('pemeriksaan-ibu-hamil.stage-store');`r`n        Route::post('pemeriksaan-ibu-hamil', [PemeriksaanIbuHamilController::class, 'store'])->name('pemeriksaan-ibu-hamil.store');")
Set-Content -Path $routePath -Value $routeContent -NoNewline

$createPath = 'c:\Users\AGUS\Desktop\TA\demo\posyandu-app\resources\views\pemeriksaan\ibu-hamil\create.blade.php'
$createContent = @'
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Ibu Hamil - Sistem 4 Tahap</h2>
        <p class="text-gray-600 mt-1">Pilih tahap pemeriksaan yang ingin dilakukan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="hover:text-purple-600">Pemeriksaan Ibu Hamil</a>
            <span class="mx-2">/</span>
            <span>Tambah</span>
        </nav>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-5 mb-6">
        <p class="text-sm text-blue-900">
            Sistem dibagi menjadi 4 tahap. Data dari tahap sebelumnya akan ditampilkan saat melanjutkan ke tahap berikutnya.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-violet-500">
            <div class="p-6 bg-gradient-to-r from-violet-50 to-purple-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-violet-600 text-white flex items-center justify-center text-xl font-bold">1</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Penimbangan & Pengukuran</h3>
                        <p class="text-sm text-gray-600">Usia kehamilan, berat badan, LILA, status BB, status LILA</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-ibu-hamil.stage', 1) }}" class="block w-full text-center bg-violet-600 hover:bg-violet-700 text-white font-semibold py-3 rounded-xl transition">Mulai Tahap 1</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-blue-500">
            <div class="p-6 bg-gradient-to-r from-blue-50 to-cyan-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xl font-bold">2</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Pemeriksaan</h3>
                        <p class="text-sm text-gray-600">Tekanan darah, status tekanan darah, skrining TBC</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-ibu-hamil.stage', 2) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">Mulai Tahap 2</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-emerald-500">
            <div class="p-6 bg-gradient-to-r from-emerald-50 to-green-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xl font-bold">3</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Pelayanan Kesehatan</h3>
                        <p class="text-sm text-gray-600">Tablet tambah darah, PMT bumil, kelas ibu hamil</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-ibu-hamil.stage', 3) }}" class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl transition">Mulai Tahap 3</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-orange-500">
            <div class="p-6 bg-gradient-to-r from-orange-50 to-amber-50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-600 text-white flex items-center justify-center text-xl font-bold">4</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Edukasi & Rujukan</h3>
                        <p class="text-sm text-gray-600">Ringkasan semua tahap + simpan final</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <a href="{{ route('pemeriksaan-ibu-hamil.stage', 4) }}" class="block w-full text-center bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 rounded-xl transition">Mulai Tahap 4</a>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 font-medium">
            <i class="fas fa-arrow-left"></i>
            Kembali ke daftar pemeriksaan
        </a>
    </div>
</div>
@endsection
'@
Set-Content -Path $createPath -Value $createContent -NoNewline