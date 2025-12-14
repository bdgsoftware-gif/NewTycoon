@extends('frontend.layouts.app')

@section('title', $product->name)
@section('description', $product->short_description)

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 font-inter">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-primary">Home</a></li>
                @if ($product->category)
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <a href="{{ route('categories.show', $product->category->slug) }}"
                            class="text-gray-500 hover:text-primary">{{ $product->category->name }}</a>
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
            <div>
                <!-- Main Image -->
                <div class="mb-4 bg-white border border-gray-200 rounded-xl overflow-hidden">
                    <img id="mainImage" src="{{ $product->featured_image_url }}" alt="{{ $product->name }}"
                        class="w-full aspect-square object-contain p-4">
                </div>

                <!-- Thumbnails -->
                @php
                    $galleryImages = $product->gallery_images_urls ?? [];
                    $allImages = array_merge([$product->featured_image_url], $galleryImages);
                @endphp
                @if (count($allImages) > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach ($allImages as $index => $image)
                            <button onclick="changeMainImage('{{ $image }}')"
                                class="border border-gray-200 rounded-lg p-2 hover:border-primary transition-colors">
                                <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}"
                                    class="w-full aspect-square object-contain">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <!-- Product Header -->
                <div class="mb-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2 font-quantico">{{ $product->name }}</h1>
                    @if ($product->sku)
                        <p class="text-gray-500 text-sm font-inter">SKU: {{ $product->sku }}</p>
                    @endif
                </div>

                <!-- Ratings -->
                <div class="flex items-center mb-4">
                    <div class="flex items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= floor($product->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="ml-2 text-gray-600 font-inter">{{ number_format($product->average_rating, 1) }}
                        ({{ $product->rating_count }} reviews)</span>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <div class="flex items-center gap-3">
                        <span
                            class="text-3xl font-bold text-gray-900 font-quantico">TK{{ number_format($product->price, 2) }}</span>
                        @if ($product->compare_price > $product->price)
                            <span
                                class="text-xl text-gray-500 line-through font-inter">TK{{ number_format($product->compare_price, 2) }}</span>
                            <span class="px-2 py-1 bg-red-100 text-red-600 text-sm font-semibold rounded font-inter">
                                Save
                                {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Stock Status -->
                <div class="mb-6">
                    @if ($product->stock_status === 'in_stock')
                        <div class="flex items-center text-green-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="font-semibold font-inter">In Stock</span>
                            <span class="ml-2 text-gray-600 font-inter">Quantity: {{ $product->quantity }}</span>
                        </div>
                    @elseif($product->stock_status === 'out_of_stock')
                        <div class="flex items-center text-red-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="font-semibold font-inter">Out of Stock</span>
                        </div>
                    @else
                        <div class="flex items-center text-orange-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-semibold font-inter">Backorder Available</span>
                        </div>
                    @endif
                </div>

                <!-- Short Description -->
                @if ($product->short_description)
                    <div class="mb-6">
                        <p class="text-gray-600 font-inter">{{ $product->short_description }}</p>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="space-y-4 mb-8">
                    @if ($product->stock_status === 'in_stock' || $product->stock_status === 'backorder')
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex gap-3">
                            @csrf
                            <!-- Quantity -->
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" onclick="decrementQuantity()"
                                    class="px-3 py-2 text-gray-600 hover:text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 12H4" />
                                    </svg>
                                </button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1"
                                    max="{{ $product->quantity }}" class="w-16 text-center border-0 focus:ring-0">
                                <button type="button" onclick="incrementQuantity()"
                                    class="px-3 py-2 text-gray-600 hover:text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Add to Cart -->
                            <button type="submit"
                                class="flex-1 bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-6 rounded-lg transition-colors font-inter">
                                Add to Cart
                            </button>

                            <!-- Buy Now -->
                            <a href="{{ route('checkout.process', $product->id) }}"
                                class="px-6 bg-accent hover:bg-accent-dark text-white font-semibold py-3 rounded-lg transition-colors font-inter">
                                Buy Now
                            </a>
                        </form>
                    @else
                        <button disabled
                            class="w-full bg-gray-300 text-gray-500 font-semibold py-3 px-6 rounded-lg cursor-not-allowed font-inter">
                            Out of Stock
                        </button>
                    @endif

                    <!-- Wishlist Button -->
                    <button
                        class="w-full border border-gray-300 hover:border-primary text-gray-700 hover:text-primary font-semibold py-3 rounded-lg transition-colors flex items-center justify-center font-inter">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Add to Wishlist
                    </button>
                </div>

                <!-- Product Meta -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="grid grid-cols-2 gap-4">
                        @if ($product->category)
                            <div>
                                <span class="text-gray-500 font-inter">Category:</span>
                                <a href="{{ route('categories.show', $product->category->slug) }}"
                                    class="ml-2 text-primary hover:text-primary-dark font-medium font-inter">
                                    {{ $product->category->name }}
                                </a>
                            </div>
                        @endif
                        @if ($product->brand)
                            <div>
                                <span class="text-gray-500 font-inter">Brand:</span>
                                <span class="ml-2 font-medium font-inter">{{ $product->brand->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Description & Details Tabs -->
        <div class="mb-12">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8">
                    <button onclick="showTab('description')"
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm font-quantico"
                        :class="{ 'border-primary text-primary': activeTab === 'description' }">
                        Description
                    </button>
                    <button onclick="showTab('specifications')"
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm font-quantico"
                        :class="{ 'border-primary text-primary': activeTab === 'specifications' }">
                        Specifications
                    </button>
                    <button onclick="showTab('reviews')"
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm font-quantico"
                        :class="{ 'border-primary text-primary': activeTab === 'reviews' }">
                        Reviews ({{ $product->rating_count }})
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="py-8">
                <!-- Description Tab -->
                <div id="descriptionTab" class="tab-content">
                    <div class="prose max-w-none">
                        {!! $product->description !!}
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div id="specificationsTab" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-600 font-inter">Weight</span>
                                <span
                                    class="font-medium font-inter">{{ $product->weight ? $product->weight . ' kg' : 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-600 font-inter">Dimensions</span>
                                <span class="font-medium font-inter">
                                    {{ $product->length && $product->width && $product->height
                                        ? $product->length . '×' . $product->width . '×' . $product->height . ' cm'
                                        : 'N/A' }}
                                </span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-600 font-inter">SKU</span>
                                <span class="font-medium font-inter">{{ $product->sku }}</span>
                            </div>
                            <div class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-600 font-inter">Stock Status</span>
                                <span
                                    class="font-medium font-inter capitalize">{{ str_replace('_', ' ', $product->stock_status) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div id="reviewsTab" class="tab-content hidden">
                    @if ($product->reviews->count() > 0)
                        <div class="space-y-6">
                            @foreach ($product->reviews as $review)
                                <div class="border border-gray-200 rounded-lg p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                                <span class="font-semibold text-gray-700 font-inter">
                                                    {{ substr($review->user->name ?? 'User', 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 font-inter">
                                                    {{ $review->user->name ?? 'Anonymous' }}</h4>
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
                                        <span
                                            class="text-gray-500 text-sm font-inter">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <p class="text-gray-600 font-inter">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <p class="text-gray-500 font-inter">No reviews yet. Be the first to review this product!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if ($relatedProducts->count() > 0)
            <div class="border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-quantico">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $related)
                        <div
                            class="group bg-white border border-gray-200 hover:border-primary rounded-xl overflow-hidden transition-all duration-300">
                            <a href="{{ route('product.show', $related->slug) }}" class="block p-4">
                                <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden mb-4">
                                    <img src="{{ $related->featured_image_url }}" alt="{{ $related->name }}"
                                        class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <h3
                                    class="font-medium text-gray-900 text-sm mb-2 line-clamp-2 group-hover:text-primary transition-colors font-quantico">
                                    {{ $related->name }}
                                </h3>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="font-bold text-gray-900 font-quantico">TK{{ number_format($related->price, 2) }}</span>
                                    @if ($related->stock_status === 'in_stock')
                                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded">In Stock</span>
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
            }

            // Quantity Controls
            function incrementQuantity() {
                const input = document.getElementById('quantity');
                const max = parseInt(input.max);
                if (parseInt(input.value) < max) {
                    input.value = parseInt(input.value) + 1;
                }
            }

            function decrementQuantity() {
                const input = document.getElementById('quantity');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            }

            // Tab System
            let activeTab = 'description';

            function showTab(tabName) {
                activeTab = tabName;

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
                event.target.classList.add('border-primary', 'text-primary');
                event.target.classList.remove('border-transparent', 'text-gray-500');
            }

            // Initialize first tab
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('.tab-button').classList.add('border-primary', 'text-primary');
            });
        </script>
    @endpush

    <style>
        .prose img {
            max-width: 100%;
            height: auto;
        }

        .prose ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin: 1rem 0;
        }

        .prose ol {
            list-style-type: decimal;
            padding-left: 1.5rem;
            margin: 1rem 0;
        }

        .prose p {
            margin: 1rem 0;
            line-height: 1.6;
        }
    </style>
@endsection
