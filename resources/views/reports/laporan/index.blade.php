@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h2 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Laporan Posyandu</h2>
        <p class="text-slate-600 mt-2">Pilih jenis laporan yang ingin ditampilkan</p>
    </div>

    <!-- Cards Laporan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Laporan Balita -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-emerald-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6">
                <div class="flex items-center justify-center w-16 h-16 bg-white/20 rounded-xl mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Laporan Balita</h3>
            </div>
            <div class="p-6">
                <p class="text-slate-600 mb-6 text-sm leading-relaxed">Laporan pemeriksaan balita termasuk grafik pertumbuhan, status gizi, dan imunisasi</p>
                <a href="{{ route('laporan.balita') }}" class="inline-flex items-center justify-center w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    Lihat Laporan
                </a>
            </div>
        </div>

        <!-- Laporan Ibu Hamil -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-violet-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-6">
                <div class="flex items-center justify-center w-16 h-16 bg-white/20 rounded-xl mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Laporan Ibu Hamil</h3>
            </div>
            <div class="p-6">
                <p class="text-slate-600 mb-6 text-sm leading-relaxed">Laporan pemeriksaan ibu hamil meliputi tekanan darah, usia kehamilan, dan catatan pemeriksaan</p>
                <a href="{{ route('laporan.ibu-hamil') }}" class="inline-flex items-center justify-center w-full bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    Lihat Laporan
                </a>
            </div>
        </div>

        <!-- Laporan Lansia -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-amber-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6">
                <div class="flex items-center justify-center w-16 h-16 bg-white/20 rounded-xl mb-4">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Laporan Lansia</h3>
            </div>
            <div class="p-6">
                <p class="text-slate-600 mb-6 text-sm leading-relaxed">Laporan pemeriksaan lansia mencakup tekanan darah, gula darah, kolesterol, dan keluhan</p>
                <a href="{{ route('laporan.lansia') }}" class="inline-flex items-center justify-center w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    Lihat Laporan
                </a>
            </div>
        </div>
    </div>

    <!-- Informasi -->
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-slate-200">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">Fitur Laporan</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-6 h-6 bg-emerald-100 rounded-lg flex items-center justify-center mr-3 mt-0.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p class="text-slate-700 font-medium">Filter Berdasarkan Periode</p>
                    <p class="text-slate-500 text-sm">Filter laporan berdasarkan bulan dan tahun</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 w-6 h-6 bg-emerald-100 rounded-lg flex items-center justify-center mr-3 mt-0.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p class="text-slate-700 font-medium">Statistik & Grafik</p>
                    <p class="text-slate-500 text-sm">Visualisasi data kesehatan dengan grafik</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 w-6 h-6 bg-emerald-100 rounded-lg flex items-center justify-center mr-3 mt-0.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p class="text-slate-700 font-medium">Cetak Laporan</p>
                    <p class="text-slate-500 text-sm">Cetak langsung atau simpan sebagai PDF</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 w-6 h-6 bg-emerald-100 rounded-lg flex items-center justify-center mr-3 mt-0.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p class="text-slate-700 font-medium">Rekap Bulanan</p>
                    <p class="text-slate-500 text-sm">Rekap pemeriksaan bulanan dan tahunan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
