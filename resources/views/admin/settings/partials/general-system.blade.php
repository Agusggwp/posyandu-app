<div class="bg-white rounded-2xl shadow-xl border border-indigo-100 overflow-hidden">
    <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <button type="button" data-accordion-toggle="panel-general" class="w-full flex items-center justify-between gap-3 px-4 py-4 sm:px-6 bg-indigo-50/70 border-b border-indigo-100 hover:bg-indigo-100/70 transition-colors duration-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 text-left">
                <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h4a2 2 0 012 2v1H2V5zm0 3h8v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8zm10-3a2 2 0 012-2h2a2 2 0 012 2v3h-8V5zm8 5h-8v5a2 2 0 002 2h4a2 2 0 002-2v-5z" clip-rule="evenodd"/>
                </svg>
                Pengaturan Umum Sistem
            </h3>
            <svg data-accordion-icon="panel-general" class="w-5 h-5 text-indigo-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div id="panel-general" class="hidden px-4 pb-4 pt-5 sm:px-6 sm:pb-6 sm:pt-6 space-y-6">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="system_app_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Aplikasi</label>
                    <input type="text" id="system_app_name" name="system_app_name" value="{{ old('system_app_name', $settings['system_app_name']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('system_app_name') border-red-500 @enderror">
                    @error('system_app_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="system_app_tagline" class="block text-sm font-semibold text-gray-700 mb-2">Tagline Aplikasi</label>
                    <input type="text" id="system_app_tagline" name="system_app_tagline" value="{{ old('system_app_tagline', $settings['system_app_tagline']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('system_app_tagline') border-red-500 @enderror">
                    @error('system_app_tagline')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="kk_registration_status" class="block text-sm font-semibold text-gray-700 mb-2">Pendaftaran Kepala Keluarga</label>
                    <select id="kk_registration_status" name="kk_registration_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_registration_status') border-red-500 @enderror">
                        <option value="active" {{ old('kk_registration_status', $settings['kk_registration_status']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('kk_registration_status', $settings['kk_registration_status']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('kk_registration_status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="kk_auto_approve" class="block text-sm font-semibold text-gray-700 mb-2">Auto Approve Akun KK</label>
                    <select id="kk_auto_approve" name="kk_auto_approve" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kk_auto_approve') border-red-500 @enderror">
                        <option value="inactive" {{ old('kk_auto_approve', $settings['kk_auto_approve']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="active" {{ old('kk_auto_approve', $settings['kk_auto_approve']) === 'active' ? 'selected' : '' }}>Aktif</option>
                    </select>
                    @error('kk_auto_approve')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="rounded-2xl border border-violet-100 bg-violet-50/60 p-6">
                <div class="flex items-center justify-between gap-3">
                    <h4 class="text-base font-bold text-violet-900">Preview Pengaturan Umum</h4>
                    <span class="text-xs font-semibold text-violet-700">Live preview</span>
                </div>
                <div class="mt-4 space-y-3 text-sm text-violet-900">
                    <p><span class="font-semibold">Nama Aplikasi:</span> <span data-preview-target="system_app_name">{{ old('system_app_name', $settings['system_app_name']) }}</span></p>
                    <p><span class="font-semibold">Tagline:</span> <span data-preview-target="system_app_tagline">{{ old('system_app_tagline', $settings['system_app_tagline']) }}</span></p>
                    <p><span class="font-semibold">Pendaftaran KK:</span> <span data-preview-target="kk_registration_status_label">{{ old('kk_registration_status', $settings['kk_registration_status']) === 'active' ? 'Aktif' : 'Nonaktif' }}</span></p>
                    <p><span class="font-semibold">Auto Approve KK:</span> <span data-preview-target="kk_auto_approve_label">{{ old('kk_auto_approve', $settings['kk_auto_approve']) === 'active' ? 'Aktif' : 'Nonaktif' }}</span></p>
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
