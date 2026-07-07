@extends('layouts.kepala-keluarga')

@section('title', 'Dashboard Kepala Keluarga')
@section('page-title', 'Dashboard')

@section('content')
    @include('panel_kepalakeluarga.dashboard.partials.summary')
    @include('panel_kepalakeluarga.dashboard.partials.member-cards')
    @include('panel_kepalakeluarga.dashboard.partials.member-detail-modal')
    @include('panel_kepalakeluarga.dashboard.partials.riwayat-pemeriksaan')
    @include('panel_kepalakeluarga.dashboard.partials.profile')
    
    @include('panel_kepalakeluarga.dashboard.partials.news-detail-modal')
@endsection

@push('scripts')
    @include('panel_kepalakeluarga.dashboard.partials.scripts')
@endpush
