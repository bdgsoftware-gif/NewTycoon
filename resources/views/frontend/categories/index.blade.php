@extends('frontend.layouts.app')

@section('title', 'Shop by Category')
@section('description', 'Browse our product categories')

@section('content')
    <div class="min-h-screen bg-gray-50">
        {{-- Header --}}
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Shop by Category</h1>
                <p class="text-gray-600">Find products organized by category</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Featured Categories --}}
            @if ($featuredCategories->count() > 0)
                <section class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Featured Categories</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                        @foreach ($featuredCategories as $category)
                            <a href="{{ route('categories.show', $category->slug) }}"
                                class="group bg-white rounded-lg border border-gray-200 hover:border-primary hover:shadow-md transition-all duration-200 p-4">
                                {{-- Icon/Image --}}
                                <div
                                    class="aspect-square mb-3 rounded-lg bg-gray-50 flex items-center justify-center overflow-hidden">
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                            class="w-full h-full object-contain p-2" loading="lazy">
                                    @else
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    @endif
                                </div>

                                {{-- Name --}}
                                <h3
                                    class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2 group-hover:text-primary transition-colors">
                                    {{ $category->name }}
                                </h3>

                                {{-- Product count --}}
                                <p class="text-xs text-gray-500">
                                    {{ $category->products_count ?? 0 }} {{ __('items') }}
                                </p>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- All Categories --}}
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">All Categories</h2>
                    <p class="text-sm text-gray-600">{{ $categories->count() }} categories</p>
                </div>

                @if ($categories->count() > 0)
                    <div class="space-y-6">
                        @foreach ($categories as $category)
                            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                                {{-- Parent Category --}}
                                <div class="p-4 sm:p-6 border-b border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            {{-- Icon --}}
                                            @if ($category->image)
                                                <div
                                                    class="w-12 h-12 rounded-lg bg-gray-50 flex items-center justify-center overflow-hidden flex-shrink-0">
                                                    <img src="{{ asset('storage/' . $category->image) }}"
                                                        alt="{{ $category->name }}" class="w-full h-full object-contain"
                                                        loading="lazy">
                                                </div>
                                            @endif

                                            {{-- Info --}}
                                            <div>
                                                <a href="{{ route('categories.show', $category->slug) }}"
                                                    class="text-lg font-bold text-gray-900 hover:text-primary transition-colors">
                                                    {{ $category->name }}
                                                </a>
                                                @if ($category->description)
                                                    <p class="text-sm text-gray-600 mt-1 line-clamp-1">
                                                        {{ $category->description }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-4">
                                            <span class="text-sm text-gray-500 hidden sm:block">
                                                {{ $category->products_count ?? 0 }} products
                                            </span>
                                            <a href="{{ route('categories.show', $category->slug) }}"
                                                class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-lg transition-colors">
                                                View
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- Subcategories --}}
                                @if ($category->children->count() > 0)
                                    <div class="p-4 sm:p-6 bg-gray-50">
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                                            @foreach ($category->children as $child)
                                                <a href="{{ route('categories.show', $child->slug) }}"
                                                    class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200 hover:border-primary hover:shadow-sm transition-all group">
                                                    <span
                                                        class="text-sm text-gray-700 group-hover:text-primary transition-colors truncate">
                                                        {{ $child->name }}
                                                    </span>
                                                    @if ($child->products_count > 0)
                                                        <span class="text-xs text-gray-500 ml-2 flex-shrink-0">
                                                            {{ $child->products_count }}
                                                        </span>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-16 bg-white rounded-lg border border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Categories</h3>
                        <p class="text-gray-600 mb-6">There are no categories available at the moment.</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-lg transition-colors">
                            Browse All Products
                        </a>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
