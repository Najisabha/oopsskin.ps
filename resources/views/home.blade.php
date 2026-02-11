@extends('layouts.app')

@section('title', 'الرئيسية - متجر المكياج')

@section('content')

<style>
    :root {
        --brand-pink: #E91E63;
        --brand-dark: #000000;
        --brand-gold: #D4AF37;
        --text-dark: #000000;
        --bg-cream: #FAF9F6;
    }

    /* --- Hero Carousel (Huda Beauty Style) --- */
    #heroCarousel .carousel-item {
        height: 75vh;
        min-height: 500px;
        position: relative;
        overflow: hidden;
    }

    .hero-image {
        object-fit: cover;
        height: 100%;
        width: 100%;
        filter: brightness(0.85);
        transition: transform 8s ease-in-out;
    }

    #heroCarousel .carousel-item.active .hero-image {
        transform: scale(1.05);
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0,0,0,0.3) 0%, rgba(233,30,99,0.2) 100%);
    }

    #heroCarousel .carousel-caption {
        bottom: auto;
        top: 50%;
        transform: translateY(-50%);
        text-align: right;
        right: 8%;
        left: auto;
        padding: 0;
        max-width: 600px;
    }

    #heroCarousel .carousel-caption h1 {
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        font-size: 3.5rem;
        line-height: 1.2;
        text-shadow: 2px 4px 20px rgba(0,0,0,0.3);
    }

    #heroCarousel .carousel-caption p {
        font-size: 1.1rem;
        line-height: 1.6;
        text-shadow: 1px 2px 10px rgba(0,0,0,0.4);
    }

    #heroCarousel .carousel-caption .badge {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 8px 18px;
        letter-spacing: 0.5px;
    }
    
    /* Mobile Responsive */
    @media (max-width: 767.98px) {
        #heroCarousel .carousel-item {
            height: 65vh;
            min-height: 450px;
        }
        
        #heroCarousel .carousel-caption {
            right: 5%;
            left: 5%;
            max-width: 90%;
            top: 50%;
        }
        
        #heroCarousel .carousel-caption h1 {
            font-size: 2rem !important;
            line-height: 1.3;
        }
        
        #heroCarousel .carousel-caption p {
            font-size: 0.95rem !important;
        }
        
        .hero-image {
            filter: brightness(0.7);
        }
    }
    
    .carousel-control-prev, 
    .carousel-control-next {
        width: 5%;
        opacity: 0.6;
    }
    
    .carousel-control-prev:hover, 
    .carousel-control-next:hover {
        opacity: 1;
    }

    .carousel-indicators button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin: 0 5px;
    }

    /* Category Cards (Minimalist Style) */
    .category-card {
        border: 1px solid #f0f0f0;
        border-radius: 0;
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        border-color: var(--brand-pink);
    }
    
    .category-icon-wrapper {
        width: 65px;
        height: 65px;
        margin: 0 auto;
        background: #fafafa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .category-card:hover .category-icon-wrapper {
        background: var(--brand-pink);
        transform: scale(1.1);
    }
    
    .category-card:hover .category-icon-wrapper i {
        color: white !important;
    }

    /* Section Titles (Clean Style) */
    .section-title {
        font-weight: 800;
        font-size: 2rem;
        color: var(--text-dark);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 15px;
    }

    .section-subtitle {
        color: #666;
        font-size: 1rem;
        margin-bottom: 40px;
    }

    /* Feature Boxes */
    .feature-box {
        text-align: center;
        padding: 35px 20px;
        border-radius: 0;
        background: #fff;
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .feature-box:hover {
        border-color: var(--brand-pink);
        box-shadow: 0 10px 30px rgba(233, 30, 99, 0.1);
    }
    
    .feature-box i {
        font-size: 2.8rem;
        color: var(--brand-pink);
        margin-bottom: 20px;
        display: block;
    }

    .feature-box h5 {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 10px;
    }

    /* Special Offers Banner */
    .special-offers {
        background: var(--brand-dark);
        position: relative;
        border-radius: 0;
    }
    
    /* Buttons */
    .btn-shop-now {
        background-color: var(--text-dark);
        color: white;
        border-radius: 0;
        padding: 14px 40px;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        border: none;
        transition: all 0.3s ease;
        display: inline-block;
    }
    
    .btn-shop-now:hover {
        background-color: var(--brand-pink);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(233, 30, 99, 0.3);
    }

    .btn-view-all {
        background: transparent;
        color: var(--text-dark);
        border: 2px solid var(--text-dark);
        border-radius: 0;
        padding: 10px 30px;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    
    .btn-view-all:hover {
        background: var(--text-dark);
        color: white;
    }
</style>

<!-- Hero Carousel Section -->
<section class="p-0 mb-5">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
        
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1616683693504-3ea7e9ad6fec?q=80&w=1920&auto=format&fit=crop" 
                     class="d-block w-100 hero-image" alt="المجموعة الجديدة">
                <div class="hero-overlay"></div>
                <div class="carousel-caption">
                    <span class="badge bg-light text-dark mb-3">NEW COLLECTION 2026</span>
                    <h1 class="fw-bold mb-4 text-white">
                        اكتشفي<br>
                        <span style="color: var(--brand-pink);">جمالك الحقيقي</span>
                    </h1>
                    <p class="lead mb-5 text-white">
                        مجموعة حصرية من أفخر منتجات المكياج والعناية بالبشرة<br>
                        من أرقى العلامات التجارية العالمية
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-shop-now">
                        تسوقي الآن
                    </a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1596462502278-27bfdd403348?q=80&w=1920&auto=format&fit=crop" 
                     class="d-block w-100 hero-image" alt="عروض خاصة">
                <div class="hero-overlay"></div>
                <div class="carousel-caption">
                    <span class="badge bg-danger mb-3">SPECIAL SALE ⚡</span>
                    <h1 class="fw-bold mb-4 text-white">
                        خصم يصل إلى<br>
                        <span style="font-size: 4rem;">50%</span>
                    </h1>
                    <p class="lead mb-5 text-white">
                        على مختارات من أفضل منتجات المكياج<br>
                        لفترة محدودة فقط!
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-shop-now">
                        اكتشفي العروض
                    </a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1522338242992-e1a54906a8da?q=80&w=1920&auto=format&fit=crop" 
                     class="d-block w-100 hero-image" alt="العناية بالبشرة">
                <div class="hero-overlay"></div>
                <div class="carousel-caption">
                    <span class="badge bg-success mb-3">SKINCARE ROUTINE</span>
                    <h1 class="fw-bold mb-4 text-white">
                        بشرة مشرقة<br>
                        <span style="color: var(--brand-pink);">بلا حدود</span>
                    </h1>
                    <p class="lead mb-5 text-white">
                        منتجات عناية فاخرة لبشرة صحية ومتألقة<br>
                        باستخدام أفضل المكونات الطبيعية
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-shop-now">
                        ابدأي الآن
                    </a>
                </div>
            </div>
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">السابق</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">التالي</span>
        </button>
    </div>
</section>

<!-- Features Section -->
<section class="container mb-5 py-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-box">
                <i class="bi bi-shield-check"></i>
                <h5>منتجات أصلية 100%</h5>
                <p class="text-muted mb-0">جميع منتجاتنا أصلية ومعتمدة من الموردين الرسميين</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <i class="bi bi-truck"></i>
                <h5>شحن مجاني</h5>
                <p class="text-muted mb-0">توصيل مجاني لجميع الطلبات فوق 200₪</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <i class="bi bi-arrow-clockwise"></i>
                <h5>إرجاع سهل</h5>
                <p class="text-muted mb-0">سياسة إرجاع مرنة خلال 14 يوم</p>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section mb-5 py-5" style="background-color: var(--bg-cream);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-2">SHOP BY CATEGORY</h2>
            <p class="section-subtitle">اكتشفي مجموعتنا المتنوعة من منتجات الجمال</p>
        </div>
        <div class="row g-4">
            @forelse($mainCategories ?? [] as $mainCategory)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('main-categories.show', $mainCategory->slug) }}" class="text-decoration-none">
                        <div class="card text-center h-100 category-card py-4">
                            <div class="category-icon-wrapper mb-3">
                                @if($mainCategory->icon)
                                    <i class="{{ $mainCategory->icon }} fs-3" style="color: var(--brand-pink);"></i>
                                @elseif($mainCategory->image)
                                    <img src="{{ $mainCategory->image }}" alt="{{ $mainCategory->name }}" class="img-fluid" style="max-width: 45px; max-height: 45px;">
                                @else
                                    <i class="bi bi-palette fs-3" style="color: var(--brand-pink);"></i>
                                @endif
                            </div>
                            <h6 class="card-title text-dark fw-bold m-0" style="font-size: 0.9rem;">{{ $mainCategory->name }}</h6>
                        </div>
                    </a>
                </div>
            @empty
                @foreach([
                    ['name' => 'مكياج العيون', 'icon' => 'bi-palette2', 'slug' => 'eye-makeup'],
                    ['name' => 'العناية بالبشرة', 'icon' => 'bi-droplet-fill', 'slug' => 'skincare'],
                    ['name' => 'أحمر الشفاه', 'icon' => 'bi-heart-fill', 'slug' => 'lipstick'],
                    ['name' => 'العطور', 'icon' => 'bi-flower1', 'slug' => 'perfumes'],
                    ['name' => 'العناية بالشعر', 'icon' => 'bi-scissors', 'slug' => 'haircare'],
                    ['name' => 'الأظافر', 'icon' => 'bi-brush', 'slug' => 'nails'],
                ] as $category)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="text-decoration-none">
                            <div class="card text-center h-100 category-card py-4">
                                <div class="category-icon-wrapper mb-3">
                                    <i class="bi {{ $category['icon'] }} fs-3" style="color: var(--brand-pink);"></i>
                                </div>
                                <h6 class="card-title text-dark fw-bold m-0" style="font-size: 0.9rem;">{{ $category['name'] }}</h6>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

