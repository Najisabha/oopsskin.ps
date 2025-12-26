<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * عرض جميع الأنواع (Types)
     */
    public function index()
    {
        $types = Type::where('is_active', true)
            ->with(['section.mainCategory'])
            ->orderBy('sort_order')
            ->get()
            ->groupBy('section.mainCategory.name');

        return view('categories.index', compact('types'));
    }
    
    /**
     * عرض منتجات نوع معين - مع الفلترة
     */
    public function show(Request $request, $mainCategorySlug, $sectionSlug, $typeSlug)
    {
        $type = Type::where('slug', $typeSlug)
            ->whereHas('section', function($query) use ($sectionSlug, $mainCategorySlug) {
                $query->where('slug', $sectionSlug)
                    ->whereHas('mainCategory', function($q) use ($mainCategorySlug) {
                        $q->where('slug', $mainCategorySlug)->where('is_active', true);
                    });
            })
            ->where('is_active', true)
            ->with(['section.mainCategory'])
            ->firstOrFail();

        // بناء الاستعلام مع الفلترة
        $query = Product::where('type_id', $type->id)
            ->active()
            ->with(['type', 'section', 'mainCategory']);

        // فلترة حسب السعر
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // فلترة حسب التقييم
        if ($request->has('rating') && is_array($request->rating)) {
            $query->whereIn('rating', $request->rating);
        }

        // الترتيب
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc')->orderBy('reviews_count', 'desc');
                break;
            case 'popular':
                $query->orderBy('reviews_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(24)->appends($request->query());

        return view('products.index', compact('type', 'products'));
    }
}

