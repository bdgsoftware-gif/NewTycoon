<!-- resources/views/components/product-slider.blade.php -->
<section class="max-w-8xl mx-auto py-12 px-4 2xl:px-0" data-slider-section="{{ $sliderId }}">
    <!-- Debug: Check all products are being passed -->
    <div class="hidden">
        <p>Total Products: {{ count($slidingProducts) }}</p>
        <p>Slides Per View: {{ $slidesPerView }}</p>
        <p>Total Ads: {{ count($adsImages) }}</p>
        @foreach ($slidingProducts as $index => $product)
            <p>{{ $index + 1 }}. {{ $product['name'] }} - Slug: {{ $product['slug'] }}</p>
        @endforeach
    </div>

    <!-- Section Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 font-quantico">{{ $title }}</h2>
        </div>

        @if ($showNavigation && count($slidingProducts) >= $slidesPerView)
            <div class="flex items-center space-x-2 hidden md:flex">
                <button
                    class="slider-prev-{{ $sliderId }} w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-gray-50 hover:border-primary transition-all duration-300 flex items-center justify-center group">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="slider-next-{{ $sliderId }} w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-gray-50 hover:border-primary transition-all duration-300 flex items-center justify-center group">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <!-- Modern Layout with Ads -->
    @if ($cardStyle === 'modern')
        <div class="relative">
            <!-- Main Layout Container -->
            <div class="grid grid-cols-1 lg:grid-cols-12 xl:grid-cols-6 gap-4">
                <!-- Ads Section (Left - Desktop, Top - Mobile) -->
                <div class="lg:col-span-5 xl:col-span-2">
                    @if (isset($adsImages) && count($adsImages) > 0)
                        <div class="sticky top-6">
                            <!-- Ads Swiper -->
                            <div class="swiper ads-modern-swiper-{{ $sliderId }} overflow-hidden">
                                <div class="swiper-wrapper py-2">
                                    @foreach ($adsImages as $ad)
                                        <!-- Each Slide With Fixed Height -->
                                        <div
                                            class="swiper-slide h-[400px] md:h-[425px] lg:h-[450px] border border-gray-200 hover:border-primary transition-all duration-300">

                                            <a href="{{ $ad['link'] ?? '#' }}"
                                                @if (!empty($ad['link'])) target="_blank" @endif
                                                class="block w-full h-full">

                                                <!-- Ad Container -->
                                                <div class="relative w-full h-full">

                                                    <!-- Full Cover Image -->
                                                    <img src="{{ $ad['image'] }}"
                                                        alt="{{ $ad['alt_text'] ?? 'Advertisement' }}"
                                                        class="w-full h-full object-cover object-center" loading="lazy">

                                                    <!-- Ad Indicator -->
                                                    <div
                                                        class="absolute top-4 right-4 bg-black/60 
                                            text-white text-xs px-3 py-1.5 rounded-full">
                                                        Ad
                                                    </div>

                                                </div>

                                            </a>

                                        </div>
                                    @endforeach
                                </div>
                                <!-- Ads Pagination -->
                                @if (count($adsImages) > 1)
                                    <div class="swiper-pagination ads-pagination-{{ $sliderId }} !bottom-4"></div>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Fallback if no ads -->
                        <div
                            class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl min-h-[400px] md:min-h-[425px] lg:min-h-[450px] flex items-center justify-center p-6">
                            <div class="text-center">
                                <p class="text-gray-600 font-cambay">Ads Space Available</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Products Section (Right - Desktop, Bottom - Mobile) -->
                <div class="lg:col-span-7 xl:col-span-4">
                    @if (count($slidingProducts) > 0)
                        <div class="swiper swiper-{{ $sliderId }} relative">
                            <div class="swiper-wrapper py-2">
                                @foreach ($slidingProducts as $product)
                                    <div class="swiper-slide !h-auto">
                                        @include('components.product-cards.modern', [
                                            'product' => $product,
                                        ])
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            @if ($showPagination)
                                <div class="swiper-pagination mt-6"></div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-12 border border-gray-200">
                            <p class="text-gray-500">No products available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Minimal Style (Original Layout) -->
    @elseif ($cardStyle === 'minimal')
        @if (count($slidingProducts) > 0)
            <div class="swiper swiper-{{ $sliderId }} relative">
                <div class="swiper-wrapper">
                    @foreach ($slidingProducts as $product)
                        <div class="swiper-slide !h-auto">
                            @include('components.product-cards.minimal', ['product' => $product])
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($showPagination)
                    <div class="swiper-pagination mt-6"></div>
                @endif
            </div>
        @else
            <div class="text-center py-12 border border-gray-200">
                <p class="text-gray-500">No products available.</p>
            </div>
        @endif
    @endif
