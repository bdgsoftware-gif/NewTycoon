@extends('admin.layouts.app')

@section('title', 'Roles & Permissions')
@section('page-title', 'Roles Management')

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
        <span class="text-gray-700">Roles</span>
    </li>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Roles Management</h3>
                <p class="text-sm text-gray-500 mt-1">Manage user roles and permissions</p>
            </div>
            <a href="{{ route('admin.settings.roles.create') }}"
                class="px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                Create New Role
            </a>
        </div>

        <!-- Roles Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h4 class="text-lg font-semibold text-gray-800">Roles List</h4>
                    <div class="text-sm text-gray-500">
                        {{ $roles->total() }} total roles
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Permissions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($roles as $role)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $role->display_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $role->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $role->users_count }} users
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $role->permissions_count }} permissions
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-500">{{ $role->description ?: 'No description' }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.settings.roles.edit', $role) }}"
                                            class="text-primary hover:text-primary-dark">Edit</a>

                                        @if (!in_array($role->name, ['admin', 'customer']))
                                            <form action="{{ route('admin.settings.roles.destroy', $role) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this role?')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        @endif

                                        <button
                                            onclick="showPermissionsModal('{{ $role->id }}', '{{ $role->name }}')"
                                            class="text-purple-600 hover:text-purple-900">Permissions</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($roles->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $roles->links() }}
                </div>
            @endif
        </div>

        <!-- Permissions Overview -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-6">Permissions Overview</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($permissions as $group => $groupPermissions)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h5 class="text-sm font-medium text-gray-900 mb-3 capitalize">{{ $group }}</h5>
                        <div class="space-y-2">
                            @foreach ($groupPermissions as $permission)
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

    <!-- Permissions Modal -->
    <div id="permissionsModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 hidden z-50">
        <div class="bg-white rounded-xl shadow-lg max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Manage Permissions: <span id="modalRoleName"></span>
                    </h3>
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
                    <!-- Permissions will be loaded here -->
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
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let selectedRoleId = null;
        let selectedPermissions = new Set();

        function showPermissionsModal(roleId, roleName) {
            selectedRoleId = roleId;
            document.getElementById('modalRoleName').textContent = roleName;

            // Load permissions
            fetch(`/admin/settings/roles/${roleId}/edit`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('permissionsContainer');
                    container.innerHTML = '';

                    // Group permissions
                    const groupedPermissions = {};
                    @foreach ($permissions as $group => $groupPermissions)
                        groupedPermissions['{{ $group }}'] = @json($groupPermissions);
                    @endforeach

                    // Render groups
                    for (const [group, permissions] of Object.entries(groupedPermissions)) {
                        const groupDiv = document.createElement('div');
                        groupDiv.className = 'border border-gray-200 rounded-lg p-4';

                        let groupHtml = `
                    <h5 class="text-sm font-medium text-gray-900 mb-3 capitalize">${group}</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                `;

                        permissions.forEach(permission => {
                            const isSelected = data.rolePermissions && data.rolePermissions.includes(permission
                                .id);
                            if (isSelected) {
                                selectedPermissions.add(permission.id);
                            }

                            groupHtml += `
                        <div class="flex items-center">
                            <input type="checkbox" id="perm_${permission.id}" 
                                value="${permission.id}" ${isSelected ? 'checked' : ''}
                                onchange="togglePermission(${permission.id})"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="perm_${permission.id}" class="ml-2 text-sm text-gray-700">
                                ${permission.display_name}
                            </label>
                        </div>
                    `;
                        });

                        groupHtml += '</div>';
                        groupDiv.innerHTML = groupHtml;
                        container.appendChild(groupDiv);
                    }

                    // Show modal
                    document.getElementById('permissionsModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error loading permissions:', error);
                    alert('Failed to load permissions');
                });
        }

        function closePermissionsModal() {
            document.getElementById('permissionsModal').classList.add('hidden');
            selectedRoleId = null;
            selectedPermissions.clear();
        }

        function togglePermission(permissionId) {
            const checkbox = document.getElementById(`perm_${permissionId}`);
            if (checkbox.checked) {
                selectedPermissions.add(permissionId);
            } else {
                selectedPermissions.delete(permissionId);
            }
        }

        function savePermissions() {
            if (!selectedRoleId) return;

            const permissions = Array.from(selectedPermissions);

            fetch(`/admin/settings/roles/${selectedRoleId}/permissions`, {
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
                        closePermissionsModal();
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