@php
    // Demo products للاستخدام في حالة عدم وجود منتجات من قاعدة البيانات
    $demoProducts = [
                        [
                            'id' => 1,
                            'name' => 'أحمر شفاه ماتي فاخر',
                            'slug' => 'luxury-matte-lipstick-1',
                            'price' => 120,
                            'discount_percentage' => 15,
                            'is_new' => true,
                            'rating' => 5,
                            'image' => 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=500&h=500&fit=crop&q=80'
                        ],
                        [
                            'id' => 2,
                            'name' => 'ماسكارا طويلة الأمد',
                            'slug' => 'long-lasting-mascara-2',
                            'price' => 85,
                            'discount_percentage' => 0,
                            'is_new' => true,
                            'rating' => 4,
                            'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500&h=500&fit=crop&q=80'
                        ],
                        [
                            'id' => 3,
                            'name' => 'أحمر خدود طبيعي',
                            'slug' => 'natural-blush-3',
                            'price' => 95,
                            'discount_percentage' => 20,
                            'is_new' => false,
                            'rating' => 5,
                            'image' => 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=500&h=500&fit=crop&q=80'
                        ],
                        [
                            'id' => 4,
                            'name' => 'أساس سائل عالي التغطية',
                            'slug' => 'high-coverage-foundation-4',
                            'price' => 180,
                            'discount_percentage' => 0,
                            'is_new' => false,
                            'rating' => 4,
                            'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=500&h=500&fit=crop&q=80'
                        ],
                        [
                            'id' => 5,
                            'name' => 'ظلال عيون متعددة الألوان',
                            'slug' => 'multi-color-eyeshadow-5',
                            'price' => 150,
                            'discount_percentage' => 25,
                            'is_new' => false,
                            'rating' => 5,
                            'image' => 'https://images.unsplash.com/photo-1622618990740-ce57d7f904d4?w=500&h=500&fit=crop&q=80'
                        ],
                        [
                            'id' => 6,
                            'name' => 'كونسيلر سائل',
                            'slug' => 'liquid-concealer-6',
                            'price' => 75,
                            'discount_percentage' => 0,
                            'is_new' => true,
                            'rating' => 4,
                            'image' => 'https://images.unsplash.com/photo-1612817288484-6f916006741a?w=500&h=500&fit=crop&q=80'
                        ],
                        [
                            'id' => 7,
                            'name' => 'برايمر للوجه',
                            'slug' => 'face-primer-7',
                            'price' => 110,
                            'discount_percentage' => 10,
                            'is_new' => false,
                            'rating' => 5,
                            'image' => 'https://images.unsplash.com/photo-1522338247332-0be842c92e7a?w=500&h=500&fit=crop&q=80'
                        ],
                        [
                            'id' => 8,
                            'name' => 'كحل سائل',
                            'slug' => 'liquid-eyeliner-8',
                            'price' => 65,
                            'discount_percentage' => 0,
                            'is_new' => true,
                            'rating' => 4,
                            'image' => 'https://images.unsplash.com/photo-1556228841-c5b7e0e0e0b0?w=500&h=500&fit=crop&q=80'
                        ]
                    ];
