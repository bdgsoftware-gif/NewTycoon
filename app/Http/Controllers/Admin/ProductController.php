<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category']);

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id != 'all') {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock status
        if ($request->has('stock_status') && $request->stock_status != 'all') {
            $query->where('stock_status', $request->stock_status);
        }

        $products = $query->latest()->paginate(20);
        $categories = Category::where('is_active', true)->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.products.create', [
            'categories' => $categories,
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();

        try {
            $featuredImages = [];

            if ($request->hasFile('featured_images')) {
                foreach ($request->file('featured_images') as $image) {
                    $featuredImages[] = $image->store('products', 'public');
                }

                // Ensure exactly 2 images
                if (count($featuredImages) === 1) {
                    $featuredImages[] = $featuredImages[0];
                }
            } else {
                $featuredImages = ['products/default.jpg'];
            }

            $galleryImages = [];

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $galleryImages[] = $image->store('products/gallery', 'public');
                }

                $galleryImages = array_slice($galleryImages, 0, 5);
            }

            $vendorId = Auth::id() ?? 1;

            $product = Product::create([
                'name' => $request->validated('name'),
                'short_description' => $request->validated('short_description'),
                'description' => $request->validated('description'),

                'price' => $request->validated('price'),
                'compare_price' => $request->validated('compare_price'),
                'cost_price' => $request->validated('cost_price'),

                'quantity' => $request->validated('quantity'),
                'alert_quantity' => $request->validated('alert_quantity') ?? 5,
                'track_quantity' => $request->validated('track_quantity') ?? true,
                'allow_backorder' => $request->validated('allow_backorder') ?? false,

                'model_number' => $request->validated('model_number'),
                'warranty_period' => $request->validated('warranty_period'),
                'warranty_type' => $request->validated('warranty_type'),

                'specifications' => $request->validated('specifications'),

                'featured_images' => $featuredImages,
                'gallery_images' => $galleryImages,

                'weight' => $request->validated('weight'),
                'length' => $request->validated('length'),
                'width' => $request->validated('width'),
                'height' => $request->validated('height'),

                'meta_title' => $request->validated('meta_title'),
                'meta_description' => $request->validated('meta_description'),
                'meta_keywords' => $request->validated('meta_keywords'),

                'is_featured' => $request->validated('is_featured') ?? false,
                'is_bestsells' => $request->validated('is_bestsells') ?? false,
                'is_new' => $request->validated('is_new') ?? true,

                'status' => $request->validated('status'),
                'stock_status' => $request->validated('stock_status'),

                'category_id' => $request->validated('category_id'),
                'vendor_id' => $vendorId,

                'discount_percentage' => $request->validated('discount_percentage') ?? 0,

            ]);

            DB::commit();

            flash('Product created successfully!', 'success', 3000);
            return redirect()->route('admin.products.index');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (!empty($featuredImages)) {
                foreach ($featuredImages as $img) {
                    Storage::disk('public')->delete($img);
                }
            }

            if (!empty($galleryImages)) {
                foreach ($galleryImages as $img) {
                    Storage::disk('public')->delete($img);
                }
            }

            flash('Failed to create product', 'error', 3000, $e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            // Handle featured images
            $featuredImages = $request->existing_featured_images ?? [];

            if ($request->hasFile('featured_images')) {
                // Delete old featured images that are not in existing list
                $oldFeaturedImages = $product->featured_images ?? [];
                foreach ($oldFeaturedImages as $oldImage) {
                    if (!in_array($oldImage, $featuredImages) && $oldImage !== 'products/featured/default.jpg') {
                        Storage::disk('public')->delete($oldImage);
                    }
                }

                // Upload new featured images
                foreach ($request->file('featured_images') as $image) {
                    $path = $image->store('products/featured', 'public');
                    $featuredImages[] = $path;
                }

                // Ensure exactly 2 images (duplicate if only 1)
                if (count($featuredImages) === 1) {
                    $featuredImages[] = $featuredImages[0];
                }

                // Limit to 2 images
                $featuredImages = array_slice($featuredImages, 0, 2);
            }

            // If no featured images remain, use default
            if (empty($featuredImages)) {
                $featuredImages = ['products/featured/default.jpg'];
            }

            // Handle gallery images
            $galleryImages = $request->existing_gallery_images ?? [];

            if ($request->hasFile('gallery_images')) {
                // Delete old gallery images that are not in existing list
                $oldGalleryImages = $product->gallery_images ?? [];
                foreach ($oldGalleryImages as $oldImage) {
                    if (!in_array($oldImage, $galleryImages)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }

                // Upload new gallery images
                foreach ($request->file('gallery_images') as $image) {
                    $path = $image->store('products/gallery', 'public');
                    $galleryImages[] = $path;
                }

                // Limit to 5 images
                $galleryImages = array_slice($galleryImages, 0, 5);
            }

            // Update the product with validated data
            $product->update([
                'name' => $request->validated('name'),
                'sku' => $request->validated('sku'),
                'slug' => $request->validated('slug'),
                'short_description' => $request->validated('short_description'),
                'description' => $request->validated('description'),
                'price' => $request->validated('price'),
                'compare_price' => $request->validated('compare_price'),
                'cost_price' => $request->validated('cost_price'),
                'quantity' => $request->validated('quantity'),
                'alert_quantity' => $request->validated('alert_quantity') ?? 5,
                'track_quantity' => $request->validated('track_quantity') ?? true,
                'allow_backorder' => $request->validated('allow_backorder') ?? false,
                'model_number' => $request->validated('model_number'),
                'warranty_period' => $request->validated('warranty_period'),
                'warranty_type' => $request->validated('warranty_type'),
                'specifications' => $request->validated('specifications'),
                'featured_images' => $featuredImages,
                'gallery_images' => $galleryImages,
                'weight' => $request->validated('weight'),
                'length' => $request->validated('length'),
                'width' => $request->validated('width'),
                'height' => $request->validated('height'),
                'meta_title' => $request->validated('meta_title'),
                'meta_description' => $request->validated('meta_description'),
                'meta_keywords' => $request->validated('meta_keywords'),
                'is_featured' => $request->validated('is_featured') ?? false,
                'is_bestsells' => $request->validated('is_bestsells') ?? false,
                'is_new' => $request->validated('is_new') ?? true,
                'status' => $request->validated('status'),
                'stock_status' => $request->validated('stock_status'),
                'category_id' => $request->validated('category_id'),
                'discount_percentage' => $request->validated('discount_percentage') ?? 0,
            ]);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update product. Error: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Delete featured images
            if ($product->featured_images) {
                foreach ($product->featured_images as $image) {
                    if ($image !== 'products/featured/default.jpg') {
                        Storage::disk('public')->delete($image);
                    }
                }
            }

            // Delete gallery images
            if ($product->gallery_images) {
                foreach ($product->gallery_images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete product. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove multiple products.
     */
    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        try {
            $products = Product::whereIn('id', $request->ids)->get();

            foreach ($products as $product) {
                // Delete featured images
                if ($product->featured_images) {
                    foreach ($product->featured_images as $image) {
                        if ($image !== 'products/featured/default.jpg') {
                            Storage::disk('public')->delete($image);
                        }
                    }
                }

                // Delete gallery images
                if ($product->gallery_images) {
                    foreach ($product->gallery_images as $image) {
                        Storage::disk('public')->delete($image);
                    }
                }

                $product->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Selected products deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete products. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update product status.
     */
    public function updateStatus(Request $request, Product $product)
    {
        $request->validate([
            'status' => 'required|in:draft,active,inactive,archived',
        ]);

        try {
            $product->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Product status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update stock status.
     */
    public function updateStockStatus(Request $request, Product $product)
    {
        $request->validate([
            'stock_status' => 'required|in:in_stock,out_of_stock,backorder',
        ]);

        try {
            $product->update(['stock_status' => $request->stock_status]);

            return response()->json([
                'success' => true,
                'message' => 'Stock status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stock status. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update featured status.
     */
    public function updateFeaturedStatus(Request $request, Product $product)
    {
        try {
            $product->update(['is_featured' => !$product->is_featured]);

            return response()->json([
                'success' => true,
                'message' => 'Featured status updated successfully!',
                'is_featured' => $product->is_featured
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,archive',
            'selected_ids' => 'required|array'
        ]);

        switch ($request->action) {
            case 'delete':
                Product::whereIn('id', $request->selected_ids)->delete();
                $message = 'Selected products deleted successfully.';
                break;

            case 'activate':
                Product::whereIn('id', $request->selected_ids)->update(['status' => 'active']);
                $message = 'Selected products activated successfully.';
                break;

            case 'deactivate':
                Product::whereIn('id', $request->selected_ids)->update(['status' => 'inactive']);
                $message = 'Selected products deactivated successfully.';
                break;

            case 'archive':
                Product::whereIn('id', $request->selected_ids)->update(['status' => 'archived']);
                $message = 'Selected products archived successfully.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Check SKU availability.
     */
    public function checkSku(Request $request)
    {
        $request->validate([
            'sku' => 'required|string',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $query = Product::where('sku', $request->sku);

        if ($request->product_id) {
            $query->where('id', '!=', $request->product_id);
        }

        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'SKU already taken' : 'SKU is available'
        ]);
    }
}
