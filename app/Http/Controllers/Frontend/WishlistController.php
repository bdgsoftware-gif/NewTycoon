<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    /**
     * Show wishlist page
     */
    public function index()
    {
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('frontend.wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add product to wishlist (AJAX compatible)
     */
    public function add(Request $request, Product $product)
    {
        try {
            // Prevent duplicate wishlist items
            $exists = Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product already in your wishlist.',
                ], 409);
            }

            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => "{$product->name} added to wishlist.",
                'wishlist_count' => Wishlist::where('user_id', auth()->id())->count(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Wishlist add failed', [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to add item to wishlist.',
            ], 500);
        }
    }

    /**
     * Remove product from wishlist
     */
    public function remove(Request $request, Product $product)
    {
        try {
            Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from wishlist.',
                'wishlist_count' => Wishlist::where('user_id', auth()->id())->count(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Wishlist remove failed', [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from wishlist.',
            ], 500);
        }
    }

    /**
     * Move wishlist item to cart
     */
    public function moveToCart(Request $request, Product $product)
    {
        try {
            // Get cart (guest/user logic already handled in Cart model)
            $cart = Cart::getCurrentCart();

            // Add product to cart (quantity = 1 by default)
            $cart->addItem($product->id, 1);

            // Remove from wishlist
            Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->delete();

            $cart->refresh();

            return response()->json([
                'success' => true,
                'message' => "{$product->name} moved to cart.",
                'cart_count' => $cart->total_items,
                'wishlist_count' => Wishlist::where('user_id', auth()->id())->count(),
                'cart_subtotal' => format_currency($cart->subtotal),
            ]);
        } catch (\Throwable $e) {
            Log::error('Wishlist move to cart failed', [
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to move item to cart.',
            ], 500);
        }
    }
}
