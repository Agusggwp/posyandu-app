<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Keluarga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f0ebf8 0%, #f5f7fa 50%, #e8f4f8 100%);
            min-height: 100vh;
        }

        .panel-shell {
            background: linear-gradient(135deg, #ffffff 0%, #f9fbfd 100%);
            border: 1px solid rgba(78, 3, 131, 0.08);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06), 0 2px 8px rgba(78, 3, 131, 0.05);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4e0383 0%, #6b2ba8 50%, #5a1f8a 100%);
            box-shadow: 0 4px 14px rgba(78, 3, 131, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3a025c 0%, #5a1f8a 50%, #4a1575 100%);
            box-shadow: 0 12px 25px rgba(78, 3, 131, 0.35);
            transform: translateY(-2px);
        }

        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f9fbfd 100%);
            border: 1px solid rgba(78, 3, 131, 0.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .table-head {
            background: linear-gradient(135deg, #4e0383 0%, #6b2ba8 100%);
        }
    </style>
</head>
<body class="text-gray-800">
    @php
        $totalAnggota = $anggota->count();
        $totalKategori = [
            'Balita' => $kepalaKeluarga->balitas->count(),
            'Ibu Hamil' => $kepalaKeluarga->ibuHamils->count(),
            'Nifas' => $kepalaKeluarga->nifases->count(),
            'Remaja' => $kepalaKeluarga->remajas->count(),
            'Lansia' => $kepalaKeluarga->lansias->count(),
        ];
    @endphp

    <header class="bg-gradient-to-r from-purple-700 via-purple-600 to-purple-500 text-white shadow-lg">
        <div class="mx-auto max-w-6xl px-6 py-8">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm text-purple-100">Sistem Informasi Kesehatan Keluarga</p>
                    <h1 class="mt-2 text-3xl font-bold">Dashboard Keluarga</h1>
                    <p class="mt-2 text-purple-100">Pantau data anggota dan lihat detail kesehatan keluarga.</p>
                </div>
                <form method="POST" action="{{ route('kepala-keluarga.logout') }}">
                    @csrf
                    <button type="submit" class="rounded-xl bg-rose-500 px-5 py-3 text-sm font-semibold text-white hover:bg-rose-600 transition">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="mx-auto max-w-6xl p-6">
        <section class="panel-shell rounded-2xl p-6 md:p-8">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="stat-card rounded-2xl border-l-4 border-violet-500 p-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Nama Kepala Keluarga</p>
                    <p class="mt-3 text-xl font-bold text-gray-900">{{ $kepalaKeluarga->nama_lengkap }}</p>
                </div>
                <div class="stat-card rounded-2xl border-l-4 border-orange-500 p-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Email</p>
                    <p class="mt-3 break-all text-xl font-bold text-gray-900">{{ $kepalaKeluarga->email }}</p>
                </div>
                <div class="stat-card rounded-2xl border-l-4 border-emerald-500 p-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Nomor Kartu Keluarga</p>
                    <p class="mt-3 text-xl font-bold text-gray-900">{{ $kepalaKeluarga->no_kk }}</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-3">
                <div class="stat-card rounded-2xl border-l-4 border-purple-500 p-6">
                    <p class="text-sm font-semibold text-gray-600">Total Anggota</p>
                    <p class="mt-2 text-4xl font-bold text-purple-700">{{ $totalAnggota }}</p>
                    <p class="mt-2 text-xs text-gray-500">anggota terdaftar</p>
                </div>
                <div class="stat-card rounded-2xl border-l-4 border-blue-500 p-6 md:col-span-2">
                    <p class="text-sm font-semibold text-gray-600">Distribusi Kategori</p>
                    <div class="mt-4 grid grid-cols-2 gap-3 md:grid-cols-5">
                        @foreach($totalKategori as $label => $count)
                            <div class="rounded-xl bg-white p-3 text-center shadow-sm">
                                <p class="text-xs text-gray-500">{{ $label }}</p>
                                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $count }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-6 rounded-2xl border border-purple-100 bg-white p-6">
                <h2 class="text-xl font-bold text-gray-900">Data Keluarga</h2>
                <div class="mt-4 grid gap-3 text-sm text-gray-700 md:grid-cols-2">
                    <div><span class="font-semibold text-gray-500">NIK:</span> {{ $kepalaKeluarga->no_nik ?? '-' }}</div>
                    <div><span class="font-semibold text-gray-500">Telepon:</span> {{ $kepalaKeluarga->no_telepon ?? '-' }}</div>
                    <div class="md:col-span-2"><span class="font-semibold text-gray-500">Alamat:</span> {{ $kepalaKeluarga->alamat }}</div>
                </div>
            </div>
        </section>

        <section class="panel-shell mt-6 rounded-2xl p-6 md:p-8">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900"><i class="fa-solid fa-people-group mr-2 text-purple-700"></i>Nama Anggota Keluarga</h2>
                <span class="rounded-lg bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">{{ $totalAnggota }} anggota</span>
            </div>

            @if($anggota->isEmpty())
                <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-center text-sm text-gray-500">
                    Belum ada data anggota keluarga.
                </div>
            @else
                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="min-w-full border-collapse">
                        <thead class="table-head text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Kategori</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-sm text-gray-700">
                            @foreach($anggota as $item)
                                <tr class="border-b border-gray-100 hover:bg-purple-50/40">
                                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $item['nama'] }}</td>
                                    <td class="px-4 py-3">{{ $item['label_tipe'] }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <a
                                                href="{{ route('kepala-keluarga.anggota.show', ['tipe' => $item['tipe'], 'id' => $item['id']]) }}"
                                                class="btn-primary inline-flex items-center rounded-lg px-4 py-2 text-xs font-semibold text-white transition"
                                            >
                                                <i class="fa-solid fa-eye mr-2"></i>Lihat Detail
                                            </a>
                                            <a
                                                href="{{ route('kepala-keluarga.anggota.pemeriksaan', ['tipe' => $item['tipe'], 'id' => $item['id']]) }}"
                                                class="inline-flex items-center rounded-lg bg-orange-500 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-orange-600"
                                            >
                                                <i class="fa-solid fa-chart-column mr-2"></i>Lihat Pemeriksaan
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</body>
</html>
