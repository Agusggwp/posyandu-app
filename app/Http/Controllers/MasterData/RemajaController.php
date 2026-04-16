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
}
