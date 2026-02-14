<!-- resources/views/components/navbar.blade.php -->
<nav class="bg-white fixed top-0 left-0 right-0 z-50 font-cambay border-b gsap-navbar">
    <div class="max-w-8xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">

            <!-- Logo on the left -->
            <div class="flex-shrink-0 gsap-nav-logo">
                <a href="{{ url('/') }}" aria-label="Home" class="inline-block" title="Tycoon Hi-Tech Park">
                    <img src="{{ asset('images/bk-logo.png') }}" alt="BK Logo" class="h-6 md:h-5 xl:h-7 2xl:h-8 w-auto">
                </a>
            </div>

            <!-- Centered navigation links -->
            <div class="hidden lg:flex items-center justify-start flex-1 pl-4 gsap-nav-links">
                <div class="flex md:space-x-1 2xl:space-x-3">
                    @foreach ($navigation as $item)
                        @if (isset($item['children']) && count($item['children']) > 0)
                            <!-- Parent link with three-level dropdown -->
                            <div class="relative group">
                                <button
                                    class="text-gray-700 hover:text-primary md:px-1 md:py-2 xl:px-3 rounded-md text-base md:text-sm {{ app()->isLocale('bn') ? 'font-bangla' : 'xl:text-base font-inter' }} font-semibold flex items-center">
                                    {{ $item['name'] }}
                                    <svg class="md:ml-0 xl:ml-1 w-2.5 h-2.5 xl:w-5 xl:h-5 transition-transform duration-200 group-hover:rotate-180"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- First Level Dropdown -->
                                <div
                                    class="absolute left-0 top-full mt-2 w-96 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border border-gray-200">
                                    <div class="p-4">
                                        <div class="grid grid-cols-2 gap-6">
                                            @foreach ($item['children'] as $child)
                                                <div class="space-y-2">
                                                    <!-- Second Level Title -->
                                                    <a href="{{ $child['url'] }}"
                                                        class="block font-semibold text-gray-900 hover:text-primary text-base md:text-sm xl:text-sm font-inter mb-3 pb-2 border-b border-gray-100">
                                                        {{ $child['name'] }}
                                                    </a>

                                                    <!-- Third Level Links -->
                                                    @if (isset($child['children']) && count($child['children']) > 0)
                                                        <div class="space-y-2 ml-2">
                                                            @foreach ($child['children'] as $grandchild)
                                                                <a href="{{ $grandchild['url'] }}"
                                                                    class="block text-gray-600 hover:text-primary text-xs font-inter hover:translate-x-1 transition-transform duration-200">
                                                                    {{ $grandchild['name'] }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- View All Link -->
                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                            <a href="{{ $item['url'] }}"
                                                class="flex items-center justify-center text-primary hover:text-primary-dark font-medium text-sm font-inter">
                                                <span>View All {{ $item['name'] }}</span>
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Single link -->
                            <a href="{{ $item['url'] }}"
                                class="text-gray-700 hover:text-primary md:px-1 md:py-2 xl:px-3 rounded-md text-base md:text-sm {{ app()->isLocale('bn') ? 'font-bangla' : 'xl:text-base font-inter' }} font-semibold transition-colors duration-200">
                                {{ $item['name'] }}
                            </a>
                        @endif
                    @endforeach
                    <!-- Single link -->
                    <a href="{{ route('categories.index') }}"
                        class="text-gray-700 hover:text-primary md:px-1 md:py-2 xl:px-3 rounded-md text-base md:text-sm {{ app()->isLocale('bn') ? 'font-bangla' : 'xl:text-base font-inter' }} font-semibold transition-colors duration-200">
                        {{ __('navbar.all-categories') }}
                    </a>
                    <a href="/catalog"
                        class="text-gray-700 hover:text-primary md:px-1 md:py-2 xl:px-3 rounded-md text-base md:text-sm {{ app()->isLocale('bn') ? 'font-bangla' : 'xl:text-base font-inter' }} font-semibold transition-colors duration-200">
                        {{ __('navbar.catalog') }}
                    </a>
                </div>
            </div>

            <!-- Right side icons -->
            <div class="flex items-center space-x-1">

                <div class="relative group hidden md:block">
                    <button
                        class="flex items-center space-x-2 md:space-x-0 xl:space-x-1 text-gray-600 hover:text-primary p-1 rounded-md transition-colors duration-200"
                        title="Change Language">
                        {{-- <span class="text-base font-semibold">EN</span> --}}
                        <span><svg class="w-5 h-5 md:w-4 md:h-4 xl:w-5 xl:h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                </path>
                            </svg></span>
                        {{-- <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg> --}}
                    </button>

                    <!-- Language Dropdown -->
                    <div
                        class="absolute right-0 mt-2 w-24 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-200">
                        <div class="py-2">
                            <button onclick="location.href='{{ url('language/en') }}'"
                                class="w-full px-4 py-2 text-base md:text-sm xl:text-base {{ app()->getLocale() == 'en' ? 'bg-primary/60 text-white' : 'text-gray-700' }} hover:bg-accent/70 hover:text-white">
                                English
                            </button>
                            <button onclick="location.href='{{ url('language/bn') }}'"
                                class="w-full px-4 py-2 text-base md:text-sm xl:text-base {{ app()->getLocale() == 'bn' ? 'bg-primary/60 text-white' : 'text-gray-700' }} hover:bg-accent/70 hover:text-white">
                                বাংলা
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Search icon -->
                <button id="search-toggle"
                    class="text-gray-600 hover:text-primary p-1 transition-all duration-300 hover:rotate-90"
                    title="Click to Search">
                    <svg class="w-5 h-5 md:w-4 md:h-4 xl:w-5 xl:h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- User icon -->
                <div class="relative group">
                    <button class="text-gray-600 hover:text-primary p-1">
                        <svg class="w-5 h-5 md:w-4 md:h-4 xl:w-5 xl:h-5" fill="currentColor" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5"
                                d="M9.667 3.5a3.532 3.532 0 1 0 0 7.063 3.532 3.532 0 0 0 0-7.063M4.636 7.032a5.032 5.032 0 1 1 10.063 0 5.032 5.032 0 0 1-10.063 0m10.8-2.564a.75.75 0 0 1 .75-.75 4.13 4.13 0 1 1-.83 8.178.75.75 0 0 1 .3-1.47q.256.052.53.053a2.63 2.63 0 1 0 0-5.261.75.75 0 0 1-.75-.75m1.001 9.34a.75.75 0 0 1 .75-.75 4.75 4.75 0 0 1 4.75 4.75v.725a1.75 1.75 0 0 1-1.75 1.75h-.877a.75.75 0 1 1 0-1.5h.877a.25.25 0 0 0 .25-.25v-.725a3.25 3.25 0 0 0-3.25-3.25.75.75 0 0 1-.75-.75M2.062 19a5.75 5.75 0 0 1 5.75-5.75h3.713a5.75 5.75 0 0 1 5.75 5.75v.25a2.75 2.75 0 0 1-2.75 2.75H4.812a2.75 2.75 0 0 1-2.75-2.75zm5.75-4.25A4.25 4.25 0 0 0 3.562 19v.25c0 .69.56 1.25 1.25 1.25h9.713c.69 0 1.25-.56 1.25-1.25V19a4.25 4.25 0 0 0-4.25-4.25z"
                                fill-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- User dropdown menu -->
                    <div
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 border">
                        <div class="py-1">
                            @auth
                                <!-- Show only for admins/moderators -->
                                @if (auth()->user()->hasAnyRole(['admin', 'moderator']))
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-base md:text-sm xl:text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                        {{ __('navbar.admin-dashboard') }}</a>
                                @endif
                                <!-- Authenticated user menu -->
                                <a href="{{ route('profile') }}"
                                    class="block px-4 py-2 text-base md:text-sm xl:text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                    {{ __('navbar.profile') }}</a>
                                </a>

                                <a href="{{ route('orders.track') }}"
                                    class="block px-4 py-2 text-base md:text-sm xl:text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                    {{ __('navbar.track-order') }}</a>
                                </a>
                                <!-- Show only for customers -->
                                @if (auth()->user()->hasRole('customer'))
                                    <a href="/orders"
                                        class="block px-4 py-2 text-base md:text-sm xl:text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                        {{ __('navbar.my-orders') }}</a>
                                @endif

                                <!-- Show only with specific permission -->
                                @if (auth()->user()->hasPermission('manage_products'))
                                    <a href="/admin/products"
                                        class="block px-4 py-2 text-base md:text-sm xl:text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                        {{ __('navbar.products-management') }}</a>
                                @endif
                                {{--  --}}
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-base md:text-sm xl:text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                        {{ __('navbar.logout') }}
                                    </button>
                                </form>
                            @else
                                <!-- Guest user menu -->
                                <a href="{{ route('login') }}"
                                    class="block px-4 py-2 text-base md:text-sm xl:text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                    {{ __('navbar.sign-in') }}
                                </a>
                                <a href="{{ route('register') }}"
                                    class="block px-4 py-2 text-base md:text-sm xl:text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                    {{ __('navbar.sign-up') }}
                                </a>
                                <hr class="my-1">
                                <a href="{{ route('orders.track') }}"
                                    class="block px-4 py-2 text-base md:text-sm xl:text-base text-gray-700 hover:bg-accent/70 hover:text-white">
                                    {{ __('navbar.track-order') }}
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Cart Icon Button -->
                <a href="{{ route('cart.index') }}"
                    class="text-gray-600 hover:text-primary p-1 transition-all duration-300 relative">
                    <svg class="w-5 h-5 md:w-4 md:h-4 xl:w-5 xl:h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span
                        class="cart-badge absolute -top-1 -right-1 bg-primary text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}">
                        {{ $cartCount ?? 0 }}
                    </span>
                </a>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-600 hover:text-primary p-1" id="mobile-menu-button">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Mobile menu (updated for three-level) -->
    <div class="lg:hidden hidden bg-white border-t" id="mobile-menu">
        <div class="px-4 py-3 space-y-1">

            @foreach ($categoriesDropdown as $item)
                @if (isset($item['children']) && count($item['children']) > 0)
                    <div class="relative">
                        <button
                            class="mobile-dropdown-toggle w-full text-left text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base font-semibold flex items-center justify-between">
                            <span>{{ $item['name'] }}</span>
                            <svg class="w-4 h-4 mobile-dropdown-arrow transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="mobile-dropdown hidden pl-4 border-l border-gray-200 ml-2">

                            @foreach ($item['children'] as $child)
                                @if (isset($child['children']) && count($child['children']) > 0)
                                    <div class="relative">
                                        <button
                                            class="mobile-subdropdown-toggle w-full text-left text-gray-600 hover:text-primary block px-3 py-2 rounded-md text-sm font-semibold flex items-center justify-between">
                                            <span>{{ $child['name'] }}</span>
                                            <svg class="w-3 h-3 mobile-subdropdown-arrow transition-transform duration-200"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div class="mobile-subdropdown hidden pl-4 border-l border-gray-200 ml-2">
                                            @foreach ($child['children'] as $grandchild)
                                                <a href="{{ $grandchild['url'] }}"
                                                    class="block px-3 py-2 text-gray-500 hover:text-primary text-xs">
                                                    {{ $grandchild['name'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ $child['url'] }}"
                                        class="block px-3 py-2 text-gray-600 hover:text-primary text-sm">
                                        {{ $child['name'] }}
                                    </a>
                                @endif
                            @endforeach

                        </div>
                    </div>
                @else
                    <a href="{{ $item['url'] }}"
                        class="text-gray-700 hover:text-primary block px-3 py-2 rounded-md text-base md:text-sm xl:text-base font-semibold">
                        {{ $item['name'] }}
                    </a>
                @endif
            @endforeach

        </div>
    </div>
</nav>

<!-- Full Page Search Modal -->
<div id="search-modal"
    class="fixed top-16 !left-1/2 transform -translate-x-1/2 w-full max-w-3xl bg-white shadow-2xl rounded-b-lg z-50 hidden border border-gray-200">

    <!-- Modal content container -->
    <div class="p-4">
        <!-- Close button -->
        <button id="search-close"
            class="absolute top-2 right-2 p-1 text-gray-500 bg-gray-200 hover:bg-accent/45 rounded-full hover:text-primary transition-transform duration-300 hover:rotate-90 z-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>

        <!-- Search header with categories dropdown -->
        <div class="mb-3">
            <!-- Categories dropdown -->
            <div class="relative group w-full overflow-visible">
                <button id="categories-toggle"
                    class="hidden md:flex items-center space-x-1 px-3 py-1.5 bg-gray-50 hover:bg-gray-100 rounded-md text-sm font-medium text-gray-700 transition-colors duration-200 border border-gray-200">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                    <span>{{ __('navbar.all-categories') }}</span>
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:-rotate-90" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>

                <!-- Categories dropdown menu -->
                <div id="categories-dropdown"
                    class="absolute left-0 top-full mt-1 w-[720px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 bg-white rounded-md shadow-lg border border-gray-200">

                    <div class="grid grid-cols-3 min-h-[300px]">

                        <!-- Level 1 -->
                        <div class="border-r border-gray-100">
                            @foreach ($categoriesDropdown as $category)
                                <div class="group/level1 relative">
                                    <button
                                        class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary flex justify-between items-center category-level1"
                                        data-id="{{ $category['id'] }}">
                                        <span class="truncate">{{ $category['name'] }}</span>

                                        @if ($category['has_children'])
                                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:-rotate-90"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7">
                                                </path>
                                            </svg>
                                        @endif
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <!-- Level 2 -->
                        <div id="level2-container" class="border-r border-gray-100 hidden"></div>

                        <!-- Level 3 -->
                        <div id="level3-container" class="hidden"></div>

                    </div>
                </div>

            </div>
        </div>

        <!-- Search input -->
        <div class="relative">
            <form action="{{ route('search') }}" method="GET" class="relative">
                <input type="text" name="q" placeholder="{{ __('navbar.search-placeholder') }}"
                    autocomplete="off"
                    class="w-full py-3 px-4 text-base md:text-sm xl:text-base bg-gray-50 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-300 pr-12"
                    id="search-input">
                <button type="submit"
                    class="absolute right-0 top-0 h-full px-4 text-gray-400 hover:text-primary transition-colors duration-200">
                    <svg class="w-5 h-5 md:w-4 md:h-4 xl:w-5 xl:h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Popular searches (AJAX loaded) -->
        <div id="popular-searches" class="px-3 py-2 hidden">
            <p class="text-xs font-medium text-gray-500 mb-2">{{ __('navbar.popular-searches') }}</p>

            <!-- Loading -->
            <div id="popular-loading" class="hidden flex items-center space-x-2 px-2 py-2">
                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-primary"></div>
                <span class="text-sm text-gray-600">{{ __('navbar.loading-popular-searches') }}</span>
            </div>

            <!-- Results -->
            <div id="popular-results" class="flex flex-wrap gap-2"></div>
        </div>

        <!-- Search suggestions dropdown -->
        <div id="search-suggestions"
            class="mt-2 bg-white rounded-lg shadow-lg border border-gray-200 hidden max-h-80 overflow-y-auto">
            <div class="p-2">
                <!-- Loading state -->
                <div id="search-loading" class="hidden px-3 py-2">
                    <div class="flex items-center space-x-2">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-primary"></div>
                        <span class="text-sm text-gray-600">Searching...</span>
                    </div>
                </div>

                <!-- No results -->
                <div id="search-empty" class="hidden px-3 py-2 text-sm text-gray-500">
                    No results found. Try different keywords.
                </div>

                <!-- Suggestions list -->
                <div id="search-results" class="mt-2">
                    <!-- Results will be populated here dynamically -->
                </div>

                <!-- View all results -->
                <div id="search-view-all" class="hidden border-t border-gray-100 mt-2 pt-2">
                    <a href="#" id="search-view-all-link"
                        class="flex items-center justify-center text-primary hover:text-primary-dark font-medium text-sm py-2 px-3 bg-gray-50 hover:bg-gray-100 rounded transition-colors duration-200">
                        <span>View all results</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileDropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
            const mobileSubdropdownToggles = document.querySelectorAll('.mobile-subdropdown-toggle');

            // Search modal elements
            const searchToggle = document.getElementById('search-toggle');
            const searchModal = document.getElementById('search-modal');
            const searchClose = document.getElementById('search-close');
            const searchInput = document.getElementById('search-input');

            const searchSuggestions = document.getElementById('search-suggestions');
            const searchResults = document.getElementById('search-results');
            const searchLoading = document.getElementById('search-loading');
            const searchEmpty = document.getElementById('search-empty');
            const searchViewAll = document.getElementById('search-view-all');
            const searchViewAllLink = document.getElementById('search-view-all-link');
            const searchForm = searchModal.querySelector('form');

            const popularContainer = document.getElementById('popular-searches');
            const popularResults = document.getElementById('popular-results');
            const popularLoading = document.getElementById('popular-loading');

            let popularLoaded = false;
            let popularAbortController = null;

            // Search variables
            let searchTimeout = null;
            let currentSearchQuery = '';
            const DEBOUNCE_DELAY = 300;

            // Mobile menu functionality
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            mobileDropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const dropdown = this.nextElementSibling;
                    const arrow = this.querySelector('.mobile-dropdown-arrow');
                    dropdown.classList.toggle('hidden');
                    arrow.classList.toggle('rotate-180');
                });
            });

            mobileSubdropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const dropdown = this.nextElementSibling;
                    const arrow = this.querySelector('.mobile-subdropdown-arrow');
                    dropdown.classList.toggle('hidden');
                    arrow.classList.toggle('rotate-180');
                });
            });

            // Search modal functionality
            searchToggle.addEventListener('click', function() {
                openSearchModal();
            });

            searchClose.addEventListener('click', function() {
                closeSearchModal();
            });

            // Search input events
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.trim();
                currentSearchQuery = query;

                if (query.length >= 2) {
                    popularContainer.classList.add('hidden');
                } else {
                    popularContainer.classList.remove('hidden');
                    hideSuggestions();
                    return;
                }

                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    fetchSearchSuggestions(query);
                }, DEBOUNCE_DELAY);
            });


            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    hideSuggestions();
                }
            });

            // Form submission
            searchForm.addEventListener('submit', function(e) {
                if (currentSearchQuery.trim() === '') {
                    e.preventDefault();
                    return;
                }

                // If user submits form, close modal and clear input
                setTimeout(() => {
                    closeSearchModal();
                }, 100);
            });

            // Functions
            function openSearchModal() {
                searchModal.classList.remove('hidden');

                // Position modal below search icon in navbar
                const searchToggleRect = searchToggle.getBoundingClientRect();
                const navbar = document.querySelector('nav');
                if (navbar) {
                    const navbarRect = navbar.getBoundingClientRect();
                }

                // Calculate position relative to centered navigation area
                const centeredNav = document.querySelector('.gsap-nav-links');
                if (centeredNav) {
                    const centeredNavRect = centeredNav.getBoundingClientRect();
                    // Position modal at the center of navigation area
                    const modalLeft = centeredNavRect.left + (centeredNavRect.width / 2);
                    searchModal.style.left = `${modalLeft}px`;
                    searchModal.style.transform = 'translateX(-50%)';
                }

                document.body.style.overflow = 'hidden';

                setTimeout(() => {
                    searchInput.focus();
                }, 100);

                // Load popular searches
                fetchPopularSearches();
            }

            function closeSearchModal() {
                searchModal.classList.add('hidden');
                document.body.style.overflow = '';
                searchInput.value = '';
                hideSuggestions();
                // Clear popular search data
                clearPopularSearches();
            }

            function hideSuggestions() {
                searchSuggestions.classList.add('hidden');
                searchLoading.classList.add('hidden');
                searchEmpty.classList.add('hidden');
                searchViewAll.classList.add('hidden');
                searchResults.innerHTML = '';
                popularContainer.classList.add('hidden');
            }


            function showSuggestions() {
                searchSuggestions.classList.remove('hidden');
            }

            function fetchSearchSuggestions(query) {
                if (query.length < 2) return;

                // Show loading state
                searchLoading.classList.remove('hidden');
                searchEmpty.classList.add('hidden');
                searchViewAll.classList.add('hidden');
                searchResults.innerHTML = '';
                showSuggestions();

                // Add a timeout to prevent hanging requests
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 5000);
                fetch(`{{ route('search.suggest') }}?q=${encodeURIComponent(query)}`, {
                        signal: controller.signal,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        clearTimeout(timeoutId);

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        searchLoading.classList.add('hidden');

                        // Check if we got an error response
                        if (data.error) {
                            console.error('Server error:', data.message);
                            searchEmpty.classList.remove('hidden');
                            searchEmpty.textContent = 'Search temporarily unavailable';
                            flash('Search is currently unavailable. Please try again later.', 'error');
                            return;
                        }

                        if (data.length === 0) {
                            searchEmpty.classList.remove('hidden');
                            searchEmpty.textContent = 'No results found';
                            flash('No results found for your search. Please try different keywords.',
                                'warning');
                            searchViewAll.classList.add('hidden');
                            return;
                        }

                        displaySearchResults(data, query);
                    })
                    .catch(error => {
                        clearTimeout(timeoutId);
                        console.error('Error fetching search suggestions:', error);
                        searchLoading.classList.add('hidden');
                        searchEmpty.classList.remove('hidden');

                        if (error.name === 'AbortError') {
                            searchEmpty.textContent = 'Request timed out';
                            flash('Search request timed out. Please check your connection and try again.',
                                'error');
                        } else {
                            searchEmpty.textContent = 'Error loading suggestions';
                            flash('An error occurred while fetching search suggestions. Please try again later.',
                                'error');
                        }
                    });
            }

            function displaySearchResults(results, query) {
                searchResults.innerHTML = '';

                results.forEach(result => {
                    const resultElement = createResultElement(result);
                    searchResults.appendChild(resultElement);
                });

                // Update view all link
                if (results.length > 0) {
                    searchViewAllLink.href = `{{ route('search') }}?q=${encodeURIComponent(query)}`;
                    searchViewAll.classList.remove('hidden');
                } else {
                    searchViewAll.classList.add('hidden');
                }

                showSuggestions();
            }

            function createResultElement(result) {
                const div = document.createElement('div');
                div.className =
                    'search-result-item px-4 py-3 hover:bg-gray-50 cursor-pointer transition-colors duration-200 border-b border-gray-100 last:border-b-0';
                div.setAttribute('data-url', result.url);

                if (result.type === 'product') {
                    div.innerHTML = `
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded overflow-hidden">
                                ${result.image ? `<img src="${result.image}" alt="${result.name}" class="w-full h-full object-cover">` : ''}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 mb-1">
                                    ${result.highlight}
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-primary font-semibold">
                                        <span class="font-bengali">৳</span>${result.price}
                                    </span>
                                    ${result.in_stock ? 
                                        '<span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded">In Stock</span>' : 
                                        '<span class="text-xs text-red-600 bg-red-50 px-2 py-1 rounded">Out of Stock</span>'}
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    div.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-blue-50 rounded">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                            </div>
                            <div class="text-sm font-medium text-gray-900">
                                ${result.highlight}
                                <span class="text-xs text-gray-500 ml-2">Category</span>
                            </div>
                        </div>
                    `;
                }

                // Add click handler
                div.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('data-url');
                    if (url) {
                        window.location.href = url;
                        closeSearchModal();
                    }
                });

                return div;
            }

            function fetchPopularSearches() {
                if (popularLoaded) return;

                popularContainer.classList.remove('hidden');
                popularLoading.classList.remove('hidden');
                popularResults.innerHTML = '';

                if (popularAbortController) {
                    popularAbortController.abort();
                }

                popularAbortController = new AbortController();

                fetch(`{{ route('search.popular') }}`, {
                        signal: popularAbortController.signal,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        popularLoading.classList.add('hidden');

                        if (!data || data.length === 0) {
                            popularResults.innerHTML =
                                `<p class="text-sm text-gray-500">No popular searches found.</p>`;
                            return;
                        }

                        data.forEach(term => {
                            const el = document.createElement('a');
                            el.href = `{{ route('search') }}?q=${encodeURIComponent(term.term)}`;
                            el.className =
                                'px-3 py-1.5 bg-gray-50 hover:bg-gray-100 rounded-full text-sm text-gray-700 transition-colors duration-200';

                            el.innerHTML = `<span class="font-medium">${term.term}</span>`;

                            popularResults.appendChild(el);
                        });

                        popularLoaded = true;
                    })
                    .catch(err => {
                        console.error('Popular search error:', err);
                        popularLoading.classList.add('hidden');
                        popularResults.innerHTML =
                            `<p class="text-sm text-red-500">Failed to load popular searches.</p>`;
                    });
            }

            function clearPopularSearches() {
                if (popularAbortController) {
                    popularAbortController.abort();
                    popularAbortController = null;
                }

                popularResults.innerHTML = '';
                popularContainer.classList.add('hidden');
            }


            // Close modal on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (!searchModal.classList.contains('hidden')) {
                        closeSearchModal();
                    }
                }
            });

            document.addEventListener('click', function(e) {
                if (!searchModal.contains(e.target) && !searchToggle.contains(e.target)) {
                    closeSearchModal();
                }
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const categoriesData = @json($categoriesDropdown);
            const level2Container = document.getElementById('level2-container');
            const level3Container = document.getElementById('level3-container');

            const categoryDropdown = document.getElementById('categories-dropdown');

            categoryDropdown.addEventListener('mouseleave', () => {
                level2Container.classList.add('hidden');
                level3Container.classList.add('hidden');
            });

            document.querySelectorAll('.category-level1').forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    const id = this.dataset.id;
                    const category = categoriesData.find(c => c.id == id);

                    if (!category || !category.children || category.children.length === 0) {
                        level2Container.classList.add('hidden');
                        level3Container.classList.add('hidden');
                        return;
                    }

                    renderLevel2(category.children);
                });
            });

            function renderLevel2(children) {
                level2Container.innerHTML = '';
                level2Container.classList.remove('hidden');
                level3Container.classList.add('hidden');

                children.forEach(child => {
                    const btn = document.createElement('button');
                    btn.className =
                        'w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary flex justify-between items-center';
                    btn.innerHTML = `
                <span class="truncate">${child.name}</span>
                ${child.has_children ? '<svg class="w-4 h-4 transition-transform duration-200 group-hover:-rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>' : ''}
            `;

                    btn.addEventListener('mouseenter', () => {
                        if (child.children && child.children.length) {
                            renderLevel3(child.children);
                        } else {
                            level3Container.classList.add('hidden');
                        }
                    });

                    level2Container.appendChild(btn);
                });
            }

            function renderLevel3(children) {
                level3Container.innerHTML = '';
                level3Container.classList.remove('hidden');

                children.forEach(grandchild => {
                    const link = document.createElement('a');
                    link.href = grandchild.url;
                    link.className =
                        'block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary truncate';
                    link.textContent = grandchild.name;

                    level3Container.appendChild(link);
                });
            }
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            const navbar = document.querySelector('.gsap-navbar');
            if (!navbar) return;

            const logo = document.querySelector('.gsap-nav-logo');
            const links = document.querySelectorAll('.gsap-nav-links > div > *');

            // 🔒 Safety reset
            gsap.set([logo, links], {
                opacity: 1,
                y: 0,
                clearProps: 'all'
            });

            const tl = gsap.timeline({
                defaults: {
                    ease: 'power3.out'
                }
            });

            tl.from(navbar, {
                    y: -20,
                    opacity: 0,
                    duration: 0.6
                })
                .from(logo, {
                    opacity: 0,
                    scale: 0.95,
                    duration: 0.4
                }, '-=0.3')
                .from(links, {
                    opacity: 0,
                    y: 10,
                    duration: 0.4,
                    stagger: 0.05
                }, '-=0.25');
        });
    </script>
@endpush
