<!-- resources/views/components/product-slider.blade.php -->
@props([
    'products' => [],
    'title' => 'Recommended for you',
    'sliderId' => 'productSlider',
    'autoPlay' => true,
    'showNavigation' => true,
    'showPagination' => false,
    'slidesPerView' => 4,
    'spaceBetween' => 24,
    'cardStyle' => 'modern', // modern, minimal, elegant
])

<section class="max-w-8xl mx-auto px-6 py-16" data-slider-section="{{ $sliderId }}">
    <!-- Section Header -->
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $title }}</h2>
            <div class="w-16 h-1 bg-primary rounded-full"></div>
        </div>

        @if ($showNavigation)
            <div class="flex items-center space-x-2">
                <button
                    class="slider-prev-{{ $sliderId }} w-12 h-12 rounded-full bg-white border border-gray-200 hover:bg-gray-50 hover:border-primary transition-all duration-300 flex items-center justify-center group shadow-sm">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="slider-next-{{ $sliderId }} w-12 h-12 rounded-full bg-white border border-gray-200 hover:bg-gray-50 hover:border-primary transition-all duration-300 flex items-center justify-center group shadow-sm">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <!-- Swiper Container -->
    <div class="swiper {{ $sliderId }} relative">
        <div class="swiper-wrapper">
            @foreach ($products as $product)
                <div class="swiper-slide">
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
            <div class="swiper-pagination mt-8"></div>
        @endif
    </div>
</section>

<!-- Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliderConfig = {
            loop: true,
            grabCursor: true,
            spaceBetween: {{ $spaceBetween }},
            slidesPerView: 1,
            autoplay: {{ $autoPlay ? `{ delay: 4000, disableOnInteraction: false }` : 'false' }},
            speed: 600,
            effect: 'slide',
            breakpoints: {
                480: {
                    slidesPerView: 2,
                    spaceBetween: 16
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: {{ $slidesPerView }},
                    spaceBetween: {{ $spaceBetween }}
                },
                1280: {
                    slidesPerView: {{ $slidesPerView + 1 }},
                    spaceBetween: {{ $spaceBetween }}
                }
            },
            @if ($showNavigation)
                navigation: {
                    nextEl: '.slider-next-{{ $sliderId }}',
                    prevEl: '.slider-prev-{{ $sliderId }}',
                },
            @endif
            @if ($showPagination)
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true
                }
            @endif
        };

        new Swiper('.{{ $sliderId }}', sliderConfig);
    });
</script>
