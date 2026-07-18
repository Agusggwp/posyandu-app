<div id="member-detail-modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto border border-slate-100">
        <div class="text-white p-4 sm:p-6 flex justify-between items-center sticky top-0 z-10 bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-t-[22px]">
            <h2 id="modal-title" class="text-xl font-extrabold">Detail Anggota</h2>
            <button onclick="closeMemberDetail()" class="text-2xl hover:text-indigo-100 transition cursor-pointer">&times;</button>
        </div>
        <div class="p-4 sm:p-6 space-y-8">
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2"><i class="fa-solid fa-circle-user text-indigo-500"></i>Data Diri</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Nama Lengkap</p><p id="member-name" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">NIK</p><p id="member-nik" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Tanggal Lahir</p><p id="member-dob" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Usia</p><p id="member-age" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Jenis Kelamin</p><p id="member-gender" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Hubungan Keluarga</p><p id="member-relation" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2"><i class="fa-solid fa-stethoscope text-emerald-500"></i>Data Pemeriksaan Terakhir</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Tekanan Darah</p><p id="member-bp" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Berat Badan</p><p id="member-weight" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Tinggi Badan</p><p id="member-height" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Kolesterol</p><p id="member-cholesterol" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Gula Darah</p><p id="member-glucose" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                    <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Tanggal Pemeriksaan</p><p id="member-checkup-date" class="text-sm font-bold text-slate-800 mt-1">-</p></div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2"><i class="fa-solid fa-chart-line text-violet-500"></i>Grafik Perkembangan</h3>
                <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100"><canvas id="weight-chart" class="max-h-80"></canvas></div>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2"><i class="fa-solid fa-clock-rotate-left text-amber-500"></i>Riwayat Pemeriksaan</h3>
                <div class="space-y-3 md:hidden">
                    <template id="member-checkup-mobile-template">
                        <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Tanggal</p>
                                    <p class="member-checkup-date-mobile text-sm font-bold text-slate-800 mt-1"></p>
                                </div>
                                <span class="member-checkup-status-mobile rounded-full px-2.5 py-1 text-xs font-semibold"></span>
                            </div>
                            <div class="mt-3 grid grid-cols-1 gap-2 text-xs text-slate-600">
                                <p><span class="font-bold text-slate-400">Jenis:</span> Pemeriksaan Kesehatan</p>
                                <p><span class="font-bold text-slate-400">Catatan:</span> <span class="member-checkup-note-mobile leading-relaxed"></span></p>
                            </div>
                        </div>
                    </template>
                    <div id="member-checkup-mobile" class="space-y-3"></div>
                </div>

                <div class="hidden overflow-hidden rounded-2xl border border-slate-100 md:block">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-slate-400 text-xs font-bold uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-left text-slate-400 text-xs font-bold uppercase tracking-wider">Jenis Pemeriksaan</th>
                                <th class="px-4 py-3 text-left text-slate-400 text-xs font-bold uppercase tracking-wider">Hasil</th>
                                <th class="px-4 py-3 text-left text-slate-400 text-xs font-bold uppercase tracking-wider">Catatan</th>
                            </tr>
                        </thead>
                        <tbody id="member-checkup-table" class="divide-y divide-slate-100"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:py-4 border-t border-slate-100 flex justify-end gap-3 rounded-b-[22px]">
            <button onclick="closeMemberDetail()" class="px-6 py-2.5 bg-slate-200 hover:bg-slate-350 text-slate-700 rounded-2xl font-bold transition text-sm cursor-pointer">Tutup</button>
        </div>
    </div>
</div>
