@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Detail Data Balita</h2>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        @php
            $excludedColumns = [
                'no_telp',
                'dusun',
                'desa',
                'kecamatan',
                'created_at',
                'updated_at',
            ];

            $data = collect($balita->getAttributes())
                ->except($excludedColumns)
                ->toArray();

            $data['alamat'] = $balita->keluarga->alamat ?? ($data['alamat'] ?? '-');

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

        <div class="flex gap-4 mt-8">
            <a href="{{ route('balita.edit', $balita) }}" class="bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Edit
            </a>
            <a href="{{ route('balita.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
