<div id="dashboard" class="section">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Total Anggota</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-2">{{ $dashboardMetrics['total_anggota'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Periksa Bulan Ini</p>
                    <p class="text-3xl font-extrabold text-slate-800 mt-2">{{ $dashboardMetrics['pemeriksaan_bulan_ini'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                    <i class="fa-solid fa-stethoscope text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Status Kesehatan</p>
                    <p class="text-3xl font-extrabold mt-2 {{ $dashboardMetrics['status_kesehatan'] === 'Baik' ? 'text-emerald-600' : 'text-amber-500' }}">{{ $dashboardMetrics['status_kesehatan'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500">
                    <i class="fa-solid fa-heart text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">Jadwal Berikutnya</p>
                    <p class="text-base font-extrabold text-slate-800 mt-2 leading-snug">{{ $dashboardMetrics['jadwal_berikutnya'] }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-500">
                    <i class="fa-solid fa-calendar-days text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    @include('panel_kepalakeluarga.dashboard.partials.news-card')
</div>
