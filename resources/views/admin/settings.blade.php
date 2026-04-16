@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <!-- Header -->
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pengaturan Sistem</h2>
        <p class="text-gray-600 mt-1">Konfigurasi dan pengaturan aplikasi Posyandu</p>
    </div>

    <!-- Success Message -->
    @if (session('success'))
    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-green-800">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Settings Forms -->
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-8 border border-indigo-100">
            <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="border-b border-indigo-200 pb-4">
                    <h3 class="text-lg font-bold text-gray-800">
                        <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Informasi Pusat Kesehatan
                    </h3>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label for="center_email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" id="center_email" name="center_email" value="{{ old('center_email', $settings['center_email']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('center_email') border-red-500 @enderror" placeholder="Contoh: posyandu@example.com">
                            @error('center_email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="center_hours_open" class="block text-sm font-semibold text-gray-700 mb-2">Jam Buka</label>
                            <input type="time" id="center_hours_open" name="center_hours_open" value="{{ old('center_hours_open', $settings['center_hours_open']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('center_hours_open') border-red-500 @enderror">
                            @error('center_hours_open')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="center_hours_close" class="block text-sm font-semibold text-gray-700 mb-2">Jam Tutup</label>
                            <input type="time" id="center_hours_close" name="center_hours_close" value="{{ old('center_hours_close', $settings['center_hours_close']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('center_hours_close') border-red-500 @enderror">
                            @error('center_hours_close')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="center_address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                            <textarea id="center_address" name="center_address" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('center_address') border-red-500 @enderror" placeholder="Alamat lengkap pusat kesehatan">{{ old('center_address', $settings['center_address']) }}</textarea>
                            @error('center_address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-6">
                        <div class="flex items-center justify-between gap-3">
                            <h4 class="text-base font-bold text-emerald-900">Preview Informasi Pusat Kesehatan</h4>
                            <span class="text-xs font-semibold text-emerald-700">Live preview</span>
                        </div>
                        <div class="mt-4 space-y-3 text-sm text-emerald-900">
                            <p><span class="font-semibold">Email:</span> <span data-preview-target="center_email">{{ old('center_email', $settings['center_email']) }}</span></p>
                            <p><span class="font-semibold">Jam Operasional:</span> <span data-preview-target="center_hours_open">{{ old('center_hours_open', $settings['center_hours_open']) }}</span> - <span data-preview-target="center_hours_close">{{ old('center_hours_close', $settings['center_hours_close']) }}</span></p>
                            <p><span class="font-semibold">Alamat:</span> <span data-preview-target="center_address">{{ old('center_address', $settings['center_address']) }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M19.414 4.414l-17.828 17.828a2 2 0 01-2.828 0l-2.83-2.829a2 2 0 010-2.828L13.758.757a2 2 0 012.828 0l2.828 2.829a2 2 0 010 2.828z" clip-rule="evenodd"/></svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-8 border border-indigo-100">
            <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="border-b border-indigo-200 pb-4">
                    <h3 class="text-lg font-bold text-gray-800">
                        <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                        Kustomisasi Login Admin
                    </h3>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label for="admin_login_title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Halaman Login</label>
                            <input type="text" id="admin_login_title" name="admin_login_title" value="{{ old('admin_login_title', $settings['admin_login_title']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_login_title') border-red-500 @enderror" placeholder="Admin Dashboard">
                            @error('admin_login_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="admin_login_subtitle" class="block text-sm font-semibold text-gray-700 mb-2">Subjudul Halaman Login</label>
                            <input type="text" id="admin_login_subtitle" name="admin_login_subtitle" value="{{ old('admin_login_subtitle', $settings['admin_login_subtitle']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_login_subtitle') border-red-500 @enderror">
                            @error('admin_login_subtitle')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="admin_login_description" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                            <textarea id="admin_login_description" name="admin_login_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_login_description') border-red-500 @enderror" placeholder="Deskripsi halaman login admin">{{ old('admin_login_description', $settings['admin_login_description']) }}</textarea>
                            @error('admin_login_description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="rounded-2xl border border-amber-100 bg-amber-50/60 p-6">
                        <div class="flex items-center justify-between gap-3">
                            <h4 class="text-base font-bold text-amber-900">Preview Login Admin</h4>
                            <span class="text-xs font-semibold text-amber-700">Live preview</span>
                        </div>
                        <div class="mt-4 space-y-3 text-sm text-amber-900">
                            <p><span class="font-semibold">Judul:</span> <span data-preview-target="admin_login_title">{{ old('admin_login_title', $settings['admin_login_title']) }}</span></p>
                            <p><span class="font-semibold">Subjudul:</span> <span data-preview-target="admin_login_subtitle">{{ old('admin_login_subtitle', $settings['admin_login_subtitle']) }}</span></p>
                            <p><span class="font-semibold">Deskripsi:</span> <span data-preview-target="admin_login_description">{{ old('admin_login_description', $settings['admin_login_description']) }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M19.414 4.414l-17.828 17.828a2 2 0 01-2.828 0l-2.83-2.829a2 2 0 010-2.828L13.758.757a2 2 0 012.828 0l2.828 2.829a2 2 0 010 2.828z" clip-rule="evenodd"/></svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-8 border border-indigo-100">
            <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="border-b border-indigo-200 pb-4">
                    <h3 class="text-lg font-bold text-gray-800">
                        <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-4 4H2v-4l4-4 .257-.257A6 6 0 1118 8zm-6-2a2 2 0 100 4 2 2 0 000-4z" clip-rule="evenodd"/>
                        </svg>
                        Kustomisasi Login Kepala Keluarga
                    </h3>
                </div>

                <div class="space-y-6">
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

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M19.414 4.414l-17.828 17.828a2 2 0 01-2.828 0l-2.83-2.829a2 2 0 010-2.828L13.758.757a2 2 0 012.828 0l2.828 2.829a2 2 0 010 2.828z" clip-rule="evenodd"/></svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-8 border border-indigo-100">
            <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="border-b border-indigo-200 pb-4">
                    <h3 class="text-lg font-bold text-gray-800">
                        <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414A1 1 0 0016.707 7L13 3.293A1 1 0 0012.293 3H4zm8 1.414L15.586 8H12V4.414zM5 9a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        Pengaturan Berita Kepala Keluarga
                    </h3>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label for="kk_news_status" class="block text-sm font-semibold text-gray-700 mb-2">Status Berita</label>
                            <select id="kk_news_status" name="kk_news_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_news_status') border-red-500 @enderror">
                                <option value="active" {{ old('kk_news_status', $settings['kk_news_status']) === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('kk_news_status', $settings['kk_news_status']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('kk_news_status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="kk_news_published_at" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Publikasi</label>
                            <input type="date" id="kk_news_published_at" name="kk_news_published_at" value="{{ old('kk_news_published_at', $settings['kk_news_published_at']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_news_published_at') border-red-500 @enderror">
                            @error('kk_news_published_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="kk_news_title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Berita</label>
                            <input type="text" id="kk_news_title" name="kk_news_title" value="{{ old('kk_news_title', $settings['kk_news_title']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_news_title') border-red-500 @enderror">
                            @error('kk_news_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="kk_news_summary" class="block text-sm font-semibold text-gray-700 mb-2">Ringkasan Berita</label>
                            <textarea id="kk_news_summary" name="kk_news_summary" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_news_summary') border-red-500 @enderror">{{ old('kk_news_summary', $settings['kk_news_summary']) }}</textarea>
                            @error('kk_news_summary')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="kk_news_content" class="block text-sm font-semibold text-gray-700 mb-2">Isi Berita</label>
                            <textarea id="kk_news_content" name="kk_news_content" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_news_content') border-red-500 @enderror">{{ old('kk_news_content', $settings['kk_news_content']) }}</textarea>
                            @error('kk_news_content')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="kk_news_link_label" class="block text-sm font-semibold text-gray-700 mb-2">Label Link</label>
                            <input type="text" id="kk_news_link_label" name="kk_news_link_label" value="{{ old('kk_news_link_label', $settings['kk_news_link_label']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_news_link_label') border-red-500 @enderror">
                            @error('kk_news_link_label')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="kk_news_link_url" class="block text-sm font-semibold text-gray-700 mb-2">URL Link (opsional)</label>
                            <input type="url" id="kk_news_link_url" name="kk_news_link_url" value="{{ old('kk_news_link_url', $settings['kk_news_link_url']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_news_link_url') border-red-500 @enderror" placeholder="https://...">
                            @error('kk_news_link_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-6">
                        <div class="flex items-center justify-between gap-4">
                            <h4 class="text-base font-bold text-blue-900">Preview Berita</h4>
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ old('kk_news_status', $settings['kk_news_status']) === 'active' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600' }}" data-preview-target="kk_news_status_label">{{ old('kk_news_status', $settings['kk_news_status']) === 'active' ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                        <p class="mt-3 text-base font-semibold text-gray-900" data-preview-target="kk_news_title">{{ old('kk_news_title', $settings['kk_news_title']) }}</p>
                        <p class="mt-2 text-sm text-gray-700" data-preview-target="kk_news_summary">{{ old('kk_news_summary', $settings['kk_news_summary']) }}</p>
                        <div class="mt-4 rounded-xl border border-blue-100 bg-white p-4">
                            <p class="whitespace-pre-line text-sm leading-7 text-gray-700" data-preview-target="kk_news_content">{{ old('kk_news_content', $settings['kk_news_content']) }}</p>
                            <p class="mt-3 text-xs text-slate-500">Tanggal publikasi: <span data-preview-target="kk_news_published_at">{{ old('kk_news_published_at', $settings['kk_news_published_at']) }}</span></p>
                            <div id="kk_news_link_preview" class="mt-4 {{ old('kk_news_link_url', $settings['kk_news_link_url']) ? '' : 'hidden' }}">
                                <span class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-xs font-semibold text-white">
                                    <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i><span data-preview-target="kk_news_link_label">{{ old('kk_news_link_label', $settings['kk_news_link_label']) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M19.414 4.414l-17.828 17.828a2 2 0 01-2.828 0l-2.83-2.829a2 2 0 010-2.828L13.758.757a2 2 0 012.828 0l2.828 2.829a2 2 0 010 2.828z" clip-rule="evenodd"/></svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Information Box -->
    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-blue-800">Catatan</p>
                <p class="text-sm text-blue-700 mt-1">Pengaturan ini akan diterapkan di seluruh aplikasi. Pastikan semua data sudah benar sebelum menyimpan.</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const textKeys = [
        'center_email',
        'center_hours_open',
        'center_hours_close',
        'center_address',
        'admin_login_title',
        'admin_login_subtitle',
        'admin_login_description',
        'kk_login_badge',
        'kk_login_hero_title',
        'kk_login_hero_subtitle',
        'kk_login_feature_1_title',
        'kk_login_feature_1_desc',
        'kk_login_feature_2_title',
        'kk_login_feature_2_desc',
        'kk_login_footer_text',
        'kk_login_form_title',
        'kk_login_form_subtitle',
        'kk_news_title',
        'kk_news_summary',
        'kk_news_content',
        'kk_news_published_at',
        'kk_news_link_label'
    ];

    textKeys.forEach(function (key) {
        const input = document.getElementById(key);
        if (!input) {
            return;
        }

        const targets = document.querySelectorAll('[data-preview-target="' + key + '"]');
        const sync = function () {
            const value = input.value.trim();
            targets.forEach(function (target) {
                if (value === '') {
                    target.textContent = '-';
                    return;
                }

                target.textContent = value;
            });
        };

        input.addEventListener('input', sync);
        sync();
    });

    const statusInput = document.getElementById('kk_news_status');
    const statusTargets = document.querySelectorAll('[data-preview-target="kk_news_status_label"]');
    if (statusInput && statusTargets.length) {
        const syncStatus = function () {
            const active = statusInput.value === 'active';
            statusTargets.forEach(function (target) {
                target.textContent = active ? 'Aktif' : 'Nonaktif';
                target.className = active
                    ? 'rounded-full px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700'
                    : 'rounded-full px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-600';
            });
        };

        statusInput.addEventListener('change', syncStatus);
        syncStatus();
    }

    const newsLinkInput = document.getElementById('kk_news_link_url');
    const newsLinkPreview = document.getElementById('kk_news_link_preview');
    if (newsLinkInput && newsLinkPreview) {
        const syncLinkVisibility = function () {
            if (newsLinkInput.value.trim() === '') {
                newsLinkPreview.classList.add('hidden');
                return;
            }

            newsLinkPreview.classList.remove('hidden');
        };

        newsLinkInput.addEventListener('input', syncLinkVisibility);
        syncLinkVisibility();
    }
});
</script>
@endsection
