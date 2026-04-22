<div class="bg-white rounded-2xl shadow-xl border border-indigo-100 overflow-hidden">
    <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <button type="button" data-accordion-toggle="panel-kk-login" class="w-full flex items-center justify-between gap-3 px-4 py-4 sm:px-6 bg-indigo-50/70 border-b border-indigo-100 hover:bg-indigo-100/70 transition-colors duration-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 text-left">
                <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-4 4H2v-4l4-4 .257-.257A6 6 0 1118 8zm-6-2a2 2 0 100 4 2 2 0 000-4z" clip-rule="evenodd"/>
                </svg>
                Kustomisasi Login Kepala Keluarga
            </h3>
            <svg data-accordion-icon="panel-kk-login" class="w-5 h-5 text-indigo-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div id="panel-kk-login" class="hidden px-4 pb-4 pt-5 sm:px-6 sm:pb-6 sm:pt-6 space-y-6">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="kk_login_badge" class="block text-sm font-semibold text-gray-700 mb-2">Badge</label>
                    <input type="text" id="kk_login_badge" name="kk_login_badge" value="{{ old('kk_login_badge', $settings['kk_login_badge']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_login_badge') border-red-500 @enderror">
                    @error('kk_login_badge')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="kk_login_form_title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Form Login</label>
                    <input type="text" id="kk_login_form_title" name="kk_login_form_title" value="{{ old('kk_login_form_title', $settings['kk_login_form_title']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_login_form_title') border-red-500 @enderror">
                    @error('kk_login_form_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="kk_login_form_subtitle" class="block text-sm font-semibold text-gray-700 mb-2">Subjudul Form Login</label>
                    <input type="text" id="kk_login_form_subtitle" name="kk_login_form_subtitle" value="{{ old('kk_login_form_subtitle', $settings['kk_login_form_subtitle']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_login_form_subtitle') border-red-500 @enderror">
                    @error('kk_login_form_subtitle')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="kk_login_hero_title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Hero</label>
                    <textarea id="kk_login_hero_title" name="kk_login_hero_title" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_login_hero_title') border-red-500 @enderror">{{ old('kk_login_hero_title', $settings['kk_login_hero_title']) }}</textarea>
                    @error('kk_login_hero_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="kk_login_hero_subtitle" class="block text-sm font-semibold text-gray-700 mb-2">Subjudul Hero</label>
                    <textarea id="kk_login_hero_subtitle" name="kk_login_hero_subtitle" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_login_hero_subtitle') border-red-500 @enderror">{{ old('kk_login_hero_subtitle', $settings['kk_login_hero_subtitle']) }}</textarea>
                    @error('kk_login_hero_subtitle')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="kk_login_feature_1_title" class="block text-sm font-semibold text-gray-700 mb-2">Fitur 1 - Judul</label>
                    <input type="text" id="kk_login_feature_1_title" name="kk_login_feature_1_title" value="{{ old('kk_login_feature_1_title', $settings['kk_login_feature_1_title']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_login_feature_1_title') border-red-500 @enderror">
                    @error('kk_login_feature_1_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="kk_login_feature_1_desc" class="block text-sm font-semibold text-gray-700 mb-2">Fitur 1 - Deskripsi</label>
                    <input type="text" id="kk_login_feature_1_desc" name="kk_login_feature_1_desc" value="{{ old('kk_login_feature_1_desc', $settings['kk_login_feature_1_desc']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_login_feature_1_desc') border-red-500 @enderror">
                    @error('kk_login_feature_1_desc')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="kk_login_feature_2_title" class="block text-sm font-semibold text-gray-700 mb-2">Fitur 2 - Judul</label>
                    <input type="text" id="kk_login_feature_2_title" name="kk_login_feature_2_title" value="{{ old('kk_login_feature_2_title', $settings['kk_login_feature_2_title']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_login_feature_2_title') border-red-500 @enderror">
                    @error('kk_login_feature_2_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="kk_login_feature_2_desc" class="block text-sm font-semibold text-gray-700 mb-2">Fitur 2 - Deskripsi</label>
                    <input type="text" id="kk_login_feature_2_desc" name="kk_login_feature_2_desc" value="{{ old('kk_login_feature_2_desc', $settings['kk_login_feature_2_desc']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_login_feature_2_desc') border-red-500 @enderror">
                    @error('kk_login_feature_2_desc')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="kk_login_footer_text" class="block text-sm font-semibold text-gray-700 mb-2">Footer Hero</label>
                    <input type="text" id="kk_login_footer_text" name="kk_login_footer_text" value="{{ old('kk_login_footer_text', $settings['kk_login_footer_text']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_login_footer_text') border-red-500 @enderror">
                    @error('kk_login_footer_text')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-6">
                <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <h4 class="text-base font-bold text-slate-800">Preview Login Kepala Keluarga</h4>
                    <a href="{{ route('kepala-keluarga.login') }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                        Buka halaman login asli
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path></svg>
                    </a>
                </div>
                <div class="overflow-hidden rounded-2xl border border-emerald-200 bg-white shadow-sm">
                    <div class="grid md:grid-cols-2">
                        <div class="bg-gradient-to-br from-emerald-700 via-teal-700 to-cyan-700 p-4 text-white sm:p-5">
                            <div class="inline-flex w-fit items-center gap-2 rounded-full border border-white/30 bg-white/10 px-3 py-1 text-[11px] font-semibold tracking-wide">
                                <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                                <span data-preview-target="kk_login_badge">{{ old('kk_login_badge', $settings['kk_login_badge']) }}</span>
                            </div>
                            <h5 class="mt-3 text-xl font-extrabold leading-tight" data-preview-target="kk_login_hero_title">{{ old('kk_login_hero_title', $settings['kk_login_hero_title']) }}</h5>
                            <p class="mt-2 text-xs text-emerald-50/90 sm:text-sm" data-preview-target="kk_login_hero_subtitle">{{ old('kk_login_hero_subtitle', $settings['kk_login_hero_subtitle']) }}</p>
                            <div class="mt-4 space-y-2 text-[11px] sm:text-xs">
                                <div class="rounded-xl border border-white/20 bg-white/10 p-2.5">
                                    <p class="font-semibold" data-preview-target="kk_login_feature_1_title">{{ old('kk_login_feature_1_title', $settings['kk_login_feature_1_title']) }}</p>
                                    <p class="mt-1 text-emerald-50/80" data-preview-target="kk_login_feature_1_desc">{{ old('kk_login_feature_1_desc', $settings['kk_login_feature_1_desc']) }}</p>
                                </div>
                                <div class="rounded-xl border border-white/20 bg-white/10 p-2.5">
                                    <p class="font-semibold" data-preview-target="kk_login_feature_2_title">{{ old('kk_login_feature_2_title', $settings['kk_login_feature_2_title']) }}</p>
                                    <p class="mt-1 text-emerald-50/80" data-preview-target="kk_login_feature_2_desc">{{ old('kk_login_feature_2_desc', $settings['kk_login_feature_2_desc']) }}</p>
                                </div>
                            </div>
                            <p class="mt-4 text-[11px] text-emerald-100/90 sm:text-xs" data-preview-target="kk_login_footer_text">{{ old('kk_login_footer_text', $settings['kk_login_footer_text']) }}</p>
                        </div>
                        <div class="p-4 sm:p-5">
                            <div class="mb-4">
                                <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-sm font-bold text-white">KK</div>
                                <h5 class="mt-2 text-lg font-bold text-slate-900" data-preview-target="kk_login_form_title">{{ old('kk_login_form_title', $settings['kk_login_form_title']) }}</h5>
                                <p class="mt-1 text-xs text-slate-500" data-preview-target="kk_login_form_subtitle">{{ old('kk_login_form_subtitle', $settings['kk_login_form_subtitle']) }}</p>
                            </div>
                            <div class="space-y-2.5">
                                <div><label class="mb-1 block text-[11px] font-semibold text-slate-700">Email</label><div class="rounded-xl border border-slate-200 px-3 py-2 text-[11px] text-slate-400">nama@email.com</div></div>
                                <div><label class="mb-1 block text-[11px] font-semibold text-slate-700">Password</label><div class="rounded-xl border border-slate-200 px-3 py-2 text-[11px] text-slate-400">••••••••</div></div>
                                <button type="button" class="w-full rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-3 py-2 text-xs font-bold text-white">Masuk</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-200 px-4 pb-4 sm:px-6 sm:pb-6">
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M19.414 4.414l-17.828 17.828a2 2 0 01-2.828 0l-2.83-2.829a2 2 0 010-2.828L13.758.757a2 2 0 012.828 0l2.828 2.829a2 2 0 010 2.828z" clip-rule="evenodd"/></svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
