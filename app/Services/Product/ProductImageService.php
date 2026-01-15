<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    /**
     * Process images for product
     */
    public function processImages(array $data, ?Product $product = null): array
    {
        if (isset($data['featured_images'])) {
            $data['featured_images'] = $this->processImageArray($data['featured_images'], 2);
        }

        if (isset($data['gallery_images'])) {
            $data['gallery_images'] = $this->processImageArray($data['gallery_images'], 5);
        }

        return $data;
    }

    /**
     * Process image array for storage
     */
    protected function processImageArray($value, int $limit): array
    {
        if (empty($value)) {
            return [];
        }

        if (is_string($value)) {
            $value = json_decode($value, true) ?? [$value];
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        // Filter out empty values
        $value = array_filter($value, function ($item) {
            return !empty($item) && is_string($item);
        });

        // Limit to specified number of images
        return array_slice(array_values($value), 0, $limit);
    }

    /**
     * Get featured images URLs
     */
    public function getFeaturedImagesUrls(Product $product): array
    {
        if (!$product->featured_images || empty($product->featured_images)) {
            return [asset('images/products/placeholder.jpg')];
        }

        $urls = [];
        foreach ($product->featured_images as $image) {
            $urls[] = $this->getImageUrl($image);
        }

        // Ensure at least 1 image
        if (empty($urls)) {
            $urls = [asset('images/products/placeholder.jpg')];
        }

        // Ensure exactly 2 images (duplicate if only 1)
        while (count($urls) < 2) {
            $urls[] = $urls[0];
        }

        return array_slice($urls, 0, 2);
    }

    /**
     * Get gallery images URLs
     */
    public function getGalleryImagesUrls(Product $product): array
    {
        if (!$product->gallery_images || empty($product->gallery_images)) {
            return [];
        }

        $urls = [];
        foreach ($product->gallery_images as $image) {
            $urls[] = $this->getImageUrl($image);
        }

        return array_slice($urls, 0, 5);
    }

    /**
     * Get image URL
     */
    protected function getImageUrl(string $image): string
    {
        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }

        return Storage::url($image);
    }

    /**
     * Delete product images
     */
    public function deleteProductImages(Product $product): void
    {
        $images = array_merge(
            $product->featured_images ?? [],
            $product->gallery_images ?? []
        );

        foreach ($images as $image) {
            if (!Str::startsWith($image, ['http://', 'https://'])) {
                Storage::delete($image);
            }
        }
    }

    /**
     * Upload product image
     */
    public function uploadImage($file, string $type = 'gallery'): string
    {
        $path = $file->store("products/{$type}", 'public');

        // Generate thumbnail for featured images
        if ($type === 'featured') {
            $this->generateThumbnail($path);
        }

        return $path;
    }

    /**
     * Generate thumbnail
     */
    protected function generateThumbnail(string $path): void
    {
        // You can use Intervention Image here if needed
        // This is a placeholder for thumbnail generation logic
    }
}
