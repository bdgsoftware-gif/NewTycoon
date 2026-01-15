@extends('admin.layouts.app')

@section('title', 'Create Role')
@section('page-title', 'Create New Role')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.settings.index') }}" class="text-gray-500 hover:text-gray-700">Settings</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.settings.roles.index') }}" class="text-gray-500 hover:text-gray-700">Roles</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Create</span>
    </li>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Create New Role</h3>
                <p class="text-sm text-gray-500 mt-1">Define a new user role with specific permissions</p>
            </div>

            <form method="POST" action="{{ route('admin.settings.roles.store') }}" class="p-6">
                @csrf

                <div class="space-y-6">
                    <!-- Role Information -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-800 mb-4">Role Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="w-full px-3 py-2 border {{ $errors->has('name') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="e.g., manager" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Lowercase, no spaces (e.g., "manager", "editor")</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Display Name *</label>
                                <input type="text" name="display_name" value="{{ old('display_name') }}"
                                    class="w-full px-3 py-2 border {{ $errors->has('display_name') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="e.g., Manager" required>
                                @error('display_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Human-readable name for the role</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Describe the purpose of this role">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Permissions -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-800 mb-4">Assign Permissions</h4>
                        <p class="text-sm text-gray-500 mb-4">Select the permissions this role should have</p>

                        <div class="space-y-6">
                            @foreach ($permissions as $group => $groupPermissions)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <h5 class="text-sm font-medium text-gray-900 capitalize">{{ $group }}</h5>
                                        <button type="button" onclick="toggleGroup('{{ $group }}')"
                                            class="text-sm text-primary hover:text-primary-dark">
                                            Toggle All
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach ($groupPermissions as $permission)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                    id="perm_{{ $permission->id }}"
                                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded group-{{ $group }}">
                                                <label for="perm_{{ $permission->id }}" class="ml-2 text-sm text-gray-700">
                                                    {{ $permission->display_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.settings.roles.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            Create Role
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleGroup(group) {
            const checkboxes = document.querySelectorAll(`.group-${group}`);
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);

            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        }
    </script>
@endpush
