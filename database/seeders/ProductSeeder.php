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
     * Real product data by category
     */
    private $productData = [
        // Air Conditioner - Split AC
        '1 Ton Split AC' => [
            ['name' => 'TYCOON Inverter Split AC 1 Ton 5 Star', 'price' => 45000, 'model' => 'TYC-SAC-1T-INV'],
            ['name' => 'TYCOON ECO Split Air Conditioner 1 Ton', 'price' => 38000, 'model' => 'TYC-SAC-1T-ECO'],
            ['name' => 'TYCOON Smart WiFi Split AC 1 Ton', 'price' => 52000, 'model' => 'TYC-SAC-1T-WIFI'],
        ],
        '1.5 Ton Split AC' => [
            ['name' => 'TYCOON Inverter Split AC 1.5 Ton 5 Star', 'price' => 58000, 'model' => 'TYC-SAC-15T-INV'],
            ['name' => 'TYCOON ECO Split Air Conditioner 1.5 Ton', 'price' => 48000, 'model' => 'TYC-SAC-15T-ECO'],
            ['name' => 'TYCOON Smart WiFi Split AC 1.5 Ton', 'price' => 65000, 'model' => 'TYC-SAC-15T-WIFI'],
            ['name' => 'TYCOON Dual Cool Split AC 1.5 Ton', 'price' => 55000, 'model' => 'TYC-SAC-15T-DC'],
        ],
        '2 Ton Split AC' => [
            ['name' => 'TYCOON Inverter Split AC 2 Ton 5 Star', 'price' => 72000, 'model' => 'TYC-SAC-2T-INV'],
            ['name' => 'TYCOON Commercial Split AC 2 Ton', 'price' => 68000, 'model' => 'TYC-SAC-2T-COM'],
            ['name' => 'TYCOON Smart WiFi Split AC 2 Ton', 'price' => 78000, 'model' => 'TYC-SAC-2T-WIFI'],
        ],
        'Inverter Split AC' => [
            ['name' => 'TYCOON Supreme Inverter AC 1.5 Ton', 'price' => 62000, 'model' => 'TYC-SAC-SUP-INV'],
            ['name' => 'TYCOON Ultra Inverter Split AC 1 Ton', 'price' => 48000, 'model' => 'TYC-SAC-ULT-INV'],
        ],

        // Air Conditioner - Window AC
        '1 Ton Window AC' => [
            ['name' => 'TYCOON Window AC 1 Ton Cooling Only', 'price' => 28000, 'model' => 'TYC-WAC-1T-CO'],
            ['name' => 'TYCOON Energy Saver Window AC 1 Ton', 'price' => 32000, 'model' => 'TYC-WAC-1T-ES'],
        ],
        '1.5 Ton Window AC' => [
            ['name' => 'TYCOON Window AC 1.5 Ton Cooling Only', 'price' => 35000, 'model' => 'TYC-WAC-15T-CO'],
            ['name' => 'TYCOON Premium Window AC 1.5 Ton', 'price' => 38000, 'model' => 'TYC-WAC-15T-PR'],
            ['name' => 'TYCOON Energy Saver Window AC 1.5 Ton', 'price' => 36000, 'model' => 'TYC-WAC-15T-ES'],
        ],
        '2 Ton Window AC' => [
            ['name' => 'TYCOON Window AC 2 Ton Heavy Duty', 'price' => 42000, 'model' => 'TYC-WAC-2T-HD'],
            ['name' => 'TYCOON Commercial Window AC 2 Ton', 'price' => 45000, 'model' => 'TYC-WAC-2T-COM'],
        ],

        // Fans - Ceiling Fan
        'Premium Ceiling Fans' => [
            ['name' => 'TYCOON Royal Ceiling Fan 56 inch', 'price' => 4500, 'model' => 'TYC-CF-56-ROY'],
            ['name' => 'TYCOON Premium Decorative Ceiling Fan 52 inch', 'price' => 3800, 'model' => 'TYC-CF-52-DEC'],
            ['name' => 'TYCOON Luxury Ceiling Fan 48 inch with Remote', 'price' => 5200, 'model' => 'TYC-CF-48-LUX'],
        ],
        'Energy Saving Fans' => [
            ['name' => 'TYCOON ECO Star Ceiling Fan 56 inch', 'price' => 3200, 'model' => 'TYC-CF-56-ECO'],
            ['name' => 'TYCOON Energy Efficient Ceiling Fan 52 inch', 'price' => 2800, 'model' => 'TYC-CF-52-EE'],
            ['name' => 'TYCOON Super Saver Ceiling Fan 48 inch', 'price' => 2500, 'model' => 'TYC-CF-48-SS'],
        ],
        'Remote Control Fans' => [
            ['name' => 'TYCOON Smart Remote Ceiling Fan 56 inch', 'price' => 4800, 'model' => 'TYC-CF-56-RC'],
            ['name' => 'TYCOON Premium Remote Control Fan 52 inch', 'price' => 4200, 'model' => 'TYC-CF-52-RC'],
        ],

        // Fans - Table Fan
        'USB Table Fans' => [
            ['name' => 'TYCOON Mini USB Table Fan Portable', 'price' => 850, 'model' => 'TYC-TF-USB-MINI'],
            ['name' => 'TYCOON USB Desk Fan with LED Light', 'price' => 1200, 'model' => 'TYC-TF-USB-LED'],
        ],
        'Rechargeable Fans' => [
            ['name' => 'TYCOON Rechargeable Table Fan 12 inch', 'price' => 1800, 'model' => 'TYC-TF-RC-12'],
            ['name' => 'TYCOON Emergency Rechargeable Fan 16 inch', 'price' => 2200, 'model' => 'TYC-TF-RC-16'],
            ['name' => 'TYCOON Solar Rechargeable Fan 14 inch', 'price' => 2500, 'model' => 'TYC-TF-RC-14S'],
        ],
        'High Speed Fans' => [
            ['name' => 'TYCOON Turbo Table Fan 16 inch', 'price' => 1500, 'model' => 'TYC-TF-HS-16'],
            ['name' => 'TYCOON High Speed Desk Fan 12 inch', 'price' => 1200, 'model' => 'TYC-TF-HS-12'],
        ],

        // Refrigerator - Single Door
        '165 Liter Refrigerator' => [
            ['name' => 'TYCOON Single Door Refrigerator 165L Red', 'price' => 28000, 'model' => 'TYC-REF-165-RD'],
            ['name' => 'TYCOON Compact Refrigerator 165L Silver', 'price' => 26500, 'model' => 'TYC-REF-165-SL'],
        ],
        '190 Liter Refrigerator' => [
            ['name' => 'TYCOON Single Door Refrigerator 190L Blue', 'price' => 32000, 'model' => 'TYC-REF-190-BL'],
            ['name' => 'TYCOON Direct Cool Refrigerator 190L White', 'price' => 30000, 'model' => 'TYC-REF-190-WH'],
            ['name' => 'TYCOON Energy Star Refrigerator 190L', 'price' => 33500, 'model' => 'TYC-REF-190-ES'],
        ],
        '230 Liter Refrigerator' => [
            ['name' => 'TYCOON Single Door Refrigerator 230L Silver', 'price' => 38000, 'model' => 'TYC-REF-230-SL'],
            ['name' => 'TYCOON Premium Refrigerator 230L Black', 'price' => 42000, 'model' => 'TYC-REF-230-BK'],
        ],

        // Refrigerator - Double Door
        '250 Liter Refrigerator' => [
            ['name' => 'TYCOON Double Door Refrigerator 250L Frost Free', 'price' => 48000, 'model' => 'TYC-DREF-250-FF'],
            ['name' => 'TYCOON Inverter Refrigerator 250L Silver', 'price' => 52000, 'model' => 'TYC-DREF-250-INV'],
        ],
        '300 Liter Refrigerator' => [
            ['name' => 'TYCOON Double Door Refrigerator 300L Frost Free', 'price' => 58000, 'model' => 'TYC-DREF-300-FF'],
            ['name' => 'TYCOON Smart Inverter Refrigerator 300L', 'price' => 65000, 'model' => 'TYC-DREF-300-SI'],
            ['name' => 'TYCOON Convertible Refrigerator 300L', 'price' => 62000, 'model' => 'TYC-DREF-300-CV'],
        ],
        '350 Liter Refrigerator' => [
            ['name' => 'TYCOON Double Door Refrigerator 350L Premium', 'price' => 72000, 'model' => 'TYC-DREF-350-PR'],
            ['name' => 'TYCOON Smart Refrigerator 350L with Dispenser', 'price' => 78000, 'model' => 'TYC-DREF-350-SD'],
        ],

        // LED TV - Smart TV
        '32 inch Smart TV' => [
            ['name' => 'TYCOON 32 inch HD Ready Smart LED TV', 'price' => 18500, 'model' => 'TYC-TV-32-HD'],
            ['name' => 'TYCOON 32 inch Full HD Smart TV with WiFi', 'price' => 22000, 'model' => 'TYC-TV-32-FHD'],
        ],
        '43 inch Smart TV' => [
            ['name' => 'TYCOON 43 inch Full HD Smart LED TV', 'price' => 32000, 'model' => 'TYC-TV-43-FHD'],
            ['name' => 'TYCOON 43 inch 4K UHD Smart TV', 'price' => 38000, 'model' => 'TYC-TV-43-4K'],
            ['name' => 'TYCOON 43 inch Smart TV with Voice Control', 'price' => 35000, 'model' => 'TYC-TV-43-VC'],
        ],
        '55 inch Smart TV' => [
            ['name' => 'TYCOON 55 inch 4K UHD Smart LED TV', 'price' => 55000, 'model' => 'TYC-TV-55-4K'],
            ['name' => 'TYCOON 55 inch Premium Smart TV with HDR', 'price' => 62000, 'model' => 'TYC-TV-55-HDR'],
            ['name' => 'TYCOON 55 inch QLED Smart TV', 'price' => 75000, 'model' => 'TYC-TV-55-QLED'],
        ],

        // LED TV - Android TV
        'Android 11 TV' => [
            ['name' => 'TYCOON 43 inch Android 11 Smart TV', 'price' => 36000, 'model' => 'TYC-ATV-43-A11'],
            ['name' => 'TYCOON 50 inch Android 11 4K TV', 'price' => 48000, 'model' => 'TYC-ATV-50-A11'],
        ],
        'Google TV' => [
            ['name' => 'TYCOON 43 inch Google TV with Chromecast', 'price' => 38000, 'model' => 'TYC-GTV-43-CC'],
            ['name' => 'TYCOON 55 inch Google TV 4K Ultra HD', 'price' => 58000, 'model' => 'TYC-GTV-55-4K'],
        ],
        'Built-in Netflix TV' => [
            ['name' => 'TYCOON 43 inch Smart TV with Netflix Button', 'price' => 34000, 'model' => 'TYC-NTV-43-NF'],
            ['name' => 'TYCOON 50 inch Netflix Certified TV', 'price' => 45000, 'model' => 'TYC-NTV-50-NC'],
        ],

        // Washing Machine - Front Load
        '6 KG Front Load' => [
            ['name' => 'TYCOON 6 KG Front Load Washing Machine', 'price' => 32000, 'model' => 'TYC-WM-FL-6K'],
            ['name' => 'TYCOON 6 KG Inverter Front Load Washer', 'price' => 38000, 'model' => 'TYC-WM-FL-6K-INV'],
        ],
        '7 KG Front Load' => [
            ['name' => 'TYCOON 7 KG Front Load Washing Machine', 'price' => 38000, 'model' => 'TYC-WM-FL-7K'],
            ['name' => 'TYCOON 7 KG Inverter Front Load with Steam', 'price' => 45000, 'model' => 'TYC-WM-FL-7K-ST'],
            ['name' => 'TYCOON 7 KG Smart Front Load Washer', 'price' => 42000, 'model' => 'TYC-WM-FL-7K-SM'],
        ],
        '8 KG Front Load' => [
            ['name' => 'TYCOON 8 KG Front Load Washing Machine', 'price' => 48000, 'model' => 'TYC-WM-FL-8K'],
            ['name' => 'TYCOON 8 KG Premium Inverter Front Load', 'price' => 55000, 'model' => 'TYC-WM-FL-8K-PR'],
        ],

        // Washing Machine - Top Load
        '6.5 KG Top Load' => [
            ['name' => 'TYCOON 6.5 KG Top Load Washing Machine', 'price' => 18000, 'model' => 'TYC-WM-TL-65K'],
            ['name' => 'TYCOON 6.5 KG Fully Automatic Top Load', 'price' => 22000, 'model' => 'TYC-WM-TL-65K-FA'],
        ],
        '7.5 KG Top Load' => [
            ['name' => 'TYCOON 7.5 KG Top Load Washing Machine', 'price' => 22000, 'model' => 'TYC-WM-TL-75K'],
            ['name' => 'TYCOON 7.5 KG Inverter Top Load Washer', 'price' => 28000, 'model' => 'TYC-WM-TL-75K-INV'],
        ],
        'Semi-Automatic Washer' => [
            ['name' => 'TYCOON 7 KG Semi-Automatic Washing Machine', 'price' => 12000, 'model' => 'TYC-WM-SA-7K'],
            ['name' => 'TYCOON 8.5 KG Semi-Automatic Twin Tub', 'price' => 15000, 'model' => 'TYC-WM-SA-85K'],
        ],

        // Microwave Oven - Solo
        '20 Liter Solo' => [
            ['name' => 'TYCOON 20L Solo Microwave Oven White', 'price' => 6500, 'model' => 'TYC-MWO-20-SO'],
            ['name' => 'TYCOON 20L Solo Microwave with Auto Cook', 'price' => 7200, 'model' => 'TYC-MWO-20-AC'],
        ],
        '25 Liter Solo' => [
            ['name' => 'TYCOON 25L Solo Microwave Oven Silver', 'price' => 7800, 'model' => 'TYC-MWO-25-SO'],
            ['name' => 'TYCOON 25L Digital Solo Microwave', 'price' => 8500, 'model' => 'TYC-MWO-25-DG'],
        ],
        '30 Liter Solo' => [
            ['name' => 'TYCOON 30L Solo Microwave Oven Black', 'price' => 9500, 'model' => 'TYC-MWO-30-SO'],
        ],

        // Microwave Oven - Convection
        '25 Liter Convection' => [
            ['name' => 'TYCOON 25L Convection Microwave Oven', 'price' => 12000, 'model' => 'TYC-MWO-25-CV'],
            ['name' => 'TYCOON 25L Grill & Convection Microwave', 'price' => 13500, 'model' => 'TYC-MWO-25-GC'],
        ],
        '30 Liter Convection' => [
            ['name' => 'TYCOON 30L Convection Microwave Oven', 'price' => 14500, 'model' => 'TYC-MWO-30-CV'],
            ['name' => 'TYCOON 30L Smart Convection Microwave', 'price' => 16800, 'model' => 'TYC-MWO-30-SM'],
        ],
        '32 Liter Convection' => [
            ['name' => 'TYCOON 32L Premium Convection Microwave', 'price' => 18000, 'model' => 'TYC-MWO-32-PR'],
        ],

        // Water Purifier - RO
        'Wall Mount RO' => [
            ['name' => 'TYCOON RO Water Purifier 7 Stage Wall Mount', 'price' => 12000, 'model' => 'TYC-WP-RO-7S-WM'],
            ['name' => 'TYCOON RO + UV Water Purifier Wall Mount', 'price' => 15000, 'model' => 'TYC-WP-ROUV-WM'],
        ],
        'Under Sink RO' => [
            ['name' => 'TYCOON Under Sink RO Water Purifier', 'price' => 14000, 'model' => 'TYC-WP-RO-US'],
            ['name' => 'TYCOON Premium Under Sink RO System', 'price' => 18000, 'model' => 'TYC-WP-RO-US-PR'],
        ],
        'Counter Top RO' => [
            ['name' => 'TYCOON Counter Top RO Water Purifier', 'price' => 13000, 'model' => 'TYC-WP-RO-CT'],
        ],

        // Water Purifier - UV
        'UV + UF Purifier' => [
            ['name' => 'TYCOON UV + UF Water Purifier 8L', 'price' => 8500, 'model' => 'TYC-WP-UVUF-8L'],
            ['name' => 'TYCOON UV + UF Electric Purifier 10L', 'price' => 9800, 'model' => 'TYC-WP-UVUF-10L'],
        ],
        'Gravity Purifier' => [
            ['name' => 'TYCOON Non-Electric Gravity Water Purifier 20L', 'price' => 3500, 'model' => 'TYC-WP-GR-20L'],
            ['name' => 'TYCOON Gravity Purifier with Storage 24L', 'price' => 4200, 'model' => 'TYC-WP-GR-24L'],
        ],
        'Electric UV Purifier' => [
            ['name' => 'TYCOON Electric UV Water Purifier 7L', 'price' => 7500, 'model' => 'TYC-WP-UV-7L'],
        ],

        // Mixer Grinder - Heavy Duty
        '1000W Mixer Grinder' => [
            ['name' => 'TYCOON 1000W Heavy Duty Mixer Grinder', 'price' => 6500, 'model' => 'TYC-MG-1000W-HD'],
            ['name' => 'TYCOON 1000W Professional Mixer with 4 Jars', 'price' => 7200, 'model' => 'TYC-MG-1000W-4J'],
        ],
        '750W Mixer Grinder' => [
            ['name' => 'TYCOON 750W Mixer Grinder with 3 Jars', 'price' => 4800, 'model' => 'TYC-MG-750W-3J'],
            ['name' => 'TYCOON 750W Heavy Duty Mixer Grinder', 'price' => 5200, 'model' => 'TYC-MG-750W-HD'],
        ],
        'Commercial Mixers' => [
            ['name' => 'TYCOON Commercial Mixer Grinder 1200W', 'price' => 8500, 'model' => 'TYC-MG-1200W-CM'],
        ],

        // Mixer Grinder - Compact
        '3 Jar Mixer' => [
            ['name' => 'TYCOON 500W Mixer Grinder with 3 Jars', 'price' => 3200, 'model' => 'TYC-MG-500W-3J'],
            ['name' => 'TYCOON Compact 3 Jar Mixer Grinder', 'price' => 3500, 'model' => 'TYC-MG-CP-3J'],
        ],
        '500W Mixer Grinder' => [
            ['name' => 'TYCOON 500W Mixer Grinder Silver', 'price' => 2800, 'model' => 'TYC-MG-500W-SL'],
        ],
        'Mini Mixer Grinder' => [
            ['name' => 'TYCOON Mini Mixer Grinder 300W', 'price' => 1800, 'model' => 'TYC-MG-300W-MINI'],
            ['name' => 'TYCOON Portable Mini Mixer 350W', 'price' => 2200, 'model' => 'TYC-MG-350W-PORT'],
        ],

        // Water Heater - Instant
        '3 Liter Instant Geyser' => [
            ['name' => 'TYCOON 3L Instant Water Heater White', 'price' => 4500, 'model' => 'TYC-WH-3L-IN'],
            ['name' => 'TYCOON 3L Instant Geyser with Safety', 'price' => 5200, 'model' => 'TYC-WH-3L-SF'],
        ],
        '6 Liter Instant Geyser' => [
            ['name' => 'TYCOON 6L Instant Water Heater', 'price' => 6500, 'model' => 'TYC-WH-6L-IN'],
        ],
        'Electric Instant Heater' => [
            ['name' => 'TYCOON Electric Instant Water Heater 4.5L', 'price' => 5800, 'model' => 'TYC-WH-45L-EL'],
        ],

        // Water Heater - Storage
        '10 Liter Storage Geyser' => [
            ['name' => 'TYCOON 10L Storage Water Heater', 'price' => 7500, 'model' => 'TYC-WH-10L-ST'],
            ['name' => 'TYCOON 10L Vertical Storage Geyser', 'price' => 8200, 'model' => 'TYC-WH-10L-VT'],
        ],
        '15 Liter Storage Geyser' => [
            ['name' => 'TYCOON 15L Storage Water Heater', 'price' => 9500, 'model' => 'TYC-WH-15L-ST'],
            ['name' => 'TYCOON 15L Premium Storage Geyser', 'price' => 10800, 'model' => 'TYC-WH-15L-PR'],
        ],
        '25 Liter Storage Geyser' => [
            ['name' => 'TYCOON 25L Storage Water Heater', 'price' => 12000, 'model' => 'TYC-WH-25L-ST'],
        ],

        // Iron - Steam Iron
        'Dry Iron' => [
            ['name' => 'TYCOON 1000W Dry Iron Black', 'price' => 850, 'model' => 'TYC-IR-1000W-DRY'],
            ['name' => 'TYCOON Automatic Dry Iron 750W', 'price' => 950, 'model' => 'TYC-IR-750W-AUTO'],
        ],
        'Steam Press Iron' => [
            ['name' => 'TYCOON 1200W Steam Press Iron', 'price' => 1500, 'model' => 'TYC-IR-1200W-ST'],
            ['name' => 'TYCOON Premium Steam Iron 1400W', 'price' => 1800, 'model' => 'TYC-IR-1400W-PR'],
        ],
        'Cordless Iron' => [
            ['name' => 'TYCOON Cordless Steam Iron 1000W', 'price' => 2200, 'model' => 'TYC-IR-1000W-CL'],
        ],

        // Iron - Garment Steamer
        'Handheld Steamer' => [
            ['name' => 'TYCOON Handheld Garment Steamer 800W', 'price' => 1800, 'model' => 'TYC-ST-800W-HH'],
            ['name' => 'TYCOON Portable Handheld Steamer', 'price' => 1500, 'model' => 'TYC-ST-PORT-HH'],
        ],
        'Standing Steamer' => [
            ['name' => 'TYCOON Standing Garment Steamer 1500W', 'price' => 4500, 'model' => 'TYC-ST-1500W-SD'],
        ],
        'Travel Steamer' => [
            ['name' => 'TYCOON Travel Mini Steamer 600W', 'price' => 1200, 'model' => 'TYC-ST-600W-TR'],
        ],

        // Vacuum Cleaner - Handheld
        'Cordless Handheld' => [
            ['name' => 'TYCOON Cordless Handheld Vacuum Cleaner', 'price' => 3500, 'model' => 'TYC-VC-CL-HH'],
            ['name' => 'TYCOON Rechargeable Handheld Vacuum', 'price' => 4200, 'model' => 'TYC-VC-RC-HH'],
        ],
        'Car Vacuum Cleaner' => [
            ['name' => 'TYCOON Car Vacuum Cleaner 12V', 'price' => 1800, 'model' => 'TYC-VC-12V-CAR'],
            ['name' => 'TYCOON Portable Car Vacuum 120W', 'price' => 2200, 'model' => 'TYC-VC-120W-CAR'],
        ],
        'Wet & Dry Vacuum' => [
            ['name' => 'TYCOON Wet & Dry Vacuum Cleaner 1200W', 'price' => 6500, 'model' => 'TYC-VC-1200W-WD'],
            ['name' => 'TYCOON Industrial Wet Dry Vacuum 1400W', 'price' => 8500, 'model' => 'TYC-VC-1400W-IND'],
        ],

        // Vacuum Cleaner - Robot
        'Smart Robot Vacuum' => [
            ['name' => 'TYCOON Smart Robot Vacuum Cleaner', 'price' => 15000, 'model' => 'TYC-VC-ROBOT-SM'],
            ['name' => 'TYCOON WiFi Robot Vacuum with App Control', 'price' => 18000, 'model' => 'TYC-VC-ROBOT-WIFI'],
        ],
        'Auto Charging Vacuum' => [
            ['name' => 'TYCOON Auto Charging Robot Vacuum', 'price' => 12000, 'model' => 'TYC-VC-ROBOT-AC'],
        ],
        'Mop & Vacuum Robot' => [
            ['name' => 'TYCOON 2-in-1 Mop & Vacuum Robot', 'price' => 16500, 'model' => 'TYC-VC-ROBOT-2IN1'],
        ],

        // Rice Cooker - Electric
        '1.8 Liter Rice Cooker' => [
            ['name' => 'TYCOON 1.8L Electric Rice Cooker', 'price' => 2200, 'model' => 'TYC-RC-18L-EL'],
            ['name' => 'TYCOON 1.8L Non-Stick Rice Cooker', 'price' => 2500, 'model' => 'TYC-RC-18L-NS'],
        ],
        '2.2 Liter Rice Cooker' => [
            ['name' => 'TYCOON 2.2L Electric Rice Cooker', 'price' => 2800, 'model' => 'TYC-RC-22L-EL'],
            ['name' => 'TYCOON 2.2L Deluxe Rice Cooker', 'price' => 3200, 'model' => 'TYC-RC-22L-DLX'],
        ],
        '2.8 Liter Rice Cooker' => [
            ['name' => 'TYCOON 2.8L Electric Rice Cooker', 'price' => 3500, 'model' => 'TYC-RC-28L-EL'],
        ],

        // Rice Cooker - Multi Cooker
        'Pressure Multi Cooker' => [
            ['name' => 'TYCOON 6L Pressure Multi Cooker', 'price' => 6500, 'model' => 'TYC-MC-6L-PR'],
            ['name' => 'TYCOON 8L Electric Pressure Cooker', 'price' => 7800, 'model' => 'TYC-MC-8L-EP'],
        ],
        'Slow Multi Cooker' => [
            ['name' => 'TYCOON 5L Slow Multi Cooker', 'price' => 4500, 'model' => 'TYC-MC-5L-SL'],
        ],
        '10-in-1 Multi Cooker' => [
            ['name' => 'TYCOON 10-in-1 Multi Cooker 6L', 'price' => 8500, 'model' => 'TYC-MC-6L-10IN1'],
        ],

        // Electric Kettle - Stainless Steel
        '1.5 Liter Kettle' => [
            ['name' => 'TYCOON 1.5L Stainless Steel Electric Kettle', 'price' => 1200, 'model' => 'TYC-EK-15L-SS'],
            ['name' => 'TYCOON 1.5L Cordless Electric Kettle', 'price' => 1400, 'model' => 'TYC-EK-15L-CL'],
        ],
        '1.8 Liter Kettle' => [
            ['name' => 'TYCOON 1.8L Electric Kettle Silver', 'price' => 1500, 'model' => 'TYC-EK-18L-SL'],
            ['name' => 'TYCOON 1.8L Premium Electric Kettle', 'price' => 1800, 'model' => 'TYC-EK-18L-PR'],
        ],
        '2 Liter Kettle' => [
            ['name' => 'TYCOON 2L Electric Kettle 1500W', 'price' => 1650, 'model' => 'TYC-EK-2L-1500W'],
        ],

        // Electric Kettle - Glass
        'LED Glass Kettle' => [
            ['name' => 'TYCOON 1.7L LED Glass Electric Kettle', 'price' => 1800, 'model' => 'TYC-EK-17L-LED'],
            ['name' => 'TYCOON 1.8L RGB LED Glass Kettle', 'price' => 2200, 'model' => 'TYC-EK-18L-RGB'],
        ],
        'Borosilicate Kettle' => [
            ['name' => 'TYCOON 1.7L Borosilicate Glass Kettle', 'price' => 2000, 'model' => 'TYC-EK-17L-BG'],
        ],
        'Temperature Control Kettle' => [
            ['name' => 'TYCOON 1.7L Temperature Control Kettle', 'price' => 2500, 'model' => 'TYC-EK-17L-TC'],
        ],
    ];

    /**
     * Warranty configuration by category
     */
    private $warrantyConfig = [
        'Air Conditioner' => ['duration' => 5, 'unit' => 'years', 'type' => 'replacement'],
        'Refrigerator' => ['duration' => 2, 'unit' => 'years', 'type' => 'replacement'],
        'LED TV' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Washing Machine' => ['duration' => 2, 'unit' => 'years', 'type' => 'replacement'],
        'Microwave Oven' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Water Purifier' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Mixer Grinder' => ['duration' => 2, 'unit' => 'years', 'type' => 'parts'],
        'Water Heater' => ['duration' => 2, 'unit' => 'years', 'type' => 'replacement'],
        'Iron' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Vacuum Cleaner' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Rice Cooker' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Electric Kettle' => ['duration' => 6, 'unit' => 'months', 'type' => 'service'],
        'Fan' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
    ];

    public function run(): void
    {
        // Get vendor (first admin user)
        $vendor = User::role('admin')->first() ?? User::first();

        if (!$vendor) {
            $this->command->error('No users found! Please run UserSeeder first.');
            return;
        }

        // Get or create brand
        $brand = Brand::firstOrCreate(
            ['slug' => 'tycoon'],
            [
                'name_en' => 'TYCOON',
                'name_bn' => 'টাইকুন',
                'description_en' => 'Premium home appliances and electronics brand',
                'description_bn' => 'প্রিমিয়াম হোম অ্যাপ্লায়েন্সেস এবং ইলেকট্রনিক্স ব্র্যান্ড',
                'is_active' => true,
            ]
        );

        // Get all leaf categories (depth 3)
        $leafCategories = Category::where('depth', 3)
            ->where('is_active', true)
            ->get();

        if ($leafCategories->isEmpty()) {
            $this->command->error('No leaf categories found! Please run CategorySeeder first.');
            return;
        }

        $productsCreated = 0;
        $productsSkipped = 0;

        foreach ($leafCategories as $category) {
            $categoryName = $category->name_en;

            // Check if we have product data for this category
            if (!isset($this->productData[$categoryName])) {
                $this->command->warn("⚠ No product data for category: {$categoryName}");
                $productsSkipped++;
                continue;
            }

            // Get warranty for this category's parent
            $parentCategory = $category->parent;
            $rootCategory = $parentCategory ? $parentCategory->parent : null;
            $rootName = $rootCategory ? $rootCategory->name_en : $parentCategory->name_en;

            $warranty = $this->warrantyConfig[$rootName] ?? ['duration' => 1, 'unit' => 'years', 'type' => 'service'];

            // Create products for this category
            foreach ($this->productData[$categoryName] as $productData) {
                $this->createProduct($productData, $category, $brand, $vendor, $warranty);
                $productsCreated++;
            }
        }

        $this->command->info('✅ Products seeded successfully!');
        $this->command->info("📦 Total products created: {$productsCreated}");
        $this->command->info("⏭ Categories skipped: {$productsSkipped}");
        $this->command->info('🏷 Featured products: ' . Product::where('is_featured', true)->count());
        $this->command->info('🔥 Best sellers: ' . Product::where('is_bestsells', true)->count());
        $this->command->info('🆕 New products: ' . Product::where('is_new', true)->count());
        $this->command->info('📈 Active products: ' . Product::where('status', 'active')->count());

        // Show sample products
        $sampleProducts = Product::inRandomOrder()->take(5)->get();
        $this->command->info("\n📋 Sample products created:");
        foreach ($sampleProducts as $product) {
            $this->command->info("  ✓ {$product->name_en}");
            $this->command->info("    Category: {$product->category->full_path}");
            $this->command->info("    Price: ৳{$product->price}");
            $this->command->info("    SKU: {$product->sku}");
        }
    }

    /**
     * Create a single product
     */
    private function createProduct($data, $category, $brand, $vendor, $warranty)
    {
        $price = $data['price'];
        $comparePrice = $price * 1.15; // 15% higher
        $discountPercentage = rand(0, 20);
        $quantity = rand(10, 100);

        // Determine flags randomly
        $isFeatured = rand(0, 10) > 7; // 30% chance
        $isBestseller = rand(0, 10) > 8; // 20% chance
        $isNew = rand(0, 10) > 6; // 40% chance

        // Bengali translation
        $nameBn = $this->translateToBangla($data['name']);

        Product::create([
            // English fields
            'name_en' => $data['name'],
            'short_description_en' => $this->generateShortDescription($data['name'], $category),
            'description_en' => $this->generateDescription($data['name'], $category),
            'meta_title_en' => $data['name'] . ' - Buy Online at Best Price',
            'meta_description_en' => 'Buy ' . $data['name'] . ' online at best price in Bangladesh. Original product with warranty.',

            // Bangla fields
            'name_bn' => $nameBn,
            'short_description_bn' => $this->generateShortDescriptionBn($nameBn, $category),
            'description_bn' => $this->generateDescriptionBn($nameBn, $category),
            'meta_title_bn' => $nameBn . ' - সেরা মূল্যে অনলাইনে কিনুন',
            'meta_description_bn' => 'বাংলাদেশে সেরা মূল্যে ' . $nameBn . ' অনলাইনে কিনুন। ওয়ারেন্টি সহ আসল পণ্য।',

            // Pricing
            'price' => $price,
            'compare_price' => $comparePrice,
            'cost_price' => $price * 0.7, // 30% margin
            'discount_percentage' => $discountPercentage,

            // Inventory
            'quantity' => $quantity,
            'alert_quantity' => 5,
            'track_quantity' => true,
            'allow_backorder' => false,
            'stock_status' => $quantity > 0 ? 'in_stock' : 'out_of_stock',

            // Product Info
            'model_number' => $data['model'],
            'warranty_duration' => $warranty['duration'],
            'warranty_unit' => $warranty['unit'],
            'warranty_type' => $warranty['type'],
            'specifications' => $this->getSpecifications($category),

            // Media (placeholder images)
            'featured_images' => ['products/default-01.jpg', 'products/default-02.jpg'],
            'gallery_images' => ['products/default-01.jpg', 'products/default-02.jpg'],

            // Shipping
            'weight' => rand(5, 50) / 10,
            'length' => rand(30, 100) / 10,
            'width' => rand(25, 80) / 10,
            'height' => rand(20, 70) / 10,

            // SEO
            'meta_keywords' => $this->generateKeywords($data['name']),

            // Status flags
            'is_featured' => $isFeatured,
            'is_bestsells' => $isBestseller,
            'is_new' => $isNew,
            'status' => 'active',

            // Ratings
            'average_rating' => rand(35, 50) / 10,
            'rating_count' => rand(10, 150),

            // Sales
            'total_sold' => rand(5, 200),
            'total_revenue' => $price * rand(5, 200),

            // Relationships
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'vendor_id' => $vendor->id,
        ]);
    }

    /**
     * Translate product name to Bangla
     */
    private function translateToBangla($name)
    {
        $translations = [
            'TYCOON' => 'টাইকুন',
            'Inverter' => 'ইনভার্টার',
            'Split AC' => 'স্প্লিট এসি',
            'Window AC' => 'উইন্ডো এসি',
            'Refrigerator' => 'রেফ্রিজারেটর',
            'Washing Machine' => 'ওয়াশিং মেশিন',
            'Microwave' => 'মাইক্রোওয়েভ',
            'Water Purifier' => 'ওয়াটার পিউরিফায়ার',
            'Mixer Grinder' => 'মিক্সার গ্রাইন্ডার',
            'Smart TV' => 'স্মার্ট টিভি',
            'LED TV' => 'এলইডি টিভি',
            'Ceiling Fan' => 'সিলিং ফ্যান',
            'Table Fan' => 'টেবিল ফ্যান',
            'Water Heater' => 'ওয়াটার হিটার',
            'Vacuum Cleaner' => 'ভ্যাকুয়াম ক্লিনার',
            'Rice Cooker' => 'রাইস কুকার',
            'Electric Kettle' => 'ইলেকট্রিক কেটলি',
            'Iron' => 'ইস্ত্রি',
            'Ton' => 'টন',
            'Liter' => 'লিটার',
            'KG' => 'কেজি',
            'inch' => 'ইঞ্চি',
        ];

        $translated = $name;
        foreach ($translations as $en => $bn) {
            $translated = str_replace($en, $bn, $translated);
        }

        return $translated;
    }

    /**
     * Generate short description
     */
    private function generateShortDescription($name, $category)
    {
        $parent = $category->parent;
        $root = $parent ? $parent->parent : null;

        return "Premium quality {$name} with excellent features and durability. Best price guaranteed with official warranty.";
    }

    /**
     * Generate full description
     */
    private function generateDescription($name, $category)
    {
        $short = $this->generateShortDescription($name, $category);

        return "{$short} This product comes with manufacturer warranty and genuine quality assurance. Perfect for home and office use with modern design and energy efficient operation. Get the best deals on {$name} with fast delivery across Bangladesh.";
    }

    /**
     * Generate Bangla short description
     */
    private function generateShortDescriptionBn($name, $category)
    {
        return "চমৎকার বৈশিষ্ট্য এবং স্থায়িত্ব সহ প্রিমিয়াম মানের {$name}। অফিসিয়াল ওয়ারেন্টি সহ সেরা মূল্যের নিশ্চয়তা।";
    }

    /**
     * Generate Bangla full description
     */
    private function generateDescriptionBn($name, $category)
    {
        $short = $this->generateShortDescriptionBn($name, $category);

        return "{$short} এই পণ্যটি প্রস্তুতকারকের ওয়ারেন্টি এবং আসল মানের নিশ্চয়তা সহ আসে। আধুনিক ডিজাইন এবং শক্তি দক্ষ অপারেশন সহ বাড়ি এবং অফিস ব্যবহারের জন্য উপযুক্ত। বাংলাদেশ জুড়ে দ্রুত ডেলিভারি সহ {$name} এর সেরা ডিল পান।";
    }

    /**
     * Get specifications based on category
     */
    private function getSpecifications($category)
    {
        $parent = $category->parent;
        $root = $parent ? $parent->parent : null;
        $rootName = $root ? $root->name_en : ($parent ? $parent->name_en : $category->name_en);

        $specs = [
            'Air Conditioner' => ['Energy Efficient', 'Auto Restart', 'Anti-bacterial Filter', 'Turbo Cooling'],
            'Refrigerator' => ['Frost Free', 'Energy Star', 'Digital Display', 'Vegetable Crisper'],
            'LED TV' => ['Full HD', 'Smart Features', 'USB Port', 'HDMI Input'],
            'Washing Machine' => ['Multiple Wash Programs', 'Energy Efficient', 'Child Lock', 'Overflow Protection'],
            'Microwave Oven' => ['Auto Cook Menu', 'Child Safety Lock', 'Digital Display', 'Express Cooking'],
            'Water Purifier' => ['Multi-stage Filtration', 'TDS Controller', 'UV Protection', 'Storage Tank'],
            'Mixer Grinder' => ['Stainless Steel Jars', 'Overload Protection', 'Multiple Speed', 'Copper Motor'],
            'Water Heater' => ['Safety Valve', 'Temperature Control', 'Energy Efficient', 'Corrosion Resistant'],
            'Iron' => ['Non-stick Sole Plate', 'Auto Shut-off', 'Temperature Control', 'Steam Function'],
            'Vacuum Cleaner' => ['HEPA Filter', 'Multiple Attachments', 'Cord Rewind', 'Dust Indicator'],
            'Rice Cooker' => ['Keep Warm Function', 'Auto Shut-off', 'Non-stick Pot', 'Steam Basket'],
            'Electric Kettle' => ['Auto Shut-off', 'Boil Dry Protection', 'Cordless', '360° Base'],
            'Fan' => ['Energy Saving', 'High Air Delivery', 'Silent Operation', 'Rust Proof'],
        ];

        return $specs[$rootName] ?? ['High Quality', 'Durable', 'Warranty Included'];
    }

    /**
     * Generate SEO keywords
     */
    private function generateKeywords($productName)
    {
        $words = explode(' ', $productName);
        $mainWords = array_slice($words, 0, 5);
        return implode(', ', $mainWords) . ', buy online, Bangladesh, TYCOON, best price';
    }
}
