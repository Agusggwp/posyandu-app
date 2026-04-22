<div class="bg-white rounded-2xl shadow-xl border border-indigo-100 overflow-hidden">
    <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <button type="button" data-accordion-toggle="panel-kk-news" class="w-full flex items-center justify-between gap-3 px-4 py-4 sm:px-6 bg-indigo-50/70 border-b border-indigo-100 hover:bg-indigo-100/70 transition-colors duration-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 text-left">
                <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414A1 1 0 0016.707 7L13 3.293A1 1 0 0012.293 3H4zm8 1.414L15.586 8H12V4.414zM5 9a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                Pengaturan Berita Kepala Keluarga
            </h3>
            <svg data-accordion-icon="panel-kk-news" class="w-5 h-5 text-indigo-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div id="panel-kk-news" class="hidden px-4 pb-4 pt-5 sm:px-6 sm:pb-6 sm:pt-6 space-y-6">
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

        <div class="pt-4 border-t border-gray-200 px-4 pb-4 sm:px-6 sm:pb-6">
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M19.414 4.414l-17.828 17.828a2 2 0 01-2.828 0l-2.83-2.829a2 2 0 010-2.828L13.758.757a2 2 0 012.828 0l2.828 2.829a2 2 0 010 2.828z" clip-rule="evenodd"/></svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
