@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4">
    <div class="mb-6 sm:mb-8">
        <h2 class="text-2xl sm:text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Admin Dashboard</h2>
        <p class="text-slate-600 mt-2">Panel Kontrol Administrasi Sistem</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 p-4 sm:p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-2">Total Users</p>
                    <h3 class="text-3xl sm:text-4xl font-bold text-indigo-600">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-emerald-100 p-4 sm:p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-2">Total Keluarga</p>
                    <h3 class="text-3xl sm:text-4xl font-bold text-emerald-600">{{ $stats['total_keluarga'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-violet-100 p-4 sm:p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-2">Total Balita</p>
                    <h3 class="text-3xl sm:text-4xl font-bold text-violet-600">{{ $stats['total_balita'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-violet-400 to-purple-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-rose-100 p-4 sm:p-6 hover:shadow-xl transition-all duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-500 text-xs font-semibold uppercase tracking-wide mb-2">Total Pemeriksaan</p>
                    <h3 class="text-3xl sm:text-4xl font-bold text-rose-600">{{ $stats['total_pemeriksaan_balita'] + $stats['total_pemeriksaan_ibu_hamil'] + $stats['total_pemeriksaan_lansia'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-rose-400 to-pink-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users & Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Users -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6">
            <div class="flex justify-between items-center mb-4 sm:mb-6">
                <h3 class="text-xl font-bold text-gray-800">User Terbaru</h3>
                <a href="{{ route('users.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat Semua →</a>
            </div>
            
            <div class="space-y-4">
                @foreach($recentUsers as $user)
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                    <div class="flex items-center space-x-3 min-w-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                        {{ $user->role_name ?? 'n/a' }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6">
            <div class="flex justify-between items-center mb-4 sm:mb-6">
                <h3 class="text-xl font-bold text-gray-800">Recent Activities</h3>
                <a href="{{ route('admin.activity-logs') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">View all →</a>
            </div>
            
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                <div class="flex items-start space-x-3 pb-3 border-b border-gray-100 last:border-0">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                            @php
                                $icon = match($activity->action ?? '') {
                                    'created' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />',
                                    'updated' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />',
                                    'deleted' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />',
                                    default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
                                };
                            @endphp
                            <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $icon !!}
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900">
                            <span class="font-semibold">{{ $activity->user->name ?? 'System' }}</span>
                            <span class="text-gray-600">{{ $activity->description }}</span>
                        </p>
                        <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No activities yet</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Activity Chart & Role Distribution -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Activity Chart (Last 7 Days) -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Activity Trend (Last 7 Days)</h3>
            
            <div class="space-y-3">
                @foreach($dailyStats as $stat)
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-600">{{ $stat['date'] }}</span>
                        <span class="text-sm font-bold text-indigo-600">{{ $stat['users'] }} activities</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        @php
                            $maxActivities = collect($dailyStats)->max('users') ?: 1;
                            $percentage = ($stat['users'] / $maxActivities) * 100;
                        @endphp
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full transition-all duration-500" 
                             style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Distribusi Role</h3>
            
            <div class="space-y-4">
                @foreach($usersByRole as $roleGroup)
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-700">{{ ucfirst($roleGroup->role->name) }}</span>
                        <span class="font-bold text-indigo-600">{{ $roleGroup->total }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full" 
                             style="width: {{ ($roleGroup->total / $stats['total_users']) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
  <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 sm:p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h3>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
            <a href="{{ route('users.create') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl hover:shadow-md transition-all duration-200 border border-indigo-100">
                <svg class="w-8 h-8 text-indigo-600 mb-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                </svg>
                <span class="text-sm font-semibold text-indigo-700">Tambah User</span>
            </a>

            <a href="{{ route('keluarga.create') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl hover:shadow-md transition-all duration-200 border border-emerald-100">
                <svg class="w-8 h-8 text-emerald-600 mb-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                <span class="text-sm font-semibold text-emerald-700">Tambah Keluarga</span>
            </a>

            <a href="{{ route('laporan.index') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-violet-50 to-purple-50 rounded-xl hover:shadow-md transition-all duration-200 border border-violet-100">
                <svg class="w-8 h-8 text-violet-600 mb-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
                <span class="text-sm font-semibold text-violet-700">Laporan</span>
            </a>

            <a href="{{ route('admin.settings') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl hover:shadow-md transition-all duration-200 border border-slate-100">
                <svg class="w-8 h-8 text-slate-600 mb-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-semibold text-slate-700">Pengaturan</span>
            </a>
        </div>
    </div>
</div>
@endsection
