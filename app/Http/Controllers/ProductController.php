<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\MainCategory;
use App\Models\Type;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with(['type', 'section', 'mainCategory']);

        // فلترة حسب الصنف الرئيسي
        if ($request->has('main_category')) {
            $query->where('main_category_id', $request->main_category);
        }

        // فلترة حسب القسم
        if ($request->has('section')) {
            $query->where('section_id', $request->section);
        }

        // فلترة حسب النوع
        if ($request->has('type')) {
            $query->where('type_id', $request->type);
        }

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

        // ترتيب
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
        $mainCategories = MainCategory::where('is_active', true)->orderBy('sort_order')->get();

        return view('products.index', compact('products', 'mainCategories'));
    }
    
    public function show($mainCategorySlug, $sectionSlug, $typeSlug, $productSlug)
    {
        $product = Product::where('slug', $productSlug)
            ->whereHas('type', function($query) use ($typeSlug, $sectionSlug, $mainCategorySlug) {
                $query->where('slug', $typeSlug)
                    ->whereHas('section', function($q) use ($sectionSlug, $mainCategorySlug) {
                        $q->where('slug', $sectionSlug)
                            ->whereHas('mainCategory', function($m) use ($mainCategorySlug) {
                                $m->where('slug', $mainCategorySlug)->where('is_active', true);
                            });
                    });
            })
            ->active()
            ->with(['type.section.mainCategory'])
            ->firstOrFail();

        // منتجات مشابهة من نفس النوع
        $relatedProducts = Product::where('type_id', $product->type_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * عرض منتج باستخدام slug فقط (للتوافق مع البيانات القديمة)
     */
    public function showBySlug($slug)
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->with(['type.section.mainCategory', 'section.mainCategory', 'mainCategory'])
            ->firstOrFail();

        // محاولة إعادة التوجيه للرابط الكامل إذا كانت العلاقات موجودة
        if ($product->type && $product->type->section && $product->type->section->mainCategory) {
            return redirect()->route('products.show', [
                'mainCategorySlug' => $product->type->section->mainCategory->slug,
                'sectionSlug' => $product->type->section->slug,
                'typeSlug' => $product->type->slug,
                'productSlug' => $product->slug
            ], 301);
        }

        // منتجات مشابهة
        $relatedProducts = Product::where('type_id', $product->type_id ?? 0)
            ->where('id', '!=', $product->id)
            ->active()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}

