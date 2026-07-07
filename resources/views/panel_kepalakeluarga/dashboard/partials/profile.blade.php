<div id="profile" class="section hidden">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($kepalaKeluarga->nama_lengkap) }}&background=6366f1&color=fff&bold=true&size=150" alt="Avatar" class="w-24 h-24 rounded-2xl mx-auto mb-4 border border-slate-100">
                <h3 class="text-lg font-extrabold text-slate-800">{{ $kepalaKeluarga->nama_lengkap }}</h3>
                <span class="inline-block mt-1 text-xs px-2.5 py-1 rounded-full font-semibold bg-indigo-50 text-indigo-700">Kepala Keluarga</span>
                <div class="mt-6 p-4 rounded-2xl border border-slate-100 bg-slate-50/50"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">NIK</p><p class="text-sm font-mono font-bold text-slate-850 mt-1">{{ $kepalaKeluarga->no_nik ?: '-' }}</p></div>
                <div class="mt-3 p-4 bg-emerald-50/60 border border-emerald-100 rounded-2xl"><p class="text-xs text-emerald-600 font-bold uppercase tracking-wider">Status Akun</p><p class="text-sm font-bold text-emerald-700 mt-1">Aktif</p></div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <h3 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-2"><i class="fa-solid fa-user-pen text-indigo-500"></i>Kelola Profile</h3>
                <div class="mb-6">
                    <div class="flex gap-4 mb-6 border-b border-slate-100">
                        <button id="tab-data-diri" class="tab-btn px-4 py-2 border-b-2 font-bold text-sm border-indigo-600 text-indigo-600 cursor-pointer" onclick="switchTab('data-diri')">Data Diri</button>
                        <button id="tab-password" class="tab-btn px-4 py-2 text-slate-500 font-bold text-sm hover:text-slate-700 cursor-pointer" onclick="switchTab('password')">Ubah Password</button>
                    </div>
                    <form id="form-data-diri" method="POST" action="{{ route('kepala-keluarga.profile.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ $kepalaKeluarga->nama_lengkap }}" required class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-colors" placeholder="Masukkan nama lengkap">
                            @error('nama_lengkap')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">NIK (Tidak Dapat Diubah)</label>
                                <input type="text" value="{{ $kepalaKeluarga->no_nik ?: '' }}" class="w-full px-4 py-2.5 border border-slate-200 bg-slate-50 text-slate-500 rounded-2xl focus:outline-none" placeholder="Masukkan NIK" readonly disabled>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">No. Telepon</label>
                                <input type="tel" name="no_telepon" value="{{ $kepalaKeluarga->no_telepon ?: '' }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-colors" placeholder="Masukkan no. telepon">
                                @error('no_telepon')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Email</label>
                            <input type="email" name="email" value="{{ $kepalaKeluarga->email }}" required class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-colors" placeholder="Masukkan email">
                            @error('email')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Alamat</label>
                            <textarea name="alamat" class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-colors" rows="3" placeholder="Masukkan alamat lengkap">{{ $kepalaKeluarga->alamat }}</textarea>
                            @error('alamat')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex gap-3 pt-4">
                            <a href="javascript:void(0)" onclick="location.reload()" class="flex-1 bg-slate-100 hover:bg-slate-250 text-slate-700 py-3 rounded-2xl font-bold transition text-center text-sm cursor-pointer">Batal</a>
                            <button type="submit" class="flex-grow-[2] bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-2xl font-bold transition text-sm shadow-md shadow-indigo-100 cursor-pointer"><i class="fa-solid fa-floppy-disk mr-2"></i>Simpan Perubahan</button>
                        </div>
                    </form>

                    <form id="form-password" method="POST" action="{{ route('kepala-keluarga.profile.password') }}" class="hidden space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Password Lama</label>
                            <div class="relative">
                                <input id="oldPassword" type="password" name="old_password" required class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-colors" placeholder="Masukkan password lama">
                                <button type="button" class="absolute right-4 top-3 text-slate-400 hover:text-slate-600 cursor-pointer" onclick="togglePasswordVisibility('oldPassword')">
                                    <i class="fas fa-eye" id="icon-oldPassword"></i>
                                </button>
                            </div>
                            @error('old_password')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Password Baru</label>
                            <div class="relative">
                                <input id="newPassword" type="password" name="password" required class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-colors" placeholder="Masukkan password baru">
                                <button type="button" class="absolute right-4 top-3 text-slate-400 hover:text-slate-600 cursor-pointer" onclick="togglePasswordVisibility('newPassword')">
                                    <i class="fas fa-eye" id="icon-newPassword"></i>
                                </button>
                            </div>
                            @error('password')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2 uppercase tracking-wide">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input id="confirmPassword" type="password" name="password_confirmation" required class="w-full px-4 py-2.5 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 transition-colors" placeholder="Konfirmasi password baru">
                                <button type="button" class="absolute right-4 top-3 text-slate-400 hover:text-slate-600 cursor-pointer" onclick="togglePasswordVisibility('confirmPassword')">
                                    <i class="fas fa-eye" id="icon-confirmPassword"></i>
                                </button>
                            </div>
                        </div>

                        <div class="border rounded-2xl p-4 text-xs bg-indigo-50/50 border-indigo-100 text-indigo-700 leading-relaxed">
                            <i class="fa-solid fa-circle-info mr-2 text-base align-middle"></i>
                            Password harus terdiri dari minimal 8 karakter dengan kombinasi huruf, angka, dan simbol.
                        </div>

                        <div class="flex gap-3 pt-4">
                            <a href="javascript:void(0)" onclick="resetPasswordForm()" class="flex-1 bg-slate-100 hover:bg-slate-250 text-slate-700 py-3 rounded-2xl font-bold transition text-center text-sm cursor-pointer">Batal</a>
                            <button type="submit" class="flex-grow-[2] bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-2xl font-bold transition text-sm shadow-md shadow-indigo-100 cursor-pointer"><i class="fa-solid fa-check mr-2"></i>Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
