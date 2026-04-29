# Setup Guide: 4-Stage Ibu Hamil Examination System

## ✅ What's Already Done

1. **Database Migration** - Added 15 new fields for 4-stage system
2. **Model Update** - Updated PemeriksaanIbuHamil fillable array
3. **Stage Views Created**:
   - `stage1.blade.php` - Penimbangan & Pengukuran
   - `stage2.blade.php` - Pemeriksaan (shows Stage 1 summary)
   - `stage3.blade.php` - Pelayanan Kesehatan (shows Stages 1-2 summary)
   - `stage4.blade.php` - Edukasi & Rujukan (shows ALL data summary + final save)
   - `create-new.blade.php` - Stage selector interface

## 🔧 What Needs To Be Done

### Step 1: Update Controller
**File**: `app/Http/Controllers/Pemeriksaan/PemeriksaanIbuHamilController.php`

Find the line: `public function store(Request $request)`

**Add these 2 methods BEFORE the store() method:**

```php
public function stage(Request $request, $stage = 1)
{
    $stage = (int)$stage;
    if (!in_array($stage, [1, 2, 3, 4])) {
        return redirect()->route('pemeriksaan-ibu-hamil.create');
    }

    $ibuHamils = IbuHamil::orderBy('nama_ibu')->get();
    
    $sessionData = $request->session()->get('pemeriksaan_ibu_hamil_stage');
    
    $pemeriksaan = null;
    if ($request->has('pemeriksaan_id')) {
        $pemeriksaan = PemeriksaanIbuHamil::findOrFail($request->query('pemeriksaan_id'));
        if (!$sessionData) {
            $sessionData = $pemeriksaan->toArray();
        }
    }

    return view('pemeriksaan.ibu-hamil.stages.stage' . $stage, [
        'stage' => $stage,
        'ibuHamils' => $ibuHamils,
        'data' => $sessionData ?? [],
        'pemeriksaan' => $pemeriksaan
    ]);
}

public function stageStore(Request $request, $stage = 1)
{
    $stage = (int)$stage;
    if (!in_array($stage, [1, 2, 3, 4])) {
        return redirect()->route('pemeriksaan-ibu-hamil.create');
    }

    $rules = $this->getStageValidationRules($stage);
    $validated = $request->validate($rules);

    $sessionData = $request->session()->get('pemeriksaan_ibu_hamil_stage', []);
    $sessionData = array_merge($sessionData, $validated);
    $request->session()->put('pemeriksaan_ibu_hamil_stage', $sessionData);

    if ($stage < 4) {
        return redirect()->route('pemeriksaan-ibu-hamil.stage', $stage + 1);
    }

    $data = $request->session()->get('pemeriksaan_ibu_hamil_stage');
    $data['tahap_terakhir'] = 5;

    PemeriksaanIbuHamil::create($data);
    $request->session()->forget('pemeriksaan_ibu_hamil_stage');

    return redirect()->route('pemeriksaan-ibu-hamil.index')->with('success', 'Data pemeriksaan berhasil ditambahkan');
}
```

**Add this private method at the END of the class (before closing brace):**

```php
private function getStageValidationRules($stage)
{
    $baseRules = [
        'ibu_hamil_identitas_id' => 'required|exists:ibu_hamil_identitas,id',
        'tanggal_kunjungan' => 'required|date',
    ];

    return match($stage) {
        1 => array_merge($baseRules, [
            'usia_kehamilan' => 'nullable|integer|min:0|max:42',
            'berat_badan' => 'nullable|numeric|min:0',
            'lingkar_lengan' => 'nullable|numeric|min:0',
            'status_bb' => 'nullable|in:Naik,Tidak',
            'status_lila' => 'nullable|in:Hijau,Kuning,Merah',
        ]),
        2 => array_merge($baseRules, [
            'tekanan_darah' => 'nullable|string|max:255',
            'status_tekanan_darah' => 'nullable|in:Normal,Tinggi,Rendah',
            'tb_skrining_batuk' => 'nullable|boolean',
            'tb_skrining_demam' => 'nullable|boolean',
            'tb_skrining_bb_turun' => 'nullable|boolean',
            'tb_skrining_kontak' => 'nullable|boolean',
            'tb_skrining_hasil' => 'nullable|in:Ya,Tidak,Dirujuk',
        ]),
        3 => array_merge($baseRules, [
            'tablet_tambah_darah' => 'nullable|boolean',
            'pmt_bumil' => 'nullable|boolean',
            'kelas_ibu_hamil' => 'nullable|boolean',
        ]),
        4 => array_merge($baseRules, [
            'edukasi' => 'nullable|string|max:1000',
            'rujukan' => 'nullable|in:Pustu,Puskesmas,Rumah Sakit,Tidak',
            'denyut_jantung' => 'nullable|string|max:255',
            'kondisi_ibu' => 'nullable|string|max:255',
            'keluhan' => 'nullable|string|max:255',
            'waktu_ke_posyandu' => 'nullable|date_format:H:i',
            'petugas' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
        ]),
        default => $baseRules
    };
}
```

---

### Step 2: Add Routes
**File**: `routes/web.php`

Find this section (around line 124-125):
```php
Route::get('pemeriksaan-ibu-hamil/create', [PemeriksaanIbuHamilController::class, 'create'])->name('pemeriksaan-ibu-hamil.create');
Route::post('pemeriksaan-ibu-hamil', [PemeriksaanIbuHamilController::class, 'store'])->name('pemeriksaan-ibu-hamil.store');
```

**Add these 2 lines right after:**
```php
Route::get('pemeriksaan-ibu-hamil/stage/{stage}', [PemeriksaanIbuHamilController::class, 'stage'])->name('pemeriksaan-ibu-hamil.stage');
Route::post('pemeriksaan-ibu-hamil/stage/{stage}', [PemeriksaanIbuHamilController::class, 'stageStore'])->name('pemeriksaan-ibu-hamil.stage-store');
```

---

### Step 3: Update Create View
**Replace the content of**: `resources/views/pemeriksaan/ibu-hamil/create.blade.php`

Copy all content from: `resources/views/pemeriksaan/ibu-hamil/create-new.blade.php`

Then delete `create-new.blade.php`

---

## How It Works

1. User clicks "Tambah Pemeriksaan Ibu Hamil"
2. Sees 4 stage cards to choose from
3. Selects a stage → form loads with previous data (from session)
4. Fills form → saves to session + advances to next stage
5. Stage 4 shows summary of ALL previous stages
6. Final submit → saves complete record to database

## Session Management
- Data stored in: `$request->session()->get('pemeriksaan_ibu_hamil_stage')`
- Cleared after successful final save
- Each stage can be edited before final submission

## Database Field: `tahap_terakhir`
- 0 = Not started
- 1-4 = Last completed stage
- 5 = Completed (all 4 stages done)

