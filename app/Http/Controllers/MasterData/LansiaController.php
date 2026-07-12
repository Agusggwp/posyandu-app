<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;

use App\Models\Lansia;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class LansiaController extends Controller
{
    public function index()
    {
        $lansias = Lansia::with('keluarga')->latest()->paginate(10);
        return view('master-data.lansia.index', compact('lansias'));
    }

    public function create()
    {
        $keluargas = Keluarga::latest()->get();
        return view('master-data.lansia.create', compact('keluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16|unique:dewasa_identitas,nik',
            'tanggal_lahir' => 'required|date',
            'umur' => 'nullable|integer|min:0',
            'no_hp' => 'nullable|string|max:20',
            'status_perkawinan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'riwayat_keluarga' => 'nullable|string',
            'riwayat_diri' => 'nullable|string',
            'merokok' => 'nullable|string|max:5',
            'konsumsi_gula' => 'nullable|string|max:5',
            'konsumsi_garam' => 'nullable|string|max:5',
            'konsumsi_lemak' => 'nullable|string|max:5',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        if (empty($validated['umur']) && ! empty($validated['tanggal_lahir'])) {
            $validated['umur'] = Carbon::parse($validated['tanggal_lahir'])->age;
        }

        Lansia::create($validated);
        return redirect()->route('lansia.index')->with('success', 'Data lansia berhasil ditambahkan');
    }

    public function show(Lansia $lansia)
    {
        $lansia->load('keluarga', 'pemeriksaans');
        return view('master-data.lansia.show', compact('lansia'));
    }

    public function edit(Lansia $lansia)
    {
        $keluargas = Keluarga::latest()->get();
        return view('master-data.lansia.edit', compact('lansia', 'keluargas'));
    }

    public function update(Request $request, Lansia $lansia)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama' => 'required|string|max:255',
            'nik' => ['nullable', 'string', 'max:16', Rule::unique('dewasa_identitas', 'nik')->ignore($lansia->id)],
            'tanggal_lahir' => 'required|date',
            'umur' => 'nullable|integer|min:0',
            'no_hp' => 'nullable|string|max:20',
            'status_perkawinan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'riwayat_keluarga' => 'nullable|string',
            'riwayat_diri' => 'nullable|string',
            'merokok' => 'nullable|string|max:5',
            'konsumsi_gula' => 'nullable|string|max:5',
            'konsumsi_garam' => 'nullable|string|max:5',
            'konsumsi_lemak' => 'nullable|string|max:5',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        if (empty($validated['umur']) && ! empty($validated['tanggal_lahir'])) {
            $validated['umur'] = Carbon::parse($validated['tanggal_lahir'])->age;
        }

        $lansia->update($validated);
        return redirect()->route('lansia.index')->with('success', 'Data lansia berhasil diperbarui');
    }

    public function destroy(Lansia $lansia)
    {
        $lansia->delete();
        return redirect()->route('lansia.index')->with('success', 'Data lansia berhasil dihapus');
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $lansias = Lansia::with('keluarga')
            ->where(function ($q) use ($query) {
                $q->where('nama', 'like', "%{$query}%")
                    ->orWhere('nik', 'like', "%{$query}%")
                    ->orWhereHas('keluarga', function ($kq) use ($query) {
                        $kq->where('nama_lengkap', 'like', "%{$query}%")
                            ->orWhere('no_kk', 'like', "%{$query}%");
                    });
            })
            ->take(10)
            ->get();

        return response()->json($lansias->map(function ($lansia) {
            return [
                'id' => $lansia->id,
                'nik' => $lansia->nik,
                'nama' => $lansia->nama,
                'jenis_kelamin' => $lansia->jenis_kelamin,
                'umur' => \Carbon\Carbon::parse($lansia->tanggal_lahir)->age,
                'keluarga' => $lansia->keluarga->nama_kepala_keluarga ?? '-',
            ];
        }));
    }

    public function exportExcel()
    {
        $lansias = Lansia::with('keluarga')->orderBy('nama', 'asc')->get();
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data_lansia_' . date('Ymd_His') . '.csv"',
        ];

        return response()->streamDownload(function() use ($lansias) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            
            fputcsv($handle, [
                'No KK', 'NIK', 'Nama', 'Tanggal Lahir', 'Umur', 'No HP', 
                'Status Perkawinan', 'Pekerjaan', 'Riwayat Keluarga', 'Riwayat Diri', 
                'Merokok', 'Konsumsi Gula', 'Konsumsi Garam', 'Konsumsi Lemak'
            ]);

            foreach ($lansias as $lansia) {
                fputcsv($handle, [
                    $lansia->keluarga->no_kk ?? '',
                    $lansia->nik,
                    $lansia->nama,
                    $lansia->tanggal_lahir ? $lansia->tanggal_lahir->format('Y-m-d') : '',
                    $lansia->umur,
                    $lansia->no_hp,
                    $lansia->status_perkawinan,
                    $lansia->pekerjaan,
                    $lansia->riwayat_keluarga,
                    $lansia->riwayat_diri,
                    $lansia->merokok,
                    $lansia->konsumsi_gula,
                    $lansia->konsumsi_garam,
                    $lansia->konsumsi_lemak
                ]);
            }
            fclose($handle);
        }, 'data_lansia_' . date('Ymd_His') . '.csv', $headers);
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_lansia.csv"',
        ];

        return response()->streamDownload(function() {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'No KK', 'NIK', 'Nama', 'Tanggal Lahir', 'Umur', 'No HP', 
                'Status Perkawinan', 'Pekerjaan', 'Riwayat Keluarga', 'Riwayat Diri', 
                'Merokok', 'Konsumsi Gula', 'Konsumsi Garam', 'Konsumsi Lemak'
            ]);
            fputcsv($handle, [
                '3201234567890123', '3201234567890127', 'Jane Doe Sr', '1960-08-20', '65', '08123456789', 
                'Kawin', 'Pensiunan', 'Tidak ada', 'Hipertensi', 
                'Tidak', 'Tidak', 'Ya', 'Tidak'
            ]);
            fclose($handle);
        }, 'template_import_lansia.csv', $headers);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        
        $handle = fopen($path, 'r');
        if (!$handle) {
            return back()->with('error', 'Gagal membuka file');
        }

        $firstLine = fgets($handle);
        $delimiter = ',';
        if (strpos($firstLine, ';') !== false && strpos($firstLine, ',') === false) {
            $delimiter = ';';
        }
        rewind($handle);

        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle, 1000, $delimiter);
        if (!$header) {
            fclose($handle);
            return back()->with('error', 'File template kosong');
        }

        $header = array_map(function($h) {
            return strtolower(trim(str_replace([' ', '.', '(', ')'], ['', '', '', ''], $h)));
        }, $header);

        $successCount = 0;
        $rowNumber = 1;

        \DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $rowNumber++;
                if (count(array_filter($row)) === 0) {
                    continue;
                }

                if (count($row) < count($header)) {
                    $row = array_pad($row, count($header), '');
                } elseif (count($row) > count($header)) {
                    $row = array_slice($row, 0, count($header));
                }

                $data = array_combine($header, $row);

                $mapped = [
                    'no_kk' => $data['nokk'] ?? '',
                    'nik' => $data['nik'] ?? '',
                    'nama' => $data['nama'] ?? '',
                    'tanggal_lahir' => $data['tanggallahir'] ?? '',
                    'umur' => $data['umur'] ?? '',
                    'no_hp' => $data['nohp'] ?? ($data['no_telepon'] ?? ''),
                    'status_perkawinan' => $data['statusperkawinan'] ?? '',
                    'pekerjaan' => $data['pekerjaan'] ?? '',
                    'riwayat_keluarga' => $data['riwayatkeluarga'] ?? '',
                    'riwayat_diri' => $data['riwayatdiri'] ?? ($data['riwayatpenyakit'] ?? ''),
                    'merokok' => $data['merokok'] ?? 'Tidak',
                    'konsumsi_gula' => $data['konsumsigula'] ?? 'Tidak',
                    'konsumsi_garam' => $data['konsumsigaram'] ?? 'Tidak',
                    'konsumsi_lemak' => $data['konsumsilemak'] ?? 'Tidak',
                ];

                // Validate row structure
                $validator = \Validator::make($mapped, [
                    'no_kk' => 'required|string',
                    'nama' => 'required|string|max:255',
                    'tanggal_lahir' => 'required|date_format:Y-m-d',
                ]);

                if ($validator->fails()) {
                    throw new \Exception("Baris {$rowNumber}: " . implode(', ', $validator->errors()->all()));
                }

                // Check Keluarga
                $keluarga = Keluarga::where('no_kk', $mapped['no_kk'])->first();
                if (!$keluarga) {
                    throw new \Exception("Baris {$rowNumber}: Nomor KK '{$mapped['no_kk']}' tidak terdaftar.");
                }

                $mapped['kepala_keluarga_id'] = $keluarga->id;

                if (empty($mapped['umur'])) {
                    $mapped['umur'] = \Carbon\Carbon::parse($mapped['tanggal_lahir'])->age;
                }

                // Check uniqueness or update
                $lansia = null;
                if (!empty($mapped['nik'])) {
                    $lansia = Lansia::where('nik', $mapped['nik'])->first();
                }

                if (!$lansia) {
                    // Match by name and birthdate under the same family
                    $lansia = Lansia::where('kepala_keluarga_id', $keluarga->id)
                        ->where('nama', $mapped['nama'])
                        ->where('tanggal_lahir', $mapped['tanggal_lahir'])
                        ->first();
                }

                if ($lansia) {
                    // Check duplicate NIK if NIK changes
                    if (!empty($mapped['nik']) && $mapped['nik'] !== $lansia->nik) {
                        if (Lansia::where('nik', $mapped['nik'])->exists()) {
                            throw new \Exception("Baris {$rowNumber}: NIK '{$mapped['nik']}' sudah digunakan lansia lain.");
                        }
                    }
                    $lansia->update($mapped);
                } else {
                    // Create new
                    if (!empty($mapped['nik']) && Lansia::where('nik', $mapped['nik'])->exists()) {
                        throw new \Exception("Baris {$rowNumber}: NIK '{$mapped['nik']}' sudah terdaftar.");
                    }
                    Lansia::create($mapped);
                }

                $successCount++;
            }
            \DB::commit();
            fclose($handle);
            if ($request->ajax()) {
                session()->flash('success', "Berhasil mengimpor {$successCount} data lansia.");
                return response()->json(['success' => true]);
            }
            return back()->with('success', "Berhasil mengimpor {$successCount} data lansia.");
        } catch (\Exception $e) {
            \DB::rollBack();
            fclose($handle);
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->with('error', 'Gagal mengimpor data. ' . $e->getMessage());
        }
    }
}
