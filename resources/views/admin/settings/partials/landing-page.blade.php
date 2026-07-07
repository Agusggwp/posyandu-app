<div class="bg-white rounded-2xl shadow-xl border border-indigo-100 overflow-hidden">
    <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <button type="button" data-accordion-toggle="panel-landing-page" class="w-full flex items-center justify-between gap-3 px-4 py-4 sm:px-6 bg-indigo-50/70 border-b border-indigo-100 hover:bg-indigo-100/70 transition-colors duration-200">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 text-left">
                <i class="fa-solid fa-home text-indigo-600 mr-2"></i>
                Pengaturan Landing Page
            </h3>
            <svg data-accordion-icon="panel-landing-page" class="w-5 h-5 text-indigo-600 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div id="panel-landing-page" class="hidden px-4 pb-4 pt-5 sm:px-6 sm:pb-6 sm:pt-6 space-y-6">
            
            <!-- SECTION 1: JADWAL POSYANDU -->
            <div class="border-b border-gray-100 pb-5">
                <h4 class="text-base font-bold text-indigo-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-alt text-indigo-500"></i>
                    Jadwal Kegiatan Posyandu
                </h4>
                
                <div class="space-y-6">
                    <!-- Schedule Balita -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md mb-3 inline-block">Kategori Balita</span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="sched_balita_title" class="block text-xs font-bold text-gray-600 uppercase mb-1">Judul Layanan</label>
                                <input type="text" id="sched_balita_title" name="sched_balita_title" value="{{ old('sched_balita_title', $settings['sched_balita_title']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="sched_balita_day" class="block text-xs font-bold text-gray-600 uppercase mb-1">Hari Pelaksanaan</label>
                                <input type="text" id="sched_balita_day" name="sched_balita_day" value="{{ old('sched_balita_day', $settings['sched_balita_day']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="sched_balita_time" class="block text-xs font-bold text-gray-600 uppercase mb-1">Waktu / Jam</label>
                                <input type="text" id="sched_balita_time" name="sched_balita_time" value="{{ old('sched_balita_time', $settings['sched_balita_time']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div class="md:col-span-2">
                                <label for="sched_balita_desc" class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi Layanan</label>
                                <textarea id="sched_balita_desc" name="sched_balita_desc" rows="2" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">{{ old('sched_balita_desc', $settings['sched_balita_desc']) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Ibu Hamil -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-xs font-bold text-fuchsia-600 bg-fuchsia-50 px-2.5 py-1 rounded-md mb-3 inline-block">Kategori Ibu Hamil</span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="sched_bumil_title" class="block text-xs font-bold text-gray-600 uppercase mb-1">Judul Layanan</label>
                                <input type="text" id="sched_bumil_title" name="sched_bumil_title" value="{{ old('sched_bumil_title', $settings['sched_bumil_title']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="sched_bumil_day" class="block text-xs font-bold text-gray-600 uppercase mb-1">Hari Pelaksanaan</label>
                                <input type="text" id="sched_bumil_day" name="sched_bumil_day" value="{{ old('sched_bumil_day', $settings['sched_bumil_day']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="sched_bumil_time" class="block text-xs font-bold text-gray-600 uppercase mb-1">Waktu / Jam</label>
                                <input type="text" id="sched_bumil_time" name="sched_bumil_time" value="{{ old('sched_bumil_time', $settings['sched_bumil_time']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div class="md:col-span-2">
                                <label for="sched_bumil_desc" class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi Layanan</label>
                                <textarea id="sched_bumil_desc" name="sched_bumil_desc" rows="2" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">{{ old('sched_bumil_desc', $settings['sched_bumil_desc']) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Lansia / Remaja -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md mb-3 inline-block">Kategori Lansia & Remaja</span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="sched_lansia_title" class="block text-xs font-bold text-gray-600 uppercase mb-1">Judul Layanan</label>
                                <input type="text" id="sched_lansia_title" name="sched_lansia_title" value="{{ old('sched_lansia_title', $settings['sched_lansia_title']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="sched_lansia_day" class="block text-xs font-bold text-gray-600 uppercase mb-1">Hari Pelaksanaan</label>
                                <input type="text" id="sched_lansia_day" name="sched_lansia_day" value="{{ old('sched_lansia_day', $settings['sched_lansia_day']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="sched_lansia_time" class="block text-xs font-bold text-gray-600 uppercase mb-1">Waktu / Jam</label>
                                <input type="text" id="sched_lansia_time" name="sched_lansia_time" value="{{ old('sched_lansia_time', $settings['sched_lansia_time']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div class="md:col-span-2">
                                <label for="sched_lansia_desc" class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi Layanan</label>
                                <textarea id="sched_lansia_desc" name="sched_lansia_desc" rows="2" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">{{ old('sched_lansia_desc', $settings['sched_lansia_desc']) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: EDUKASI / TIPS KESEHATAN -->
            <div>
                <h4 class="text-base font-bold text-indigo-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-heart-pulse text-indigo-500"></i>
                    Tips Edukasi Kesehatan
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tips Balita -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md mb-3 inline-block">Tips Balita</span>
                        <div class="space-y-3">
                            <div>
                                <label for="edu_balita_title" class="block text-xs font-bold text-gray-600 uppercase mb-1">Judul Tips</label>
                                <input type="text" id="edu_balita_title" name="edu_balita_title" value="{{ old('edu_balita_title', $settings['edu_balita_title']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="edu_balita_desc" class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi Tips</label>
                                <textarea id="edu_balita_desc" name="edu_balita_desc" rows="2" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">{{ old('edu_balita_desc', $settings['edu_balita_desc']) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Ibu Hamil -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-xs font-bold text-fuchsia-600 bg-fuchsia-50 px-2.5 py-1 rounded-md mb-3 inline-block">Tips Ibu Hamil</span>
                        <div class="space-y-3">
                            <div>
                                <label for="edu_bumil_title" class="block text-xs font-bold text-gray-600 uppercase mb-1">Judul Tips</label>
                                <input type="text" id="edu_bumil_title" name="edu_bumil_title" value="{{ old('edu_bumil_title', $settings['edu_bumil_title']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="edu_bumil_desc" class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi Tips</label>
                                <textarea id="edu_bumil_desc" name="edu_bumil_desc" rows="2" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">{{ old('edu_bumil_desc', $settings['edu_bumil_desc']) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Lansia -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md mb-3 inline-block">Tips Lansia</span>
                        <div class="space-y-3">
                            <div>
                                <label for="edu_lansia_title" class="block text-xs font-bold text-gray-600 uppercase mb-1">Judul Tips</label>
                                <input type="text" id="edu_lansia_title" name="edu_lansia_title" value="{{ old('edu_lansia_title', $settings['edu_lansia_title']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="edu_lansia_desc" class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi Tips</label>
                                <textarea id="edu_lansia_desc" name="edu_lansia_desc" rows="2" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">{{ old('edu_lansia_desc', $settings['edu_lansia_desc']) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Umum -->
                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md mb-3 inline-block">Tips Umum</span>
                        <div class="space-y-3">
                            <div>
                                <label for="edu_umum_title" class="block text-xs font-bold text-gray-600 uppercase mb-1">Judul Tips</label>
                                <input type="text" id="edu_umum_title" name="edu_umum_title" value="{{ old('edu_umum_title', $settings['edu_umum_title']) }}" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="edu_umum_desc" class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi Tips</label>
                                <textarea id="edu_umum_desc" name="edu_umum_desc" rows="2" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">{{ old('edu_umum_desc', $settings['edu_umum_desc']) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="pt-4 border-t border-gray-200 px-4 pb-4 sm:px-6 sm:pb-6">
            <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <i class="fa-solid fa-save mr-2"></i>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
