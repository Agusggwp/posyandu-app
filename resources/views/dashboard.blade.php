@extends('layouts.app')

@section('page_title', 'Dashboard')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.96) 0%, rgba(248, 250, 252, 0.96) 100%);
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 18px;
        padding: 22px;
        box-shadow: 0 8px 24px rgba(2, 6, 23, 0.07);
        position: relative;
        overflow: hidden;
    }

    .stat-card.purple { border-left: 4px solid #7c3aed; }
    .stat-card.blue { border-left: 4px solid #2563eb; }
    .stat-card.green { border-left: 4px solid #059669; }
    .stat-card.orange { border-left: 4px solid #ea580c; }

    .stat-label {
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }

    .stat-label i {
        font-size: 14px;
        color: inherit;
    }

    .stat-value {
        font-size: 34px;
        line-height: 1.1;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }

    .stat-change {
        display: inline-block;
        font-size: 12px;
        font-weight: 700;
        color: #047857;
        background: rgba(16, 185, 129, 0.12);
        padding: 4px 10px;
        border-radius: 999px;
        position: relative;
        z-index: 1;
    }

    .stat-watermark {
        position: absolute;
        right: 16px;
        top: 14px;
        font-size: 44px;
        opacity: 0.14;
        line-height: 1;
        z-index: 0;
        pointer-events: none;
        text-rendering: geometricPrecision;
        -webkit-font-smoothing: antialiased;
    }

    .stat-card.purple .stat-watermark { color: #7c3aed; }
    .stat-card.blue .stat-watermark { color: #2563eb; }
    .stat-card.green .stat-watermark { color: #059669; }
    .stat-card.orange .stat-watermark { color: #ea580c; }

    .dash-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.96) 0%, rgba(248, 250, 252, 0.96) 100%);
        border: 1px solid rgba(15, 23, 42, 0.08);
        border-radius: 20px;
        padding: 26px;
        box-shadow: 0 10px 24px rgba(2, 6, 23, 0.08);
    }

    .dash-card-title {
        font-size: 21px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 18px;
    }

    .ringkasan-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 14px;
        border-radius: 12px;
        margin-bottom: 10px;
        border: 1px solid transparent;
    }

    .ringkasan-item.green { background: #ecfdf5; border-color: #a7f3d0; }
    .ringkasan-item.blue { background: #eff6ff; border-color: #bfdbfe; }
    .ringkasan-item.orange { background: #fff7ed; border-color: #fed7aa; }

    .ringkasan-badge {
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 999px;
    }

    .ringkasan-badge.green { background: #059669; }
    .ringkasan-badge.blue { background: #2563eb; }
    .ringkasan-badge.orange { background: #ea580c; }

    .quick-link {
        display: block;
        text-align: center;
        color: #fff;
        font-weight: 700;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 10px;
        text-decoration: none;
    }

    .quick-link.green { background: linear-gradient(135deg, #10b981 0%, #0f766e 100%); }
    .quick-link.blue { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
    .quick-link.orange { background: linear-gradient(135deg, #fb923c 0%, #ea580c 100%); }

    .table-card table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-card th {
        text-align: left;
        font-size: 12px;
        color: #64748b;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 14px 12px;
        border-bottom: 2px solid #dbeafe;
    }

    .table-card td {
        padding: 14px 12px;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 30px;
        }

        .dash-card {
            padding: 18px;
        }
    }
</style>
@endpush

@section('content')
@php
    $showStatsCards = ($dashboardSettings['show_stats_cards'] ?? 'active') === 'active';
    $showCardKeluarga = ($dashboardSettings['show_card_keluarga'] ?? 'active') === 'active';
    $showCardBalita = ($dashboardSettings['show_card_balita'] ?? 'active') === 'active';
    $showCardIbuHamil = ($dashboardSettings['show_card_ibu_hamil'] ?? 'active') === 'active';
    $showCardNifas = ($dashboardSettings['show_card_nifas'] ?? 'active') === 'active';
    $showCardRemaja = ($dashboardSettings['show_card_remaja'] ?? 'active') === 'active';
    $showCardLansia = ($dashboardSettings['show_card_lansia'] ?? 'active') === 'active';

    $showChecksSummary = ($dashboardSettings['show_checks_summary'] ?? 'active') === 'active';
    $showChecksBalita = ($dashboardSettings['show_checks_balita'] ?? 'active') === 'active';
    $showChecksIbuHamil = ($dashboardSettings['show_checks_ibu_hamil'] ?? 'active') === 'active';
    $showChecksNifas = ($dashboardSettings['show_checks_nifas'] ?? 'active') === 'active';
    $showChecksRemaja = ($dashboardSettings['show_checks_remaja'] ?? 'active') === 'active';
    $showChecksLansia = ($dashboardSettings['show_checks_lansia'] ?? 'active') === 'active';

    $showNutrition = ($dashboardSettings['show_nutrition'] ?? 'active') === 'active';
    $showQuickActions = ($dashboardSettings['show_quick_actions'] ?? 'active') === 'active';
    $showActionBalita = ($dashboardSettings['show_action_balita'] ?? 'active') === 'active';
    $showActionIbuHamil = ($dashboardSettings['show_action_ibu_hamil'] ?? 'active') === 'active';
    $showActionNifas = ($dashboardSettings['show_action_nifas'] ?? 'active') === 'active';
    $showActionRemaja = ($dashboardSettings['show_action_remaja'] ?? 'active') === 'active';
    $showActionLansia = ($dashboardSettings['show_action_lansia'] ?? 'active') === 'active';

    $showSystemInfo = ($dashboardSettings['show_system_info'] ?? 'active') === 'active';

    $hasStatsCards = $showCardKeluarga || $showCardBalita || $showCardIbuHamil || $showCardNifas || $showCardRemaja || $showCardLansia;
    $hasChecksItems = $showChecksBalita || $showChecksIbuHamil || $showChecksNifas || $showChecksRemaja || $showChecksLansia;
    $hasQuickActions = $showActionBalita || $showActionIbuHamil || $showActionNifas || $showActionRemaja || $showActionLansia;
@endphp

@if ($showStatsCards && $hasStatsCards)
<div class="stats-grid">
    @if ($showCardKeluarga)
    <div class="stat-card purple">
        <span class="stat-watermark"><i class="fa-solid fa-people-roof"></i></span>
        <div class="stat-label"><i class="fa-solid fa-people-roof"></i>Total Keluarga</div>
        <div class="stat-value">{{ $data['total_keluarga'] }}</div>
        <div class="stat-change">{{ $dashboardSettings['stat_note'] ?? 'Data aktif' }}</div>
    </div>
    @endif

    @if ($showCardBalita)
    <div class="stat-card blue">
        <span class="stat-watermark"><i class="fa-solid fa-baby"></i></span>
        <div class="stat-label"><i class="fa-solid fa-baby"></i>Total Balita</div>
        <div class="stat-value">{{ $data['total_balita'] }}</div>
        <div class="stat-change">{{ $dashboardSettings['stat_note'] ?? 'Data aktif' }}</div>
    </div>
    @endif

    @if ($showCardIbuHamil)
    <div class="stat-card green">
        <span class="stat-watermark"><i class="fa-solid fa-person-pregnant"></i></span>
        <div class="stat-label"><i class="fa-solid fa-person-pregnant"></i>Total Ibu Hamil</div>
        <div class="stat-value">{{ $data['total_ibu_hamil'] }}</div>
        <div class="stat-change">{{ $dashboardSettings['stat_note'] ?? 'Data aktif' }}</div>
    </div>
    @endif

    @if ($showCardNifas)
    <div class="stat-card purple">
        <span class="stat-watermark"><i class="fa-solid fa-child-reaching"></i></span>
        <div class="stat-label"><i class="fa-solid fa-child-reaching"></i>Total Nifas</div>
        <div class="stat-value">{{ $data['total_nifas'] }}</div>
        <div class="stat-change">{{ $dashboardSettings['stat_note'] ?? 'Data aktif' }}</div>
    </div>
    @endif

    @if ($showCardRemaja)
    <div class="stat-card blue">
        <span class="stat-watermark"><i class="fa-solid fa-user-group"></i></span>
        <div class="stat-label"><i class="fa-solid fa-user-group"></i>Total Remaja</div>
        <div class="stat-value">{{ $data['total_remaja'] }}</div>
        <div class="stat-change">{{ $dashboardSettings['stat_note'] ?? 'Data aktif' }}</div>
    </div>
    @endif

    @if ($showCardLansia)
    <div class="stat-card orange">
        <span class="stat-watermark"><i class="fa-solid fa-person-cane"></i></span>
        <div class="stat-label"><i class="fa-solid fa-person-cane"></i>Total Lansia</div>
        <div class="stat-value">{{ $data['total_lansia'] }}</div>
        <div class="stat-change">{{ $dashboardSettings['stat_note'] ?? 'Data aktif' }}</div>
    </div>
    @endif
</div>
@endif

@if (($showChecksSummary && $hasChecksItems) || $showNutrition || ($showQuickActions && $hasQuickActions))
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    @if ($showChecksSummary && $hasChecksItems)
    <div class="dash-card">
        <h3 class="dash-card-title">{{ $dashboardSettings['checks_title'] ?? 'Pemeriksaan Bulan Ini' }}</h3>
        <div>
            @if ($showChecksBalita)
            <div class="ringkasan-item green">
                <span>Pemeriksaan Balita</span>
                <span class="ringkasan-badge green">{{ $data['total_pemeriksaan_balita'] }}</span>
            </div>
            @endif

            @if ($showChecksIbuHamil)
            <div class="ringkasan-item blue">
                <span>Pemeriksaan Ibu Hamil</span>
                <span class="ringkasan-badge blue">{{ $data['total_pemeriksaan_ibu_hamil'] }}</span>
            </div>
            @endif

            @if ($showChecksNifas)
            <div class="ringkasan-item green">
                <span>Pemeriksaan Nifas</span>
                <span class="ringkasan-badge green">{{ $data['total_pemeriksaan_nifas'] }}</span>
            </div>
            @endif

            @if ($showChecksRemaja)
            <div class="ringkasan-item blue">
                <span>Pemeriksaan Remaja</span>
                <span class="ringkasan-badge blue">{{ $data['total_pemeriksaan_remaja'] }}</span>
            </div>
            @endif

            @if ($showChecksLansia)
            <div class="ringkasan-item orange" style="margin-bottom: 0;">
                <span>Pemeriksaan Lansia</span>
                <span class="ringkasan-badge orange">{{ $data['total_pemeriksaan_lansia'] }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    @if ($showNutrition)
    <div class="dash-card">
        <h3 class="dash-card-title">{{ $dashboardSettings['nutrition_title'] ?? 'Status Gizi' }}</h3>
        <div class="bg-rose-50 border border-rose-200 rounded-xl p-5 mb-4">
            <h4 class="text-sm font-semibold text-rose-800 mb-1">Perhatian</h4>
            <p class="text-rose-700">Balita dengan status <strong>Stunting</strong></p>
            <p class="text-4xl font-bold mt-2 text-rose-600">{{ $data['balita_stunting'] }} <span class="text-lg">anak</span></p>
        </div>
        <a href="{{ route('pemeriksaan-balita.index') }}" class="quick-link blue" style="margin-bottom: 0;">
            Lihat Detail
        </a>
    </div>
    @endif

    @if ($showQuickActions && $hasQuickActions)
    <div class="dash-card">
        <h3 class="dash-card-title">{{ $dashboardSettings['quick_actions_title'] ?? 'Quick Actions' }}</h3>
        @if ($showActionBalita)
        <a href="{{ route('pemeriksaan-balita.create') }}" class="quick-link green">
            Input Pemeriksaan Balita
        </a>
        @endif

        @if ($showActionIbuHamil)
        <a href="{{ route('pemeriksaan-ibu-hamil.create') }}" class="quick-link blue">
            Input Pemeriksaan Ibu Hamil
        </a>
        @endif

        @if ($showActionNifas)
        <a href="{{ route('pemeriksaan-nifas.create') }}" class="quick-link green">
            Input Pemeriksaan Nifas
        </a>
        @endif

        @if ($showActionRemaja)
        <a href="{{ route('pemeriksaan-remaja.create') }}" class="quick-link blue">
            Input Pemeriksaan Remaja
        </a>
        @endif

        @if ($showActionLansia)
        <a href="{{ route('pemeriksaan-lansia.create') }}" class="quick-link orange" style="margin-bottom: 0;">
            Input Pemeriksaan Lansia
        </a>
        @endif
    </div>
    @endif
</div>
@endif

@if ($showSystemInfo)
<div class="dash-card table-card">
    <h3 class="dash-card-title">{{ $dashboardSettings['system_info_title'] ?? 'Informasi Sistem' }}</h3>
    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nama Pengguna</td>
                    <td>{{ Auth::user()->name }}</td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td>{{ Auth::user()->role_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Total Keluarga</td>
                    <td>{{ $data['total_keluarga'] }}</td>
                </tr>
                <tr>
                    <td>Total Data Pemeriksaan (Bulan Ini)</td>
                    <td>{{ $data['total_pemeriksaan_balita'] + $data['total_pemeriksaan_ibu_hamil'] + $data['total_pemeriksaan_nifas'] + $data['total_pemeriksaan_remaja'] + $data['total_pemeriksaan_lansia'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
