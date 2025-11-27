<!-- resources/views/components/hero-swiper.blade.php -->
<section class="relative">
    <!-- Swiper Container -->
    <div class="swiper heroSwiper h-screen max-h-[800px] w-full">
        <div class="swiper-wrapper">
            @foreach ($heroSlides as $slide)
                <div class="swiper-slide relative">
                    <!-- Background Media -->
                    @if ($slide['type'] === 'video')
                        <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                            <source src="{{ asset($slide['background']) }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ asset($slide['background']) }}" alt="{{ $slide['title'] ?? '' }}"
                            class="w-full h-full object-cover">
                    @endif

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/40"></div>

                    <!-- Content -->
                    @if ($slide['has_content'])
                        <div class="absolute inset-0 flex items-center">
                            <div class="max-w-8xl mx-auto px-4 w-full">
                                <div
                                    class="max-w-2xl {{ $slide['content_position'] === 'right' ? 'ml-auto text-right' : ($slide['content_position'] === 'center' ? 'mx-auto text-center' : '') }}">

                                    @if (!empty($slide['badge']))
                                        <div
                                            class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                                            <span class="text-sm font-semibold text-white">{{ $slide['badge'] }}</span>
                                        </div>
                                    @endif

                                    @if (!empty($slide['title']))
                                        <h1
                                            class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-4">
                                            {!! $slide['title'] !!}
                                        </h1>
                                    @endif

                                    @if (!empty($slide['subtitle']))
                                        <p class="text-xl md:text-2xl text-white/90 leading-relaxed mb-8">
                                            {{ $slide['subtitle'] }}
                                        </p>
                                    @endif

                                    @if ($slide['has_cta'] && !empty($slide['cta_buttons']))
                                        <div
                                            class="flex flex-col sm:flex-row gap-4 {{ $slide['content_position'] === 'center' ? 'justify-center' : ($slide['content_position'] === 'right' ? 'justify-end' : 'justify-start') }}">
                                            @foreach ($slide['cta_buttons'] as $button)
                                                <a href="{{ $button['url'] }}"
                                                    class="{{ $button['type'] === 'primary' ? 'bg-accent hover:bg-accent/90 text-white' : 'border-2 border-white hover:bg-white hover:text-primary text-white' }} px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                                    {{ $button['text'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Navigation Buttons -->
        <div
            class="swiper-button-next text-white after:content-[''] w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </div>
        <div
            class="swiper-button-prev text-white after:content-[''] w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center ml-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </div>

        <!-- Pagination -->
        <div class="swiper-pagination !bottom-8"></div>

        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10">
            <div class="animate-bounce cursor-pointer" onclick="scrollToContent()">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const heroSwiper = new Swiper('.heroSwiper', {
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 10000,
                disableOnInteraction: false,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                renderBullet: function(index, className) {
                    return '<span class="' + className +
                        ' !w-3 !h-3 !bg-white/50 !opacity-100 hover:!bg-white !mx-1"></span>';
                },
            },
        });

        // Pause video when slide changes
        heroSwiper.on('slideChange', function() {
            const currentSlide = heroSwiper.slides[heroSwiper.activeIndex];
            const video = currentSlide.querySelector('video');
            if (video) {
                video.currentTime = 0;
                video.play();
            }
        });
    });

    function scrollToContent() {
        document.querySelector('#content-section')?.scrollIntoView({
            behavior: 'smooth'
        });
    }
</script>

<style>
    .swiper-pagination-bullet-active {
        background: #ffffff !important;
        transform: scale(1.2);
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
