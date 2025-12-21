<!-- resources/views/components/hero-swiper.blade.php -->
<section class="relative">
    <!-- Swiper Container -->
    <div
        class="swiper heroSwiper w-full h-[60vh] min-h-[400px] md:h-screen md:max-h-[650px] lg:max-h-[750px] xl:max-h-[660px] 2xl:max-h-[800px] overflow-hidden">
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
                            class="w-full h-full md:object-cover 2xl:object-contain">
                    @endif

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/40 {{ $slide['has_content'] ? '' : 'hidden' }}"></div>

                    <!-- Content -->
                    @if ($slide['has_content'])
                        <div class="absolute inset-0 flex items-center">
                            <div class="max-w-8xl mx-auto px-4 md:px-16 2xl:px-4 w-full">
                                <div
                                    class="max-w-2xl {{ $slide['content_position'] === 'right' ? 'ml-auto text-right' : ($slide['content_position'] === 'center' ? 'mx-auto text-center' : '') }}">

                                    @if (!empty($slide['badge']))
                                        <div
                                            class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-6 font-inter">
                                            <span class="text-sm font-semibold text-white">{{ $slide['badge'] }}</span>
                                        </div>
                                    @endif

                                    @if (!empty($slide['title']))
                                        <h1
                                            class="text-4xl md:text-4xl lg:text-5xl xl:text-6xl font-bold text-white leading-tight mb-4 font-quantico">
                                            {!! $slide['title'] !!}
                                        </h1>
                                    @endif

                                    @if (!empty($slide['subtitle']))
                                        <p class="text-base md:text-xl text-white/90 leading-relaxed mb-8 font-inter">
                                            {{ $slide['subtitle'] }}
                                        </p>
                                    @endif

                                    @if ($slide['has_cta'] && !empty($slide['cta_buttons']))
                                        <div
                                            class="flex flex-wrap items-center gap-2 {{ $slide['content_position'] === 'center' ? 'justify-center' : ($slide['content_position'] === 'right' ? 'justify-end' : 'justify-start') }}">

                                            @foreach ($slide['cta_buttons'] as $button)
                                                <a href="{{ $button['url'] }}"
                                                    class="inline-flex items-center justify-center text-sm sm:text-base md:text-lg px-4 py-2 sm:px-5 sm:py-2.5 md:px-6 md:py-3 rounded-lg font-semibold font-quantico transition-all duration-300 shadow-md hover:shadow-lg active:scale-95 md:hover:scale-105 {{ $button['type'] === 'primary'
                                                        ? 'bg-accent text-white hover:bg-accent/90'
                                                        : 'border border-white text-white hover:bg-white hover:text-primary' }}">
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

        <!-- Progress Bar Container -->
        <div
            class="hidden md:block absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 w-full max-w-xl px-4 md:px-8">
            <div class="flex items-center gap-4 md:gap-6">
                <!-- Progress Bar -->
                <div class="flex-1 h-2 bg-white/20 rounded-full overflow-hidden relative group">
                    <!-- Background Track -->
                    <div class="absolute inset-0 bg-white/10 rounded-full"></div>

                    <!-- Progress Fill with Gradient -->
                    <div
                        class="swiper-progress-fill absolute inset-0 rounded-full bg-gradient-to-r from-primary to-accent transform origin-left scale-x-0 transition-transform duration-100 ease-linear">
                    </div>

                    <!-- Individual Slide Segments (Optional) -->
                    <div class="absolute inset-0 flex">
                        @for ($i = 0; $i < count($heroSlides); $i++)
                            <div class="flex-1 border-r border-white/10 last:border-r-0"></div>
                        @endfor
                    </div>

                    <!-- Hover Indicator -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-[shimmer_2s_infinite]">
                        </div>
                    </div>
                </div>

                <!-- Slide Counter -->
                <div class="flex items-center gap-2">
                    <div class="text-white font-semibold text-sm md:text-base min-w-[70px] text-center">
                        <span class="swiper-current-slide">1</span> / <span
                            class="swiper-total-slides">{{ count($heroSlides) }}</span>
                    </div>

                    <!-- Autoplay Toggle -->
                    <button
                        class="swiper-autoplay-toggle w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-colors duration-300">
                        <svg class="w-4 h-4 text-white swiper-play-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 4l12 8-12 8z" />
                        </svg>
                        <svg class="w-4 h-4 text-white swiper-pause-icon hidden" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path d="M6 4h4v16H6zm8 0h4v16h-4z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Swiper Navigation -->
        <div
            class="hidden md:flex absolute inset-y-0 left-4 xl:left-5 2xl:left-8 items-center z-20 pointer-events-none">
            <button type="button" aria-label="Previous slide"
                class="swiper-button-prev pointer-events-auto w-6 h-6 xl:w-8 xl:h-8 2xl:w-12 2xl:h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-primary/30 transition-all duration-300 flex items-center justify-center group active:scale-95 disabled:opacity-40 disabled:cursor-not-allowed">

                <svg class="w-3 h-3 2xl:w-5 2xl:h-5 text-gray-700 group-hover:text-primary transition-colors"
                    viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                </svg>
            </button>
        </div>

        <div
            class="hidden md:flex absolute inset-y-0 right-4 xl:right-5 2xl:right-8 items-center z-20 pointer-events-none">
            <button type="button" aria-label="Next slide"
                class="swiper-button-next pointer-events-auto w-6 h-6 xl:w-8 xl:h-8 2xl:w-12 2xl:h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 hover:border-primary/30 transition-all duration-300 flex items-center justify-center group active:scale-95 disabled:opacity-40 disabled:cursor-not-allowed">

                <svg class="w-3 h-3 2xl:w-5 2xl:h-5 text-gray-700 group-hover:text-primary transition-colors"
                    viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M8.59 16.59 10 18l6-6-6-6-1.41 1.41L13.17 12z" />
                </svg>
            </button>
        </div>


        <!-- Bullet Indicators (Optional - Removed if you want only progress bar) -->
        <div class="md:hidden swiper-pagination"></div>
    </div>
