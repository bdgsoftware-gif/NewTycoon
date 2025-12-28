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
            'quantity' => 'required|integer|min:1|max:100'
        ]);

        $quantity = $request->quantity ?? 1;

        // Check stock availability
        if ($product->track_quantity && $product->quantity < $quantity && !$product->allow_backorder) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock',
                    'type' => 'error',
                    'cart_count' => Cart::getCurrentCart()->total_items ?? 0
                ], 400);
            }

            flash('Product is out of stock', 'error', 3000, 'Please try another product');
            return redirect()->back();
        }

        try {
            // Get current cart
            $cart = Cart::getCurrentCart();

            // Add item to cart
            $cart->addItem($product->id, $quantity);

            // Clear cart cache
            Cache::forget("cart_" . (auth()->id() ?? session()->getId()));

            // Refresh cart to get updated data
            $cart->refresh();
            $cartCount = $cart->total_items;

            // Prepare response
            $response = [
                'success' => true,
                'message' => "{$product->name} added to cart",
                'type' => 'success',
                'cart_count' => $cartCount,
                'product_name' => $product->name,
                'cart_total' => format_currency($cart->subtotal),
                'cart_subtotal' => format_currency($cart->subtotal)
            ];

            // AJAX response
            if ($request->expectsJson()) {
                return response()->json($response);
            }

            // Non-AJAX response
            flash($response['message'], $response['type'], 3000, "Item successfully added to your shopping cart");
            return redirect()->back();
        } catch (\Exception $e) {
            // Error handling
            $errorResponse = [
                'success' => false,
                'message' => 'Failed to add to cart: ' . $e->getMessage(),
                'type' => 'error',
                'cart_count' => Cart::getCurrentCart()->total_items ?? 0
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 500);
            }

            flash($errorResponse['message'], $errorResponse['type'], 3000, 'Please try again');
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
        $quantity = $request->quantity;

        try {
            // Check stock if increasing quantity
            if ($quantity > 0) {
                $cartItem = $cart->items()->where('product_id', $product->id)->first();
                if ($cartItem && $quantity > $cartItem->quantity) {
                    $increaseAmount = $quantity - $cartItem->quantity;
                    if ($product->track_quantity && $product->quantity < $increaseAmount && !$product->allow_backorder) {
                        $response = [
                            'success' => false,
                            'message' => 'Not enough stock available',
                            'type' => 'warning',
                            'cart_count' => $cart->total_items
                        ];

                        if ($request->expectsJson()) {
                            return response()->json($response, 400);
                        }

                        flash($response['message'], $response['type'], 3000, 'Only ' . $product->quantity . ' items available');
                        return redirect()->back();
                    }
                }
            }

            $cart->updateItem($product->id, $quantity);
            Cache::forget("cart_" . (auth()->id() ?? session()->getId()));

            // Refresh cart data
            $cart->refresh();

            // Get updated item
            $updatedItem = $cart->items()->where('product_id', $product->id)->first();
            $itemTotal = $updatedItem ? $updatedItem->quantity * $updatedItem->price : 0;

            $response = [
                'success' => true,
                'message' => $quantity == 0 ? 'Item removed from cart' : 'Cart updated successfully',
                'type' => 'success',
                'cart_count' => $cart->total_items,
                'cart_total' => format_currency($cart->subtotal),
                'cart_subtotal' => format_currency($cart->subtotal),
                'item_total' => format_currency($itemTotal) // Make sure this is included
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            flash($response['message'], $response['type'], 3000, 'Your cart has been updated');
            return redirect()->route('cart.index');
        } catch (\Exception $e) {
            $errorResponse = [
                'success' => false,
                'message' => 'Failed to update cart: ' . $e->getMessage(),
                'type' => 'error',
                'cart_count' => $cart->total_items ?? 0
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 500);
            }

            flash($errorResponse['message'], $errorResponse['type'], 3000, 'Please try again');
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

            // Refresh cart data
            $cart->refresh();

            $response = [
                'success' => true,
                'message' => 'Product removed from cart',
                'type' => 'success',
                'cart_count' => $cart->total_items,
                'cart_total' => format_currency($cart->subtotal),
                'cart_subtotal' => format_currency($cart->subtotal),
                'product_name' => $product->name
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            flash($response['message'], $response['type'], 3000, $product->name . ' has been removed from your cart');
            return redirect()->route('cart.index');
        } catch (\Exception $e) {
            $errorResponse = [
                'success' => false,
                'message' => 'Failed to remove item: ' . $e->getMessage(),
                'type' => 'error',
                'cart_count' => Cart::getCurrentCart()->total_items ?? 0
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 500);
            }

            flash($errorResponse['message'], $errorResponse['type'], 3000, 'Please try again');
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

            $response = [
                'success' => true,
                'message' => 'Cart cleared successfully',
                'type' => 'success',
                'cart_count' => 0,
                'cart_total' => format_currency(0),
                'cart_subtotal' => format_currency(0)
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            flash($response['message'], $response['type'], 3000, 'All items have been removed from your cart');
            return redirect()->route('cart.index');
        } catch (\Exception $e) {
            $errorResponse = [
                'success' => false,
                'message' => 'Failed to clear cart: ' . $e->getMessage(),
                'type' => 'error',
                'cart_count' => Cart::getCurrentCart()->total_items ?? 0
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 500);
            }

            flash($errorResponse['message'], $errorResponse['type'], 3000, 'Please try again');
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
            'success' => true,
            'count' => $cart->total_items,
            'total' => format_currency($cart->subtotal),
            'cart_count' => $cart->total_items,
            'cart_total' => format_currency($cart->subtotal)
        ]);
    }

    /**
     * Get cart count (AJAX only)
     */
    public function count(Request $request)
    {
        if (!$request->expectsJson()) {
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
