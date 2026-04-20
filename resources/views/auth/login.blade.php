<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Kesehatan Keluarga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .login-left {
            animation: slideInLeft 0.8s ease-out;
            background: #ffffff;
        }

        .btn-login {
            background: linear-gradient(135deg, #7c3aed 0%, #2563eb 100%);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .btn-login:hover {
            box-shadow: 0 16px 40px rgba(124, 58, 237, 0.5);
            transform: translateY(-3px);
        }

        .btn-login:active {
            transform: scale(0.95) translateY(-1px);
        }

        input,
        input:-webkit-autofill {
            background-color: #f8fafb !important;
            border: 1.5px solid #e5e7eb !important;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.02) !important;
        }

        input::placeholder {
            color: #9ca3af;
        }

        input:focus,
        input:focus-visible {
            outline: none !important;
            border-color: #7c3aed !important;
            background-color: #ffffff !important;
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1), inset 0 1px 2px rgba(0, 0, 0, 0.02) !important;
        }

        input:-webkit-autofill {
            -webkit-text-fill-color: #1f2937 !important;
        }

        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1), inset 0 1px 2px rgba(0, 0, 0, 0.02), 0 0 0 1000px #ffffff inset !important;
            -webkit-text-fill-color: #1f2937 !important;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            background: #f8fafb;
        }

        .forgot-link,
        .sign-up-link {
            color: #7c3aed;
            font-weight: 600;
            text-decoration: none;
        }

        .forgot-link:hover,
        .sign-up-link:hover {
            color: #2563eb;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 16px 0;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-60px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-12">
        <div class="w-full max-w-6xl bg-white rounded-3xl shadow-2xl overflow-hidden flex">
            <div class="hidden md:flex w-1/2 relative items-center justify-center overflow-hidden bg-gradient-to-br from-purple-400 via-purple-500 to-blue-600">
                <img src="{{ asset('auth/login.webp') }}" alt="Welcome" class="w-full h-full object-cover">
            </div>

            <div class="login-left w-full md:w-1/2 flex items-center justify-center px-6 md:px-12 py-12 bg-white">
                <div class="w-full max-w-md">
                    <div class="mb-12">
                        <h1 class="text-5xl font-bold text-gray-900 mb-2 leading-tight">{{ isset($loginSettings) ? $loginSettings['title'] : 'Holla, Welcome Back' }}</h1>
                        <p class="text-gray-600 text-base mt-4 leading-relaxed">{{ isset($loginSettings) ? $loginSettings['description'] : 'Silakan masuk ke akun Anda untuk melanjutkan pengelolaan kesehatan keluarga' }}</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first('email') ?? $errors->first('password') ?? 'Login gagal. Periksa kembali data Anda.' }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div class="form-group">
                            <label class="form-label" for="email">Email Address</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="stanley@gmail.com"
                                class="form-input"
                                required
                                autofocus
                            >
                        </div>

                        <div class="form-group">
                            <div class="flex items-center justify-between mb-2">
                                <label class="form-label m-0" for="password-input">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-link text-sm">Lupa Password?</a>
                                @endif
                            </div>
                            <div class="relative">
                                <input
                                    id="password-input"
                                    name="password"
                                    type="password"
                                    placeholder="••••••••"
                                    class="form-input pr-12"
                                    required
                                >
                                <button type="button" class="absolute right-4 top-3 text-gray-500 hover:text-gray-700 text-xl" id="toggle-password" aria-label="Toggle password visibility">
                                    👁️
                                </button>
                            </div>
                        </div>

                        <div class="checkbox-wrapper pt-2">
                            <input type="checkbox" id="remember-me" name="remember" value="1" class="w-5 h-5 cursor-pointer accent-purple-600" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember-me" class="text-gray-700 font-medium text-sm cursor-pointer">Ingatkan saya</label>
                        </div>

                        <button
                            type="submit"
                            class="btn-login w-full text-white font-bold py-3.5 px-6 rounded-xl mt-8 text-base uppercase tracking-wide shadow-lg hover:shadow-2xl"
                        >
                            Sign In
                        </button>
                    </form>

                    @if (Route::has('register'))
                        <p class="text-center text-gray-700 text-sm mt-8 font-medium">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="sign-up-link">Daftar Sekarang -></a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password-input');
        const toggleBtn = document.getElementById('toggle-password');

        if (passwordInput && toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleBtn.innerHTML = '🙈';
                } else {
                    passwordInput.type = 'password';
                    toggleBtn.innerHTML = '👁️';
                }
            });
        }
    </script>
</body>
</html>
