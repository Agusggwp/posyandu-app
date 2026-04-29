@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-3 sm:px-4">
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pemeriksaan Ibu Hamil - Sistem 4 Tahap</h2>
        <p class="text-gray-600 mt-1">Pilih tahap pemeriksaan yang ingin Anda lakukan</p>
        <nav class="text-sm text-gray-600 mt-2">
            <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="hover:text-purple-600">Pemeriksaan Ibu Hamil</a>
            <span class="mx-2">/</span>
            <span>Tambah - Pilih Tahap</span>
        </nav>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
        <div class="flex gap-3">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-semibold text-blue-900 mb-1">Pemeriksaan Berjenjang</h3>
                <p class="text-blue-800 text-sm">
                    Sistem pemeriksaan terbagi menjadi 4 tahap. Data dari setiap tahap akan ditampilkan pada tahap berikutnya. 
                    Anda dapat memulai dari tahap mana saja dan dapat melanjutkan di kemudian hari.
                </p>
            </div>
        </div>
    </div>

    <!-- Stage Selection Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Stage 1 Card -->
        <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-purple-500 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-purple-500 text-white rounded-lg flex items-center justify-center font-bold text-lg">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Penimbangan & Pengukuran</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">
                    Data fisik ibu hamil termasuk berat badan, usia kehamilan, dan lingkar lengan.
                </p>
            </div>
            <div class="p-6 space-y-3">
                <div class="text-sm text-gray-600 space-y-1">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Usia Kehamilan (minggu)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Berat Badan (kg)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>LILA / Lingkar Lengan Atas (cm)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Status Gizi</span>
                    </div>
                </div>
                <div class="pt-3">
                    <a href="{{ route('pemeriksaan-ibu-hamil.stage', 1) }}" class="block w-full bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold py-2 px-4 rounded-lg text-center shadow-md hover:shadow-lg transition-all duration-200">
                        Mulai Tahap 1
                    </a>
                </div>
            </div>
        </div>

        <!-- Stage 2 Card -->
        <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-blue-500 text-white rounded-lg flex items-center justify-center font-bold text-lg">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Pemeriksaan</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">
                    Pemeriksaan klinis meliputi tekanan darah, denyut jantung, dan skrining TBC.
                </p>
            </div>
            <div class="p-6 space-y-3">
                <div class="text-sm text-gray-600 space-y-1">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Tekanan Darah (Sistol/Diastol)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Status Tekanan Darah</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Skrining TBC (4 gejala)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Hasil Skrining TBC</span>
                    </div>
                </div>
                <div class="pt-3">
                    <a href="{{ route('pemeriksaan-ibu-hamil.stage', 2) }}" class="block w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-center shadow-md hover:shadow-lg transition-all duration-200">
                        Mulai Tahap 2
                    </a>
                </div>
            </div>
        </div>

        <!-- Stage 3 Card -->
        <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-green-500 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-green-100 p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-green-500 text-white rounded-lg flex items-center justify-center font-bold text-lg">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Pelayanan Kesehatan</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">
                    Pelayanan kesehatan yang diberikan kepada ibu hamil.
                </p>
            </div>
            <div class="p-6 space-y-3">
                <div class="text-sm text-gray-600 space-y-1">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Tablet Tambah Darah</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>PMT Bumil (Pemakanan Tambahan)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Kelas Ibu Hamil</span>
                    </div>
                </div>
                <div class="pt-3">
                    <a href="{{ route('pemeriksaan-ibu-hamil.stage', 3) }}" class="block w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-2 px-4 rounded-lg text-center shadow-md hover:shadow-lg transition-all duration-200">
                        Mulai Tahap 3
                    </a>
                </div>
            </div>
        </div>

        <!-- Stage 4 Card -->
        <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-orange-500 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-orange-500 text-white rounded-lg flex items-center justify-center font-bold text-lg">
                        4
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Edukasi & Rujukan</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">
                    Edukasi, rujukan, dan ringkasan semua data pemeriksaan.
                </p>
            </div>
            <div class="p-6 space-y-3">
                <div class="text-sm text-gray-600 space-y-1">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Edukasi Kesehatan</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Rujukan (Pustu/Puskesmas/RS)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Ringkasan Semua Data</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Simpan Hasil Akhir</span>
                    </div>
                </div>
                <div class="pt-3">
                    <a href="{{ route('pemeriksaan-ibu-hamil.stage', 4) }}" class="block w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold py-2 px-4 rounded-lg text-center shadow-md hover:shadow-lg transition-all duration-200">
                        Mulai Tahap 4
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alternative: Continue Existing Exam -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-history text-purple-600 mr-2"></i>
            Lanjutkan Pemeriksaan Sebelumnya
        </h3>
        <p class="text-gray-600 mb-4">
            Jika Anda memiliki pemeriksaan yang belum selesai, Anda dapat melanjutkannya dengan memilih dari daftar di bawah.
        </p>
        <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
            Lihat Daftar Pemeriksaan
        </a>
    </div>

    <!-- Back Button -->
    <div class="mt-8">
        <a href="{{ route('pemeriksaan-ibu-hamil.index') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 font-medium">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Daftar Pemeriksaan
        </a>
    </div>
</div>
@endsection
