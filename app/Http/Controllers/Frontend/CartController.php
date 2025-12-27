<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = Cart::getCurrentCart();
        return view('frontend.cart.index', compact('cart'));
    }

    /**
     * Add item to cart (AJAX compatible)
     */
    public function add(Request $request, Product $product)
    {
        // Validate request
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = $request->quantity ?? 1;

        // Check stock availability
        if ($product->track_quantity && $product->quantity < $quantity && !$product->allow_backorder) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock',
                    'type' => 'error'
                ], 400);
            }

            flash('Product is out of stock', 'error');
            return redirect()->back();
        }

        try {
            // Get current cart (for user or guest)
            $cart = Cart::getCurrentCart();

            // Add item to cart
            $cart->addItem($product->id, $quantity);

            // Clear cart cache for fresh data
            Cache::forget("cart_" . (auth()->id() ?? session()->getId()));

            // Get updated cart count
            $cartCount = $cart->total_items;

            // Prepare success message
            $message = "{$product->name} added to cart";

            // AJAX response
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'type' => 'success',
                    'cart_count' => $cartCount,
                    'product_name' => $product->name
                ]);
            }
            // Non-AJAX response (regular form submission)
            flash($message, 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Error handling
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add to cart',
                    'type' => 'error'
                ], 500);
            }

            flash('Failed to add to cart', 'error');
            return redirect()->back();
        }
    }

    /**
     * Update cart item quantity (AJAX compatible)
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $cart = Cart::getCurrentCart();

        try {
            // Check stock if increasing quantity
            if ($request->quantity > 0) {
                $cartItem = $cart->items()->where('product_id', $product->id)->first();
                if ($cartItem && $request->quantity > $cartItem->quantity) {
                    $increaseAmount = $request->quantity - $cartItem->quantity;
                    if ($product->track_quantity && $product->quantity < $increaseAmount && !$product->allow_backorder) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Not enough stock available',
                            'type' => 'warning'
                        ], 400);
                    }
                }
            }

            $cart->updateItem($product->id, $request->quantity);

            Cache::forget("cart_" . (auth()->id() ?? session()->getId()));

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $request->quantity == 0 ? 'Item removed from cart' : 'Cart updated',
                    'type' => 'success',
                    'cart_count' => $cart->total_items,
                    'cart_total' => format_currency($cart->subtotal)
                ]);
            }

            flash('Cart updated', 'success');
            return redirect()->route('cart.index');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update cart',
                    'type' => 'error'
                ], 500);
            }

            flash('Failed to update cart', 'error');
            return redirect()->back();
        }
    }

    /**
     * Remove item from cart (AJAX compatible)
     */
    public function remove(Request $request, Product $product)
    {
        try {
            $cart = Cart::getCurrentCart();
            $cart->removeItem($product->id);

            Cache::forget("cart_" . (auth()->id() ?? session()->getId()));

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart',
                    'type' => 'success',
                    'cart_count' => $cart->total_items,
                    'cart_total' => format_currency($cart->subtotal)
                ]);
            }

            flash('Product removed from cart', 'success');
            return redirect()->route('cart.index');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove item',
                    'type' => 'error'
                ], 500);
            }

            flash('Failed to remove item', 'error');
            return redirect()->back();
        }
    }

    /**
     * Clear entire cart (AJAX compatible)
     */
    public function clear(Request $request)
    {
        try {
            $cart = Cart::getCurrentCart();
            $cart->clear();

            Cache::forget("cart_" . (auth()->id() ?? session()->getId()));

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart cleared',
                    'type' => 'success',
                    'cart_count' => 0,
                    'cart_total' => format_currency(0)
                ]);
            }

            flash('Cart cleared', 'success');
            return redirect()->route('cart.index');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to clear cart',
                    'type' => 'error'
                ], 500);
            }

            flash('Failed to clear cart', 'error');
            return redirect()->back();
        }
    }

    /**
     * Get cart summary for AJAX updates
     */
    public function getCartSummary()
    {
        $cart = Cart::getCurrentCart();

        return response()->json([
            'count' => $cart->total_items,
            'total' => format_currency($cart->subtotal)
        ]);
    }

    /**
     * Get current cart count (AJAX only)
     */
    public function count(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        try {
            $cart = Cart::getCurrentCart();

            return response()->json([
                'success' => true,
                'count' => $cart->total_items,
                'total' => format_currency($cart->subtotal)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get cart count',
                'count' => 0
            ], 500);
        }
    }
}
