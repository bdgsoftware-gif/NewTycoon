<!-- resources/views/components/navbar.blade.php -->
<nav class="bg-white relative font-cambay border-b">
    <div class="max-w-8xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo on the left -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" aria-label="Home" class="inline-block" title="Tycoon Hi-Tech Park">
                    <img src="{{ asset('images/bk-logo.png') }}" alt="BK Logo" loading="lazy" class="h-6 md:h-8 w-auto">
                </a>
            </div>

            <!-- Centered navigation links -->
            <div class="hidden md:flex items-center justify-start flex-1 pl-4">
                <div class="flex space-x-4">
                    @foreach ($navigation as $item)
                        @if (isset($item['children']) && count($item['children']) > 0)
                            <!-- Parent link with dropdown -->
                            <div class="relative group">
                                <button
                                    class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-base font-semibold flex items-center">
                                    {{ $item['name'] }}
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown menu -->
                                <div
                                    class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                    <div class="py-1">
                                        @foreach ($item['children'] as $child)
                                            <a href="{{ $child['url'] }}"
                                                class="block px-4 py-2 text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                                {{ $child['name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Single link -->
                            <a href="{{ $item['url'] }}"
                                class="text-gray-700 hover:text-primary px-3 py-2 rounded-md text-base font-semibold">
                                {{ $item['name'] }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Right side icons -->
            <div class="flex items-center space-x-4">
                <!-- Search icon -->
                <button id="search-toggle"
                    class="text-gray-600 hover:text-primary p-2 transition-all duration-300 hover:rotate-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- User icon -->
                <div class="relative group">
                    <button class="text-gray-600 hover:text-primary p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </button>

                    <!-- User dropdown menu -->
                    <div
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border">
                        <div class="py-1">
                            @auth
                                <!-- Authenticated user menu -->
                                <a href="{{ route('profile') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Profile
                                </a>
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Dashboard
                                </a>
                                <a href="{{ route('trackOrder') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Track Order
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            @else
                                <!-- Guest user menu -->
                                <a href="{{ route('login') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign In
                                </a>
                                <a href="{{ route('register') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign Up
                                </a>
                                <hr class="my-1">
                                <a href="{{ route('trackOrder') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Track Order
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-600 hover:text-primary p-2" id="mobile-menu-button">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t">
            @foreach ($navigation as $item)
                @if (isset($item['children']) && count($item['children']) > 0)
                    <div class="relative">
                        <button
                            class="mobile-dropdown-toggle w-full text-left text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-semibold">
                            {{ $item['name'] }}
                        </button>
                        <div class="mobile-dropdown hidden pl-4">
                            @foreach ($item['children'] as $child)
                                <a href="{{ $child['url'] }}"
                                    class="block px-3 py-2 text-gray-600 hover:text-primary text-sm">
                                    {{ $child['name'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $item['url'] }}"
                        class="text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-semibold">
                        {{ $item['name'] }}
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</nav>

<!-- Full Page Search Modal -->
<div id="search-modal" class="fixed inset-0 bg-white z-50 hidden transition-opacity duration-300">
    <div class="container mx-auto px-4 pt-20">
        <!-- Close button -->
        <button id="search-close"
            class="absolute top-6 right-6 text-gray-500 hover:text-primary transition-transform duration-300 hover:rotate-90">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Search input -->
        <div class="max-w-2xl mx-auto">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="text" name="q" placeholder="What are you looking for?" autocomplete="off"
                    class="w-full py-4 text-2xl md:text-4xl font-light border-0 border-b-2 border-gray-300 focus:border-primary focus:ring-0 outline-none transition-all duration-300"
                    id="search-input">
                <button type="submit"
                    class="absolute right-0 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary p-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Add this script for mobile menu and search functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileDropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');

        // Search modal elements
        const searchToggle = document.getElementById('search-toggle');
        const searchModal = document.getElementById('search-modal');
        const searchClose = document.getElementById('search-close');
        const searchInput = document.getElementById('search-input');

        // Mobile menu functionality
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        mobileDropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const dropdown = this.nextElementSibling;
                dropdown.classList.toggle('hidden');
            });
        });

        // Search modal functionality
        searchToggle.addEventListener('click', function() {
            searchModal.classList.remove('hidden');
            setTimeout(() => {
                searchInput.focus();
            }, 100);
        });

        searchClose.addEventListener('click', function() {
            searchModal.classList.add('hidden');
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !searchModal.classList.contains('hidden')) {
                searchModal.classList.add('hidden');
            }
        });

        // Close modal when clicking outside content (optional)
        searchModal.addEventListener('click', function(e) {
            if (e.target === searchModal) {
                searchModal.classList.add('hidden');
            }
        });
    });
</script>
