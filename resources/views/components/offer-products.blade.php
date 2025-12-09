<!-- Offers Section -->
<section class="relative w-full py-12 md:py-16 overflow-hidden">
    {{-- Top Blur/Shadow Effect for smooth transition from previous section --}}
    <div class="absolute top-0 left-0 right-0 h-10 bg-gradient-to-b from-gray-50 via-cyan-400/20 to-transparent z-20">
    </div>
    <div class="absolute -bottom-8 left-0 right-0 h-12 bg-gradient-to-b from-cyan-600/20 via-white  to-transparent z-20">
    </div>

    @php
        // Ensure data exists with proper fallbacks
        $offerData = $offerData ?? [];
        $offerProducts = $offerProducts ?? [];

        $backgroundType = $offerData['background_type'] ?? 'image'; // 'image' or 'video'
        $backgroundImage = $offerData['background_image'] ?? 'images/offers/bg.jpg';
        $backgroundVideo = $offerData['background_video'] ?? 'videos/offers-bg.mp4';
        $offerTitle = $offerData['title'] ?? 'Winter Offer';
        $offerSubtitle = $offerData['subtitle'] ?? 'Enjoy amazing discounts!';
        $mainBannerImage = $offerData['main_banner_image'] ?? 'images/offers/main-banner.jpg';
        $timerEnabled = $offerData['timer_enabled'] ?? true;
        $timerEndDate = $offerData['timer_end_date'] ?? now()->addDays(7)->format('Y-m-d H:i:s');
        $viewAllLink = $offerData['view_all_link'] ?? route('products.offers');

        // Fix route if it's just a string
