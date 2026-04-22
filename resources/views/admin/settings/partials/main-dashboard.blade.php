<div class="bg-white rounded-2xl shadow-xl border border-indigo-100 overflow-hidden">
    <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <button type="button" data-accordion-toggle="panel-main-dashboard" class="w-full flex items-center justify-between gap-3 px-4 py-4 sm:px-6 bg-indigo-50/70 border-b border-indigo-100 hover:bg-indigo-100/70 transition-colors duration-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 text-left">
                <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm3 3a1 1 0 000 2h8a1 1 0 100-2H6zm0 4a1 1 0 100 2h5a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                Pengaturan Isi Dashboard Utama
            </h3>
            <svg data-accordion-icon="panel-main-dashboard" class="w-5 h-5 text-indigo-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div id="panel-main-dashboard" class="hidden px-4 pb-4 pt-5 sm:px-6 sm:pb-6 sm:pt-6 space-y-6">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="main_dashboard_checks_title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Pemeriksaan</label>
                    <input type="text" id="main_dashboard_checks_title" name="main_dashboard_checks_title" value="{{ old('main_dashboard_checks_title', $settings['main_dashboard_checks_title']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('main_dashboard_checks_title') border-red-500 @enderror">
                    @error('main_dashboard_checks_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="main_dashboard_nutrition_title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Status Gizi</label>
                    <input type="text" id="main_dashboard_nutrition_title" name="main_dashboard_nutrition_title" value="{{ old('main_dashboard_nutrition_title', $settings['main_dashboard_nutrition_title']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('main_dashboard_nutrition_title') border-red-500 @enderror">
                    @error('main_dashboard_nutrition_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="main_dashboard_quick_actions_title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Quick Actions</label>
                    <input type="text" id="main_dashboard_quick_actions_title" name="main_dashboard_quick_actions_title" value="{{ old('main_dashboard_quick_actions_title', $settings['main_dashboard_quick_actions_title']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('main_dashboard_quick_actions_title') border-red-500 @enderror">
                    @error('main_dashboard_quick_actions_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="main_dashboard_system_info_title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Informasi Sistem</label>
                    <input type="text" id="main_dashboard_system_info_title" name="main_dashboard_system_info_title" value="{{ old('main_dashboard_system_info_title', $settings['main_dashboard_system_info_title']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('main_dashboard_system_info_title') border-red-500 @enderror">
                    @error('main_dashboard_system_info_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="main_dashboard_stat_note" class="block text-sm font-semibold text-gray-700 mb-2">Teks Catatan Kartu Statistik</label>
                    <input type="text" id="main_dashboard_stat_note" name="main_dashboard_stat_note" value="{{ old('main_dashboard_stat_note', $settings['main_dashboard_stat_note']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('main_dashboard_stat_note') border-red-500 @enderror">
                    @error('main_dashboard_stat_note')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">
                <h4 class="text-sm font-bold text-slate-800 mb-3">Pilih Card Statistik Yang Ditampilkan</h4>
                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Card Total Keluarga</label><select id="main_dashboard_show_card_keluarga" name="main_dashboard_show_card_keluarga" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_card_keluarga', $settings['main_dashboard_show_card_keluarga']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_card_keluarga', $settings['main_dashboard_show_card_keluarga']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Card Total Balita</label><select id="main_dashboard_show_card_balita" name="main_dashboard_show_card_balita" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_card_balita', $settings['main_dashboard_show_card_balita']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_card_balita', $settings['main_dashboard_show_card_balita']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Card Total Ibu Hamil</label><select id="main_dashboard_show_card_ibu_hamil" name="main_dashboard_show_card_ibu_hamil" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_card_ibu_hamil', $settings['main_dashboard_show_card_ibu_hamil']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_card_ibu_hamil', $settings['main_dashboard_show_card_ibu_hamil']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Card Total Nifas</label><select id="main_dashboard_show_card_nifas" name="main_dashboard_show_card_nifas" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_card_nifas', $settings['main_dashboard_show_card_nifas']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_card_nifas', $settings['main_dashboard_show_card_nifas']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Card Total Remaja</label><select id="main_dashboard_show_card_remaja" name="main_dashboard_show_card_remaja" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_card_remaja', $settings['main_dashboard_show_card_remaja']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_card_remaja', $settings['main_dashboard_show_card_remaja']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Card Total Lansia</label><select id="main_dashboard_show_card_lansia" name="main_dashboard_show_card_lansia" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_card_lansia', $settings['main_dashboard_show_card_lansia']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_card_lansia', $settings['main_dashboard_show_card_lansia']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">
                <h4 class="text-sm font-bold text-slate-800 mb-3">Pilih Menu Quick Actions</h4>
                <div class="grid grid-cols-1 gap-3 md:grid-cols-5">
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Input Balita</label><select id="main_dashboard_show_action_balita" name="main_dashboard_show_action_balita" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_action_balita', $settings['main_dashboard_show_action_balita']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_action_balita', $settings['main_dashboard_show_action_balita']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Input Ibu Hamil</label><select id="main_dashboard_show_action_ibu_hamil" name="main_dashboard_show_action_ibu_hamil" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_action_ibu_hamil', $settings['main_dashboard_show_action_ibu_hamil']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_action_ibu_hamil', $settings['main_dashboard_show_action_ibu_hamil']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Input Nifas</label><select id="main_dashboard_show_action_nifas" name="main_dashboard_show_action_nifas" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_action_nifas', $settings['main_dashboard_show_action_nifas']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_action_nifas', $settings['main_dashboard_show_action_nifas']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Input Remaja</label><select id="main_dashboard_show_action_remaja" name="main_dashboard_show_action_remaja" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_action_remaja', $settings['main_dashboard_show_action_remaja']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_action_remaja', $settings['main_dashboard_show_action_remaja']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Input Lansia</label><select id="main_dashboard_show_action_lansia" name="main_dashboard_show_action_lansia" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_action_lansia', $settings['main_dashboard_show_action_lansia']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_action_lansia', $settings['main_dashboard_show_action_lansia']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:p-5">
                <h4 class="text-sm font-bold text-slate-800 mb-3">Pilih Item Pemeriksaan Bulan Ini</h4>
                <div class="grid grid-cols-1 gap-3 md:grid-cols-5">
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Pemeriksaan Balita</label><select id="main_dashboard_show_checks_balita" name="main_dashboard_show_checks_balita" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_checks_balita', $settings['main_dashboard_show_checks_balita']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_checks_balita', $settings['main_dashboard_show_checks_balita']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Pemeriksaan Ibu Hamil</label><select id="main_dashboard_show_checks_ibu_hamil" name="main_dashboard_show_checks_ibu_hamil" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_checks_ibu_hamil', $settings['main_dashboard_show_checks_ibu_hamil']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_checks_ibu_hamil', $settings['main_dashboard_show_checks_ibu_hamil']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Pemeriksaan Nifas</label><select id="main_dashboard_show_checks_nifas" name="main_dashboard_show_checks_nifas" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_checks_nifas', $settings['main_dashboard_show_checks_nifas']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_checks_nifas', $settings['main_dashboard_show_checks_nifas']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Pemeriksaan Remaja</label><select id="main_dashboard_show_checks_remaja" name="main_dashboard_show_checks_remaja" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_checks_remaja', $settings['main_dashboard_show_checks_remaja']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_checks_remaja', $settings['main_dashboard_show_checks_remaja']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                    <div><label class="block text-xs font-semibold text-slate-700 mb-1">Pemeriksaan Lansia</label><select id="main_dashboard_show_checks_lansia" name="main_dashboard_show_checks_lansia" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><option value="active" {{ old('main_dashboard_show_checks_lansia', $settings['main_dashboard_show_checks_lansia']) === 'active' ? 'selected' : '' }}>Aktif</option><option value="inactive" {{ old('main_dashboard_show_checks_lansia', $settings['main_dashboard_show_checks_lansia']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option></select></div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="main_dashboard_show_stats_cards" class="block text-sm font-semibold text-gray-700 mb-2">Tampilkan Kartu Statistik</label>
                    <select id="main_dashboard_show_stats_cards" name="main_dashboard_show_stats_cards" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('main_dashboard_show_stats_cards') border-red-500 @enderror">
                        <option value="active" {{ old('main_dashboard_show_stats_cards', $settings['main_dashboard_show_stats_cards']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('main_dashboard_show_stats_cards', $settings['main_dashboard_show_stats_cards']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('main_dashboard_show_stats_cards')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="main_dashboard_show_checks_summary" class="block text-sm font-semibold text-gray-700 mb-2">Tampilkan Ringkasan Pemeriksaan</label>
                    <select id="main_dashboard_show_checks_summary" name="main_dashboard_show_checks_summary" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('main_dashboard_show_checks_summary') border-red-500 @enderror">
                        <option value="active" {{ old('main_dashboard_show_checks_summary', $settings['main_dashboard_show_checks_summary']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('main_dashboard_show_checks_summary', $settings['main_dashboard_show_checks_summary']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('main_dashboard_show_checks_summary')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="main_dashboard_show_nutrition" class="block text-sm font-semibold text-gray-700 mb-2">Tampilkan Status Gizi</label>
                    <select id="main_dashboard_show_nutrition" name="main_dashboard_show_nutrition" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('main_dashboard_show_nutrition') border-red-500 @enderror">
                        <option value="active" {{ old('main_dashboard_show_nutrition', $settings['main_dashboard_show_nutrition']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('main_dashboard_show_nutrition', $settings['main_dashboard_show_nutrition']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('main_dashboard_show_nutrition')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="main_dashboard_show_quick_actions" class="block text-sm font-semibold text-gray-700 mb-2">Tampilkan Quick Actions</label>
                    <select id="main_dashboard_show_quick_actions" name="main_dashboard_show_quick_actions" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('main_dashboard_show_quick_actions') border-red-500 @enderror">
                        <option value="active" {{ old('main_dashboard_show_quick_actions', $settings['main_dashboard_show_quick_actions']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('main_dashboard_show_quick_actions', $settings['main_dashboard_show_quick_actions']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('main_dashboard_show_quick_actions')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="main_dashboard_show_system_info" class="block text-sm font-semibold text-gray-700 mb-2">Tampilkan Informasi Sistem</label>
                    <select id="main_dashboard_show_system_info" name="main_dashboard_show_system_info" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('main_dashboard_show_system_info') border-red-500 @enderror">
                        <option value="active" {{ old('main_dashboard_show_system_info', $settings['main_dashboard_show_system_info']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('main_dashboard_show_system_info', $settings['main_dashboard_show_system_info']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('main_dashboard_show_system_info')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="rounded-2xl border border-sky-100 bg-sky-50/60 p-6">
                <div class="flex items-center justify-between gap-3">
                    <h4 class="text-base font-bold text-sky-900">Preview Dashboard Utama</h4>
                    <span class="text-xs font-semibold text-sky-700">Live preview</span>
                </div>

                <div class="mt-4 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" data-preview-toggle="main_dashboard_show_stats_cards">
                        <div class="rounded-xl border border-violet-200 bg-white p-3" data-preview-toggle="main_dashboard_show_card_keluarga"><p class="text-xs text-slate-500">Total Keluarga</p><p class="text-xl font-bold text-violet-700">120</p><p class="text-[11px] text-emerald-700" data-preview-target="main_dashboard_stat_note">{{ old('main_dashboard_stat_note', $settings['main_dashboard_stat_note']) }}</p></div>
                        <div class="rounded-xl border border-blue-200 bg-white p-3" data-preview-toggle="main_dashboard_show_card_balita"><p class="text-xs text-slate-500">Total Balita</p><p class="text-xl font-bold text-blue-700">88</p><p class="text-[11px] text-emerald-700" data-preview-target="main_dashboard_stat_note">{{ old('main_dashboard_stat_note', $settings['main_dashboard_stat_note']) }}</p></div>
                        <div class="rounded-xl border border-emerald-200 bg-white p-3" data-preview-toggle="main_dashboard_show_card_ibu_hamil"><p class="text-xs text-slate-500">Total Ibu Hamil</p><p class="text-xl font-bold text-emerald-700">24</p><p class="text-[11px] text-emerald-700" data-preview-target="main_dashboard_stat_note">{{ old('main_dashboard_stat_note', $settings['main_dashboard_stat_note']) }}</p></div>
                        <div class="rounded-xl border border-violet-200 bg-white p-3" data-preview-toggle="main_dashboard_show_card_nifas"><p class="text-xs text-slate-500">Total Nifas</p><p class="text-xl font-bold text-violet-700">17</p><p class="text-[11px] text-emerald-700" data-preview-target="main_dashboard_stat_note">{{ old('main_dashboard_stat_note', $settings['main_dashboard_stat_note']) }}</p></div>
                        <div class="rounded-xl border border-blue-200 bg-white p-3" data-preview-toggle="main_dashboard_show_card_remaja"><p class="text-xs text-slate-500">Total Remaja</p><p class="text-xl font-bold text-blue-700">57</p><p class="text-[11px] text-emerald-700" data-preview-target="main_dashboard_stat_note">{{ old('main_dashboard_stat_note', $settings['main_dashboard_stat_note']) }}</p></div>
                        <div class="rounded-xl border border-orange-200 bg-white p-3" data-preview-toggle="main_dashboard_show_card_lansia"><p class="text-xs text-slate-500">Total Lansia</p><p class="text-xl font-bold text-orange-700">35</p><p class="text-[11px] text-emerald-700" data-preview-target="main_dashboard_stat_note">{{ old('main_dashboard_stat_note', $settings['main_dashboard_stat_note']) }}</p></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="rounded-xl border border-slate-200 bg-white p-3" data-preview-toggle="main_dashboard_show_checks_summary">
                            <p class="font-semibold text-slate-800" data-preview-target="main_dashboard_checks_title">{{ old('main_dashboard_checks_title', $settings['main_dashboard_checks_title']) }}</p>
                            <div class="mt-2 space-y-2 text-xs">
                                <p data-preview-toggle="main_dashboard_show_checks_balita">Balita: <span class="font-bold">35</span></p>
                                <p data-preview-toggle="main_dashboard_show_checks_ibu_hamil">Ibu Hamil: <span class="font-bold">20</span></p>
                                <p data-preview-toggle="main_dashboard_show_checks_nifas">Nifas: <span class="font-bold">12</span></p>
                                <p data-preview-toggle="main_dashboard_show_checks_remaja">Remaja: <span class="font-bold">18</span></p>
                                <p data-preview-toggle="main_dashboard_show_checks_lansia">Lansia: <span class="font-bold">14</span></p>
                            </div>
                        </div>
                        <div class="rounded-xl border border-rose-200 bg-white p-3" data-preview-toggle="main_dashboard_show_nutrition">
                            <p class="font-semibold text-slate-800" data-preview-target="main_dashboard_nutrition_title">{{ old('main_dashboard_nutrition_title', $settings['main_dashboard_nutrition_title']) }}</p>
                            <p class="text-xs text-rose-600 mt-2">Stunting: <span class="font-bold">6 anak</span></p>
                        </div>
                        <div class="rounded-xl border border-teal-200 bg-white p-3" data-preview-toggle="main_dashboard_show_quick_actions">
                            <p class="font-semibold text-slate-800" data-preview-target="main_dashboard_quick_actions_title">{{ old('main_dashboard_quick_actions_title', $settings['main_dashboard_quick_actions_title']) }}</p>
                            <div class="mt-2 space-y-1 text-xs">
                                <p data-preview-toggle="main_dashboard_show_action_balita">Input Pemeriksaan Balita</p>
                                <p data-preview-toggle="main_dashboard_show_action_ibu_hamil">Input Pemeriksaan Ibu Hamil</p>
                                <p data-preview-toggle="main_dashboard_show_action_nifas">Input Pemeriksaan Nifas</p>
                                <p data-preview-toggle="main_dashboard_show_action_remaja">Input Pemeriksaan Remaja</p>
                                <p data-preview-toggle="main_dashboard_show_action_lansia">Input Pemeriksaan Lansia</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-3" data-preview-toggle="main_dashboard_show_system_info">
                        <p class="font-semibold text-slate-800" data-preview-target="main_dashboard_system_info_title">{{ old('main_dashboard_system_info_title', $settings['main_dashboard_system_info_title']) }}</p>
                        <p class="text-xs text-slate-500 mt-1">Nama Pengguna, Role, dan ringkasan data akan tampil di sini.</p>
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
