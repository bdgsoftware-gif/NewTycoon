<!-- Sidebar -->
<div class="w-64 bg-white border-r border-gray-200 flex flex-col flex-shrink-0 transition-all duration-300 ease-in-out"
    :class="{ 'w-16': sidebarCollapsed }" x-data="{ sidebarCollapsed: false }" x-init="$watch('sidebarCollapsed', value => localStorage.setItem('sidebarCollapsed', value));
    sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true'" id="sidebar">

    <!-- Logo & Toggle -->
    <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3" x-show="!sidebarCollapsed">
            <div class="h-8 w-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                <span class="text-white font-bold text-sm">T</span>
            </div>
            <div>
                <span class="text-gray-900 font-bold text-sm">{{ config('app.name', 'Tycoon') }}</span>
                <p class="text-xs text-gray-500">Admin Panel</p>
            </div>
        </a>

        <!-- Toggle Button -->
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="p-1.5 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            :title="sidebarCollapsed ? 'Expand Sidebar' : 'Collapse Sidebar'">
            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    :d="sidebarCollapsed ? 'M13 5l7 7-7 7M5 5l7 7-7 7' : 'M11 19l-7-7 7-7m8 14l-7-7 7-7'" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
            class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50' }}"
            x-data="{ tooltip: false }" @mouseenter="if (sidebarCollapsed) tooltip = true" @mouseleave="tooltip = false">
            <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="ml-3" x-show="!sidebarCollapsed">Dashboard</span>
            <div x-show="sidebarCollapsed && tooltip" x-transition
                class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                Dashboard
            </div>
        </a>

        <!-- Users -->
        @if (auth()->user()->hasPermission('manage_users'))
            <div x-data="{ open: {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }} }" x-init="if (sidebarCollapsed) open = false">
                <button @click="open = !open"
                    class="w-full group flex items-center px-2 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50' }}"
                    x-data="{ tooltip: false }" @mouseenter="if (sidebarCollapsed) tooltip = true"
                    @mouseleave="tooltip = false">
                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.users.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="ml-3 flex-1 text-left" x-show="!sidebarCollapsed">Users</span>
                    <svg :class="{ 'transform rotate-90': open }"
                        class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        x-show="!sidebarCollapsed && open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <div x-show="sidebarCollapsed && tooltip" x-transition
                        class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                        Users
                    </div>
                </button>

                <div x-show="open && !sidebarCollapsed" x-collapse class="ml-8 mt-1 space-y-1">
                    <a href="{{ route('admin.users.index') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.users.index') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        All Users
                    </a>
                    <a href="{{ route('admin.users.create') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users.create') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.users.create') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add User
                    </a>
                </div>
            </div>
        @endif

        <!-- Products -->
        @if (auth()->user()->hasPermission('manage_products'))
            <div x-data="{ open: {{ request()->routeIs('admin.products.*') ? 'true' : 'false' }} }" x-init="if (sidebarCollapsed) open = false">
                <button @click="open = !open"
                    class="w-full group flex items-center px-2 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50' }}"
                    x-data="{ tooltip: false }" @mouseenter="if (sidebarCollapsed) tooltip = true"
                    @mouseleave="tooltip = false">
                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.products.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="ml-3 flex-1 text-left" x-show="!sidebarCollapsed">Products</span>
                    <svg :class="{ 'transform rotate-90': open }"
                        class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        x-show="!sidebarCollapsed && open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <div x-show="sidebarCollapsed && tooltip" x-transition
                        class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                        Products
                    </div>
                </button>

                <div x-show="open && !sidebarCollapsed" x-collapse class="ml-8 mt-1 space-y-1">
                    <a href="{{ route('admin.products.index') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.products.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.products.index') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        All Products
                    </a>
                    <a href="{{ route('admin.products.create') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.products.create') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.products.create') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Product
                    </a>
                </div>
            </div>
        @endif

        <!-- Categories -->
        @if (auth()->user()->hasPermission('manage_products'))
            <a href="{{ route('admin.categories.index') }}"
                class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50' }}"
                x-data="{ tooltip: false }" @mouseenter="if (sidebarCollapsed) tooltip = true"
                @mouseleave="tooltip = false">
                <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="ml-3" x-show="!sidebarCollapsed">Categories</span>
                <div x-show="sidebarCollapsed && tooltip" x-transition
                    class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                    Categories
                </div>
            </a>
        @endif

        <!-- Brands -->
        @if (auth()->user()->hasPermission('manage_products'))
            <a href="{{ route('admin.brands.index') }}"
                class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.brands.*') ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50' }}"
                x-data="{ tooltip: false }" @mouseenter="if (sidebarCollapsed) tooltip = true"
                @mouseleave="tooltip = false">
                <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.brands.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span class="ml-3" x-show="!sidebarCollapsed">Brands</span>
                <div x-show="sidebarCollapsed && tooltip" x-transition
                    class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                    Brands
                </div>
            </a>
        @endif

        <!-- Orders -->
        @if (auth()->user()->hasPermission('view_orders'))
            <div x-data="{ open: {{ request()->routeIs('admin.orders.*') ? 'true' : 'false' }} }" x-init="if (sidebarCollapsed) open = false">
                <button @click="open = !open"
                    class="w-full group flex items-center px-2 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50' }}"
                    x-data="{ tooltip: false }" @mouseenter="if (sidebarCollapsed) tooltip = true"
                    @mouseleave="tooltip = false">
                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.orders.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="ml-3 flex-1 text-left" x-show="!sidebarCollapsed">Orders</span>
                    <svg :class="{ 'transform rotate-90': open }"
                        class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        x-show="!sidebarCollapsed && open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <div x-show="sidebarCollapsed && tooltip" x-transition
                        class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                        Orders
                    </div>
                </button>

                <div x-show="open && !sidebarCollapsed" x-collapse class="ml-8 mt-1 space-y-1">
                    <a href="{{ route('admin.orders.index') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.orders.index') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.orders.index') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        All Orders
                    </a>
                    <a href="{{ route('admin.orders.create') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.orders.create') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.orders.create') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add Order
                    </a>
                </div>
            </div>
        @endif

        <!-- Content -->
        @if (auth()->user()->hasPermission('manage_content'))
            <a href="{{ route('admin.content.index') }}"
                class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.content.*') ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50' }}"
                x-data="{ tooltip: false }" @mouseenter="if (sidebarCollapsed) tooltip = true"
                @mouseleave="tooltip = false">
                <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.content.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span class="ml-3" x-show="!sidebarCollapsed">Content</span>
                <div x-show="sidebarCollapsed && tooltip" x-transition
                    class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                    Content
                </div>
            </a>
        @endif

        <!-- Analytics -->
        @if (auth()->user()->hasPermission('view_reports'))
            <a href="{{ route('admin.analytics.index') }}"
                class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.analytics') ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50' }}"
                x-data="{ tooltip: false }" @mouseenter="if (sidebarCollapsed) tooltip = true"
                @mouseleave="tooltip = false">
                <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.analytics') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="ml-3" x-show="!sidebarCollapsed">Analytics</span>
                <div x-show="sidebarCollapsed && tooltip" x-transition
                    class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                    Analytics
                </div>
            </a>
        @endif

        <!-- Settings -->
        @if (auth()->user()->hasPermission('manage_settings'))
            <div x-data="{ open: {{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }} }" x-init="if (sidebarCollapsed) open = false">
                <button @click="open = !open"
                    class="w-full group flex items-center px-2 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'text-gray-700 hover:text-indigo-700 hover:bg-indigo-50' }}"
                    x-data="{ tooltip: false }" @mouseenter="if (sidebarCollapsed) tooltip = true"
                    @mouseleave="tooltip = false">
                    <svg class="h-5 w-5 flex-shrink-0 {{ request()->routeIs('admin.settings.*') ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-600' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="ml-3 flex-1 text-left" x-show="!sidebarCollapsed">Settings</span>
                    <svg :class="{ 'transform rotate-90': open }"
                        class="ml-2 h-4 w-4 text-gray-400 transition-transform duration-200 flex-shrink-0"
                        x-show="!sidebarCollapsed && open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <div x-show="sidebarCollapsed && tooltip" x-transition
                        class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                        Settings
                    </div>
                </button>

                <div x-show="open && !sidebarCollapsed" x-collapse class="ml-8 mt-1 space-y-1">
                    <a href="{{ route('admin.settings.index') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.settings') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.settings') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        General Settings
                    </a>
                    <a href="{{ route('admin.settings.roles.index') }}"
                        class="group flex items-center px-2 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.settings.roles') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-indigo-600 hover:bg-indigo-50' }}">
                        <svg class="mr-3 h-4 w-4 {{ request()->routeIs('admin.settings.roles') ? 'text-indigo-500' : 'text-gray-400 group-hover:text-indigo-500' }}"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Roles & Permissions
                    </a>
                </div>
            </div>
        @endif

        <!-- Divider -->
        <div class="pt-4 mt-4 border-t border-gray-200" x-show="!sidebarCollapsed">
            <p class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Quick Actions</p>
        </div>

        <!-- Quick Actions -->
        @if (auth()->user()->hasPermission('manage_users'))
            <a href="{{ route('admin.users.create') }}"
                class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-lg transition-colors text-gray-700 hover:text-indigo-700 hover:bg-indigo-50"
                x-data="{ tooltip: false }" @mouseenter="if (sidebarCollapsed) tooltip = true"
                @mouseleave="tooltip = false">
                <svg class="h-5 w-5 flex-shrink-0 text-gray-500 group-hover:text-indigo-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="ml-3" x-show="!sidebarCollapsed">Add User</span>
                <div x-show="sidebarCollapsed && tooltip" x-transition
                    class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                    Add User
                </div>
            </a>
        @endif

        @if (auth()->user()->hasPermission('manage_products'))
            <a href="{{ route('admin.products.create') }}"
                class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-lg transition-colors text-gray-700 hover:text-indigo-700 hover:bg-indigo-50"
                x-data="{ tooltip: false }" @mouseenter="if (sidebarCollapsed) tooltip = true"
                @mouseleave="tooltip = false">
                <svg class="h-5 w-5 flex-shrink-0 text-gray-500 group-hover:text-indigo-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="ml-3" x-show="!sidebarCollapsed">Add Product</span>
                <div x-show="sidebarCollapsed && tooltip" x-transition
                    class="absolute left-full ml-2 px-2 py-1 bg-gray-900 text-white text-xs rounded shadow-lg z-50 whitespace-nowrap">
                    Add Product
                </div>
            </a>
        @endif
    </nav>

    <!-- User Profile -->
    <div class="border-t border-gray-200 p-4">
        <div class="flex items-center">
            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                <span
                    class="text-indigo-600 font-semibold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
            <div class="ml-3" x-show="!sidebarCollapsed">
                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">
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
