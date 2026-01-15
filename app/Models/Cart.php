<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'session_id'];

    public function hasItem(int $productId): bool
    {
        return $this->items->contains('product_id', $productId);
    }

    /**
     * Get the cart for the current user/session
     */
    public static function getCurrentCart()
    {
        $sessionId = Session::getId();

        if (Auth::check()) {
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
    public function getItemTotal(int $productId): float
    {
        $item = $this->items->firstWhere('product_id', $productId);
        return $item ? ($item->quantity * $item->price) : 0;
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
        return DB::transaction(function () use ($productId, $quantity, $options) {

            $product = Product::lockForUpdate()->findOrFail($productId);

            // Stock check (now atomic)
            if ($product->track_quantity && $product->quantity < $quantity && !$product->allow_backorder) {
                throw new \Exception('Product out of stock');
            }

            $item = $this->items()
                ->where('product_id', $productId)
                ->lockForUpdate()
                ->first();

            if ($item) {
                $item->increment('quantity', $quantity);
            } else {
                $item = $this->items()->create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'options' => $options
                ]);
            }

            return $item;
        });
    }

    /**
     * Update item quantity
     */
    public function updateItem($productId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeItem($productId);
        }

        $item = $this->items()
            ->where('product_id', $productId)
            ->firstOrFail();

        $item->update(['quantity' => $quantity]);

        return $item;
    }


    /**
     * Remove item from cart
     */
    public function removeItem($productId): bool
    {
        return (bool) $this->items()
            ->where('product_id', $productId)
            ->delete();
    }
}
