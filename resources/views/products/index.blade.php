@extends('layouts.app')

@section('title', (isset($type) ? $type->name : 'جميع المنتجات') . ' - متجر المكياج')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            @if(isset($type))
                <li class="breadcrumb-item"><a href="{{ route('main-categories.show', $type->section->mainCategory->slug) }}">{{ $type->section->mainCategory->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sections.show', ['mainCategorySlug' => $type->section->mainCategory->slug, 'sectionSlug' => $type->section->slug]) }}">{{ $type->section->name }}</a></li>
                <li class="breadcrumb-item active">{{ $type->name }}</li>
            @else
                <li class="breadcrumb-item active">جميع المنتجات</li>
            @endif
        </ol>
    </nav>

    <h1 class="mb-5 text-center">{{ isset($type) ? $type->name : 'جميع المنتجات' }}</h1>
    
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm sticky-top" style="top: 100px;">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-funnel"></i> الفلترة والترتيب</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ isset($type) ? route('categories.show', [
                        'mainCategorySlug' => $type->section->mainCategory->slug,
                        'sectionSlug' => $type->section->slug,
                        'typeSlug' => $type->slug
                    ]) : route('products.index') }}" id="filterForm">
                        <!-- Sort Options -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">الترتيب</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="sort" id="sort_latest" value="latest" {{ request('sort', 'latest') == 'latest' ? 'checked' : '' }}>
                                <label class="form-check-label" for="sort_latest">
                                    <i class="bi bi-clock"></i> الأحدث
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="sort" id="sort_price_low" value="price_low" {{ request('sort') == 'price_low' ? 'checked' : '' }}>
                                <label class="form-check-label" for="sort_price_low">
                                    <i class="bi bi-arrow-down"></i> من الأقل سعر إلى الأعلى
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="sort" id="sort_price_high" value="price_high" {{ request('sort') == 'price_high' ? 'checked' : '' }}>
                                <label class="form-check-label" for="sort_price_high">
                                    <i class="bi bi-arrow-up"></i> من الأعلى سعر إلى الأقل
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="sort" id="sort_rating" value="rating" {{ request('sort') == 'rating' ? 'checked' : '' }}>
                                <label class="form-check-label" for="sort_rating">
                                    <i class="bi bi-star-fill text-warning"></i> الأعلى تقيماً
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="sort" id="sort_popular" value="popular" {{ request('sort') == 'popular' ? 'checked' : '' }}>
                                <label class="form-check-label" for="sort_popular">
                                    <i class="bi bi-fire"></i> الأكثر مبيعاً
                                </label>
                            </div>
                        </div>
                        
                        <!-- Rating Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">حسب النجوم</h6>
                            @for($i = 5; $i >= 1; $i--)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="rating[]" id="rating{{ $i }}" value="{{ $i }}" {{ in_array($i, (array)request('rating', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rating{{ $i }}">
                                        @for($j = 1; $j <= 5; $j++)
                                            <i class="bi bi-star{{ $j <= $i ? '-fill' : '' }} text-warning"></i>
                                        @endfor
                                        <span class="ms-2">({{ $i }} نجمة{{ $i > 1 ? 'ات' : '' }})</span>
                                    </label>
                                </div>
                            @endfor
                        </div>
                        
                        <!-- Price Range -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">نطاق السعر</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <label class="form-label small">من</label>
                                    <input type="number" class="form-control form-control-sm" name="min_price" value="{{ request('min_price') }}" placeholder="0" min="0">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small">إلى</label>
                                    <input type="number" class="form-control form-control-sm" name="max_price" value="{{ request('max_price') }}" placeholder="1000" min="0">
                                </div>
                            </div>
                        </div>
                        
                        @if(request('main_category') || request('section') || request('type'))
                            <input type="hidden" name="main_category" value="{{ request('main_category') }}">
                            <input type="hidden" name="section" value="{{ request('section') }}">
                            <input type="hidden" name="type" value="{{ request('type') }}">
                        @endif
                        
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-check-circle"></i> تطبيق الفلتر
                        </button>
                        <a href="{{ isset($type) ? route('categories.show', [
                            'mainCategorySlug' => $type->section->mainCategory->slug,
                            'sectionSlug' => $type->section->slug,
                            'typeSlug' => $type->slug
                        ]) : route('products.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise"></i> إعادة تعيين
                        </a>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="mb-0">
                    @if(isset($products) && $products->count() > 0)
                        عرض <strong>{{ $products->count() }}</strong> منتج 
                        @if($products->total() > 0)
                            من أصل <strong>{{ $products->total() }}</strong>
                        @endif
                    @else
                        لا توجد منتجات
                    @endif
                </p>
            </div>
            
            @if(isset($products) && $products->count() > 0)
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-md-6 col-lg-4">
                            @include('components.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <nav aria-label="Page navigation" class="mt-5">
                    {{ $products->links() }}
                </nav>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <h4 class="mt-3">لا توجد منتجات</h4>
                    <p class="text-muted">لم يتم العثور على منتجات تطابق معايير البحث</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-arrow-right"></i> عرض جميع المنتجات
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // تطبيق الفلتر تلقائياً عند تغيير خيارات الترتيب
    document.querySelectorAll('input[name="sort"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endpush
@endsection
