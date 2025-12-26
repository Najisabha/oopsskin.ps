<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // جلب الأصناف الرئيسية النشطة
        $mainCategories = MainCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->with(['activeSections.activeTypes'])
            ->get();

        // جلب المنتجات المميزة مع العلاقات الكاملة
        $featuredProducts = Product::active()
            ->featured()
            ->with(['type.section.mainCategory', 'section.mainCategory', 'mainCategory'])
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        return view('home', compact('mainCategories', 'featuredProducts'));
    }
}

