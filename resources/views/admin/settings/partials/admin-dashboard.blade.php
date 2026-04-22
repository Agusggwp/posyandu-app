<div class="bg-white rounded-2xl shadow-xl border border-indigo-100 overflow-hidden">
    <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <button type="button" data-accordion-toggle="panel-admin-dashboard" class="w-full flex items-center justify-between gap-3 px-4 py-4 sm:px-6 bg-indigo-50/70 border-b border-indigo-100 hover:bg-indigo-100/70 transition-colors duration-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 text-left">
                <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v4H3V3zm0 6h14v8a1 1 0 01-1 1H4a1 1 0 01-1-1V9zm4 2a1 1 0 100 2h2a1 1 0 100-2H7z" clip-rule="evenodd"/>
                </svg>
                Pengaturan Tampilan Dashboard Admin
            </h3>
            <svg data-accordion-icon="panel-admin-dashboard" class="w-5 h-5 text-indigo-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div id="panel-admin-dashboard" class="hidden px-4 pb-4 pt-5 sm:px-6 sm:pb-6 sm:pt-6 space-y-6">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="admin_dashboard_title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Dashboard</label>
                    <input type="text" id="admin_dashboard_title" name="admin_dashboard_title" value="{{ old('admin_dashboard_title', $settings['admin_dashboard_title']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_dashboard_title') border-red-500 @enderror">
                    @error('admin_dashboard_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label for="admin_dashboard_subtitle" class="block text-sm font-semibold text-gray-700 mb-2">Subjudul Dashboard</label>
                    <input type="text" id="admin_dashboard_subtitle" name="admin_dashboard_subtitle" value="{{ old('admin_dashboard_subtitle', $settings['admin_dashboard_subtitle']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_dashboard_subtitle') border-red-500 @enderror">
                    @error('admin_dashboard_subtitle')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="admin_show_stats_cards" class="block text-sm font-semibold text-gray-700 mb-2">Kartu Statistik</label>
                    <select id="admin_show_stats_cards" name="admin_show_stats_cards" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_show_stats_cards') border-red-500 @enderror">
                        <option value="active" {{ old('admin_show_stats_cards', $settings['admin_show_stats_cards']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('admin_show_stats_cards', $settings['admin_show_stats_cards']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('admin_show_stats_cards')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="admin_show_recent_users" class="block text-sm font-semibold text-gray-700 mb-2">Daftar User Terbaru</label>
                    <select id="admin_show_recent_users" name="admin_show_recent_users" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_show_recent_users') border-red-500 @enderror">
                        <option value="active" {{ old('admin_show_recent_users', $settings['admin_show_recent_users']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('admin_show_recent_users', $settings['admin_show_recent_users']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('admin_show_recent_users')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="admin_show_recent_activities" class="block text-sm font-semibold text-gray-700 mb-2">Daftar Aktivitas Terbaru</label>
                    <select id="admin_show_recent_activities" name="admin_show_recent_activities" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_show_recent_activities') border-red-500 @enderror">
                        <option value="active" {{ old('admin_show_recent_activities', $settings['admin_show_recent_activities']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('admin_show_recent_activities', $settings['admin_show_recent_activities']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('admin_show_recent_activities')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="admin_show_activity_chart" class="block text-sm font-semibold text-gray-700 mb-2">Grafik Aktivitas</label>
                    <select id="admin_show_activity_chart" name="admin_show_activity_chart" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_show_activity_chart') border-red-500 @enderror">
                        <option value="active" {{ old('admin_show_activity_chart', $settings['admin_show_activity_chart']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('admin_show_activity_chart', $settings['admin_show_activity_chart']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('admin_show_activity_chart')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="admin_show_role_distribution" class="block text-sm font-semibold text-gray-700 mb-2">Distribusi Role</label>
                    <select id="admin_show_role_distribution" name="admin_show_role_distribution" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_show_role_distribution') border-red-500 @enderror">
                        <option value="active" {{ old('admin_show_role_distribution', $settings['admin_show_role_distribution']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('admin_show_role_distribution', $settings['admin_show_role_distribution']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('admin_show_role_distribution')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="admin_show_quick_actions" class="block text-sm font-semibold text-gray-700 mb-2">Quick Actions</label>
                    <select id="admin_show_quick_actions" name="admin_show_quick_actions" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admin_show_quick_actions') border-red-500 @enderror">
                        <option value="active" {{ old('admin_show_quick_actions', $settings['admin_show_quick_actions']) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('admin_show_quick_actions', $settings['admin_show_quick_actions']) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('admin_show_quick_actions')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="rounded-2xl border border-cyan-100 bg-cyan-50/60 p-6">
                <div class="flex items-center justify-between gap-3">
                    <h4 class="text-base font-bold text-cyan-900">Preview Komponen Dashboard</h4>
                    <span class="text-xs font-semibold text-cyan-700">Live preview</span>
                </div>
                <div class="mt-4 space-y-3 text-sm text-cyan-900">
                    <p><span class="font-semibold">Judul:</span> <span data-preview-target="admin_dashboard_title">{{ old('admin_dashboard_title', $settings['admin_dashboard_title']) }}</span></p>
                    <p><span class="font-semibold">Subjudul:</span> <span data-preview-target="admin_dashboard_subtitle">{{ old('admin_dashboard_subtitle', $settings['admin_dashboard_subtitle']) }}</span></p>
                    <p><span class="font-semibold">Kartu Statistik:</span> <span data-preview-target="admin_show_stats_cards_label">{{ old('admin_show_stats_cards', $settings['admin_show_stats_cards']) === 'active' ? 'Aktif' : 'Nonaktif' }}</span></p>
                    <p><span class="font-semibold">User Terbaru:</span> <span data-preview-target="admin_show_recent_users_label">{{ old('admin_show_recent_users', $settings['admin_show_recent_users']) === 'active' ? 'Aktif' : 'Nonaktif' }}</span></p>
                    <p><span class="font-semibold">Aktivitas Terbaru:</span> <span data-preview-target="admin_show_recent_activities_label">{{ old('admin_show_recent_activities', $settings['admin_show_recent_activities']) === 'active' ? 'Aktif' : 'Nonaktif' }}</span></p>
                    <p><span class="font-semibold">Grafik Aktivitas:</span> <span data-preview-target="admin_show_activity_chart_label">{{ old('admin_show_activity_chart', $settings['admin_show_activity_chart']) === 'active' ? 'Aktif' : 'Nonaktif' }}</span></p>
                    <p><span class="font-semibold">Distribusi Role:</span> <span data-preview-target="admin_show_role_distribution_label">{{ old('admin_show_role_distribution', $settings['admin_show_role_distribution']) === 'active' ? 'Aktif' : 'Nonaktif' }}</span></p>
                    <p><span class="font-semibold">Quick Actions:</span> <span data-preview-target="admin_show_quick_actions_label">{{ old('admin_show_quick_actions', $settings['admin_show_quick_actions']) === 'active' ? 'Aktif' : 'Nonaktif' }}</span></p>
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
