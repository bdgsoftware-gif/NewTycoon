<!-- User Stories in Motion Section -->
<section class="w-full bg-white py-12">
    <div class="max-w-8xl mx-auto">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 md:mb-16">
            <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4 font-quantico">
                User Stories in Motion
            </h2>
            <p class="text-lg md:text-xl text-gray-600 font-cambay">
                See how our products come to life through real user experiences and stories
            </p>
        </div>

        <!-- Video Reels Section -->
        <div class="relative">
            <!-- Desktop: Swiper with 4 videos per slide -->
            <div class="hidden lg:block">
                <div class="swiper userStoriesSwiper">
                    <div class="swiper-wrapper">
                        <!-- Group videos in chunks of 4 for desktop -->
                        @php
                            $videoChunks = $userStories->chunk(4);
                        @endphp

                        @foreach ($videoChunks as $chunk)
                            <div class="swiper-slide">
                                <div class="grid grid-cols-4 gap-4 md:gap-6 px-4">
                                    @foreach ($chunk as $story)
                                        <div
                                            class="bg-gray-50 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                                            <!-- Video Container -->
                                            <div class="relative aspect-[9/16] bg-black">
                                                <video class="w-full h-full object-cover" controls
                                                    controlsList="nodownload" poster="{{ $story->thumbnail ?? '' }}"
                                                    preload="metadata">
                                                    <source src="{{ asset('storage/' . $story->video_path) }}"
                                                        type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>

                                                <!-- Play/Pause Overlay -->
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                                    <div class="bg-black/50 rounded-full p-3">
                                                        <svg class="w-8 h-8 text-white" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path d="M8 5v14l11-7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Story Info -->
                                            <div class="p-4">
                                                <div class="flex items-center mb-2">
                                                    @if ($story->user_avatar)
                                                        <img src="{{ asset('storage/' . $story->user_avatar) }}"
                                                            alt="{{ $story->user_name }}"
                                                            class="w-8 h-8 rounded-full mr-3">
                                                    @else
                                                        <div
                                                            class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center mr-3">
                                                            <span class="text-primary font-semibold text-sm">
                                                                {{ strtoupper(substr($story->user_name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h4 class="font-semibold text-gray-900 text-sm">
                                                            {{ $story->user_name }}</h4>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $story->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>

                                                <p class="text-sm text-gray-700 mb-2 line-clamp-2">{{ $story->caption }}
                                                </p>

                                                <!-- Engagement Stats -->
                                                <div class="flex items-center justify-between text-xs text-gray-500">
                                                    <div class="flex items-center space-x-4">
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                            </svg>
                                                            {{ $story->likes_count }}
                                                        </span>
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                            </svg>
                                                            {{ $story->comments_count }}
                                                        </span>
                                                    </div>

                                                    <!-- Product Tag -->
                                                    @if ($story->product)
                                                        <span
                                                            class="bg-primary/10 text-primary text-xs px-2 py-1 rounded-full">
                                                            {{ $story->product->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Mobile & Tablet: Single video per slide -->
            <div class="block lg:hidden">
                <div class="swiper userStoriesMobileSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($userStories as $story)
                            <div class="swiper-slide">
                                <div class="max-w-sm mx-auto">
                                    <div class="bg-gray-50 rounded-2xl overflow-hidden shadow-lg">
                                        <!-- Video Container -->
                                        <div class="relative aspect-[9/16] bg-black">
                                            <video class="w-full h-full object-cover" controls controlsList="nodownload"
                                                poster="{{ $story->thumbnail ?? '' }}" preload="metadata">
                                                <source src="{{ asset('storage/' . $story->video_path) }}"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                            <!-- Play/Pause Overlay -->
                                            <div
                                                class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                                <div class="bg-black/50 rounded-full p-3">
                                                    <svg class="w-8 h-8 text-white" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path d="M8 5v14l11-7z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Story Info -->
                                        <div class="p-4">
                                            <div class="flex items-center mb-3">
                                                @if ($story->user_avatar)
                                                    <img src="{{ asset('storage/' . $story->user_avatar) }}"
                                                        alt="{{ $story->user_name }}"
                                                        class="w-10 h-10 rounded-full mr-3">
                                                @else
                                                    <div
                                                        class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center mr-3">
                                                        <span class="text-primary font-semibold">
                                                            {{ strtoupper(substr($story->user_name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">{{ $story->user_name }}
                                                    </h4>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $story->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>

                                            <p class="text-gray-700 mb-3">{{ $story->caption }}</p>

                                            <!-- Engagement Stats -->
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-6">
                                                    <span class="flex items-center text-gray-600">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                        </svg>
                                                        {{ $story->likes_count }}
                                                    </span>
                                                    <span class="flex items-center text-gray-600">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                        </svg>
                                                        {{ $story->comments_count }}
                                                    </span>
                                                </div>

                                                <!-- Product Tag -->
                                                @if ($story->product)
                                                    <span
                                                        class="bg-primary/10 text-primary text-sm px-3 py-1 rounded-full">
                                                        {{ $story->product->name }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination for Mobile -->
                    <div class="swiper-pagination !bottom-0 mt-6"></div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center mt-12 md:mt-16">
            <button
                class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-full font-semibold hover:bg-primary-dark transition-all duration-300 transform hover:scale-105 font-quantico">
                Share Your Story
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </button>
            <p class="text-gray-500 text-sm mt-4 font-cambay">
                Upload your experience and get featured
            </p>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        // Initialize Desktop Swiper (4 videos per slide)
        document.addEventListener('DOMContentLoaded', function() {
            // Desktop Swiper (4 per slide)
            if (document.querySelector('.userStoriesSwiper')) {
                const desktopSwiper = new Swiper('.userStoriesSwiper', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpoints: {
                        1024: {
                            slidesPerView: 1,
                            spaceBetween: 30,
                        },
                    }
                });
            }

            // Mobile Swiper (1 per slide)
            if (document.querySelector('.userStoriesMobileSwiper')) {
                const mobileSwiper = new Swiper('.userStoriesMobileSwiper', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    // No navigation buttons
                    navigation: false,

                    // No pagination dots
                    pagination: false,

                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                    }
                });
            }

            // Pause other videos when one plays
            document.querySelectorAll('video').forEach(video => {
                video.addEventListener('play', function() {
                    document.querySelectorAll('video').forEach(otherVideo => {
                        if (otherVideo !== video && !otherVideo.paused) {
                            otherVideo.pause();
                        }
                    });
                });
            });
        });
    </script>
@endpush
