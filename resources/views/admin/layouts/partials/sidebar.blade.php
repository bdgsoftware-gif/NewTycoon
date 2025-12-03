<!-- Sidebar -->
<div class="w-64 bg-gray-900 border-r border-gray-800 flex flex-col flex-shrink-0">
    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b border-gray-800">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
            <div class="h-10 w-10 rounded-lg bg-indigo-600 flex items-center justify-center">
                <span class="text-white font-bold text-xl">T</span>
            </div>
            <div>
                <span class="text-white font-bold text-lg">{{ config('app.name', 'Tycoon') }}</span>
                <p class="text-xs text-gray-400">Admin Panel</p>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <i class="fas fa-tachometer-alt w-5 mr-3 text-center"></i>
            Dashboard
        </a>

        <!-- Users (Only for admins with permission) -->
        @if (auth()->user()->hasPermission('manage_users'))
            <a href="{{ route('admin.users.index') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-users w-5 mr-3 text-center"></i>
                Users
            </a>
        @endif

        <!-- Content -->
        @if (auth()->user()->hasPermission('manage_content'))
            <a href="{{ route('admin.content.index') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.content.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-newspaper w-5 mr-3 text-center"></i>
                Content
            </a>
        @endif

        <!-- Products -->
        @if (auth()->user()->hasPermission('manage_products'))
            <a href="{{ route('admin.products.index') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-box w-5 mr-3 text-center"></i>
                Products
            </a>
        @endif

        <!-- Orders -->
        @if (auth()->user()->hasPermission('view_orders'))
            <a href="{{ route('admin.orders.index') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-shopping-cart w-5 mr-3 text-center"></i>
                Orders
            </a>
        @endif

        <!-- Analytics -->
        @if (auth()->user()->hasPermission('view_reports'))
            <a href="{{ route('admin.analytics') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.analytics') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-chart-bar w-5 mr-3 text-center"></i>
                Analytics
            </a>
        @endif

        <!-- Settings -->
        @if (auth()->user()->hasPermission('manage_settings'))
            <a href="{{ route('admin.settings') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.settings') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <i class="fas fa-cog w-5 mr-3 text-center"></i>
                Settings
            </a>
        @endif

        <!-- Divider -->
        <div class="pt-4 mt-4 border-t border-gray-800">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Quick Actions</p>
        </div>

        <!-- Quick Actions -->
        @if (auth()->user()->hasPermission('manage_users'))
            <a href="{{ route('admin.users.create') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors text-gray-300 hover:bg-gray-800 hover:text-white">
                <i class="fas fa-user-plus w-5 mr-3 text-center"></i>
                Add New User
            </a>
        @endif

        @if (auth()->user()->hasPermission('manage_products'))
            <a href="{{ route('admin.products.create') }}"
                class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors text-gray-300 hover:bg-gray-800 hover:text-white">
                <i class="fas fa-plus-circle w-5 mr-3 text-center"></i>
                Add Product
            </a>
        @endif
    </nav>

    <!-- User Profile -->
    <div class="border-t border-gray-800 p-4">
        <div class="flex items-center">
            <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center">
                <span class="text-white font-semibold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400">
                    @if (Auth::user()->isAdmin())
                        Administrator
                    @elseif(Auth::user()->isModerator())
                        Moderator
                    @else
                        User
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
