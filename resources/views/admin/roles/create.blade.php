@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('roles.index') }}" class="text-indigo-600 hover:text-indigo-700 mb-4 inline-flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Roles
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Create New Role</h1>
            <p class="mt-2 text-sm text-gray-600">Add a new user role with specific permissions</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm p-8">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <!-- Role Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Role Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Permissions -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-4">
                        Permissions
                    </label>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        @foreach($availablePermissions as $key => $label)
                            <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" 
                                    {{ in_array($key, old('permissions', [])) ? 'checked' : '' }}
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <span class="ml-3 text-sm text-gray-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('permissions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-sm">
                        Create Role
                    </button>
                    <a href="{{ route('roles.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
