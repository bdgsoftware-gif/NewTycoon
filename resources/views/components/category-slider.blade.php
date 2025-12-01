<div class="w-full py-12 max-w-8xl mx-auto px-4">
    <h2 class="text-4xl font-bold text-gray-900 mb-10 leading-tight capitalize font-quantico">
        The best way to buy the <br> products you love.
    </h2>

    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-5">
        @if (count($categories) > 0)
            @foreach ($categories as $item)
                <a href="{{ url('category/' . $item['id']) }}" class="group block">
                    <div
                        class="bg-gray-100 rounded-2xl shadow-sm border border-gray-100
                               
                               flex flex-col items-center justify-center p-5 h-40">
                        <img src="{{ asset($item['imageUrl']) }}" alt="{{ $item['name'] }}"
                            class="h-16 object-contain mb-3 group-hover:scale-105 transition-all duration-300">

                        <p class="text-sm font-medium text-gray-700 text-center font-cambay">
                            {{ $item['name'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        @else
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500">No categories found.</p>
            </div>
        @endif
    </div>
</div>
