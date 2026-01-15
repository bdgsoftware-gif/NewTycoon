@extends('admin.layouts.app')

@section('title', 'Permissions')
@section('page-title', 'Permissions Management')

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
        <span class="text-gray-700">Permissions</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Permissions Management</h3>
                    <p class="text-sm text-gray-500 mt-1">Manage system permissions and access controls</p>
                </div>
                <button onclick="showCreatePermissionModal()"
                    class="px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                    Create Permission
                </button>
            </div>

            <!-- Permissions Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h4 class="text-lg font-semibold text-gray-800">Permissions List</h4>
                        <div class="text-sm text-gray-500">
                            {{ $permissions->total() }} total permissions
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Permission</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Group
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Roles
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($permissions as $permission)
                                @php
                                    $group = explode('_', $permission->name)[0] ?? 'other';
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $permission->display_name }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $permission->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                            {{ $group }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-500">{{ $permission->description ?: 'No description' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $permission->roles_count }} roles
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <button onclick="showEditPermissionModal({{ $permission->id }})"
                                                class="text-primary hover:text-primary-dark">Edit</button>

                                            <form action="{{ route('admin.settings.permissions.destroy', $permission) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this permission?')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($permissions->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $permissions->links() }}
                    </div>
                @endif
            </div>

            <!-- Permission Groups -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-6">Permission Groups</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($permissionGroups as $group => $permissions)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h5 class="text-sm font-medium text-gray-900 capitalize">{{ $group }}</h5>
                                <span class="text-xs text-gray-500">{{ count($permissions) }} permissions</span>
                            </div>
                            <div class="space-y-2">
                                @foreach ($permissions as $permission)
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">{{ $permission->display_name }}</span>
                                        <span class="text-xs text-gray-500">{{ $permission->roles_count }} roles</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Create Permission Modal -->
        <div id="createPermissionModal"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Create New Permission</h3>
                </div>

                <form id="createPermissionForm" method="POST" action="{{ route('admin.settings.permissions.store') }}"
                    class="p-6">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permission Name *</label>
                            <input type="text" name="name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="e.g., view_users">
                            <p class="mt-1 text-xs text-gray-500">Lowercase, underscore separated (e.g., "view_users",
                                "create_products")</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Display Name *</label>
                            <input type="text" name="display_name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="e.g., View Users">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Describe what this permission allows"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Group</label>
                            <input type="text" name="group"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="e.g., users (optional)">
                            <p class="mt-1 text-xs text-gray-500">Optional: Groups permissions for better organization</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeCreatePermissionModal()"
                                class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Permission Modal -->
        <div id="editPermissionModal"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
            <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Edit Permission</h3>
                </div>

                <form id="editPermissionForm" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permission Name *</label>
                            <input type="text" name="name" id="editName" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Display Name *</label>
                            <input type="text" name="display_name" id="editDisplayName" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="editDescription" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeEditPermissionModal()"
                                class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showCreatePermissionModal() {
            document.getElementById('createPermissionModal').classList.remove('hidden');
        }

        function closeCreatePermissionModal() {
            document.getElementById('createPermissionModal').classList.add('hidden');
        }

        function showEditPermissionModal(permissionId) {
            // Fetch permission data
            fetch(`/admin/settings/permissions/${permissionId}`)
                .then(response => response.json())
                .then(permission => {
                    document.getElementById('editName').value = permission.name;
                    document.getElementById('editDisplayName').value = permission.display_name;
                    document.getElementById('editDescription').value = permission.description || '';

                    // Update form action
                    document.getElementById('editPermissionForm').action =
                        `/admin/settings/permissions/${permissionId}`;

                    // Show modal
                    document.getElementById('editPermissionModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error loading permission:', error);
                    alert('Failed to load permission data');
                });
        }

        function closeEditPermissionModal() {
            document.getElementById('editPermissionModal').classList.add('hidden');
        }

        // Handle create form submission
        document.getElementById('createPermissionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            this.submit();
        });

        // Handle edit form submission
        document.getElementById('editPermissionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            this.submit();
        });
    </script>
@endpush
