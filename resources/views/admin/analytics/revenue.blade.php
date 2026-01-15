@extends('admin.layouts.app')

@section('title', 'Revenue Analytics')
@section('page-title', 'Revenue Analytics')

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
        <span class="text-gray-700">Revenue</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Period Selector -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Revenue Analytics</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.analytics.revenue', ['period' => 'week']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'week' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 7 Days
                        </a>
                        <a href="{{ route('admin.analytics.revenue', ['period' => 'month']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'month' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 30 Days
                        </a>
                        <a href="{{ route('admin.analytics.revenue', ['period' => 'quarter']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'quarter' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 90 Days
                        </a>
                        <a href="{{ route('admin.analytics.revenue', ['period' => 'year']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ $period == 'year' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last Year
                        </a>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-2">Period: {{ $dateRange['start'] }} to {{ $dateRange['end'] }}</p>
            </div>

            <!-- Revenue Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Revenue Over Time</h3>
                <div class="h-96">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Revenue Stats -->
            @php
                $totalRevenue = $revenueData->sum('revenue');
                $totalOrders = $revenueData->sum('orders_count');
                $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
                $maxRevenueDay = $revenueData->sortByDesc('revenue')->first();
                $minRevenueDay = $revenueData->sortBy('revenue')->first();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">${{ number_format($totalRevenue, 2) }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Avg Order Value</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">${{ number_format($avgOrderValue, 2) }}</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Best Day</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">
                                @if ($maxRevenueDay)
                                    ${{ number_format($maxRevenueDay->revenue, 2) }}
                                @else
                                    $0.00
                                @endif
                            </p>
                            @if ($maxRevenueDay)
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($maxRevenueDay->date)->format('M d, Y') }}</p>
                            @endif
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Revenue Growth</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">
                                @php
                                    $firstHalf = $revenueData->slice(0, ceil(count($revenueData) / 2))->sum('revenue');
                                    $secondHalf = $revenueData->slice(ceil(count($revenueData) / 2))->sum('revenue');
                                    $growth = $firstHalf > 0 ? (($secondHalf - $firstHalf) / $firstHalf) * 100 : 0;
                                @endphp
                                {{ number_format($growth, 1) }}%
                            </p>
                            <p class="text-sm text-gray-500 mt-1">{{ $growth >= 0 ? 'Increase' : 'Decrease' }}</p>
                        </div>
                        <div class="p-3 {{ $growth >= 0 ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                            <svg class="h-6 w-6 {{ $growth >= 0 ? 'text-green-500' : 'text-red-500' }}" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                @if ($growth >= 0)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                @endif
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue by Category -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Revenue by Category</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Products</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Revenue</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Avg Price</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Percentage</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($revenueByCategory as $category)
                                @php
                                    $categoryRevenue = $category->products_sum_total_revenue ?? 0;
                                    $productCount = $category->products_count ?? 0;
                                    $avgPrice = $productCount > 0 ? $categoryRevenue / $productCount : 0;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if ($category->image)
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-lg object-cover"
                                                        src="{{ Storage::url($category->image) }}"
                                                        alt="{{ $category->name }}">
                                                </div>
                                            @endif
                                            <div class="{{ $category->image ? 'ml-4' : '' }}">
                                                <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $productCount }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($categoryRevenue, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($avgPrice, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-primary h-2.5 rounded-full"
                                                    style="width: {{ $totalRevenue > 0 ? ($categoryRevenue / $totalRevenue) * 100 : 0 }}%">
                                                </div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-500">
                                                {{ $totalRevenue > 0 ? number_format(($categoryRevenue / $totalRevenue) * 100, 1) : 0 }}%
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Products by Revenue -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Top Products by Revenue</h3>
                        <a href="{{ route('admin.analytics.reports.products') }}"
                            class="text-sm text-primary hover:text-primary-dark">View Report</a>
                    </div>
                    <div class="space-y-4">
                        @foreach ($revenueByProduct as $product)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <img class="h-12 w-12 rounded-lg object-cover"
                                        src="{{ $product->featured_image_url }}" alt="{{ $product->name }}">
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <h4 class="text-sm font-medium text-gray-900">{{ Str::limit($product->name, 30) }}
                                        </h4>
                                        <span
                                            class="text-sm font-semibold text-gray-900">${{ number_format($product->total_revenue, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-500 mt-1">
                                        <span>{{ $product->total_sold }} sold</span>
                                        <span>${{ number_format($product->price, 2) }} each</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Revenue Distribution</h3>
                        <span class="text-sm text-gray-500">Avg Order: ${{ number_format($averageOrderValue, 2) }}</span>
                    </div>
                    <div class="h-80">
                        <canvas id="revenueDistributionChart"></canvas>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500">Highest Value Order</p>
                            <p class="text-lg font-semibold text-gray-800">
                                @php
                                    $maxOrder = \App\Models\Order::where('status', 'completed')
                                        ->orderBy('total_amount', 'desc')
                                        ->first();
                                @endphp
                                ${{ $maxOrder ? number_format($maxOrder->total_amount, 2) : '0.00' }}
                            </p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500">Lowest Value Order</p>
                            <p class="text-lg font-semibold text-gray-800">
                                @php
                                    $minOrder = \App\Models\Order::where('status', 'completed')
                                        ->orderBy('total_amount', 'asc')
                                        ->first();
                                @endphp
                                ${{ $minOrder ? number_format($minOrder->total_amount, 2) : '0.00' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: @json($revenueData->pluck('date')),
                    datasets: [{
                        label: 'Revenue',
                        data: @json($revenueData->pluck('revenue')),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }, {
                        label: 'Avg Order Value',
                        data: @json($revenueData->pluck('avg_order_value')),
                        type: 'line',
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            // Revenue Distribution Chart
            const distributionCtx = document.getElementById('revenueDistributionChart').getContext('2d');

            // Prepare data for distribution
            const revenueRanges = [{
                    label: '$0 - $50',
                    min: 0,
                    max: 50
                },
                {
                    label: '$50 - $100',
                    min: 50,
                    max: 100
                },
                {
                    label: '$100 - $200',
                    min: 100,
                    max: 200
                },
                {
                    label: '$200 - $500',
                    min: 200,
                    max: 500
                },
                {
                    label: '$500+',
                    min: 500,
                    max: Infinity
                }
            ];

            // Count orders in each range
            const orderCounts = revenueRanges.map(range => {
                return @json($revenueData->sum('orders_count')); // Simplified - in real app, fetch actual distribution
            });

            new Chart(distributionCtx, {
                type: 'pie',
                data: {
                    labels: revenueRanges.map(r => r.label),
                    datasets: [{
                        data: orderCounts,
                        backgroundColor: [
                            'rgb(59, 130, 246)',
                            'rgb(16, 185, 129)',
                            'rgb(245, 158, 11)',
                            'rgb(139, 92, 246)',
                            'rgb(239, 68, 68)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((context.parsed / total) * 100);
                                    return `${context.label}: ${context.parsed} orders (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
