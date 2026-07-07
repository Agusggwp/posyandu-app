<div id="riwayat-pemeriksaan" class="section hidden">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 mb-6">
        <h3 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-indigo-500"></i>
            Riwayat Pemeriksaan Keluarga
        </h3>

        <div class="mb-6">
            <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
                <button class="member-tab-btn px-4 py-2.5 rounded-2xl font-bold text-xs transition whitespace-nowrap bg-indigo-50 text-indigo-750 cursor-pointer" onclick="filterCheckupByMember('all', this)">Semua Anggota</button>
                @foreach($memberCards as $member)
                    <button class="member-tab-btn px-4 py-2.5 rounded-2xl font-bold text-xs transition whitespace-nowrap bg-slate-50 text-slate-650 hover:bg-slate-100 cursor-pointer" onclick="filterCheckupByMember('{{ $member['name'] }}', this)">{{ $member['name'] }}</button>
                @endforeach
            </div>
        </div>

        <div id="checkup-history-container" class="grid grid-cols-1 gap-8"></div>
    </div>
</div>
