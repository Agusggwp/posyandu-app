@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="bg-white rounded-lg shadow-lg border border-rose-200 p-4 sm:p-6">
        <h2 class="text-2xl font-bold text-rose-800 mb-6">Detail Pemeriksaan Nifas</h2>
        @php
            $data = $pemeriksaanNifas->getAttributes();
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            @foreach($data as $column => $raw)
                <div>
                    <span class="text-gray-500">{{ $label($column) }}:</span>
                    <span class="font-semibold break-words">{{ $value($column, $raw) }}</span>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex flex-col sm:flex-row gap-3 sm:gap-4">
            <a href="{{ route('pemeriksaan-nifas.edit', $pemeriksaanNifas->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center">Edit</a>
            <a href="{{ route('pemeriksaan-nifas.index') }}" class="bg-rose-700 hover:bg-rose-800 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center">Kembali</a>
        </div>
    </div>
</div>
@endsection
