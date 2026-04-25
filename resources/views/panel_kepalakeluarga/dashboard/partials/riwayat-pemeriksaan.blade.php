<div id="riwayat-pemeriksaan" class="section hidden">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-history" style="color: #8e4682;"></i>
            Riwayat Pemeriksaan Keluarga
        </h3>

        <div class="mb-6">
            <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
                <button class="member-tab-btn px-4 py-2 rounded-lg font-medium text-sm transition whitespace-nowrap bg-blue-100 text-blue-700" style="background-color: #e8f0fe; color: #1a73e8;" onclick="filterCheckupByMember('all', this)">Semua Anggota</button>
                @foreach($memberCards as $member)
                    <button class="member-tab-btn px-4 py-2 rounded-lg font-medium text-sm transition whitespace-nowrap bg-gray-100 text-gray-700 hover:bg-gray-200" onclick="filterCheckupByMember('{{ $member['name'] }}', this)">{{ $member['name'] }}</button>
                @endforeach
            </div>
        </div>

        <div id="checkup-history-container" class="grid grid-cols-1 gap-8"></div>
    </div>
</div>
