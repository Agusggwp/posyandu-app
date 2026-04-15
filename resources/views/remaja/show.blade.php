@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg border border-cyan-200 p-6">
        <h2 class="text-2xl font-bold text-cyan-900 mb-6">Detail Remaja</h2>

        @php
            $excludedColumns = [
                'dusun',
                'desa',
                'kecamatan',
                'kepala_keluarga_id',
                'created_at',
                'updated_at',
            ];

            $data = collect($remaja->getAttributes())
                ->except($excludedColumns)
                ->toArray();

            $data['alamat'] = $remaja->keluarga->alamat ?? ($data['alamat'] ?? '-');

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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            @foreach($data as $column => $raw)
                <div>
                    <span class="text-gray-500">{{ $label($column) }}:</span>
                    <span class="font-semibold break-words">{{ $value($column, $raw) }}</span>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <a href="{{ route('remaja.edit', $remaja) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-6 rounded-xl">Edit</a>
            <a href="{{ route('remaja.index') }}" class="ml-2 bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-2 px-6 rounded-xl">Kembali</a>
        </div>
    </div>
</div>
@endsection
