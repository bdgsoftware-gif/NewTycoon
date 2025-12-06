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
                    'images/products/fr-07.jpg',
                    'images/products/fr-08.jpg'
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
                    'images/products/ck-01.jpg',
                    'images/products/ck-02.jpg'
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
                    'images/products/ac-04.jpg',
                    'images/products/ac-03.jpg'
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
                    'images/products/ck-03.jpg',
                    'images/products/ck-04.jpg'
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
                    'images/products/fr-09.jpg',
                    'images/products/fr-010.jpg'
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
                    'images/products/wm-01.jpg',
                    'images/products/wm-01.jpg'
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
                    'images/products/stv-03.jpg',
                    'images/products/stv-02.jpg'
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
                    'images/products/ac-01.jpg',
                    'images/products/ac-02.jpg'
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
                    'images/products/stv-03.jpg',
                    'images/products/stv-01.jpg'
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
                    'images/products/stv-01.jpg',
                    'images/products/stv-02.jpg'
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
                    'images/products/e-stv-03.jpg',
                    'images/products/e-stv-02.jpg'
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
                    'images/products/e-stv-02.jpg',
                    'images/products/e-stv-03.jpg'
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
                'name' => 'Wireless Bluetooth Headphones',
                'slug' => 'wireless-bluetooth-headphones',
                'images' => [
                    'images/products/fan-02.jpg',
                    'images/products/fan-07.jpg'
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
                    'images/products/fan-04.jpg',
                    'images/products/fan-01.jpg'
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
                    'images/products/bd-01.jpg',
                    'images/products/bd-01.jpg'
                ],
                'original_price' => 1299.99,
                'discounted_price' => 999.99,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
            ],
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
                    'user_avatar' => 'images/stories/user.jpg',
                    'video_path' => 'videos/stories/story.mp4', // You can use placeholder videos
                    'thumbnail' => 'images/fr-09.jpg',
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
                    'thumbnail' => 'images/refrigerator.jpg',
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
                    'thumbnail' => 'images/fr-07.jpg',
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
                    'thumbnail' => 'images/refrigerator.jpg',
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
                    'thumbnail' => 'images/car.jpg',
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
                    'thumbnail' => 'images/car.jpg',
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
