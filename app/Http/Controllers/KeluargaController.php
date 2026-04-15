<?php

namespace App\Http\Controllers;

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
        return view('keluarga.index', compact('keluargas'));
    }

    public function create()
    {
        return view('keluarga.create');
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
        return view('keluarga.show', compact('keluarga'));
    }

    public function edit(Keluarga $keluarga)
    {
        return view('keluarga.edit', compact('keluarga'));
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
}
