<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::getCurrentCart();

        return view('frontend.cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1',
            'options' => 'nullable|array'
        ]);

        $quantity = $request->quantity ?? 1;
        $options = $request->options ?? [];

        // Check stock
        if ($product->track_quantity && $product->quantity < $quantity && !$product->allow_backorder) {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock'
            ], 400);
        }

        $cart = Cart::getCurrentCart();
        $cart->addItem($product->id, $quantity, $options);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart_count' => $cart->total_items,
                'cart_total' => format_currency($cart->subtotal)
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Product added to cart');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $cart = Cart::getCurrentCart();

        // Check stock if increasing quantity
        $cartItem = $cart->items()->where('product_id', $product->id)->first();
        if ($cartItem && $request->quantity > $cartItem->quantity) {
            $increaseAmount = $request->quantity - $cartItem->quantity;
            if ($product->track_quantity && $product->quantity < $increaseAmount && !$product->allow_backorder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available'
                ], 400);
            }
        }

        $cart->updateItem($product->id, $request->quantity);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated',
                'cart_count' => $cart->total_items,
                'cart_total' => format_currency($cart->subtotal),
                'item_total' => format_currency($request->quantity * $product->price)
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Cart updated');
    }

    public function remove(Request $request, Product $product)
    {
        $cart = Cart::getCurrentCart();
        $cart->removeItem($product->id);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart',
                'cart_count' => $cart->total_items,
                'cart_total' => format_currency($cart->subtotal)
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Product removed from cart');
    }

    public function clear()
    {
        $cart = Cart::getCurrentCart();
        $cart->clear();

        return redirect()->route('cart.index')
            ->with('success', 'Cart cleared');
    }

    public function getCartSummary()
    {
        $cart = Cart::getCurrentCart();

        return response()->json([
            'count' => $cart->total_items,
            'total' => format_currency($cart->subtotal)
        ]);
    }
}
