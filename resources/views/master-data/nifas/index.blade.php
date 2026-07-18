@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-1 sm:px-0">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
        <div>
            <h2 class="text-2xl sm:text-4xl font-bold bg-gradient-to-r from-rose-700 to-pink-800 bg-clip-text text-transparent">Data Nifas</h2>
            <p class="text-slate-600 mt-2">Manajemen data nifas (identitas)</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <a href="{{ route('nifas.export-excel') }}" class="w-full sm:w-auto text-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition-all duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Excel
            </a>
            <button onclick="toggleImportModal(true)" class="w-full sm:w-auto text-center bg-rose-700 hover:bg-rose-800 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition-all duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Import Excel
            </button>
            <a href="{{ route('nifas.create') }}" class="w-full sm:w-auto text-center bg-gradient-to-r from-rose-700 to-pink-800 hover:from-rose-800 hover:to-pink-900 text-white font-semibold py-2 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                + Tambah Nifas
            </a>
        </div>
    </div>

    <!-- Search Box -->
    <div class="mb-6">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" id="searchInput" placeholder="Cari berdasarkan nama, NIK, atau keluarga..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-transparent">
            <div id="searchResults" class="hidden absolute top-full left-0 right-0 mt-2 bg-white border border-gray-300 rounded-lg shadow-lg z-10 max-h-96 overflow-y-auto"></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-rose-700 to-pink-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Ibu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Bersalin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Keluarga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($nifases as $index => $nifas)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $nifases->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $nifas->nama_ibu }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $nifas->nik ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ optional($nifas->tanggal_bersalin)->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $nifas->keluarga->nama_kepala_keluarga ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('nifas.show', $nifas->id) }}" class="inline-flex px-2 py-1 rounded bg-emerald-100 text-emerald-800 hover:bg-emerald-200">Detail</a>
                                <a href="{{ route('nifas.edit', $nifas->id) }}" class="inline-flex px-2 py-1 rounded bg-amber-100 text-amber-800 hover:bg-amber-200">Edit</a>
                                <form action="{{ route('nifas.destroy', $nifas->id) }}" method="POST" style="display: contents" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex px-2 py-1 rounded bg-rose-100 text-rose-800 hover:bg-rose-200">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data nifas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="md:hidden p-4 space-y-4 bg-gray-50">
            @forelse($nifases as $index => $nifas)
                <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <div class="flex justify-between items-start gap-3">
                        <div>
                            <p class="text-xs text-gray-500">No. {{ $nifases->firstItem() + $index }}</p>
                            <h3 class="text-base font-semibold text-gray-900 break-words">{{ $nifas->nama_ibu }}</h3>
                            <p class="text-sm text-gray-600 mt-1 break-words">NIK: {{ $nifas->nik ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1 text-sm text-gray-700">
                        <p><span class="font-medium">Tanggal Bersalin:</span> {{ optional($nifas->tanggal_bersalin)->format('d/m/Y') ?? '-' }}</p>
                        <p class="break-words"><span class="font-medium">Keluarga:</span> {{ $nifas->keluarga->nama_kepala_keluarga ?? '-' }}</p>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <a href="{{ route('nifas.show', $nifas->id) }}" class="inline-flex items-center justify-center px-3 py-2 rounded bg-emerald-100 text-emerald-800 hover:bg-emerald-200 text-xs font-semibold">Detail</a>
                        <a href="{{ route('nifas.edit', $nifas->id) }}" class="inline-flex items-center justify-center px-3 py-2 rounded bg-amber-100 text-amber-800 hover:bg-amber-200 text-xs font-semibold">Edit</a>
                        <form action="{{ route('nifas.destroy', $nifas->id) }}" method="POST" class="col-span-2" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 rounded bg-rose-100 text-rose-800 hover:bg-rose-200 text-xs font-semibold">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-xl p-6 text-center text-gray-500">Tidak ada data nifas</div>
            @endforelse
        </div>
        <div class="px-6 py-4 bg-gray-50">{{ $nifases->links() }}</div>
    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    if (!searchInput || !searchResults) {
        return;
    }

    searchInput.addEventListener('input', async function () {
        const query = this.value.trim();

        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }

        try {
            const response = await fetch(`{{ route('api.search.nifas') }}?q=${encodeURIComponent(query)}`);
            const results = await response.json();

            if (results.length === 0) {
                searchResults.innerHTML = '<div class="px-4 py-3 text-gray-500 text-center">Tidak ada hasil pencarian</div>';
                searchResults.classList.remove('hidden');
                return;
            }

            searchResults.innerHTML = results.map(item => `
                <a href="{{ url('nifas') }}/${item.id}" class="block px-4 py-2 hover:bg-gray-100 border-b border-gray-200 last:border-b-0 cursor-pointer">
                    <div class="font-semibold text-gray-900">${item.nama}</div>
                    <div class="text-sm text-gray-500">NIK: ${item.nik || '-'} | ${item.keluarga}</div>
                </a>
            `).join('');

            searchResults.classList.remove('hidden');
        } catch (error) {
            console.error('Search error:', error);
        }
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#searchInput') && !e.target.closest('#searchResults')) {
            searchResults.classList.add('hidden');
        }
    });
});
</script>

