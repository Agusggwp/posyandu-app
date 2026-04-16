@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4">
    <!-- Header -->
    <div class="mb-4 sm:mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Pengaturan Sistem</h2>
        <p class="text-gray-600 mt-1">Konfigurasi dan pengaturan aplikasi Posyandu</p>
    </div>

    <!-- Success Message -->
    @if (session('success'))
    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-green-800">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Settings Form -->
    <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-8 border border-indigo-100">
        <form action="{{ route('admin.updateSettings') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Informasi Pusat Kesehatan -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-indigo-200">
                    <svg class="w-5 h-5 inline-block mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    Informasi Pusat Kesehatan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Center Email -->
                    <div>
                        <label for="center_email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <input 
                            type="email"
                            id="center_email"
                            name="center_email"
                            value="{{ old('center_email', $settings['center_email']) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('center_email') border-red-500 @enderror"
                            placeholder="Contoh: posyandu@example.com"
                        >
                        @error('center_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Opening Hours -->
                    <div>
                        <label for="center_hours_open" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jam Buka
                        </label>
                        <input 
                            type="time"
                            id="center_hours_open"
                            name="center_hours_open"
                            value="{{ old('center_hours_open', $settings['center_hours_open']) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('center_hours_open') border-red-500 @enderror"
                        >
                        @error('center_hours_open')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Closing Hours -->
                    <div>
                        <label for="center_hours_close" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jam Tutup
                        </label>
                        <input 
                            type="time"
                            id="center_hours_close"
                            name="center_hours_close"
                            value="{{ old('center_hours_close', $settings['center_hours_close']) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('center_hours_close') border-red-500 @enderror"
                        >
                        @error('center_hours_close')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Center Address -->
                <div class="mt-4">
                    <label for="center_address" class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat
                    </label>
                    <textarea 
                        id="center_address"
                        name="center_address"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('center_address') border-red-500 @enderror"
                        placeholder="Alamat lengkap pusat kesehatan"
                    >{{ old('center_address', $settings['center_address']) }}</textarea>
                    @error('center_address')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col-reverse sm:flex-row gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.dashboard') }}" class="text-center px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-gray-700 font-semibold">
                    Batal
                </a>
                <button 
                    type="submit"
                    class="w-full sm:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200"
                >
                    <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M19.414 4.414l-17.828 17.828a2 2 0 01-2.828 0l-2.83-2.829a2 2 0 010-2.828L13.758.757a2 2 0 012.828 0l2.828 2.829a2 2 0 010 2.828z" clip-rule="evenodd"/>
                    </svg>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <!-- Information Box -->
    <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-blue-800">Catatan</p>
                <p class="text-sm text-blue-700 mt-1">Pengaturan ini akan diterapkan di seluruh aplikasi. Pastikan semua data sudah benar sebelum menyimpan.</p>
            </div>
        </div>
    </div>
</div>
@endsection
