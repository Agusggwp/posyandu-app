<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;

use App\Models\Keluarga;
use App\Models\Nifas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class NifasController extends Controller
{
    public function index()
    {
        $nifases = Nifas::with('keluarga')->latest()->paginate(10);
        return view('master-data.nifas.index', compact('nifases'));
    }

    public function create()
    {
        $keluargas = Keluarga::latest()->get();
        return view('master-data.nifas.create', compact('keluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama_ibu' => 'required|string|max:100',
            'nik' => 'nullable|string|max:50|unique:nifas_identitas,nik',
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'nullable|integer|min:0',
            'nama_suami' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'dusun' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'tanggal_bersalin' => 'nullable|date',
            'tempat_bersalin' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer|min:1',
            'tinggi_badan_ibu' => 'nullable|numeric',
        ]);

        if (empty($validated['umur']) && !empty($validated['tanggal_lahir'])) {
            $validated['umur'] = Carbon::parse($validated['tanggal_lahir'])->age;
        }

        Nifas::create($validated);

        return redirect()->route('nifas.index')->with('success', 'Data nifas berhasil ditambahkan');
    }

    public function show(Nifas $nifas)
    {
        $nifas->load('keluarga');
        return view('master-data.nifas.show', compact('nifas'));
    }

    public function edit(Nifas $nifas)
    {
        $keluargas = Keluarga::latest()->get();
        return view('master-data.nifas.edit', compact('nifas', 'keluargas'));
    }

    public function update(Request $request, Nifas $nifas)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama_ibu' => 'required|string|max:100',
            'nik' => ['nullable', 'string', 'max:50', Rule::unique('nifas_identitas', 'nik')->ignore($nifas->id)],
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'nullable|integer|min:0',
            'nama_suami' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'dusun' => 'nullable|string|max:100',
            'desa' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'tanggal_bersalin' => 'nullable|date',
            'tempat_bersalin' => 'nullable|string|max:100',
            'anak_ke' => 'nullable|integer|min:1',
            'tinggi_badan_ibu' => 'nullable|numeric',
        ]);

        if (empty($validated['umur']) && !empty($validated['tanggal_lahir'])) {
            $validated['umur'] = Carbon::parse($validated['tanggal_lahir'])->age;
        }

        $nifas->update($validated);

        return redirect()->route('nifas.index')->with('success', 'Data nifas berhasil diperbarui');
    }

    public function destroy(Nifas $nifas)
    {
        $nifas->delete();
        return redirect()->route('nifas.index')->with('success', 'Data nifas berhasil dihapus');
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $nifases = Nifas::with('keluarga')
            ->where(function ($q) use ($query) {
                $q->where('nama_ibu', 'like', "%{$query}%")
                    ->orWhere('nik', 'like', "%{$query}%")
                    ->orWhereHas('keluarga', function ($kq) use ($query) {
                        $kq->where('nama_lengkap', 'like', "%{$query}%")
                            ->orWhere('no_kk', 'like', "%{$query}%");
                    });
            })
            ->take(10)
            ->get();

        return response()->json($nifases->map(function ($nifas) {
            return [
                'id' => $nifas->id,
                'nik' => $nifas->nik,
                'nama' => $nifas->nama_ibu,
                'keluarga' => $nifas->keluarga->nama_kepala_keluarga ?? '-',
            ];
        }));
    }

    public function exportExcel()
    {
        $nifases = Nifas::with('keluarga')->orderBy('nama_ibu', 'asc')->get();
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data_nifas_' . date('Ymd_His') . '.csv"',
        ];

        return response()->streamDownload(function() use ($nifases) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            
            fputcsv($handle, [
                'No KK', 'Nama Ibu', 'NIK', 'Tanggal Lahir', 'Umur', 'Nama Suami', 
                'No HP', 'Tanggal Bersalin', 'Tempat Bersalin', 'Anak Ke', 'Tinggi Badan Ibu (cm)'
            ]);

            foreach ($nifases as $nifas) {
                fputcsv($handle, [
                    $nifas->keluarga->no_kk ?? '',
                    $nifas->nama_ibu,
                    $nifas->nik,
                    $nifas->tanggal_lahir ? $nifas->tanggal_lahir->format('Y-m-d') : '',
                    $nifas->umur,
                    $nifas->nama_suami,
                    $nifas->no_hp,
                    $nifas->tanggal_bersalin ? $nifas->tanggal_bersalin->format('Y-m-d') : '',
                    $nifas->tempat_bersalin,
                    $nifas->anak_ke,
                    $nifas->tinggi_badan_ibu
                ]);
            }
            fclose($handle);
        }, 'data_nifas_' . date('Ymd_His') . '.csv', $headers);
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_nifas.csv"',
        ];

        return response()->streamDownload(function() {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'No KK', 'Nama Ibu', 'NIK', 'Tanggal Lahir', 'Umur', 'Nama Suami', 
                'No HP', 'Tanggal Bersalin', 'Tempat Bersalin', 'Anak Ke', 'Tinggi Badan Ibu (cm)'
            ]);
            fputcsv($handle, [
                '3201234567890123', 'Jane Doe Jr', '3201234567890128', '1996-03-12', '30', 'John Doe', 
                '08123456789', '2026-06-01', 'Puskesmas', '1', '158.5'
            ]);
            fclose($handle);
        }, 'template_import_nifas.csv', $headers);
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
                    'nama_ibu' => $data['namaibu'] ?? ($data['nama'] ?? ''),
                    'nik' => $data['nik'] ?? '',
                    'tanggal_lahir' => $data['tanggallahir'] ?? '',
                    'umur' => $data['umur'] ?? '',
                    'nama_suami' => $data['namasuami'] ?? '',
                    'no_hp' => $data['nohp'] ?? '',
                    'tanggal_bersalin' => $data['tanggalbersalin'] ?? null,
                    'tempat_bersalin' => $data['tempatbersalin'] ?? '',
                    'anak_ke' => $data['anakke'] ?? null,
                    'tinggi_badan_ibu' => $data['tinggibadanibucm'] ?? ($data['tinggibadanibu'] ?? null),
                ];

                // Validate row structure
                $validator = \Validator::make($mapped, [
                    'no_kk' => 'required|string',
                    'nama_ibu' => 'required|string|max:255',
                    'tanggal_lahir' => 'nullable|date_format:Y-m-d',
                    'tanggal_bersalin' => 'nullable|date_format:Y-m-d',
                    'anak_ke' => 'nullable|integer',
                    'tinggi_badan_ibu' => 'nullable|numeric|min:0',
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

                if (empty($mapped['umur']) && !empty($mapped['tanggal_lahir'])) {
                    $mapped['umur'] = \Carbon\Carbon::parse($mapped['tanggal_lahir'])->age;
                }

                // Check uniqueness or update
                $nifas = null;
                if (!empty($mapped['nik'])) {
                    $nifas = Nifas::where('nik', $mapped['nik'])->first();
                }

                if (!$nifas) {
                    // Match by name and birthdate under the same family
                    $nifas = Nifas::where('kepala_keluarga_id', $keluarga->id)
                        ->where('nama_ibu', $mapped['nama_ibu'])
                        ->first();
                }

                if ($nifas) {
                    // Check duplicate NIK if NIK changes
                    if (!empty($mapped['nik']) && $mapped['nik'] !== $nifas->nik) {
                        if (Nifas::where('nik', $mapped['nik'])->exists()) {
                            throw new \Exception("Baris {$rowNumber}: NIK '{$mapped['nik']}' sudah digunakan ibu nifas lain.");
                        }
                    }
                    $nifas->update($mapped);
                } else {
                    // Create new
                    if (!empty($mapped['nik']) && Nifas::where('nik', $mapped['nik'])->exists()) {
                        throw new \Exception("Baris {$rowNumber}: NIK '{$mapped['nik']}' sudah terdaftar.");
                    }
                    Nifas::create($mapped);
                }

                $successCount++;
            }
            \DB::commit();
            fclose($handle);
            if ($request->ajax()) {
                session()->flash('success', "Berhasil mengimpor {$successCount} data nifas.");
                return response()->json(['success' => true]);
            }
            return back()->with('success', "Berhasil mengimpor {$successCount} data nifas.");
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
