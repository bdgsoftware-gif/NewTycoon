@if ($adsBanners->count() > 0)
    <section class="max-w-8xl mx-auto pt-12 overflow-hidden">
        <div class="relative overflow-hidden aspect-[16/6]">

            <!-- Skeleton with data attribute for JS -->
            <div class="ads-skeleton absolute inset-0 z-10" data-skeleton></div>

            <!-- Swiper -->
            <div class="swiper adsSwiper absolute inset-0 z-20">
                <div class="swiper-wrapper h-full">
                    @foreach ($adsBanners as $banner)
                        <div class="swiper-slide h-full">
                            <a href="{{ $banner->link ?? '#' }}"
                                @if ($banner->link) target="{{ $banner->target ?? '_self' }}" @endif
                                class="block w-full h-full">

                                <div class="relative w-full h-full" data-ad-content>
                                    <img src="{{ asset($banner->image_path) }}"
                                        alt="{{ $banner->alt_text ?? 'Advertisement Banner' }}"
                                        class="ad-image w-full h-full object-contain object-center scale-105"
                                        loading="lazy" data-ad-image />
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
            if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

            gsap.registerPlugin(ScrollTrigger);

            const swiperEl = document.querySelector('.adsSwiper');
            if (!swiperEl) return;

            const skeleton = document.querySelector('[data-skeleton]');

            // Function to remove skeleton
            function removeSkeleton() {
                if (skeleton) {
                    // Fade out before removing
                    gsap.to(skeleton, {
                        opacity: 0,
                        duration: 0.3,
                        onComplete: () => {
                            skeleton.remove();
                        }
                    });
                }
            }

            // Preload all images and remove skeleton when first one loads
            function handleImageLoading() {
                const images = swiperEl.querySelectorAll('[data-ad-image]');
                let imagesLoaded = 0;
                const totalImages = images.length;

                if (totalImages === 0) {
                    removeSkeleton();
                    return;
                }

                // Set timeout as fallback (5 seconds max)
                const timeoutId = setTimeout(() => {
                    removeSkeleton();
                }, 5000);

                images.forEach(img => {
                    if (img.complete) {
                        imagesLoaded++;
                        if (imagesLoaded >= Math.min(2, totalImages)) { // Wait for at least 2 images
                            clearTimeout(timeoutId);
                            removeSkeleton();
                        }
                    } else {
                        img.addEventListener('load', () => {
                            imagesLoaded++;
                            if (imagesLoaded >= Math.min(2, totalImages)) {
                                clearTimeout(timeoutId);
                                removeSkeleton();
                            }
                        });

                        img.addEventListener('error', () => {
                            imagesLoaded++; // Count errors as loaded to continue
                            if (imagesLoaded >= Math.min(2, totalImages)) {
                                clearTimeout(timeoutId);
                                removeSkeleton();
                            }
                        });
                    }
                });
            }

            const adsSwiper = new Swiper('.adsSwiper', {
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                loop: true,
                speed: 1000,
                navigation: false,
                pagination: false,
                on: {
                    init() {
                        // Start image loading check
                        handleImageLoading();
                        animateSlide();
                    }
                }
            });

            function animateSlide() {
                const content = swiperEl.querySelector(
                    '.swiper-slide-active [data-ad-content]'
                );
                if (!content) return;

                // Kill any existing animations on this content
                gsap.killTweensOf(content);
                gsap.killTweensOf(content.querySelector('img'));

                gsap.fromTo(
                    content, {
                        opacity: 0,
                        y: 20
                    }, {
                        opacity: 1,
                        y: 0,
                        duration: 0.6,
                        ease: 'power3.out'
                    }
                );

                const img = content.querySelector('img');
                if (img) {
                    gsap.fromTo(
                        img, {
                            scale: 1.05
                        }, {
                            scale: 1,
                            duration: 2,
                            ease: 'power2.out'
                        }
                    );
                }
            }

            adsSwiper.on('slideChangeTransitionStart', animateSlide);

            // Section entrance - only if skeleton is already removed
            if (!skeleton || skeleton.classList.contains('ads-skeleton-hidden')) {
                gsap.from(swiperEl, {
                    opacity: 0,
                    y: 30,
                    duration: 0.8,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: swiperEl.closest('section'),
                        start: 'top 75%',
                        once: true,
                    }
                });
            } else {
                // Wait for skeleton to be removed before animating
                const observer = new MutationObserver(() => {
                    if (!document.querySelector('[data-skeleton]')) {
                        observer.disconnect();
                        gsap.from(swiperEl, {
                            opacity: 0,
                            y: 30,
                            duration: 0.8,
                            ease: 'power3.out',
                            scrollTrigger: {
                                trigger: swiperEl.closest('section'),
                                start: 'top 75%',
                                once: true,
                            }
                        });
                    }
                });

                if (skeleton) {
                    observer.observe(skeleton.parentNode, {
                        childList: true
                    });
                }
            }

        });
    </script>
@endpush
