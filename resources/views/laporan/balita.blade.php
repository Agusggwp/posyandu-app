@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2><i class="bi bi-file-earmark-text"></i> Laporan Pemeriksaan Balita</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.balita') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select name="bulan" id="bulan" class="form-select">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select name="tahun" id="tahun" class="form-select">
                        @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block w-100">
                        <i class="bi bi-search"></i> Filter
                    </button>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="btn-group d-block" role="group">
                        <button type="button" class="btn btn-success" onclick="alert('Export Excel dalam pengembangan')">
                            <i class="bi bi-file-earmark-excel"></i> Excel
                        </button>
                        <button type="button" class="btn btn-danger" onclick="alert('Export PDF dalam pengembangan')">
                            <i class="bi bi-file-earmark-pdf"></i> PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3>{{ $statistik['total'] }}</h3>
                    <p class="mb-0">Total Pemeriksaan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3>{{ $statistik['normal'] }}</h3>
                    <p class="mb-0">Status Gizi Normal</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h3>{{ $statistik['kurang'] }}</h3>
                    <p class="mb-0">Status Gizi Kurang</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h3>{{ $statistik['stunting'] }}</h3>
                    <p class="mb-0">Stunting</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Data Pemeriksaan - {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Balita</th>
                            <th>BB (kg)</th>
                            <th>TB (cm)</th>
                            <th>LK (cm)</th>
                            <th>Imunisasi</th>
                            <th>Vitamin</th>
                            <th>Status Gizi</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pemeriksaans as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                            <td>{{ $p->balita->nama ?? '-' }}</td>
                            <td>{{ $p->berat_badan }}</td>
                            <td>{{ $p->tinggi_badan }}</td>
                            <td>{{ $p->lingkar_kepala ?? '-' }}</td>
                            <td>{{ $p->imunisasi ?? '-' }}</td>
                            <td>{{ $p->vitamin ?? '-' }}</td>
                            <td>
                                @if($p->status_gizi == 'normal')
                                    <span class="badge bg-success">Normal</span>
                                @elseif($p->status_gizi == 'kurang')
                                    <span class="badge bg-warning">Kurang</span>
                                @else
                                    <span class="badge bg-danger">Stunting</span>
                                @endif
                            </td>
                            <td>{{ $p->petugas->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data pemeriksaan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
