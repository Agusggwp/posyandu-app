<div id="anggota-keluarga" class="section hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($memberCards as $member)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                <div class="h-24" style="background-color: white;"></div>
                <div class="px-6 pb-6">
                    <div class="flex justify-center -mt-12 mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($member['name']) }}&background=a6599e&color=fff" alt="Avatar" class="w-20 h-20 rounded-full border-4 border-white">
                    </div>
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">{{ $member['name'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $member['label'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">NIK: {{ $member['nik'] }}</p>
                    </div>
                    <div class="bg-gray-50 rounded p-3 mb-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Usia</span>
                            <span class="font-medium text-gray-800">{{ $member['age'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status</span>
                            <span class="font-medium {{ $member['status_color'] === 'green' ? 'text-green-600' : ($member['status_color'] === 'yellow' ? 'text-yellow-600' : 'text-gray-600') }}">{{ $member['status'] }}</span>
                        </div>
                    </div>
                    <button onclick="showMemberDetail('{{ $member['name'] }}')" class="w-full text-white py-2 rounded-lg font-medium transition text-sm" style="background-color: #8e4682;" onmouseover="this.style.backgroundColor='#7a3d6e'" onmouseout="this.style.backgroundColor='#8e4682'">Lihat Detail</button>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-6 text-sm text-gray-500">Belum ada data anggota keluarga.</div>
        @endforelse
    </div>
</div>
