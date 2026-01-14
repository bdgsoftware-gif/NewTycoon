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

        $rootCategories = Category::whereNull('parent_id')->get();

        $stats = [
            'totalCategories' => Category::count(),
            'activeCategories' => Category::where('is_active', true)->count(),
            'featuredCategories' => Category::where('is_featured', true)->count(),
            'totalProducts' => Product::count(),
        ];

        return view('admin.categories.index', array_merge($stats, [
            'categories' => $categories,
            'rootCategories' => $rootCategories,
        ]));
    }

    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->get();

        return view('admin.categories.create', [
            'parentCategories' => $parentCategories,
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
            Category::create($data);

            flash('Category created successfully!', 'success', 5000, 'The category has been added to the system.');
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
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->where('is_active', true)
            ->get();
        // dd($category);
        return view('admin.categories.edit', [
            'category' => $category->load('children'),
            'parentCategories' => $parentCategories,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // dd($request->all());
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

            // Prevent setting self as parent
            if (isset($data['parent_id']) && $data['parent_id'] == $category->id) {
                flash('Invalid Selection', 'error', 8000, 'A category cannot be its own parent.');
                return redirect()->back()->withInput();
            }

            // Update the category
            $category->update($data);

            flash('Category Updated!', 'success', 5000, $category->name_en . ' has been successfully updated.');
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
            // Delete associated image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            // Success feedback
            flash('Category Deleted!', 'success', 5000, 'The category has been successfully deleted.');

            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $category->id,
            ]);

            // Error feedback
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

        $category->is_active = $request->is_active;
        $category->save();

        return response()->json([
            'success' => true,
            'is_active' => $category->is_active,
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

            foreach ($categories as $category) {
                // Don't delete if has children
                if ($category->children()->count() > 0) {
                    continue;
                }

                // Delete image if exists
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                $category->delete();
                $count++;
            }

            return response()->json([
                'success' => true,
                'message' => "{$count} categories deleted successfully.",
                'count' => $count
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
            $count = Category::whereIn('id', $request->ids)
                ->update(['is_active' => true]);

            return response()->json([
                'success' => true,
                'message' => "{$count} categories activated.",
                'count' => $count
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

            return response()->json([
                'success' => true,
                'message' => "{$count} categories deactivated.",
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
}
