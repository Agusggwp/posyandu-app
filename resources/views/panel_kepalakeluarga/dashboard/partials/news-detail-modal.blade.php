<div id="news-detail-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
        <div class="relative">
            <img id="news-image" src="" alt="" class="w-full h-96 object-cover">
            <button onclick="closeNewsDetail()" class="absolute top-4 right-4 bg-white rounded-full p-2 hover:bg-gray-100 shadow-lg">
                <i class="fas fa-times text-gray-800 text-xl"></i>
            </button>
            <span id="news-badge" class="absolute top-4 left-4 text-xs px-3 py-1 rounded text-white bg-blue-500">Kategori</span>
        </div>

        <div class="p-6">
            <h2 id="news-title" class="text-2xl font-bold text-gray-800 mb-2">Judul Berita</h2>
            <p id="news-date" class="text-sm text-gray-500 mb-4">Tanggal</p>
            <div id="news-content" class="text-gray-700 leading-relaxed mb-6">Konten berita akan ditampilkan di sini</div>

            <div class="mb-6" id="photos-section" style="display:none;">
                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-images text-blue-500"></i>
                    Galeri Kegiatan
                </h3>
                <div id="news-photos" class="grid grid-cols-2 md:grid-cols-3 gap-3"></div>
            </div>

            <div id="event-details-section" style="display:none;">
                <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-purple-500"></i>
                    Detail Acara
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded">
                    <div id="event-time" style="display:none;"><p class="text-sm text-gray-600">Waktu</p><p class="font-semibold text-gray-800" id="event-time-text">-</p></div>
                    <div id="event-location" style="display:none;"><p class="text-sm text-gray-600">Lokasi</p><p class="font-semibold text-gray-800" id="event-location-text">-</p></div>
                    <div id="event-contact" style="display:none;" class="md:col-span-2"><p class="text-sm text-gray-600">Hubungi</p><p class="font-semibold text-gray-800" id="event-contact-text">-</p></div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end gap-3">
            <button onclick="closeNewsDetail()" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-medium transition">Tutup</button>
        </div>
    </div>
</div>
