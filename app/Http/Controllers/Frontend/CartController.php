<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

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
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $quantity = (int) $validated['quantity'];

        try {
            $cart = Cart::getCurrentCart();
            $cart->addItem($product->id, $quantity);
            $cart->refresh();

            $response = [
                'success' => true,
                'message' => "{$product->name} added to cart",
                'cart_count' => $cart->total_items,
                'cart_subtotal' => format_currency($cart->subtotal),
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            flash(
                $response['message'],
                'success',
                3000,
                'Item successfully added to your shopping cart'
            );

            return redirect()->back();
        } catch (\Throwable $e) {
            Log::error('Add to cart failed', [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'error' => $e->getMessage(),
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Unable to add product to cart. Please try again.',
                'cart_count' => Cart::getCurrentCart()->total_items ?? 0,
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 422);
            }

            flash($errorResponse['message'], 'error', 3000);
            return redirect()->back();
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0|max:100',
        ]);

        $quantity = (int) $validated['quantity'];

        try {
            $cart = Cart::getCurrentCart();

            // Quantity 0 means remove
            if ($quantity === 0) {
                $cart->removeItem($product->id);
            } else {
                $cart->updateItem($product->id, $quantity);
            }

            $cart->refresh();

            $response = [
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_count' => $cart->total_items,
                'cart_subtotal' => format_currency($cart->subtotal),
                'item_quantity' => $quantity,
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            flash($response['message'], 'success', 3000);
            return redirect()->route('cart.index');
        } catch (\Throwable $e) {
            Log::error('Cart update failed', [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'error' => $e->getMessage(),
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Unable to update cart. Please try again.',
                'cart_count' => Cart::getCurrentCart()->total_items ?? 0,
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 422);
            }

            flash($errorResponse['message'], 'error', 3000);
            return redirect()->back();
        }
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request, Product $product)
    {
        try {
            $cart = Cart::getCurrentCart();
            $cart->removeItem($product->id);
            $cart->refresh();

            $response = [
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $cart->total_items,
                'cart_subtotal' => format_currency($cart->subtotal),
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            flash($response['message'], 'success', 3000);
            return redirect()->route('cart.index');
        } catch (\Throwable $e) {
            Log::error('Cart remove failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Unable to remove item. Please try again.',
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 422);
            }

            flash($errorResponse['message'], 'error', 3000);
            return redirect()->back();
        }
    }

    /**
     * Clear entire cart
     */
    public function clear(Request $request)
    {
        try {
            $cart = Cart::getCurrentCart();
            $cart->clear();

            $response = [
                'success' => true,
                'message' => 'Cart cleared successfully',
                'cart_count' => 0,
                'cart_subtotal' => format_currency(0),
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            flash($response['message'], 'success', 3000);
            return redirect()->route('cart.index');
        } catch (\Throwable $e) {
            Log::error('Cart clear failed', [
                'error' => $e->getMessage(),
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Unable to clear cart. Please try again.',
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 422);
            }

            flash($errorResponse['message'], 'error', 3000);
            return redirect()->back();
        }
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
