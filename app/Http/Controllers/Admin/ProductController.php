<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }
    /* -----------------------------------------------------------------
     | Index
     |------------------------------------------------------------------*/
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->search, fn($q) => $q->search($request->search))
            ->when(
                $request->status && $request->status !== 'all',
                fn($q) => $q->where('status', $request->status)
            )
            ->when(
                $request->category_id && $request->category_id !== 'all',
                fn($q) => $q->where('category_id', $request->category_id)
            )
            ->latest()
            ->paginate(20);

        $categories = Category::where('is_active', true)->orderBy('name_en')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /* -----------------------------------------------------------------
     | Create
     |------------------------------------------------------------------*/
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name_en')->get();

        return view('admin.products.create', compact('categories'));
    }

    /* -----------------------------------------------------------------
     | Store
     |------------------------------------------------------------------*/
    public function store(StoreProductRequest $request)
    {
        // dd($request->all());
        DB::transaction(function () use ($request) {
            $product = Product::create(
                array_merge(
                    $request->validated(),
                    [
                        'vendor_id' => Auth::id(),
                        'featured_images' => $this->storeImages(
                            $request->file('featured_images'),
                            'products/featured',
                            2,
                            [Product::DEFAULT_FEATURED_IMAGE]
                        ),
                        'gallery_images' => $this->storeImages(
                            $request->file('gallery_images'),
                            'products/gallery',
                            5
                        ),
                    ]
                )
            );
        });

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /* -----------------------------------------------------------------
     | Edit
     |------------------------------------------------------------------*/
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name_en')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /* -----------------------------------------------------------------
     | Update
     |------------------------------------------------------------------*/
    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {

            // ---------- FEATURED IMAGES ----------
            $featured = $request->input('existing_featured_images', $product->featured_images ?? []);

            // Remove selected
            if ($request->filled('remove_featured_images')) {
                foreach ($request->remove_featured_images as $path) {
                    Storage::disk('public')->delete($path);
                    $featured = array_values(array_diff($featured, [$path]));
                }
            }

            // Add new uploads
            if ($request->hasFile('featured_images')) {
                foreach ($request->file('featured_images') as $image) {
                    if (count($featured) >= 2) break;

                    $featured[] = $image->store('products/featured', 'public');
                }
            }

            // ---------- GALLERY IMAGES ----------
            $gallery = $request->input('existing_gallery_images', $product->gallery_images ?? []);

            if ($request->filled('remove_gallery_images')) {
                foreach ($request->remove_gallery_images as $path) {
                    Storage::disk('public')->delete($path);
                    $gallery = array_values(array_diff($gallery, [$path]));
                }
            }

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    if (count($gallery) >= 5) break;

                    $gallery[] = $image->store('products/gallery', 'public');
                }
            }

            // ---------- UPDATE PRODUCT ----------
            $product->update(array_merge(
                $request->validated(),
                [
                    'featured_images' => $featured,
                    'gallery_images'  => $gallery,
                ]
            ));
        });

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $product->load([
            'category',
            'reviews' => function ($query) {
                $query->latest()->limit(10);
            },
            'orderItems' => function ($query) {
                $query->with(['order' => function ($q) {
                    $q->select('id', 'order_number', 'created_at');
                }])->latest()->limit(10);
            },
            'wishlists' => function ($query) {
                $query->with(['user' => function ($q) {
                    $q->select('id', 'name', 'email');
                }])->latest()->limit(10);
            }
        ]);

        return view('admin.products.show', compact('product'));
    }

    /* -----------------------------------------------------------------
     | Destroy
     |------------------------------------------------------------------*/
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            $this->deleteImages($product->featured_images);
            $this->deleteImages($product->gallery_images);

            $product->delete();
        });

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /* -----------------------------------------------------------------
     | Helpers
     |------------------------------------------------------------------*/
    protected function storeImages(
        ?array $files,
        string $directory,
        int $limit,
        array $fallback = []
    ): array {
        if (empty($files)) {
            return $fallback;
        }

        $paths = [];

        foreach ($files as $file) {
            $paths[] = $file->store($directory, 'public');
        }

        return array_slice($paths, 0, $limit);
    }

    protected function deleteImages(?array $images): void
    {
        foreach ($images ?? [] as $image) {
            if ($image !== Product::DEFAULT_FEATURED_IMAGE) {
                Storage::disk('public')->delete($image);
            }
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
