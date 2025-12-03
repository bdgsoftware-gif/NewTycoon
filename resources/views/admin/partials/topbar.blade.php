<!-- Topbar -->
<header class="bg-white border-b border-gray-200">
    <div class="flex items-center justify-between h-16 px-6">
        <!-- Left Section -->
        <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">
                @hasSection('page-title')
                    @yield('page-title')
                @else
                    Dashboard
                @endif
            </h1>
            @hasSection('page-description')
                <span class="ml-4 text-sm text-gray-500">@yield('page-description')</span>
            @endif
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4">
            <!-- Search -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="search"
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-64"
                    placeholder="Search...">
            </div>

            <!-- User Menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 focus:outline-none">
                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                        <span class="text-indigo-600 font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="hidden lg:block text-left">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">
                            @if (Auth::user()->isAdmin())
                                Admin
                            @elseif(Auth::user()->isModerator())
                                Moderator
                            @else
                                User
                            @endif
                        </p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" x-cloak
                    class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                    <a href="{{ route('profile') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-3 text-gray-400"></i>
                        Profile
                    </a>
                    @if (auth()->user()->hasPermission('manage_settings'))
                        <a href="{{ route('admin.settings.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-3 text-gray-400"></i>
                            Settings
                        </a>
                    @endif
                    <a href="{{ route('home') }}"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-t border-gray-100">
                        <i class="fas fa-external-link-alt mr-3 text-gray-400"></i>
                        View Site
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100 border-t border-gray-100">
                            <i class="fas fa-sign-out-alt mr-3"></i>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
