<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
        // dd($product);
        if (!$product->is_active || !$product->in_stock) {
            return response()->json([
                'success' => false,
                'message' => 'This product is currently unavailable.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $quantity = (int) $validator->validated()['quantity'];

        $cart = Cart::getCurrentCart();
        try {
            $cart->addItem($product->id, $quantity);
            $cart->refresh();

            $response = [
                'success' => true,
                'message' => "{$product->name} added to cart",
                'cart_count' => $cart->total_items,
                'cart_total' => $cart->subtotal,
                'cart_subtotal' => $cart->subtotal,
                'item_total' => $cart->getItemTotal($product->id) ?? 0,
            ];

            if ($request->ajax() || $request->wantsJson()) {
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
                'cart_count' => $cart->total_items ?? 0,
            ];

            if ($request->ajax() || $request->wantsJson()) {
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
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $quantity = (int) $validator->validated()['quantity'];


        $cart = Cart::getCurrentCart();
        try {

            if (!$cart->hasItem($product->id)) {
                $cart->addItem($product->id, $quantity);
            } else {
                $cart->updateItem($product->id, $quantity);
            }

            $cart->refresh();

            $response = [
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_count' => $cart->total_items,
                'cart_total' => $cart->subtotal,
                'cart_subtotal' => $cart->subtotal,
                'item_quantity' => $quantity,
                'item_total' => $cart->getItemTotal($product->id) ?? 0,
            ];

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($response);
            }

            flash($response['message'], 'success', 3000);
            return redirect()->route('cart.index');
        } catch (\Throwable $e) {
            Log::error('Cart update failed', [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'cart_items' => $cart->items,
                'error' => $e->getMessage(),
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Unable to update cart. Please try again.',
                'cart_count' => $cart->total_items ?? 0,
            ];

            if ($request->ajax() || $request->wantsJson()) {
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
                'cart_total' => $cart->subtotal,
                'cart_subtotal' => $cart->subtotal,
            ];

            if ($request->ajax() || $request->wantsJson()) {
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

            if ($request->ajax() || $request->wantsJson()) {
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
                'cart_subtotal' => 0,
            ];

            if ($request->ajax() || $request->wantsJson()) {
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

            if ($request->ajax() || $request->wantsJson()) {
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
        if (!($request->ajax() || $request->wantsJson())) {
            abort(404);
        }

        $cart = Cart::getCurrentCart();

        return response()->json([
            'success' => true,
            'count' => $cart->total_items,
            'total' => $cart->subtotal,
        ]);
    }
}
