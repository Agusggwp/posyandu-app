<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistem Informasi Posyandu - Pantau kesehatan keluarga Anda, lihat jadwal Posyandu terbaru, imunisasi, dan artikel kesehatan penting lainnya.">
    <title>{{ $settings['app_name'] }} - Dashboard Publik</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            min-height: 100vh;
        }
        
        .heading-font {
            font-family: 'Outfit', sans-serif;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        .hero-gradient {
            background: radial-gradient(circle at 10% 20%, rgba(124, 58, 237, 0.05) 0%, transparent 40%),
                        radial-gradient(circle at 90% 80%, rgba(37, 99, 235, 0.05) 0%, transparent 40%),
                        linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #7c3aed 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #7c3aed 0%, #2563eb 100%);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.25);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-gradient:hover {
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
            transform: translateY(-2px);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }

        /* Micro-animations */
        @keyframes pulse-slow {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .pulse-icon {
            animation: pulse-slow 3s infinite;
        }
    </style>
</head>
<body class="antialiased text-slate-800">

    <!-- Header / Navigation -->
    <header class="sticky top-0 z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-2xl bg-gradient-to-br from-violet-600 to-blue-600 flex items-center justify-center text-white shadow-md shadow-violet-200">
                        <i class="fa-solid fa-house-medical text-lg"></i>
                    </div>
                    <div>
                        <h1 class="heading-font text-lg font-bold tracking-tight text-slate-900 leading-tight">
                            {{ $settings['app_name'] }}
                        </h1>
                        <p class="text-xs text-slate-500 font-medium">Kesehatan Keluarga</p>
                    </div>
                </div>

                <!-- Navigation Links / Auth Actions -->
                <div class="hidden lg:flex items-center gap-4">
                    @auth('kepala_keluarga')
                        <div class="flex items-center gap-3 bg-fuchsia-50/50 border border-fuchsia-100/80 rounded-2xl px-4 py-2">
                            <span class="h-2 w-2 rounded-full bg-fuchsia-500"></span>
                            <span class="text-sm font-semibold text-fuchsia-800">KK: {{ Auth::guard('kepala_keluarga')->user()->nama_lengkap }}</span>
                        </div>
                        <a href="{{ route('kepala-keluarga.dashboard') }}" id="btn-kk-dashboard" class="btn-gradient text-white text-sm font-bold px-5 py-2.5 rounded-xl">
                            <i class="fa-solid fa-gauge-high mr-2"></i> Ke Dashboard
                        </a>
                        <form action="{{ route('kepala-keluarga.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" id="btn-kk-logout" class="text-sm font-semibold text-slate-600 hover:text-rose-600 transition px-3 py-2">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                            </button>
                        </form>
                    @elseauth('web')
                        <div class="flex items-center gap-3 bg-violet-50/50 border border-violet-100/80 rounded-2xl px-4 py-2">
                            <span class="h-2 w-2 rounded-full bg-violet-500"></span>
                            <span class="text-sm font-semibold text-violet-800">Petugas: {{ Auth::guard('web')->user()->name }}</span>
                        </div>
                        <a href="{{ route('dashboard') }}" id="btn-admin-dashboard" class="btn-gradient text-white text-sm font-bold px-5 py-2.5 rounded-xl">
                            <i class="fa-solid fa-gauge-high mr-2"></i> Panel Petugas
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" id="btn-admin-logout" class="text-sm font-semibold text-slate-600 hover:text-rose-600 transition px-3 py-2">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                            </button>
                        </form>
                    @else
                        <!-- Guest Actions -->
                        <div class="flex items-center gap-3">
                            <a href="{{ route('kepala-keluarga.login') }}" id="btn-kk-login-nav" class="text-sm font-bold text-violet-700 hover:text-violet-800 transition px-4 py-2">
                                <i class="fa-solid fa-user mr-1.5"></i> Login Keluarga
                            </a>
                            <a href="{{ route('kepala-keluarga.register') }}" id="btn-kk-register-nav" class="bg-violet-50 border border-violet-100 hover:bg-violet-100 text-violet-700 text-sm font-bold px-4 py-2.5 rounded-xl transition">
                                <i class="fa-solid fa-user-plus mr-1.5"></i> Daftar Keluarga
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden">
                    <button type="button" id="mobile-menu-button" class="text-slate-600 hover:text-slate-900 p-2 rounded-xl focus:outline-none" aria-label="Toggle menu">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white border-b border-slate-100 px-4 pt-2 pb-6 space-y-3 transition-all duration-300">
            @auth('kepala_keluarga')
                <div class="bg-fuchsia-50 p-3 rounded-xl mb-2">
                    <p class="text-xs text-slate-500 font-semibold uppercase">Masuk Sebagai</p>
                    <p class="text-sm font-bold text-fuchsia-900">KK: {{ Auth::guard('kepala_keluarga')->user()->nama_lengkap }}</p>
                </div>
                <a href="{{ route('kepala-keluarga.dashboard') }}" id="btn-kk-dashboard-mobile" class="block w-full text-center btn-gradient text-white text-sm font-bold py-3 rounded-xl">
                    <i class="fa-solid fa-gauge-high mr-2"></i> Ke Dashboard
                </a>
                <form action="{{ route('kepala-keluarga.logout') }}" method="POST" class="block w-full">
                    @csrf
                    <button type="submit" id="btn-kk-logout-mobile" class="w-full text-center border border-slate-200 text-slate-600 hover:bg-rose-50 hover:text-rose-600 text-sm font-bold py-3 rounded-xl transition">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar
                    </button>
                </form>
            @elseauth('web')
                <div class="bg-violet-50 p-3 rounded-xl mb-2">
                    <p class="text-xs text-slate-500 font-semibold uppercase">Masuk Sebagai</p>
                    <p class="text-sm font-bold text-violet-900">Petugas: {{ Auth::guard('web')->user()->name }}</p>
                </div>
                <a href="{{ route('dashboard') }}" id="btn-admin-dashboard-mobile" class="block w-full text-center btn-gradient text-white text-sm font-bold py-3 rounded-xl">
                    <i class="fa-solid fa-gauge-high mr-2"></i> Panel Petugas
                </a>
                <form action="{{ route('logout') }}" method="POST" class="block w-full">
                    @csrf
                    <button type="submit" id="btn-admin-logout-mobile" class="w-full text-center border border-slate-200 text-slate-600 hover:bg-rose-50 hover:text-rose-600 text-sm font-bold py-3 rounded-xl transition">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('kepala-keluarga.login') }}" id="btn-kk-login-mobile" class="block w-full text-center border border-violet-200 text-violet-700 text-sm font-bold py-3 rounded-xl transition hover:bg-violet-50">
                    <i class="fa-solid fa-user mr-2"></i> Login Kepala Keluarga
                </a>
                <a href="{{ route('kepala-keluarga.register') }}" id="btn-kk-register-mobile" class="block w-full text-center btn-gradient text-white text-sm font-bold py-3 rounded-xl">
                    <i class="fa-solid fa-user-plus mr-2"></i> Registrasi Kepala Keluarga
                </a>
            @endauth
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero-gradient overflow-hidden py-16 lg:py-24 border-b border-slate-100" aria-label="Hero Utama">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-12 items-center">
                    <!-- Text Content -->
                    <div class="lg:col-span-7 text-center lg:text-left">
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-violet-50 text-violet-700 text-xs font-bold uppercase tracking-wider mb-6">
                            <i class="fa-solid fa-star pulse-icon"></i> Posyandu Digital Terintegrasi
                        </span>
                        <h2 class="heading-font text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight">
                            Selamat Datang di <br>
                            <span class="gradient-text leading-normal">{{ $settings['app_name'] }}</span>
                        </h2>
                        <p class="mt-6 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                            {{ $settings['app_tagline'] }} Portal ini memfasilitasi monitoring tumbuh kembang anak, ibu hamil, remaja, dan lansia secara transparan dan berkala.
                        </p>

                        <!-- Call to Actions -->
                        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                            @auth('kepala_keluarga')
                                <a href="{{ route('kepala-keluarga.dashboard') }}" id="hero-btn-dashboard" class="btn-gradient text-white font-bold py-4 px-8 rounded-2xl flex items-center gap-2">
                                    <span>Buka Dashboard Keluarga</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            @else
                                <a href="{{ route('kepala-keluarga.register') }}" id="hero-btn-register" class="btn-gradient text-white font-bold py-4 px-8 rounded-2xl flex items-center gap-2 w-full sm:w-auto justify-center">
                                    <span>Registrasi Akun Keluarga</span>
                                    <i class="fa-solid fa-user-plus"></i>
                                </a>
                                <a href="{{ route('kepala-keluarga.login') }}" id="hero-btn-login" class="bg-white border border-slate-200 hover:border-violet-300 hover:bg-violet-50/50 text-slate-700 font-bold py-4 px-8 rounded-2xl flex items-center gap-2 w-full sm:w-auto justify-center transition duration-300">
                                    <span>Login Portal Keluarga</span>
                                    <i class="fa-solid fa-right-to-bracket text-violet-600"></i>
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Visual Panel -->
                    <div class="lg:col-span-5 relative flex justify-center">
                        <div class="absolute -top-12 -left-12 w-72 h-72 bg-violet-300/20 rounded-full blur-3xl"></div>
                        <div class="absolute -bottom-12 -right-12 w-72 h-72 bg-blue-300/20 rounded-full blur-3xl"></div>
                        
                        <!-- Beautiful Mock Widget Card -->
                        <div class="relative bg-white border border-slate-100 rounded-[2.5rem] shadow-2xl p-8 max-w-sm w-full transition duration-500 hover:scale-[1.02]">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Informasi Layanan</span>
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                            </div>
                            
                            <div class="mt-6 space-y-5">
                                <div class="flex gap-4">
                                    <div class="h-10 w-10 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600 flex-shrink-0">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 font-semibold uppercase">Jam Operasional</p>
                                        <p class="text-sm font-bold text-slate-800">{{ $settings['hours_open'] }} - {{ $settings['hours_close'] }} WIB</p>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="h-10 w-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                                        <i class="fa-solid fa-map-location-dot"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 font-semibold uppercase">Lokasi Posyandu</p>
                                        <p class="text-sm font-bold text-slate-800 leading-relaxed">{{ $settings['address'] }}</p>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    <div class="h-10 w-10 rounded-xl bg-fuchsia-50 flex items-center justify-center text-fuchsia-600 flex-shrink-0">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400 font-semibold uppercase">Email Kontak</p>
                                        <p class="text-sm font-bold text-slate-800 break-all">{{ $settings['email'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-12 bg-white border-b border-slate-100" aria-label="Statistik Data Posyandu">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                    <!-- Keluarga -->
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-5 text-center transition duration-300 hover:bg-slate-50">
                        <div class="h-10 w-10 mx-auto rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-people-roof text-lg"></i>
                        </div>
                        <p class="heading-font text-3xl font-extrabold text-slate-900">{{ $stats['total_keluarga'] }}</p>
                        <p class="text-xs text-slate-500 font-semibold uppercase mt-1">Keluarga</p>
                    </div>
                    <!-- Balita -->
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-5 text-center transition duration-300 hover:bg-slate-50">
                        <div class="h-10 w-10 mx-auto rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-baby text-lg"></i>
                        </div>
                        <p class="heading-font text-3xl font-extrabold text-slate-900">{{ $stats['total_balita'] }}</p>
                        <p class="text-xs text-slate-500 font-semibold uppercase mt-1">Balita</p>
                    </div>
                    <!-- Ibu Hamil -->
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-5 text-center transition duration-300 hover:bg-slate-50">
                        <div class="h-10 w-10 mx-auto rounded-xl bg-fuchsia-50 text-fuchsia-600 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-person-pregnant text-lg"></i>
                        </div>
                        <p class="heading-font text-3xl font-extrabold text-slate-900">{{ $stats['total_ibu_hamil'] }}</p>
                        <p class="text-xs text-slate-500 font-semibold uppercase mt-1">Ibu Hamil</p>
                    </div>
                    <!-- Remaja -->
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-5 text-center transition duration-300 hover:bg-slate-50">
                        <div class="h-10 w-10 mx-auto rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-user-group text-lg"></i>
                        </div>
                        <p class="heading-font text-3xl font-extrabold text-slate-900">{{ $stats['total_remaja'] }}</p>
                        <p class="text-xs text-slate-500 font-semibold uppercase mt-1">Remaja</p>
                    </div>
                    <!-- Lansia -->
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-5 text-center transition duration-300 hover:bg-slate-50 col-span-2 md:col-span-1">
                        <div class="h-10 w-10 mx-auto rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-person-cane text-lg"></i>
                        </div>
                        <p class="heading-font text-3xl font-extrabold text-slate-900">{{ $stats['total_lansia'] }}</p>
                        <p class="text-xs text-slate-500 font-semibold uppercase mt-1">Lansia</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Schedules Section -->
        <section class="py-16 lg:py-24" id="jadwal-posyandu" aria-label="Jadwal Posyandu">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-bold text-violet-700 uppercase tracking-widest px-3 py-1 bg-violet-50 rounded-full">Agenda Kegiatan</span>
                    <h3 class="heading-font text-3xl sm:text-4xl font-extrabold text-slate-900 mt-4">Jadwal Layanan Rutin Posyandu</h3>
                    <p class="text-slate-600 mt-3">Silakan datang sesuai kategori dan jadwal yang ditentukan untuk memperoleh layanan pemeriksaan kesehatan yang maksimal.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($schedules as $sched)
                        <div class="bg-white border border-slate-100 rounded-3xl p-8 card-hover flex flex-col justify-between shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 right-0 h-24 w-24 bg-gradient-to-bl from-slate-50 to-transparent -mr-6 -mt-6 rounded-full"></div>
                            <div>
                                <!-- Header Card -->
                                <div class="flex items-center justify-between mb-6">
                                    <div class="h-14 w-14 rounded-2xl flex items-center justify-center {{ $sched['bg_color'] }} border shadow-sm text-xl">
                                        <i class="fa-solid {{ $sched['icon'] }}"></i>
                                    </div>
                                    <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-slate-100 text-slate-600">{{ $sched['badge'] }}</span>
                                </div>
                                
                                <h4 class="heading-font text-xl font-bold text-slate-900 mb-3">{{ $sched['title'] }}</h4>
                                <p class="text-slate-500 text-sm leading-relaxed mb-6">{{ $sched['description'] }}</p>
                            </div>

                            <div class="border-t border-slate-50 pt-5 mt-auto">
                                <div class="flex items-center gap-3 text-slate-700 mb-2">
                                    <i class="fa-solid fa-calendar-day text-violet-600 text-sm"></i>
                                    <span class="text-sm font-bold">{{ $sched['day'] }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-slate-600">
                                    <i class="fa-solid fa-clock text-slate-400 text-sm"></i>
                                    <span class="text-xs font-semibold">{{ $sched['time'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Information & News Section -->
        @if($settings['news_status'] === 'active')
            <section class="py-16 lg:py-24 bg-white border-y border-slate-100" id="berita-posyandu" aria-label="Informasi Penting">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-5 text-center lg:text-left">
                            <span class="text-xs font-bold text-fuchsia-700 uppercase tracking-widest px-3 py-1 bg-fuchsia-50 rounded-full">Pengumuman Terbaru</span>
                            <h3 class="heading-font text-3xl sm:text-4xl font-extrabold text-slate-900 mt-4 leading-tight">Informasi & Berita Penting Posyandu</h3>
                            <p class="text-slate-500 mt-4 leading-relaxed">Berikut adalah pemberitahuan terbaru mengenai layanan dan anjuran kesehatan dari kader Posyandu untuk seluruh keluarga.</p>
                            
                            <div class="mt-6 flex items-center justify-center lg:justify-start gap-3 text-sm text-slate-400 font-semibold">
                                <i class="fa-solid fa-calendar-check"></i>
                                <span>Dipublikasikan: {{ \Carbon\Carbon::parse($settings['news_published_at'])->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>

                        <div class="lg:col-span-7">
                            <div class="bg-gradient-to-br from-violet-50/50 to-fuchsia-50/50 border border-fuchsia-100/50 rounded-[2rem] p-8 sm:p-10 shadow-sm">
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="h-2 w-2 rounded-full bg-fuchsia-600"></span>
                                    <h4 class="heading-font text-lg font-bold text-violet-900 tracking-wide">
                                        {{ $settings['news_title'] }}
                                    </h4>
                                </div>
                                <p class="text-slate-700 font-medium mb-4 text-sm sm:text-base leading-relaxed">
                                    {{ $settings['news_summary'] }}
                                </p>
                                <div class="h-px bg-slate-200/50 my-6"></div>
                                <p class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                                    {{ $settings['news_content'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Health Edu Section -->
        <section class="py-16 lg:py-24" aria-label="Edukasi Kesehatan">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-xs font-bold text-blue-700 uppercase tracking-widest px-3 py-1 bg-blue-50 rounded-full">Edukasi Kesehatan</span>
                    <h3 class="heading-font text-3xl sm:text-4xl font-extrabold text-slate-900 mt-4">Tips Kesehatan Keluarga</h3>
                    <p class="text-slate-600 mt-3">Panduan ringkas dari ahli untuk mendukung kesehatan dan perkembangan anggota keluarga Anda.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Tips 1 -->
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg">Balita</span>
                        <h4 class="font-bold text-slate-900 mt-4 mb-2">{{ $settings['edu_balita_title'] }}</h4>
                        <p class="text-slate-500 text-xs leading-relaxed">{{ $settings['edu_balita_desc'] }}</p>
                    </div>
                    <!-- Tips 2 -->
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition">
                        <span class="text-xs font-bold text-fuchsia-600 bg-fuchsia-50 px-2.5 py-1 rounded-lg">Ibu Hamil</span>
                        <h4 class="font-bold text-slate-900 mt-4 mb-2">{{ $settings['edu_bumil_title'] }}</h4>
                        <p class="text-slate-500 text-xs leading-relaxed">{{ $settings['edu_bumil_desc'] }}</p>
                    </div>
                    <!-- Tips 3 -->
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">Lansia</span>
                        <h4 class="font-bold text-slate-900 mt-4 mb-2">{{ $settings['edu_lansia_title'] }}</h4>
                        <p class="text-slate-500 text-xs leading-relaxed">{{ $settings['edu_lansia_desc'] }}</p>
                    </div>
                    <!-- Tips 4 -->
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition">
                        <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-lg">Umum</span>
                        <h4 class="font-bold text-slate-900 mt-4 mb-2">{{ $settings['edu_umum_title'] }}</h4>
                        <p class="text-slate-500 text-xs leading-relaxed">{{ $settings['edu_umum_desc'] }}</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-16 border-t border-slate-800" aria-label="Footer Informasi">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 pb-12 border-b border-slate-800">
                <!-- Col 1 -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-10 w-10 rounded-xl bg-violet-600 flex items-center justify-center text-white">
                            <i class="fa-solid fa-house-medical"></i>
                        </div>
                        <h4 class="heading-font text-white font-extrabold text-lg">{{ $settings['app_name'] }}</h4>
                    </div>
                    <p class="text-sm leading-relaxed">
                        Aplikasi monitoring data kesehatan posyandu digital mandiri untuk memantau tumbuh kembang dan pelayanan kesehatan secara real-time.
                    </p>
                </div>
                <!-- Col 2 -->
                <div>
                    <h5 class="heading-font text-white font-bold text-sm uppercase tracking-wider mb-6">Kontak Posyandu</h5>
                    <ul class="space-y-4 text-sm">
                        <li class="flex gap-3">
                            <i class="fa-solid fa-map-marker-alt text-violet-500 mt-1 flex-shrink-0"></i>
                            <span>{{ $settings['address'] }}</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fa-solid fa-envelope text-violet-500 mt-1 flex-shrink-0"></i>
                            <span>{{ $settings['email'] }}</span>
                        </li>
                        <li class="flex gap-3">
                            <i class="fa-solid fa-clock text-violet-500 mt-1 flex-shrink-0"></i>
                            <span>Jam Buka: {{ $settings['hours_open'] }} - {{ $settings['hours_close'] }} WIB</span>
                        </li>
                    </ul>
                </div>
                <!-- Col 3 -->
                <div>
                    <h5 class="heading-font text-white font-bold text-sm uppercase tracking-wider mb-6">Akses Sistem</h5>
                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('kepala-keluarga.login') }}" class="text-slate-400 hover:text-white text-sm font-semibold transition">
                            <i class="fa-solid fa-circle-chevron-right text-violet-500 mr-2 text-xs"></i> Portal Kepala Keluarga
                        </a>
                        <a href="{{ route('kepala-keluarga.register') }}" class="text-slate-400 hover:text-white text-sm font-semibold transition">
                            <i class="fa-solid fa-circle-chevron-right text-violet-500 mr-2 text-xs"></i> Registrasi Kepala Keluarga
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs">
                <p>&copy; 2026 {{ $settings['app_name'] }}. Hak Cipta Dilindungi.</p>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <span class="hover:text-white transition">Posyandu Digital Terpadu</span>
                    <span class="hover:text-white transition">Kebijakan Privasi</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    const icon = menuBtn.querySelector('i');
                    if (mobileMenu.classList.contains('hidden')) {
                        icon.className = 'fa-solid fa-bars text-xl';
                    } else {
                        icon.className = 'fa-solid fa-xmark text-xl';
                    }
                });
            }
        });
    </script>
</body>
</html>
