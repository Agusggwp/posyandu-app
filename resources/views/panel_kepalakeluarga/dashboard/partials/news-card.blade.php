<div class="bg-white rounded-lg shadow p-6 mb-8 mt-8">
    <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
        <i class="fas fa-newspaper text-blue-500"></i>
        Berita Terbaru
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @if(!empty($news['aktif']) && !empty($news['judul']))
            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition flex flex-col bg-white">
                <div class="w-full h-48 overflow-hidden bg-gray-200">
                    <img src="{{ $news['gambar'] ? asset($news['gambar']) : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=500&h=300&fit=crop' }}" alt="{{ $news['judul'] }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="flex items-start justify-between mb-2 gap-2">
                        <h4 class="font-bold text-gray-800 text-sm flex-grow">{{ $news['judul'] }}</h4>
                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded whitespace-nowrap flex-shrink-0">Info</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-3 flex-grow">{{ \Illuminate\Support\Str::limit(strip_tags($news['isi']), 140) }}</p>
                    <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-500">{{ now()->translatedFormat('d M Y') }}</p>
                        <button onclick="showNewsDetail(1)" class="text-xs font-medium flex items-center gap-1" style="color: #8e4682;" onmouseover="this.style.color='#7a3d6e'" onmouseout="this.style.color='#8e4682'">
                            Lihat Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="border border-gray-200 rounded-lg p-6 text-sm text-gray-500 bg-gray-50">
                Belum ada berita yang diaktifkan oleh admin.
            </div>
        @endif
    </div>
</div>
