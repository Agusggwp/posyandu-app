<?php

namespace App\Http\Controllers;

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
        return view('ibu-hamil.index', compact('ibuHamils'));
    }

    public function create()
    {
        $keluargas = Keluarga::latest()->get();
        return view('ibu-hamil.create', compact('keluargas'));
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
        return view('ibu-hamil.show', compact('ibuHamil'));
    }

    public function edit(IbuHamil $ibuHamil)
    {
        $keluargas = Keluarga::latest()->get();
        return view('ibu-hamil.edit', compact('ibuHamil', 'keluargas'));
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
}
