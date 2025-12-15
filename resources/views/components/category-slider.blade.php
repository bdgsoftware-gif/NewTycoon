<div class="w-full py-12 max-w-8xl mx-auto px-4 relative">
    <h2 class="text-4xl font-bold text-gray-900 mb-10 leading-tight capitalize font-quantico">
        The best way to buy the <br> products you love.
    </h2>

    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
        @if ($categories->isNotEmpty())
            @foreach ($categories as $item)
                <a href="{{ route('categories.show', $item->slug) }}" class="group block">
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm flex flex-col h-40 p-4">

                        <div class="flex-grow flex items-center justify-center">

                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                class="h-16 md:h-24 object-contain">
                        </div>

                        <div class="pt-4">
                            <p class="text-sm md:text-base font-medium text-black text-center font-cambay line-clamp-1">
                                {{ $item->name }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <p class="text-gray-500 col-span-full text-center">No featured categories found.</p>
        @endif
    </div>

    <div class="absolute right-4 md:-right-10 bottom-4 md:bottom-[4.5rem]">
        <a href="{{ route('categories.index') }}"
            class="inline-block transform rotate-90 px-2.5 py-1 bg-primary text-white text-xs font-inter font-normal tracking-wide rounded-md">
            View All
        </a>
    </div>

</div>
