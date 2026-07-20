@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <div class="bg-white rounded-lg shadow-lg border border-cyan-200 p-4 sm:p-6">
        <h2 class="text-2xl font-bold text-cyan-900 mb-6">Detail Pemeriksaan Remaja</h2>
        @php
            $data = $pemeriksaan->getAttributes();
            $displayData = array_merge(
                ['nama_remaja' => optional($pemeriksaan->remaja)->nama_anak ?? '-'],
                ['tanggal_kunjungan' => $data['tanggal_kunjungan'] ?? null],
                array_diff_key($data, array_flip([
                    'id', 'remaja_identitas_id', 'tahap_terakhir', 
                    'tanggal_pemeriksaan', 'waktu_kunjungan', 'tanggal_kunjungan',
                    'created_at', 'updated_at'
                ]))
            );
            $label = fn ($key) => ucwords(str_replace('_', ' ', $key));
            $value = function ($key, $raw) {
                if ($raw === null || $raw === '') {
                    return '-';
                }

                if (is_string($raw) && ($key === 'waktu_kunjungan' || $key === 'tanggal_kunjungan')) {
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
            @foreach($displayData as $column => $raw)
                <div>
                    <span class="text-gray-500">{{ $label($column) }}:</span>
                    @if($column === 'rujukan')
                        @if($raw && $raw !== 'Tidak' && $raw !== 'Tidak Ada')
                            <span class="inline-flex items-center px-3 py-1 rounded bg-rose-100 text-rose-800 border border-rose-200 text-xs font-semibold">
                                ⚠️ Perlu Rujukan (ke: {{ $raw }})
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-semibold">
                                ✓ Tidak Perlu Rujukan
                            </span>
                        @endif
                    @else
                        <span class="font-semibold break-words">{{ $value($column, $raw) }}</span>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex flex-col sm:flex-row gap-3 sm:gap-4">
            <a href="{{ route('pemeriksaan-remaja.edit', $pemeriksaan->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center">Edit</a>
            <a href="{{ route('pemeriksaan-remaja.print', $pemeriksaan->id) }}" target="_blank" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center shadow-md hover:shadow-lg transition-all duration-200">
                🖨️ Cetak Laporan Perkembangan
            </a>
            <a href="{{ route('pemeriksaan-remaja.index') }}" class="bg-cyan-700 hover:bg-cyan-800 text-white font-semibold py-2 px-6 rounded-xl w-full sm:w-auto text-center">Kembali</a>
        </div>
    </div>
</div>
@endsection
