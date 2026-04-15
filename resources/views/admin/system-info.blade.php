@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">System Information</h1>
            <p class="mt-2 text-sm text-gray-600">View system configuration and technical details</p>
        </div>

        <!-- System Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- PHP Information -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-bold text-gray-900">PHP Information</h2>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start justify-between gap-3 py-2 border-b border-gray-100">
                        <span class="text-gray-600">PHP Version</span>
                        <span class="font-semibold text-gray-900 text-right break-all">{{ $info['php_version'] }}</span>
                    </div>
                    <div class="flex items-start justify-between gap-3 py-2 border-b border-gray-100">
                        <span class="text-gray-600">Memory Limit</span>
                        <span class="font-semibold text-gray-900 text-right break-all">{{ ini_get('memory_limit') }}</span>
                    </div>
                    <div class="flex items-start justify-between gap-3 py-2">
                        <span class="text-gray-600">Max Upload Size</span>
                        <span class="font-semibold text-gray-900 text-right break-all">{{ ini_get('upload_max_filesize') }}</span>
                    </div>
                </div>
            </div>

            <!-- Laravel Information -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-bold text-gray-900">Laravel Information</h2>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Laravel Version</span>
                        <span class="font-semibold text-gray-900">{{ $info['laravel_version'] }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Environment</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $info['environment'] === 'production' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($info['environment']) }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Debug Mode</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $info['debug_mode'] === 'Enabled' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ $info['debug_mode'] }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Database Information -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-bold text-gray-900">Database Information</h2>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start justify-between gap-3 py-2 border-b border-gray-100">
                        <span class="text-gray-600">Database Type</span>
                        <span class="font-semibold text-gray-900 text-right break-all">{{ ucfirst($info['database']) }}</span>
                    </div>
                    <div class="flex items-start justify-between gap-3 py-2 border-b border-gray-100">
                        <span class="text-gray-600">Database Name</span>
                        <span class="font-semibold text-gray-900 text-right break-all">{{ config('database.connections.mysql.database') }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Connection</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            Connected
                        </span>
                    </div>
                </div>
            </div>

            <!-- Application Information -->
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-bold text-gray-900">Application Settings</h2>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start justify-between gap-3 py-2 border-b border-gray-100">
                        <span class="text-gray-600">Timezone</span>
                        <span class="font-semibold text-gray-900 text-right break-all">{{ $info['timezone'] }}</span>
                    </div>
                    <div class="flex items-start justify-between gap-3 py-2 border-b border-gray-100">
                        <span class="text-gray-600">Locale</span>
                        <span class="font-semibold text-gray-900 text-right break-all">{{ $info['locale'] }}</span>
                    </div>
                    <div class="flex items-start justify-between gap-3 py-2">
                        <span class="text-gray-600">App URL</span>
                        <span class="font-semibold text-gray-900 truncate ml-2">{{ config('app.url') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Server Information -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mt-6">
            <div class="flex items-center mb-4">
                <div class="p-3 bg-indigo-100 rounded-lg">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                </div>
                <h2 class="ml-3 text-xl font-bold text-gray-900">Server Information</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600">Server Software</span>
                    <span class="font-semibold text-gray-900 text-right">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600">Server IP</span>
                    <span class="font-semibold text-gray-900">{{ $_SERVER['SERVER_ADDR'] ?? 'Unknown' }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600">Server Port</span>
                    <span class="font-semibold text-gray-900">{{ $_SERVER['SERVER_PORT'] ?? 'Unknown' }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600">Document Root</span>
                    <span class="font-semibold text-gray-900 text-right truncate ml-2">{{ $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
