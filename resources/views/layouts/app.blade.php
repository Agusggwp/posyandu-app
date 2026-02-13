<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Posyandu App</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
    <div id="app">
        <!-- Navbar -->
        <nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-slate-200 sticky top-0 z-50">
            <div class="container-fluid mx-auto px-4">
                <div class="flex justify-between items-center py-3">
                    <div class="flex items-center space-x-4">
                        <a href="{{ url('/') }}" class="text-slate-800 text-xl font-bold flex items-center group">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center mr-3 shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                            </div>
                            <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Posyandu</span>
                        </a>
                        @auth
                        <div class="hidden md:flex space-x-1">
                            <a href="{{ route('dashboard') }}" class="text-slate-700 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-xl transition-all duration-200 font-medium text-sm">
                                Dashboard
                            </a>
                            
                            <div class="relative dropdown-container">
                                <button onclick="toggleDropdown('masterDataDropdown')" class="text-slate-700 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-xl transition-all duration-200 font-medium text-sm inline-flex items-center">
                                    Master Data
                                    <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <div id="masterDataDropdown" class="absolute left-0 mt-2 w-56 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-slate-200 hidden z-50 overflow-hidden">
                                    <div class="py-2">
                                        <a href="{{ route('keluarga.index') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">👨‍👩‍👧‍👦</span>
                                            <span class="text-sm font-medium">Keluarga</span>
                                        </a>
                                        <a href="{{ route('balita.index') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">👶</span>
                                            <span class="text-sm font-medium">Balita</span>
                                        </a>
                                        <a href="{{ route('ibu-hamil.index') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-violet-50 hover:text-violet-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">🤰</span>
                                            <span class="text-sm font-medium">Ibu Hamil</span>
                                        </a>
                                        <a href="{{ route('lansia.index') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-amber-50 hover:text-amber-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">👴</span>
                                            <span class="text-sm font-medium">Lansia</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="relative dropdown-container">
                                <button onclick="toggleDropdown('pemeriksaanDropdown')" class="text-slate-700 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-xl transition-all duration-200 font-medium text-sm inline-flex items-center">
                                    Pemeriksaan
                                    <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <div id="pemeriksaanDropdown" class="absolute left-0 mt-2 w-64 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-slate-200 hidden z-50 overflow-hidden">
                                    <div class="py-2">
                                        <a href="{{ route('pemeriksaan-balita.index') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">🩺</span>
                                            <span class="text-sm font-medium">Pemeriksaan Balita</span>
                                        </a>
                                        <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-violet-50 hover:text-violet-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">💉</span>
                                            <span class="text-sm font-medium">Pemeriksaan Ibu Hamil</span>
                                        </a>
                                        <a href="{{ route('pemeriksaan-lansia.index') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-amber-50 hover:text-amber-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">📋</span>
                                            <span class="text-sm font-medium">Pemeriksaan Lansia</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('laporan.index') }}" class="text-slate-700 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-xl transition-all duration-200 font-medium text-sm">
                                Laporan
                            </a>

                            @admin
                            <div class="relative dropdown-container">
                                <button onclick="toggleDropdown('adminDropdown')" class="text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 px-4 py-2 rounded-xl transition-all duration-200 font-medium text-sm inline-flex items-center shadow-md">
                                    ⚙️ Admin
                                    <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <div id="adminDropdown" class="absolute left-0 mt-2 w-56 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-indigo-200 hidden z-50 overflow-hidden">
                                    <div class="py-2">
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">📊</span>
                                            <span class="text-sm font-medium">Admin Dashboard</span>
                                        </a>
                                        <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-purple-50 hover:text-purple-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">👥</span>
                                            <span class="text-sm font-medium">Kelola User</span>
                                        </a>
                                        <a href="{{ route('roles.index') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">🔐</span>
                                            <span class="text-sm font-medium">Kelola Role</span>
                                        </a>
                                        <div class="border-t border-gray-100 my-1"></div>
                                        <a href="{{ route('admin.activity-logs') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-green-50 hover:text-green-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">📝</span>
                                            <span class="text-sm font-medium">Activity Logs</span>
                                        </a>
                                        <a href="{{ route('admin.system-info') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">ℹ️</span>
                                            <span class="text-sm font-medium">System Info</span>
                                        </a>
                                        <div class="border-t border-gray-100 my-1"></div>
                                        <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2.5 text-slate-700 hover:bg-slate-50 hover:text-slate-600 transition-colors duration-150">
                                            <span class="mr-3 text-lg">⚙️</span>
                                            <span class="text-sm font-medium">Pengaturan</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endadmin
                        </div>
                        @endauth
                    </div>

                    <div class="flex items-center space-x-3">
                        @guest
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="text-slate-700 hover:text-indigo-600 font-medium text-sm">Login</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-xl hover:shadow-lg transition-all duration-200 font-medium text-sm">Register</a>
                            @endif
                        @else
                            <div class="relative dropdown-container">
                                <button onclick="toggleDropdown('userDropdown')" class="flex items-center space-x-2 text-slate-700 hover:bg-slate-100 px-3 py-2 rounded-xl transition-all duration-200">
                                    <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-md">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                    <span class="font-medium text-sm hidden md:block">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <div id="userDropdown" class="absolute right-0 mt-2 w-56 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-slate-200 hidden z-50 overflow-hidden">
                                    <div class="px-4 py-3 border-b border-slate-200 bg-gradient-to-br from-indigo-50 to-purple-50">
                                        <p class="text-xs text-slate-600 mb-1">Signed in as</p>
                                        <p class="font-semibold text-sm text-slate-800">{{ Auth::user()->email }}</p>
                                        <p class="text-xs text-indigo-600 mt-1">Role: {{ Auth::user()->role->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="py-2">
                                        <a href="{{ route('logout') }}" 
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                           class="flex items-center px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors duration-150">
                                            <span class="mr-3">🚪</span>
                                            <span class="text-sm font-medium">Logout</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Mobile menu button -->
                            <button onclick="toggleMobileMenu()" class="md:hidden text-slate-700 hover:text-indigo-600 p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                        @endguest
                    </div>
                </div>

                <!-- Mobile menu -->
                @auth
                <div id="mobileMenu" class="hidden md:hidden pb-4">
                    <div class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="block text-slate-700 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-xl transition-all duration-200 font-medium text-sm">
                            Dashboard
                        </a>
                        
                        <div class="border-t border-slate-200 my-2"></div>
                        <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Master Data</p>
                        <a href="{{ route('keluarga.index') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-150">
                            <span class="mr-2">👨‍👩‍👧‍👦</span>
                            <span class="text-sm">Keluarga</span>
                        </a>
                        <a href="{{ route('balita.index') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors duration-150">
                            <span class="mr-2">👶</span>
                            <span class="text-sm">Balita</span>
                        </a>
                        <a href="{{ route('ibu-hamil.index') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-violet-50 hover:text-violet-600 transition-colors duration-150">
                            <span class="mr-2">🤰</span>
                            <span class="text-sm">Ibu Hamil</span>
                        </a>
                        <a href="{{ route('lansia.index') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-600 transition-colors duration-150">
                            <span class="mr-2">👴</span>
                            <span class="text-sm">Lansia</span>
                        </a>

                        <div class="border-t border-slate-200 my-2"></div>
                        <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pemeriksaan</p>
                        <a href="{{ route('pemeriksaan-balita.index') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors duration-150">
                            <span class="mr-2">🩺</span>
                            <span class="text-sm">Pemeriksaan Balita</span>
                        </a>
                        <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-violet-50 hover:text-violet-600 transition-colors duration-150">
                            <span class="mr-2">💉</span>
                            <span class="text-sm">Pemeriksaan Ibu Hamil</span>
                        </a>
                        <a href="{{ route('pemeriksaan-lansia.index') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-600 transition-colors duration-150">
                            <span class="mr-2">📋</span>
                            <span class="text-sm">Pemeriksaan Lansia</span>
                        </a>

                        <div class="border-t border-slate-200 my-2"></div>
                        <a href="{{ route('laporan.index') }}" class="block text-slate-700 hover:text-indigo-600 hover:bg-indigo-50 px-4 py-2 rounded-xl transition-all duration-200 font-medium text-sm">
                            Laporan
                        </a>

                        @admin
                        <div class="border-t border-slate-200 my-2"></div>
                        <p class="px-4 text-xs font-semibold text-indigo-600 uppercase tracking-wider">Admin Menu</p>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-150">
                            <span class="mr-2">📊</span>
                            <span class="text-sm">Admin Dashboard</span>
                        </a>
                        <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-purple-50 hover:text-purple-600 transition-colors duration-150">
                            <span class="mr-2">👥</span>
                            <span class="text-sm">Kelola User</span>
                        </a>
                        <a href="{{ route('roles.index') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                            <span class="mr-2">🔐</span>
                            <span class="text-sm">Kelola Role</span>
                        </a>
                        <a href="{{ route('admin.activity-logs') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-green-50 hover:text-green-600 transition-colors duration-150">
                            <span class="mr-2">📝</span>
                            <span class="text-sm">Activity Logs</span>
                        </a>
                        <a href="{{ route('admin.system-info') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-150">
                            <span class="mr-2">ℹ️</span>
                            <span class="text-sm">System Info</span>
                        </a>
                        <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-slate-600 transition-colors duration-150">
                            <span class="mr-2">⚙️</span>
                            <span class="text-sm">Pengaturan</span>
                        </a>
                        @endadmin
                    </div>
                </div>
                @endauth
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-8">
            <div class="container-fluid mx-auto px-4">
                @if (session('success'))
                    <div class="bg-white border-l-4 border-emerald-500 rounded-xl shadow-sm px-6 py-4 mb-6 flex items-start" role="alert">
                        <div class="flex-shrink-0 mr-4">
                            <svg class="w-6 h-6 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="flex-shrink-0 ml-4 text-slate-400 hover:text-slate-600" onclick="this.parentElement.style.display='none'">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-white border-l-4 border-rose-500 rounded-xl shadow-sm px-6 py-4 mb-6 flex items-start" role="alert">
                        <div class="flex-shrink-0 mr-4">
                            <svg class="w-6 h-6 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-rose-800">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="flex-shrink-0 ml-4 text-slate-400 hover:text-slate-600" onclick="this.parentElement.style.display='none'">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="bg-white border-l-4 border-blue-500 rounded-xl shadow-sm px-6 py-4 mb-6 flex items-start" role="alert">
                        <div class="flex-shrink-0 mr-4">
                            <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-800">{{ session('info') }}</p>
                        </div>
                        <button type="button" class="flex-shrink-0 ml-4 text-slate-400 hover:text-slate-600" onclick="this.parentElement.style.display='none'">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white/80 backdrop-blur-md border-t border-slate-200 mt-16">
            <div class="container-fluid mx-auto px-4 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-sm text-slate-600">
                        &copy; {{ date('Y') }} <span class="font-semibold text-slate-800">Posyandu App</span>. All rights reserved.
                    </div>
                    <div class="flex items-center space-x-4 text-sm text-slate-600">
                        <span>Made with</span>
                        <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        <span>by Developer</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <script>
        // Toggle dropdown menus
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const allDropdowns = document.querySelectorAll('.dropdown-container > div[id$="Dropdown"]');
            
            // Close all other dropdowns
            allDropdowns.forEach(dd => {
                if (dd.id !== dropdownId) {
                    dd.classList.add('hidden');
                }
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        }

        // Toggle mobile menu
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const isDropdownButton = event.target.closest('[onclick^="toggleDropdown"]');
            const isDropdownContent = event.target.closest('[id$="Dropdown"]');
            
            if (!isDropdownButton && !isDropdownContent) {
                const allDropdowns = document.querySelectorAll('.dropdown-container > div[id$="Dropdown"]');
                allDropdowns.forEach(dd => dd.classList.add('hidden'));
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenuButton = event.target.closest('[onclick="toggleMobileMenu()"]');
            const mobileMenu = document.getElementById('mobileMenu');
            
            if (!mobileMenuButton && !event.target.closest('#mobileMenu')) {
                if (mobileMenu) {
                    mobileMenu.classList.add('hidden');
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
