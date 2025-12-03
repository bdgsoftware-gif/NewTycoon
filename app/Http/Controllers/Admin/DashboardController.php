<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Only admin can access dashboard
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Get stats
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'new_users' => User::whereDate('created_at', today())->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        // Get recent users
        $recent_users = User::latest()->take(5)->get();

        // Get recent orders
        $recent_orders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recent_users', 'recent_orders'));
    }
}
