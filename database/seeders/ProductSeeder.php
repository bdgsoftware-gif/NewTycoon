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
        'portable-ac' => ['ac-05.jpg', 'ac-06.jpg'],
        'inverter-ac' => ['ac-07.jpg', 'ac-08.jpg'],

        // Fans
        'ceiling-fan' => ['fan-01.jpg', 'fan-02.jpg'],
        'tower-fan' => ['fan-03.jpg', 'fan-04.jpg'],
        'table-fan' => ['fan-05.jpg', 'fan-06.jpg'],
        'wall-fan' => ['fan-07.jpg', 'fan-08.jpg'],

        // Room Comforters
        'air-cooler' => ['cooler-01.jpg', 'cooler-02.jpg'],
        'heater' => ['heater-01.jpg', 'heater-02.jpg'],
        'humidifier' => ['humidifier-01.jpg', 'humidifier-02.jpg'],
        'air-purifier' => ['purifier-01.jpg', 'purifier-02.jpg'],

        // Cookware
        'cookware-sets' => ['cookware-01.jpg', 'cookware-02.jpg'],
        'fry-pans' => ['pan-01.jpg', 'pan-02.jpg'],
        'saucepans' => ['saucepan-01.jpg', 'saucepan-02.jpg'],

        // Gas Burners
        'gas-stoves' => ['stove-01.jpg', 'stove-02.jpg'],
        'induction-cooktops' => ['induction-01.jpg', 'induction-02.jpg'],

        // Pressure Cookers
        'pressure-cooker' => ['cooker-01.jpg', 'cooker-02.jpg'],

        // Rice Cookers
        'rice-cooker' => ['rice-cooker-01.jpg', 'rice-cooker-02.jpg'],

        // Electric Kettles
        'electric-kettle' => ['kettle-01.jpg', 'kettle-02.jpg'],

        // Mixer Grinders
        'mixer-grinder' => ['mixer-01.jpg', 'mixer-02.jpg'],

        // LED TVs
        'led-tv' => ['tv-01.jpg', 'tv-02.jpg'],
        'smart-tv' => ['tv-03.jpg', 'tv-04.jpg'],

        // Monitors
        'monitor' => ['monitor-01.jpg', 'monitor-02.jpg'],

        // Refrigerators
        'refrigerator' => ['fridge-01.jpg', 'fridge-02.jpg'],
        'single-door-fridges' => ['fridge-03.jpg', 'fridge-04.jpg'],
        'double-door-fridges' => ['fridge-05.jpg', 'fridge-06.jpg'],
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
                'slug' => 'tycoon',
                'description' => 'Premium home appliances and electronics brand',
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

            // Generate realistic SKU
            $sku = 'TYC-' . date('Ym') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT);

            // Create the product
            Product::create([
                'name' => $productData['name'],
                'sku' => $sku,
                'slug' => Str::slug($productData['name'] . ' ' . $i),
                'short_description' => $productData['short_description'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'cost_price' => $productData['price'] * 0.65, // 35% margin
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
                'meta_title' => $productData['name'] . ' - Buy Online',
                'meta_description' => $productData['short_description'],
                'meta_keywords' => $this->generateKeywords($productData['name']),
                'is_featured' => $productData['is_featured'],
                'is_bestseller' => $productData['is_bestseller'],
                'is_new' => $productData['is_new'],
                'status' => $productData['status'],
                'stock_status' => $productData['stock_status'],
                'average_rating' => rand(38, 50) / 10,
                'rating_count' => rand(10, 200),
                'total_sold' => rand(5, 150),
                'total_revenue' => $productData['price'] * rand(5, 150),
                'category_id' => $category->id,               
            ]);
        }

        // Create some out of stock products (10 products)
        for ($i = 51; $i <= 60; $i++) {
            $category = $leafCategories->random();
            $productType = $this->determineProductType($category);
            $productData = $this->generateProductData($productType, $i);

            Product::create([
                'name' => $productData['name'] . ' - Out of Stock',
                'sku' => 'TYC-' . date('Ym') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'slug' => Str::slug($productData['name'] . ' ' . $i . ' out of stock'),
                'short_description' => $productData['short_description'] . ' (Currently out of stock)',
                'description' => $productData['description'] . ' This product is temporarily out of stock. New stock arriving soon.',
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'cost_price' => $productData['price'] * 0.65,
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
                'meta_title' => $productData['name'] . ' - Out of Stock',
                'meta_description' => 'Currently out of stock. Will be available soon.',
                'meta_keywords' => $this->generateKeywords($productData['name']) . ', out of stock',
                'is_featured' => false,
                'is_bestseller' => false,
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
        $this->command->info('Best sellers: ' . Product::where('is_bestseller', true)->count());
        $this->command->info('New products: ' . Product::where('is_new', true)->count());
    }

    /**
     * Determine product type based on category name
     */
    private function determineProductType(Category $category): string
    {
        $categoryName = strtolower($category->name);
        $parentCategory = $category->parent;

        // Get parent category name if available
        $parentName = $parentCategory ? strtolower($parentCategory->name) : '';

        // Check specific category names
        if (str_contains($categoryName, 'ac') || str_contains($categoryName, 'air conditioner')) {
            if (str_contains($categoryName, 'split')) return 'split-ac';
            if (str_contains($categoryName, 'window')) return 'window-ac';
            if (str_contains($categoryName, 'portable')) return 'portable-ac';
            if (str_contains($categoryName, 'inverter')) return 'inverter-ac';
            return 'split-ac';
        }

        if (str_contains($categoryName, 'fan')) {
            if (str_contains($categoryName, 'ceiling')) return 'ceiling-fan';
            if (str_contains($categoryName, 'tower')) return 'tower-fan';
            if (str_contains($categoryName, 'table')) return 'table-fan';
            if (str_contains($categoryName, 'wall')) return 'wall-fan';
            return 'ceiling-fan';
        }

        if (
            str_contains($categoryName, 'cooler') || str_contains($categoryName, 'heater') ||
            str_contains($categoryName, 'humidifier') || str_contains($categoryName, 'purifier')
        ) {
            if (str_contains($categoryName, 'cooler')) return 'air-cooler';
            if (str_contains($categoryName, 'heater')) return 'heater';
            if (str_contains($categoryName, 'humidifier')) return 'humidifier';
            if (str_contains($categoryName, 'purifier')) return 'air-purifier';
            return 'air-cooler';
        }

        if (str_contains($categoryName, 'cookware') || str_contains($parentName, 'cookware')) {
            return 'cookware-sets';
        }

        if (
            str_contains($categoryName, 'gas') || str_contains($categoryName, 'stove') ||
            str_contains($categoryName, 'induction')
        ) {
            if (str_contains($categoryName, 'induction')) return 'induction-cooktops';
            return 'gas-stoves';
        }

        if (str_contains($categoryName, 'pressure cooker')) {
            return 'pressure-cooker';
        }

        if (str_contains($categoryName, 'rice cooker')) {
            return 'rice-cooker';
        }

        if (str_contains($categoryName, 'kettle')) {
            return 'electric-kettle';
        }

        if (str_contains($categoryName, 'mixer') || str_contains($categoryName, 'grinder')) {
            return 'mixer-grinder';
        }

        if (str_contains($categoryName, 'tv') || str_contains($categoryName, 'television')) {
            if (str_contains($categoryName, 'smart')) return 'smart-tv';
            return 'led-tv';
        }

        if (str_contains($categoryName, 'monitor')) {
            return 'monitor';
        }

        if (str_contains($categoryName, 'refrigerator') || str_contains($categoryName, 'fridge')) {
            if (str_contains($categoryName, 'single')) return 'single-door-fridges';
            if (str_contains($categoryName, 'double')) return 'double-door-fridges';
            return 'refrigerator';
        }

        // Default based on parent
        if ($parentCategory) {
            return $this->determineProductType($parentCategory);
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
                'name_prefix' => 'TYCOON Split AC',
                'capacity' => ['1 Ton', '1.5 Ton', '2 Ton'][rand(0, 2)],
                'price_range' => [35000, 85000],
                'warranty' => '5 Years Compressor, 1 Year General',
                'specifications' => ['Inverter Technology', '5 Star Rating', 'Anti-bacterial Filter', 'Wi-Fi Enabled'],
                'weight_range' => [30, 50],
                'dimensions' => ['length' => [80, 100], 'width' => [25, 35], 'height' => [25, 35]],
            ],
            'window-ac' => [
                'name_prefix' => 'TYCOON Window AC',
                'capacity' => ['1 Ton', '1.5 Ton', '2 Ton'][rand(0, 2)],
                'price_range' => [25000, 45000],
                'warranty' => '3 Years Compressor, 1 Year General',
                'specifications' => ['Auto Restart', 'Sleep Mode', 'Dehumidifier', 'Energy Saving'],
                'weight_range' => [40, 60],
                'dimensions' => ['length' => [50, 70], 'width' => [40, 60], 'height' => [40, 60]],
            ],
            'ceiling-fan' => [
                'name_prefix' => 'TYCOON Ceiling Fan',
                'size' => ['56"', '48"', '52"'][rand(0, 2)],
                'price_range' => [2500, 5000],
                'warranty' => '2 Years',
                'specifications' => ['Energy Efficient', 'Remote Control', 'Reversible', 'LED Light'],
                'weight_range' => [5, 8],
                'dimensions' => ['length' => [120, 150], 'width' => [20, 30], 'height' => [20, 30]],
            ],
            'refrigerator' => [
                'name_prefix' => 'TYCOON Refrigerator',
                'capacity' => ['185L', '220L', '260L'][rand(0, 2)],
                'price_range' => [25000, 45000],
                'warranty' => '1 Year Comprehensive',
                'specifications' => ['Frost Free', 'Digital Display', 'Energy Star', 'Multi-airflow'],
                'weight_range' => [45, 75],
                'dimensions' => ['length' => [55, 70], 'width' => [55, 70], 'height' => [140, 170]],
            ],
            'led-tv' => [
                'name_prefix' => 'TYCOON LED TV',
                'size' => ['32"', '43"', '50"'][rand(0, 2)],
                'price_range' => [15000, 45000],
                'warranty' => '1 Year',
                'specifications' => ['Full HD', 'Smart Features', 'Multiple Ports', 'Wall Mountable'],
                'weight_range' => [5, 15],
                'dimensions' => ['length' => [70, 110], 'width' => [5, 10], 'height' => [40, 70]],
            ],
            'smart-tv' => [
                'name_prefix' => 'TYCOON Smart TV',
                'size' => ['43"', '55"', '65"'][rand(0, 2)],
                'price_range' => [35000, 85000],
                'warranty' => '2 Years',
                'specifications' => ['4K UHD', 'Android TV', 'Voice Control', 'HDR Support'],
                'weight_range' => [10, 25],
                'dimensions' => ['length' => [95, 145], 'width' => [5, 10], 'height' => [55, 85]],
            ],
            'rice-cooker' => [
                'name_prefix' => 'TYCOON Rice Cooker',
                'capacity' => ['1.8L', '3L', '5L'][rand(0, 2)],
                'price_range' => [2000, 5000],
                'warranty' => '1 Year',
                'specifications' => ['Non-stick Pot', 'Keep Warm', 'Auto Shut-off', 'Steam Tray'],
                'weight_range' => [2, 4],
                'dimensions' => ['length' => [25, 35], 'width' => [25, 35], 'height' => [25, 35]],
            ],
            'mixer-grinder' => [
                'name_prefix' => 'TYCOON Mixer Grinder',
                'power' => ['500W', '750W', '1000W'][rand(0, 2)],
                'price_range' => [3000, 8000],
                'warranty' => '2 Years',
                'specifications' => ['Stainless Steel Jars', 'Overload Protection', 'Multiple Speed', 'Copper Motor'],
                'weight_range' => [4, 7],
                'dimensions' => ['length' => [20, 30], 'width' => [20, 30], 'height' => [30, 40]],
            ],
            'electric-kettle' => [
                'name_prefix' => 'TYCOON Electric Kettle',
                'capacity' => ['1.5L', '1.8L', '2L'][rand(0, 2)],
                'price_range' => [1500, 3000],
                'warranty' => '1 Year',
                'specifications' => ['Auto Shut-off', 'Boil-dry Protection', '360° Base', 'Water Level Indicator'],
                'weight_range' => [1, 2],
                'dimensions' => ['length' => [20, 25], 'width' => [20, 25], 'height' => [25, 30]],
            ],
        ];

        // Default template if type not found
        $template = $dataTemplates[$type] ?? $dataTemplates['electronics'] ?? [
            'name_prefix' => 'TYCOON Product',
            'price_range' => [5000, 50000],
            'warranty' => '1 Year',
            'specifications' => ['High Quality', 'Durable', 'Energy Efficient'],
            'weight_range' => [5, 20],
            'dimensions' => ['length' => [30, 50], 'width' => [30, 50], 'height' => [30, 50]],
        ];

        // Generate product name
        $name = $template['name_prefix'];
        if (isset($template['capacity'])) {
            $name .= ' ' . $template['capacity'];
        } elseif (isset($template['size'])) {
            $name .= ' ' . $template['size'];
        } elseif (isset($template['power'])) {
            $name .= ' ' . $template['power'];
        }
        $name .= ' ' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999);

        // Generate price
        $price = rand($template['price_range'][0], $template['price_range'][1]);
        $comparePrice = $price * (1 + (rand(10, 25) / 100)); // 10-25% higher

        // Get images for this product type
        $featuredImages = $this->getProductImages($type);

        // Random status flags (some products are featured, bestseller, or new)
        $isFeatured = rand(0, 10) > 7; // 30% chance
        $isBestseller = rand(0, 10) > 8; // 20% chance
        $isNew = rand(0, 10) > 6; // 40% chance

        // Generate quantity
        $quantity = rand(0, 100);
        $stockStatus = $quantity > 0 ? 'in_stock' : 'out_of_stock';

        // Status
        $status = $quantity > 0 ? 'active' : (rand(0, 1) ? 'active' : 'inactive');

        return [
            'name' => $name,
            'short_description' => $this->generateShortDescription($type, $template),
            'description' => $this->generateDescription($type, $template),
            'price' => $price,
            'compare_price' => $comparePrice,
            'quantity' => $quantity,
            'warranty' => $template['warranty'],
            'specifications' => $template['specifications'],
            'featured_images' => $featuredImages,
            'gallery_images' => $featuredImages, // Using same images for gallery
            'weight' => rand($template['weight_range'][0], $template['weight_range'][1]) / 10, // Convert to kg
            'dimensions' => [
                'length' => rand($template['dimensions']['length'][0], $template['dimensions']['length'][1]) / 10,
                'width' => rand($template['dimensions']['width'][0], $template['dimensions']['width'][1]) / 10,
                'height' => rand($template['dimensions']['height'][0], $template['dimensions']['height'][1]) / 10,
            ],
            'is_featured' => $isFeatured,
            'is_bestseller' => $isBestseller,
            'is_new' => $isNew,
            'status' => $status,
            'stock_status' => $stockStatus,
        ];
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
                return 'images/products/' . $file;
            }, $imageFiles);
        }

        // Return default images
        return $defaultImages;
    }

    /**
     * Generate short description
     */
    private function generateShortDescription(string $type, array $template): string
    {
        $descriptions = [
            'split-ac' => 'Energy efficient split air conditioner with inverter technology and smart features.',
            'window-ac' => 'Compact window AC with auto restart, sleep mode, and energy saving function.',
            'ceiling-fan' => 'Premium ceiling fan with remote control, reversible function, and LED light.',
            'refrigerator' => 'Frost-free refrigerator with digital display and energy efficient cooling.',
            'led-tv' => 'Full HD LED television with smart features and multiple connectivity options.',
            'smart-tv' => '4K Smart TV with Android operating system and voice control support.',
            'rice-cooker' => 'Automatic rice cooker with non-stick pot and keep warm function.',
            'mixer-grinder' => 'Powerful mixer grinder with stainless steel jars and multiple speed settings.',
            'electric-kettle' => 'Electric kettle with auto shut-off and boil-dry protection.',
        ];

        return $descriptions[$type] ?? 'High quality product with excellent features and durability.';
    }

    /**
     * Generate full description
     */
    private function generateDescription(string $type, array $template): string
    {
        $baseDescription = $this->generateShortDescription($type, $template);

        $features = implode(', ', $template['specifications']);

        return $baseDescription . " This product features " . $features . ". It comes with " . $template['warranty'] . " warranty. Perfect for home or office use with energy efficient operation and modern design.";
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
