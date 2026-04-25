<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Kepala Keluarga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background: radial-gradient(circle at 12% 20%, rgba(166, 89, 158, 0.14) 0%, transparent 30%), radial-gradient(circle at 85% 15%, rgba(142, 70, 130, 0.16) 0%, transparent 34%), linear-gradient(135deg, #faf5fb 0%, #fff 48%, #f7f2f7 100%);">
    <div class="w-full max-w-3xl overflow-hidden rounded-[2rem] border border-fuchsia-100 bg-white shadow-[0_25px_70px_-20px_rgba(142,70,130,0.28)]">
        <div class="px-8 py-8 text-white" style="background: linear-gradient(135deg, #a6599e, #8e4682);">
            <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-semibold">
                <span class="h-2 w-2 rounded-full bg-white/90"></span>
                Panel Kepala Keluarga
            </div>
            <h1 class="mt-4 text-3xl font-extrabold">Register Kepala Keluarga</h1>
            <p class="mt-2 max-w-2xl text-sm text-white/85">Buat akun untuk mengakses panel keluarga.</p>
        </div>

        <div class="p-8">
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 rounded-2xl text-white flex items-center justify-center text-2xl font-bold shadow-lg" style="background: linear-gradient(135deg, #a6599e, #8e4682); box-shadow: 0 12px 30px rgba(142, 70, 130, 0.22);">KK</div>
            <h2 class="mt-4 text-2xl font-bold text-gray-900">Register Kepala Keluarga</h2>
            <p class="mt-2 text-sm text-gray-500">Buat akun untuk mengakses panel keluarga.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('kepala-keluarga.register.post') }}" class="grid gap-5 md:grid-cols-2">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">No KK</label>
                <input type="text" name="no_kk" value="{{ old('no_kk') }}" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                <input type="text" name="no_nik" value="{{ old('no_nik') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <textarea name="alamat" rows="3" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">{{ old('alamat') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">No Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
            </div>
            <div class="md:col-span-2 flex items-center justify-between gap-4 pt-2">
                <a href="{{ route('kepala-keluarga.login') }}" class="text-sm font-semibold text-fuchsia-700 hover:underline">Sudah punya akun?</a>
                <button type="submit" class="rounded-2xl px-6 py-3 font-semibold text-white shadow-lg transition" style="background: linear-gradient(135deg, #a6599e, #8e4682); box-shadow: 0 12px 30px rgba(142, 70, 130, 0.22);">Daftar</button>
            </div>
        </form>
        </div>
    </div>
</body>
</html>
