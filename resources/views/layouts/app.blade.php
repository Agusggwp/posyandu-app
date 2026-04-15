<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Posyandu App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(60px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        :root {
            --sidebar-width: 280px;
            --line: #e2e8f0;
            --text: #0f172a;
            --muted: #64748b;
            --primary: #2563eb;
            --primary-soft: #e0e7ff;
        }

        * {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f0f4f8 0%, #f8fafc 100%);
            color: var(--text);
            margin: 0;
            font-family: 'Inter', sans-serif;
        }

        .app-layout {
            display: grid;
            grid-template-columns: var(--sidebar-width) 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background: #ffffff;
            border-right: 1px solid var(--line);
            padding: 24px 16px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            overflow-y: auto;
            z-index: 130;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            animation: slideInLeft 0.5s ease-out;
            transition: left .25s ease;
        }

        .sidebar-header {
            padding: 12px 12px 20px 12px;
            border-bottom: 1px solid var(--line);
            margin-bottom: 18px;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-logo-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid #dbeafe;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .sidebar-logo-text h2 {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .sidebar-logo-text p {
            display: none;
        }

        .sidebar-menu {
            flex: 1;
        }

        .menu-section {
            margin-bottom: 16px;
        }

        .menu-section-title {
            font-size: 12px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 0 12px;
            margin-bottom: 8px;
            display: block;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .menu-item:hover {
            background: #f1f5f9;
            color: var(--primary);
        }

        .menu-item.active {
            background: linear-gradient(135deg, var(--primary-soft) 0%, #f0f4ff 100%);
            color: var(--primary);
            font-weight: 600;
        }

        .menu-item-icon {
            width: 20px;
            text-align: center;
            flex-shrink: 0;
            color: inherit;
            font-size: 15px;
        }

        .sidebar-footer {
            padding-top: 14px;
            border-top: 1px solid var(--line);
            margin-top: auto;
        }

        .sidebar-footer-btn {
            width: 100%;
            padding: 12px 16px;
            border-radius: 8px;
            border: none;
            background: #3b4556;
            color: white;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .sidebar-footer-btn:hover {
            background: #2c3240;
            transform: translateY(-2px);
        }

        .main-panel {
            grid-column: 2;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            animation: slideInRight 0.5s ease-out;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 40;
            backdrop-filter: blur(20px);
            background: linear-gradient(180deg, rgba(255, 255, 255, .96) 0%, rgba(248, 250, 252, .95) 100%);
            border-bottom: 1px solid rgba(0, 0, 0, .08);
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .topbar-title {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .topbar-sub {
            margin: 2px 0 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        .user-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #7c3aed 0%, #2563eb 100%);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            box-shadow: 0 8px 20px rgba(124, 58, 237, .3);
        }

        .main-content {
            padding: 24px;
            flex: 1;
        }

        .flash {
            margin-bottom: 14px;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid;
        }

        .flash.success { background: #ecfdf5; border-color: #a7f3d0; color: #065f46; }
        .flash.error { background: #fff1f2; border-color: #fecdd3; color: #9f1239; }
        .flash.info { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }

        .menu-toggle {
            display: none;
            position: fixed;
            top: 14px;
            right: 14px;
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #7c3aed 0%, #2563eb 100%);
            border: none;
            border-radius: 10px;
            color: white;
            z-index: 150;
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3);
            align-items: center;
            justify-content: center;
        }

        .menu-toggle:hover {
            transform: scale(1.05);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(2, 6, 23, 0.35);
            z-index: 120;
            pointer-events: none;
        }

        .sidebar-overlay.active {
            display: block;
            pointer-events: auto;
        }

        @media (max-width: 992px) {
            .app-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                left: calc(-1 * var(--sidebar-width));
            }

            .sidebar.active {
                left: 0;
            }

            .main-panel {
                grid-column: 1;
            }

            .topbar {
                padding-right: 64px;
            }

            .menu-toggle {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                cursor: pointer;
                opacity: 1;
                visibility: visible;
            }

            .main-content {
                padding: 16px;
            }

            .menu-item {
                padding: 12px;
            }

            .menu-section-title {
                margin-top: 6px;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    @auth
    <button class="menu-toggle" id="menu-toggle" aria-label="Toggle sidebar">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M4 7H20" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
            <path d="M4 12H20" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
            <path d="M4 17H20" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
        </svg>
    </button>
    <div class="sidebar-overlay" id="sidebar-overlay" aria-hidden="true"></div>
    @endauth

    @auth
    <div class="app-layout">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <i class="fa-solid fa-house-medical"></i>
                    </div>
                    <div class="sidebar-logo-text">
                        <h2>Sistem Posyandu</h2>
                    </div>
                </div>
            </div>

            <nav class="sidebar-menu">
                <div class="menu-section">
                    <span class="menu-section-title">Main</span>
                    <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-chart-line"></i></span><span>Dashboard</span></a>
                </div>

                @canany(['manage_keluarga', 'manage_balita', 'manage_ibu_hamil', 'manage_lansia'])
                <div class="menu-section">
                    <span class="menu-section-title">Master Data</span>
                    @can('manage_keluarga')
                    <a href="{{ route('keluarga.index') }}" class="menu-item {{ request()->routeIs('keluarga.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-people-roof"></i></span><span>Keluarga</span></a>
                    @endcan
                    @can('manage_balita')
                    <a href="{{ route('balita.index') }}" class="menu-item {{ request()->routeIs('balita.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-baby"></i></span><span>Balita</span></a>
                    @endcan
                    @can('manage_ibu_hamil')
                    <a href="{{ route('ibu-hamil.index') }}" class="menu-item {{ request()->routeIs('ibu-hamil.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-person-pregnant"></i></span><span>Ibu Hamil</span></a>
                    <a href="{{ route('nifas.index') }}" class="menu-item {{ request()->routeIs('nifas.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-child-reaching"></i></span><span>Nifas</span></a>
                    @endcan
                    @can('manage_lansia')
                    <a href="{{ route('remaja.index') }}" class="menu-item {{ request()->routeIs('remaja.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-user-group"></i></span><span>Remaja</span></a>
                    <a href="{{ route('lansia.index') }}" class="menu-item {{ request()->routeIs('lansia.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-person-cane"></i></span><span>Lansia</span></a>
                    @endcan
                </div>
                @endcanany

                @can('view_data')
                <div class="menu-section">
                    <span class="menu-section-title">Pemeriksaan</span>
                    <a href="{{ route('pemeriksaan-balita.index') }}" class="menu-item {{ request()->routeIs('pemeriksaan-balita.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-stethoscope"></i></span><span>Pemeriksaan Balita</span></a>
                    <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="menu-item {{ request()->routeIs('pemeriksaan-ibu-hamil.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-syringe"></i></span><span>Pemeriksaan Ibu Hamil</span></a>
                    <a href="{{ route('pemeriksaan-nifas.index') }}" class="menu-item {{ request()->routeIs('pemeriksaan-nifas.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-notes-medical"></i></span><span>Pemeriksaan Nifas</span></a>
                    <a href="{{ route('pemeriksaan-remaja.index') }}" class="menu-item {{ request()->routeIs('pemeriksaan-remaja.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-heart-pulse"></i></span><span>Pemeriksaan Remaja</span></a>
                    <a href="{{ route('pemeriksaan-lansia.index') }}" class="menu-item {{ request()->routeIs('pemeriksaan-lansia.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-file-medical"></i></span><span>Pemeriksaan Lansia</span></a>
                </div>
                @endcan

                @can('view_reports')
                <div class="menu-section">
                    <span class="menu-section-title">Laporan</span>
                    <a href="{{ route('laporan.index') }}" class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-chart-column"></i></span><span>Laporan</span></a>
                </div>
                @endcan

                @admin
                <div class="menu-section">
                    <span class="menu-section-title">Admin</span>
                    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-gauge-high"></i></span><span>Admin Dashboard</span></a>
                    <a href="{{ route('users.index') }}" class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-users-gear"></i></span><span>Kelola User</span></a>
                    <a href="{{ route('roles.index') }}" class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-user-shield"></i></span><span>Kelola Role</span></a>
                    <a href="{{ route('admin.activity-logs') }}" class="menu-item {{ request()->routeIs('admin.activity-logs') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-file-lines"></i></span><span>Activity Logs</span></a>
                    <a href="{{ route('admin.system-info') }}" class="menu-item {{ request()->routeIs('admin.system-info') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-circle-info"></i></span><span>System Info</span></a>
                    <a href="{{ route('admin.settings') }}" class="menu-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><span class="menu-item-icon"><i class="fa-solid fa-sliders"></i></span><span>Pengaturan</span></a>
                </div>
                @endadmin
            </nav>

            <div class="sidebar-footer">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-footer-btn">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <section class="main-panel">
            <header class="topbar">
                <div>
                    <h1 class="topbar-title">{{ trim($__env->yieldContent('page_title', 'Dashboard')) }}</h1>
                    <p class="topbar-sub">Sistem Informasi Kesehatan Keluarga</p>
                </div>
                <div class="user-badge">
                    <span>{{ Auth::user()->name }}</span>
                    <span class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
            </header>

            <main class="main-content">
                @if (session('success'))
                    <div class="flash success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="flash error">{{ session('error') }}</div>
                @endif
                @if (session('info'))
                    <div class="flash info">{{ session('info') }}</div>
                @endif

                @yield('content')
            </main>
        </section>
    </div>
    @else
    <div id="app">
        <main class="py-8">
            <div class="container-fluid mx-auto px-4">
                @yield('content')
            </div>
        </main>
    </div>
    @endauth

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menu-toggle');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
                sidebar.classList.add('active');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.add('active');
                }
            }

            function closeSidebar() {
                sidebar.classList.remove('active');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove('active');
                }
            }

            if (sidebar && menuToggle) {
                menuToggle.addEventListener('click', function () {
                    if (sidebar.classList.contains('active')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });

                document.addEventListener('click', function (event) {
                    if (window.innerWidth > 992) return;
                    if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                        closeSidebar();
                    }
                });

                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', closeSidebar);
                }

                sidebar.querySelectorAll('.menu-item').forEach(function (menuLink) {
                    menuLink.addEventListener('click', function () {
                        if (window.innerWidth <= 992) {
                            closeSidebar();
                        }
                    });
                });

                window.addEventListener('resize', function () {
                    if (window.innerWidth > 992) {
                        closeSidebar();
                    }
                });
            }

            document.querySelectorAll('.js-keluarga-search').forEach(function (searchInput) {
                const targetSelector = searchInput.getAttribute('data-target') || '#kepala_keluarga_id';
                const keluargaSelect = document.querySelector(targetSelector);

                if (!keluargaSelect) {
                    return;
                }

                const allOptions = Array.from(keluargaSelect.options).map(function (opt) {
                    return {
                        value: opt.value,
                        text: opt.text,
                        selected: opt.selected,
                    };
                });

                searchInput.addEventListener('input', function () {
                    const keyword = searchInput.value.trim().toLowerCase();
                    const currentValue = keluargaSelect.value;

                    keluargaSelect.innerHTML = '';

                    allOptions.forEach(function (opt) {
                        const isPlaceholder = opt.value === '';
                        const matches = opt.text.toLowerCase().includes(keyword);
                        const keepCurrent = opt.value !== '' && opt.value === currentValue;

                        if (isPlaceholder || matches || keepCurrent) {
                            const optionEl = document.createElement('option');
                            optionEl.value = opt.value;
                            optionEl.text = opt.text;
                            optionEl.selected = opt.value === currentValue || (currentValue === '' && opt.selected);
                            keluargaSelect.appendChild(optionEl);
                        }
                    });
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
