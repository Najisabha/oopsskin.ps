@extends('layouts.app')

@section('title', 'الرئيسية - متجر المكياج')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-light py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">اكتشفي جمالك الطبيعي</h1>
                <p class="lead mb-4">مجموعة واسعة من منتجات المكياج والعناية بالبشرة من أشهر الماركات العالمية</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-left"></i> تصفح المنتجات
                </a>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=600&h=400&fit=crop" class="img-fluid rounded" alt="Hero Image">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section mb-5">
    <div class="container">
        <h2 class="text-center mb-5">تصفح حسب النوع</h2>
        <div class="row g-4">
            @foreach([
                ['name' => 'أحمر الشفاه', 'icon' => 'bi-lips', 'color' => 'danger'],
                ['name' => 'ماسكارا', 'icon' => 'bi-eye', 'color' => 'dark'],
                ['name' => 'أحمر الخدود', 'icon' => 'bi-heart', 'color' => 'pink'],
                ['name' => 'أساس', 'icon' => 'bi-palette', 'color' => 'warning'],
                ['name' => 'ظلال العيون', 'icon' => 'bi-stars', 'color' => 'info'],
                ['name' => 'عناية بالبشرة', 'icon' => 'bi-droplet', 'color' => 'primary'],
            ] as $category)
                <div class="col-md-4 col-lg-2">
                    <a href="{{ route('categories.show', str_replace(' ', '-', $category['name'])) }}" class="text-decoration-none">
                        <div class="card text-center h-100 shadow-sm category-card">
                            <div class="card-body">
                                <i class="bi {{ $category['icon'] }} fs-1 text-{{ $category['color'] }} mb-3"></i>
                                <h6 class="card-title">{{ $category['name'] }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>منتجات مميزة</h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">عرض الكل</a>
        </div>
        <div class="row g-4">
            @for($i = 1; $i <= 8; $i++)
                <div class="col-md-6 col-lg-3">
                    @include('components.product-card', ['product' => (object)[
                        'id' => $i,
                        'name' => 'منتج المكياج ' . $i,
                        'description' => 'وصف المنتج المميز',
                        'price' => rand(50, 500),
                        'discount' => $i % 3 == 0 ? 20 : 0,
                        'is_new' => $i <= 2,
                        'rating' => rand(3, 5),
                        'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=300&h=300&fit=crop&sig=' . $i
                    ]])
                </div>
            @endfor
        </div>
    </div>
</section>

<!-- Special Offers -->
<section class="special-offers bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="mb-3">عروض خاصة</h2>
                <p class="lead">احصلي على خصم 30% على جميع منتجات المكياج هذا الأسبوع فقط!</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-arrow-left"></i> تسوق الآن
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    .category-card {
        transition: transform 0.3s;
        border: none;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
    }
    
    .hero-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
</style>

@push('scripts')
<script>
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            // إضافة منطق إضافة المنتج للسلة
            alert('تم إضافة المنتج للسلة');
        });
    });
</script>
@endpush
@endsection

