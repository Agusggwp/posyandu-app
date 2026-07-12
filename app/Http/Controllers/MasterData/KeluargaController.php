<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;

use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KeluargaController extends Controller
{
    public function index()
    {
        $keluargas = Keluarga::latest()->paginate(10);
        return view('master-data.keluarga.index', compact('keluargas'));
    }

    public function create()
    {
        return view('master-data.keluarga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|max:16|unique:kepala_keluarga,no_kk',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:kepala_keluarga,email',
            'password' => 'required|string|min:8',
            'no_nik' => 'nullable|string|max:16|unique:kepala_keluarga,no_nik',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = null;

        Keluarga::create($validated);
        return redirect()->route('keluarga.index')->with('success', 'Data keluarga berhasil ditambahkan');
    }

    public function show(Keluarga $keluarga)
    {
        $keluarga->load('balitas', 'ibuHamils', 'lansias');
        return view('master-data.keluarga.show', compact('keluarga'));
    }

    public function edit(Keluarga $keluarga)
    {
        return view('master-data.keluarga.edit', compact('keluarga'));
    }

    public function update(Request $request, Keluarga $keluarga)
    {
        $oldStatus = $keluarga->status;

        $validated = $request->validate([
            'no_kk' => ['required', 'string', 'max:16', Rule::unique('kepala_keluarga', 'no_kk')->ignore($keluarga->id)],
            'nama_lengkap' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('kepala_keluarga', 'email')->ignore($keluarga->id)],
            'password' => 'nullable|string|min:8',
            'no_nik' => ['nullable', 'string', 'max:16', Rule::unique('kepala_keluarga', 'no_nik')->ignore($keluarga->id)],
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|string|max:20',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $keluarga->update($validated);

        if ($oldStatus !== $keluarga->status) {
            Mail::send('emails.kepala-keluarga-status-updated', [
                'keluarga' => $keluarga->fresh(),
                'status' => $keluarga->status,
                'loginUrl' => route('kepala-keluarga.login'),
            ], function ($message) use ($keluarga) {
                $message->to($keluarga->email, $keluarga->nama_lengkap)
                    ->subject('Status Akun Kepala Keluarga Diperbarui');
            });
        }

        return redirect()->route('keluarga.index')->with('success', 'Data keluarga berhasil diperbarui');
    }

    public function destroy(Keluarga $keluarga)
    {
        $keluarga->delete();
        return redirect()->route('keluarga.index')->with('success', 'Data keluarga berhasil dihapus');
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $keluargas = Keluarga::where(function ($q) use ($query) {
            $q->where('nama_lengkap', 'like', "%{$query}%")
                ->orWhere('no_kk', 'like', "%{$query}%")
                ->orWhere('no_nik', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
        })
        ->take(10)
        ->get();

        return response()->json($keluargas->map(function ($keluarga) {
            return [
                'id' => $keluarga->id,
                'no_kk' => $keluarga->no_kk,
                'nama' => $keluarga->nama_lengkap,
                'email' => $keluarga->email,
                'status' => $keluarga->status,
            ];
        }));
    }

    public function exportExcel()
    {
        $keluargas = Keluarga::orderBy('no_kk', 'asc')->get();
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="data_kepala_keluarga_' . date('Ymd_His') . '.csv"',
        ];

        return response()->streamDownload(function() use ($keluargas) {
            $handle = fopen('php://output', 'w');
            // Write BOM for Excel UTF-8 compatibility
            fwrite($handle, "\xEF\xBB\xBF");
            
            // Header
            fputcsv($handle, ['No KK', 'No NIK', 'Nama Lengkap', 'Email', 'Alamat', 'No Telepon', 'Status']);

            foreach ($keluargas as $keluarga) {
                fputcsv($handle, [
                    $keluarga->no_kk,
                    $keluarga->no_nik,
                    $keluarga->nama_lengkap,
                    $keluarga->email,
                    $keluarga->alamat,
                    $keluarga->no_telepon,
                    $keluarga->status
                ]);
            }
            fclose($handle);
        }, 'data_kepala_keluarga_' . date('Ymd_His') . '.csv', $headers);
    }

    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_keluarga.csv"',
        ];

        return response()->streamDownload(function() {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['No KK', 'No NIK', 'Nama Lengkap', 'Email', 'Alamat', 'No Telepon']);
            fputcsv($handle, ['3201234567890123', '3201234567890124', 'John Doe', 'john.doe@example.com', 'Jl. Posyandu No. 1', '08123456789']);
            fclose($handle);
        }, 'template_import_keluarga.csv', $headers);
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

        // Detect separator
        $firstLine = fgets($handle);
        $delimiter = ',';
        if (strpos($firstLine, ';') !== false && strpos($firstLine, ',') === false) {
            $delimiter = ';';
        }
        rewind($handle);

        // Skip BOM if present
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
            return strtolower(trim(str_replace([' ', '.'], ['', ''], $h)));
        }, $header);

        $successCount = 0;
        $rowNumber = 1;

        \DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $rowNumber++;
                // Skip empty rows
                if (count(array_filter($row)) === 0) {
                    continue;
                }

                if (count($row) < count($header)) {
                    $row = array_pad($row, count($header), '');
                } elseif (count($row) > count($header)) {
                    $row = array_slice($row, 0, count($header));
                }

                $data = array_combine($header, $row);

                // Map header variations to database fields
                $mapped = [
                    'no_kk' => $data['nokk'] ?? ($data['no_kk'] ?? ''),
                    'no_nik' => $data['nonik'] ?? ($data['no_nik'] ?? ($data['nik'] ?? '')),
                    'nama_lengkap' => $data['namalengkap'] ?? ($data['nama_lengkap'] ?? ($data['nama'] ?? '')),
                    'email' => $data['email'] ?? '',
                    'alamat' => $data['alamat'] ?? '',
                    'no_telepon' => $data['notelepon'] ?? ($data['no_telepon'] ?? ($data['telepon'] ?? ($data['no_hp'] ?? ''))),
                    'status' => 'approved',
                ];

                // Validate row
                $validator = \Validator::make($mapped, [
                    'no_kk' => 'required|string|max:16',
                    'no_nik' => 'nullable|string|max:16',
                    'nama_lengkap' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'alamat' => 'required|string',
                ]);

                if ($validator->fails()) {
                    throw new \Exception("Baris {$rowNumber}: " . implode(', ', $validator->errors()->all()));
                }

                // Check uniqueness manually for clearer messages
                $existingKK = Keluarga::where('no_kk', $mapped['no_kk'])->first();
                if ($existingKK) {
                    // Update existing
                    $existingKK->update($mapped);
                } else {
                    // Create new
                    // Check duplicate email
                    if (Keluarga::where('email', $mapped['email'])->exists()) {
                        throw new \Exception("Baris {$rowNumber}: Email '{$mapped['email']}' sudah terdaftar.");
                    }
                    if (!empty($mapped['no_nik']) && Keluarga::where('no_nik', $mapped['no_nik'])->exists()) {
                        throw new \Exception("Baris {$rowNumber}: NIK '{$mapped['no_nik']}' sudah terdaftar.");
                    }
                    $mapped['password'] = Hash::make('12345678');
                    $mapped['email_verified_at'] = now();
                    Keluarga::create($mapped);
                }

                $successCount++;
            }
            \DB::commit();
            fclose($handle);
            if ($request->ajax()) {
                session()->flash('success', "Berhasil mengimpor {$successCount} data kepala keluarga.");
                return response()->json(['success' => true]);
            }
            return back()->with('success', "Berhasil mengimpor {$successCount} data kepala keluarga.");
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
