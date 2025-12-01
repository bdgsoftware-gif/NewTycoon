<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('frontend.home', compact('footerData', 'navigation', 'heroSlides', 'categories', 'products', 'smartSections', 'recommendedProducts', 'featuredProducts', 'saleProducts', 'newArrivals'));
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
            ]
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
                'name' => 'Wireless Bluetooth Headphones 5',
                'slug' => 'wireless-bluetooth-headphones-5', // Fixed: removed space, added hyphen
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
                'slug' => 'wireless-bluetooth-headphones', // Different from first
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
                'name' => 'Smart Fitness Watch Series 6', // Changed name
                'slug' => 'smart-fitness-watch-series-6', // Different slug
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
                'name' => 'Professional DSLR Camera Kit', // Changed name
                'slug' => 'professional-dslr-camera-kit', // Different slug
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
                'name' => 'Gaming Laptop Pro Max', // Changed name
                'slug' => 'gaming-laptop-pro-max', // Different slug
                'images' => [
                    'images/products/default1.png',
                    'images/products/default2.png'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => false,
            ]
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
}
