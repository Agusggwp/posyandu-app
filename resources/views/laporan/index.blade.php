@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="bi bi-file-earmark-text"></i> Laporan</h2>
            <p class="text-muted">Pilih jenis laporan yang ingin ditampilkan</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person"></i> Laporan Balita</h5>
                </div>
                <div class="card-body">
                    <p>Laporan pemeriksaan balita termasuk grafik pertumbuhan, status gizi, dan imunisasi</p>
                    <a href="{{ route('laporan.balita') }}" class="btn btn-primary">
                        <i class="bi bi-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person-heart"></i> Laporan Ibu Hamil</h5>
                </div>
                <div class="card-body">
                    <p>Laporan pemeriksaan ibu hamil meliputi tekanan darah, usia kehamilan, dan catatan pemeriksaan</p>
                    <a href="{{ route('laporan.ibu-hamil') }}" class="btn btn-success">
                        <i class="bi bi-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-person-wheelchair"></i> Laporan Lansia</h5>
                </div>
                <div class="card-body">
                    <p>Laporan pemeriksaan lansia mencakup tekanan darah, gula darah, kolesterol, dan keluhan</p>
                    <a href="{{ route('laporan.lansia') }}" class="btn btn-info">
                        <i class="bi bi-eye"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi</h5>
                </div>
                <div class="card-body">
                    <h6>Fitur Laporan:</h6>
                    <ul>
                        <li>Filter laporan berdasarkan bulan dan tahun</li>
                        <li>Statistik dan grafik data kesehatan</li>
                        <li>Export data ke format Excel dan PDF</li>
                        <li>Daftar anak yang belum diimunisasi</li>
                        <li>Rekap pemeriksaan bulanan/tahunan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
