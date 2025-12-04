<?php

namespace App\Http\Controllers\Frontend;

use App\Models\AdBanner;
use App\Models\UserStory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $footerController = new FooterController();
        $footerData = $footerController->getFooterData();

        // Get navigation data
        $navigation = $this->getNavigation();

        $heroSlides = $this->heroSlides();
        $categories = $this->categories();
        $products = $this->products();
        $smartSections = $this->smartSections();
        // dd($categories);
        $recommendedProducts = $this->getRecommendedProducts();
        $featuredProducts = $this->getFeaturedProducts();
        $newArrivals = $this->newArrivals();
        $saleProducts = $this->saleProducts();

        $adsBanners = $this->getAdsBanners();
        $userStories = $this->getUserStories();

        return view('frontend.home', compact('footerData', 'navigation', 'heroSlides', 'categories', 'products', 'smartSections', 'recommendedProducts', 'featuredProducts', 'saleProducts', 'newArrivals', 'adsBanners', 'userStories'));
    }

    protected function getNavigation()
    {
        return [
            [
                'name' => 'TV',
                'url'  => '/tvs-home-theater/all-tvs', // Main TV category page
                'children' => [
                    [
                        'name' => 'OLED TVs',
                        'url'  => '/tvs-home-theater/qled-tvs/oled-tvs' // Specific TV type
                    ],
                    [
                        'name' => 'Soundbars',
                        'url'  => '/audio-video/soundbars' // Related Audio product
                    ]
                ]
            ],

            [
                'name' => 'Monitors',
                'url'  => '/computing/monitors', // Main Monitors category page
                'children' => [
                    [
                        'name' => 'Gaming Monitors',
                        'url'  => '/computing/monitors/gaming-monitors' // Specific Monitor type
                    ],
                    [
                        'name' => 'Smart Monitors',
                        'url'  => '/computing/monitors/smart-monitors' // Specific Monitor type
                    ]
                ]
            ],

            [
                'name' => 'Cameras',
                'url'  => '/electronics/interchangeable-lens-cameras',
                'children' => [
                    [
                        'name' => 'Alpha Mirrorless',
                        'url'  => '/electronics/interchangeable-lens-cameras/alpha'
                    ],
                    [
                        'name' => 'Headphones & Audio',
                        'url'  => '/electronics/headphones-audio'
                    ]
                ]
            ],

            [
                'name' => 'Lighting',
                'url'  => '/home-appliances/lighting-solutions',
                'children' => [
                    [
                        'name' => 'Smart Lighting',
                        'url'  => '/home-appliances/smart-lighting'
                    ],
                    [
                        'name' => 'Bulbs & Fixtures',
                        'url'  => '/home-appliances/lighting-fixtures'
                    ]
                ]
            ],

            [
                'name' => 'Fans',
                'url'  => '/home-appliances/air-care/fans',
                'children' => [
                    [
                        'name' => 'Tower Fans',
                        'url'  => '/home-appliances/air-care/tower-fans'
                    ],
                    [
                        'name' => 'Ceiling Fans',
                        'url'  => '/home-appliances/air-care/ceiling-fans'
                    ]
                ]
            ],

            [
                'name' => 'Support',
                'url'  => '/support'
            ]
        ];
    }

    protected function heroSlides()
    {
        return [
            [
                'type' => 'image',
                'background' => 'images/hero/slide1.jpg',
                'has_content' => true,
                'content_position' => 'left',
                'badge' => 'New Collection',
                'title' => 'Premium Quality <span class="text-accent">Products</span>',
                'subtitle' => 'Discover our exclusive collection designed to enhance your lifestyle',
                'has_cta' => true,
                'cta_buttons' => [
                    [
                        'text' => 'Shop Now',
                        'url' => '/shop',
                        'type' => 'primary'
                    ],
                    [
                        'text' => 'Learn More',
                        'url' => '/about',
                        'type' => 'secondary'
                    ]
                ]
            ],
            [
                'type' => 'video',
                'background' => 'videos/hero-background.mp4',
                'has_content' => true,
                'content_position' => 'center',
                'badge' => 'Limited Time',
                'title' => 'Summer <span class="text-accent">Sale</span>',
                'subtitle' => 'Up to 50% off on selected items. Limited stock available.',
                'has_cta' => true,
                'cta_buttons' => [
                    [
                        'text' => 'View Deals',
                        'url' => '/sale',
                        'type' => 'primary'
                    ]
                ]
            ],
            [
                'type' => 'image',
                'background' => 'images/hero/slide3.jpg',
                'has_content' => true,
                'content_position' => 'right',
                'badge' => 'Featured',
                'title' => 'Elegant <span class="text-accent">Design</span>',
                'subtitle' => 'Experience the perfect blend of style and functionality',
                'has_cta' => false,
                'cta_buttons' => []
            ],
            [
                'type' => 'video',
                'background' => 'videos/back-cover-video.mp4',
                'has_content' => false,
                'content_position' => 'center',
                'badge' => null,
                'title' => null,
                'subtitle' => null,
                'has_cta' => false,
                'cta_buttons' => []
            ],
        ];
    }

    protected function categories()
    {
        return [
            [
                'id' => 1,
                'name' => 'Smart Phones',
                'imageUrl' => 'images/cat/default.png',
            ],
            [
                'id' => 2,
                'name' => 'Tabs',
                'imageUrl' => 'images/cat/default.png',
            ],
            [
                'id' => 3,
                'name' => 'Laptops',
                'imageUrl' => 'images/cat/default.png',
            ],
            [
                'id' => 4,
                'name' => 'Smart Watches',
                'imageUrl' => 'images/cat/default.png',
            ],
            [
                'id' => 5,
                'name' => 'Headphones',
                'imageUrl' => 'images/cat/default.png',
            ],
            [
                'id' => 6,
                'name' => 'Earbuds',
                'imageUrl' => 'images/cat/default.png',
            ],
            [
                'id' => 7,
                'name' => 'Power Tools',
                'imageUrl' => 'images/cat/default.png',
            ],
            [
                'id' => 8,
                'name' => 'Game Consoles',
                'imageUrl' => 'images/cat/default.png',
            ],
            [
                'id' => 9,
                'name' => 'Chargers',
                'imageUrl' => 'images/cat/default.png',
            ],
            [
                'id' => 10,
                'name' => 'Cable & Others',
                'imageUrl' => 'images/cat/default.png',
            ],
            [
                'id' => 11,
                'name' => 'Monitor',
                'imageUrl' => 'images/cat/default.png',
            ],
            [
                'id' => 12,
                'name' => 'Product Name',
                'imageUrl' => 'images/cat/default.png',
            ],
        ];
    }

    protected function products()
    {
        return [
            [
                'id' => 1,
                'name' => 'Wireless Bluetooth Headphones',
                'slug' => 'wireless-bluetooth-headphones',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 199.99,
                'discounted_price' => 149.99,
                'discount_percentage' => 25,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.5,
                'review_count' => 128,
                'description' => 'High-quality wireless headphones with noise cancellation.'
            ],
            [
                'id' => 2,
                'name' => 'Smart Fitness Watch Series 5',
                'slug' => 'smart-fitness-watch-series-5',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 299.99,
                'discounted_price' => 299.99,
                'discount_percentage' => 0,
                'in_stock' => false,
                'is_new' => false,
                'rating' => 4.2,
                'review_count' => 89,
                'description' => 'Advanced fitness tracking with heart rate monitoring.'
            ],
            [
                'id' => 3,
                'name' => 'Professional DSLR Camera',
                'slug' => 'professional-dslr-camera',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1299.99,
                'discounted_price' => 999.99,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.8,
                'review_count' => 256,
                'description' => 'Professional-grade DSLR camera for stunning photography.'
            ],
            [
                'id' => 4,
                'name' => 'Gaming Laptop Pro',
                'slug' => 'gaming-laptop-pro',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => false,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ],
            [
                'id' => 5,
                'name' => '4K Action Camera',
                'slug' => '4k-action-camera',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 399.99,
                'discounted_price' => 319.99,
                'discount_percentage' => 20,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.4,
                'review_count' => 54,
                'description' => 'Compact 4K action camera for durable, high-quality footage.'
            ],
            [
                'id' => 6,
                'name' => 'Noise-Cancelling Wireless Earbuds',
                'slug' => 'noise-cancelling-wireless-earbuds',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 149.99,
                'discounted_price' => 99.99,
                'discount_percentage' => 33,
                'in_stock' => true,
                'is_new' => false,
                'rating' => 4.1,
                'review_count' => 76,
                'description' => 'Pocket-sized earbuds with active noise cancellation.'
            ],
            [
                'id' => 7,
                'name' => 'Smart Home Speaker',
                'slug' => 'smart-home-speaker',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 99.99,
                'discounted_price' => 69.99,
                'discount_percentage' => 30,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.3,
                'review_count' => 142,
                'description' => 'Voice-controlled smart speaker with crisp audio.'
            ],
            [
                'id' => 8,
                'name' => '4K Ultra HD Monitor 27"',
                'slug' => '4k-ultra-hd-monitor-27',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 349.99,
                'discounted_price' => 299.99,
                'discount_percentage' => 14,
                'in_stock' => true,
                'is_new' => false,
                'rating' => 4.5,
                'review_count' => 66,
                'description' => 'Crisp 4K display with vibrant colors and wide viewing angles.'
            ],
        ];
    }

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

    // ==========================================
    protected function getRecommendedProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'Wireless Bluetooth Headphones',
                'slug' => 'wireless-bluetooth-headphones-5',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 199.99,
                'discounted_price' => 149.99,
                'discount_percentage' => 25,
                'in_stock' => true,
                'is_new' => true,
            ],
            [
                'id' => 2,
                'name' => 'Smart Fitness Watch Series',
                'slug' => 'smart-fitness-watch-series-5',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 299.99,
                'discounted_price' => 299.99,
                'discount_percentage' => 0,
                'in_stock' => false,
                'is_new' => false,
            ],
            [
                'id' => 3,
                'name' => 'Professional DSLR Camera',
                'slug' => 'professional-dslr-camera',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1299.99,
                'discounted_price' => 999.99,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
            ],
            [
                'id' => 4,
                'name' => 'Gaming Laptop Pro',
                'slug' => 'gaming-laptop-pro',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => false,
            ],
            [
                'id' => 5,
                'name' => 'Wireless Bluetooth Headphones',
                'slug' => 'wireless-bluetooth-headphones',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 199.99,
                'discounted_price' => 149.99,
                'discount_percentage' => 25,
                'in_stock' => true,
                'is_new' => true,
            ],
            [
                'id' => 6,
                'name' => 'Smart Fitness Watch Series 6',
                'slug' => 'smart-fitness-watch-series-6',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 299.99,
                'discounted_price' => 299.99,
                'discount_percentage' => 0,
                'in_stock' => false,
                'is_new' => false,
            ],
            [
                'id' => 7,
                'name' => 'Professional DSLR Camera Kit',
                'slug' => 'professional-dslr-camera-kit',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1299.99,
                'discounted_price' => 999.99,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
            ],
            [
                'id' => 8,
                'name' => 'Gaming Laptop Pro Max',
                'slug' => 'gaming-laptop-pro-max',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => false,
            ],
            [
                'id' => 9,
                'name' => '4K Action Camera',
                'slug' => '4k-action-camera',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 399.99,
                'discounted_price' => 319.99,
                'discount_percentage' => 20,
                'in_stock' => true,
                'is_new' => true,
            ],
            [
                'id' => 10,
                'name' => 'Noise-Cancelling Earbuds',
                'slug' => 'noise-cancelling-wireless-earbuds',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 149.99,
                'discounted_price' => 99.99,
                'discount_percentage' => 33,
                'in_stock' => true,
                'is_new' => false,
            ],
        ];
    }
    protected function getFeaturedProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'Wireless Bluetooth Headphones',
                'slug' => 'wireless-bluetooth-headphones',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 199.99,
                'discounted_price' => 149.99,
                'discount_percentage' => 25,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.5,
                'review_count' => 128,
                'description' => 'High-quality wireless headphones with noise cancellation.'
            ],
            [
                'id' => 2,
                'name' => 'Smart Fitness Watch Series 5',
                'slug' => 'smart-fitness-watch-series-5',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 299.99,
                'discounted_price' => 299.99,
                'discount_percentage' => 0,
                'in_stock' => false,
                'is_new' => false,
                'rating' => 4.2,
                'review_count' => 89,
                'description' => 'Advanced fitness tracking with heart rate monitoring.'
            ],
            [
                'id' => 3,
                'name' => 'Professional DSLR Camera',
                'slug' => 'professional-dslr-camera',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1299.99,
                'discounted_price' => 999.99,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.8,
                'review_count' => 256,
                'description' => 'Professional-grade DSLR camera for stunning photography.'
            ],
            [
                'id' => 4,
                'name' => 'Gaming Laptop Pro',
                'slug' => 'gaming-laptop-pro',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => false,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ]
        ];
    }
    protected function saleProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'Wireless Bluetooth Headphones',
                'slug' => 'wireless-bluetooth-headphones',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 199.99,
                'discounted_price' => 149.99,
                'discount_percentage' => 25,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.5,
                'review_count' => 128,
                'description' => 'High-quality wireless headphones with noise cancellation.'
            ],
            [
                'id' => 2,
                'name' => 'Smart Fitness Watch Series 5',
                'slug' => 'smart-fitness-watch-series-5',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 299.99,
                'discounted_price' => 299.99,
                'discount_percentage' => 0,
                'in_stock' => false,
                'is_new' => false,
                'rating' => 4.2,
                'review_count' => 89,
                'description' => 'Advanced fitness tracking with heart rate monitoring.'
            ],
            [
                'id' => 3,
                'name' => 'Professional DSLR Camera',
                'slug' => 'professional-dslr-camera',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1299.99,
                'discounted_price' => 999.99,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.8,
                'review_count' => 256,
                'description' => 'Professional-grade DSLR camera for stunning photography.'
            ],
            [
                'id' => 4,
                'name' => 'Gaming Laptop Pro',
                'slug' => 'gaming-laptop-pro',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => false,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ]
        ];
    }
    protected function newArrivals()
    {
        return [
            [
                'id' => 1,
                'name' => 'Wireless Bluetooth Headphones',
                'slug' => 'wireless-bluetooth-headphones',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 199.99,
                'discounted_price' => 149.99,
                'discount_percentage' => 25,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.5,
                'review_count' => 128,
                'description' => 'High-quality wireless headphones with noise cancellation.'
            ],
            [
                'id' => 2,
                'name' => 'Smart Fitness Watch Series 5',
                'slug' => 'smart-fitness-watch-series-5',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 299.99,
                'discounted_price' => 299.99,
                'discount_percentage' => 0,
                'in_stock' => false,
                'is_new' => false,
                'rating' => 4.2,
                'review_count' => 89,
                'description' => 'Advanced fitness tracking with heart rate monitoring.'
            ],
            [
                'id' => 3,
                'name' => 'Professional DSLR Camera',
                'slug' => 'professional-dslr-camera',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1299.99,
                'discounted_price' => 999.99,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.8,
                'review_count' => 256,
                'description' => 'Professional-grade DSLR camera for stunning photography.'
            ],
            [
                'id' => 4,
                'name' => 'Gaming Laptop Pro',
                'slug' => 'gaming-laptop-pro',
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => false,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ]
        ];
    }
    // ==========================================

    protected function getAdsBanners()
    {
        $adsBanners = AdBanner::where('is_active', true)
            ->orderBy('order')
            ->get();

        // If empty, return ads ads
        if ($adsBanners->isEmpty()) {
            $adsBanners = collect([
                (object)[
                    'image_path' => 'images/ads/ads2.png',
                    'link' => '#',
                    'target' => '_self',
                    'title' => null,
                    'description' => null,
                    'alt_text' => 'Dummy Advertisement Banner 1'
                ],
                (object)[
                    'image_path' => 'images/ads/ads15.png',
                    'link' => '#',
                    'target' => '_self',
                    'title' => null,
                    'description' => null,
                    'alt_text' => 'Dummy Advertisement Banner 2'
                ],
                (object)[
                    'image_path' => 'images/ads/ads3.png',
                    'link' => '#',
                    'target' => '_self',
                    'title' => 'Best Products Just for You',
                    'description' => 'Handpicked quality items curated for customers.',
                    'alt_text' => 'Dummy Advertisement Banner 3'
                ],
            ]);
        }

        return $adsBanners;
    }

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
                    'user_avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=random',
                    'video_path' => 'videos/demo/story1.mp4', // You can use placeholder videos
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
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
                    'user_avatar' => 'https://ui-avatars.com/api/?name=Mike+Chen&background=random',
                    'video_path' => 'videos/demo/story2.mp4',
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
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
                    'user_avatar' => 'https://ui-avatars.com/api/?name=Emma+Wilson&background=random',
                    'video_path' => 'videos/demo/story3.mp4',
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
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
                    'user_avatar' => 'https://ui-avatars.com/api/?name=Alex+Rodriguez&background=random',
                    'video_path' => 'videos/demo/story4.mp4',
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
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
                    'user_avatar' => 'https://ui-avatars.com/api/?name=Lisa+Park&background=random',
                    'video_path' => 'videos/demo/story5.mp4',
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
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
                    'user_avatar' => 'https://ui-avatars.com/api/?name=David+Miller&background=random',
                    'video_path' => 'videos/demo/story6.mp4',
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
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
                (object)[
                    'id' => 7,
                    'user_name' => 'Sophia Williams',
                    'user_avatar' => 'https://ui-avatars.com/api/?name=Sophia+Williams&background=random',
                    'video_path' => 'videos/demo/story7.mp4',
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'caption' => 'My new laptop arrived! The performance is incredible for both work and gaming.',
                    'likes_count' => 325,
                    'comments_count' => 52,
                    'views_count' => 1650,
                    'created_at' => now()->subDays(7),
                    'product' => (object)[
                        'id' => 7,
                        'name' => 'Gaming Laptop',
                        'slug' => 'gaming-laptop'
                    ]
                ],
                (object)[
                    'id' => 8,
                    'user_name' => 'James Wilson',
                    'user_avatar' => 'https://ui-avatars.com/api/?name=James+Wilson&background=random',
                    'video_path' => 'videos/demo/story8.mp4',
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'caption' => 'Testing the new gaming chair. The ergonomics are perfect for long gaming sessions.',
                    'likes_count' => 187,
                    'comments_count' => 29,
                    'views_count' => 920,
                    'created_at' => now()->subDays(8),
                    'product' => (object)[
                        'id' => 8,
                        'name' => 'Gaming Chair',
                        'slug' => 'gaming-chair'
                    ]
                ],
                // Add more dummy data to make 12 items total
                (object)[
                    'id' => 9,
                    'user_name' => 'Olivia Brown',
                    'user_avatar' => 'https://ui-avatars.com/api/?name=Olivia+Brown&background=random',
                    'video_path' => 'videos/demo/story9.mp4',
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'caption' => 'Unboxing my new tablet. The display quality is stunning for media consumption.',
                    'likes_count' => 212,
                    'comments_count' => 33,
                    'views_count' => 1050,
                    'created_at' => now()->subDays(9),
                    'product' => (object)[
                        'id' => 9,
                        'name' => 'Tablet Pro',
                        'slug' => 'tablet-pro'
                    ]
                ],
                (object)[
                    'id' => 10,
                    'user_name' => 'Daniel Lee',
                    'user_avatar' => 'https://ui-avatars.com/api/?name=Daniel+Lee&background=random',
                    'video_path' => 'videos/demo/story10.mp4',
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'caption' => 'Just installed the new SSD in my PC. The boot time is lightning fast!',
                    'likes_count' => 178,
                    'comments_count' => 24,
                    'views_count' => 850,
                    'created_at' => now()->subDays(10),
                    'product' => (object)[
                        'id' => 10,
                        'name' => 'SSD 1TB',
                        'slug' => 'ssd-1tb'
                    ]
                ],
                (object)[
                    'id' => 11,
                    'user_name' => 'Maya Patel',
                    'user_avatar' => 'https://ui-avatars.com/api/?name=Maya+Patel&background=random',
                    'video_path' => 'videos/demo/story11.mp4',
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'caption' => 'First look at the new webcam. The video quality is perfect for streaming and video calls.',
                    'likes_count' => 231,
                    'comments_count' => 35,
                    'views_count' => 1120,
                    'created_at' => now()->subDays(11),
                    'product' => (object)[
                        'id' => 11,
                        'name' => '4K Webcam',
                        'slug' => '4k-webcam'
                    ]
                ],
                (object)[
                    'id' => 12,
                    'user_name' => 'Ryan Taylor',
                    'user_avatar' => 'https://ui-avatars.com/api/?name=Ryan+Taylor&background=random',
                    'video_path' => 'videos/demo/story12.mp4',
                    'thumbnail' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                    'caption' => 'Testing the new microphone. Crystal clear audio for podcasts and gaming.',
                    'likes_count' => 195,
                    'comments_count' => 28,
                    'views_count' => 940,
                    'created_at' => now()->subDays(12),
                    'product' => (object)[
                        'id' => 12,
                        'name' => 'USB Microphone',
                        'slug' => 'usb-microphone'
                    ]
                ],
            ]);
        }

        return $userStories;
    }
}
