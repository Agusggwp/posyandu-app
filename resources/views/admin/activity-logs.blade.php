@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Activity Logs</h1>
            <p class="mt-2 text-sm text-gray-600">Track all user activities in the system</p>
        </div>

        <!-- Filter Form -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
            <form method="GET" action="{{ route('admin.activity-logs') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- User Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">User</label>
                    <select name="user_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                    <select name="action" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">All Actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $action)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 md:flex-none px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('admin.activity-logs') }}" class="flex-1 md:flex-none text-center px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Activity Logs Table -->
        <div class="hidden md:block bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-medium">
                                            {{ substr($log->user->name ?? 'S', 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $log->user->name ?? 'System' }}</div>
                                            <div class="text-sm text-gray-500">{{ $log->user->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $colors = [
                                            'created' => 'bg-green-100 text-green-800',
                                            'updated' => 'bg-blue-100 text-blue-800',
                                            'deleted' => 'bg-red-100 text-red-800',
                                            'viewed' => 'bg-cyan-100 text-cyan-800',
                                            'login' => 'bg-purple-100 text-purple-800',
                                            'logout' => 'bg-gray-100 text-gray-800',
                                            'reset_requested' => 'bg-amber-100 text-amber-800',
                                            'reset_completed' => 'bg-emerald-100 text-emerald-800',
                                            'reset_failed' => 'bg-rose-100 text-rose-800',
                                        ];
                                        $color = $colors[$log->action] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                        {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $log->description }}</div>
                                    @if(!empty($log->properties['target_label']) || !empty($log->properties['changed_fields']))
                                        <div class="mt-1 text-xs text-gray-500">
                                            @if(!empty($log->properties['target_label']))
                                                <span>Target: {{ $log->properties['target_label'] }}</span>
                                            @endif
                                            @if(!empty($log->properties['changed_fields']) && is_array($log->properties['changed_fields']))
                                                <span class="{{ !empty($log->properties['target_label']) ? 'ml-2' : '' }}">Perubahan: {{ implode(', ', $log->properties['changed_fields']) }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    @if(!empty($log->properties['changes']) && is_array($log->properties['changes']))
                                        <div class="mt-2 space-y-1 text-xs text-gray-600">
                                            @foreach($log->properties['changes'] as $field => $change)
                                                <p>
                                                    <span class="font-semibold text-gray-700">{{ $field }}</span>:
                                                    <span class="text-red-600">{{ $change['before'] ?? '-' }}</span>
                                                    <span class="mx-1">-></span>
                                                    <span class="text-green-600">{{ $change['after'] ?? '-' }}</span>
                                                </p>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $log->model ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $log->ip_address ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $log->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-4">No activity logs found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($logs->hasPages())
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>

        <div class="md:hidden mt-4 space-y-3">
            @forelse($logs as $log)
                @php
                    $colors = [
                        'created' => 'bg-green-100 text-green-800',
                        'updated' => 'bg-blue-100 text-blue-800',
                        'deleted' => 'bg-red-100 text-red-800',
                        'viewed' => 'bg-cyan-100 text-cyan-800',
                        'login' => 'bg-purple-100 text-purple-800',
                        'logout' => 'bg-gray-100 text-gray-800',
                        'reset_requested' => 'bg-amber-100 text-amber-800',
                        'reset_completed' => 'bg-emerald-100 text-emerald-800',
                        'reset_failed' => 'bg-rose-100 text-rose-800',
                    ];
                    $color = $colors[$log->action] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $log->user->name ?? 'System' }}</p>
                            <p class="text-xs text-gray-500">{{ $log->user->email ?? '-' }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</span>
                    </div>
                    <p class="mt-2 text-sm text-gray-700">{{ $log->description }}</p>
                    @if(!empty($log->properties['target_label']) || !empty($log->properties['changed_fields']))
                        <div class="mt-2 text-xs text-gray-500 space-y-1">
                            @if(!empty($log->properties['target_label']))
                                <p>Target: {{ $log->properties['target_label'] }}</p>
                            @endif
                            @if(!empty($log->properties['changed_fields']) && is_array($log->properties['changed_fields']))
                                <p>Perubahan: {{ implode(', ', $log->properties['changed_fields']) }}</p>
                            @endif
                        </div>
                    @endif
                    @if(!empty($log->properties['changes']) && is_array($log->properties['changes']))
                        <div class="mt-2 space-y-1 text-xs text-gray-600">
                            @foreach($log->properties['changes'] as $field => $change)
                                <p>
                                    <span class="font-semibold text-gray-700">{{ $field }}</span>:
                                    <span class="text-red-600">{{ $change['before'] ?? '-' }}</span>
                                    <span class="mx-1">-></span>
                                    <span class="text-green-600">{{ $change['after'] ?? '-' }}</span>
                                </p>
                            @endforeach
                        </div>
                    @endif
                    <div class="mt-3 text-xs text-gray-500 space-y-1">
                        <p>Model: {{ $log->model ?? '-' }}</p>
                        <p>IP: {{ $log->ip_address ?? '-' }}</p>
                        <p>{{ $log->created_at->format('M d, Y H:i:s') }}</p>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center text-gray-500">No activity logs found</div>
            @endforelse

            @if($logs->hasPages())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-3">{{ $logs->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
