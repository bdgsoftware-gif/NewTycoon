<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Offer;
use App\Models\Product;
use App\Models\AdBanner;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\UserStory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Services\Product\ProductService;
use App\Services\Product\ActiveProductService;
use App\Http\Resources\FeaturedProductViewResource;

class HomeController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected ActiveProductService $activeProductService,
    ) {}

    public function index()
    {
        $heroSlides = HeroSlide::active()->sorted()->get();
        // dd($heroSlides);

        // Get active categories with active parents
        // $categories = Category::active()->root()->featured()->limit(12)->get();
        $categories = Cache::remember('homepage.featured.categories', 3600, function () {
            return Category::active()->root()->featured()->limit(12)->get();
        });

        $products = $this->activeProductService->getHomepageActiveProducts();
        // Get active featured products
        $featuredProducts = Cache::remember('homepage.featured.products', 3600, function () {
            return $this->activeProductService->getActiveFeaturedProducts(8);
        });

        // $featuredProducts = FeaturedProductViewResource::collection($featuredProducts);
        // dd($featuredProducts);

        // Get new Arrivals products
        $newArrivals = $this->activeProductService->getActiveNewArrivals();
        // $newArrivals = FeaturedProductViewResource::collection($newArrivals);

        // Get Best Sells products
        $bestsells = $this->activeProductService->getActiveBestSells();
        // $bestsells = FeaturedProductViewResource::collection($bestsells);

        // Get Recommended Products products
        $recommendedProducts = $this->activeProductService->getActiveRecommendedProducts();
        // $recommendedProducts = FeaturedProductViewResource::collection($recommendedProducts);

        $smartSections = $this->smartSections();
        $adsBanners = $this->getAdsBanners();
        $adsAnotherBanners = $this->getAnotherAdsBanners();

        // Get offer data
        $offer = Offer::active()->with('products')->first();
        $offerProducts = $this->activeProductService->getActiveOfferProducts(8) ?? [];
        // dd($featuredProducts, $offerProducts);
        $userStories = $this->getUserStories();

        return view('frontend.home', compact(
            'heroSlides',
            'categories',
            'featuredProducts',
            'products',
            'newArrivals',
            'bestsells',
            'recommendedProducts',
            'smartSections',
            'adsBanners',
            'userStories',
            'adsAnotherBanners',
            'offer',
            'offerProducts'
        ));
    }

    // keeping for now
    protected function smartSections()
    {
        return [
            [
                'title' => 'Your Home, Always Secured',
                'description' => 'Smart cameras and locks work together to keep your home secure. Clear views, instant alerts, and keyless entry – all in one app.',
                'button' => 'Get Security Camera',
                'image' => 'images/smartads/security-camera.png',
                'reverse' => false,
                'special' => false
            ],
            [
                'title' => 'Your Home, Your Stage.',
                'description' => 'Stunning visuals, rich sound, and hands-free control.',
                'button' => 'Discover Comfort',
                'image' => 'images/smartads/tv.png',
                'reverse' => false,
                'special' => true
            ],
            [
                'title' => 'Comfort Made Simple',
                'description' => 'From thermostats that learn your routine to plugs that make any device smart – Lumio keeps you in control.',
                'button' => 'Discover Comfort',
                'image' => 'images/smartads/thermostat.png',
                'reverse' => true,
                'special' => false
            ],
        ];
    }

    // keeding for now
    protected function getAdsBanners()
    {
        $adsBanners = AdBanner::where('is_active', true)
            ->orderBy('order')
            ->get();

        if ($adsBanners->isEmpty()) {
            $adsBanners = collect([
                (object)[
                    'image_path' => 'storage/ads-banner/airad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/tvad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/fanad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/kettelads.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
            ]);
        }

        return $adsBanners;
    }
    // keeding for now
    protected function getAnotherAdsBanners()
    {
        $adsBanners = AdBanner::where('is_active', true)
            ->orderBy('order')
            ->get();

        if ($adsBanners->isEmpty()) {
            $adsBanners = collect([
                (object)[
                    'image_path' => 'storage/ads-banner/watchad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/tvad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/frezze.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/fanad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
            ]);
        }

        return $adsBanners;
    }

    // keeding for now
    protected function getUserStories()
    {
        $userStories = UserStory::with('product')
            ->where('is_approved', true)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(12) // Get 12 stories for 3 slides of 4
            ->get();

        // If no stories found, return dummy data
        if ($userStories->isEmpty()) {
            return collect([
                (object)[
                    'id' => 1,
                    'user_name' => 'Sarah Johnson',
                    'user_avatar' => 'images/stories/user.jpg',
                    'video_path' => 'videos/stories/story.mp4', // You can use placeholder videos
                    'thumbnail' => 'images/stories/fr-09.jpg',
                    'caption' => 'Just got my new gaming headset! The sound quality is absolutely incredible and the comfort is next level.',
                    'likes_count' => 245,
                    'comments_count' => 32,
                    'views_count' => 1200,
                    'created_at' => now()->subDays(2),
                    'product' => (object)[
                        'id' => 1,
                        'name' => 'Pro Gaming Headset',
                        'slug' => 'pro-gaming-headset'
                    ]
                ],
                (object)[
                    'id' => 2,
                    'user_name' => 'Mike Chen',
                    'user_avatar' => 'images/stories/user.jpg',
                    'video_path' => 'videos/stories/storyOk.mp4',
                    'thumbnail' => 'images/stories/bd-01.jpg',
                    'caption' => 'Unboxing the new wireless keyboard. The typing experience is so smooth!',
                    'likes_count' => 189,
                    'comments_count' => 21,
                    'views_count' => 980,
                    'created_at' => now()->subDays(3),
                    'product' => (object)[
                        'id' => 2,
                        'name' => 'Mechanical Keyboard',
                        'slug' => 'mechanical-keyboard'
                    ]
                ],
                (object)[
                    'id' => 3,
                    'user_name' => 'Emma Wilson',
                    'user_avatar' => 'images/stories/user.jpg',
                    'video_path' => 'videos/stories/story.mp4',
                    'thumbnail' => 'images/stories/fr-07.jpg',
                    'caption' => 'My new smartwatch arrived! The battery life is amazing and fitness tracking is super accurate.',
                    'likes_count' => 312,
                    'comments_count' => 45,
                    'views_count' => 1500,
                    'created_at' => now()->subDays(1),
                    'product' => (object)[
                        'id' => 3,
                        'name' => 'Smart Watch Pro',
                        'slug' => 'smart-watch-pro'
                    ]
                ],
                (object)[
                    'id' => 4,
                    'user_name' => 'Alex Rodriguez',
                    'user_avatar' => 'images/stories/user.jpg',
                    'video_path' => 'videos/stories/storyOk.mp4',
                    'thumbnail' => 'images/stories/wm-01.jpg',
                    'caption' => 'Testing out the new wireless earbuds. Noise cancellation is phenomenal!',
                    'likes_count' => 278,
                    'comments_count' => 38,
                    'views_count' => 1350,
                    'created_at' => now()->subDays(4),
                    'product' => (object)[
                        'id' => 4,
                        'name' => 'Wireless Earbuds',
                        'slug' => 'wireless-earbuds'
                    ]
                ],
                (object)[
                    'id' => 5,
                    'user_name' => 'Lisa Park',
                    'user_avatar' => 'images/stories/user.jpg',
                    'video_path' => 'videos/stories/story.mp4',
                    'thumbnail' => 'images/stories/car.jpg',
                    'caption' => 'Just set up my new monitor. The colors are so vibrant and the refresh rate is buttery smooth.',
                    'likes_count' => 198,
                    'comments_count' => 27,
                    'views_count' => 890,
                    'created_at' => now()->subDays(5),
                    'product' => (object)[
                        'id' => 5,
                        'name' => 'Gaming Monitor',
                        'slug' => 'gaming-monitor'
                    ]
                ],
                (object)[
                    'id' => 6,
                    'user_name' => 'David Miller',
                    'user_avatar' => 'images/stories/user.jpg',
                    'video_path' => 'videos/stories/story.mp4',
                    'thumbnail' => 'images/stories/car.jpg',
                    'caption' => 'First impressions of the new gaming mouse. The precision is unbelievable for competitive gaming.',
                    'likes_count' => 265,
                    'comments_count' => 41,
                    'views_count' => 1150,
                    'created_at' => now()->subDays(6),
                    'product' => (object)[
                        'id' => 6,
                        'name' => 'Gaming Mouse',
                        'slug' => 'gaming-mouse'
                    ]
                ],
            ]);
        }

        return $userStories;
    }
}
