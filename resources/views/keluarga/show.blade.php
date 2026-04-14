@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Detail Data Keluarga</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('keluarga.index') }}" class="hover:text-blue-600">Data Keluarga</a>
            <span class="mx-2">/</span>
            <span>Detail</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">No. KK</label>
                <p class="text-lg text-gray-900">{{ $keluarga->no_kk }}</p>
            @php
                $data = $keluarga->getAttributes();
                $label = fn ($key) => ucwords(str_replace('_', ' ', $key));
                $value = function ($key, $raw) {
                    if ($raw === null || $raw === '') {
                        return '-';
                    }

                    if (is_string($raw) && (str_contains($key, 'tanggal') || str_contains($key, 'waktu') || str_ends_with($key, '_at'))) {
                        try {
                            return \Illuminate\Support\Carbon::parse($raw)->format('d/m/Y H:i');
                        } catch (\Throwable $e) {
                            return $raw;
                        }
                    }

                    if ($raw === '1' || $raw === 1) {
                        return 'Ya';
                    }

                    if ($raw === '0' || $raw === 0) {
                        return 'Tidak';
                    }

                    return (string) $raw;
                };
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($data as $column => $raw)
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">{{ $label($column) }}</label>
                        <p class="text-lg text-gray-900 break-words">{{ $value($column, $raw) }}</p>
                    </div>
                @endforeach
            </div>
                <label class="block text-sm font-medium text-gray-500 mb-1">RW</label>
                <p class="text-lg text-gray-900">{{ $keluarga->rw }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Kelurahan</label>
                <p class="text-lg text-gray-900">{{ $keluarga->kelurahan }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Kecamatan</label>
                <p class="text-lg text-gray-900">{{ $keluarga->kecamatan }}</p>
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-500 mb-1">Telepon</label>
            <p class="text-lg text-gray-900">{{ $keluarga->telepon ?? '-' }}</p>
        </div>

        <div class="flex gap-4 mt-8">
            <a href="{{ route('keluarga.edit', $keluarga->id) }}" class="bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Edit
            </a>
            <a href="{{ route('keluarga.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Kembali
            </a>
        </div>
    </div>

    <!-- List Anggota Keluarga -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Anggota Keluarga</h3>
        
        <div class="space-y-4">
            @if($keluarga->balitas && $keluarga->balitas->count() > 0)
                <div>
                    <h4 class="font-semibold text-green-600 mb-2">Balita ({{ $keluarga->balitas->count() }})</h4>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        @foreach($keluarga->balitas as $balita)
                            <li>{{ $balita->nama }} - {{ \Carbon\Carbon::parse($balita->tanggal_lahir)->age }} tahun</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($keluarga->ibuHamils && $keluarga->ibuHamils->count() > 0)
                <div>
                    <h4 class="font-semibold text-purple-600 mb-2">Ibu Hamil ({{ $keluarga->ibuHamils->count() }})</h4>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        @foreach($keluarga->ibuHamils as $ibuHamil)
                            <li>{{ $ibuHamil->nama }} - Hamil ke-{{ $ibuHamil->hamil_ke }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($keluarga->lansias && $keluarga->lansias->count() > 0)
                <div>
                    <h4 class="font-semibold text-yellow-600 mb-2">Lansia ({{ $keluarga->lansias->count() }})</h4>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        @foreach($keluarga->lansias as $lansia)
                            <li>{{ $lansia->nama }} - {{ \Carbon\Carbon::parse($lansia->tanggal_lahir)->age }} tahun</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if((!$keluarga->balitas || $keluarga->balitas->count() == 0) && 
                (!$keluarga->ibuHamils || $keluarga->ibuHamils->count() == 0) && 
                (!$keluarga->lansias || $keluarga->lansias->count() == 0))
                <p class="text-gray-500 italic">Belum ada anggota keluarga terdaftar</p>
            @endif
        </div>
    </div>
</div>
@endsection
