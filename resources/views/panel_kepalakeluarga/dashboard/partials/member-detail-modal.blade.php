<div id="member-detail-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-screen overflow-y-auto">
        <div class="text-white p-6 flex justify-between items-center sticky top-0" style="background: linear-gradient(to right, #8e4682, #a6599e);">
            <h2 id="modal-title" class="text-2xl font-bold">Detail Anggota</h2>
            <button onclick="closeMemberDetail()" class="text-2xl hover:text-gray-200">×</button>
        </div>
        <div class="p-6">
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-user-circle text-blue-500"></i>Data Diri</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">Nama Lengkap</p><p id="member-name" class="text-lg font-semibold text-gray-800">-</p></div>
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">NIK</p><p id="member-nik" class="text-lg font-semibold text-gray-800">-</p></div>
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">Tanggal Lahir</p><p id="member-dob" class="text-lg font-semibold text-gray-800">-</p></div>
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">Usia</p><p id="member-age" class="text-lg font-semibold text-gray-800">-</p></div>
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">Jenis Kelamin</p><p id="member-gender" class="text-lg font-semibold text-gray-800">-</p></div>
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">Hubungan Keluarga</p><p id="member-relation" class="text-lg font-semibold text-gray-800">-</p></div>
                </div>
            </div>
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-stethoscope text-green-500"></i>Data Pemeriksaan Terakhir</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">Tekanan Darah</p><p id="member-bp" class="text-lg font-semibold text-gray-800">-</p></div>
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">Berat Badan</p><p id="member-weight" class="text-lg font-semibold text-gray-800">-</p></div>
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">Tinggi Badan</p><p id="member-height" class="text-lg font-semibold text-gray-800">-</p></div>
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">Kolesterol</p><p id="member-cholesterol" class="text-lg font-semibold text-gray-800">-</p></div>
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">Gula Darah</p><p id="member-glucose" class="text-lg font-semibold text-gray-800">-</p></div>
                    <div class="bg-gray-50 p-4 rounded"><p class="text-sm text-gray-600">Tanggal Pemeriksaan</p><p id="member-checkup-date" class="text-lg font-semibold text-gray-800">-</p></div>
                </div>
            </div>
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-chart-line text-purple-500"></i>Grafik Perkembangan</h3>
                <div class="bg-gray-50 p-6 rounded"><canvas id="weight-chart" class="max-h-80"></canvas></div>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-history text-orange-500"></i>Riwayat Pemeriksaan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100"><tr><th class="px-4 py-2 text-left text-gray-700 font-semibold">Tanggal</th><th class="px-4 py-2 text-left text-gray-700 font-semibold">Jenis Pemeriksaan</th><th class="px-4 py-2 text-left text-gray-700 font-semibold">Hasil</th><th class="px-4 py-2 text-left text-gray-700 font-semibold">Catatan</th></tr></thead>
                        <tbody id="member-checkup-table" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end gap-3"><button onclick="closeMemberDetail()" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-medium transition">Tutup</button></div>
    </div>
</div>
