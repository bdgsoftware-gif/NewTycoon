<!-- Ads Banner Section -->
@if ($adsBanners->count() > 0)
    <section class="max-w-8xl mx-auto pt-12 overflow-hidden">
        <div class="relative overflow-hidden">
            <!-- Swiper Container -->
            <div class="swiper adsSwiper">
                <div class="swiper-wrapper">
                    @foreach ($adsBanners as $banner)
                        <div class="swiper-slide">
                            <a href="{{ $banner->link ?? '#' }}"
                                @if ($banner->link) target="{{ $banner->target ?? '_self' }}" @endif
                                class="block w-full h-full">
                                <div class="relative">
                                    <img src="{{ asset($banner->image_path) }}"
                                        alt="{{ $banner->alt_text ?? 'Advertisement Banner' }}"
                                        class="w-full h-full object-contain object-center" loading="lazy" />

                                    <!-- Optional Overlay Text (if banner has title/description) -->
                                    @if ($banner->title || $banner->description)
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex flex-col justify-end p-6 md:p-10">
                                            @if ($banner->title)
                                                <h3
                                                    class="text-2xl md:text-4xl font-bold text-white mb-2 drop-shadow-lg">
                                                    {{ $banner->title }}
                                                </h3>
                                            @endif

                                            @if ($banner->description)
                                                <p class="text-white/90 text-base md:text-lg max-w-2xl drop-shadow-lg">
                                                    {{ $banner->description }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // Initialize Ads Swiper
            document.addEventListener('DOMContentLoaded', function() {
                const adsSwiper = new Swiper('.adsSwiper', {
                    // Autoplay settings
                    autoplay: {
                        delay: 5000, // 5 seconds
                        disableOnInteraction: false,
                    },

                    // Effect settings
                    effect: 'fade', // Smooth fade transition
                    fadeEffect: {
                        crossFade: true
                    },

                    // No navigation buttons
                    navigation: false,

                    // No pagination dots
                    pagination: false,

                    // Loop infinitely
                    loop: true,

                    // Speed of transition
                    speed: 1000, // 1 second transition

                    // No grab cursor
                    grabCursor: false,

                    // Responsive breakpoints
                    breakpoints: {
                        320: {
                            slidesPerView: 1,
                            spaceBetween: 0
                        },
                        768: {
                            slidesPerView: 1,
                            spaceBetween: 0
                        },
                        1024: {
                            slidesPerView: 1,
                            spaceBetween: 0
                        }
                    }
                });
            });
        </script>
    @endpush
@endif
