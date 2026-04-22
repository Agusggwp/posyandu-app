<div class="bg-white rounded-2xl shadow-xl border border-indigo-100 overflow-hidden">
    <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <button type="button" data-accordion-toggle="panel-center-info" class="w-full flex items-center justify-between gap-3 px-4 py-4 sm:px-6 bg-indigo-50/70 border-b border-indigo-100 hover:bg-indigo-100/70 transition-colors duration-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 text-left">
                <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                Informasi Pusat Kesehatan
            </h3>
            <svg data-accordion-icon="panel-center-info" class="w-5 h-5 text-indigo-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div id="panel-center-info" class="hidden px-4 pb-4 pt-5 sm:px-6 sm:pb-6 sm:pt-6 space-y-6">
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

        <div class="pt-4 border-t border-gray-200 px-4 pb-4 sm:px-6 sm:pb-6">
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M19.414 4.414l-17.828 17.828a2 2 0 01-2.828 0l-2.83-2.829a2 2 0 010-2.828L13.758.757a2 2 0 012.828 0l2.828 2.829a2 2 0 010 2.828z" clip-rule="evenodd"/></svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
