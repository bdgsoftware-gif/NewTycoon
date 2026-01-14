@extends('admin.layouts.app')

@section('title', 'Product Details')
@section('page-title', 'Product Details')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.products.index') }}" class="text-primary hover:text-primary/80">Products</a>
    </li>
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">{{ $product->name_en }}</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Header with Actions -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Product Details</h1>
                    <p class="mt-1 text-sm text-gray-600">Complete information about the product</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.products.edit', $product) }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Product
                    </a>
                    <a href="{{ route('admin.products.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Products
                    </a>
                </div>
            </div>

            <!-- Product Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div
                            class="p-2 rounded-lg {{ $product->status == 'active' ? 'bg-green-100' : ($product->status == 'draft' ? 'bg-yellow-100' : ($product->status == 'inactive' ? 'bg-red-100' : 'bg-gray-100')) }}">
                            <svg class="h-6 w-6 {{ $product->status == 'active' ? 'text-green-600' : ($product->status == 'draft' ? 'text-yellow-600' : ($product->status == 'inactive' ? 'text-red-600' : 'text-gray-600')) }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if ($product->status == 'active')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @elseif($product->status == 'draft')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @endif
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600">Status</p>
                            <p
                                class="text-lg font-bold {{ $product->status == 'active' ? 'text-green-700' : ($product->status == 'draft' ? 'text-yellow-700' : ($product->status == 'inactive' ? 'text-red-700' : 'text-gray-700')) }}">
                                {{ ucfirst($product->status) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Stock Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg {{ $product->in_stock ? 'bg-blue-100' : 'bg-red-100' }}">
                            <svg class="h-6 w-6 {{ $product->in_stock ? 'text-blue-600' : 'text-red-600' }}" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600">Stock</p>
                            <p class="text-lg font-bold {{ $product->in_stock ? 'text-blue-700' : 'text-red-700' }}">
                                {{ $product->quantity }} units
                            </p>
                            @if ($product->is_low_stock)
                                <p class="text-xs text-red-600 mt-1">Low Stock Alert!</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Price Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600">Price</p>
                            <p class="text-lg font-bold text-gray-900">
                                <span class="font-bengali">৳</span>{{ number_format($product->price, 2) }}
                                @if ($product->compare_price)
                                    <span class="text-sm text-gray-500 line-through ml-2">
                                        <span class="font-bengali">৳</span>{{ number_format($product->compare_price, 2) }}
                                    </span>
                                @endif
                            </p>
                            @if ($product->discount_percentage)
                                <p class="text-xs text-green-600 mt-1">{{ $product->discount_percentage }}% OFF</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Flags Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <div class="flex items-center">
                        <div class="p-2 rounded-lg bg-purple-100">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-600">Flags</p>
                            <div class="flex items-center space-x-2 mt-1">
                                @if ($product->is_featured)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        Featured
                                    </span>
                                @endif
                                @if ($product->is_bestsells)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                        </svg>
                                        Bestseller
                                    </span>
                                @endif
                                @if ($product->is_new)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        New
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Product Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Product Images -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Product Images</h2>

                        <!-- Featured Images -->
                        <div class="mb-8">
                            <h3 class="text-sm font-medium text-gray-700 mb-4">Featured Images</h3>
                            <div class="grid grid-cols-2 gap-4">
                                @foreach ($product->featured_images as $index => $image)
                                    <div class="relative group aspect-square">
                                        <img src="{{ Storage::url($image) }}" alt="Featured Image {{ $index + 1 }}"
                                            class="w-full h-full object-cover rounded-lg">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                            <a href="{{ Storage::url($image) }}" target="_blank"
                                                class="px-3 py-1.5 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                View Full Size
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Gallery Images -->
                        @if (count($product->gallery_images) > 0)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-4">Gallery Images</h3>
                                <div class="grid grid-cols-4 gap-4">
                                    @foreach ($product->gallery_images as $index => $image)
                                        <div class="relative group aspect-square">
                                            <img src="{{ Storage::url($image) }}"
                                                alt="Gallery Image {{ $index + 1 }}"
                                                class="w-full h-full object-cover rounded-lg">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                                <a href="{{ Storage::url($image) }}" target="_blank"
                                                    class="px-2 py-1 bg-white rounded text-xs font-medium text-gray-700 hover:bg-gray-50">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Product Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Product Information</h2>

                        <div class="space-y-6">
                            <!-- Basic Info -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-3">Basic Information</h3>
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500">English Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $product->name_en }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500">Bengali Name</dt>
                                        <dd class="font-bengali mt-1 text-sm text-gray-900">
                                            {{ $product->name_bn ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500">SKU</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $product->sku }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500">Model Number</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $product->model_number ?? 'N/A' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500">Slug</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $product->slug }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-medium text-gray-500">Category</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            <a href="{{ route('admin.categories.show', $product->category) }}"
                                                class="text-primary hover:text-primary/80">
                                                {{ $product->category->name_en ?? 'N/A' }}
                                            </a>
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Descriptions -->
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Short Description</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500">English</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ $product->short_description_en ?? 'N/A' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500">Bengali</dt>
                                            <dd class="font-bengali mt-1 text-sm text-gray-900">
                                                {{ $product->short_description_bn ?? 'N/A' }}</dd>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Full Description</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500">English</dt>
                                            <dd class="mt-1 text-sm text-gray-900 prose prose-sm max-w-none">
                                                {!! nl2br(e($product->description_en)) !!}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500">Bengali</dt>
                                            <dd class="font-bengali mt-1 text-sm text-gray-900 prose prose-sm max-w-none">
                                                {!! nl2br(e($product->description_bn ?? 'N/A')) !!}
                                            </dd>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Specifications -->
                    @if (!empty($product->specifications))
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6">Specifications</h2>

                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Key
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Value
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($product->specifications as $spec)
                                            <tr>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $spec['key'] }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                    {{ $spec['value'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Sales & Order Data -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Sales & Order Data</h2>

                        <div class="space-y-4">
                            <!-- Order Items -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-3">Order History</h3>
                                @if ($product->orderItems->count() > 0)
                                    <div class="overflow-hidden">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500">
                                                        Order ID
                                                    </th>
                                                    <th scope="col"
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500">
                                                        Quantity
                                                    </th>
                                                    <th scope="col"
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500">
                                                        Unit Price
                                                    </th>
                                                    <th scope="col"
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500">
                                                        Total
                                                    </th>
                                                    <th scope="col"
                                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500">
                                                        Date
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @foreach ($product->orderItems->take(5) as $item)
                                                    <tr>
                                                        <td class="px-4 py-2 text-sm">
                                                            <a href="{{ route('admin.orders.show', $item->order) }}"
                                                                class="text-primary hover:text-primary/80">
                                                                #{{ $item->order->order_number ?? 'N/A' }}
                                                            </a>
                                                        </td>
                                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $item->quantity }}
                                                        </td>
                                                        <td class="px-4 py-2 text-sm text-gray-900">
                                                            <span
                                                                class="font-bengali">৳</span>{{ number_format($item->unit_price, 2) }}
                                                        </td>
                                                        <td class="px-4 py-2 text-sm text-gray-900">
                                                            <span
                                                                class="font-bengali">৳</span>{{ number_format($item->total_price, 2) }}
                                                        </td>
                                                        <td class="px-4 py-2 text-sm text-gray-500">
                                                            {{ $item->created_at->format('M d, Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if ($product->orderItems->count() > 5)
                                            <div class="text-center mt-4">
                                                <a href="{{ route('admin.orders.index', ['product_id' => $product->id]) }}"
                                                    class="text-sm text-primary hover:text-primary/80">
                                                    View all {{ $product->orderItems->count() }} orders
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No orders yet</p>
                                @endif
                            </div>

                            <!-- Reviews -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-3">Customer Reviews</h3>
                                @if ($product->reviews->count() > 0)
                                    <div class="space-y-3">
                                        @foreach ($product->reviews->take(3) as $review)
                                            <div class="border border-gray-200 rounded-lg p-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $review->customer_name ?? 'Anonymous' }}
                                                        </div>
                                                        <div class="ml-3 flex items-center">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-sm text-gray-700">{{ $review->comment }}</p>
                                            </div>
                                        @endforeach
                                        @if ($product->reviews->count() > 3)
                                            <div class="text-center">
                                                <a href="{{ route('admin.reviews.index', ['product_id' => $product->id]) }}"
                                                    class="text-sm text-primary hover:text-primary/80">
                                                    View all {{ $product->reviews->count() }} reviews
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No reviews yet</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Additional Info -->
                <div class="space-y-6">
                    <!-- Pricing Details -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Pricing Details</h2>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Selling Price</span>
                                <span class="text-lg font-bold text-gray-900"><span
                                        class="font-bengali">৳</span>{{ number_format($product->price, 2) }}</span>
                            </div>

                            @if ($product->compare_price)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Compare Price</span>
                                    <span class="text-lg text-gray-500 line-through"><span
                                            class="font-bengali">৳</span>{{ number_format($product->compare_price, 2) }}</span>
                                </div>
                            @endif

                            @if ($product->cost_price)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Cost Price</span>
                                    <span class="text-lg text-gray-900"><span
                                            class="font-bengali">৳</span>{{ number_format($product->cost_price, 2) }}</span>
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm font-medium text-gray-700">Profit Margin</span>
                                        <span class="text-lg font-bold text-green-600">
                                            @php
                                                $profit = $product->price - $product->cost_price;
                                                $margin =
                                                    $product->cost_price > 0
                                                        ? ($profit / $product->cost_price) * 100
                                                        : 0;
                                            @endphp
                                            {{ number_format($margin, 2) }}%
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-700">Profit per Unit</span>
                                        <span class="text-lg font-bold text-green-600"><span
                                                class="font-bengali">৳</span>{{ number_format($profit, 2) }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($product->discount_percentage)
                                <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                    <span class="text-sm font-medium text-gray-700">Discount</span>
                                    <span
                                        class="text-lg font-bold text-green-600">{{ $product->discount_percentage }}%</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Inventory Details -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Inventory Details</h2>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Current Stock</span>
                                <span
                                    class="text-lg font-bold {{ $product->quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->quantity }} units
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Stock Status</span>
                                <span
                                    class="px-2 py-1 rounded text-xs font-medium 
                                    {{ $product->stock_status == 'in_stock'
                                        ? 'bg-green-100 text-green-800'
                                        : ($product->stock_status == 'out_of_stock'
                                            ? 'bg-red-100 text-red-800'
                                            : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst(str_replace('_', ' ', $product->stock_status)) }}
                                </span>
                            </div>

                            @if ($product->track_quantity)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Alert Quantity</span>
                                    <span class="text-lg text-gray-900">{{ $product->alert_quantity ?? 5 }} units</span>
                                </div>

                                @if ($product->is_low_stock)
                                    <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-red-400 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.732 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                            </svg>
                                            <span class="text-sm font-medium text-red-800">Low Stock Warning</span>
                                        </div>
                                        <p class="mt-1 text-xs text-red-600">
                                            Stock is below alert level ({{ $product->alert_quantity }} units)
                                        </p>
                                    </div>
                                @endif
                            @endif

                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Track Quantity</span>
                                <span
                                    class="px-2 py-1 rounded text-xs font-medium 
                                    {{ $product->track_quantity ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $product->track_quantity ? 'Yes' : 'No' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Allow Backorders</span>
                                <span
                                    class="px-2 py-1 rounded text-xs font-medium 
                                    {{ $product->allow_backorder ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $product->allow_backorder ? 'Yes' : 'No' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping & Dimensions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Shipping & Dimensions</h2>

                        <div class="space-y-4">
                            @if ($product->weight)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Weight</span>
                                    <span class="text-sm text-gray-900">{{ $product->weight }} kg</span>
                                </div>
                            @endif

                            @if ($product->length || $product->width || $product->height)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Dimensions</h3>
                                    <div class="grid grid-cols-3 gap-2">
                                        @if ($product->length)
                                            <div class="text-center">
                                                <span class="block text-xs text-gray-500">Length</span>
                                                <span
                                                    class="block text-sm font-medium text-gray-900">{{ $product->length }}
                                                    cm</span>
                                            </div>
                                        @endif
                                        @if ($product->width)
                                            <div class="text-center">
                                                <span class="block text-xs text-gray-500">Width</span>
                                                <span
                                                    class="block text-sm font-medium text-gray-900">{{ $product->width }}
                                                    cm</span>
                                            </div>
                                        @endif
                                        @if ($product->height)
                                            <div class="text-center">
                                                <span class="block text-xs text-gray-500">Height</span>
                                                <span
                                                    class="block text-sm font-medium text-gray-900">{{ $product->height }}
                                                    cm</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if (!$product->weight && !$product->length && !$product->width && !$product->height)
                                <p class="text-sm text-gray-500">No shipping details provided</p>
                            @endif
                        </div>
                    </div>

                    <!-- Warranty Information -->
                    @if ($product->warranty_duration && $product->warranty_unit)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-6">Warranty Information</h2>

                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Duration</span>
                                    <span class="text-sm text-gray-900">{{ $product->warranty_duration }}
                                        {{ $product->warranty_unit }}</span>
                                </div>

                                @if ($product->warranty_type)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-700">Type</span>
                                        <span class="text-sm text-gray-900">{{ ucfirst($product->warranty_type) }}</span>
                                    </div>
                                @endif

                                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-blue-400 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        <span class="text-sm font-medium text-blue-800">Warranty Expiry</span>
                                    </div>
                                    <p class="mt-1 text-xs text-blue-600">
                                        If purchased today: {{ $product->getWarrantyExpiryDate()->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- SEO Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">SEO Information</h2>

                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Meta Titles</h3>
                                <div class="space-y-2">
                                    @if ($product->meta_title_en)
                                        <div>
                                            <span class="text-xs text-gray-500">English</span>
                                            <p class="text-sm text-gray-900 truncate">{{ $product->meta_title_en }}</p>
                                        </div>
                                    @endif
                                    @if ($product->meta_title_bn)
                                        <div>
                                            <span class="text-xs text-gray-500">Bengali</span>
                                            <p class="font-bengali text-sm text-gray-900 truncate">
                                                {{ $product->meta_title_bn }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Meta Descriptions</h3>
                                <div class="space-y-2">
                                    @if ($product->meta_description_en)
                                        <div>
                                            <span class="text-xs text-gray-500">English</span>
                                            <p class="text-sm text-gray-900 line-clamp-2">
                                                {{ $product->meta_description_en }}</p>
                                        </div>
                                    @endif
                                    @if ($product->meta_description_bn)
                                        <div>
                                            <span class="text-xs text-gray-500">Bengali</span>
                                            <p class="font-bengali text-sm text-gray-900 line-clamp-2">
                                                {{ $product->meta_description_bn }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if ($product->meta_keywords)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Keywords</h3>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach (explode(',', $product->meta_keywords) as $keyword)
                                            <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded">
                                                {{ trim($keyword) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">System Information</h2>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Created</span>
                                <span
                                    class="text-sm text-gray-500">{{ $product->created_at->format('M d, Y h:i A') }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Last Updated</span>
                                <span
                                    class="text-sm text-gray-500">{{ $product->updated_at->format('M d, Y h:i A') }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Product ID</span>
                                <span class="text-sm text-gray-900 font-mono">{{ $product->id }}</span>
                            </div>

                            @if ($product->vendor_id)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">Vendor ID</span>
                                    <span class="text-sm text-gray-900">{{ $product->vendor_id }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add any interactive functionality here
            console.log('Product details page loaded');
        });
    </script>
@endpush
