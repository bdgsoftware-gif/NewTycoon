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
            ->paginate(20);

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
            if ($request->hasFile('image')) {
                $filename = Str::slug($data['name']) . '.' . $request->file('image')->extension();
                $data['image'] = $request->file('image')->storeAs('categories', $filename, 'public');
            }

            // Create the category
            Category::create($data);

            // Success feedback - CORRECTED
            flash('Category created successfully!', 'success', 5000, 'The category has been added to the system.');
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
            ]);

            // Error feedback - CORRECTED
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

        return view('admin.categories.edit', [
            'category' => $category->load('children'),
            'parentCategories' => $parentCategories,
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
                $filename = Str::slug($data['name']) . '-' . time() . '.' . $request->file('image')->extension();
                $data['image'] = $request->file('image')->storeAs('categories', $filename, 'public');
            }
            // If remove_image flag is true (handled in request's passedValidation)
            elseif ($request->has('remove_image') && $request->boolean('remove_image')) {
                // Delete the image file
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
            }

            // Prevent setting self as parent
            if (isset($data['parent_id']) && $data['parent_id'] == $category->id) {
                flash('Invalid Selection', 'error', 8000,  'A category cannot be its own parent.');
                return redirect()->back()->withInput();
            }

            // Update the category
            $category->update($data);

            // Success feedback
            flash('Category Updated!',  'success',  5000, $category->name . ' has been successfully updated.');

            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage(), [
                'exception' => $e,
                'category_id' => $category->id,
                'request' => $request->all(),
            ]);

            // If it's a validation error, let the form request handle it
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                throw $e;
            }

            // For other errors
            flash('Update Failed!',  'error',  8000, 'An unexpected error occurred while updating the category. Please try again.');

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
}
