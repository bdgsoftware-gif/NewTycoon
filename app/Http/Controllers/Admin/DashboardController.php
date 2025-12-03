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
        // Get stats with safe defaults
        $stats = [
            'total_users'    => User::count() ?: 0,
            'total_products' => Product::count() ?: 0,
            'total_orders'   => Order::count() ?: 0,
            'revenue'        => Order::where('status', 'completed')->sum('total_amount') ?: 0,
            'new_users'      => User::whereDate('created_at', today())->count() ?: 0,
            'pending_orders' => Order::where('status', 'pending')->count() ?: 0,
        ];

        // Get recent users (fallback to default structure if none)
        $recent_users = User::latest()->take(5)->get();
        if ($recent_users->isEmpty()) {
            // Provide a default skeleton user list to avoid blade errors
            $recent_users = collect([
                (object) ['id' => 0, 'name' => 'No users yet', 'email' => '', 'created_at' => null],
                (object) ['id' => 0, 'name' => 'No users yet', 'email' => '', 'created_at' => null],
                (object) ['id' => 0, 'name' => 'No users yet', 'email' => '', 'created_at' => null],
                (object) ['id' => 0, 'name' => 'No users yet', 'email' => '', 'created_at' => null],
                (object) ['id' => 0, 'name' => 'No users yet', 'email' => '', 'created_at' => null],
            ]);
        }

        // Get recent orders (with fallback)
        $recent_orders = Order::with('user')->latest()->take(5)->get();
        if ($recent_orders->isEmpty()) {
            $recent_orders = collect([
                (object) ['id' => 0, 'order_number' => 'N/A', 'total_amount' => 0, 'status' => 'N/A', 'created_at' => null, 'user' => (object)['name' => 'No user']],
            ]);
        }

        return view('admin.dashboard.index', compact('stats', 'recent_users', 'recent_orders'));
    }
}
