<!-- resources/views/components/product-slider.blade.php -->
<section class="max-w-8xl mx-auto py-12" data-slider-section="{{ $sliderId }}">
    <!-- Debug: Check all products are being passed -->
    <div class="hidden">
        <p>Total Products: {{ count($slidingProducts) }}</p>
        <p>Slides Per View: {{ $slidesPerView }}</p>
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
                    class="slider-prev-{{ $sliderId }} w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-gray-50 hover:border-primary transition-all duration-300 flex items-center justify-center group shadow-sm">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="slider-next-{{ $sliderId }} w-10 h-10 rounded-full bg-white border border-gray-300 hover:bg-gray-50 hover:border-primary transition-all duration-300 flex items-center justify-center group shadow-sm">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <!-- Swiper Container -->
    @if (count($slidingProducts) > 0)
        <div class="swiper swiper-{{ $sliderId }} relative">
            <div class="swiper-wrapper">
                @foreach ($slidingProducts as $product)
                    <div class="swiper-slide !h-auto">
                        @if ($cardStyle === 'minimal')
                            @include('components.product-cards.minimal', ['product' => $product])
                        @elseif($cardStyle === 'elegant')
                            @include('components.product-cards.elegant', ['product' => $product])
                        @else
                            @include('components.product-cards.modern', ['product' => $product])
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($showPagination)
                <div class="swiper-pagination mt-6"></div>
            @endif
        </div>
    @else
        <div class="text-center py-12 border border-gray-200 rounded-lg">
            <p class="text-gray-500">No products available.</p>
        </div>
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
                320 => ['slidesPerView' => min(2, count($slidingProducts)), 'spaceBetween' => 12],
                480 => ['slidesPerView' => min(3, count($slidingProducts)), 'spaceBetween' => 14],
                768 => ['slidesPerView' => min(4, count($slidingProducts)), 'spaceBetween' => 16],
                1024 => [
                    'slidesPerView' => min($slidesPerView, count($slidingProducts)),
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
@endphp

@if (count($slidingProducts) > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sliderElement = document.querySelector('.swiper-{{ $sliderId }}');
            if (!sliderElement) {
                console.error('Slider element not found: .swiper-{{ $sliderId }}');
                return;
            }

            const sliderConfig = @json($sliderConfig ?? []);

            if (Object.keys(sliderConfig).length === 0) {
                console.error('Slider config is empty');
                return;
            }

            console.log('Initializing slider with config:', sliderConfig);

            try {
                const swiper = new Swiper(sliderElement, sliderConfig);
                console.log('Slider initialized successfully');
            } catch (error) {
                console.error('Slider initialization error:', error);
            }
        });
    </script>
@endif
