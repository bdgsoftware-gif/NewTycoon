<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $categories = Category::with(['parent', 'children'])
            ->withCount('products')
            ->latest()
            ->paginate(30);

        // Only categories without products can be parents
        $rootCategories = Category::whereNull('parent_id')
            ->whereDoesntHave('products')
            ->get();

        $stats = [
            'totalCategories' => Category::count(),
            'activeCategories' => Category::where('is_active', true)->count(),
            'featuredCategories' => Category::where('is_featured', true)->count(),
            'totalProducts' => Product::count(),
            'leafCategories' => Category::leaf()->count(), // Categories that can have products
        ];

        return view('admin.categories.index', array_merge($stats, [
            'categories' => $categories,
            'rootCategories' => $rootCategories,
        ]));
    }

    public function create()
    {
        // Only active categories without products and within depth limit can be parents
        $parentCategories = Category::where('is_active', true)
            ->whereDoesntHave('products')
            ->where('depth', '<', Category::MAX_DEPTH)
            ->orderBy('depth')
            ->orderBy('name_en')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->full_path,
                    'depth' => $category->depth,
                ];
            });

        return view('admin.categories.create', [
            'parentCategories' => $parentCategories,
            'maxDepth' => Category::MAX_DEPTH,
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                $filename = Str::slug($data['name_en']) . '-' . time() . '.' . $request->file('image')->extension();
                $data['image'] = $request->file('image')->storeAs('categories', $filename, 'public');
            }

            // Create the category
            $category = Category::create($data);

            flash('Category created successfully!', 'success', 5000, 
                'The category "' . $category->name_en . '" has been added at depth level ' . $category->depth . '.');
            
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);

            flash('Category creation failed!', 'error', 8000, 'There was a problem creating the category. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Category $category)
    {
        // Get potential parent categories
        // Exclude: self, descendants, categories with products, max depth reached, inactive categories
        $descendantIds = $category->getAllDescendantIds();
        
        $parentCategories = Category::where('is_active', true)
            ->where('id', '!=', $category->id)
            ->whereNotIn('id', $descendantIds)
            ->whereDoesntHave('products')
            ->where('depth', '<', Category::MAX_DEPTH)
            ->orderBy('depth')
            ->orderBy('name_en')
            ->get()
            ->filter(function ($potentialParent) use ($category) {
                // Check if moving would exceed depth limit
                $newDepth = $potentialParent->depth + 1;
                $maxChildDepth = $this->getMaxDescendantDepth($category);
                return ($newDepth + $maxChildDepth) <= Category::MAX_DEPTH;
            })
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->full_path,
                    'depth' => $cat->depth,
                ];
            });

        return view('admin.categories.edit', [
            'category' => $category->load('children', 'products'),
            'parentCategories' => $parentCategories,
            'maxDepth' => Category::MAX_DEPTH,
            'hasProducts' => $category->products()->exists(),
            'hasChildren' => $category->hasChildren(),
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $data = $request->validated();

            // Handle image update
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                // Upload new image
                $filename = Str::slug($data['name_en']) . '-' . time() . '.' . $request->file('image')->extension();
                $data['image'] = $request->file('image')->storeAs('categories', $filename, 'public');
            }
            // If remove_image flag is true
            elseif ($request->has('remove_image') && $request->boolean('remove_image')) {
                // Delete the image file
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $data['image'] = null;
            }

            // Update the category
            $category->update($data);

            $message = 'Category "' . $category->name_en . '" updated successfully';
            if ($category->wasChanged('parent_id')) {
                $message .= '. Descendant depths have been recalculated.';
            }

            flash('Category Updated!', 'success', 5000, $message);
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $category->id,
                'request' => $request->all(),
            ]);

            if ($e instanceof \Illuminate\Validation\ValidationException) {
                throw $e;
            }

            flash('Update Failed!', 'error', 8000, 'An unexpected error occurred while updating the category. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Category $category)
    {
        try {
            // Check if category has children
            if ($category->hasChildren()) {
                flash('Cannot Delete!', 'error', 8000, 
                    'This category has subcategories. Please delete or reassign them first.');
                return redirect()->back();
            }

            // Check if category has products
            if ($category->products()->exists()) {
                flash('Cannot Delete!', 'error', 8000, 
                    'This category has ' . $category->products()->count() . ' products assigned. Please reassign or delete them first.');
                return redirect()->back();
            }

            // Delete associated image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            flash('Category Deleted!', 'success', 5000, 'The category has been successfully deleted.');

            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $category->id,
            ]);

            flash('Deletion Failed!', 'error', 8000, 'An error occurred while deleting the category. Please try again.');

            return redirect()->back();
        }
    }

    public function toggleFeature(Category $category)
    {
        $category->is_featured = !$category->is_featured;
        $category->save();

        return response()->json([
            'success' => true,
            'is_featured' => $category->is_featured,
        ]);
    }

    public function changeStatus(Request $request, Category $category)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        // Check if activating and parent is inactive
        if ($request->is_active && !$category->isParentActive()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot activate category when parent is inactive.',
            ], 422);
        }

        $category->is_active = $request->is_active;
        $category->save();

        // If deactivating, children will be automatically deactivated by model observer
        $message = $request->is_active 
            ? 'Category activated successfully.' 
            : 'Category and all its subcategories deactivated successfully.';

        return response()->json([
            'success' => true,
            'is_active' => $category->is_active,
            'message' => $message,
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id'
        ]);

        try {
            $categories = Category::whereIn('id', $request->ids)->get();
            $count = 0;
            $skipped = 0;

            foreach ($categories as $category) {
                // Don't delete if has children or products
                if ($category->children()->count() > 0 || $category->products()->count() > 0) {
                    $skipped++;
                    continue;
                }

                // Delete image if exists
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                $category->delete();
                $count++;
            }

            $message = "{$count} categories deleted successfully.";
            if ($skipped > 0) {
                $message .= " {$skipped} categories skipped (have children or products).";
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'count' => $count,
                'skipped' => $skipped,
            ]);
        } catch (\Exception $e) {
            Log::error('Bulk delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete categories.'
            ], 500);
        }
    }

    public function bulkActivate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id'
        ]);

        try {
            $categories = Category::whereIn('id', $request->ids)->get();
            $count = 0;
            $skipped = 0;

            foreach ($categories as $category) {
                // Check if parent is active
                if (!$category->isParentActive()) {
                    $skipped++;
                    continue;
                }

                $category->is_active = true;
                $category->save();
                $count++;
            }

            $message = "{$count} categories activated.";
            if ($skipped > 0) {
                $message .= " {$skipped} categories skipped (parent inactive).";
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'count' => $count,
                'skipped' => $skipped,
            ]);
        } catch (\Exception $e) {
            Log::error('Bulk activate error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to activate categories.'
            ], 500);
        }
    }

    public function bulkDeactivate(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id'
        ]);

        try {
            $count = Category::whereIn('id', $request->ids)
                ->update(['is_active' => false]);

            // Note: Child categories will be automatically deactivated by model observers

            return response()->json([
                'success' => true,
                'message' => "{$count} categories and their descendants deactivated.",
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Bulk deactivate error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to deactivate categories.'
            ], 500);
        }
    }

    public function reorder(Request $request, Category $category)
    {
        $request->validate([
            'direction' => 'required|in:up,down'
        ]);

        try {
            $sibling = null;

            if ($request->direction === 'up') {
                // Move up - find previous sibling
                $sibling = Category::where('parent_id', $category->parent_id)
                    ->where('order', '<', $category->order)
                    ->orderBy('order', 'desc')
                    ->first();
            } else {
                // Move down - find next sibling
                $sibling = Category::where('parent_id', $category->parent_id)
                    ->where('order', '>', $category->order)
                    ->orderBy('order', 'asc')
                    ->first();
            }

            if ($sibling) {
                // Swap orders
                $tempOrder = $category->order;
                $category->order = $sibling->order;
                $sibling->order = $tempOrder;

                $category->save();
                $sibling->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Category order updated.'
            ]);
        } catch (\Exception $e) {
            Log::error('Reorder error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to reorder category.'
            ], 500);
        }
    }

    /**
     * Helper to get max descendant depth
     */
    private function getMaxDescendantDepth(Category $category): int
    {
        if (!$category->hasChildren()) {
            return 0;
        }

        $maxDepth = 0;
        foreach ($category->children as $child) {
            $childMaxDepth = 1 + $this->getMaxDescendantDepth($child);
            $maxDepth = max($maxDepth, $childMaxDepth);
        }

        return $maxDepth;
    }

    /**
     * Get categories eligible to be parents (for AJAX)
     */
    public function getEligibleParents(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        $query = Category::where('is_active', true)
            ->whereDoesntHave('products')
            ->where('depth', '<', Category::MAX_DEPTH);

        if ($categoryId) {
            $category = Category::find($categoryId);
            if ($category) {
                $descendantIds = $category->getAllDescendantIds();
                $query->where('id', '!=', $categoryId)
                    ->whereNotIn('id', $descendantIds);
            }
        }

        $categories = $query->orderBy('depth')
            ->orderBy('name_en')
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->full_path,
                    'depth' => $cat->depth,
                ];
            });

        return response()->json($categories);
    }
}