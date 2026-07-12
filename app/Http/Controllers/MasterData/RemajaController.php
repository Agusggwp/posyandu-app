<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;

use App\Models\Keluarga;
use App\Models\Remaja;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RemajaController extends Controller
{
    public function index()
    {
        $remajas = Remaja::with('keluarga')->latest()->paginate(10);
        return view('master-data.remaja.index', compact('remajas'));
    }

    public function create()
    {
        $keluargas = Keluarga::latest()->get();
        return view('master-data.remaja.create', compact('keluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama_anak' => 'required|string|max:100',
            'nik' => 'nullable|string|max:50|unique:remaja_identitas,nik',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ortu' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'riwayat_keluarga' => 'nullable|string',
            'riwayat_diri' => 'nullable|string',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        Remaja::create($validated);

        return redirect()->route('remaja.index')->with('success', 'Data remaja berhasil ditambahkan');
    }

    public function show(Remaja $remaja)
    {
        $remaja->load('keluarga');
        return view('master-data.remaja.show', compact('remaja'));
    }

    public function edit(Remaja $remaja)
    {
        $keluargas = Keluarga::latest()->get();
        return view('master-data.remaja.edit', compact('remaja', 'keluargas'));
    }

    public function update(Request $request, Remaja $remaja)
    {
        $validated = $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluarga,id',
            'nama_anak' => 'required|string|max:100',
            'nik' => ['nullable', 'string', 'max:50', Rule::unique('remaja_identitas', 'nik')->ignore($remaja->id)],
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ortu' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'riwayat_keluarga' => 'nullable|string',
            'riwayat_diri' => 'nullable|string',
        ]);

        $keluarga = Keluarga::find($validated['kepala_keluarga_id']);
        $validated['alamat'] = $keluarga->alamat ?? null;

        $remaja->update($validated);

        return redirect()->route('remaja.index')->with('success', 'Data remaja berhasil diperbarui');
    }

    public function destroy(Remaja $remaja)
    {
        $remaja->delete();
        return redirect()->route('remaja.index')->with('success', 'Data remaja berhasil dihapus');
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $remajas = Remaja::with('keluarga')
            ->where(function ($q) use ($query) {
                $q->where('nama_anak', 'like', "%{$query}%")
                    ->orWhere('nik', 'like', "%{$query}%")
                    ->orWhereHas('keluarga', function ($kq) use ($query) {
                        $kq->where('nama_lengkap', 'like', "%{$query}%")
                            ->orWhere('no_kk', 'like', "%{$query}%");
                    });
            })
            ->take(10)
            ->get();

        return response()->json($remajas->map(function ($remaja) {
            return [
                'id' => $remaja->id,
                'nik' => $remaja->nik,
                'nama' => $remaja->nama_anak,
                'jenis_kelamin' => $remaja->jenis_kelamin,
                'keluarga' => $remaja->keluarga->nama_kepala_keluarga ?? '-',
            ];
        }));
    }

    public function exportExcel()
    {
        $remajas = Remaja::with('keluarga')->orderBy('nama_anak', 'asc')->get();
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data_remaja_' . date('Ymd_His') . '.csv"',
        ];

        return response()->streamDownload(function() use ($remajas) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            
            fputcsv($handle, [
                'No KK', 'NIK', 'Nama Anak', 'Tanggal Lahir', 'Jenis Kelamin', 'Nama Ortu', 'No HP', 'Riwayat Keluarga', 'Riwayat Diri'
            ]);

            foreach ($remajas as $remaja) {
                fputcsv($handle, [
                    $remaja->keluarga->no_kk ?? '',
                    $remaja->nik,
                    $remaja->nama_anak,
                    $remaja->tanggal_lahir ? $remaja->tanggal_lahir->format('Y-m-d') : '',
                    $remaja->jenis_kelamin,
                    $remaja->nama_ortu,
                    $remaja->no_hp,
                    $remaja->riwayat_keluarga,
                    $remaja->riwayat_diri
                ]);
            }
            fclose($handle);
        }, 'data_remaja_' . date('Ymd_His') . '.csv', $headers);
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_remaja.csv"',
        ];

        return response()->streamDownload(function() {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'No KK', 'NIK', 'Nama Anak', 'Tanggal Lahir', 'Jenis Kelamin', 'Nama Ortu', 'No HP', 'Riwayat Keluarga', 'Riwayat Diri'
            ]);
            fputcsv($handle, [
                '3201234567890123', '3201234567890129', 'Jane Doe Jr Jr', '2012-04-18', 'P', 'John Doe', 
                '08123456789', 'Tidak ada', 'Asma'
            ]);
            fclose($handle);
        }, 'template_import_remaja.csv', $headers);
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
                    'nama_anak' => $data['namaanak'] ?? ($data['nama'] ?? ''),
                    'tanggal_lahir' => $data['tanggallahir'] ?? '',
                    'jenis_kelamin' => strtoupper($data['jeniskelamin'] ?? ($data['jk'] ?? '')),
                    'nama_ortu' => $data['namaortu'] ?? '',
                    'no_hp' => $data['nohp'] ?? '',
                    'riwayat_keluarga' => $data['riwayatkeluarga'] ?? '',
                    'riwayat_diri' => $data['riwayatdiri'] ?? ($data['riwayatpenyakit'] ?? ''),
                ];

                // Validate row structure
                $validator = \Validator::make($mapped, [
                    'no_kk' => 'required|string',
                    'nama_anak' => 'required|string|max:255',
                    'jenis_kelamin' => 'required|in:L,P',
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

                // Check uniqueness or update
                $remaja = null;
                if (!empty($mapped['nik'])) {
                    $remaja = Remaja::where('nik', $mapped['nik'])->first();
                }

                if (!$remaja) {
                    // Match by name and birthdate under the same family
                    $remaja = Remaja::where('kepala_keluarga_id', $keluarga->id)
                        ->where('nama_anak', $mapped['nama_anak'])
                        ->where('tanggal_lahir', $mapped['tanggal_lahir'])
                        ->first();
                }

                if ($remaja) {
                    // Check duplicate NIK if NIK changes
                    if (!empty($mapped['nik']) && $mapped['nik'] !== $remaja->nik) {
                        if (Remaja::where('nik', $mapped['nik'])->exists()) {
                            throw new \Exception("Baris {$rowNumber}: NIK '{$mapped['nik']}' sudah digunakan remaja lain.");
                        }
                    }
                    $remaja->update($mapped);
                } else {
                    // Create new
                    if (!empty($mapped['nik']) && Remaja::where('nik', $mapped['nik'])->exists()) {
                        throw new \Exception("Baris {$rowNumber}: NIK '{$mapped['nik']}' sudah terdaftar.");
                    }
                    Remaja::create($mapped);
                }

                $successCount++;
            }
            \DB::commit();
            fclose($handle);
            if ($request->ajax()) {
                session()->flash('success', "Berhasil mengimpor {$successCount} data remaja.");
                return response()->json(['success' => true]);
            }
            return back()->with('success', "Berhasil mengimpor {$successCount} data remaja.");
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
