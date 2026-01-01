<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Str;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        $offer = Offer::create([
            'title' => 'Winter Dhamaka Offer 2025',
            'slug' => Str::slug('Winter Dhamaka Offer 2025'),
            'subtitle' => 'Enjoy the coolest discounts of the season with up to 70% off!',
            'background_type' => 'svg',
            'background_svg' => $this->winterSvg(),
            'timer_enabled' => true,
            'timer_end_date' => now()->addDays(7),
            'view_all_link' => 'products',
            'main_banner_image' => 'images/offers/main-banner.jpeg',
            'view_all_text' => 'View All Deals',
            'product_source' => 'manual',
            'product_limit' => 8,
            'status' => 'active',
            'order' => 1,
        ]);

        // Attach products (latest discounted)
        Product::where('discount_percentage', '>', 10)
            ->latest()
            ->take(20)
            ->get()
            ->each(function ($product, $index) use ($offer) {
                $offer->products()->attach($product->id, [
                    'order' => $index,
                ]);
            });
    }

    private function winterSvg(): string
    {
        return <<<SVG
<svg viewBox="0 0 1440 600" preserveAspectRatio="xMidYMid slice"
     xmlns="http://www.w3.org/2000/svg"
     class="absolute inset-0 w-full h-full">

    <defs>
        <linearGradient id="winterGradient" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#0f172a"/>
            <stop offset="50%" stop-color="#1e3a8a"/>
            <stop offset="100%" stop-color="#0ea5e9"/>
        </linearGradient>
    </defs>

    <rect width="1440" height="600" fill="url(#winterGradient)" />

    <g class="snow-layer" fill="white" opacity="0.6">
        <circle cx="100" cy="50" r="2"/>
        <circle cx="300" cy="120" r="1.5"/>
        <circle cx="500" cy="200" r="2.2"/>
        <circle cx="800" cy="100" r="1.8"/>
        <circle cx="1100" cy="160" r="2"/>
        <circle cx="1300" cy="80" r="1.6"/>
    </g>
</svg>
SVG;
    }
}
