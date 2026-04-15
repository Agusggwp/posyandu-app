@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Detail Pemeriksaan Balita</h2>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        @php
            $data = $pemeriksaan->getAttributes();
            $displayData = array_merge(
                ['nama_balita' => optional($pemeriksaan->balita)->nama ?? '-'],
                ['umur' => $data['umur'] ?? null, 'waktu_kunjungan' => $data['waktu_kunjungan'] ?? null],
                array_diff_key($data, array_flip(['balita_identitas_id', 'umur', 'waktu_kunjungan']))
            );
            $orderedKeys = array_keys($displayData);
            $label = fn ($key) => ucwords(str_replace('_', ' ', $key));
            $value = function ($key, $raw) {
                if ($raw === null || $raw === '') {
                    return '-';
                }

                if (is_string($raw) && $key === 'waktu_kunjungan') {
                    try {
                        return \Illuminate\Support\Carbon::parse($raw)->format('d/m/Y');
                    } catch (\Throwable $e) {
                        return $raw;
                    }
                }

                if (is_string($raw) && (str_contains($key, 'tanggal') || str_ends_with($key, '_at'))) {
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
            @foreach($orderedKeys as $column)
                @php $raw = $displayData[$column] ?? null; @endphp
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-1">{{ $label($column) }}</label>
                    <p class="text-lg text-gray-900 break-words">{{ $value($column, $raw) }}</p>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
            <a href="{{ route('pemeriksaan-balita.edit', $pemeriksaan->id) }}" class="bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                Edit
            </a>
            <a href="{{ route('pemeriksaan-balita.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
