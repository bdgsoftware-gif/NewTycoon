@if ($adsBanners->count() > 0)
    <section class="max-w-8xl mx-auto pt-12 ads-section">
        <div class="relative">

            <!-- Skeleton Overlay -->
            <div class="ads-skeleton absolute inset-0 z-10 rounded-xl pointer-events-none p-4"></div>

            <!-- Swiper -->
            <div class="swiper adsSwiper relative z-20">
                <div class="swiper-wrapper">

                    @foreach ($adsBanners as $banner)
                        <div class="swiper-slide p-4">
                            <a href="{{ $banner->link ?? '#' }}"
                                @if ($banner->link) target="{{ $banner->target ?? '_self' }}" @endif
                                class="block">

                                <div
                                    class="relative aspect-[16/6] rounded-xl overflow-hidden
                                       transform transition-all duration-300
                                       hover:scale-[1.02] hover:shadow-md">

                                    <img src="{{ asset($banner->image_path) }}"
                                        alt="{{ $banner->alt_text ?? 'Advertisement Banner' }}"
                                        class="w-full h-full object-contain object-center rounded-xl" loading="lazy" />
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endif
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.ads-section').forEach(section => {
                const swiperEl = section.querySelector('.adsSwiper');
                const skeleton = section.querySelector('.ads-skeleton');

                if (!swiperEl) return;

                const swiper = new Swiper(swiperEl, {
                    autoplay: {
                        delay: 8000,
                        disableOnInteraction: false,
                    },
                    loop: true,
                    speed: 1000,
                    spaceBetween: 4,

                    breakpoints: {
                        0: {
                            slidesPerView: 1,
                        },
                        768: {
                            slidesPerView: 2,
                        }
                    },

                    on: {
                        init(swiper) {
                            const activeImg = swiper.slides[swiper.activeIndex]
                                ?.querySelector('img');

                            if (!activeImg) {
                                skeleton?.remove();
                                return;
                            }

                            if (activeImg.complete) {
                                skeleton?.remove();
                            } else {
                                activeImg.addEventListener('load', () => skeleton?.remove(), {
                                    once: true
                                });
                            }

                            // Pause on hover
                            swiper.el.addEventListener('mouseenter', () => swiper.autoplay.stop());
                            swiper.el.addEventListener('mouseleave', () => swiper.autoplay.start());
                        }
                    }
                });
            });

        });
    </script>
@endpush
