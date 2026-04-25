<div id="dashboard" class="section">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Anggota</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $dashboardMetrics['total_anggota'] }}</p>
                </div>
                <i class="fas fa-users text-blue-500 text-3xl opacity-20"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pemeriksaan Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $dashboardMetrics['pemeriksaan_bulan_ini'] }}</p>
                </div>
                <i class="fas fa-stethoscope text-green-500 text-3xl opacity-20"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Status Kesehatan</p>
                    <p class="text-3xl font-bold {{ $dashboardMetrics['status_kesehatan'] === 'Baik' ? 'text-green-600' : 'text-yellow-600' }}">{{ $dashboardMetrics['status_kesehatan'] }}</p>
                </div>
                <i class="fas fa-heart text-red-500 text-3xl opacity-20"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Jadwal Berikutnya</p>
                    <p class="text-lg font-bold text-gray-800">{{ $dashboardMetrics['jadwal_berikutnya'] }}</p>
                </div>
                <i class="fas fa-calendar text-purple-500 text-3xl opacity-20"></i>
            </div>
        </div>
    </div>

    @include('panel_kepalakeluarga.dashboard.partials.news-card')
</div>
