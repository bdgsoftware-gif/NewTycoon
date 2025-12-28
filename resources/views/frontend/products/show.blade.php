@extends('frontend.layouts.app')

@section('title', $product->name)
@section('description', $product->short_description)

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex flex-wrap items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition-colors">
                        Home
                    </a>
                </li>
                @if ($product->category)
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <a href="{{ route('categories.show', $product->category->slug) }}"
                            class="text-gray-500 hover:text-primary transition-colors">
                            {{ $product->category->name }}
                        </a>
                    </li>
                @endif
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-900 font-medium">{{ Str::limit($product->name, 50) }}</span>
                </li>
            </ol>
        </nav>

        <!-- Product Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Product Images -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden p-4 lg:p-8">
                    <img id="mainImage" src="{{ $product->featured_image_url }}" alt="{{ $product->name }}"
                        class="w-full max-h-[500px] object-contain">
                </div>

                <!-- Thumbnails -->
                @php
                    $galleryImages = $product->gallery_images_urls ?? [];
                    $allImages = array_merge([$product->featured_image_url], $galleryImages);
                @endphp
                @if (count($allImages) > 1)
                    <div class="grid grid-cols-4 sm:grid-cols-6 lg:grid-cols-4 gap-2">
                        @foreach ($allImages as $index => $image)
                            <button onclick="changeMainImage('{{ $image }}')"
                                class="border border-gray-200 rounded-lg p-1 sm:p-2 hover:border-primary transition-colors {{ $index === 0 ? 'border-2 border-primary' : '' }}">
                                <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}"
                                    class="w-full aspect-square object-cover rounded">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info - Clean Design -->
            <div class="space-y-6">
                <!-- Product Header -->
                <div class="border-b border-gray-200 pb-4">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2">
                        {{ $product->name }}
                    </h1>
                    @if ($product->sku)
                        <p class="text-gray-500 text-sm">SKU: {{ $product->sku }}</p>
                    @endif
                </div>

                <!-- Ratings and Price -->
                <div class="space-y-4">
                    <!-- Ratings -->
                    <div class="flex items-center gap-3">
                        <div class="flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= floor($product->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="text-gray-600">
                            {{ number_format($product->average_rating, 1) }} ({{ $product->rating_count }} reviews)
                        </span>
                        @if ($product->total_sold > 0)
                            <span class="text-gray-500 text-sm">
                                • {{ $product->total_sold }} sold
                            </span>
                        @endif
                    </div>

                    <!-- Price -->
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-3xl sm:text-4xl font-bold text-gray-900">
                                TK{{ number_format($product->price, 2) }}
                            </span>
                            @if ($product->compare_price > $product->price)
                                <span class="text-xl text-gray-500 line-through">
                                    TK{{ number_format($product->compare_price, 2) }}
                                </span>
                                <span class="px-3 py-1 bg-red-100 text-red-600 text-sm font-semibold rounded-full">
                                    Save
                                    {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                                </span>
                            @endif
                        </div>
                        @if ($product->discount_percentage)
                            <p class="mt-1 text-green-600 text-sm">
                                {{ $product->discount_percentage }}% discount applied
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Stock Status -->
                <div
                    class="p-4 rounded-lg {{ $product->stock_status === 'in_stock' ? 'bg-green-50' : ($product->stock_status === 'out_of_stock' ? 'bg-red-50' : 'bg-yellow-50') }}">
                    <div class="flex items-start">
                        @if ($product->stock_status === 'in_stock')
                            <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div>
                                <p class="font-semibold text-green-700">In Stock</p>
                                <p class="text-sm text-green-600 mt-1">
                                    {{ $product->quantity }} units available
                                    @if ($product->is_low_stock)
                                        <span class="text-orange-600">• Low Stock</span>
                                    @endif
                                </p>
                            </div>
                        @elseif($product->stock_status === 'out_of_stock')
                            <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <p class="font-semibold text-red-700">Out of Stock</p>
                        @else
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="font-semibold text-yellow-700">Backorder Available</p>
                                <p class="text-sm text-yellow-600 mt-1">Order now, ships when available</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Short Description -->
                @if ($product->short_description)
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->short_description }}</p>
                    </div>
                @endif

                <!-- Quantity and Add to Cart -->
                @if ($product->stock_status === 'in_stock' || $product->stock_status === 'backorder')
                    <div class="space-y-4">
                        <!-- Quantity -->
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Quantity</h3>
                            <div class="flex items-center border border-gray-300 rounded-lg w-32">
                                <button type="button" onclick="decrementQuantity()"
                                    class="px-3 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-l-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 12H4" />
                                    </svg>
                                </button>
                                <input type="text" name="quantity" id="quantity" value="1" min="1"
                                    max="{{ $product->quantity }}" class="w-16 text-center border-0 focus:ring-0">
                                <button type="button" onclick="incrementQuantity()"
                                    class="px-3 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-r-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" id="cartQuantity" value="1">
                                <button type="submit"
                                    class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>

                            <form action="{{ route('checkout.process', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" id="buyNowQuantity" value="1">
                                <button type="submit"
                                    class="w-full bg-accent hover:bg-accent/90 text-white font-semibold py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Buy Now
                                </button>
                            </form>
                        </div>

                        <button
                            class="w-full border border-gray-300 hover:border-primary text-gray-700 hover:text-primary font-semibold py-3 rounded-lg transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Add to Wishlist
                        </button>
                    </div>
                @else
                    <div class="text-center py-4">
                        <button disabled
                            class="w-full max-w-md bg-gray-300 text-gray-500 font-semibold py-3 px-6 rounded-lg cursor-not-allowed mx-auto">
                            Out of Stock
                        </button>
                        <p class="text-gray-500 text-sm mt-2">We'll notify you when this product is back in stock</p>
                    </div>
                @endif

                <!-- Product Details -->
                <div class="border-t border-gray-200 pt-6 space-y-4">
                    <h3 class="font-semibold text-gray-900">Product Details</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @if ($product->category)
                            <div class="flex items-center">
                                <span class="text-gray-500 w-28">Category:</span>
                                <a href="{{ route('categories.show', $product->category->slug) }}"
                                    class="text-primary hover:text-primary/80 font-medium ml-2 truncate">
                                    {{ $product->category->name }}
                                </a>
                            </div>
                        @endif

                        @if ($product->model_number)
                            <div class="flex items-center">
                                <span class="text-gray-500 w-28">Model:</span>
                                <span class="font-medium ml-2 truncate">{{ $product->model_number }}</span>
                            </div>
                        @endif

                        @if ($product->weight)
                            <div class="flex items-center">
                                <span class="text-gray-500 w-28">Weight:</span>
                                <span class="font-medium ml-2 truncate">{{ $product->weight }} kg</span>
                            </div>
                        @endif

                        @if ($product->warranty_period && $product->warranty_type)
                            <div class="flex items-center">
                                <span class="text-gray-500 w-28">Warranty:</span>
                                <span class="font-medium ml-2 truncate">{{ $product->warranty_period }}
                                    {{ $product->warranty_type }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Share Product -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Share this product</h3>
                    <div class="flex items-center space-x-3">
                        <button onclick="shareProduct()"
                            class="flex items-center text-gray-600 hover:text-primary transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            Share
                        </button>

                        <button class="flex items-center text-gray-600 hover:text-primary transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Secure Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description & Details Tabs -->
        <div class="mb-12">
            <div class="border-b border-gray-200">
                <div class="flex overflow-x-auto">
                    <nav class="flex min-w-max">
                        <button onclick="showTab('description')" id="descriptionTabBtn"
                            class="tab-button py-4 px-6 border-b-2 font-medium text-sm whitespace-nowrap border-primary text-primary">
                            Description
                        </button>
                        <button onclick="showTab('specifications')" id="specificationsTabBtn"
                            class="tab-button py-4 px-6 border-b-2 font-medium text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700">
                            Specifications
                        </button>
                        <button onclick="showTab('reviews')" id="reviewsTabBtn"
                            class="tab-button py-4 px-6 border-b-2 font-medium text-sm whitespace-nowrap border-transparent text-gray-500 hover:text-gray-700">
                            Reviews ({{ $product->rating_count }})
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="py-8">
                <!-- Description Tab -->
                <div id="descriptionTab" class="tab-content space-y-4">
                    @if ($product->description)
                        <div class="prose max-w-none">
                            {!! $product->description !!}
                        </div>
                    @else
                        <p class="text-gray-500">No description available.</p>
                    @endif
                </div>

                <!-- Specifications Tab -->
                <div id="specificationsTab" class="tab-content hidden">
                    <div class="space-y-8">
                        <!-- Basic Specifications Table -->
                        <div class="overflow-hidden border border-gray-200 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                            Specification
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                            Value
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if ($product->sku)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                SKU
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->sku }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($product->model_number)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Model Number
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->model_number }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($product->category)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Category
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->category->name }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($product->weight)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Weight
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->weight }} kg
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($product->length && $product->width && $product->height)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Dimensions (L×W×H)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->length }} × {{ $product->width }} × {{ $product->height }}
                                                cm
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($product->warranty_period && $product->warranty_type)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                Warranty
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->warranty_period }} {{ $product->warranty_type }}
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Stock Status
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $product->stock_status === 'in_stock'
                                                ? 'bg-green-100 text-green-800'
                                                : ($product->stock_status === 'out_of_stock'
                                                    ? 'bg-red-100 text-red-800'
                                                    : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ str_replace('_', ' ', ucfirst($product->stock_status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Additional Specifications -->
                        @if (!empty($product->specifications_array))
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Specifications</h3>
                                <div class="overflow-hidden border border-gray-200 rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                                    Feature
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                                    Details
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($product->specifications_array as $spec)
                                                @if (isset($spec['key']) && isset($spec['value']) && trim($spec['key']) && trim($spec['value']))
                                                    <tr>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            {{ $spec['key'] }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $spec['value'] }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- No Specifications Message -->
                        @if (empty($product->specifications_array) &&
                                !$product->weight &&
                                !$product->length &&
                                !$product->width &&
                                !$product->height &&
                                !$product->warranty_period)
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-500">No specifications available for this product.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div id="reviewsTab" class="tab-content hidden">
                    @if ($product->reviews->count() > 0)
                        <div class="space-y-6">
                            <!-- Average Rating Summary -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex flex-col sm:flex-row items-center sm:items-start justify-between">
                                    <div class="text-center sm:text-left mb-4 sm:mb-0">
                                        <div class="text-4xl font-bold text-gray-900 mb-2">
                                            {{ number_format($product->average_rating, 1) }}
                                        </div>
                                        <div class="flex items-center justify-center sm:justify-start mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-6 h-6 {{ $i <= floor($product->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <p class="text-gray-600">{{ $product->rating_count }} customer reviews</p>
                                    </div>

                                    <!-- Write Review Button -->
                                    <button
                                        class="px-6 py-3 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg transition-colors">
                                        Write a Review
                                    </button>
                                </div>
                            </div>

                            <!-- Reviews List -->
                            <div class="space-y-6">
                                @foreach ($product->reviews as $review)
                                    <div class="border border-gray-200 rounded-lg p-6">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4">
                                            <div class="flex items-center mb-3 sm:mb-0">
                                                <div
                                                    class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                                    <span class="font-semibold text-gray-700">
                                                        {{ substr($review->user->name ?? 'User', 0, 1) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-gray-900">
                                                        {{ $review->user->name ?? 'Anonymous' }}
                                                    </h4>
                                                    <div class="flex items-center">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-gray-500 text-sm">
                                                {{ $review->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600">{{ $review->comment }}</p>

                                        @if ($review->reply)
                                            <div class="mt-4 p-4 bg-gray-50 rounded-lg border-l-4 border-primary">
                                                <div class="flex items-center mb-2">
                                                    <svg class="w-4 h-4 text-primary mr-2" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="font-semibold text-gray-900">Store Response</span>
                                                </div>
                                                <p class="text-gray-600 text-sm">{{ $review->reply }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Reviews Yet</h3>
                            <p class="text-gray-500 mb-6">Be the first to review this product!</p>
                            <button
                                class="px-6 py-3 bg-primary hover:bg-primary/90 text-white font-semibold rounded-lg transition-colors">
                                Write a Review
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if (isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $related)
                        <div
                            class="group bg-white border border-gray-200 hover:border-primary rounded-xl overflow-hidden transition-all duration-300">
                            <a href="{{ route('product.show', $related->slug) }}" class="block">
                                <div class="aspect-square bg-gray-50 p-4">
                                    <img src="{{ $related->featured_image_url }}" alt="{{ $related->name }}"
                                        class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="p-4">
                                    <h3
                                        class="font-medium text-gray-900 text-sm mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                        {{ $related->name }}
                                    </h3>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-bold text-gray-900">
                                                TK{{ number_format($related->price, 2) }}
                                            </span>
                                            @if ($related->compare_price > $related->price)
                                                <span class="text-xs text-gray-500 line-through ml-1">
                                                    TK{{ number_format($related->compare_price, 2) }}
                                                </span>
                                            @endif
                                        </div>
                                        @if ($related->stock_status === 'in_stock')
                                            <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded">In
                                                Stock</span>
                                        @endif
                                    </div>
                                    <!-- Rating -->
                                    @if ($related->average_rating > 0)
                                        <div class="flex items-center mt-2">
                                            <div class="flex items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= floor($related->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-500 ml-1">
                                                ({{ $related->rating_count }})
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            // Image Gallery
            function changeMainImage(src) {
                document.getElementById('mainImage').src = src;
                // Update active thumbnail
                document.querySelectorAll('#featuredUploadArea + div button').forEach((btn, index) => {
                    if (btn.querySelector('img').src === src) {
                        btn.classList.add('border-2', 'border-primary');
                    } else {
                        btn.classList.remove('border-2', 'border-primary');
                        btn.classList.add('border');
                    }
                });
            }

            // Quantity Controls
            function incrementQuantity() {
                const input = document.getElementById('quantity');
                const max = parseInt(input.max);
                if (parseInt(input.value) < max) {
                    const newValue = parseInt(input.value) + 1;
                    input.value = newValue;
                    document.getElementById('cartQuantity').value = newValue;
                    document.getElementById('buyNowQuantity').value = newValue;
                }
            }

            function decrementQuantity() {
                const input = document.getElementById('quantity');
                if (parseInt(input.value) > 1) {
                    const newValue = parseInt(input.value) - 1;
                    input.value = newValue;
                    document.getElementById('cartQuantity').value = newValue;
                    document.getElementById('buyNowQuantity').value = newValue;
                }
            }

            // Update hidden quantity inputs when main input changes
            document.getElementById('quantity').addEventListener('input', function() {
                const value = parseInt(this.value) || 1;
                document.getElementById('cartQuantity').value = value;
                document.getElementById('buyNowQuantity').value = value;
            });

            // Tab System
            function showTab(tabName) {
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });

                // Remove active class from all tab buttons
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.classList.remove('border-primary', 'text-primary');
                    button.classList.add('border-transparent', 'text-gray-500');
                });

                // Show selected tab content
                document.getElementById(tabName + 'Tab').classList.remove('hidden');

                // Add active class to selected tab button
                const tabBtn = document.getElementById(tabName + 'TabBtn');
                if (tabBtn) {
                    tabBtn.classList.add('border-primary', 'text-primary');
                    tabBtn.classList.remove('border-transparent', 'text-gray-500');
                }
            }

            // Share Product
            function shareProduct() {
                if (navigator.share) {
                    navigator.share({
                        title: '{{ $product->name }}',
                        text: 'Check out this product!',
                        url: window.location.href
                    });
                } else {
                    // Fallback for browsers that don't support Web Share API
                    const shareUrl = window.location.href;
                    navigator.clipboard.writeText(shareUrl).then(() => {
                        alert('Link copied to clipboard!');
                    });
                }
            }
        </script>
    @endpush
@endsection
