<div class="bg-white rounded-2xl shadow-xl border border-indigo-100 overflow-hidden">
    <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <button type="button" data-accordion-toggle="panel-admin-login" class="w-full flex items-center justify-between gap-3 px-4 py-4 sm:px-6 bg-indigo-50/70 border-b border-indigo-100 hover:bg-indigo-100/70 transition-colors duration-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 text-left">
                <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                </svg>
                Kustomisasi Login Admin
            </h3>
            <svg data-accordion-icon="panel-admin-login" class="w-5 h-5 text-indigo-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div id="panel-admin-login" class="hidden px-4 pb-4 pt-5 sm:px-6 sm:pb-6 sm:pt-6 space-y-6">
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

        <div class="pt-4 border-t border-gray-200 px-4 pb-4 sm:px-6 sm:pb-6">
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M19.414 4.414l-17.828 17.828a2 2 0 01-2.828 0l-2.83-2.829a2 2 0 010-2.828L13.758.757a2 2 0 012.828 0l2.828 2.829a2 2 0 010 2.828z" clip-rule="evenodd"/></svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
