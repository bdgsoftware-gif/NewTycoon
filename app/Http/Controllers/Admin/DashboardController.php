<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Today's date
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $lastMonth = Carbon::now()->subMonth();

        // Basic stats with comparison
        $stats = [
            'total_users' => User::count(),
            'new_users_today' => User::whereDate('created_at', $today)->count(),
            'new_users_yesterday' => User::whereDate('created_at', $yesterday)->count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'low_stock_products' => Product::whereColumn('quantity', '<=', 'alert_quantity')->count(),
            'out_of_stock_products' => Product::where('stock_status', 'out_of_stock')->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'today_revenue' => Order::where('status', 'completed')->whereDate('created_at', $today)->sum('total_amount'),
            'yesterday_revenue' => Order::where('status', 'completed')->whereDate('created_at', $yesterday)->sum('total_amount'),
            'monthly_revenue' => Order::where('status', 'completed')->whereMonth('created_at', $today->month)->sum('total_amount'),
            'total_categories' => Category::count(),
        ];

        // Calculate percentage changes
        $stats['users_change'] = $this->calculatePercentageChange(
            $stats['new_users_yesterday'],
            $stats['new_users_today']
        );

        $stats['revenue_change'] = $this->calculatePercentageChange(
            $stats['yesterday_revenue'],
            $stats['today_revenue']
        );

        // Recent activity
        $recent_users = User::with('roles')->latest()->take(6)->get();
        $recent_orders = Order::with(['user', 'items'])->latest()->take(6)->get();
        $recent_products = Product::with('category')->latest()->take(6)->get();

        // Sales chart data (last 7 days)
        $salesData = $this->getSalesData(7);

        // Top selling products
        $top_products = Product::with('category')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // Order status distribution for chart
        $orderStatusData = $this->getOrderStatusData();

        return view('admin.dashboard.index', compact(
            'stats',
            'recent_users',
            'recent_orders',
            'recent_products',
            'salesData',
            'top_products',
            'orderStatusData'
        ));
    }

    private function calculatePercentageChange($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100 : 0;
        }

        return round((($newValue - $oldValue) / $oldValue) * 100, 2);
    }

    private function getSalesData($days = 7)
    {
        $data = [];
        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays($days - 1);

        $orders = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(CASE WHEN status = "completed" THEN total_amount ELSE 0 END) as revenue')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');
            $dayData = $orders->get($dateString);

            $data[] = [
                'date' => $currentDate->format('M d'),
                'day' => $currentDate->format('D'),
                'revenue' => $dayData ? ($dayData->revenue ?: 0) : 0,
                'orders' => $dayData ? $dayData->total_orders : 0,
            ];

            $currentDate->addDay();
        }

        return $data;
    }

    private function getOrderStatusData()
    {
        return Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status => $item->count];
            })
            ->toArray();
    }
}
