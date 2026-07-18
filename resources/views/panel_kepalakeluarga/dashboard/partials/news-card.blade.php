<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-4 sm:p-6 mb-8 mt-8">
    <h3 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-2">
        <i class="fa-solid fa-newspaper text-indigo-500"></i>
        Berita Terbaru
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @if(!empty($news['aktif']) && !empty($news['judul']))
            <div class="border border-slate-100 rounded-3xl overflow-hidden hover:shadow-md transition flex flex-col bg-white">
                <div class="w-full h-48 overflow-hidden bg-slate-100">
                    <img src="{{ $news['gambar'] ? asset($news['gambar']) : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=500&h=300&fit=crop' }}" alt="{{ $news['judul'] }}" class="w-full h-full object-cover hover:scale-102 transition duration-300">
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <div class="flex items-start justify-between mb-2 gap-2">
                        <h4 class="font-extrabold text-slate-800 text-sm flex-grow">{{ $news['judul'] }}</h4>
                        <span class="text-xs bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-full font-semibold whitespace-nowrap flex-shrink-0">Info</span>
                    </div>
                    <p class="text-xs text-slate-500 mb-3 flex-grow leading-relaxed">{{ \Illuminate\Support\Str::limit(strip_tags($news['isi']), 140) }}</p>
                    <div class="flex items-center justify-between mt-auto pt-3 border-t border-slate-100">
                        <p class="text-xs text-slate-400 font-bold">{{ now()->translatedFormat('d M Y') }}</p>
                        <button onclick="showNewsDetail(1)" class="text-xs font-bold flex items-center gap-1 text-indigo-600 hover:text-indigo-800 transition cursor-pointer">
                            Lihat Selengkapnya
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="col-span-full border border-dashed border-slate-200 rounded-3xl p-8 text-center text-sm text-slate-500 bg-slate-50/50">
                Belum ada berita yang diaktifkan oleh admin.
            </div>
        @endif
    </div>
</div>
