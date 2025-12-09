<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $brands = Brand::all();
        $vendors = User::role('customer')->get();

        $products = [
            [
                'name' => 'iPhone 15 Pro Max',
                'short_description' => 'Latest Apple smartphone with advanced features',
                'description' => 'Experience the power of iPhone 15 Pro Max with its revolutionary camera system, A17 Pro chip, and titanium design.',
                'price' => 1299.99,
                'compare_price' => 1499.99,
                'quantity' => 100,
                'is_featured' => true,
                'is_bestseller' => true,
                'is_new' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'short_description' => 'Premium Android smartphone with S Pen',
                'description' => 'The ultimate Galaxy smartphone with built-in S Pen, powerful camera system, and intelligent AI features.',
                'price' => 1199.99,
                'compare_price' => 1399.99,
                'quantity' => 85,
                'is_featured' => true,
                'is_bestseller' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'short_description' => 'Noise cancelling wireless headphones',
                'description' => 'Industry-leading noise cancellation with premium sound quality and 30-hour battery life.',
                'price' => 399.99,
                'compare_price' => 499.99,
                'quantity' => 50,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Apple Watch Series 9',
                'short_description' => 'Advanced smartwatch with health monitoring',
                'description' => 'Track your fitness, receive notifications, and monitor your health with the latest Apple Watch.',
                'price' => 399.99,
                'compare_price' => 449.99,
                'quantity' => 120,
                'is_bestseller' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Nike Air Max 270',
                'short_description' => 'Comfortable running shoes',
                'description' => 'Experience maximum comfort with Nike Air Max 270 running shoes.',
                'price' => 159.99,
                'compare_price' => 189.99,
                'quantity' => 200,
                'status' => 'active',
            ],
            [
                'name' => 'MacBook Pro 16-inch',
                'short_description' => 'Professional laptop for creative work',
                'description' => 'Powerful laptop with M3 Pro chip, Liquid Retina XDR display, and up to 22 hours of battery life.',
                'price' => 2499.99,
                'compare_price' => 2999.99,
                'quantity' => 40,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Canon EOS R5',
                'short_description' => 'Professional mirrorless camera',
                'description' => 'High-performance mirrorless camera with 45MP full-frame sensor and 8K video recording.',
                'price' => 3899.99,
                'compare_price' => 4299.99,
                'quantity' => 25,
                'status' => 'active',
            ],
            [
                'name' => 'LG OLED C3 Series',
                'short_description' => 'Premium 4K Smart TV',
                'description' => 'Experience stunning picture quality with LG OLED TV featuring AI-powered 4K upscaling.',
                'price' => 1999.99,
                'compare_price' => 2499.99,
                'quantity' => 35,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Dyson V15 Detect',
                'short_description' => 'Cordless vacuum cleaner',
                'description' => 'Intelligent cordless vacuum with laser dust detection and powerful suction.',
                'price' => 799.99,
                'compare_price' => 899.99,
                'quantity' => 60,
                'status' => 'active',
            ],
            [
                'name' => 'KitchenAid Stand Mixer',
                'short_description' => 'Professional kitchen mixer',
                'description' => 'Powerful stand mixer for all your baking needs with various attachments.',
                'price' => 449.99,
                'compare_price' => 599.99,
                'quantity' => 75,
                'is_bestseller' => true,
                'status' => 'active',
            ],
            [
                'name' => 'PlayStation 5',
                'short_description' => 'Next-gen gaming console',
                'description' => 'Experience lightning-fast loading with an ultra-high-speed SSD, deeper immersion with support for haptic feedback.',
                'price' => 499.99,
                'quantity' => 90,
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Bose QuietComfort 45',
                'short_description' => 'Wireless noise cancelling headphones',
                'description' => 'World-class noise cancellation for a better listening experience.',
                'price' => 329.99,
                'compare_price' => 379.99,
                'quantity' => 70,
                'status' => 'active',
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'short_description' => 'Gaming console with OLED screen',
                'description' => 'Play at home on your TV or on-the-go with a vibrant OLED screen.',
                'price' => 349.99,
                'quantity' => 110,
                'status' => 'active',
            ],
            [
                'name' => 'GoPro HERO12 Black',
                'short_description' => 'Action camera',
                'description' => 'Capture your adventures with professional-quality video and photo capabilities.',
                'price' => 399.99,
                'compare_price' => 449.99,
                'quantity' => 45,
                'status' => 'active',
            ],
            [
                'name' => 'Kindle Paperwhite',
                'short_description' => 'Waterproof e-reader',
                'description' => 'Read comfortably with a glare-free, high-resolution display.',
                'price' => 139.99,
                'compare_price' => 169.99,
                'quantity' => 150,
                'is_bestseller' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Yeti Rambler 36 oz',
                'short_description' => 'Insulated water bottle',
                'description' => 'Keeps drinks cold for 36 hours or hot for 12 hours.',
                'price' => 59.99,
                'quantity' => 200,
                'status' => 'active',
            ],
            [
                'name' => 'Lululemon ABC Pants',
                'short_description' => 'Comfortable stretch pants',
                'description' => 'Versatile pants that feel like sweatpants but look like dress pants.',
                'price' => 128.00,
                'quantity' => 120,
                'status' => 'active',
            ],
            [
                'name' => 'Patagonia Nano Puff Jacket',
                'short_description' => 'Lightweight insulated jacket',
                'description' => 'Ultra-lightweight, packable, and warm synthetic insulation.',
                'price' => 229.00,
                'compare_price' => 279.00,
                'quantity' => 80,
                'status' => 'active',
            ],
            [
                'name' => 'Vitamix 5200 Blender',
                'short_description' => 'Professional-grade blender',
                'description' => 'Powerful blender for smoothies, soups, and more.',
                'price' => 449.95,
                'compare_price' => 599.95,
                'quantity' => 55,
                'status' => 'active',
            ],
            [
                'name' => 'AirPods Pro (2nd Gen)',
                'short_description' => 'Wireless earbuds with noise cancellation',
                'description' => 'Active noise cancellation and adaptive transparency mode.',
                'price' => 249.99,
                'quantity' => 180,
                'is_featured' => true,
                'is_bestseller' => true,
                'status' => 'active',
            ],
        ];

        foreach ($products as $productData) {
            $category = $categories->random();
            $brand = $brands->random();
            $vendor = $vendors->random();

            // Generate realistic product data
            $costPrice = $productData['price'] * 0.6; // 40% margin
            $weight = rand(100, 5000) / 100; // 1g to 5kg

            Product::create(array_merge($productData, [
                'sku' => 'PROD-' . strtoupper(Str::random(8)),
                'slug' => Str::slug($productData['name']),
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'vendor_id' => $vendor->id,
                'cost_price' => $costPrice,
                'alert_quantity' => 10,
                'track_quantity' => true,
                'allow_backorder' => rand(0, 1) == 1,
                'featured_image' => null,
                'gallery_images' => null,
                'weight' => $weight,
                'length' => rand(10, 100) / 10,
                'width' => rand(10, 100) / 10,
                'height' => rand(10, 100) / 10,
                'meta_title' => $productData['name'],
                'meta_description' => $productData['short_description'],
                'meta_keywords' => implode(', ', explode(' ', $productData['name'])),
                'stock_status' => $productData['quantity'] > 0 ? 'in_stock' : 'out_of_stock',
                'average_rating' => rand(35, 50) / 10, // 3.5 to 5.0
                'rating_count' => rand(5, 200),
                'total_sold' => rand(0, $productData['quantity'] * 2),
                'total_revenue' => rand(100, 10000),
            ]));
        }

        // Create some draft and inactive products
        for ($i = 1; $i <= 5; $i++) {
            $category = $categories->random();
            $brand = $brands->random();
            $vendor = $vendors->random();

            Product::create([
                'name' => 'Draft Product ' . $i,
                'sku' => 'DRAFT-' . strtoupper(Str::random(6)),
                'slug' => 'draft-product-' . $i,
                'short_description' => 'This is a draft product',
                'description' => 'This product is in draft status and will be published soon.',
                'price' => rand(20, 100),
                'quantity' => rand(0, 10),
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'vendor_id' => $vendor->id,
                'cost_price' => rand(10, 50),
                'status' => 'draft',
                'stock_status' => 'out_of_stock',
                'alert_quantity' => 5,
                'meta_title' => 'Draft Product ' . $i,
                'meta_description' => 'Draft product description',
            ]);
        }

        // Create some out of stock products
        for ($i = 1; $i <= 5; $i++) {
            $category = $categories->random();
            $brand = $brands->random();
            $vendor = $vendors->random();

            Product::create([
                'name' => 'Out of Stock Product ' . $i,
                'sku' => 'OOS-' . strtoupper(Str::random(6)),
                'slug' => 'out-of-stock-product-' . $i,
                'short_description' => 'This product is temporarily out of stock',
                'description' => 'We are expecting more stock soon. Please check back later.',
                'price' => rand(50, 200),
                'quantity' => 0,
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'vendor_id' => $vendor->id,
                'cost_price' => rand(20, 100),
                'status' => 'active',
                'stock_status' => 'out_of_stock',
                'allow_backorder' => rand(0, 1) == 1,
                'alert_quantity' => 5,
            ]);
        }
    }
}
