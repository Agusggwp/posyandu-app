<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-12">
        <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">
            <section class="hidden md:flex relative items-center overflow-hidden bg-gradient-to-br from-purple-500 via-indigo-500 to-blue-600 p-10 text-white">
                <div class="absolute -top-16 -left-16 h-56 w-56 rounded-full bg-white/15 blur-3xl"></div>
                <div class="absolute -bottom-20 -right-8 h-64 w-64 rounded-full bg-cyan-300/25 blur-3xl"></div>
                <div class="relative">
                    <p class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-4 py-2 text-xs font-semibold tracking-wide">Portal Petugas</p>
                    <h1 class="mt-6 text-4xl font-extrabold leading-tight">Reset Password Admin, Kader, dan Bidan</h1>
                    <p class="mt-4 text-sm text-white/90">Masukkan email akun petugas. Kami akan kirim tautan untuk membuat password baru.</p>
                </div>
            </section>

            <section class="flex items-center p-6 sm:p-10 md:p-12">
                <div class="w-full max-w-md mx-auto">
                    <h2 class="text-3xl font-bold text-slate-900">Lupa Password?</h2>
                    <p class="mt-2 text-sm text-slate-500">Khusus akun Admin, Kader, dan Bidan.</p>

                    @if (session('status'))
                        <div class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                autofocus
                                placeholder="nama@email.com"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-purple-500 focus:ring-4 focus:ring-purple-100"
                            >
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 px-4 py-3 font-bold text-white transition hover:from-purple-700 hover:to-blue-700">
                            Kirim Link Reset Password
                        </button>
                    </form>

                    <p class="mt-6 text-sm text-slate-500 text-center">
                        Sudah ingat password?
                        <a href="{{ route('login') }}" class="font-semibold text-purple-700 hover:text-blue-700 hover:underline">Kembali ke Login</a>
                    </p>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
