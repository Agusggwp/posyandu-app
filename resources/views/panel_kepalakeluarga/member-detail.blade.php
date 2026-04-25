<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Anggota Keluarga - POSYANDU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
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
<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen">
        <aside class="fixed h-screen w-64 bg-fuchsia-700 text-white">
            <div class="border-b border-fuchsia-500 p-6 text-white">
                <div class="flex items-center gap-3">
                    <i class="fas fa-home text-3xl"></i>
                    <div>
                        <h1 class="text-xl font-bold">POSYANDU</h1>
                        <p class="text-xs text-fuchsia-100">Kepala Keluarga</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 space-y-2 px-4 py-6">
                <a href="{{ route('kepala-keluarga.dashboard') }}" class="nav-btn active flex w-full items-center gap-3 rounded-lg px-4 py-3 text-left font-medium text-white transition">
                    <i class="fas fa-user-circle w-5"></i>
                    <span>Detail Anggota</span>
                </a>
            </nav>

            <div class="border-t border-fuchsia-500 p-4">
                <form method="POST" action="{{ route('kepala-keluarga.logout') }}">
                    @csrf
                    <button class="flex w-full items-center gap-3 rounded-lg border border-rose-200 bg-white px-4 py-3 text-rose-500 transition hover:bg-rose-50 hover:text-rose-600">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="ml-64 flex-1 overflow-auto">
            <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-200 bg-white px-6 py-6">
                <div>
                    <p class="text-xs font-semibold uppercase text-gray-500">Panel Kepala Keluarga</p>
                    <h2 class="text-2xl font-bold text-gray-800">Detail Anggota</h2>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-700">{{ $memberName }}</p>
                    <p class="text-xs text-gray-500">Kategori: {{ $memberTypeLabel }}</p>
                </div>
            </div>

            <div class="p-8">
                <div class="mb-6 flex flex-wrap gap-2">
                    <a href="{{ route('kepala-keluarga.anggota.pemeriksaan', ['tipe' => $memberType, 'id' => $member->id]) }}" class="inline-flex items-center rounded-lg bg-orange-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-600">
                        <i class="fa-solid fa-chart-column mr-2"></i>Lihat Pemeriksaan
                    </a>
                    <a href="{{ route('kepala-keluarga.dashboard') }}" class="inline-flex items-center rounded-lg bg-slate-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-700">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali Dashboard
                    </a>
                </div>

                <div class="rounded-lg bg-white p-6 shadow">
                    <h3 class="mb-4 text-lg font-bold text-gray-800">Data Lengkap Anggota</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach($displayAttributes as $key => $value)
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                <p class="text-xs font-semibold uppercase text-gray-500">{{ str_replace('_', ' ', $key) }}</p>
                                <p class="mt-1 break-words text-sm font-semibold text-gray-900">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
