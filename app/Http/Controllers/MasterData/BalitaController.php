<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;

use App\Models\Balita;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BalitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $balitas = Balita::with('keluarga')->latest()->paginate(10);
        return view('master-data.balita.index', compact('balitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $keluargas = Keluarga::latest()->get();
        return view('master-data.balita.create', compact('keluargas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama_bayi' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16|unique:balita_identitas,nik',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'berat_badan_lahir' => 'nullable|numeric|min:0',
            'panjang_badan_lahir' => 'nullable|numeric|min:0',
            'nama_ortu' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        Balita::create($validated);
        return redirect()->route('balita.index')->with('success', 'Data balita berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Balita $balita)
    {
        $balita->load('keluarga', 'pemeriksaans');
        return view('master-data.balita.show', compact('balita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Balita $balita)
    {
        $keluargas = Keluarga::latest()->get();
        return view('master-data.balita.edit', compact('balita', 'keluargas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Balita $balita)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama_bayi' => 'required|string|max:255',
            'nik' => ['nullable', 'string', 'max:16', Rule::unique('balita_identitas', 'nik')->ignore($balita->id)],
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'berat_badan_lahir' => 'nullable|numeric|min:0',
            'panjang_badan_lahir' => 'nullable|numeric|min:0',
            'nama_ortu' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        $balita->update($validated);
        return redirect()->route('balita.index')->with('success', 'Data balita berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Balita $balita)
    {
        $balita->delete();
        return redirect()->route('balita.index')->with('success', 'Data balita berhasil dihapus');
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $balitas = Balita::with('keluarga')
            ->where(function ($q) use ($query) {
                $q->where('nama_bayi', 'like', "%{$query}%")
                    ->orWhere('nik', 'like', "%{$query}%")
                    ->orWhereHas('keluarga', function ($kq) use ($query) {
                        $kq->where('nama_lengkap', 'like', "%{$query}%")
                            ->orWhere('no_kk', 'like', "%{$query}%");
                    });
            })
            ->take(10)
            ->get();

        return response()->json($balitas->map(function ($balita) {
            return [
                'id' => $balita->id,
                'nik' => $balita->nik,
                'nama' => $balita->nama_bayi,
                'jenis_kelamin' => $balita->jenis_kelamin,
                'umur' => \Carbon\Carbon::parse($balita->tanggal_lahir)->age,
                'keluarga' => $balita->keluarga->nama_kepala_keluarga ?? '-',
            ];
        }));
    }

    public function exportExcel()
    {
        $balitas = Balita::with('keluarga')->orderBy('nama_bayi', 'asc')->get();
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data_balita_' . date('Ymd_His') . '.csv"',
        ];

        return response()->streamDownload(function() use ($balitas) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            
            fputcsv($handle, [
                'No KK', 'NIK', 'Nama Bayi', 'Jenis Kelamin', 'Tanggal Lahir', 
                'Berat Badan Lahir (kg)', 'Panjang Badan Lahir (cm)', 'Nama Ortu', 'No HP'
            ]);

            foreach ($balitas as $balita) {
                fputcsv($handle, [
                    $balita->keluarga->no_kk ?? '',
                    $balita->nik,
                    $balita->nama_bayi,
                    $balita->jenis_kelamin,
                    $balita->tanggal_lahir ? $balita->tanggal_lahir->format('Y-m-d') : '',
                    $balita->berat_badan_lahir,
                    $balita->panjang_badan_lahir,
                    $balita->nama_ortu,
                    $balita->no_hp
                ]);
            }
            fclose($handle);
        }, 'data_balita_' . date('Ymd_His') . '.csv', $headers);
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_balita.csv"',
        ];

        return response()->streamDownload(function() {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'No KK', 'NIK', 'Nama Bayi', 'Jenis Kelamin', 'Tanggal Lahir', 
                'Berat Badan Lahir (kg)', 'Panjang Badan Lahir (cm)', 'Nama Ortu', 'No HP'
            ]);
            fputcsv($handle, [
                '3201234567890123', '3201234567890125', 'Baby Doe', 'L', '2024-01-15', 
                '3.2', '49', 'John Doe', '08123456789'
            ]);
            fclose($handle);
        }, 'template_import_balita.csv', $headers);
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
                    'nama_bayi' => $data['namabayi'] ?? ($data['nama'] ?? ''),
                    'jenis_kelamin' => strtoupper($data['jeniskelamin'] ?? ($data['jk'] ?? '')),
                    'tanggal_lahir' => $data['tanggallahir'] ?? '',
                    'berat_badan_lahir' => $data['beratbadanlahirkg'] ?? ($data['beratbadanlahir'] ?? null),
                    'panjang_badan_lahir' => $data['panjangbadanlahircm'] ?? ($data['panjangbadanlahir'] ?? null),
                    'nama_ortu' => $data['namaortu'] ?? '',
                    'no_hp' => $data['nohp'] ?? '',
                ];

                // Validate row structure
                $validator = \Validator::make($mapped, [
                    'no_kk' => 'required|string',
                    'nama_bayi' => 'required|string|max:255',
                    'jenis_kelamin' => 'required|in:L,P',
                    'tanggal_lahir' => 'required|date_format:Y-m-d',
                    'berat_badan_lahir' => 'nullable|numeric|min:0',
                    'panjang_badan_lahir' => 'nullable|numeric|min:0',
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
                $mapped['alamat'] = $keluarga->alamat ?? null;

                // Check uniqueness or update
                $balita = null;
                if (!empty($mapped['nik'])) {
                    $balita = Balita::where('nik', $mapped['nik'])->first();
                }

                if (!$balita) {
                    // Match by name and birthdate under the same family
                    $balita = Balita::where('kepala_keluarga_id', $keluarga->id)
                        ->where('nama_bayi', $mapped['nama_bayi'])
                        ->where('tanggal_lahir', $mapped['tanggal_lahir'])
                        ->first();
                }

                if ($balita) {
                    // Check duplicate NIK if NIK changes
                    if (!empty($mapped['nik']) && $mapped['nik'] !== $balita->nik) {
                        if (Balita::where('nik', $mapped['nik'])->exists()) {
                            throw new \Exception("Baris {$rowNumber}: NIK '{$mapped['nik']}' sudah digunakan balita lain.");
                        }
                    }
                    $balita->update($mapped);
                } else {
                    // Create new
                    if (!empty($mapped['nik']) && Balita::where('nik', $mapped['nik'])->exists()) {
                        throw new \Exception("Baris {$rowNumber}: NIK '{$mapped['nik']}' sudah terdaftar.");
                    }
                    Balita::create($mapped);
                }

                $successCount++;
            }
            \DB::commit();
            fclose($handle);
            if ($request->ajax()) {
                session()->flash('success', "Berhasil mengimpor {$successCount} data balita.");
                return response()->json(['success' => true]);
            }
            return back()->with('success', "Berhasil mengimpor {$successCount} data balita.");
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
