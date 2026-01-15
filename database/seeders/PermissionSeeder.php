<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'view_users', 'display_name' => 'View Users'],
            ['name' => 'create_users', 'display_name' => 'Create Users'],
            ['name' => 'edit_users', 'display_name' => 'Edit Users'],
            ['name' => 'delete_users', 'display_name' => 'Delete Users'],
            ['name' => 'manage_users', 'display_name' => 'Manage Users'],

            // Product Management
            ['name' => 'view_products', 'display_name' => 'View Products'],
            ['name' => 'create_products', 'display_name' => 'Create Products'],
            ['name' => 'edit_products', 'display_name' => 'Edit Products'],
            ['name' => 'delete_products', 'display_name' => 'Delete Products'],
            ['name' => 'manage_products', 'display_name' => 'Manage Products'],

            // Category Management
            ['name' => 'view_categories', 'display_name' => 'View Categories'],
            ['name' => 'create_categories', 'display_name' => 'Create Categories'],
            ['name' => 'edit_categories', 'display_name' => 'Edit Categories'],
            ['name' => 'delete_categories', 'display_name' => 'Delete Categories'],

            // Brand Management
            ['name' => 'view_brands', 'display_name' => 'View Brands'],
            ['name' => 'create_brands', 'display_name' => 'Create Brands'],
            ['name' => 'edit_brands', 'display_name' => 'Edit Brands'],
            ['name' => 'delete_brands', 'display_name' => 'Delete Brands'],

            // Order Management
            ['name' => 'view_orders', 'display_name' => 'View Orders'],
            ['name' => 'create_orders', 'display_name' => 'Create Orders'],
            ['name' => 'edit_orders', 'display_name' => 'Edit Orders'],
            ['name' => 'delete_orders', 'display_name' => 'Delete Orders'],
            ['name' => 'update_orders', 'display_name' => 'Update Orders'],

            // Content Management
            ['name' => 'manage_content', 'display_name' => 'Manage Content'],
            ['name' => 'manage_pages', 'display_name' => 'Manage Pages'],
            ['name' => 'manage_blog', 'display_name' => 'Manage Blog'],
            ['name' => 'manage_faqs', 'display_name' => 'Manage FAQs'],

            // Settings
            ['name' => 'manage_settings', 'display_name' => 'Manage Settings'],
            ['name' => 'manage_roles', 'display_name' => 'Manage Roles'],
            ['name' => 'manage_permissions', 'display_name' => 'Manage Permissions'],

            // Analytics
            ['name' => 'view_reports', 'display_name' => 'View Reports'],
            ['name' => 'view_analytics', 'display_name' => 'View Analytics'],
            ['name' => 'export_data', 'display_name' => 'Export Data'],

            // Customer Permissions
            ['name' => 'view_own_orders', 'display_name' => 'View Own Orders'],
            ['name' => 'place_order', 'display_name' => 'Place Order'],
            ['name' => 'manage_wishlist', 'display_name' => 'Manage Wishlist'],
            ['name' => 'write_reviews', 'display_name' => 'Write Reviews'],

            // Media Management
            ['name' => 'upload_media', 'display_name' => 'Upload Media'],
            ['name' => 'manage_media', 'display_name' => 'Manage Media'],

            // Promotional Tools
            ['name' => 'manage_coupons', 'display_name' => 'Manage Coupons'],
            ['name' => 'manage_discounts', 'display_name' => 'Manage Discounts'],

            // Shipping & Tax
            ['name' => 'manage_shipping', 'display_name' => 'Manage Shipping'],
            ['name' => 'manage_tax', 'display_name' => 'Manage Tax'],

            ['name' => 'no_permissions', 'display_name' => 'No Permission'],

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description'] ?? null,
                ]
            );
        }
    }
}
