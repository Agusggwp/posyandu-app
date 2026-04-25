<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kepala Keluarga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen p-4 sm:p-6 lg:p-10" style="background: radial-gradient(circle at 12% 20%, rgba(166, 89, 158, 0.16) 0%, transparent 30%), radial-gradient(circle at 85% 15%, rgba(142, 70, 130, 0.18) 0%, transparent 34%), linear-gradient(135deg, #faf5fb 0%, #fdfcff 46%, #f7f2f7 100%);">
    <div class="mx-auto grid min-h-[calc(100vh-2rem)] w-full max-w-6xl overflow-hidden rounded-[2rem] border border-fuchsia-100 bg-white shadow-[0_25px_70px_-20px_rgba(142,70,130,0.28)] md:grid-cols-2">
        <section class="relative hidden overflow-hidden p-10 text-white md:block lg:p-12" style="background: linear-gradient(160deg, #a6599e 0%, #8e4682 55%, #6f2f67 100%);">
            <div class="absolute -top-16 -left-16 h-56 w-56 rounded-full bg-white/15 blur-2xl"></div>
            <div class="absolute -bottom-20 -right-8 h-64 w-64 rounded-full bg-white/10 blur-2xl"></div>

            <div class="relative flex h-full flex-col">
                <div class="inline-flex w-fit items-center gap-2 rounded-full border border-white/25 bg-white/10 px-4 py-2 text-sm font-semibold tracking-wide">
                    <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                    {{ $loginSettings['badge'] ?? 'Portal Kepala Keluarga' }}
                </div>

                <div class="mt-10">
                    <h1 class="text-4xl font-extrabold leading-tight lg:text-5xl">{{ $loginSettings['hero_title'] ?? 'Pantau kesehatan keluarga dari satu tempat.' }}</h1>
                    <p class="mt-4 max-w-md text-base text-white/85 lg:text-lg">
                        {{ $loginSettings['hero_subtitle'] ?? 'Akses data pemeriksaan, berita posyandu, dan informasi keluarga dengan tampilan yang rapi dan mudah digunakan.' }}
                    </p>
                </div>

                <div class="mt-10 space-y-4 text-sm">
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 shadow-sm backdrop-blur">
                        <p class="font-semibold">{{ $loginSettings['feature_1_title'] ?? 'Akses cepat data keluarga' }}</p>
                        <p class="mt-1 text-white/80">{{ $loginSettings['feature_1_desc'] ?? 'Lihat riwayat pemeriksaan dan status layanan secara real-time.' }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-4 shadow-sm backdrop-blur">
                        <p class="font-semibold">{{ $loginSettings['feature_2_title'] ?? 'Data aman dan privat' }}</p>
                        <p class="mt-1 text-white/80">{{ $loginSettings['feature_2_desc'] ?? 'Informasi hanya bisa diakses melalui akun terverifikasi.' }}</p>
                    </div>
                </div>

                <p class="mt-auto pt-10 text-sm text-white/75">{{ $loginSettings['footer_text'] ?? 'Posyandu Digital • Layanan Kesehatan Keluarga' }}</p>
            </div>
        </section>

        <section class="flex items-center p-6 sm:p-10" style="background: linear-gradient(180deg, #fff 0%, #fcf8fc 100%);">
            <div class="mx-auto w-full max-w-md">
                <div class="mb-8 text-center md:text-left">
                    <div class="mx-auto inline-flex h-14 w-14 items-center justify-center rounded-2xl text-xl font-bold text-white shadow-lg md:mx-0" style="background: linear-gradient(135deg, #a6599e, #8e4682); box-shadow: 0 12px 30px rgba(142, 70, 130, 0.28);">KK</div>
                    <h2 class="mt-4 text-3xl font-extrabold tracking-tight text-gray-900">{{ $loginSettings['form_title'] ?? 'Login Kepala Keluarga' }}</h2>
                    <p class="mt-2 text-sm text-gray-500">{{ $loginSettings['form_subtitle'] ?? 'Masuk untuk melanjutkan ke panel keluarga.' }}</p>
                </div>

                @if (session('success'))
                    <div class="mb-4 rounded-2xl border border-fuchsia-100 bg-fuchsia-50 p-4 text-sm font-medium text-fuchsia-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm font-medium text-rose-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('kepala-keluarga.login.post') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-gray-800 outline-none transition focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100"
                            placeholder="nama@email.com"
                        >
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Password</label>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-gray-800 outline-none transition focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100"
                            placeholder="••••••••"
                        >
                    </div>

                    <div class="flex items-center justify-end text-sm">
                        @if (Route::has('kepala-keluarga.password.request'))
                            <a href="{{ route('kepala-keluarga.password.request') }}" class="font-semibold text-fuchsia-700 hover:text-fuchsia-800 hover:underline">Lupa password?</a>
                        @endif
                    </div>

                    <button type="submit" class="group w-full rounded-2xl px-4 py-3 font-bold text-white shadow-lg transition" style="background: linear-gradient(135deg, #a6599e, #8e4682); box-shadow: 0 12px 30px rgba(142, 70, 130, 0.22);">
                        <span class="inline-flex items-center gap-2">
                            Masuk
                            <svg class="h-4 w-4 transition group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-500">
                    Belum punya akun?
                    <a href="{{ route('kepala-keluarga.register') }}" class="font-bold text-fuchsia-700 hover:text-fuchsia-800 hover:underline">Daftar di sini</a>
                </p>
            </div>
        </section>
    </div>
</body>
</html>



