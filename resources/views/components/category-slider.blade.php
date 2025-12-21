<div class="w-full py-12 max-w-8xl mx-auto px-4 relative">
    <h2 class="text-4xl font-bold text-gray-900 mb-10 leading-tight capitalize font-quantico">
        The best way to buy the <br> products you love.
    </h2>

    <div class="categories grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 md:gap-2 lg:gap-4">
        @if ($categories->isNotEmpty())
            @foreach ($categories as $item)
                <a href="{{ route('categories.show', $item->slug) }}" class="group block">
                    <div class="relative bg-white rounded-xl p-0.5 shadow-sm flex flex-col h-40 overflow-hidden">
                        <!-- Animated Gradient Border -->
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-primary via-accent to-primary opacity-0 group-hover:opacity-100 transition-opacity duration-700 animate-gradient-x">
                        </div>

                        <!-- Card Content -->
                        <div class="relative flex flex-col h-full p-4 bg-white rounded-[10px] z-10">
                            <!-- Abstract Background Elements -->
                            <div class="absolute inset-0 overflow-hidden opacity-5">
                                <div class="absolute -top-4 -left-4 w-20 h-20 bg-primary rounded-full blur-md"></div>
                                <div class="absolute -bottom-4 -right-4 w-16 h-16 bg-accent rounded-full blur-md">
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="flex-grow flex items-center justify-center relative">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                    class="h-16 md:h-24 object-contain transition-all duration-500 group-hover:scale-110 group-hover:rotate-2 relative z-20">
                            </div>

                            <!-- Title -->
                            <div class="pt-4 relative z-20">
                                <p
                                    class="text-sm md:text-base font-medium text-black text-center font-cambay line-clamp-1">
                                    {{ $item->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <p class="text-gray-500 col-span-full text-center">No featured categories found.</p>
        @endif
    </div>

    <div class="absolute right-4 top-1/4 2xl:-right-10 2xl:bottom-[4.5rem]">
        <a href="{{ route('categories.index') }}"
            class="inline-block transform 2xl:rotate-90 px-3 py-1.5 2xl:px-2.5 2xl:py-1 bg-primary hover:bg-accent text-white text-sm 2xl:text-xs font-inter font-normal tracking-wide rounded-md">
            View All
        </a>
    </div>

</div>
