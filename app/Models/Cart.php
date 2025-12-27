<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'session_id'];

    /**
     * Get the cart for the current user/session
     */
    public static function getCurrentCart()
    {
        $sessionId = Session::getId();

        if (Auth::check()) {
            // If user is logged in, get or create cart for user
            $cart = self::firstOrCreate([
                'user_id' => Auth::id(),
            ]);

            // If there's a session cart, merge it
            $sessionCart = self::where('session_id', $sessionId)->first();
            if ($sessionCart) {
                $cart->mergeCart($sessionCart);
                $sessionCart->delete();
            }
        } else {
            // For guest users, use session
            $cart = self::firstOrCreate([
                'session_id' => $sessionId
            ]);
        }

        return $cart;
    }

    /**
     * Get the cart for the current user/session with caching
     */
    public static function getCurrentCartCached()
    {
        return cache()->remember("cart_" . (Auth::id() ?? session()->getId()), 10, function () {
            return self::getCurrentCart();
        });
    }

    /**
     * Merge another cart into this one
     */
    public function mergeCart(Cart $otherCart)
    {
        foreach ($otherCart->items as $item) {
            $existingItem = $this->items()
                ->where('product_id', $item->product_id)
                ->first();

            if ($existingItem) {
                $existingItem->quantity += $item->quantity;
                $existingItem->save();
            } else {
                $this->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'options' => $item->options
                ]);
            }
        }
    }

    /**
     * Get cart items
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get total items count
     */
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }

    /**
     * Get subtotal (without tax/shipping)
     */
    public function getSubtotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        $this->items()->delete();
    }

    /**
     * Add item to cart
     */
    public function addItem($productId, $quantity = 1, $options = [])
    {
        $product = Product::findOrFail($productId);

        // Check stock
        if ($product->track_quantity && $product->quantity < $quantity && !$product->allow_backorder) {
            throw new \Exception('Product out of stock');
        }

        $item = $this->items()
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            $this->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
                'options' => $options
            ]);
        }

        return $item;
    }

    /**
     * Update item quantity
     */
    public function updateItem($productId, $quantity)
    {
        $item = $this->items()
            ->where('product_id', $productId)
            ->firstOrFail();

        if ($quantity <= 0) {
            $item->delete();
            return null;
        }

        $item->quantity = $quantity;
        $item->save();

        return $item;
    }

    /**
     * Remove item from cart
     */
    public function removeItem($productId)
    {
        $this->items()
            ->where('product_id', $productId)
            ->delete();
    }
}
