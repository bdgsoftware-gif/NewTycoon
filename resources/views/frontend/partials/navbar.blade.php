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
                    class="text-gray-600 hover:text-primary p-2 transition-all duration-300 hover:rotate-90" title="Click to Search">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- User icon -->
                <div class="relative group">
                    <button class="text-gray-600 hover:text-primary p-2">
                        <svg class="w-6 h-6" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M695.2 275.5c0 9.8-.7 19.5-2 29.2.4-2.7.7-5.3 1.1-8-2.6 18.3-7.4 36.2-14.5 53.2l3-7.2c-5.3 12.6-11.8 24.7-19.4 36-1.9 2.9-4 5.8-6.1 8.6-4.4 5.9 3.8-4.7.7-.9-1.1 1.4-2.2 2.7-3.3 4.1-4.2 5-8.6 9.9-13.2 14.5s-9.5 9.1-14.5 13.2c-1.3 1.1-2.7 2.2-4.1 3.3-3.9 3.1 6.8-5.1.9-.7-2.8 2.1-5.7 4.1-8.6 6.1-11.4 7.6-23.4 14-36 19.4l7.2-3c-17.1 7.1-34.9 12-53.2 14.5 2.7-.4 5.3-.7 8-1.1-19.4 2.6-38.9 2.6-58.3 0 2.7.4 5.3.7 8 1.1-18.3-2.6-36.2-7.4-53.2-14.5l7.2 3c-12.6-5.3-24.7-11.8-36-19.4-2.9-1.9-5.8-4-8.6-6.1-5.9-4.4 4.7 3.8.9.7-1.4-1.1-2.7-2.2-4.1-3.3-5-4.2-9.9-8.6-14.5-13.2s-9.1-9.5-13.2-14.5c-1.1-1.3-2.2-2.7-3.3-4.1-3.1-3.9 5.1 6.8.7.9-2.1-2.8-4.1-5.7-6.1-8.6-7.6-11.4-14-23.4-19.4-36l3 7.2c-7.1-17.1-12-34.9-14.5-53.2.4 2.7.7 5.3 1.1 8-2.6-19.4-2.6-38.9 0-58.3-.4 2.7-.7 5.3-1.1 8 2.6-18.3 7.4-36.2 14.5-53.2l-3 7.2c5.3-12.6 11.8-24.7 19.4-36 1.9-2.9 4-5.8 6.1-8.6 4.4-5.9-3.8 4.7-.7.9 1.1-1.4 2.2-2.7 3.3-4.1 4.2-5 8.6-9.9 13.2-14.5s9.5-9.1 14.5-13.2c1.3-1.1 2.7-2.2 4.1-3.3 3.9-3.1-6.8 5.1-.9.7 2.8-2.1 5.7-4.1 8.6-6.1 11.4-7.6 23.4-14 36-19.4l-7.2 3c17.1-7.1 34.9-12 53.2-14.5-2.7.4-5.3.7-8 1.1 19.4-2.6 38.9-2.6 58.3 0-2.7-.4-5.3-.7-8-1.1 18.3 2.6 36.2 7.4 53.2 14.5l-7.2-3c12.6 5.3 24.7 11.8 36 19.4 2.9 1.9 5.8 4 8.6 6.1 5.9 4.4-4.7-3.8-.9-.7 1.4 1.1 2.7 2.2 4.1 3.3 5 4.2 9.9 8.6 14.5 13.2s9.1 9.5 13.2 14.5c1.1 1.3 2.2 2.7 3.3 4.1 3.1 3.9-5.1-6.8-.7-.9 2.1 2.8 4.1 5.7 6.1 8.6 7.6 11.4 14 23.4 19.4 36l-3-7.2c7.1 17.1 12 34.9 14.5 53.2-.4-2.7-.7-5.3-1.1-8 1.3 9.7 2 19.4 2 29.1.1 15.7 13.8 30.7 30 30s30.1-13.2 30-30c-.2-49.1-15-98.8-43.7-138.9-29.6-41.5-70-72.5-117.8-90.1-93.3-34.4-204.6-4.2-267.7 72.6-32.9 40.1-52.5 87.9-56.5 139.7-3.8 49.3 8.7 100.3 34.4 142.6 24.8 40.8 62.1 75.1 105.8 94.7 25 11.2 50.1 18.1 77.3 21.3 25.2 3 50.8 1.2 75.7-3.9 95.7-19.4 174.6-101.2 189.2-198 2-13.2 3.4-26.5 3.4-39.9.1-15.7-13.8-30.7-30-30-16.4.7-30 13.1-30.1 29.9m133.5 656.2H270.1c-24.8 0-49.5.1-74.3 0-2.5 0-5-.2-7.5-.5 2.7.4 5.3.7 8 1.1-4-.6-7.8-1.7-11.5-3.2l7.2 3c-2.8-1.2-5.5-2.6-8.1-4.3s-3.5-4 1.9 1.6c-1-1.1-2.3-2-3.3-3-.3-.3-3.2-3.2-3-3.3 0 0 5.2 7.3 1.6 1.9-1.7-2.5-3.1-5.2-4.3-8.1l3 7.2c-1.5-3.7-2.5-7.6-3.2-11.5.4 2.7.7 5.3 1.1 8-.7-5.6-.5-11.4-.5-17v-87.4c0-11.5.5-23 2-34.4-.4 2.7-.7 5.3-1.1 8 2.8-20.5 8.2-40.6 16.3-59.7l-3 7.2c4.5-10.5 9.7-20.7 15.7-30.5 3-4.9 6.1-9.6 9.5-14.2.8-1.1 1.5-2.1 2.3-3.2.4-.5.8-1 1.2-1.6 1.7-2.3-2.8 4-2.7 3.5.4-2.1 4.4-5.5 5.8-7.1 7.2-8.5 15-16.4 23.4-23.8 2.1-1.9 4.3-3.7 6.5-5.5 1-.8 2-1.6 3.1-2.5 3.4-2.8-6.2 4.6-1.4 1.1 4.6-3.4 9.2-6.7 14-9.7 10.9-7 22.5-13.1 34.4-18.2l-7.2 3c19.1-8 39.1-13.5 59.7-16.3-2.7.4-5.3.7-8 1.1 16.4-2.1 32.8-2 49.3-2h223.7c18.6 0 37.1-.4 55.6 2-2.7-.4-5.3-.7-8-1.1 20.5 2.8 40.6 8.2 59.7 16.3l-7.2-3c10.5 4.5 20.7 9.7 30.5 15.7 4.9 3 9.6 6.1 14.2 9.5 1.1.8 2.1 1.5 3.2 2.3.5.4 1 .8 1.6 1.2 2.3 1.7-4-2.8-3.5-2.7 2.1.4 5.5 4.4 7.1 5.8 8.5 7.2 16.4 15 23.8 23.4 1.9 2.1 3.7 4.3 5.5 6.5.8 1 1.6 2 2.5 3.1 2.8 3.4-4.6-6.2-1.1-1.4 3.4 4.6 6.7 9.2 9.7 14 7 10.9 13.1 22.5 18.2 34.4l-3-7.2c8 19.1 13.5 39.1 16.3 59.7-.4-2.7-.7-5.3-1.1-8 2.3 18 2 36.1 2 54.2v64.2c0 6.7.4 13.6-.5 20.3.4-2.7.7-5.3 1.1-8-.6 4-1.7 7.8-3.2 11.5l3-7.2c-1.2 2.8-2.6 5.5-4.3 8.1s-4 3.5 1.6-1.9c-1.1 1-2 2.3-3 3.3-.3.3-3.2 3.2-3.3 3 0 0 7.3-5.2 1.9-1.6-2.5 1.7-5.2 3.1-8.1 4.3l7.2-3c-3.7 1.5-7.6 2.5-11.5 3.2 2.7-.4 5.3-.7 8-1.1-2.3.3-4.5.4-6.9.5-15.7.2-30.7 13.6-30 30 .7 16.1 13.2 30.2 30 30 36.1-.5 70.5-26.6 76.4-63.2 2.2-13.6 1.6-27.4 1.6-41.1V833c0-12.7.3-25.5-.7-38.2-4.3-57.8-26.9-111.9-65.1-155.6-35.8-41-86-70.6-139.3-81.8-27.4-5.8-54.6-6.1-82.3-6.1H416.2c-21.2 0-42.8-.9-63.9 1.4-30.3 3.4-58.6 11.1-86.3 23.9-24.5 11.3-47.2 27.2-66.9 45.6-39.8 37.2-68.2 88.3-77.6 142-6.1 35.1-4.5 70.7-4.5 106.2v41.5c0 28.9 15.4 58.1 42.1 71 12.4 6 25.3 8.8 39.1 8.8h630.4c15.7 0 30.7-13.8 30-30-.6-16.3-13-30-29.9-30" />
                        </svg>
                    </button>

                    <!-- User dropdown menu -->
                    <div
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border">
                        <div class="py-1">
                            @auth
                                <!-- Authenticated user menu -->
                                <a href="{{ route('profile') }}"
                                    class="block px-4 py-2 text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                    Profile
                                </a>
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                    Dashboard
                                </a>
                                <a href="{{ route('trackOrder') }}"
                                    class="block px-4 py-2 text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                    Track Order
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                        Logout
                                    </button>
                                </form>
                            @else
                                <!-- Guest user menu -->
                                <a href="{{ route('login') }}"
                                    class="block px-4 py-2 text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                    Sign In
                                </a>
                                <a href="{{ route('register') }}"
                                    class="block px-4 py-2 text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                    Sign Up
                                </a>
                                <hr class="my-1">
                                <a href="{{ route('trackOrder') }}"
                                    class="block px-4 py-2 text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                    Track Order
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Cart Icon Button -->
                <button id="cart-toggle" class="text-gray-600 hover:text-primary p-2 transition-all duration-300">
                    <svg class="w-6 h-6" id="Layer_1" enable-background="new 0 0 32 32" viewBox="0 0 32 32"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="_01">
                            <g>
                                <path
                                    d="m23.8 30h-15.6c-3.3 0-6-2.7-6-6v-.2l.6-16c.1-3.3 2.8-5.8 6-5.8h14.4c3.2 0 5.9 2.5 6 5.8l.6 16c.1 1.6-.5 3.1-1.6 4.3s-2.6 1.9-4.2 1.9c0 0-.1 0-.2 0zm-15-26c-2.2 0-3.9 1.7-4 3.8l-.6 16.2c0 2.2 1.8 4 4 4h15.8c1.1 0 2.1-.5 2.8-1.3s1.1-1.8 1.1-2.9l-.6-16c-.1-2.2-1.8-3.8-4-3.8z" />
                            </g>
                            <g>
                                <path
                                    d="m16 14c-3.9 0-7-3.1-7-7 0-.6.4-1 1-1s1 .4 1 1c0 2.8 2.2 5 5 5s5-2.2 5-5c0-.6.4-1 1-1s1 .4 1 1c0 3.9-3.1 7-7 7z" />
                            </g>
                        </g>
                    </svg>
                </button>

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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
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
