<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kepala Keluarga</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-teal-100 flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl border border-emerald-100 p-8">
        <div class="text-center mb-8">
            <div class="mx-auto w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-600 text-white flex items-center justify-center text-2xl font-bold">KK</div>
            <h1 class="mt-4 text-2xl font-bold text-gray-900">Login Kepala Keluarga</h1>
            <p class="mt-2 text-sm text-gray-500">Masuk ke panel keluarga untuk melihat data dan layanan.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('kepala-keluarga.login.post') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100" placeholder="nama@email.com">
            </div>
                @if (session('success'))
                    <div class="mt-8 p-4 rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-700 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100" placeholder="••••••••">
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                Ingat saya
            </label>

            <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-3 font-semibold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition">Masuk</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
            Belum punya akun?
            <a href="{{ route('kepala-keluarga.register') }}" class="font-semibold text-emerald-700 hover:underline">Daftar di sini</a>
        </p>
    </div>
</body>
</html>
