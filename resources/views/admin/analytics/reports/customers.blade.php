@extends('admin.layouts.app')

@section('title', 'Customers Report')
@section('page-title', 'Customers Report')

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
        <span class="text-gray-700">Customers Report</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Report Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Customers Report</h3>
                        <p class="text-sm text-gray-500 mt-1">Detailed customer information and analytics</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.analytics.export', 'customers') }}"
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
                        <p class="text-sm font-medium text-gray-500">Total Customers</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($customers->total()) }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Active Customers</p>
                        @php
                            $activeCustomers = \App\Models\User::role('customer')
                                ->whereHas('orders', function ($q) {
                                    $q->where('created_at', '>=', now()->subDays(30));
                                })
                                ->count();
                        @endphp
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($activeCustomers) }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">New This Month</p>
                        @php
                            $newThisMonth = \App\Models\User::role('customer')
                                ->where('created_at', '>=', now()->startOfMonth())
                                ->count();
                        @endphp
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($newThisMonth) }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Avg Orders/Customer</p>
                        @php
                            $totalOrders = \App\Models\Order::where('status', 'completed')->count();
                            $avgOrders = $customers->total() > 0 ? $totalOrders / $customers->total() : 0;
                        @endphp
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($avgOrders, 1) }}</p>
                    </div>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Customers List</h3>
                        <div class="text-sm text-gray-500">
                            Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of
                            {{ $customers->total() }}
                            customers
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Joined</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Orders</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                    Spent</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Avg
                                    Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last
                                    Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($customers as $customer)
                                @php
                                    $lastOrder = $customer->orders()->where('status', 'completed')->latest()->first();
                                    $totalSpent = $customer
                                        ->orders()
                                        ->where('status', 'completed')
                                        ->sum('total_amount');
                                    $orderCount = $customer->orders()->where('status', 'completed')->count();
                                    $avgOrder = $orderCount > 0 ? $totalSpent / $orderCount : 0;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if ($customer->profile && $customer->profile->avatar)
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ Storage::url($customer->profile->avatar) }}"
                                                        alt="{{ $customer->name }}">
                                                @else
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span
                                                            class="text-gray-500 font-medium">{{ substr($customer->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                                                @if ($customer->phone)
                                                    <div class="text-xs text-gray-500">{{ $customer->phone }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $customer->created_at->format('M d, Y') }}
                                        <div class="text-xs text-gray-400">{{ $customer->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $customer->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($customer->status) }}
                                        </span>
                                        @if ($customer->email_verified_at)
                                            <span
                                                class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                Verified
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $orderCount }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($totalSpent, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ number_format($avgOrder, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($lastOrder)
                                            <div>{{ $lastOrder->created_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $lastOrder->order_number }}</div>
                                        @else
                                            <span class="text-gray-400">No orders</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.users.show', $customer) }}"
                                            class="text-primary hover:text-primary-dark mr-3">View</a>
                                        <a href="{{ route('admin.orders.index', ['customer' => $customer->id]) }}"
                                            class="text-gray-600 hover:text-gray-900">Orders</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($customers->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>

            <!-- Customer Segments Analysis -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Customer Segments Analysis</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $segments = [
                            [
                                'title' => 'Top Spenders',
                                'description' => 'Customers who spent $1000+',
                                'count' => \App\Models\User::role('customer')
                                    ->whereHas('orders', function ($q) {
                                        $q->where('status', 'completed')
                                            ->selectRaw('user_id, SUM(total_amount) as total')
                                            ->groupBy('user_id')
                                            ->havingRaw('SUM(total_amount) >= 1000');
                                    })
                                    ->count(),
                                'color' => 'bg-green-100 text-green-800',
                            ],
                            [
                                'title' => 'Frequent Buyers',
                                'description' => '5+ orders in last 6 months',
                                'count' => \App\Models\User::role('customer')
                                    ->whereHas('orders', function ($q) {
                                        $q->where('status', 'completed')
                                            ->where('created_at', '>=', now()->subMonths(6))
                                            ->groupBy('user_id')
                                            ->havingRaw('COUNT(*) >= 5');
                                    })
                                    ->count(),
                                'color' => 'bg-blue-100 text-blue-800',
                            ],
                            [
                                'title' => 'New Customers',
                                'description' => 'Joined in last 30 days',
                                'count' => $newThisMonth,
                                'color' => 'bg-purple-100 text-purple-800',
                            ],
                            [
                                'title' => 'At Risk',
                                'description' => 'No orders in 90+ days',
                                'count' => \App\Models\User::role('customer')
                                    ->whereDoesntHave('orders', function ($q) {
                                        $q->where('created_at', '>=', now()->subDays(90));
                                    })
                                    ->has('orders', '>=', 1)
                                    ->count(),
                                'color' => 'bg-yellow-100 text-yellow-800',
                            ],
                            [
                                'title' => 'Inactive',
                                'description' => 'Never placed an order',
                                'count' => \App\Models\User::role('customer')->doesntHave('orders')->count(),
                                'color' => 'bg-gray-100 text-gray-800',
                            ],
                            [
                                'title' => 'Loyal Customers',
                                'description' => '3+ years with us',
                                'count' => \App\Models\User::role('customer')
                                    ->where('created_at', '<=', now()->subYears(3))
                                    ->has('orders', '>=', 1)
                                    ->count(),
                                'color' => 'bg-indigo-100 text-indigo-800',
                            ],
                        ];
                    @endphp

                    @foreach ($segments as $segment)
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-medium text-gray-900">{{ $segment['title'] }}</h4>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $segment['color'] }}">
                                    {{ $segment['count'] }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mb-3">{{ $segment['description'] }}</p>
                            @if ($customers->total() > 0)
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="bg-primary h-1.5 rounded-full"
                                        style="width: {{ ($segment['count'] / $customers->total()) * 100 }}%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
                                    {{ number_format(($segment['count'] / $customers->total()) * 100, 1) }}% of customers
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Geographic Distribution -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Geographic Distribution</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Country</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customers</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Orders</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Revenue</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Avg Order Value</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $countries = \App\Models\Order::select('shipping_country')
                                    ->selectRaw('COUNT(DISTINCT user_id) as customer_count')
                                    ->selectRaw('COUNT(*) as order_count')
                                    ->selectRaw('SUM(total_amount) as total_revenue')
                                    ->where('status', 'completed')
                                    ->whereNotNull('user_id')
                                    ->groupBy('shipping_country')
                                    ->orderBy('total_revenue', 'desc')
                                    ->take(10)
                                    ->get();
                            @endphp

                            @foreach ($countries as $country)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $country->shipping_country }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $country->customer_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $country->order_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${{ number_format($country->total_revenue, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${{ $country->order_count > 0 ? number_format($country->total_revenue / $country->order_count, 2) : '0.00' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        }
    </style>
@endpush
