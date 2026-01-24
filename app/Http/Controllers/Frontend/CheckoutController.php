<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        $cart = Cart::getCurrentCart();

        // Check if cart is empty
        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty');
        }

        // Check stock for all items
        foreach ($cart->items as $item) {
            if (!$item->product) {
                return redirect()->route('cart.index')
                    ->with('error', 'Some items in your cart are no longer available');
            }

            if (
                $item->product->track_quantity &&
                $item->product->quantity < $item->quantity &&
                !$item->product->allow_backorder
            ) {
                return redirect()->route('cart.index')
                    ->with('error', "{$item->product->name} is out of stock");
            }
        }

        $user = Auth::user();
        $addresses = $user ? $user->addresses()->where('type', 'shipping')->get() : collect();
        $isGuest = !Auth::check();

        return view('frontend.checkout.index', compact('cart', 'user', 'addresses', 'isGuest'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,online',
            'notes' => 'nullable|string|max:1000',
            'terms' => 'accepted',
        ];

        // Guest account creation
        if (!Auth::check() && $request->boolean('create_account')) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        $cart = Cart::getCurrentCart();

        if ($cart->items->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        // Validate stock again
        foreach ($cart->items as $item) {
            if (!$item->product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some items are no longer available'
                ], 400);
            }

            if (
                $item->product->track_quantity &&
                $item->product->quantity < $item->quantity &&
                !$item->product->allow_backorder
            ) {
                return response()->json([
                    'success' => false,
                    'message' => "{$item->product->name} is out of stock"
                ], 400);
            }
        }

        DB::beginTransaction();

        try {
            $userId = Auth::id();

            if (!$userId && $request->boolean('create_account')) {
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'password' => Hash::make($validated['password']),
                    'status' => 'active',
                ]);

                // Assign customer role
                $user->assignRole('customer');

                // Auto-login
                Auth::login($user);
                $userId = $user->id;

                // Create address for user
                Address::create([
                    'user_id' => $userId,
                    'type' => 'shipping',
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'address_line_1' => $validated['address'],
                    'address_line_2' => null,
                    'city' => $validated['city'],
                    'state' => 'Dhaka', // Default for Bangladesh
                    'postal_code' => $validated['postal_code'],
                    'country' => 'Bangladesh',
                    'is_default' => true,
                ]);
            }

            // ✅ CREATE ORDER
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => $userId,

                // Customer info
                'customer_name' => $validated['name'],
                'customer_email' => $validated['email'],
                'customer_phone' => $validated['phone'],

                // Shipping address (Bangladesh only)
                'shipping_name' => $validated['name'],
                'shipping_email' => $validated['email'],
                'shipping_phone' => $validated['phone'],
                'shipping_address_line1' => $validated['address'],
                'shipping_address_line2' => null,
                'shipping_city' => $validated['city'],
                'shipping_state' => 'Bangladesh',
                'shipping_country' => 'Bangladesh',
                'shipping_zip_code' => $validated['postal_code'],

                // Billing same as shipping
                'billing_same_as_shipping' => true,

                // Totals
                'subtotal' => $cart->subtotal,
                'shipping_cost' => 0, // Free shipping for now
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => $cart->subtotal,

                // Status
                'status' => 'pending',
                'payment_status' => 'pending',

                // Payment & Shipping
                'payment_method' => $validated['payment_method'],
                'shipping_method' => 'standard', // Default

                // Notes
                'customer_note' => $validated['notes'] ?? null,

                // Meta
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // ✅ CREATE ORDER ITEMS
            foreach ($cart->items as $item) {
                $product = $item->product;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku ?? 'N/A',
                    'product_image' => is_array($product->featured_images) && !empty($product->featured_images)
                        ? $product->featured_images[0]
                        : null,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'total_price' => $item->quantity * $item->price,
                    'discount_amount' => 0,
                    'tax_amount' => 0,
                ]);

                // ✅ UPDATE PRODUCT STOCK
                if ($product->track_quantity) {
                    $product->decrement('quantity', $item->quantity);
                    $product->increment('total_sold', $item->quantity);
                    $product->updateStockStatus();
                }
            }

            // ✅ CREATE PAYMENT RECORD
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'],
                'amount' => $order->total_amount,
                'status' => $validated['payment_method'] === 'cod' ? 'pending' : 'pending',
                'transaction_id' => null,
            ]);

            // ✅ CLEAR CART
            $cart->items()->delete();

            DB::commit();

            // ✅ SEND ORDER CONFIRMATION EMAIL (Optional)
            // Mail::to($order->customer_email)->send(new OrderConfirmation($order));

            return response()->json([
                'success' => true,
                'redirect_url' => route('checkout.success', $order->order_number)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Checkout failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Checkout failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Show order success page
     */
    public function success($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items.product')
            ->when(Auth::check(), fn($q) => $q->where('user_id', Auth::id()))
            ->firstOrFail();

        return view('frontend.checkout.success', compact('order'));
    }

    /**
     * Show order failed page
     */
    public function failed()
    {
        return view('frontend.checkout.failed');
    }

    /**
     * Generate unique order number
     */
    private function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
