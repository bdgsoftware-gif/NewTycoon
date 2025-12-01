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
                    <div class="absolute inset-0 bg-black/40 {{ $slide['has_content'] ? '' : 'hidden' }}"></div>
                    
                    <!-- Content -->
                    @if ($slide['has_content'])
                        <div class="absolute inset-0 flex items-center">
                            <div class="max-w-8xl mx-auto px-4 w-full">
                                <div
                                    class="max-w-2xl {{ $slide['content_position'] === 'right' ? 'ml-auto text-right' : ($slide['content_position'] === 'center' ? 'mx-auto text-center' : '') }}">

                                    @if (!empty($slide['badge']))
                                        <div
                                            class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-6 font-cambay">
                                            <span class="text-sm font-semibold text-white">{{ $slide['badge'] }}</span>
                                        </div>
                                    @endif

                                    @if (!empty($slide['title']))
                                        <h1
                                            class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-4 font-quantico">
                                            {!! $slide['title'] !!}
                                        </h1>
                                    @endif

                                    @if (!empty($slide['subtitle']))
                                        <p class="text-xl md:text-2xl text-white/90 leading-relaxed mb-8 font-cambay">
                                            {{ $slide['subtitle'] }}
                                        </p>
                                    @endif

                                    @if ($slide['has_cta'] && !empty($slide['cta_buttons']))
                                        <div
                                            class="flex flex-col sm:flex-row gap-4 {{ $slide['content_position'] === 'center' ? 'justify-center' : ($slide['content_position'] === 'right' ? 'justify-end' : 'justify-start') }}">
                                            @foreach ($slide['cta_buttons'] as $button)
                                                <a href="{{ $button['url'] }}"
                                                    class="{{ $button['type'] === 'primary' ? 'bg-accent hover:bg-accent/90 text-white' : 'border-2 border-white hover:bg-white hover:text-primary text-white' }} px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl font-quantico">
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

        <!-- Pagination -->
        <div class="swiper-pagination !bottom-8"></div>


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
            navigation: false,
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
</script>
