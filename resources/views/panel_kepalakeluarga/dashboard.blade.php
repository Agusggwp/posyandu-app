<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Keluarga - POSYANDU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px white inset !important;
            -webkit-text-fill-color: #333 !important;
        }

        .nav-btn {
            background-color: transparent !important;
            box-shadow: none !important;
        }

        .nav-btn.active {
            background-color: #8e4682 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3), inset 0 2px 4px rgba(0, 0, 0, 0.2) !important;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <div class="w-64 text-white flex flex-col fixed h-screen" style="background-color: #a6599e;">
            <div class="p-6 border-b text-white" style="border-color: #8e4682;">
                <div class="flex items-center gap-3">
                    <i class="fas fa-home text-3xl"></i>
                    <div>
                        <h1 class="text-xl font-bold">POSYANDU</h1>
                        <p class="text-xs" style="color: #e8d5e8;">Kepala Keluarga</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <button onclick="showSection('dashboard', this)" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg text-white font-medium transition" style="color: white;" onmouseover="if(!this.classList.contains('active')) this.style.backgroundColor='#8e4682'" onmouseout="if(!this.classList.contains('active')) this.style.backgroundColor='transparent'">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>Dashboard</span>
                </button>
                <button onclick="showSection('anggota-keluarga', this)" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg transition" style="color: white;" onmouseover="if(!this.classList.contains('active')) this.style.backgroundColor='#8e4682'" onmouseout="if(!this.classList.contains('active')) this.style.backgroundColor='transparent'">
                    <i class="fas fa-users w-5"></i>
                    <span>Anggota Keluarga</span>
                </button>
                <button onclick="showSection('riwayat-pemeriksaan', this)" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg transition" style="color: white;" onmouseover="if(!this.classList.contains('active')) this.style.backgroundColor='#8e4682'" onmouseout="if(!this.classList.contains('active')) this.style.backgroundColor='transparent'">
                    <i class="fas fa-history w-5"></i>
                    <span>Riwayat Pemeriksaan</span>
                </button>
                <button onclick="showSection('profile', this)" class="nav-btn w-full flex items-center gap-3 px-4 py-3 rounded-lg transition" style="color: white;" onmouseover="if(!this.classList.contains('active')) this.style.backgroundColor='#8e4682'" onmouseout="if(!this.classList.contains('active')) this.style.backgroundColor='transparent'">
                    <i class="fas fa-user-circle w-5"></i>
                    <span>Profile Saya</span>
                </button>
            </nav>

            <div class="p-4 border-t" style="border-color: #8e4682;">
                <form method="POST" action="{{ route('kepala-keluarga.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg transition" style="background-color: white; color: #ef4444; border: 1px solid #fecaca;" onmouseover="this.style.backgroundColor='#fee2e2'; this.style.color='#dc2626';" onmouseout="this.style.backgroundColor='white'; this.style.color='#ef4444';">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="ml-64 flex-1 overflow-auto">
            <div class="bg-white border-b border-gray-200 px-6 py-6 flex justify-between items-center sticky top-0 z-10">
                <div>
                    <h2 id="page-title" class="text-2xl font-bold text-gray-800">Dashboard</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-700">{{ $kepalaKeluarga->nama_lengkap }}</p>
                        <p class="text-xs text-gray-500">NIK: {{ $kepalaKeluarga->no_nik ?: '-' }}</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($kepalaKeluarga->nama_lengkap) }}&background=a6599e&color=fff" alt="Avatar" class="w-10 h-10 rounded-full">
                </div>
            </div>

            <div class="p-8">
                @include('panel_kepalakeluarga.dashboard.partials.summary')
                @include('panel_kepalakeluarga.dashboard.partials.member-cards')
                @include('panel_kepalakeluarga.dashboard.partials.member-detail-modal')
                @include('panel_kepalakeluarga.dashboard.partials.riwayat-pemeriksaan')
                @include('panel_kepalakeluarga.dashboard.partials.profile')
            </div>
        </div>
    </div>

    @include('panel_kepalakeluarga.dashboard.partials.news-detail-modal')

    @include('panel_kepalakeluarga.dashboard.partials.scripts')
</body>
</html>