<!-- Import Excel Modal -->
<div id="importModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleImportModal(false)"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('nifas.import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content-area bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="import-error-msg hidden bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 mb-4 text-sm rounded-r-lg"></div>

                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-semibold text-gray-900" id="modal-title">
                                Import Data Nifas
                            </h3>
                            <div class="mt-2 text-sm text-gray-500">
                                <p class="mb-4">Silakan unggah file Excel/CSV data nifas. Gunakan tombol di bawah ini untuk mengunduh template format data yang sesuai.</p>
                                <a href="{{ route('nifas.import-template') }}" class="inline-flex items-center gap-1.5 text-rose-700 hover:text-rose-900 font-semibold mb-6">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh Template Format CSV
                                </a>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File (.csv)</label>
                                    <input type="file" name="file" accept=".csv" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress & Loading Indicator -->
                <div class="progress-container hidden bg-white px-4 pt-5 pb-8 sm:p-6 text-center">
                    <div class="flex justify-center mb-6">
                        <div class="relative w-16 h-16">
                            <div class="absolute inset-0 rounded-full border-4 border-rose-100"></div>
                            <div class="absolute inset-0 rounded-full border-4 border-t-rose-700 border-r-rose-700 animate-spin"></div>
                        </div>
                    </div>
                    <h4 class="text-base font-semibold text-gray-900 mb-2 progress-text">Mengunggah file...</h4>
                    <p class="text-xs text-gray-500 mb-6">Harap tunggu, jangan menutup browser atau memuat ulang halaman.</p>
                    
                    <div class="w-full bg-gray-100 rounded-full h-3 relative overflow-hidden mb-2">
                        <div class="progress-bar-fill bg-gradient-to-r from-rose-500 to-rose-700 h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <div class="text-sm font-bold text-rose-700 progress-percent">0%</div>
                </div>

                <div class="modal-footer bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <button type="submit" class="submit-btn w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-rose-700 text-base font-semibold text-white hover:bg-rose-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Mulai Import
                    </button>
                    <button type="button" onclick="toggleImportModal(false)" class="cancel-btn mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleImportModal(show) {
        const modal = document.getElementById('importModal');
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#importModal form');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                const formContent = form.querySelector('.modal-content-area');
                const progressContainer = form.querySelector('.progress-container');
                const footer = form.querySelector('.modal-footer');
                const errorMsg = form.querySelector('.import-error-msg');
                
                const progressBar = progressContainer.querySelector('.progress-bar-fill');
                const progressText = progressContainer.querySelector('.progress-text');
                const progressPercent = progressContainer.querySelector('.progress-percent');
                
                errorMsg.classList.add('hidden');
                errorMsg.textContent = '';
                
                formContent.classList.add('hidden');
                progressContainer.classList.remove('hidden');
                footer.classList.add('hidden');
                
                const formData = new FormData(form);
                const xhr = new XMLHttpRequest();
                
                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        progressBar.style.width = percent + '%';
                        progressPercent.textContent = percent + '%';
                        if (percent === 100) {
                            progressText.textContent = 'Memproses data ke database...';
                        } else {
                            progressText.textContent = 'Mengunggah file...';
                        }
                    }
                });
                
                xhr.onload = function () {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        window.location.reload();
                    } else {
                        let error = 'Terjadi kesalahan saat memproses data.';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                error = response.message;
                            }
                        } catch (err) {}
                        
                        errorMsg.textContent = error;
                        errorMsg.classList.remove('hidden');
                        
                        formContent.classList.remove('hidden');
                        progressContainer.classList.add('hidden');
                        footer.classList.remove('hidden');
                    }
                };
                
                xhr.onerror = function () {
                    errorMsg.textContent = 'Koneksi error, gagal mengunggah file.';
                    errorMsg.classList.remove('hidden');
                    
                    formContent.classList.remove('hidden');
                    progressContainer.classList.add('hidden');
                    footer.classList.remove('hidden');
                };
                
                xhr.send(formData);
            });
        }
    });
</script>
