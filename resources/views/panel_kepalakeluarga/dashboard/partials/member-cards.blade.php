<div id="anggota-keluarga" class="section hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($memberCards as $member)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition overflow-hidden">
                <div class="h-20 bg-gradient-to-r from-indigo-500/10 to-violet-500/10"></div>
                <div class="px-6 pb-6">
                    <div class="flex justify-center -mt-10 mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($member['name']) }}&background=6366f1&color=fff&bold=true" alt="Avatar" class="w-20 h-20 rounded-2xl border-4 border-white shadow-sm object-cover">
                    </div>
                    <div class="text-center mb-4">
                        <h3 class="text-base font-extrabold text-slate-800">{{ $member['name'] }}</h3>
                        <span class="inline-block mt-1 text-xs px-2.5 py-1 rounded-full font-semibold bg-indigo-50 text-indigo-700">{{ $member['label'] }}</span>
                        <p class="text-xs text-slate-400 mt-2 font-mono">NIK: {{ $member['nik'] }}</p>
                    </div>
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-4 mb-4 space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500 font-semibold">Usia</span>
                            <span class="font-bold text-slate-800">{{ $member['age'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-semibold">Status</span>
                            <span class="font-bold {{ $member['status_color'] === 'green' ? 'text-emerald-600' : ($member['status_color'] === 'yellow' ? 'text-amber-600' : 'text-slate-600') }}">{{ $member['status'] }}</span>
                        </div>
                    </div>
                    <button onclick="showMemberDetail('{{ $member['name'] }}')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-2xl font-bold transition text-xs shadow-md shadow-indigo-100 cursor-pointer">Lihat Detail</button>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-slate-50/50 border border-dashed border-slate-200 rounded-3xl p-8 text-center text-sm text-slate-500">Belum ada data anggota keluarga.</div>
        @endforelse
    </div>
</div>
