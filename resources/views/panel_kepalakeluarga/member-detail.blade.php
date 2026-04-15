<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Anggota Keluarga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f0ebf8 0%, #f5f7fa 50%, #e8f4f8 100%);
            min-height: 100vh;
        }

        .shell {
            background: linear-gradient(135deg, #ffffff 0%, #f9fbfd 100%);
            border: 1px solid rgba(78, 3, 131, 0.08);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06), 0 2px 8px rgba(78, 3, 131, 0.05);
        }

        .btn-back {
            background: linear-gradient(135deg, #4e0383 0%, #6b2ba8 50%, #5a1f8a 100%);
            box-shadow: 0 4px 14px rgba(78, 3, 131, 0.25);
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #3a025c 0%, #5a1f8a 50%, #4a1575 100%);
            box-shadow: 0 12px 25px rgba(78, 3, 131, 0.35);
            transform: translateY(-2px);
        }

        .field-card {
            border: 1px solid rgba(78, 3, 131, 0.1);
            background: linear-gradient(135deg, #ffffff 0%, #faf9fe 100%);
        }
    </style>
</head>
<body class="text-gray-800">
    <header class="bg-gradient-to-r from-purple-700 via-purple-600 to-purple-500 text-white shadow-lg">
        <div class="mx-auto max-w-6xl px-6 py-7">
            <p class="text-sm text-purple-100">Detail Anggota Keluarga</p>
            <h1 class="mt-2 text-3xl font-bold">{{ $memberName }}</h1>
            <p class="mt-2 text-purple-100">Kategori: {{ $memberTypeLabel }}</p>
        </div>
    </header>

    <div class="mx-auto max-w-6xl p-6">
        <div class="mb-6 flex items-center justify-between gap-4">
            <p class="text-sm text-gray-600">
                <span class="font-semibold text-purple-700">Dashboard</span> / Detail Anggota
            </p>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('kepala-keluarga.anggota.pemeriksaan', ['tipe' => $memberType, 'id' => $member->id]) }}" class="inline-flex items-center rounded-xl bg-orange-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-600">
                    <i class="fa-solid fa-chart-column mr-2"></i>Lihat Pemeriksaan
                </a>
                <a href="{{ route('kepala-keluarga.dashboard') }}" class="btn-back inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold text-white transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>

        <section class="shell rounded-2xl p-6 md:p-8">
            <h2 class="mb-5 text-xl font-bold text-gray-900"><i class="fa-solid fa-circle-info mr-2 text-purple-700"></i>Detail Data</h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach($displayAttributes as $key => $value)
                    <div class="field-card rounded-xl p-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ str_replace('_', ' ', $key) }}</p>
                        <p class="mt-2 break-words text-sm font-semibold text-gray-900">{{ $value }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</body>
</html>
