<div id="news-detail-modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-slate-100">
        <div class="relative">
            <img id="news-image" src="" alt="" class="w-full h-96 object-cover rounded-t-[22px]">
            <button onclick="closeNewsDetail()" class="absolute top-4 right-4 bg-white/90 backdrop-blur rounded-full p-2 hover:bg-white shadow-lg cursor-pointer">
                <i class="fa-solid fa-xmark text-slate-850 text-base"></i>
            </button>
            <span id="news-badge" class="absolute top-4 left-4 text-[10px] uppercase font-bold tracking-wider px-3 py-1 rounded-full text-white bg-indigo-600 shadow-sm">Kategori</span>
        </div>

        <div class="p-6">
            <h2 id="news-title" class="text-xl font-extrabold text-slate-800 mb-2">Judul Berita</h2>
            <p id="news-date" class="text-xs text-slate-400 font-bold mb-4">Tanggal</p>
            <div id="news-content" class="text-slate-600 leading-relaxed text-sm mb-6">Konten berita akan ditampilkan di sini</div>

            <div class="mb-6" id="photos-section" style="display:none;">
                <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-images text-indigo-500"></i>
                    Galeri Kegiatan
                </h3>
                <div id="news-photos" class="grid grid-cols-2 md:grid-cols-3 gap-3"></div>
            </div>

            <div id="event-details-section" style="display:none;">
                <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check text-indigo-500"></i>
                    Detail Acara
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50/50 p-4 rounded-2xl border border-slate-100">
                    <div id="event-time" style="display:none;"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Waktu</p><p class="font-bold text-slate-800 text-sm mt-1" id="event-time-text">-</p></div>
                    <div id="event-location" style="display:none;"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Lokasi</p><p class="font-bold text-slate-800 text-sm mt-1" id="event-location-text">-</p></div>
                    <div id="event-contact" style="display:none;" class="md:col-span-2"><p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Hubungi</p><p class="font-bold text-slate-800 text-sm mt-1" id="event-contact-text">-</p></div>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex justify-end gap-3 rounded-b-[22px]">
            <button onclick="closeNewsDetail()" class="px-6 py-2.5 bg-slate-200 hover:bg-slate-350 text-slate-700 rounded-2xl font-bold transition text-sm cursor-pointer">Tutup</button>
        </div>
    </div>
</div>
