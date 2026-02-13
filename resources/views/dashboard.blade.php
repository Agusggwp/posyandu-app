@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h2 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Dashboard</h2>
        <p class="text-slate-600 mt-2">Sistem Informasi Manajemen Posyandu</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 p-6 hover:shadow-xl transition-all duration-300 group overflow-hidden relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full blur-3xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
            <div class="relative">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-2">Total Keluarga</p>
                        <h3 class="text-5xl font-bold bg-gradient-to-r from-indigo-500 to-purple-600 bg-clip-text text-transparent">{{ $data['total_keluarga'] }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-emerald-100 p-6 hover:shadow-xl transition-all duration-300 group overflow-hidden relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full blur-3xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
            <div class="relative">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-2">Total Balita</p>
                        <h3 class="text-5xl font-bold bg-gradient-to-r from-emerald-500 to-teal-600 bg-clip-text text-transparent">{{ $data['total_balita'] }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-violet-100 p-6 hover:shadow-xl transition-all duration-300 group overflow-hidden relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-violet-100 to-purple-100 rounded-full blur-3xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
            <div class="relative">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-2">Total Ibu Hamil</p>
                        <h3 class="text-5xl font-bold bg-gradient-to-r from-violet-500 to-purple-600 bg-clip-text text-transparent">{{ $data['total_ibu_hamil'] }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-violet-400 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-amber-100 p-6 hover:shadow-xl transition-all duration-300 group overflow-hidden relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full blur-3xl opacity-50 group-hover:opacity-70 transition-opacity"></div>
            <div class="relative">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-2">Total Lansia</p>
                        <h3 class="text-5xl font-bold bg-gradient-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent">{{ $data['total_lansia'] }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/20 rounded-full blur-2xl"></div>
                <h3 class="text-lg font-semibold text-white relative">📊 Pemeriksaan Bulan Ini</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-100 hover:shadow-md transition-all duration-200">
                        <span class="text-slate-700 font-medium">Pemeriksaan Balita</span>
                        <span class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm">{{ $data['total_pemeriksaan_balita'] }}</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gradient-to-r from-violet-50 to-purple-50 rounded-xl border border-violet-100 hover:shadow-md transition-all duration-200">
                        <span class="text-slate-700 font-medium">Pemeriksaan Ibu Hamil</span>
                        <span class="bg-gradient-to-r from-violet-500 to-purple-500 text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm">{{ $data['total_pemeriksaan_ibu_hamil'] }}</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-100 hover:shadow-md transition-all duration-200">
                        <span class="text-slate-700 font-medium">Pemeriksaan Lansia</span>
                        <span class="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm">{{ $data['total_pemeriksaan_lansia'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-rose-200 overflow-hidden hover:shadow-xl transition-all duration-300">
            <div class="bg-gradient-to-r from-rose-400 to-pink-500 px-6 py-4 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/20 rounded-full blur-2xl"></div>
                <h3 class="text-lg font-semibold text-white relative">⚠️ Status Gizi</h3>
            </div>
            <div class="p-6">
                <div class="bg-gradient-to-r from-rose-50 to-pink-50 border-l-4 border-rose-400 p-5 mb-4 rounded-xl shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-rose-800 mb-1">Perhatian!</h3>
                            <div class="mt-2 text-sm text-rose-700">
                                <p class="font-medium">Balita dengan status <strong>Stunting</strong>:</p>
                                <p class="text-4xl font-bold mt-2 bg-gradient-to-r from-rose-600 to-pink-600 bg-clip-text text-transparent">{{ $data['balita_stunting'] }} <span class="text-xl">anak</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('pemeriksaan-balita.index') }}" class="block w-full text-center bg-gradient-to-r from-rose-400 to-pink-500 hover:from-rose-500 hover:to-pink-600 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                    Lihat Detail
                </a>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300">
            <div class="bg-gradient-to-r from-slate-600 to-slate-700 px-6 py-4 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                <h3 class="text-lg font-semibold text-white relative">⚡ Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <a href="{{ route('pemeriksaan-balita.create') }}" class="group block w-full bg-gradient-to-r from-emerald-400 to-teal-500 hover:from-emerald-500 hover:to-teal-600 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 text-center shadow-md hover:shadow-lg hover:scale-105">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                            Input Pemeriksaan Balita
                        </span>
                    </a>
                    <a href="{{ route('pemeriksaan-ibu-hamil.create') }}" class="group block w-full bg-gradient-to-r from-violet-400 to-purple-500 hover:from-violet-500 hover:to-purple-600 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 text-center shadow-md hover:shadow-lg hover:scale-105">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                            Input Pemeriksaan Ibu Hamil
                        </span>
                    </a>
                    <a href="{{ route('pemeriksaan-lansia.create') }}" class="group block w-full bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 text-center shadow-md hover:shadow-lg hover:scale-105">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                            Input Pemeriksaan Lansia
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/20 rounded-full blur-3xl"></div>
            <h3 class="text-lg font-semibold text-white relative flex items-center">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Informasi Sistem
            </h3>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <p class="text-xl font-semibold text-slate-800 mb-2">Selamat datang, <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">{{ Auth::user()->name }}</span>! 👋</p>
                <p class="text-slate-600">Anda login sebagai: <span class="bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 px-4 py-1.5 rounded-full text-sm font-semibold border border-indigo-200">{{ Auth::user()->role->name ?? 'N/A' }}</span></p>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent my-6"></div>
            <p class="text-slate-600 leading-relaxed">
                Sistem Informasi Posyandu ini digunakan untuk mengelola data keluarga, balita, ibu hamil, lansia, 
                serta pencatatan pemeriksaan kesehatan dan pembuatan laporan.
            </p>
        </div>
    </div>
</div>
@endsection