</section>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const heroSwiper = new Swiper('.heroSwiper', {
                loop: true,
                speed: 1000,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: false,
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },

                // Navigation buttons
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },

                // Remove bullet pagination if using only progress bar
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    type: 'bullets',
                },

                // Keyboard control
                keyboard: {
                    enabled: true,
                },

                // Touch control
                touchRatio: 1,
                touchAngle: 45,
                grabCursor: true,

                on: {
                    init: function() {
                        updateSlideCounter(this);
                        updateProgressBar(this, 0);
                        setupAutoplayToggle(this);
                    },
                    slideChange: function() {
                        updateSlideCounter(this);
                        // Reset progress bar on slide change
                        updateProgressBar(this, 0);

                        // Pause/play video
                        const currentSlide = this.slides[this.activeIndex];
                        const video = currentSlide.querySelector('video');
                        if (video) {
                            video.currentTime = 0;
                            video.play();
                        }
                    },
                    autoplayTimeLeft: function(swiper, time, progress) {
                        // Progress is 0 to 1, where 1 is start and 0 is end
                        // Convert to 0 to 1 where 0 is start and 1 is end
                        const fillProgress = 1 - progress;
                        updateProgressBar(swiper, fillProgress);
                    },
                    autoplayStart: function() {
                        updateAutoplayUI(true);
                    },
                    autoplayStop: function() {
                        updateAutoplayUI(false);
                    }
                },
            });

            function updateSlideCounter(swiper) {
                const current = swiper.el.querySelector('.swiper-current-slide');
                const total = swiper.el.querySelector('.swiper-total-slides');
                if (current && total) {
                    current.textContent = swiper.realIndex + 1;
                }
            }

            function updateProgressBar(swiper, progress) {
                const progressFill = swiper.el.querySelector('.swiper-progress-fill');
                if (progressFill) {
                    // Ensure progress is between 0 and 1
                    const safeProgress = Math.max(0, Math.min(1, progress));
                    progressFill.style.transform = `scaleX(${safeProgress})`;

                    // Smooth transition for filling, immediate reset on slide change
                    if (progress === 0) {
                        progressFill.style.transition = 'transform 0.1s ease';
                    } else {
                        progressFill.style.transition = 'transform 100ms linear';
                    }
                }
            }

            function setupAutoplayToggle(swiper) {
                const toggleBtn = swiper.el.querySelector('.swiper-autoplay-toggle');
                if (toggleBtn) {
                    toggleBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        if (swiper.autoplay.running) {
                            swiper.autoplay.stop();
                            updateAutoplayUI(false);
                        } else {
                            swiper.autoplay.start();
                            updateAutoplayUI(true);
                        }
                    });
                }
            }

            function updateAutoplayUI(isPlaying) {
                const playIcon = document.querySelector('.swiper-play-icon');
                const pauseIcon = document.querySelector('.swiper-pause-icon');
                const toggleBtn = document.querySelector('.swiper-autoplay-toggle');

                if (playIcon && pauseIcon && toggleBtn) {
                    if (isPlaying) {
                        playIcon.classList.add('hidden');
                        pauseIcon.classList.remove('hidden');
                        toggleBtn.setAttribute('title', 'Pause autoplay');
                    } else {
                        playIcon.classList.remove('hidden');
                        pauseIcon.classList.add('hidden');
                        toggleBtn.setAttribute('title', 'Play autoplay');
                    }
                }
            }

            // Initialize autoplay UI
            updateAutoplayUI(true);

            // Add interaction pause on hover
            const container = document.querySelector('.heroSwiper');
            container.addEventListener('mouseenter', () => {
                // Already handled by pauseOnMouseEnter: true
            });

            container.addEventListener('mouseleave', () => {
                // Already handled by pauseOnMouseEnter: true
            });

            // Manual control handlers
            const prevBtn = document.querySelector('.swiper-button-prev');
            const nextBtn = document.querySelector('.swiper-button-next');

            if (prevBtn) {
                prevBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    heroSwiper.slidePrev();
                    heroSwiper.autoplay.start(); // Restart autoplay after manual navigation
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    heroSwiper.slideNext();
                    heroSwiper.autoplay.start(); // Restart autoplay after manual navigation
                });
            }
        });
    </script>
@endpush