if (!str_contains($viewAllLink, '://') && !str_starts_with($viewAllLink, '/')) {
    try {
        $viewAllLink = route($viewAllLink);
    } catch (\Exception $e) {
        $viewAllLink = '#';
            }
        }
    @endphp

    {{-- Full Width Background Container --}}
    <div class="absolute inset-0 w-full h-full overflow-hidden">
        {{-- <div class="max-w-8xl mx-auto h-full"> --}}
        {{-- Background Image / Video constrained to 8xl --}}
        <div class="relative w-full h-full">
            @if ($backgroundType === 'video' && $backgroundVideo && file_exists(public_path($backgroundVideo)))
                <video autoplay loop muted playsinline class="w-full h-full object-cover">
                    <source src="{{ asset($backgroundVideo) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @else
                <img src="{{ asset($backgroundImage) }}" class="w-full h-full object-cover"
                    alt="{{ $offerTitle }} Background" loading="lazy"
                    onerror="this.src='{{ asset('images/offers/default-bg.jpg') }}'">
            @endif
        </div>
        {{-- </div> --}}
    </div>

    {{-- Gradient Overlay for better readability --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/40 to-black/20"></div>

    {{-- CONTENT constrained to 8xl --}}
    <div class="relative max-w-8xl mx-auto overflow-hidden">
        {{-- TOP BANNER AREA --}}
        <div class="w-full relative mb-4 overflow-hidden rounded-xl">
            {{-- Background Image (Full Width + Full Height) --}}
            @if ($mainBannerImage)
                <div class="absolute inset-0">
                    <img src="{{ asset($mainBannerImage) }}" alt="{{ $offerTitle }} Banner"
                        class="w-full h-full object-cover" loading="lazy"
                        onerror="this.src='{{ asset('images/offers/default-banner.jpg') }}'">
                </div>

                {{-- Optional Overlay for readability --}}
                {{-- <div class="absolute inset-0 bg-gray-50/10 backdrop-blur-[1px]"></div> --}}
            @endif

            {{-- Content on top of the image --}}
            <div class="relative z-10 p-4 md:p-6">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-4">

                    {{-- Left: Title & Info --}}
                    <div class="text-center lg:text-left">
                        <h2 class="text-white text-2xl md:text-3xl font-bold font-quantico mb-2">
                            {{ $offerTitle }}
                        </h2>
                        <p class="text-white/90 text-base md:text-lg font-cambay max-w-2xl">
                            {{ $offerSubtitle }}
                        </p>
                    </div>

                    {{-- Right: Timer --}}
                    @if ($timerEnabled)
                        <div class="flex-shrink-0">
                            <div class="backdrop-blur-md bg-white/10 border border-white/20 px-6 py-3 rounded-xl">
                                <div class="text-xs tracking-wide text-white/80 font-cambay mb-1 text-center">
                                    OFFER ENDS IN
                                </div>

                                <div id="offer-timer"
                                    class="flex items-center justify-center gap-3 text-white font-quantico text-lg md:text-xl"
                                    data-end-date="{{ $timerEndDate }}">

                                    {{-- Days --}}
                                    <div class="flex items-center gap-1">
                                        <span class="timer-days font-bold"></span>
                                        <span class="text-[11px] opacity-70">d</span>
                                    </div>

                                    {{-- Divider --}}
                                    <div class="w-1 h-1 bg-white/40 rounded-full"></div>

                                    {{-- Hours --}}
                                    <div class="flex items-center gap-1">
                                        <span class="timer-hours font-bold"></span>
                                        <span class="text-[11px] opacity-70">h</span>
                                    </div>

                                    <div class="w-1 h-1 bg-white/40 rounded-full"></div>

                                    {{-- Minutes --}}
                                    <div class="flex items-center gap-1">
                                        <span class="timer-minutes font-bold"></span>
                                        <span class="text-[11px] opacity-70">m</span>
                                    </div>

                                    <div class="w-1 h-1 bg-white/40 rounded-full"></div>

                                    {{-- Seconds --}}
                                    <div class="flex items-center gap-1">
                                        <span class="timer-seconds font-bold"></span>
                                        <span class="text-[11px] opacity-70">s</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Force minimum banner height --}}
                <div class="h-[200px] md:h-[250px]"></div>
            </div>
        </div>

        {{-- PRODUCT SLIDER SECTION --}}
        @if (count($offerProducts) > 0)
            <div class="mt-4">
                {{-- Header Row --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-4">
                    <div>
                        <h3 class="text-white text-2xl md:text-3xl font-bold font-quantico">
                            Special Offer Products
                        </h3>
                        <p class="text-white/80 text-sm md:text-base font-cambay mt-1">
                            {{ count($offerProducts) }} products on discount
                        </p>
                    </div>

                    <a href="{{ $viewAllLink }}"
                        class="inline-flex items-center px-5 py-2.5 bg-white text-gray-900 font-semibold rounded-md ">
                        View All
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                {{-- Swiper Slider --}}
                <div class="swiper offer-products-swiper relative pb-10">
                    <div class="swiper-wrapper">
                        @foreach ($offerProducts as $product)
                            @php
                                $productSlug = $product['slug'] ?? '#';
                                $productId = $product['id'] ?? '#';
                                $productName = $product['name'] ?? 'Product Name';
                                $primaryImage = $product['images'][0] ?? 'images/placeholder.jpg';
                                $secondaryImage = $product['images'][1] ?? null;
                                $discountedPrice = $product['discounted_price'] ?? ($product['original_price'] ?? 0);
                                $originalPrice = $product['original_price'] ?? 0;
                                $discountPercentage = $product['discount_percentage'] ?? 0;
                                $inStock = $product['in_stock'] ?? true;
                                $isNew = $product['is_new'] ?? false;

                                // Ensure images exist
                                $primaryImageSrc = asset($primaryImage);
                                $secondaryImageSrc = $secondaryImage ? asset($secondaryImage) : $primaryImageSrc;
                            @endphp

                            <div class="swiper-slide !h-auto">
                                <div
                                    class="group relative h-full bg-white border border-gray-200 hover:shadow-lg transition-all duration-300 flex flex-col rounded-xl overflow-hidden">
                                    <!-- Image Section -->
                                    <a href="{{ route('product.show', $productSlug) }}">
                                        <div class="w-full aspect-square bg-white overflow-hidden relative">
                                            <img src="{{ $primaryImageSrc }}"
                                                class="absolute inset-0 w-full h-full object-contain transition-opacity duration-300 group-hover:opacity-0"
                                                alt="{{ $productName }}" loading="lazy"
                                                onerror="this.src='{{ asset('images/products/default.png') }}'">
                                            <img src="{{ $secondaryImageSrc }}"
                                                class="absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-300 group-hover:opacity-100 {{ !$secondaryImage ? 'group-hover:scale-105' : '' }}"
                                                alt="{{ $productName }} - Alternate View" loading="lazy"
                                                onerror="this.src='{{ $primaryImageSrc }}'">
                                        </div>
                                    </a>

                                    <!-- Stock Badge -->
                                    @if (!$inStock)
                                        <div
                                            class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 z-20 font-quantico">
                                            OUT OF STOCK
                                        </div>
                                    @elseif($isNew)
                                        <div
                                            class="absolute top-2 right-2 bg-accent text-white text-xs font-bold px-2 py-1 z-20 font-quantico">
                                            NEW
                                        </div>
                                    @endif

                                    <!-- Buy Now Overlay -->
                                    @if ($inStock)
                                        <div
                                            class="absolute bottom-0 left-0 right-0 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-30">
                                            <div class="bg-gradient-to-t from-black/80 to-transparent pt-6 pb-3 px-4">
                                                <a href="{{ route('checkout.process', $productId) }}"
                                                    class="block w-full bg-primary hover:bg-primary-dark text-white text-center font-semibold py-2.5 px-4 transition-colors duration-200 shadow-lg hover:shadow-xl transform">
                                                    <span class="flex items-center justify-center font-quantico">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                        </svg>
                                                        Buy Now
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Product Info -->
                                    <div class="p-4 border-t border-gray-100 flex-grow flex flex-col">
                                        <a href="{{ route('product.show', $productSlug) }}"
                                            class="font-medium font-quantico text-gray-900 text-sm mb-3 line-clamp-2 group-hover:text-primary transition-colors duration-200 flex-grow">
                                            {{ $productName }}
                                        </a>

                                        <!-- Price + Wishlist -->
                                        <div class="mt-auto">
                                            <div class="flex items-center justify-between">
                                                <span class="text-lg font-bold font-quantico text-gray-900">
                                                    TK{{ number_format($discountedPrice, 0) }}
                                                </span>

                                                @if (!$inStock)
                                                    <button
                                                        class="wishlist-btn p-1 hover:text-red-500 transition-colors duration-200"
                                                        title="Add to Wishlist">
                                                        <svg class="w-5 h-5 text-gray-400 hover:text-red-500"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>

                                            @if ($discountPercentage > 0)
                                                <div class="flex items-center space-x-2 mt-2 font-inter">
                                                    <span
                                                        class="text-xs bg-accent/10 text-accent font-semibold px-2 py-1">
                                                        Save {{ $discountPercentage }}%
                                                    </span>
                                                    <span class="text-xs text-gray-500 line-through">
                                                        TK{{ number_format($originalPrice, 0) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Swiper Navigation --}}
                    {{-- @if (count($offerProducts) > 1)
                        <div
                            class="swiper-button-next !text-white !bg-black/30 backdrop-blur-sm !w-10 !h-10 md:!w-12 md:!h-12 !rounded-full after:!text-lg hover:!bg-black/50">
                        </div>
                        <div
                            class="swiper-button-prev !text-white !bg-black/30 backdrop-blur-sm !w-10 !h-10 md:!w-12 md:!h-12 !rounded-full after:!text-lg hover:!bg-black/50">
                        </div>
                    @endif --}}

                </div>
            </div>
        @else
            {{-- No Products Message --}}
            <div class="text-center py-12 bg-white/10 backdrop-blur-sm rounded-2xl border border-white/20">
                <div class="text-5xl mb-4">😔</div>
                <h3 class="text-white text-xl font-semibold mb-2">No Offers Available</h3>
                <p class="text-white/80">Check back later for amazing deals!</p>
            </div>
        @endif
    </div>
</section>

@push('scripts')
    <script>
        // Initialize Offer Products Swiper
        document.addEventListener('DOMContentLoaded', function() {
            const offerSwiperElement = document.querySelector('.offer-products-swiper');
            if (offerSwiperElement) {
                const productCount = {{ count($offerProducts) }};
                const swiperConfig = {
                    slidesPerView: 1.3,
                    spaceBetween: 16,
                    loop: productCount > 1,
                    grabCursor: true,
                    speed: 500,
                    breakpoints: {
                        480: {
                            slidesPerView: Math.min(2.2, productCount),
                            spaceBetween: 16,
                        },
                        640: {
                            slidesPerView: Math.min(2.5, productCount),
                            spaceBetween: 18,
                        },
                        768: {
                            slidesPerView: Math.min(3, productCount),
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: Math.min(4, productCount),
                            spaceBetween: 24,
                        },
                        1280: {
                            slidesPerView: Math.min(5, productCount),
                            spaceBetween: 24,
                        },
                    }
                };

                // Add navigation if more than 1 product
                if (productCount > 1) {
                    swiperConfig.navigation = {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    };
                    swiperConfig.pagination = {
                        el: '.swiper-pagination',
                        clickable: true,
                        dynamicBullets: true,
                    };
                }

                try {
                    new Swiper(offerSwiperElement, swiperConfig);
                } catch (error) {
                    console.error('Swiper initialization error:', error);
                }
            }

            // Countdown Timer Functionality
            const timerElement = document.getElementById('offer-timer');
            if (timerElement) {
                const endDateString = timerElement.dataset.endDate;
                if (endDateString) {
                    const endDate = new Date(endDateString).getTime();

                    function updateTimer() {
                        const now = new Date().getTime();
                        const timeLeft = endDate - now;

                        if (timeLeft < 0) {
                            timerElement.innerHTML = '<div class="text-sm font-medium">Offer Expired</div>';
                            return;
                        }

                        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        const daysElement = timerElement.querySelector('.timer-days');
                        const hoursElement = timerElement.querySelector('.timer-hours');
                        const minutesElement = timerElement.querySelector('.timer-minutes');
                        const secondsElement = timerElement.querySelector('.timer-seconds');

                        if (daysElement) daysElement.textContent = days.toString().padStart(2, '0');
                        if (hoursElement) hoursElement.textContent = hours.toString().padStart(2, '0');
                        if (minutesElement) minutesElement.textContent = minutes.toString().padStart(2, '0');
                        if (secondsElement) secondsElement.textContent = seconds.toString().padStart(2, '0');
                    }

                    // Update immediately and then every second
                    updateTimer();
                    const timerInterval = setInterval(updateTimer, 1000);

                    // Clean up on page unload
                    window.addEventListener('beforeunload', () => {
                        clearInterval(timerInterval);
                    });
                }
            }

            // Wishlist button functionality
            document.querySelectorAll('.wishlist-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Here you can add your wishlist AJAX functionality
                    console.log('Add to wishlist clicked');
                    // Example: addToWishlist(productId);
                });
            });
        });
    </script>
@endpush
