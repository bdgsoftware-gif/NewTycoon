<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Offer;
use App\Models\Product;
use App\Models\AdBanner;
use App\Models\Category;
use App\Models\UserStory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $heroSlides = $this->heroSlides();

        // Get active categories with active parents
        $categories = Category::active()->root()->featured()->limit(12)->get();

        $products = $this->activeProductService->getHomepageActiveProducts();
        // Get active featured products
        $featuredProducts = $this->activeProductService->getActiveFeaturedProducts(8);
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


    public function getNavigation()
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
                'background' => 'images/hero/demo-banner.jpg',
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
                'background' => 'images/hero/demo-banner.jpg',
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
            [
                'type' => 'image',
                'background' => 'images/hero/demo-banner.jpg',
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
                'name' => 'Air Conditioner',
                'imageUrl' => 'images/cat/ac.png',
            ],
            [
                'id' => 2,
                'name' => 'Fan',
                'imageUrl' => 'images/cat/fan.png',
            ],
            [
                'id' => 3,
                'name' => 'Room Comforter',
                'imageUrl' => 'images/cat/room-comporter.png',
            ],
            [
                'id' => 4,
                'name' => 'Cookware',
                'imageUrl' => 'images/cat/cookware.png',
            ],
            [
                'id' => 5,
                'name' => 'Gas Burner',
                'imageUrl' => 'images/cat/gas-burner.png',
            ],
            [
                'id' => 6,
                'name' => 'Pressure Cooker',
                'imageUrl' => 'images/cat/pressure-cooker.png',
            ],
            [
                'id' => 7,
                'name' => 'Rice Cooker',
                'imageUrl' => 'images/cat/rice-cooker.png',
            ],
            [
                'id' => 8,
                'name' => 'Electric Kettle',
                'imageUrl' => 'images/cat/electric-kettle.png',
            ],
            [
                'id' => 9,
                'name' => 'Mixer Grinder',
                'imageUrl' => 'images/cat/mixer-grinder.png',
            ],
            [
                'id' => 10,
                'name' => 'LED TV',
                'imageUrl' => 'images/cat/led-tv.png',
            ],
            [
                'id' => 11,
                'name' => 'Monitor',
                'imageUrl' => 'images/cat/monitor.png',
            ],
            [
                'id' => 12,
                'name' => 'Refrigerator',
                'imageUrl' => 'images/cat/refrigerator.png',
            ],
        ];
    }

    protected function products()
    {
        return [
            [
                'id' => 1,
                'name' => 'TYCOON Refrigerator-202 L TCN-A3DBP-202 630x630x1420',
                'slug' => 'TYCOON-Refrigerator-202-L',
                'images' => [
                    'images/products/fr-07.jpg',
                    'images/products/fr-08.jpg'
                ],
                'original_price' => 39999,
                'discounted_price' => 35899,
                'discount_percentage' => 5,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.5,
                'review_count' => 128,
                'description' => 'High-quality wireless headphones with noise cancellation.'
            ],
            [
                'id' => 2,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-01.jpg',
                    'images/products/ck-02.jpg'
                ],
                'original_price' => 3500,
                'discounted_price' => 3350,
                'discount_percentage' => 0,
                'in_stock' => false,
                'is_new' => false,
                'rating' => 4.2,
                'review_count' => 89,
                'description' => 'Advanced fitness tracking with heart rate monitoring.'
            ],
            [
                'id' => 3,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-03.jpg',
                    'images/products/ck-04.jpg'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ],
            [
                'id' => 4,
                'name' => 'TYCOON Refrigerator-202 L TCN-A3DLW 630x630x1420',
                'slug' => 'TYCOON-Refrigerator-202-L',
                'images' => [
                    'images/products/fr-09.jpg',
                    'images/products/fr-010.jpg'
                ],
                'original_price' => 59999,
                'discounted_price' => 40750,
                'discount_percentage' => 20,
                'in_stock' => true,
                'is_new' => false,
                'rating' => 4.4,
                'review_count' => 54,
                'description' => 'Compact 4K action camera for durable, high-quality footage.'
            ],
            [
                'id' => 5,
                'name' => 'Tycoon Washing Machine 8.0 KG Top Loading',
                'slug' => 'Tycoon-Washing-Machine-8.0-KG-Top-Loading',
                'images' => [
                    'images/products/wm-01.jpg',
                    'images/products/wm-01.jpg'
                ],
                'original_price' => 125870,
                'discounted_price' => 105650,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.1,
                'review_count' => 76,
                'description' => 'Pocket-sized earbuds with active noise cancellation.'
            ],
            [
                'id' => 6,
                'name' => 'Tycoon Double Burner Glass LPG Stove TCN-DBLPGG-Fantasy Flower',
                'slug' => 'Tycoon-Double-Burner-Glass-LPG-Stove',
                'images' => [
                    'images/products/stv-02.jpg',
                    'images/products/stv-01.jpg'
                ],
                'original_price' => 6999,
                'discounted_price' => 5950,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => false,
                'rating' => 4.8,
                'review_count' => 256,
                'description' => 'Professional-grade DSLR camera for stunning photography.'
            ],

            [
                'id' => 7,
                'name' => 'Tycoon Double Burner Glass LPG Stove TCN-DBLPGG-Red Lily 720mmX380mmX115mm',
                'slug' => 'Tycoon-Double-Burner-Glass-LPG-Stove',
                'images' => [
                    'images/products/stv-03.jpg',
                    'images/products/stv-02.jpg'
                ],
                'original_price' => 5999,
                'discounted_price' => 4850,
                'discount_percentage' => 20,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.3,
                'review_count' => 142,
                'description' => 'Voice-controlled smart speaker with crisp audio.'
            ],
            [
                'id' => 8,
                'name' => 'Tycoon Hot & Cool AC 1.5 Ton Tycoon AC 1.5 Ton Hot & Cool Inverter WiFi (TCN 18K HC R410 INV WiFi) Indoor 920×306×195mm Outdoor - 853×349×602mm',
                'slug' => 'Tycoon-Hot-&-Cool-AC-1.5-Ton',
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
                'name' => 'TYCOON Refrigerator-202 L TCN-A3DBP-202 630x630x1420',
                'slug' => 'TYCOON-Refrigerator-202-L',
                'images' => [
                    'images/products/fr-07.jpg',
                    'images/products/fr-08.jpg'
                ],
                'original_price' => 39999,
                'discounted_price' => 35899,
                'discount_percentage' => 5,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.5,
                'review_count' => 128,
                'description' => 'High-quality wireless headphones with noise cancellation.'
            ],
            [
                'id' => 2,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-01.jpg',
                    'images/products/ck-02.jpg'
                ],
                'original_price' => 3500,
                'discounted_price' => 3350,
                'discount_percentage' => 0,
                'in_stock' => false,
                'is_new' => false,
                'rating' => 4.2,
                'review_count' => 89,
                'description' => 'Advanced fitness tracking with heart rate monitoring.'
            ],
            [
                'id' => 3,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-03.jpg',
                    'images/products/ck-04.jpg'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ],
            [
                'id' => 4,
                'name' => 'TYCOON Refrigerator-202 L TCN-A3DLW 630x630x1420',
                'slug' => 'TYCOON-Refrigerator-202-L',
                'images' => [
                    'images/products/fr-09.jpg',
                    'images/products/fr-010.jpg'
                ],
                'original_price' => 59999,
                'discounted_price' => 40750,
                'discount_percentage' => 20,
                'in_stock' => true,
                'is_new' => false,
                'rating' => 4.4,
                'review_count' => 54,
                'description' => 'Compact 4K action camera for durable, high-quality footage.'
            ],
            [
                'id' => 5,
                'name' => 'Tycoon Washing Machine 8.0 KG Top Loading',
                'slug' => 'Tycoon-Washing-Machine-8.0-KG-Top-Loading',
                'images' => [
                    'images/products/wm-01.jpg',
                    'images/products/wm-01.jpg'
                ],
                'original_price' => 125870,
                'discounted_price' => 105650,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.1,
                'review_count' => 76,
                'description' => 'Pocket-sized earbuds with active noise cancellation.'
            ],
            [
                'id' => 6,
                'name' => 'Tycoon Double Burner Glass LPG Stove TCN-DBLPGG-Fantasy Flower',
                'slug' => 'Tycoon-Double-Burner-Glass-LPG-Stove',
                'images' => [
                    'images/products/stv-02.jpg',
                    'images/products/stv-01.jpg'
                ],
                'original_price' => 6999,
                'discounted_price' => 5950,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => false,
                'rating' => 4.8,
                'review_count' => 256,
                'description' => 'Professional-grade DSLR camera for stunning photography.'
            ],

            [
                'id' => 7,
                'name' => 'Tycoon Double Burner Glass LPG Stove TCN-DBLPGG-Red Lily 720mmX380mmX115mm',
                'slug' => 'Tycoon-Double-Burner-Glass-LPG-Stove',
                'images' => [
                    'images/products/stv-03.jpg',
                    'images/products/stv-02.jpg'
                ],
                'original_price' => 5999,
                'discounted_price' => 4850,
                'discount_percentage' => 20,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.3,
                'review_count' => 142,
                'description' => 'Voice-controlled smart speaker with crisp audio.'
            ],
            [
                'id' => 8,
                'name' => 'Tycoon Hot & Cool AC 1.5 Ton Tycoon AC 1.5 Ton Hot & Cool Inverter WiFi (TCN 18K HC R410 INV WiFi) Indoor 920×306×195mm Outdoor - 853×349×602mm',
                'slug' => 'Tycoon-Hot-&-Cool-AC-1.5-Ton',
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
    protected function getFeaturedProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'TYCOON Refrigerator-202 L TCN-A3DBP-202 630x630x1420',
                'slug' => 'TYCOON-Refrigerator-202-L',
                'images' => [
                    'images/products/fr-07.jpg',
                    'images/products/fr-08.jpg'
                ],
                'original_price' => 39999,
                'discounted_price' => 35899,
                'discount_percentage' => 5,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.5,
                'review_count' => 128,
                'description' => 'High-quality wireless headphones with noise cancellation.'
            ],
            [
                'id' => 3,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-03.jpg',
                    'images/products/ck-04.jpg'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ],
            [
                'id' => 3,
                'name' => 'Tycoon Washing Machine 8.0 KG Top Loading',
                'slug' => 'Tycoon-Washing-Machine-8.0-KG-Top-Loading',
                'images' => [
                    'images/products/wm-01.jpg',
                    'images/products/wm-01.jpg'
                ],
                'original_price' => 125870,
                'discounted_price' => 105650,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.1,
                'review_count' => 76,
                'description' => 'Pocket-sized earbuds with active noise cancellation.'
            ],
            [
                'id' => 4,
                'name' => 'Tycoon Double Burner Glass LPG Stove TCN-DBLPGG-Red Lily 720mmX380mmX115mm',
                'slug' => 'Tycoon-Double-Burner-Glass-LPG-Stove',
                'images' => [
                    'images/products/stv-03.jpg',
                    'images/products/stv-02.jpg'
                ],
                'original_price' => 5999,
                'discounted_price' => 4850,
                'discount_percentage' => 20,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.3,
                'review_count' => 142,
                'description' => 'Voice-controlled smart speaker with crisp audio.'
            ],
            [
                'id' => 5,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-01.jpg',
                    'images/products/ck-02.jpg'
                ],
                'original_price' => 3500,
                'discounted_price' => 3350,
                'discount_percentage' => 0,
                'in_stock' => false,
                'is_new' => false,
                'rating' => 4.2,
                'review_count' => 89,
                'description' => 'Advanced fitness tracking with heart rate monitoring.'
            ],
            [
                'id' => 6,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-03.jpg',
                    'images/products/ck-04.jpg'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ],
        ];
    }
    protected function saleProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'TYCOON Refrigerator-202 L TCN-A3DBP-202 630x630x1420',
                'slug' => 'TYCOON-Refrigerator-202-L',
                'images' => [
                    'images/products/fr-07.jpg',
                    'images/products/fr-08.jpg'
                ],
                'original_price' => 39999,
                'discounted_price' => 35899,
                'discount_percentage' => 5,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.5,
                'review_count' => 128,
                'description' => 'High-quality wireless headphones with noise cancellation.'
            ],
            [
                'id' => 3,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-03.jpg',
                    'images/products/ck-04.jpg'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ],
            [
                'id' => 3,
                'name' => 'Tycoon Washing Machine 8.0 KG Top Loading',
                'slug' => 'Tycoon-Washing-Machine-8.0-KG-Top-Loading',
                'images' => [
                    'images/products/wm-01.jpg',
                    'images/products/wm-01.jpg'
                ],
                'original_price' => 125870,
                'discounted_price' => 105650,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.1,
                'review_count' => 76,
                'description' => 'Pocket-sized earbuds with active noise cancellation.'
            ],
            [
                'id' => 4,
                'name' => 'Tycoon Double Burner Glass LPG Stove TCN-DBLPGG-Red Lily 720mmX380mmX115mm',
                'slug' => 'Tycoon-Double-Burner-Glass-LPG-Stove',
                'images' => [
                    'images/products/stv-03.jpg',
                    'images/products/stv-02.jpg'
                ],
                'original_price' => 5999,
                'discounted_price' => 4850,
                'discount_percentage' => 20,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.3,
                'review_count' => 142,
                'description' => 'Voice-controlled smart speaker with crisp audio.'
            ],
            [
                'id' => 5,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-01.jpg',
                    'images/products/ck-02.jpg'
                ],
                'original_price' => 3500,
                'discounted_price' => 3350,
                'discount_percentage' => 0,
                'in_stock' => false,
                'is_new' => false,
                'rating' => 4.2,
                'review_count' => 89,
                'description' => 'Advanced fitness tracking with heart rate monitoring.'
            ],
            [
                'id' => 6,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-03.jpg',
                    'images/products/ck-04.jpg'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ],
        ];
    }
    protected function newArrivals()
    {
        return [
            [
                'id' => 1,
                'name' => 'TYCOON Refrigerator-202 L TCN-A3DBP-202 630x630x1420',
                'slug' => 'TYCOON-Refrigerator-202-L',
                'images' => [
                    'images/products/fr-07.jpg',
                    'images/products/fr-08.jpg'
                ],
                'original_price' => 39999,
                'discounted_price' => 35899,
                'discount_percentage' => 5,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.5,
                'review_count' => 128,
                'description' => 'High-quality wireless headphones with noise cancellation.'
            ],
            [
                'id' => 3,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-03.jpg',
                    'images/products/ck-04.jpg'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ],
            [
                'id' => 3,
                'name' => 'Tycoon Washing Machine 8.0 KG Top Loading',
                'slug' => 'Tycoon-Washing-Machine-8.0-KG-Top-Loading',
                'images' => [
                    'images/products/wm-01.jpg',
                    'images/products/wm-01.jpg'
                ],
                'original_price' => 125870,
                'discounted_price' => 105650,
                'discount_percentage' => 23,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.1,
                'review_count' => 76,
                'description' => 'Pocket-sized earbuds with active noise cancellation.'
            ],
            [
                'id' => 4,
                'name' => 'Tycoon Double Burner Glass LPG Stove TCN-DBLPGG-Red Lily 720mmX380mmX115mm',
                'slug' => 'Tycoon-Double-Burner-Glass-LPG-Stove',
                'images' => [
                    'images/products/stv-03.jpg',
                    'images/products/stv-02.jpg'
                ],
                'original_price' => 5999,
                'discounted_price' => 4850,
                'discount_percentage' => 20,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.3,
                'review_count' => 142,
                'description' => 'Voice-controlled smart speaker with crisp audio.'
            ],
            [
                'id' => 5,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-01.jpg',
                    'images/products/ck-02.jpg'
                ],
                'original_price' => 3500,
                'discounted_price' => 3350,
                'discount_percentage' => 0,
                'in_stock' => false,
                'is_new' => false,
                'rating' => 4.2,
                'review_count' => 89,
                'description' => 'Advanced fitness tracking with heart rate monitoring.'
            ],
            [
                'id' => 6,
                'name' => 'Tycoon 2.8L Rice Cooker TRM-240 1Y 320x320x342mm',
                'slug' => 'Tycoon-2.8L-Rice-Cooker',
                'images' => [
                    'images/products/ck-03.jpg',
                    'images/products/ck-04.jpg'
                ],
                'original_price' => 1999.99,
                'discounted_price' => 1799.99,
                'discount_percentage' => 10,
                'in_stock' => true,
                'is_new' => true,
                'rating' => 4.6,
                'review_count' => 167,
                'description' => 'High-performance gaming laptop with RTX graphics.'
            ],
        ];
    }


    // ==========================================

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

    // ==========================================
    public function offerHeadData(): array
    {
        $offerHeadData = [
            'title' => 'Winter Dhamaka Offer 2025',
            'subtitle' => 'Enjoy the coolest discounts of the season with up to 70% off!',
            'main_banner_image' => 'images/offers/main-banner.jpeg',
            'timer_enabled' => true,
            'timer_end_date' => now()->addDays(7)->format('Y-m-d H:i:s'), // Fixed: 7 days from now
            'view_all_link' => 'products.sale', // This will be converted to route
        ];

        return $offerHeadData;
    }
}
