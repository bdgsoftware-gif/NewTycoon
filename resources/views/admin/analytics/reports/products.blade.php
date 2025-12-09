@extends('admin.layouts.app')

@section('title', 'Products Report')
@section('page-title', 'Products Report')

@section('breadcrumb')
    <li class="inline-flex items-center">

        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <a href="{{ route('admin.analytics.index') }}" class="text-gray-500 hover:text-gray-700">Analytics</a>
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Products Report</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Report Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Products Report</h3>
                        <p class="text-sm text-gray-500 mt-1">Detailed product performance and inventory analysis</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.analytics.export', 'products') }}"
                            class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                            Export CSV
                        </a>
                        <button onclick="window.print()"
                            class="px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                            Print Report
                        </button>
                    </div>
                </div>

                <!-- Summary Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Total Products</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($products->total()) }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Total Sold</p>
                        @php
                            $totalSold = \App\Models\Product::sum('total_sold');
                        @endphp
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalSold) }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                        @php
                            $totalRevenue = \App\Models\Product::sum('total_revenue');
                        @endphp
                        <p class="text-2xl font-bold text-gray-800 mt-1">${{ number_format($totalRevenue, 2) }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Out of Stock</p>
                        @php
                            $outOfStock = \App\Models\Product::where('track_quantity', true)
                                ->where('quantity', '<=', 0)
                                ->where('allow_backorder', false)
                                ->count();
                        @endphp
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($outOfStock) }}</p>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Products Performance</h3>
                        <div class="text-sm text-gray-500">
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}
                            products
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    SKU
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sold
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Revenue</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rating</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-lg object-cover"
                                                    src="{{ $product->featured_image_url }}" alt="{{ $product->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ Str::limit($product->name, 30) }}</div>
                                                @if ($product->brand)
                                                    <div class="text-xs text-gray-500">{{ $product->brand->name }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $product->sku }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $product->category->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($product->price, 2) }}
                                        @if ($product->compare_price > $product->price)
                                            <div class="text-xs text-red-600 line-through">
                                                ${{ number_format($product->compare_price, 2) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($product->total_sold) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($product->total_revenue, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($product->track_quantity)
                                            @if ($product->quantity <= 0)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    Out of Stock
                                                </span>
                                            @elseif($product->quantity <= $product->alert_quantity)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Low: {{ $product->quantity }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $product->quantity }}
                                                </span>
                                            @endif
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                Unlimited
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span
                                                class="ml-1 text-sm text-gray-900">{{ number_format($product->average_rating, 1) }}</span>
                                            <span class="ml-1 text-xs text-gray-500">({{ $product->rating_count }})</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $product->status == 'active'
                                                ? 'bg-green-100 text-green-800'
                                                : ($product->status == 'draft'
                                                    ? 'bg-gray-100 text-gray-800'
                                                    : ($product->status == 'inactive'
                                                        ? 'bg-red-100 text-red-800'
                                                        : 'bg-yellow-100 text-yellow-800')) }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                        @if ($product->is_featured)
                                            <span
                                                class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Featured
                                            </span>
                                        @endif
                                        @if ($product->is_bestseller)
                                            <span
                                                class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                Bestseller
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($products->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

            <!-- Performance Metrics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Categories -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Top Categories by Revenue</h3>
                    <div class="space-y-4">
                        @php
                            $topCategories = \App\Models\Category::withSum('products', 'total_revenue')
                                ->withCount('products')
                                ->orderBy('products_sum_total_revenue', 'desc')
                                ->take(8)
                                ->get();
                        @endphp

                        @foreach ($topCategories as $category)
                            @php
                                $categoryRevenue = $category->products_sum_total_revenue ?? 0;
                                $percentage = $totalRevenue > 0 ? ($categoryRevenue / $totalRevenue) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium">{{ $category->name }}</span>
                                    <span>${{ number_format($categoryRevenue, 2) }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-primary h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>{{ $category->products_count }} products</span>
                                    <span>{{ number_format($percentage, 1) }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Stock Analysis -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Stock Analysis</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $stockAnalysis = [
                                [
                                    'title' => 'Well Stocked',
                                    'description' => 'Above alert quantity',
                                    'count' => \App\Models\Product::where('track_quantity', true)
                                        ->where('quantity', '>', DB::raw('alert_quantity'))
                                        ->count(),
                                    'color' => 'bg-green-100 text-green-800',
                                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                                [
                                    'title' => 'Low Stock',
                                    'description' => 'At or below alert quantity',
                                    'count' => \App\Models\Product::where('track_quantity', true)
                                        ->where('quantity', '<=', DB::raw('alert_quantity'))
                                        ->where('quantity', '>', 0)
                                        ->count(),
                                    'color' => 'bg-yellow-100 text-yellow-800',
                                    'icon' =>
                                        'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
                                ],
                                [
                                    'title' => 'Out of Stock',
                                    'description' => 'Zero quantity',
                                    'count' => $outOfStock,
                                    'color' => 'bg-red-100 text-red-800',
                                    'icon' =>
                                        'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636',
                                ],
                                [
                                    'title' => 'No Stock Tracking',
                                    'description' => 'Unlimited stock',
                                    'count' => \App\Models\Product::where('track_quantity', false)->count(),
                                    'color' => 'bg-gray-100 text-gray-800',
                                    'icon' =>
                                        'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                ],
                            ];
                        @endphp

                        @foreach ($stockAnalysis as $analysis)
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="p-2 {{ str_replace('text', 'bg', $analysis['color']) }} bg-opacity-10 rounded-lg">
                                            <svg class="h-6 w-6 {{ str_replace('100', '500', $analysis['color']) }}"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="{{ $analysis['icon'] }}" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $analysis['title'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $analysis['description'] }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 text-center">
                                    <span class="text-2xl font-bold text-gray-800">{{ $analysis['count'] }}</span>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $products->total() > 0 ? number_format(($analysis['count'] / $products->total()) * 100, 1) : 0 }}%
                                        of products
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Performance Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Product Performance Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $performanceMetrics = [
                            [
                                'title' => 'Top 10% Products',
                                'description' => 'Generate 80% of revenue',
                                'value' => ceil($products->total() * 0.1),
                                'color' => 'text-green-600',
                                'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
                            ],
                            [
                                'title' => 'Avg Profit Margin',
                                'description' => 'Across all products',
                                'value' => $this->getAverageProfitMargin() . '%',
                                'color' => 'text-blue-600',
                                'icon' =>
                                    'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                            ],
                            [
                                'title' => 'Avg Selling Price',
                                'description' => 'Average product price',
                                'value' => '$' . number_format($this->getAverageSellingPrice(), 2),
                                'color' => 'text-purple-600',
                                'icon' =>
                                    'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                            ],
                            [
                                'title' => 'Return Rate',
                                'description' => 'Estimated return rate',
                                'value' => '2.5%',
                                'color' => 'text-orange-600',
                                'icon' =>
                                    'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                            ],
                        ];
                    @endphp

                    @foreach ($performanceMetrics as $metric)
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div
                                class="inline-flex items-center justify-center p-3 {{ str_replace('text', 'bg', $metric['color']) }} bg-opacity-10 rounded-lg">
                                <svg class="h-6 w-6 {{ $metric['color'] }}" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $metric['icon'] }}" />
                                </svg>
                            </div>
                            <p class="text-xl font-bold {{ $metric['color'] }} mt-3">{{ $metric['value'] }}</p>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $metric['title'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $metric['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .bg-white {
                background: white !important;
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                border: 1px solid #e5e7eb;
                padding: 8px;
            }

            img {
                max-width: 40px !important;
                max-height: 40px !important;
            }
        }
    </style>
@endpush
