<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Kepala Keluarga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-teal-50 via-white to-cyan-100 flex items-center justify-center p-6">
    <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-cyan-100 p-8">
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-600 to-teal-600 text-white flex items-center justify-center text-2xl font-bold">KK</div>
            <h1 class="mt-4 text-2xl font-bold text-gray-900">Register Kepala Keluarga</h1>
            <p class="mt-2 text-sm text-gray-500">Buat akun untuk mengakses panel keluarga.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('kepala-keluarga.register.post') }}" class="grid gap-5 md:grid-cols-2">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">No KK</label>
                <input type="text" name="no_kk" value="{{ old('no_kk') }}" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                <input type="text" name="no_nik" value="{{ old('no_nik') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <textarea name="alamat" rows="3" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">{{ old('alamat') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">No Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-cyan-500 focus:ring-4 focus:ring-cyan-100">
            </div>
            <div class="md:col-span-2 flex items-center justify-between gap-4 pt-2">
                <a href="{{ route('kepala-keluarga.login') }}" class="text-sm font-semibold text-cyan-700 hover:underline">Sudah punya akun?</a>
                <button type="submit" class="rounded-2xl bg-cyan-600 px-6 py-3 font-semibold text-white shadow-lg shadow-cyan-200 hover:bg-cyan-700 transition">Daftar</button>
            </div>
        </form>
    </div>
</body>
</html>
