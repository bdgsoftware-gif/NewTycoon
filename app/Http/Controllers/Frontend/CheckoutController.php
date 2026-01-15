<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            if ($item->product->track_quantity && $item->product->quantity < $item->quantity && !$item->product->allow_backorder) {
                return redirect()->route('cart.index')
                    ->with('error', 'Some items in your cart are out of stock');
            }
        }

        $user = Auth::user();
        $addresses = $user ? $user->addresses : collect();
        $isGuest = !Auth::check();

        return view('frontend.checkout.index', compact('cart', 'user', 'addresses', 'isGuest'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required_if:use_existing_shipping,true',
            'billing_address_id' => 'required_if:use_existing_billing,true',
            'shipping_method' => 'required|string',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
            'create_account' => 'boolean',
            'password' => 'required_if:create_account,true|min:6',
            'terms' => 'accepted',
        ]);

        $cart = Cart::getCurrentCart();

        if ($cart->items->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        // Validate stock
        foreach ($cart->items as $item) {
            if ($item->product->track_quantity && $item->product->quantity < $item->quantity && !$item->product->allow_backorder) {
                return response()->json([
                    'success' => false,
                    'message' => "{$item->product->name} is out of stock"
                ], 400);
            }
        }

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),

                // USER OR GUEST
                'user_id' => Auth::id(),

                // CUSTOMER SNAPSHOT
                'customer_name'  => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,

                // SHIPPING SNAPSHOT
                'shipping_name' => $request->shipping_name,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address_line1' => $request->shipping_address_1,
                'shipping_address_line2' => $request->shipping_address_2,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_country' => $request->shipping_country,
                'shipping_zip_code' => $request->shipping_postal_code,

                // BILLING
                'billing_same_as_shipping' => $request->same_as_shipping,

                // TOTALS
                'subtotal' => $cart->subtotal,
                'shipping_cost' => 0,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => $cart->subtotal,

                // STATUS
                'status' => 'pending',
                'payment_status' => 'pending',

                // META
                'shipping_method' => $request->shipping_method,
                'payment_method' => $request->payment_method,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);


            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'total_price' => $item->quantity * $item->price,
                ]);

                // Update product stock
                if ($item->product->track_quantity) {
                    $item->product->decrement('quantity', $item->quantity);
                    $item->product->updateStockStatus();
                }
            }

            // Clear cart
            $cart->clear();

            // Create initial payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $order->total_amount,
                'status' => 'pending',
                'transaction_id' => null,
            ]);

            DB::commit();

            // Redirect to payment gateway or order confirmation
            return response()->json([
                'success' => true,
                'redirect_url' => route('checkout.success', $order->order_number)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

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
     * Save address
     */
    public function saveAddress(Request $request)
    {
        $request->validate([
            'type' => 'required|in:shipping,billing',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        $address = Address::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'is_default' => $request->boolean('is_default', false),
        ]);

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    /**
     * Calculate shipping
     */
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        // Implement your shipping calculation logic
        $shippingAmount = 0; // Default free shipping

        // Example: Charge shipping for specific areas
        if (in_array($request->city, ['Remote Area 1', 'Remote Area 2'])) {
            $shippingAmount = 150;
        }

        return response()->json([
            'success' => true,
            'shipping_amount' => $shippingAmount
        ]);
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

    /**
     * Get shipping address ID
     */
    private function getShippingAddressId(Request $request)
    {
        if ($request->use_existing_shipping && $request->shipping_address_id) {
            return $request->shipping_address_id;
        }

        // Create new shipping address
        if (Auth::check() && $request->save_address) {
            $address = Address::create([
                'user_id' => Auth::id(),
                'type' => 'shipping',
                'first_name' => $request->shipping_first_name,
                'last_name' => $request->shipping_last_name,
                'email' => $request->shipping_email,
                'phone' => $request->shipping_phone,
                'address_line_1' => $request->shipping_address_1,
                'address_line_2' => $request->shipping_address_2,
                'city' => $request->shipping_city,
                'state' => $request->shipping_state,
                'postal_code' => $request->shipping_postal_code,
                'country' => $request->shipping_country,
            ]);
        }
        return $address->id;
    }

    /**
     * Get billing address ID
     */
    private function getBillingAddressId(Request $request)
    {
        if ($request->same_as_shipping) {
            return $this->getShippingAddressId($request);
        }

        if ($request->use_existing_billing && $request->billing_address_id) {
            return $request->billing_address_id;
        }

        // Create new billing address
        $address = Address::create([
            'user_id' => Auth::id(),
            'type' => 'billing',
            'first_name' => $request->billing_first_name,
            'last_name' => $request->billing_last_name,
            'email' => $request->billing_email,
            'phone' => $request->billing_phone,
            'address_line_1' => $request->billing_address_1,
            'address_line_2' => $request->billing_address_2,
            'city' => $request->billing_city,
            'state' => $request->billing_state,
            'postal_code' => $request->billing_postal_code,
            'country' => $request->billing_country,
        ]);

        return $address->id;
    }

    /**
     * Process direct checkout (from product page)
     */
    public function directCheckout(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = $request->quantity ?? 1;

        // Check stock
        if ($product->track_quantity && $product->quantity < $quantity && !$product->allow_backorder) {
            return redirect()->back()
                ->with('error', 'Product is out of stock');
        }

        // Create temporary cart with single item
        $cart = Cart::getCurrentCart();
        $cart->clear(); // Clear existing items
        $cart->addItem($product->id, $quantity);

        return redirect()->route('checkout.index');
    }
}
