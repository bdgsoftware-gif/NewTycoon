<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $customers = User::role('customer')->get();

        $reviews = [
            'Great product! Very happy with my purchase.',
            'Good quality, but delivery took longer than expected.',
            'Excellent value for money. Would recommend!',
            'Product arrived damaged. Customer service was helpful.',
            'Better than expected. Very satisfied.',
            'Average product. Does the job but nothing special.',
            'Perfect for my needs. Easy to use.',
            'Not as described. Disappointed.',
            'Fast shipping and great product quality.',
            'Would buy again. Good experience overall.',
            'The product broke after a week of use.',
            'Exceeded my expectations. Very pleased.',
            'Good but could be improved.',
            'Best purchase I\'ve made this year!',
            'Works as advertised. No complaints.',
        ];

        foreach ($products as $product) {
            // Create 0-5 reviews per product
            $reviewCount = rand(0, 5);

            for ($i = 0; $i < $reviewCount; $i++) {
                $customer = $customers->random();
                $rating = rand(3, 5); // Most reviews are positive
                $rating = rand(0, 10) === 0 ? rand(1, 2) : $rating; // 10% chance of low rating

                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $customer->id,
                    'rating' => $rating,
                    'title' => fake()->words(rand(3, 6), true),
                    'comment' => $reviews[array_rand($reviews)],
                    'is_approved' => true,
                    'created_at' => now()->subDays(rand(0, 90)),
                ]);
            }

            // Update product rating stats
            $productReviews = Review::where('product_id', $product->id)->where('is_approved', true)->get();

            if ($productReviews->count() > 0) {
                $averageRating = $productReviews->avg('rating');
                $product->update([
                    'average_rating' => round($averageRating, 2),
                    'rating_count' => $productReviews->count(),
                ]);
            }
        }
    }
}
