@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-1 sm:px-0">
    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-rose-800">Edit Data Nifas</h2>
        <p class="text-sm text-gray-600 mt-2">Perbarui data pada tabel nifas_identitas.</p>
    </div>

    <div class="bg-white rounded-lg shadow-lg border border-rose-200 p-4 sm:p-6">
        <form action="{{ route('nifas.update', $nifas->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keluarga <span class="text-red-500">*</span></label>
                    <input type="text" class="js-keluarga-search w-full px-4 py-2 mb-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent" data-target="#kepala_keluarga_id" placeholder="Cari no KK / nama kepala keluarga...">
                    <select name="kepala_keluarga_id" id="kepala_keluarga_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                        <option value="">-- Pilih Keluarga --</option>
                        @foreach($keluargas as $keluarga)
                        <option value="{{ $keluarga->id }}" {{ old('kepala_keluarga_id', $nifas->kepala_keluarga_id) == $keluarga->id ? 'selected' : '' }}>{{ $keluarga->no_kk }} - {{ $keluarga->nama_kepala_keluarga }}</option>
                        @endforeach
                    </select>
                    @error('kepala_keluarga_id')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ibu Nifas/Menyusui <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $nifas->nama_ibu) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    @error('nama_ibu')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $nifas->nik) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bersalin</label>
                    <input type="date" name="tanggal_bersalin" value="{{ old('tanggal_bersalin', optional($nifas->tanggal_bersalin)->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($nifas->tanggal_lahir)->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Umur</label>
                    <input type="number" name="umur" value="{{ old('umur', $nifas->umur) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Suami</label>
                    <input type="text" name="nama_suami" value="{{ old('nama_suami', $nifas->nama_suami) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $nifas->no_hp) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Bersalin</label>
                    <input type="text" name="tempat_bersalin" value="{{ old('tempat_bersalin', $nifas->tempat_bersalin) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Anak Ke</label>
                    <input type="number" name="anak_ke" value="{{ old('anak_ke', $nifas->anak_ke) }}" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan Ibu</label>
                    <input type="number" step="0.01" name="tinggi_badan_ibu" value="{{ old('tinggi_badan_ibu', $nifas->tinggi_badan_ibu) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-8">
                <button type="submit" class="w-full sm:w-auto bg-rose-700 hover:bg-rose-800 text-white font-semibold py-2 px-6 rounded-xl">Update</button>
                <a href="{{ route('nifas.index') }}" class="w-full sm:w-auto text-center bg-rose-700 hover:bg-rose-800 text-white font-semibold py-2 px-6 rounded-xl">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
