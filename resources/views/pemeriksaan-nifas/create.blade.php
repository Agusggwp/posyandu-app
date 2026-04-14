@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-rose-800">Input Pemeriksaan Nifas</h2>
    </div>

    <div class="bg-white rounded-lg shadow-lg border border-rose-200 p-6">
        <form action="{{ route('pemeriksaan-nifas.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Nifas</label>
                    <select name="nifas_identitas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        <option value="">-- Pilih --</option>
                        @foreach($nifases as $nifas)
                        <option value="{{ $nifas->id }}" {{ old('nifas_identitas_id') == $nifas->id ? 'selected' : '' }}>{{ $nifas->nama_ibu }} - {{ $nifas->nik }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Kunjungan</label>
                    <input type="datetime-local" name="waktu_kunjungan" value="{{ old('waktu_kunjungan', now()->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Berat Badan</label>
                    <input type="number" step="0.01" name="berat_badan" value="{{ old('berat_badan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Naik/Turun</label>
                    <input type="text" name="naik_turun" value="{{ old('naik_turun') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan</label>
                    <input type="number" step="0.01" name="tinggi_badan" value="{{ old('tinggi_badan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">LILA</label>
                    <input type="number" step="0.01" name="lila" value="{{ old('lila') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Gizi</label>
                    <input type="text" name="status_gizi" value="{{ old('status_gizi') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sistole</label>
                    <input type="number" name="sistole" value="{{ old('sistole') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Diastole</label>
                    <input type="number" name="diastole" value="{{ old('diastole') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Tekanan Darah</label>
                    <input type="text" name="tekanan_darah_status" value="{{ old('tekanan_darah_status') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Batuk</label>
                    <select name="batuk" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('batuk') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('batuk') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Demam</label>
                    <select name="demam" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('demam') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('demam') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">BB Turun</label>
                    <select name="bb_turun" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('bb_turun') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('bb_turun') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontak TBC</label>
                    <select name="kontak_tbc" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('kontak_tbc') === '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('kontak_tbc') === '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vitamin A</label>
                    <input type="text" name="vitamin_a" value="{{ old('vitamin_a') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Menyusui</label>
                    <input type="text" name="menyusui" value="{{ old('menyusui') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">KB</label>
                    <input type="text" name="kb" value="{{ old('kb') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Edukasi</label>
                <textarea name="edukasi" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('edukasi') }}</textarea>
            </div>
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rujukan</label>
                <input type="text" name="rujukan" value="{{ old('rujukan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-rose-700 hover:bg-rose-800 text-white font-semibold py-2 px-6 rounded-xl">Simpan</button>
                <a href="{{ route('pemeriksaan-nifas.index') }}" class="bg-rose-700 hover:bg-rose-800 text-white font-semibold py-2 px-6 rounded-xl">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
