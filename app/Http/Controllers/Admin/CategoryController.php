<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
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

   
}
