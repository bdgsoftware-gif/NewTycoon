@extends('admin.layouts.app')

@section('title', 'Edit Role')
@section('page-title', 'Edit Role: ' . $role->display_name)

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
        <span class="text-gray-700">Edit</span>
    </li>
@endsection

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Edit Role: {{ $role->display_name }}</h3>
                <p class="text-sm text-gray-500 mt-1">Update role information and permissions</p>
            </div>

            <form method="POST" action="{{ route('admin.settings.roles.update', $role) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Role Information -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-800 mb-4">Role Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Role Name *</label>
                                <input type="text" name="name" value="{{ old('name', $role->name) }}"
                                    class="w-full px-3 py-2 border {{ $errors->has('name') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="e.g., manager" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Lowercase, no spaces</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Display Name *</label>
                                <input type="text" name="display_name"
                                    value="{{ old('display_name', $role->display_name) }}"
                                    class="w-full px-3 py-2 border {{ $errors->has('display_name') ? 'border-red-300' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="e.g., Manager" required>
                                @error('display_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Describe the purpose of this role">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Current Permissions -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-800 mb-4">Current Permissions</h4>
                        @if ($role->permissions->count() > 0)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                    @foreach ($role->permissions as $permission)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $permission->display_name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6 bg-gray-50 rounded-lg">
                                <svg class="h-12 w-12 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">This role has no permissions assigned</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex justify-between">
                        <a href="{{ route('admin.settings.roles.index') }}"
                            class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                            Back to Roles
                        </a>
                        <div class="flex space-x-3">
                            <button type="button"
                                onclick="showPermissionsModal('{{ $role->id }}', '{{ $role->name }}')"
                                class="px-4 py-2 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                Manage Permissions
                            </button>
                            <button type="submit"
                                class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                Update Role
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Permissions Modal -->
    <div id="permissionsModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Manage Permissions: {{ $role->name }}</h3>
                    <button onclick="closePermissionsModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div id="permissionsContainer" class="space-y-6">
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
                                        <input type="checkbox" id="perm_{{ $permission->id }}"
                                            value="{{ $permission->id }}"
                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
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

            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closePermissionsModal()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        Cancel
                    </button>
                    <button type="button" onclick="savePermissions()"
                        class="px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        Save Permissions
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showPermissionsModal() {
            document.getElementById('permissionsModal').classList.remove('hidden');
        }

        function closePermissionsModal() {
            document.getElementById('permissionsModal').classList.add('hidden');
        }

        function toggleGroup(group) {
            const checkboxes = document.querySelectorAll(`.group-${group}`);
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);

            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
        }

        function savePermissions() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            const permissions = Array.from(checkboxes).map(cb => cb.value);

            fetch(`{{ route('admin.settings.roles.sync.permissions', $role) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        permissions: permissions
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Permissions updated successfully');
                        location.reload();
                    } else {
                        alert('Failed to update permissions: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error saving permissions:', error);
                    alert('Failed to save permissions');
                });
        }
    </script>
@endpush
