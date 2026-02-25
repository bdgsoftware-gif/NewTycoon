<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Catalog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    public function index()
    {
        $catalogs = Catalog::where('is_active', true)->orderBy('sort_order')->latest()->paginate(12);
        // dd($catalogs);
        return view('frontend.pages.catalogs', compact('catalogs'));
    }
}
