@extends('frontend.layouts.app')

@section('title', 'Product Categories')
@section('description', 'Browse our product categories')

@section('content')
    <div class="max-w-8xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2 font-quantico">Product Categories</h1>
            <p class="text-gray-600 font-inter">Browse products by category</p>
        </div>

        <!-- Featured Categories -->
        @if ($featuredCategories->count() > 0)
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-quantico">Featured Categories</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($featuredCategories as $category)
                        <a href="{{ route('categories.show', $category->slug) }}"
                            class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 border border-primary/20 hover:border-primary/40 transition-all duration-300 hover:shadow-xl">
                            <div class="p-8">
                                @if ($category->image)
                                    <div class="w-20 h-20 mb-4 rounded-full overflow-hidden bg-white/50">
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                            class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                @endif
                                <h3 class="text-xl font-bold text-gray-900 mb-2 font-quantico group-hover:text-primary">
                                    {{ $category->name }}</h3>
                                @if ($category->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2 font-inter">
                                        {{ $category->description }}</p>
                                @endif
                                <span class="inline-flex items-center text-primary font-medium text-sm font-inter">
                                    Browse Products
                                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- All Categories -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6 font-quantico">All Categories</h2>
            <div class="space-y-4">
                @foreach ($categories as $category)
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    @if ($category->image)
                                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-100">
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                alt="{{ $category->name }}" class="w-full h-full object-contain">
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 font-quantico">
                                            <a href="{{ route('categories.show', $category->slug) }}"
                                                class="hover:text-primary transition-colors">
                                                {{ $category->name }}
                                            </a>
                                        </h3>
                                        @if ($category->description)
                                            <p class="text-gray-600 text-sm mt-1 font-inter">
                                                {{ Str::limit($category->description, 100) }}</p>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('categories.show', $category->slug) }}"
                                    class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors text-sm font-quantico">
                                    View Products
                                </a>
                            </div>

                            @if ($category->children->count() > 0)
                                <div class="pl-16">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach ($category->children as $child)
                                            <a href="{{ route('categories.show', $child->slug) }}"
                                                class="flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:border-primary hover:bg-gray-50 transition-colors group">
                                                <span
                                                    class="text-gray-700 group-hover:text-primary font-inter">{{ $child->name }}</span>
                                                <svg class="w-4 h-4 text-gray-400 group-hover:text-primary" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
