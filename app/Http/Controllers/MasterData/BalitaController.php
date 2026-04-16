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
}
