<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Kepala Keluarga</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen p-4 sm:p-6 lg:p-10" style="font-family: 'Outfit', sans-serif; background: radial-gradient(circle at 12% 20%, #c7f9cc 0%, transparent 35%), radial-gradient(circle at 85% 15%, #99f6e4 0%, transparent 40%), linear-gradient(135deg, #f0fdf4 0%, #ecfeff 45%, #f8fafc 100%);">
    <div class="mx-auto flex min-h-[calc(100vh-2rem)] w-full max-w-3xl items-center justify-center">
        <div class="w-full overflow-hidden rounded-[2rem] border border-emerald-100 bg-white/85 shadow-[0_25px_70px_-20px_rgba(5,150,105,0.35)] backdrop-blur">
            <div class="bg-gradient-to-r from-emerald-700 via-teal-700 to-cyan-700 px-6 py-8 text-white sm:px-10">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-4 py-2 text-sm font-semibold">
                    <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                    Reset Password
                </div>
                <h1 class="mt-5 text-3xl font-extrabold sm:text-4xl">Buat password baru</h1>
                <p class="mt-3 max-w-2xl text-sm text-emerald-50/90 sm:text-base">Masukkan email dan password baru untuk akun Kepala Keluarga.</p>
            </div>

            <div class="p-6 sm:p-10">
                <form method="POST" action="{{ route('kepala-keluarga.password.update') }}" class="space-y-5">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ $email ?? old('email') }}"
                            required
                            autofocus
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                            placeholder="nama@email.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password Baru</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                            placeholder="••••••••"
                        >
                        @error('password')
                            <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                            placeholder="••••••••"
                        >
                    </div>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row">
                        <a href="{{ route('kepala-keluarga.login') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-200 px-4 py-3 font-semibold text-slate-700 transition hover:bg-slate-50 sm:w-auto">Kembali ke Login</a>
                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-3 font-bold text-white shadow-lg shadow-emerald-200 transition hover:from-emerald-700 hover:to-teal-700 sm:w-auto">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
