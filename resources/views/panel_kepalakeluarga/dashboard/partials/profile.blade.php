<div id="profile" class="section hidden">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($kepalaKeluarga->nama_lengkap) }}&background=a6599e&color=fff&size=150" alt="Avatar" class="w-24 h-24 rounded-full mx-auto mb-4">
                <h3 class="text-xl font-bold text-gray-800">{{ $kepalaKeluarga->nama_lengkap }}</h3>
                <p class="text-gray-600 text-sm">Kepala Keluarga</p>
                <div class="mt-4 p-3 rounded" style="background-color: #f3e8f3;"><p class="text-xs text-gray-600">NIK</p><p class="text-sm font-mono font-semibold text-gray-800">{{ $kepalaKeluarga->no_nik ?: '-' }}</p></div>
                <div class="mt-4 p-3 bg-green-50 rounded"><p class="text-xs text-gray-600">Status</p><p class="text-sm font-semibold text-green-600">Aktif</p></div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2"><i class="fas fa-edit" style="color: #8e4682;"></i>Kelola Profile</h3>
                <div class="mb-6">
                    <div class="flex gap-4 mb-6 border-b border-gray-200">
                        <button id="tab-data-diri" class="tab-btn px-4 py-2 border-b-2 font-medium" style="border-color: #8e4682; color: #8e4682;" onclick="switchTab('data-diri')">Data Diri</button>
                        <button id="tab-password" class="tab-btn px-4 py-2 text-gray-600 font-medium hover:text-gray-800" onclick="switchTab('password')">Ubah Password</button>
                    </div>
                    <form id="form-data-diri" method="POST" action="{{ route('kepala-keluarga.profile.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ $kepalaKeluarga->nama_lengkap }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2" style="--tw-ring-color: #8e4682;" placeholder="Masukkan nama lengkap">
                            @error('nama_lengkap')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                                <input type="text" value="{{ $kepalaKeluarga->no_nik ?: '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2" style="--tw-ring-color: #8e4682;" placeholder="Masukkan NIK" readonly disabled>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                                <input type="tel" name="no_telepon" value="{{ $kepalaKeluarga->no_telepon ?: '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2" style="--tw-ring-color: #8e4682;" placeholder="Masukkan no. telepon">
                                @error('no_telepon')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ $kepalaKeluarga->email }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2" style="--tw-ring-color: #8e4682;" placeholder="Masukkan email">
                            @error('email')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                            <textarea name="alamat" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2" style="--tw-ring-color: #8e4682;" rows="3" placeholder="Masukkan alamat lengkap">{{ $kepalaKeluarga->alamat }}</textarea>
                            @error('alamat')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex gap-3 pt-4">
                            <a href="javascript:void(0)" onclick="location.reload()" class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium transition text-center">Batal</a>
                            <button type="submit" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-medium transition"><i class="fas fa-save mr-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>

                    <form id="form-password" method="POST" action="{{ route('kepala-keluarga.profile.password') }}" class="hidden space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                            <div class="relative">
                                <input id="oldPassword" type="password" name="old_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2" style="--tw-ring-color: #8e4682;" placeholder="Masukkan password lama">
                                <button type="button" class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700" onclick="togglePasswordVisibility('oldPassword')">
                                    <i class="fas fa-eye" id="icon-oldPassword"></i>
                                </button>
                            </div>
                            @error('old_password')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                            <div class="relative">
                                <input id="newPassword" type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2" style="--tw-ring-color: #8e4682;" placeholder="Masukkan password baru">
                                <button type="button" class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700" onclick="togglePasswordVisibility('newPassword')">
                                    <i class="fas fa-eye" id="icon-newPassword"></i>
                                </button>
                            </div>
                            @error('password')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input id="confirmPassword" type="password" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2" style="--tw-ring-color: #8e4682;" placeholder="Konfirmasi password baru">
                                <button type="button" class="absolute right-3 top-2.5 text-gray-500 hover:text-gray-700" onclick="togglePasswordVisibility('confirmPassword')">
                                    <i class="fas fa-eye" id="icon-confirmPassword"></i>
                                </button>
                            </div>
                        </div>

                        <div class="border rounded p-3 text-sm" style="background-color: #f3e8f3; border-color: #d4b3d4; color: #8e4682;">
                            <i class="fas fa-info-circle mr-2"></i>
                            Password harus terdiri dari minimal 8 karakter dengan kombinasi huruf, angka, dan simbol.
                        </div>

                        <div class="flex gap-3 pt-4">
                            <a href="javascript:void(0)" onclick="resetPasswordForm()" class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium transition text-center">Batal</a>
                            <button type="submit" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-medium transition"><i class="fas fa-check mr-2"></i>Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
