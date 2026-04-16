@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-1 sm:px-0">
    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Detail Data Ibu Hamil</h2>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('ibu-hamil.index') }}" class="hover:text-blue-600">Data Ibu Hamil</a>
            <span class="mx-2">/</span>
            <span>Detail</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        @php
            $excludedColumns = [
                'created_at',
                'updated_at',
                'kepala_keluarga_id',
                'kehamilan_ke',
                'jarak_anak',
                'anak_sebelumnya',
            ];

            $data = collect($ibuHamil->getAttributes())
                ->except($excludedColumns)
                ->toArray();

            $data['alamat'] = $ibuHamil->keluarga->alamat ?? ($data['alamat'] ?? '-');

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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            @foreach($data as $column => $raw)
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">{{ $label($column) }}</label>
                    <p class="text-base sm:text-lg text-gray-900 break-words">{{ $value($column, $raw) }}</p>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-8">
            <a href="{{ route('ibu-hamil.edit', $ibuHamil) }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Edit
            </a>
            <a href="{{ route('ibu-hamil.index') }}" class="w-full sm:w-auto text-center bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
