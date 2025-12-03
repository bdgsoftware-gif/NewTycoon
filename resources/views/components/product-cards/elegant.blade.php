<!-- Elegant Card Style -->
<a href="{{ route('product.show', $product['slug']) }}" class="block group">
    <div
        class="bg-white rounded-lg border border-gray-200 hover:shadow-lg transition-all duration-300 overflow-hidden h-full">
        <!-- Image -->
        <div class="h-52 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center relative">
            <img src="{{ asset($product['images'][0]) }}" alt="{{ $product['name'] }}"
                class="max-h-36 object-contain transition-transform duration-500 group-hover:scale-110">

            <!-- Stock Badge -->
            @if (!$product['in_stock'])
                <div class="absolute top-3 right-3 bg-gray-600 text-white text-xs font-semibold px-2 py-1 rounded">
                    OUT OF STOCK
                </div>
            @endif
        </div>

        <!-- Content -->
        <div class="p-4">
            <div class="flex items-start justify-between mb-3">
                <h3 class="font-medium text-gray-900 text-sm flex-1 pr-2 line-clamp-2">
                    {{ $product['name'] }}
                </h3>
                @if ($product['is_new'])
                    <span class="bg-primary text-white text-xs font-semibold px-2 py-1 rounded shrink-0">
                        NEW
                    </span>
                @endif
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-baseline space-x-2">
                    <span class="text-lg font-bold text-gray-900">
                        ${{ number_format($product['discounted_price'], 2) }}
                    </span>
                    @if ($product['discount_percentage'] > 0)
                        <span class="text-sm text-gray-400 line-through">
                            ${{ number_format($product['original_price'], 2) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</a>
