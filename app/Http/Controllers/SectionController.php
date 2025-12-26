<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Product;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function show($mainCategorySlug, $sectionSlug)
    {
        $section = Section::where('slug', $sectionSlug)
            ->whereHas('mainCategory', function($query) use ($mainCategorySlug) {
                $query->where('slug', $mainCategorySlug)->where('is_active', true);
            })
            ->where('is_active', true)
            ->with(['mainCategory', 'activeTypes'])
            ->firstOrFail();

        // جلب المنتجات المميزة من هذا القسم
        $featuredProducts = Product::where('section_id', $section->id)
            ->active()
            ->featured()
            ->with(['type', 'mainCategory', 'section'])
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        return view('types.index', compact('section', 'featuredProducts'));
    }
}

