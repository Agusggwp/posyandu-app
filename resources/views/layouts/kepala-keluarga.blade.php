@php
    $kkUser = auth('kepala_keluarga')->user();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Portal Keluarga POSYANDU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        .active-section-btn {
            background-color: #f5f3ff !important;
            color: #4f46e5 !important;
            border-left-color: #4f46e5 !important;
        }
        .active-section-btn i {
            color: #4f46e5 !important;
        }
    </style>
</head>
<body class="bg-slate-50/50 text-slate-800 antialiased min-h-screen">
    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 bottom-0 left-0 z-40 w-64 bg-white border-r border-slate-100 shadow-sm flex flex-col transition-transform -translate-x-full lg:translate-x-0 duration-300">
        <!-- Sidebar Brand -->
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-md shadow-indigo-100">
                    <i class="fa-solid fa-house-chimney-medical text-lg"></i>
                </div>
                <div>
                    <h1 class="text-base font-bold text-slate-900 leading-tight">POSYANDU</h1>
                    <p class="text-xs text-indigo-600 font-semibold">Portal Keluarga</p>
                </div>
            </div>
            <!-- Close button for mobile -->
            <button onclick="toggleSidebar()" class="lg:hidden p-1.5 rounded-lg hover:bg-slate-50 text-slate-500">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        @php
            $isDashboard = Request::routeIs('kepala-keluarga.dashboard');
        @endphp
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a href="{{ $isDashboard ? 'javascript:void(0)' : route('kepala-keluarga.dashboard', ['section' => 'dashboard']) }}" 
               onclick="{{ $isDashboard ? "showSection('dashboard', this)" : "" }}" 
               class="nav-btn flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm transition text-slate-600 hover:bg-slate-50 border-l-4 border-transparent"
               data-section-btn="dashboard">
                <i class="fa-solid fa-chart-line text-indigo-500 w-5 text-center text-base"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ $isDashboard ? 'javascript:void(0)' : route('kepala-keluarga.dashboard', ['section' => 'anggota-keluarga']) }}" 
               onclick="{{ $isDashboard ? "showSection('anggota-keluarga', this)" : "" }}" 
               class="nav-btn flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm transition text-slate-600 hover:bg-slate-50 border-l-4 border-transparent"
               data-section-btn="anggota-keluarga">
                <i class="fa-solid fa-users text-indigo-500 w-5 text-center text-base"></i>
                <span>Anggota Keluarga</span>
            </a>
            <a href="{{ $isDashboard ? 'javascript:void(0)' : route('kepala-keluarga.dashboard', ['section' => 'riwayat-pemeriksaan']) }}" 
               onclick="{{ $isDashboard ? "showSection('riwayat-pemeriksaan', this)" : "" }}" 
               class="nav-btn flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm transition text-slate-600 hover:bg-slate-50 border-l-4 border-transparent"
               data-section-btn="riwayat-pemeriksaan">
                <i class="fa-solid fa-clock-rotate-left text-indigo-500 w-5 text-center text-base"></i>
                <span>Riwayat Pemeriksaan</span>
            </a>
            <a href="{{ $isDashboard ? 'javascript:void(0)' : route('kepala-keluarga.dashboard', ['section' => 'profile']) }}" 
               onclick="{{ $isDashboard ? "showSection('profile', this)" : "" }}" 
               class="nav-btn flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm transition text-slate-600 hover:bg-slate-50 border-l-4 border-transparent"
               data-section-btn="profile">
                <i class="fa-solid fa-circle-user text-indigo-500 w-5 text-center text-base"></i>
                <span>Profile Saya</span>
            </a>
        </nav>

        <!-- Logout Section -->
        <div class="p-4 border-t border-slate-100">
            <form method="POST" action="{{ route('kepala-keluarga.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-2xl border border-rose-100 bg-rose-50/50 hover:bg-rose-50 text-rose-600 transition font-bold text-sm cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket text-base"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Overlay Backdrop for mobile -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm lg:hidden"></div>

    <!-- Main Wrapper -->
    <div class="lg:pl-64 flex flex-col min-h-screen">
        <!-- Header -->
        <header class="sticky top-0 z-20 flex h-20 items-center justify-between border-b border-slate-100 bg-white/80 backdrop-blur-md px-6 py-4 shadow-sm">
            <div class="flex items-center gap-4">
                <!-- Hamburger button for mobile -->
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl border border-slate-100 hover:bg-slate-50 text-slate-600">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div>
                    <h2 id="page-title" class="text-xl font-extrabold text-slate-800">@yield('page-title', 'Dashboard')</h2>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                @if($kkUser)
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-slate-800">{{ $kkUser->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500 font-semibold">NIK: {{ $kkUser->no_nik ?: '-' }}</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($kkUser->nama_lengkap) }}&background=6366f1&color=fff&bold=true" alt="Avatar" class="w-10 h-10 rounded-xl border border-slate-100">
                @endif
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow p-4 sm:p-6">
            @yield('content')
        </main>
    </div>

    <!-- Script to toggle sidebar on mobile -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