@endphp

<!-- Trending Products Section -->
<section class="featured-products mb-5 py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-2">TRENDING NOW</h2>
            <p class="section-subtitle">المنتجات الأكثر رواجاً هذا الأسبوع</p>
        </div>
        
        <div class="row g-4">
            @forelse($featuredProducts ?? [] as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('components.product-card', ['product' => $product])
                </div>
            @empty
                @foreach($demoProducts as $demoProduct)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('components.product-card', ['product' => (object)$demoProduct])
                    </div>
                @endforeach
            @endforelse
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-view-all">
                VIEW ALL PRODUCTS
            </a>
        </div>
    </div>
</section>

<!-- Special Offer Banner -->
<section class="special-offers py-5 mb-5">
    <div class="container">
        <div class="row align-items-center g-0">
            <div class="col-lg-6 p-5 text-white">
                <span class="badge mb-3" style="background-color: var(--brand-pink); font-size: 0.75rem; letter-spacing: 1px;">
                    LIMITED TIME OFFER
                </span>
                <h2 class="display-4 fw-bold mb-4" style="font-family: 'Playfair Display', serif;">
                    مجموعة العناية الفاخرة
                </h2>
                <p class="lead mb-4" style="color: #ccc;">
                    احصلي على خصم 40% عند شراء المجموعة الكاملة للعناية بالبشرة.<br>
                    العرض ساري حتى نفاذ الكمية!
                </p>
                <a href="{{ route('products.index') }}" class="btn btn-shop-now" style="background: white; color: black;">
                    تسوقي الآن
                </a>
            </div>
            <div class="col-lg-6 text-center d-none d-lg-block" style="background: linear-gradient(135deg, #E91E63 0%, #FF6B9D 100%); padding: 80px 0;">
                <img src="https://images.unsplash.com/photo-1629198688000-71f23e745b6e?w=600&fit=crop" 
                     class="img-fluid shadow-lg" 
                     alt="Special Offer" 
                     style="max-height: 450px; object-fit: contain; border-radius: 10px;">
            </div>
        </div>
    </div>
</section>

<!-- New Arrivals Section -->
<section class="new-arrivals mb-5 py-5" style="background-color: #f9f9f9;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-2">NEW ARRIVALS</h2>
            <p class="section-subtitle">أحدث المنتجات التي وصلت حديثاً</p>
        </div>
        
        <div class="row g-4">
            @foreach(array_slice($demoProducts, 0, 4) as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('components.product-card', ['product' => (object)$product])
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Instagram Feed Section -->
<section class="instagram-section py-5 mb-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-2">FOLLOW US @OOPSSKIN</h2>
            <p class="section-subtitle">تابعينا على انستغرام لمشاهدة آخر الإطلالات والمنتجات</p>
        </div>
        
        <div class="row g-3">
            @php
                $instaPosts = [
                    'https://images.unsplash.com/photo-1596462502278-27bfdd403348?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1631214524020-7e18db9a8f92?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1616683693504-3ea7e9ad6fec?w=400&h=400&fit=crop',
                    'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=400&h=400&fit=crop',
                ];
            @endphp
            @foreach($instaPosts as $post)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="#" class="d-block position-relative overflow-hidden insta-post">
                        <img src="{{ $post }}" alt="Instagram Post" class="w-100" style="aspect-ratio: 1/1; object-fit: cover;">
                        <div class="insta-overlay">
                            <i class="bi bi-instagram fs-2 text-white"></i>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section py-5 mb-5" style="background: linear-gradient(135deg, #000000 0%, #434343 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0 text-white">
                <h3 class="fw-bold mb-3" style="font-size: 2rem;">
                    اشتركي في نشرتنا البريدية
                </h3>
                <p class="mb-0" style="color: #ccc; font-size: 1.1rem;">
                    احصلي على خصومات حصرية وكوني أول من يعلم بالمنتجات الجديدة
                </p>
            </div>
            <div class="col-lg-6">
                <form class="d-flex gap-2">
                    <input type="email" 
                           class="form-control border-0 p-3" 
                           placeholder="أدخلي بريدك الإلكتروني"
                           style="background: rgba(255,255,255,0.9); border-radius: 0; font-size: 0.95rem;">
                    <button type="submit" class="btn btn-primary-brand px-4" style="white-space: nowrap;">
                        اشتراك
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    /* Instagram Post Hover Effect */
    .insta-post {
        position: relative;
        overflow: hidden;
    }

    .insta-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(233, 30, 99, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .insta-post:hover .insta-overlay {
        opacity: 1;
    }

    .insta-post img {
        transition: transform 0.5s ease;
    }

    .insta-post:hover img {
        transform: scale(1.1);
    }
</style>

@endsection

@push('scripts')
<script>
    // Carousel Auto-play
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips if needed
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    
    // Add to Cart Animation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-to-cart')) {
            const btn = e.target.closest('.add-to-cart');
            const originalHtml = btn.innerHTML;
            
            btn.innerHTML = '<i class="bi bi-check2"></i>';
            btn.style.background = '#28a745';
            btn.style.color = 'white';
            
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.style.background = '';
                btn.style.color = '';
            }, 1500);
        }
    });

    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush