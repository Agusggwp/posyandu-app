@extends('layouts.kepala-keluarga')

@section('title', 'Detail Anggota Keluarga')
@section('page-title', 'Detail Anggota')

@section('content')
<div class="mb-6 flex flex-wrap gap-2">
    <a href="{{ route('kepala-keluarga.anggota.pemeriksaan', ['tipe' => $memberType, 'id' => $member->id]) }}" class="inline-flex items-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-indigo-700 shadow-md shadow-indigo-100">
        <i class="fa-solid fa-chart-column mr-2"></i>Lihat Pemeriksaan
    </a>
    <a href="{{ route('kepala-keluarga.dashboard') }}" class="inline-flex items-center rounded-2xl bg-slate-200 px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-300">
        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali Dashboard
    </a>
</div>

<div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-100">
    <h3 class="mb-6 text-lg font-extrabold text-slate-800">Data Lengkap Anggota</h3>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        @foreach($displayAttributes as $key => $value)
            <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-4">
                <p class="text-xs font-bold uppercase text-slate-400 tracking-wider">{{ str_replace('_', ' ', $key) }}</p>
                <p class="mt-1 break-words text-sm font-bold text-slate-800">{{ $value ?: '-' }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Highlight active sidebar item
        document.querySelectorAll('.nav-btn').forEach(btn => btn.classList.remove('active-section-btn'));
        const activeBtn = document.querySelector('[data-section-btn="anggota-keluarga"]');
        if (activeBtn) {
            activeBtn.classList.add('active-section-btn');
        }
    });
</script>
@endpush
