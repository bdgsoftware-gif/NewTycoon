<div class="w-full py-12 max-w-8xl mx-auto px-4">
    <h2 class="text-4xl font-bold text-gray-900 mb-10 leading-tight capitalize font-quantico">
        The best way to buy the <br> products you love.
    </h2>

    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
        @if (count($categories) > 0)
            @foreach ($categories as $item)
                <a href="{{ url('category/' . $item['id']) }}" class="group block">
                    <div
                        class="bg-white rounded-xl border border-gray-100 shadow-sm flex flex-col h-40 p-4">
                        <!-- Image container with flex-grow to push text down -->
                        <div class="flex-grow flex items-center justify-center">
                            <img src="{{ asset($item['imageUrl']) }}" alt="{{ $item['name'] }}"
                                class="h-16 md:h-24 object-contain">
                        </div>

                        <!-- Text container -->
                        <div class="pt-4">
                            <p
                                class="text-sm md:text-base font-medium text-black text-center font-cambay line-clamp-1">
                                {{ $item['name'] }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
</div>
