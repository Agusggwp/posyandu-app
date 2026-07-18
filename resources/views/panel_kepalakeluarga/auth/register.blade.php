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

        <form id="registerForm" method="POST" action="{{ route('kepala-keluarga.register.post') }}" class="grid gap-5 md:grid-cols-2">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">No KK</label>
                <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk') }}" required 
                       maxlength="16"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16); validateKk();"
                       onblur="validateKk()"
                       class="w-full rounded-2xl border @error('no_kk') border-rose-500 @else border-gray-200 @enderror px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
                <p id="error_no_kk" class="mt-1 text-xs text-rose-600 hidden"></p>
                @error('no_kk')
                    <p id="backend_error_no_kk" class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                <input type="text" name="no_nik" id="no_nik" value="{{ old('no_nik') }}"
                       maxlength="16"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16); validateNik();"
                       onblur="validateNik()"
                       class="w-full rounded-2xl border @error('no_nik') border-rose-500 @else border-gray-200 @enderror px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
                <p id="error_no_nik" class="mt-1 text-xs text-rose-600 hidden"></p>
                @error('no_nik')
                    <p id="backend_error_no_nik" class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required 
                       maxlength="30"
                       oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').slice(0, 30); validateNama();"
                       onblur="validateNama()"
                       class="w-full rounded-2xl border @error('nama_lengkap') border-rose-500 @else border-gray-200 @enderror px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
                <p id="error_nama_lengkap" class="mt-1 text-xs text-rose-600 hidden"></p>
                @error('nama_lengkap')
                    <p id="backend_error_nama_lengkap" class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                       oninput="validateEmail()"
                       onblur="validateEmail()"
                       class="w-full rounded-2xl border @error('email') border-rose-500 @else border-gray-200 @enderror px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
                <p id="error_email" class="mt-1 text-xs text-rose-600 hidden"></p>
                @error('email')
                    <p id="backend_error_email" class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <textarea name="alamat" rows="3" required class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">{{ old('alamat') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">No Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}"
                       maxlength="13" minlength="11" pattern="\d{11,13}"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)"
                       class="w-full rounded-2xl border border-gray-200 px-4 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required 
                           oninput="validatePassword()"
                           onblur="validatePassword()"
                           class="w-full rounded-2xl border @error('password') border-rose-500 @else border-gray-200 @enderror pl-4 pr-12 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
                    <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-fuchsia-600 focus:outline-none">
                        <svg id="eye-icon-password" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eye-slash-icon-password" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                <p id="error_password" class="mt-1 text-xs text-rose-600 hidden"></p>
                @error('password')
                    <p id="backend_error_password" class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation" required 
                           oninput="validatePasswordMatch()"
                           onblur="validatePasswordMatch()"
                           class="w-full rounded-2xl border @error('password_confirmation') border-rose-500 @else border-gray-200 @enderror pl-4 pr-12 py-3 outline-none focus:border-fuchsia-500 focus:ring-4 focus:ring-fuchsia-100">
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-fuchsia-600 focus:outline-none">
                        <svg id="eye-icon-password_confirmation" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eye-slash-icon-password_confirmation" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                <p id="error_password_confirmation" class="mt-1 text-xs text-rose-600 hidden"></p>
                @error('password_confirmation')
                    <p id="backend_error_password_confirmation" class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="md:col-span-2 flex items-center justify-between gap-4 pt-2">
                <a href="{{ route('kepala-keluarga.login') }}" class="text-sm font-semibold text-fuchsia-700 hover:underline">Sudah punya akun?</a>
                <button type="submit" class="rounded-2xl px-6 py-3 font-semibold text-white shadow-lg transition" style="background: linear-gradient(135deg, #a6599e, #8e4682); box-shadow: 0 12px 30px rgba(142, 70, 130, 0.22);">Daftar</button>
            </div>
        </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-icon-' + fieldId);
            const eyeSlashIcon = document.getElementById('eye-slash-icon-' + fieldId);
            
            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                field.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }

        function validateKk() {
            const input = document.getElementById('no_kk');
            const errorEl = document.getElementById('error_no_kk');
            const backendError = document.getElementById('backend_error_no_kk');
            const val = input.value;
            
            if (backendError) {
                backendError.classList.add('hidden');
            }

            if (val.length === 0) {
                showInputError(input, errorEl, 'Nomor KK wajib diisi.');
                return false;
            } else if (val.length < 16) {
                showInputError(input, errorEl, 'Masukkan 16 Digit No KK');
                return false;
            } else {
                hideInputError(input, errorEl);
                return true;
            }
        }

        function validateNik() {
            const input = document.getElementById('no_nik');
            const errorEl = document.getElementById('error_no_nik');
            const backendError = document.getElementById('backend_error_no_nik');
            const val = input.value;
            
            if (backendError) {
                backendError.classList.add('hidden');
            }

            if (val.length > 0 && val.length < 16) {
                showInputError(input, errorEl, 'Masukkan 16 Digit NIK');
                return false;
            } else {
                hideInputError(input, errorEl);
                return true;
            }
        }

        function validateNama() {
            const input = document.getElementById('nama_lengkap');
            const errorEl = document.getElementById('error_nama_lengkap');
            const backendError = document.getElementById('backend_error_nama_lengkap');
            const val = input.value;
            
            if (backendError) {
                backendError.classList.add('hidden');
            }

            if (val.length === 0) {
                showInputError(input, errorEl, 'Nama lengkap wajib diisi.');
                return false;
            } else if (/[^a-zA-Z\s]/.test(val)) {
                showInputError(input, errorEl, 'Nama lengkap hanya boleh berisi huruf.');
                return false;
            } else if (val.length > 30) {
                showInputError(input, errorEl, 'Nama lengkap tidak boleh lebih dari 30 karakter.');
                return false;
            } else {
                hideInputError(input, errorEl);
                return true;
            }
        }

        function validateEmail() {
            const input = document.getElementById('email');
            const errorEl = document.getElementById('error_email');
            const backendError = document.getElementById('backend_error_email');
            const val = input.value;
            
            if (backendError) {
                backendError.classList.add('hidden');
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (val.length === 0) {
                showInputError(input, errorEl, 'Email wajib diisi.');
                return false;
            } else if (!emailRegex.test(val)) {
                showInputError(input, errorEl, 'Format email tidak valid.');
                return false;
            } else {
                hideInputError(input, errorEl);
                return true;
            }
        }

        function validatePassword() {
            const password = document.getElementById('password');
            const errorEl = document.getElementById('error_password');
            const backendError = document.getElementById('backend_error_password');
            const val = password.value;
            
            if (backendError) {
                backendError.classList.add('hidden');
            }
            
            if (val.length === 0) {
                showInputError(password, errorEl, 'Password wajib diisi.');
                return false;
            } else if (val.length < 8) {
                showInputError(password, errorEl, 'Password minimal harus 8 karakter.');
                return false;
            } else {
                hideInputError(password, errorEl);
                if (document.getElementById('password_confirmation').value.length > 0) {
                    validatePasswordMatch();
                }
                return true;
            }
        }

        function validatePasswordMatch() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const errorEl = document.getElementById('error_password_confirmation');
            const backendError = document.getElementById('backend_error_password_confirmation');
            
            if (backendError) {
                backendError.classList.add('hidden');
            }
            
            if (password.value !== confirmPassword.value) {
                showInputError(confirmPassword, errorEl, 'Konfirmasi password tidak cocok dengan password.');
                return false;
            } else {
                hideInputError(confirmPassword, errorEl);
                return true;
            }
        }

        function showInputError(input, errorEl, message) {
            errorEl.textContent = message;
            errorEl.classList.remove('hidden');
            input.classList.remove('border-gray-200');
            input.classList.add('border-rose-500', 'focus:border-rose-500', 'focus:ring-rose-100');
        }

        function hideInputError(input, errorEl) {
            errorEl.classList.add('hidden');
            input.classList.remove('border-rose-500', 'focus:border-rose-500', 'focus:ring-rose-100');
            input.classList.add('border-gray-200');
        }

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            if (!validateKk()) isValid = false;
            if (!validateNik()) isValid = false;
            if (!validateNama()) isValid = false;
            if (!validateEmail()) isValid = false;
            if (!validatePassword()) isValid = false;
            if (!validatePasswordMatch()) isValid = false;
            
            if (!isValid) {
                e.preventDefault();
                const firstError = document.querySelector('.text-rose-600:not(.hidden)');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    </script>
</body>
</html>
