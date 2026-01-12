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
    /**
     * Image mapping for products
     */
    private $productImages = [
        // Air Conditioners
        'split-ac' => ['ac-01.jpg', 'ac-02.jpg'],
        'window-ac' => ['ac-03.jpg', 'ac-04.jpg'],

        // Fans
        'ceiling-fan' => ['fan-01.jpg', 'fan-02.jpg'],
        'table-fan' => ['fan-05.jpg', 'fan-06.jpg'],

        // Refrigerators
        'single-door-fridges' => ['fridge-03.jpg', 'fridge-04.jpg'],
        'double-door-fridges' => ['fridge-05.jpg', 'fridge-06.jpg'],

        // TVs
        'led-tv' => ['tv-01.jpg', 'tv-02.jpg'],
        'smart-tv' => ['tv-03.jpg', 'tv-04.jpg'],

        // Mixer Grinders
        'mixer-grinder' => ['mixer-01.jpg', 'mixer-02.jpg'],
    ];

    public function run(): void
    {
        // Get vendor (first admin user)
        $vendor = User::role('admin')->first() ?? User::first();

        if (!$vendor) {
            $this->command->error('No users found! Please run UserSeeder first.');
            return;
        }

        // Get or create a brand
        $brand = Brand::firstOrCreate(
            ['name' => 'TYCOON'],
            [
                'name_en' => 'TYCOON',
                'name_bn' => 'টাইকুন',
                'slug' => 'tycoon',
                'description' => 'Premium home appliances and electronics brand',
                'description_en' => 'Premium home appliances and electronics brand',
                'description_bn' => 'প্রিমিয়াম হোম অ্যাপ্লায়েন্সেস এবং ইলেকট্রনিক্স ব্র্যান্ড',
                'is_active' => true,
            ]
        );

        // Get all leaf categories (categories that don't have children)
        $leafCategories = Category::whereDoesntHave('children')->get();

        if ($leafCategories->isEmpty()) {
            $this->command->error('No categories found! Please run CategorySeeder first.');
            return;
        }

        // Create 50 products with realistic data
        for ($i = 1; $i <= 50; $i++) {
            // Randomly select a leaf category
            $category = $leafCategories->random();

            // Determine product type based on category
            $productType = $this->determineProductType($category);

            // Generate product data
            $productData = $this->generateProductData($productType, $i);

            // Generate unique SKU
            $sku = 'TYC-' . date('Ym') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT);

            // Create the product
            Product::create([
                // English fields
                'name_en' => $productData['name_en'],
                'short_description_en' => $productData['short_description_en'],
                'description_en' => $productData['description_en'],
                'meta_title_en' => $productData['meta_title_en'],
                'meta_description_en' => $productData['meta_description_en'],

                // Bangla fields
                'name_bn' => $productData['name_bn'],
                'short_description_bn' => $productData['short_description_bn'],
                'description_bn' => $productData['description_bn'],
                'meta_title_bn' => $productData['meta_title_bn'],
                'meta_description_bn' => $productData['meta_description_bn'],

                // Original fields (will be handled by model accessors)
                // 'name' => $productData['name_en'], // Base name
                'sku' => $sku,
                'slug' => Str::slug($productData['name_en'] . ' ' . $i),
                // 'short_description' => $productData['short_description_en'], // Base description
                // 'description' => $productData['description_en'], // Base description
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'cost_price' => $productData['price'] * 0.65, // 35% margin
                'discount_percentage' => $productData['discount_percentage'],
                'quantity' => $productData['quantity'],
                'alert_quantity' => 5,
                'track_quantity' => true,
                'allow_backorder' => false,
                'model_number' => 'TYC-' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999),
                'warranty_period' => $productData['warranty'],
                'warranty_type' => 'replacement',
                'specifications' => $productData['specifications'],
                'featured_images' => $productData['featured_images'],
                'gallery_images' => $productData['gallery_images'],
                'weight' => $productData['weight'],
                'length' => $productData['dimensions']['length'],
                'width' => $productData['dimensions']['width'],
                'height' => $productData['dimensions']['height'],
                // 'meta_title' => $productData['meta_title_en'], // Base meta title
                // 'meta_description' => $productData['meta_description_en'], // Base meta description
                'meta_keywords' => $this->generateKeywords($productData['name_en']),
                'is_featured' => $productData['is_featured'],
                'is_bestsells' => $productData['is_bestsells'],
                'is_new' => $productData['is_new'],
                'status' => $productData['status'],
                'stock_status' => $productData['stock_status'],
                'average_rating' => rand(38, 50) / 10,
                'rating_count' => rand(10, 200),
                'total_sold' => rand(5, 150),
                'total_revenue' => $productData['price'] * rand(5, 150),
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'vendor_id' => $vendor->id,
            ]);
        }

        // Create some out of stock products (10 products)
        for ($i = 51; $i <= 60; $i++) {
            $category = $leafCategories->random();
            $productType = $this->determineProductType($category);
            $productData = $this->generateProductData($productType, $i);

            // Mark as out of stock
            $productData['quantity'] = 0;
            $productData['stock_status'] = 'out_of_stock';
            $productData['is_featured'] = false;
            $productData['is_bestsells'] = false;
            $productData['is_new'] = false;

            Product::create([
                // English fields
                'name_en' => $productData['name_en'] . ' - Out of Stock',
                'short_description_en' => $productData['short_description_en'] . ' (Currently out of stock)',
                'description_en' => $productData['description_en'] . ' This product is temporarily out of stock. New stock arriving soon.',
                'meta_title_en' => $productData['meta_title_en'] . ' - Out of Stock',
                'meta_description_en' => 'Currently out of stock. Will be available soon.',

                // Bangla fields
                'name_bn' => $productData['name_bn'] . ' - স্টক নেই',
                'short_description_bn' => $productData['short_description_bn'] . ' (বর্তমানে স্টক নেই)',
                'description_bn' => $productData['description_bn'] . ' এই পণ্যটি সাময়িকভাবে স্টক নেই। নতুন স্টক শীঘ্রই আসছে।',
                'meta_title_bn' => $productData['meta_title_bn'] . ' - স্টক নেই',
                'meta_description_bn' => 'বর্তমানে স্টক নেই। শীঘ্রই পাওয়া যাবে।',

                // Original fields
                // 'name' => $productData['name_en'] . ' - Out of Stock',
                'sku' => 'TYC-' . date('Ym') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'slug' => Str::slug($productData['name_en'] . ' ' . $i . ' out of stock'),
                // 'short_description' => $productData['short_description_en'] . ' (Currently out of stock)',
                // 'description' => $productData['description_en'] . ' This product is temporarily out of stock. New stock arriving soon.',
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'cost_price' => $productData['price'] * 0.65,
                'discount_percentage' => $productData['discount_percentage'],
                'quantity' => 0,
                'alert_quantity' => 5,
                'track_quantity' => true,
                'allow_backorder' => true,
                'model_number' => 'TYC-OOS-' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999),
                'warranty_period' => $productData['warranty'],
                'warranty_type' => 'replacement',
                'specifications' => $productData['specifications'],
                'featured_images' => $productData['featured_images'],
                'gallery_images' => $productData['gallery_images'],
                'weight' => $productData['weight'],
                'length' => $productData['dimensions']['length'],
                'width' => $productData['dimensions']['width'],
                'height' => $productData['dimensions']['height'],
                // 'meta_title' => $productData['meta_title_en'] . ' - Out of Stock',
                // 'meta_description' => 'Currently out of stock. Will be available soon.',
                'meta_keywords' => $this->generateKeywords($productData['name_en']) . ', out of stock',
                'is_featured' => false,
                'is_bestsells' => false,
                'is_new' => false,
                'status' => 'active',
                'stock_status' => 'out_of_stock',
                'average_rating' => rand(38, 50) / 10,
                'rating_count' => rand(10, 200),
                'total_sold' => rand(20, 100),
                'total_revenue' => $productData['price'] * rand(20, 100),
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'vendor_id' => $vendor->id,
            ]);
        }

        $this->command->info('Products seeded successfully!');
        $this->command->info('Total products created: ' . Product::count());
        $this->command->info('In-stock products: ' . Product::where('stock_status', 'in_stock')->count());
        $this->command->info('Out-of-stock products: ' . Product::where('stock_status', 'out_of_stock')->count());
        $this->command->info('Featured products: ' . Product::where('is_featured', true)->count());
        $this->command->info('Best sellers: ' . Product::where('is_bestsells', true)->count());
        $this->command->info('New products: ' . Product::where('is_new', true)->count());
    }

    /**
     * Determine product type based on category name
     */
    private function determineProductType(Category $category): string
    {
        $categoryName = strtolower($category->name);

        if (str_contains($categoryName, 'ac') || str_contains($categoryName, 'air conditioner')) {
            if (str_contains($categoryName, 'split')) return 'split-ac';
            if (str_contains($categoryName, 'window')) return 'window-ac';
            return 'split-ac';
        }

        if (str_contains($categoryName, 'fan')) {
            if (str_contains($categoryName, 'ceiling')) return 'ceiling-fan';
            if (str_contains($categoryName, 'table')) return 'table-fan';
            return 'ceiling-fan';
        }

        if (str_contains($categoryName, 'fridge') || str_contains($categoryName, 'refrigerator')) {
            if (str_contains($categoryName, 'single')) return 'single-door-fridges';
            if (str_contains($categoryName, 'double')) return 'double-door-fridges';
            return 'single-door-fridges';
        }

        if (str_contains($categoryName, 'tv') || str_contains($categoryName, 'television')) {
            if (str_contains($categoryName, 'smart')) return 'smart-tv';
            return 'led-tv';
        }

        if (str_contains($categoryName, 'mixer') || str_contains($categoryName, 'grinder')) {
            return 'mixer-grinder';
        }

        return 'electronics';
    }

    /**
     * Generate product data based on type
     */
    private function generateProductData(string $type, int $index): array
    {
        $dataTemplates = [
            'split-ac' => [
                'name_en_prefix' => 'TYCOON Split AC',
                'name_bn_prefix' => 'টাইকুন স্প্লিট এসি',
                'capacity' => ['1 Ton', '1.5 Ton', '2 Ton'][rand(0, 2)],
                'price_range' => [35000, 85000],
                'discount_range' => [5, 25],
                'warranty' => '5 Years Compressor, 1 Year General',
                'specifications' => ['Inverter Technology', '5 Star Rating', 'Anti-bacterial Filter', 'Wi-Fi Enabled'],
                'weight_range' => [30, 50],
                'dimensions' => ['length' => [80, 100], 'width' => [25, 35], 'height' => [25, 35]],
            ],
            'window-ac' => [
                'name_en_prefix' => 'TYCOON Window AC',
                'name_bn_prefix' => 'টাইকুন উইন্ডো এসি',
                'capacity' => ['1 Ton', '1.5 Ton', '2 Ton'][rand(0, 2)],
                'price_range' => [25000, 45000],
                'discount_range' => [5, 20],
                'warranty' => '3 Years Compressor, 1 Year General',
                'specifications' => ['Auto Restart', 'Sleep Mode', 'Dehumidifier', 'Energy Saving'],
                'weight_range' => [40, 60],
                'dimensions' => ['length' => [50, 70], 'width' => [40, 60], 'height' => [40, 60]],
            ],
            'ceiling-fan' => [
                'name_en_prefix' => 'TYCOON Ceiling Fan',
                'name_bn_prefix' => 'টাইকুন সিলিং ফ্যান',
                'size' => ['56"', '48"', '52"'][rand(0, 2)],
                'price_range' => [2500, 5000],
                'discount_range' => [0, 15],
                'warranty' => '2 Years',
                'specifications' => ['Energy Efficient', 'Remote Control', 'Reversible', 'LED Light'],
                'weight_range' => [5, 8],
                'dimensions' => ['length' => [120, 150], 'width' => [20, 30], 'height' => [20, 30]],
            ],
            'single-door-fridges' => [
                'name_en_prefix' => 'TYCOON Refrigerator',
                'name_bn_prefix' => 'টাইকুন রেফ্রিজারেটর',
                'capacity' => ['185L', '220L', '260L'][rand(0, 2)],
                'price_range' => [25000, 45000],
                'discount_range' => [8, 22],
                'warranty' => '1 Year Comprehensive',
                'specifications' => ['Frost Free', 'Digital Display', 'Energy Star', 'Multi-airflow'],
                'weight_range' => [45, 75],
                'dimensions' => ['length' => [55, 70], 'width' => [55, 70], 'height' => [140, 170]],
            ],
            'double-door-fridges' => [
                'name_en_prefix' => 'TYCOON Double Door Refrigerator',
                'name_bn_prefix' => 'টাইকুন ডাবল ডোর রেফ্রিজারেটর',
                'capacity' => ['250L', '300L', '350L'][rand(0, 2)],
                'price_range' => [40000, 80000],
                'discount_range' => [10, 25],
                'warranty' => '2 Years Comprehensive',
                'specifications' => ['Frost Free', 'Inverter Compressor', 'Smart Convertible', 'Water Dispenser'],
                'weight_range' => [60, 90],
                'dimensions' => ['length' => [65, 80], 'width' => [65, 80], 'height' => [160, 190]],
            ],
            'led-tv' => [
                'name_en_prefix' => 'TYCOON LED TV',
                'name_bn_prefix' => 'টাইকুন এলইডি টিভি',
                'size' => ['32"', '43"', '50"'][rand(0, 2)],
                'price_range' => [15000, 45000],
                'discount_range' => [5, 20],
                'warranty' => '1 Year',
                'specifications' => ['Full HD', 'Smart Features', 'Multiple Ports', 'Wall Mountable'],
                'weight_range' => [5, 15],
                'dimensions' => ['length' => [70, 110], 'width' => [5, 10], 'height' => [40, 70]],
            ],
            'smart-tv' => [
                'name_en_prefix' => 'TYCOON Smart TV',
                'name_bn_prefix' => 'টাইকুন স্মার্ট টিভি',
                'size' => ['43"', '55"', '65"'][rand(0, 2)],
                'price_range' => [35000, 85000],
                'discount_range' => [8, 25],
                'warranty' => '2 Years',
                'specifications' => ['4K UHD', 'Android TV', 'Voice Control', 'HDR Support'],
                'weight_range' => [10, 25],
                'dimensions' => ['length' => [95, 145], 'width' => [5, 10], 'height' => [55, 85]],
            ],
            'mixer-grinder' => [
                'name_en_prefix' => 'TYCOON Mixer Grinder',
                'name_bn_prefix' => 'টাইকুন মিক্সার গ্রাইন্ডার',
                'power' => ['500W', '750W', '1000W'][rand(0, 2)],
                'price_range' => [3000, 8000],
                'discount_range' => [5, 18],
                'warranty' => '2 Years',
                'specifications' => ['Stainless Steel Jars', 'Overload Protection', 'Multiple Speed', 'Copper Motor'],
                'weight_range' => [4, 7],
                'dimensions' => ['length' => [20, 30], 'width' => [20, 30], 'height' => [30, 40]],
            ],
        ];

        // Default template if type not found
        $template = $dataTemplates[$type] ?? [
            'name_en_prefix' => 'TYCOON Product',
            'name_bn_prefix' => 'টাইকুন পণ্য',
            'price_range' => [5000, 50000],
            'discount_range' => [0, 20],
            'warranty' => '1 Year',
            'specifications' => ['High Quality', 'Durable', 'Energy Efficient'],
            'weight_range' => [5, 20],
            'dimensions' => ['length' => [30, 50], 'width' => [30, 50], 'height' => [30, 50]],
        ];

        // Generate product name
        $nameEn = $template['name_en_prefix'];
        $nameBn = $template['name_bn_prefix'];

        if (isset($template['capacity'])) {
            $nameEn .= ' ' . $template['capacity'];
            $nameBn .= ' ' . $this->translateCapacity($template['capacity']);
        } elseif (isset($template['size'])) {
            $nameEn .= ' ' . $template['size'];
            $nameBn .= ' ' . $this->translateSize($template['size']);
        } elseif (isset($template['power'])) {
            $nameEn .= ' ' . $template['power'];
            $nameBn .= ' ' . $template['power'];
        }

        $nameEn .= ' ' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999);
        $nameBn .= ' ' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999);

        // Generate price and discount
        $price = rand($template['price_range'][0], $template['price_range'][1]);
        $comparePrice = $price * (1 + (rand(10, 25) / 100)); // 10-25% higher
        $discountPercentage = rand($template['discount_range'][0], $template['discount_range'][1]);

        // Get images for this product type
        $featuredImages = $this->getProductImages($type);

        // Random status flags
        $isFeatured = rand(0, 10) > 7; // 30% chance
        $isBestseller = rand(0, 10) > 8; // 20% chance
        $isNew = rand(0, 10) > 6; // 40% chance

        // Generate quantity
        $quantity = rand(5, 100);
        $stockStatus = $quantity > 0 ? 'in_stock' : 'out_of_stock';
        $status = $quantity > 0 ? 'active' : (rand(0, 1) ? 'active' : 'inactive');

        return [
            // English data
            'name_en' => $nameEn,
            'short_description_en' => $this->generateShortDescription($type, $template, 'en'),
            'description_en' => $this->generateDescription($type, $template, 'en'),
            'meta_title_en' => $nameEn . ' - Buy Online at Best Price',
            'meta_description_en' => $this->generateShortDescription($type, $template, 'en'),

            // Bangla data
            'name_bn' => $nameBn,
            'short_description_bn' => $this->generateShortDescription($type, $template, 'bn'),
            'description_bn' => $this->generateDescription($type, $template, 'bn'),
            'meta_title_bn' => $nameBn . ' - সেরা মূল্যে অনলাইনে কিনুন',
            'meta_description_bn' => $this->generateShortDescription($type, $template, 'bn'),

            // Common data
            'price' => $price,
            'compare_price' => $comparePrice,
            'discount_percentage' => $discountPercentage,
            'quantity' => $quantity,
            'warranty' => $template['warranty'],
            'specifications' => $template['specifications'],
            'featured_images' => $featuredImages,
            'gallery_images' => $featuredImages,
            'weight' => rand($template['weight_range'][0], $template['weight_range'][1]) / 10, // Convert to kg
            'dimensions' => [
                'length' => rand($template['dimensions']['length'][0], $template['dimensions']['length'][1]) / 10,
                'width' => rand($template['dimensions']['width'][0], $template['dimensions']['width'][1]) / 10,
                'height' => rand($template['dimensions']['height'][0], $template['dimensions']['height'][1]) / 10,
            ],
            'is_featured' => $isFeatured,
            'is_bestsells' => $isBestseller,
            'is_new' => $isNew,
            'status' => $status,
            'stock_status' => $stockStatus,
        ];
    }

    /**
     * Translate capacity to Bangla
     */
    private function translateCapacity(string $capacity): string
    {
        $translations = [
            '1 Ton' => '১ টন',
            '1.5 Ton' => '১.৫ টন',
            '2 Ton' => '২ টন',
            '185L' => '১৮৫ লিটার',
            '220L' => '২২০ লিটার',
            '260L' => '২৬০ লিটার',
            '250L' => '২৫০ লিটার',
            '300L' => '৩০০ লিটার',
            '350L' => '৩৫০ লিটার',
        ];

        return $translations[$capacity] ?? $capacity;
    }

    /**
     * Translate size to Bangla
     */
    private function translateSize(string $size): string
    {
        $translations = [
            '32"' => '৩২ ইঞ্চি',
            '43"' => '৪৩ ইঞ্চি',
            '50"' => '৫০ ইঞ্চি',
            '55"' => '৫৫ ইঞ্চি',
            '65"' => '৬৫ ইঞ্চি',
            '56"' => '৫৬ ইঞ্চি',
            '48"' => '৪৮ ইঞ্চি',
            '52"' => '৫২ ইঞ্চি',
        ];

        return $translations[$size] ?? $size;
    }

    /**
     * Get product images based on type
     */
    private function getProductImages(string $type): array
    {
        // Default images
        $defaultImages = ['products/default-01.jpg', 'products/default-02.jpg'];

        // Check if we have images for this type
        if (isset($this->productImages[$type])) {
            $imageFiles = $this->productImages[$type];
            return array_map(function ($file) {
                return 'products/' . $file;
            }, $imageFiles);
        }

        // Return default images
        return $defaultImages;
    }

    /**
     * Generate short description
     */
    private function generateShortDescription(string $type, array $template, string $language = 'en'): string
    {
        $descriptions = [
            'en' => [
                'split-ac' => 'Energy efficient split air conditioner with inverter technology and smart features.',
                'window-ac' => 'Compact window AC with auto restart, sleep mode, and energy saving function.',
                'ceiling-fan' => 'Premium ceiling fan with remote control, reversible function, and LED light.',
                'single-door-fridges' => 'Single door refrigerator with frost-free technology and digital display.',
                'double-door-fridges' => 'Double door refrigerator with inverter compressor and smart convertible features.',
                'led-tv' => 'Full HD LED television with smart features and multiple connectivity options.',
                'smart-tv' => '4K Smart TV with Android operating system and voice control support.',
                'mixer-grinder' => 'Powerful mixer grinder with stainless steel jars and multiple speed settings.',
            ],
            'bn' => [
                'split-ac' => 'ইনভার্টার প্রযুক্তি এবং স্মার্ট বৈশিষ্ট্য সহ শক্তি-দক্ষ স্প্লিট এয়ার কন্ডিশনার।',
                'window-ac' => 'অটো রিস্টার্ট, স্লিপ মোড এবং এনার্জি সেভিং ফাংশন সহ কমপ্যাক্ট উইন্ডো এসি।',
                'ceiling-fan' => 'রিমোট কন্ট্রোল, বিপরীতমুখী কার্যকারিতা এবং এলইডি লাইট সহ প্রিমিয়াম সিলিং ফ্যান।',
                'single-door-fridges' => 'ফ্রস্ট-ফ্রি প্রযুক্তি এবং ডিজিটাল ডিসপ্লে সহ সিঙ্গেল ডোর রেফ্রিজারেটর।',
                'double-door-fridges' => 'ইনভার্টার কম্প্রেসার এবং স্মার্ট কনভার্টিবল বৈশিষ্ট্য সহ ডাবল ডোর রেফ্রিজারেটর।',
                'led-tv' => 'স্মার্ট বৈশিষ্ট্য এবং একাধিক সংযোগ বিকল্প সহ ফুল এইচডি এলইডি টেলিভিশন।',
                'smart-tv' => 'অ্যান্ড্রয়েড অপারেটিং সিস্টেম এবং ভয়েস কন্ট্রোল সমর্থন সহ ৪কে স্মার্ট টিভি।',
                'mixer-grinder' => 'স্টেইনলেস স্টিল জার এবং একাধিক গতি সেটিংস সহ শক্তিশালী মিক্সার গ্রাইন্ডার।',
            ]
        ];

        return $descriptions[$language][$type] ??
            ($language === 'bn' ? 'সেরা গুণমান এবং প্রতিযোগিতামূলক মূল্যে উচ্চ মানের পণ্য।' :
                'High quality product with excellent features and durability.');
    }

    /**
     * Generate full description
     */
    private function generateDescription(string $type, array $template, string $language = 'en'): string
    {
        $shortDesc = $this->generateShortDescription($type, $template, $language);
        $features = implode(', ', $template['specifications']);

        if ($language === 'bn') {
            return $shortDesc . " এই পণ্যটিতে রয়েছে " . $features . ". এটি " . $template['warranty'] . " ওয়ারেন্টি সহ আসে। আধুনিক ডিজাইন এবং শক্তি দক্ষ অপারেশন সহ বাড়ি বা অফিস ব্যবহারের জন্য উপযুক্ত।";
        }

        return $shortDesc . " This product features " . $features . ". It comes with " . $template['warranty'] . " warranty. Perfect for home or office use with modern design and energy efficient operation.";
    }

    /**
     * Generate SEO keywords
     */
    private function generateKeywords(string $productName): string
    {
        $words = explode(' ', $productName);
        $mainWords = array_slice($words, 0, 4);
        return implode(', ', $mainWords) . ', buy online, best price, TYCOON, Bangladesh';
    }
}
