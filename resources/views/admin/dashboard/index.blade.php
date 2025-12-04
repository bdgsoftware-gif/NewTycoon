@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <span class="text-gray-500">Home</span>
    </li>
@endsection

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in">
        <!-- Total Revenue -->
        <div
            class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-inter font-medium text-gray-500 uppercase tracking-wider">Total Revenue</p>
                    <p class="text-3xl font-cambay font-bold text-gray-900 mt-2">
                        ${{ number_format($stats['total_revenue'], 2) }}</p>
                    <div class="mt-3 flex items-center">
                        <span
                            class="text-sm font-medium {{ $stats['revenue_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i class="fas {{ $stats['revenue_change'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                            {{ abs($stats['revenue_change']) }}%
                        </span>
                        <span class="text-sm text-gray-500 ml-2">vs yesterday</span>
                    </div>
                </div>
                <div class="h-14 w-14 rounded-xl bg-primary-light flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-primary text-2xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500">Monthly: ${{ number_format($stats['monthly_revenue'], 2) }}</p>
            </div>
        </div>

        <!-- Total Orders -->
        <div
            class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-inter font-medium text-gray-500 uppercase tracking-wider">Total Orders</p>
                    <p class="text-3xl font-cambay font-bold text-gray-900 mt-2">{{ $stats['total_orders'] }}</p>
                    <div class="mt-3">
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $stats['completed_orders'] }} completed
                            </span>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ $stats['pending_orders'] }} pending
                            </span>
                        </div>
                    </div>
                </div>
                <div class="h-14 w-14 rounded-xl bg-accent-light flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-accent text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div
            class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-inter font-medium text-gray-500 uppercase tracking-wider">Total Users</p>
                    <p class="text-3xl font-cambay font-bold text-gray-900 mt-2">{{ $stats['total_users'] }}</p>
                    <div class="mt-3 flex items-center">
                        <span
                            class="text-sm font-medium {{ $stats['users_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i class="fas {{ $stats['users_change'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                            {{ abs($stats['users_change']) }}%
                        </span>
                        <span class="text-sm text-gray-500 ml-2">vs yesterday</span>
                    </div>
                </div>
                <div class="h-14 w-14 rounded-xl bg-blue-50 flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500">{{ $stats['new_users_today'] }} new today</p>
            </div>
        </div>

        <!-- Products Stats -->
        <div
            class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-inter font-medium text-gray-500 uppercase tracking-wider">Products</p>
                    <p class="text-3xl font-cambay font-bold text-gray-900 mt-2">{{ $stats['total_products'] }}</p>
                    <div class="mt-3 space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600">Active</span>
                            <span class="text-xs font-medium">{{ $stats['active_products'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600">Low Stock</span>
                            <span class="text-xs font-medium text-yellow-600">{{ $stats['low_stock_products'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600">Out of Stock</span>
                            <span class="text-xs font-medium text-red-600">{{ $stats['out_of_stock_products'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="h-14 w-14 rounded-xl bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-box text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold font-cambay text-gray-900">Revenue Overview</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Last 7 days</span>
                </div>
            </div>
            <div class="h-64">
                <div class="flex items-end h-48 space-x-2">
                    @foreach ($salesData as $day)
                        <div class="flex-1 flex flex-col items-center">
                            <div class="w-full rounded-t-lg transition-all duration-300 hover:opacity-80 cursor-pointer"
                                style="height: {{ $day['revenue'] > 0 ? max(20, ($day['revenue'] / max(array_column($salesData, 'revenue'))) * 100) : 0 }}%; background: linear-gradient(to top, #ea2f30, #fdba74);"
                                title="${{ number_format($day['revenue'], 2) }}"></div>
                            <span class="text-xs text-gray-500 mt-2">{{ $day['day'] }}</span>
                            <span class="text-xs font-medium mt-1">{{ $day['date'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                    <div>
                        <p class="text-sm text-gray-500">Total Revenue (7 days)</p>
                        <p class="text-lg font-bold text-gray-900">
                            ${{ number_format(array_sum(array_column($salesData, 'revenue')), 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Orders</p>
                        <p class="text-lg font-bold text-gray-900">{{ array_sum(array_column($salesData, 'orders')) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Chart -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold font-cambay text-gray-900">Order Status Distribution</h3>
            </div>
            <div class="h-64">
                <div class="grid grid-cols-2 gap-4">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'completed' => 'bg-green-100 text-green-800 border-green-200',
                            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                            'refunded' => 'bg-purple-100 text-purple-800 border-purple-200',
                        ];
                    @endphp

                    @foreach ($orderStatusData as $status => $count)
                        @if (isset($statusColors[$status]))
                            <div class="flex flex-col p-4 rounded-xl border {{ $statusColors[$status] }}">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium capitalize">{{ $status }}</span>
                                    <span class="text-lg font-bold">{{ $count }}</span>
                                </div>
                                <div class="mt-2 w-full bg-white/50 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ str_replace('bg-', 'bg-opacity-80 ', $statusColors[$status]) }}"
                                        style="width: {{ $stats['total_orders'] > 0 ? ($count / $stats['total_orders']) * 100 : 0 }}%">
                                    </div>
                                </div>
                                <div class="mt-2 text-xs text-gray-600">
                                    {{ $stats['total_orders'] > 0 ? round(($count / $stats['total_orders']) * 100, 1) : 0 }}%
                                    of total
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Recent Users -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm lg:col-span-1">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold font-cambay text-gray-900">Recent Users</h3>
                <a href="{{ route('admin.users.index') }}"
                    class="text-sm text-primary hover:text-primary-dark font-medium">
                    View All
                </a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach ($recent_users as $user)
                        <div
                            class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <div
                                    class="h-10 w-10 rounded-full bg-gradient-to-br from-primary to-accent flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 truncate max-w-[150px]">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                                <div class="mt-1">
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($recent_users->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-users text-gray-300 text-3xl mb-3"></i>
                        <p class="text-gray-500">No recent users</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm lg:col-span-2">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold font-cambay text-gray-900">Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}"
                    class="text-sm text-primary hover:text-primary-dark font-medium">
                    View All
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($recent_orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->order_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order->customer_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->customer_email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusBadge = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'completed' => 'bg-green-100 text-green-800 border-green-200',
                                            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                            'refunded' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusBadge[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        ${{ number_format($order->total_amount, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->items->sum('quantity') }} items</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('M d, Y') }}
                                    <div class="text-xs">{{ $order->created_at->format('h:i A') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($recent_orders->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-shopping-cart text-gray-300 text-4xl mb-3"></i>
                        <p class="text-gray-500">No recent orders</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-8">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold font-cambay text-gray-900">Top Selling Products</h3>
            <a href="{{ route('admin.products.index') }}"
                class="text-sm text-primary hover:text-primary-dark font-medium">
                View All Products
            </a>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach ($top_products as $product)
                    <div class="group">
                        <div
                            class="relative overflow-hidden rounded-xl border border-gray-200 p-4 hover:border-primary transition-all duration-300">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden">
                                    @if ($product->featured_image)
                                        <img src="{{ Storage::url($product->featured_image) }}"
                                            alt="{{ $product->name }}" class="h-full w-full object-cover">
                                    @else
                                        <i class="fas fa-box text-gray-400 text-xl"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4
                                        class="text-sm font-medium text-gray-900 group-hover:text-primary transition-colors truncate">
                                        {{ $product->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                    <div class="mt-2 flex items-center justify-between">
                                        <span
                                            class="text-sm font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                                            <span
                                                class="text-xs text-gray-600">{{ number_format($product->average_rating, 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-gray-500">Sold:</span>
                                    <span class="font-semibold text-primary">{{ $product->total_sold }}</span>
                                </div>
                                <div class="mt-1 flex items-center justify-between text-xs">
                                    <span class="text-gray-500">Stock:</span>
                                    <span
                                        class="font-semibold {{ $product->quantity <= $product->alert_quantity ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $product->quantity }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($top_products->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-chart-line text-gray-300 text-3xl mb-3"></i>
                    <p class="text-gray-500">No product sales data yet</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Add hover effect for chart bars
        document.addEventListener('DOMContentLoaded', function() {
            const bars = document.querySelectorAll('[title^="$"]');
            bars.forEach(bar => {
                bar.addEventListener('mouseenter', function() {
                    this.style.transform = 'scaleY(1.1)';
                });
                bar.addEventListener('mouseleave', function() {
                    this.style.transform = 'scaleY(1)';
                });
            });

            // Initialize tooltips
            tippy('[title]', {
                placement: 'top',
                animation: 'scale',
                duration: 200,
            });
        });
    </script>
@endpush
