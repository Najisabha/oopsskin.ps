<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    public function index()
    {
        $mainCategories = MainCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->with(['activeSections.activeTypes'])
            ->get();

        return view('main-categories.index', compact('mainCategories'));
    }

    public function show($slug)
    {
        $mainCategory = MainCategory::where('slug', $slug)
            ->where('is_active', true)
            ->with(['activeSections.activeTypes'])
            ->firstOrFail();

        // جلب المنتجات المميزة من هذا الصنف الرئيسي
        $featuredProducts = \App\Models\Product::where('main_category_id', $mainCategory->id)
            ->active()
            ->featured()
            ->with(['type', 'section', 'mainCategory'])
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        return view('sections.index', compact('mainCategory', 'featuredProducts'));
    }
}

