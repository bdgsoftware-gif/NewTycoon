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
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Show checkout page (from cart)
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
        $isBuyNow = false; // This is from cart

        return view('frontend.checkout.index', compact('cart', 'user', 'addresses', 'isGuest', 'isBuyNow'));
    }

    /**
     * Buy Now - Direct checkout for single product
     */
    public function buyNow(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $quantity = $validated['quantity'];

        // Check if product exists and is active
        if ($product->status !== 'active') {
            return redirect()->back()
                ->with('error', 'This product is not available');
        }

        // Check stock
        if (
            $product->track_quantity &&
            $product->quantity < $quantity &&
            !$product->allow_backorder
        ) {
            return redirect()->back()
                ->with('error', "{$product->name} is out of stock");
        }

        // Store buy now data in session
        Session::put('buy_now_product', [
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ]);

        // Redirect to buy now checkout
        return redirect()->route('checkout.buy-now-checkout');
    }

    /**
     * Show Buy Now checkout page
     */
    public function buyNowCheckout()
    {
        // Get buy now data from session
        $buyNowData = Session::get('buy_now_product');

        if (!$buyNowData) {
            return redirect()->route('home')
                ->with('error', 'No product selected for purchase');
        }

        // Get product
        $product = Product::with('category')->findOrFail($buyNowData['product_id']);

        // Check stock again
        if (
            $product->track_quantity &&
            $product->quantity < $buyNowData['quantity'] &&
            !$product->allow_backorder
        ) {
            Session::forget('buy_now_product');
            return redirect()->route('product.show', $product->slug)
                ->with('error', "{$product->name} is out of stock");
        }

        // Create temporary cart-like structure for the view
        $cart = (object) [
            'items' => collect([
                (object) [
                    'product' => $product,
                    'quantity' => $buyNowData['quantity'],
                    'price' => $buyNowData['price'],
                ]
            ]),
            'subtotal' => $buyNowData['price'] * $buyNowData['quantity'],
            'total' => $buyNowData['price'] * $buyNowData['quantity'],
        ];

        $user = Auth::user();
        $addresses = $user ? $user->addresses()->where('type', 'shipping')->get() : collect();
        $isGuest = !Auth::check();
        $isBuyNow = true; // This is buy now

        return view('frontend.checkout.index', compact('cart', 'user', 'addresses', 'isGuest', 'isBuyNow'));
    }

    /**
     * Process checkout (handles both cart and buy now)
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
            'is_buy_now' => 'boolean', // Flag to identify buy now
        ];

        // Guest account creation
        if (!Auth::check() && $request->boolean('create_account')) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Determine if this is buy now or cart checkout
        $isBuyNow = $request->boolean('is_buy_now');

        if ($isBuyNow) {
            return $this->processBuyNow($request, $validated);
        } else {
            return $this->processCart($request, $validated);
        }
    }

    /**
     * Process Buy Now checkout
     */
    private function processBuyNow(Request $request, array $validated)
    {
        $buyNowData = Session::get('buy_now_product');

        if (!$buyNowData) {
            return response()->json([
                'success' => false,
                'message' => 'Product data not found'
            ], 400);
        }

        $product = Product::findOrFail($buyNowData['product_id']);

        // Validate stock
        if (
            $product->track_quantity &&
            $product->quantity < $buyNowData['quantity'] &&
            !$product->allow_backorder
        ) {
            Session::forget('buy_now_product');
            return response()->json([
                'success' => false,
                'message' => "{$product->name} is out of stock"
            ], 400);
        }

        DB::beginTransaction();

        try {
            $userId = $this->handleUserCreation($request, $validated);

            // Calculate totals
            $subtotal = $buyNowData['price'] * $buyNowData['quantity'];
            $shippingCost = 0;
            $total = $subtotal + $shippingCost;

            // CREATE ORDER
            $order = $this->createOrder($validated, $userId, $subtotal, $shippingCost, $total, $request);

            // CREATE ORDER ITEM
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku ?? 'N/A',
                'product_image' => is_array($product->featured_images) && !empty($product->featured_images)
                    ? $product->featured_images[0]
                    : null,
                'quantity' => $buyNowData['quantity'],
                'unit_price' => $buyNowData['price'],
                'total_price' => $buyNowData['quantity'] * $buyNowData['price'],
                'discount_amount' => 0,
                'tax_amount' => 0,
            ]);

            // UPDATE PRODUCT STOCK
            if ($product->track_quantity) {
                $product->decrement('quantity', $buyNowData['quantity']);
                $product->increment('total_sold', $buyNowData['quantity']);
                $product->updateStockStatus();
            }

            // CREATE PAYMENT RECORD
            $this->createPayment($order, $validated['payment_method']);

            // CLEAR BUY NOW SESSION
            Session::forget('buy_now_product');

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect_url' => route('checkout.success', $order->order_number)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Buy Now checkout failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Checkout failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Process Cart checkout
     */
    private function processCart(Request $request, array $validated)
    {
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
            $userId = $this->handleUserCreation($request, $validated);

            // Calculate totals
            $subtotal = $cart->subtotal;
            $shippingCost = 0;
            $total = $subtotal + $shippingCost;

            // CREATE ORDER
            $order = $this->createOrder($validated, $userId, $subtotal, $shippingCost, $total, $request);

            // CREATE ORDER ITEMS
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

                // UPDATE PRODUCT STOCK
                if ($product->track_quantity) {
                    $product->decrement('quantity', $item->quantity);
                    $product->increment('total_sold', $item->quantity);
                    $product->updateStockStatus();
                }
            }

            // CREATE PAYMENT RECORD
            $this->createPayment($order, $validated['payment_method']);

            // CLEAR CART
            $cart->items()->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect_url' => route('checkout.success', $order->order_number)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Cart checkout failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Checkout failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle user creation for guest checkout
     */
    private function handleUserCreation(Request $request, array $validated)
    {
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
                'state' => 'Dhaka',
                'postal_code' => $validated['postal_code'],
                'country' => 'Bangladesh',
                'is_default' => true,
            ]);
        }

        return $userId;
    }

    /**
     * Create order
     */
    private function createOrder(array $validated, $userId, $subtotal, $shippingCost, $total, Request $request)
    {
        return Order::create([
            'order_number' => $this->generateOrderNumber(),
            'user_id' => $userId,

            // Customer info
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'customer_phone' => $validated['phone'],

            // Shipping address
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
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'total_amount' => $total,

            // Status
            'status' => 'pending',
            'payment_status' => 'pending',

            // Payment & Shipping
            'payment_method' => $validated['payment_method'],
            'shipping_method' => 'standard',

            // Notes
            'customer_note' => $validated['notes'] ?? null,

            // Meta
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    /**
     * Create payment record
     */
    private function createPayment(Order $order, string $paymentMethod)
    {
        return Payment::create([
            'order_id' => $order->id,
            'payment_method' => $paymentMethod,
            'amount' => $order->total_amount,
            'status' => $paymentMethod === 'cod' ? 'pending' : 'pending',
            'transaction_id' => null,
        ]);
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
     * Cancel checkout
     */
    public function cancel()
    {
        // Clear buy now session if exists
        Session::forget('buy_now_product');

        return redirect()->route('home')
            ->with('info', 'Checkout cancelled');
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
