<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        // Get some products
        $products = Product::limit(5)->get();
        $user = User::first();

        if ($user) {
            // Create a cart for the first user
            $cart = Cart::create([
                'user_id' => $user->id
            ]);

            // Add some items to the cart
            foreach ($products as $index => $product) {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $index + 1,
                    'price' => $product->price
                ]);
            }
        }

        // Create some guest carts
        for ($i = 1; $i <= 3; $i++) {
            $cart = Cart::create([
                'session_id' => 'session_' . $i
            ]);

            $product = Product::inRandomOrder()->first();
            if ($product) {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'price' => $product->price
                ]);
            }
        }
    }
}