</section>

@php
    // Only generate slider config if there are products
    if (count($slidingProducts) > 2) {
        $sliderConfig = [
            'loop' => count($slidingProducts) > 1,
            'grabCursor' => true,
            'spaceBetween' => $spaceBetween,
            'slidesPerView' => 1,
            'speed' => 600,
            'effect' => 'slide',
            'breakpoints' => [
                320 => ['slidesPerView' => min(1, count($slidingProducts)), 'spaceBetween' => 12],
                480 => ['slidesPerView' => min(2, count($slidingProducts)), 'spaceBetween' => 14],
                768 => ['slidesPerView' => min(3, count($slidingProducts)), 'spaceBetween' => 16],
                1024 => [
                    'slidesPerView' => min($slidesPerView - 1, count($slidingProducts)),
                    'spaceBetween' => $spaceBetween,
                ],
                1280 => [
                    'slidesPerView' => min($slidesPerView, count($slidingProducts)),
                    'spaceBetween' => $spaceBetween,
                ],
            ],
        ];

        if ($autoPlay && count($slidingProducts) > 1) {
            $sliderConfig['autoplay'] = [
                'delay' => 4000,
                'disableOnInteraction' => false,
                'pauseOnMouseEnter' => true,
            ];
        }

        if ($showNavigation && count($slidingProducts) > 1) {
            $sliderConfig['navigation'] = [
                'nextEl' => '.slider-next-' . $sliderId,
                'prevEl' => '.slider-prev-' . $sliderId,
            ];
        }

        if ($showPagination && count($slidingProducts) > 1) {
            $sliderConfig['pagination'] = [
                'el' => '.swiper-pagination',
                'clickable' => true,
                'dynamicBullets' => true,
            ];
        }
    }

    // Ads slider config
    if (isset($adsImages) && count($adsImages) > 0) {
        $adsSliderConfig = [
            'loop' => count($adsImages) > 1,
            'spaceBetween' => 0,
            'slidesPerView' => 1,
            'speed' => 500,
            'effect' => 'fade',
            'fadeEffect' => ['crossFade' => true],
            'autoplay' => [
                'delay' => 5000,
                'disableOnInteraction' => false,
                'pauseOnMouseEnter' => true,
            ],
            'pagination' =>
                count($adsImages) > 1
                    ? [
                        'el' => '.ads-pagination-' . $sliderId,
                        'clickable' => true,
                        'type' => 'bullets',
                    ]
                    : false,
            'navigation' =>
                count($adsImages) > 1
                    ? [
                        'nextEl' => '.ads-next-' . $sliderId,
                        'prevEl' => '.ads-prev-' . $sliderId,
                    ]
                    : false,
        ];
    }
@endphp

@if (count($slidingProducts) > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize main product slider
            const sliderElement = document.querySelector('.swiper-{{ $sliderId }}');
            if (sliderElement) {
                const sliderConfig = @json($sliderConfig ?? []);
                if (Object.keys(sliderConfig).length > 0) {
                    try {
                        new Swiper(sliderElement, sliderConfig);
                    } catch (error) {
                        console.error('Product slider initialization error:', error);
                    }
                }
            }

            // Initialize ads slider if exists
            const adsSliderElement = document.querySelector('.ads-modern-swiper-{{ $sliderId }}');
            if (adsSliderElement) {
                const adsSliderConfig = @json($adsSliderConfig ?? []);
                if (Object.keys(adsSliderConfig).length > 0) {
                    try {
                        new Swiper(adsSliderElement, adsSliderConfig);
                    } catch (error) {
                        console.error('Ads slider initialization error:', error);
                    }
                }
            }
        });
    </script>
@endif
