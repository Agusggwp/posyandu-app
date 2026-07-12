<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;

use App\Models\IbuHamil;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class IbuHamilController extends Controller
{
    public function index()
    {
        $ibuHamils = IbuHamil::with('keluarga')->latest()->paginate(10);
        return view('master-data.ibu-hamil.index', compact('ibuHamils'));
    }

    public function create()
    {
        $keluargas = Keluarga::latest()->get();
        return view('master-data.ibu-hamil.create', compact('keluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nik' => 'nullable|string|max:16|unique:ibu_hamil_identitas,nik',
            'nama_ibu' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'nullable|integer|min:0',
            'nama_suami' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'l_ibu_hamil' => 'nullable|string|max:50',
            'kehamilan_ke' => 'nullable|integer|min:1',
            'hamil_ke' => 'nullable|integer|min:1',
            'jarak_anak_sebelumnya' => 'nullable|string|max:50',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        if (empty($validated['umur']) && ! empty($validated['tanggal_lahir'])) {
            $validated['umur'] = Carbon::parse($validated['tanggal_lahir'])->age;
        }

        if (empty($validated['kehamilan_ke']) && ! empty($validated['hamil_ke'])) {
            $validated['kehamilan_ke'] = $validated['hamil_ke'];
        }

        unset($validated['hamil_ke']);

        IbuHamil::create($validated);
        return redirect()->route('ibu-hamil.index')->with('success', 'Data ibu hamil berhasil ditambahkan');
    }

    public function show(IbuHamil $ibuHamil)
    {
        $ibuHamil->load('keluarga', 'pemeriksaans');
        return view('master-data.ibu-hamil.show', compact('ibuHamil'));
    }

    public function edit(IbuHamil $ibuHamil)
    {
        $keluargas = Keluarga::latest()->get();
        return view('master-data.ibu-hamil.edit', compact('ibuHamil', 'keluargas'));
    }

    public function update(Request $request, IbuHamil $ibuHamil)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nik' => ['nullable', 'string', 'max:16', Rule::unique('ibu_hamil_identitas', 'nik')->ignore($ibuHamil->id)],
            'nama_ibu' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'nullable|integer|min:0',
            'nama_suami' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'l_ibu_hamil' => 'nullable|string|max:50',
            'kehamilan_ke' => 'nullable|integer|min:1',
            'hamil_ke' => 'nullable|integer|min:1',
            'jarak_anak_sebelumnya' => 'nullable|string|max:50',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        if (empty($validated['umur']) && ! empty($validated['tanggal_lahir'])) {
            $validated['umur'] = Carbon::parse($validated['tanggal_lahir'])->age;
        }

        if (empty($validated['kehamilan_ke']) && ! empty($validated['hamil_ke'])) {
            $validated['kehamilan_ke'] = $validated['hamil_ke'];
        }

        unset($validated['hamil_ke']);

        $ibuHamil->update($validated);
        return redirect()->route('ibu-hamil.index')->with('success', 'Data ibu hamil berhasil diperbarui');
    }

    public function destroy(IbuHamil $ibuHamil)
    {
        $ibuHamil->delete();
        return redirect()->route('ibu-hamil.index')->with('success', 'Data ibu hamil berhasil dihapus');
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $ibuHamils = IbuHamil::with('keluarga')
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

        return response()->json($ibuHamils->map(function ($ibuHamil) {
            return [
                'id' => $ibuHamil->id,
                'nik' => $ibuHamil->nik,
                'nama' => $ibuHamil->nama_ibu,
                'keluarga' => $ibuHamil->keluarga->nama_kepala_keluarga ?? '-',
            ];
        }));
    }

    public function exportExcel()
    {
        $ibuHamils = IbuHamil::with('keluarga')->orderBy('nama_ibu', 'asc')->get();
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data_ibu_hamil_' . date('Ymd_His') . '.csv"',
        ];

        return response()->streamDownload(function() use ($ibuHamils) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            
            fputcsv($handle, [
                'No KK', 'NIK', 'Nama Ibu', 'Tanggal Lahir', 'Umur', 
                'Nama Suami', 'No HP', 'L Ibu Hamil', 'Kehamilan Ke', 'Jarak Anak Sebelumnya'
            ]);

            foreach ($ibuHamils as $ibuHamil) {
                fputcsv($handle, [
                    $ibuHamil->keluarga->no_kk ?? '',
                    $ibuHamil->nik,
                    $ibuHamil->nama_ibu,
                    $ibuHamil->tanggal_lahir ? $ibuHamil->tanggal_lahir->format('Y-m-d') : '',
                    $ibuHamil->umur,
                    $ibuHamil->nama_suami,
                    $ibuHamil->no_hp,
                    $ibuHamil->l_ibu_hamil,
                    $ibuHamil->kehamilan_ke,
                    $ibuHamil->jarak_anak_sebelumnya
                ]);
            }
            fclose($handle);
        }, 'data_ibu_hamil_' . date('Ymd_His') . '.csv', $headers);
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_ibu_hamil.csv"',
        ];

        return response()->streamDownload(function() {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'No KK', 'NIK', 'Nama Ibu', 'Tanggal Lahir', 'Umur', 
                'Nama Suami', 'No HP', 'L Ibu Hamil', 'Kehamilan Ke', 'Jarak Anak Sebelumnya'
            ]);
            fputcsv($handle, [
                '3201234567890123', '3201234567890126', 'Jane Doe', '1995-05-10', '31', 
                'John Doe', '08123456789', '23.5', '2', '2 tahun'
            ]);
            fclose($handle);
        }, 'template_import_ibu_hamil.csv', $headers);
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
                    'nama_ibu' => $data['namaibu'] ?? ($data['nama'] ?? ''),
                    'tanggal_lahir' => $data['tanggallahir'] ?? '',
                    'umur' => $data['umur'] ?? '',
                    'nama_suami' => $data['namasuami'] ?? '',
                    'no_hp' => $data['nohp'] ?? '',
                    'l_ibu_hamil' => $data['libuhamil'] ?? null,
                    'kehamilan_ke' => $data['kehamilanke'] ?? null,
                    'jarak_anak_sebelumnya' => $data['jarakanaksebelumnya'] ?? '',
                ];

                // Validate row structure
                $validator = \Validator::make($mapped, [
                    'no_kk' => 'required|string',
                    'nama_ibu' => 'required|string|max:255',
                    'tanggal_lahir' => 'required|date_format:Y-m-d',
                    'kehamilan_ke' => 'nullable|integer',
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
                $ibuHamil = null;
                if (!empty($mapped['nik'])) {
                    $ibuHamil = IbuHamil::where('nik', $mapped['nik'])->first();
                }

                if (!$ibuHamil) {
                    // Match by name and birthdate under the same family
                    $ibuHamil = IbuHamil::where('kepala_keluarga_id', $keluarga->id)
                        ->where('nama_ibu', $mapped['nama_ibu'])
                        ->where('tanggal_lahir', $mapped['tanggal_lahir'])
                        ->first();
                }

                if ($ibuHamil) {
                    // Check duplicate NIK if NIK changes
                    if (!empty($mapped['nik']) && $mapped['nik'] !== $ibuHamil->nik) {
                        if (IbuHamil::where('nik', $mapped['nik'])->exists()) {
                            throw new \Exception("Baris {$rowNumber}: NIK '{$mapped['nik']}' sudah digunakan ibu hamil lain.");
                        }
                    }
                    $ibuHamil->update($mapped);
                } else {
                    // Create new
                    if (!empty($mapped['nik']) && IbuHamil::where('nik', $mapped['nik'])->exists()) {
                        throw new \Exception("Baris {$rowNumber}: NIK '{$mapped['nik']}' sudah terdaftar.");
                    }
                    IbuHamil::create($mapped);
                }

                $successCount++;
            }
            \DB::commit();
            fclose($handle);
            if ($request->ajax()) {
                session()->flash('success', "Berhasil mengimpor {$successCount} data ibu hamil.");
                return response()->json(['success' => true]);
            }
            return back()->with('success', "Berhasil mengimpor {$successCount} data ibu hamil.");
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
