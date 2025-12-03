<!-- Modern Card Style -->
<a href="{{ route('product.show', $product['slug']) }}" class="block group">
    <div
        class="bg-white rounded-lg border border-gray-200 hover:border-primary transition-all duration-300 product-card-hover overflow-hidden shadow-sm hover:shadow-lg">
        <!-- Image Container -->
        <div class="relative h-56 bg-gray-50 overflow-hidden">
            <img src="{{ asset($product['images'][0]) }}" alt="{{ $product['name'] }}"
                class="w-full h-full object-contain p-4 transition-transform duration-300 group-hover:scale-105">

            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col space-y-1">
                @if ($product['is_new'])
                    <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded">
                        NEW
                    </span>
                @endif
                @if ($product['discount_percentage'] > 0)
                    <span class="bg-accent text-white text-xs font-semibold px-2 py-1 rounded">
                        -{{ $product['discount_percentage'] }}%
                    </span>
                @endif
            </div>

            <!-- Stock Status -->
            @if (!$product['in_stock'])
                <div class="absolute top-3 right-3">
                    <span class="bg-gray-600 text-white text-xs font-semibold px-2 py-1 rounded">
                        SOLD OUT
                    </span>
                </div>
            @endif

            <!-- Quick Action -->
            <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-all duration-300">
                <button class="bg-primary text-white p-2 rounded-full hover:bg-red-600 transition-colors shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4">
            <!-- Product Name -->
            <h3 class="font-medium text-gray-900 text-sm mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                {{ $product['name'] }}
            </h3>

            <!-- Price -->
            <div class="flex items-center justify-between">
                <div class="flex items-baseline space-x-2">
                    <span class="text-lg font-bold text-gray-900">
                        ${{ number_format($product['discounted_price'], 2) }}
                    </span>
                    @if ($product['discount_percentage'] > 0)
                        <span class="text-sm text-gray-500 line-through">
                            ${{ number_format($product['original_price'], 2) }}
                        </span>
                    @endif
                </div>

                <!-- Rating -->
                @if (isset($product['rating']))
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm text-gray-600">{{ $product['rating'] }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</a>
