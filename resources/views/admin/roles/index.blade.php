@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center mb-6 sm:mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Role Management</h1>
                <p class="mt-2 text-sm text-gray-600">Manage user roles and permissions</p>
            </div>
            <a href="{{ route('roles.create') }}" class="w-full sm:w-auto text-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-sm">
                <svg class="inline-block w-5 h-5 mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New Role
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Roles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($roles as $role)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow p-6">
                    <!-- Role Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="p-3 bg-indigo-100 rounded-lg">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-bold text-gray-900">{{ $role->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $role->users_count }} users</p>
                            </div>
                        </div>
                    </div>

                    <!-- Role Description -->
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ $role->description ?? 'No description available' }}
                    </p>

                    <!-- Permissions Count -->
                    <div class="mb-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            {{ count($role->permissions ?? []) }} permissions
                        </div>
                    </div>

                    <!-- Permissions List -->
                    @if($role->permissions && count($role->permissions) > 0)
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_slice($role->permissions, 0, 3) as $permission)
                                    <span class="px-2 py-1 text-xs bg-blue-50 text-blue-700 rounded">
                                        {{ str_replace('-', ' ', ucfirst($permission)) }}
                                    </span>
                                @endforeach
                                @if(count($role->permissions) > 3)
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">
                                        +{{ count($role->permissions) - 3 }} more
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('roles.edit', $role) }}" class="flex-1 px-4 py-2 text-center bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors">
                            Edit
                        </a>
                        @if(!in_array($role->name, ['Admin', 'Kader', 'Bidan']))
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="w-full sm:w-auto" onsubmit="return confirm('Are you sure you want to delete this role?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors">
                                    Delete
                                </button>
                            </form>
                        @else
                            <button type="button" class="w-full sm:w-auto px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed" disabled title="Cannot delete default role">
                                Delete
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if($roles->isEmpty())
            <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="mt-4 text-gray-500">No roles found</p>
            </div>
        @endif
    </div>
</div>
@endsection
