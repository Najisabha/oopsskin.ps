@extends('layouts.app')

@section('title', 'الرئيسية - متجر المكياج')

@section('content')

<style>
    :root {
        --main-color: #d63384;
        --accent-color: #f8d7da;
        --gold-color: #c5a059;
        --text-dark: #2c2c2c;
    }

    /* --- تعديلات خاصة بالـ Carousel --- */
    #heroCarousel .carousel-item {
        height: 85vh; /* ارتفاع مناسب للشاشات الكبيرة */
        min-height: 550px; /* حد أدنى للارتفاع */
        position: relative;
    }

    .hero-image {
        object-fit: cover; /* لضمان تغطية الصورة للمساحة بالكامل */
        height: 100%;
        width: 100%;
        /* فلتر لتقليل سطوع الصورة وجعل النص الأبيض أكثر وضوحاً */
        filter: brightness(0.75); 
    }

    /* طبقة إضافية فوق الصورة لزيادة وضوح النص (اختياري) */
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.4) 100%);
    }

    /* تنسيق حاوية النص داخل الـ Carousel */
    #heroCarousel .carousel-caption {
        bottom: auto; /* إلغاء التموضع السفلي الافتراضي */
        top: 50%; /* توسيط عمودي */
        transform: translateY(-50%);
        text-align: right; /* محاذاة لليمين */
        right: 10%; /* مسافة من اليمين */
        left: auto;
        padding: 0;
        max-width: 650px; /* أقصى عرض للنص */
    }
    
    /* تخصيص أزرار التنقل (الأسهم) */
    .carousel-control-prev, .carousel-control-next {
        width: 6%;
        opacity: 0.5;
    }
    .carousel-control-prev:hover, .carousel-control-next:hover {
        opacity: 0.9;
    }

    /* --- باقي تنسيقات الصفحة (كما هي) --- */
    body { font-family: 'Cairo', sans-serif; }

    .category-card {
        border: none;
        border-radius: 15px;
        background: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.4s ease;
        overflow: hidden;
    }
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(214, 51, 132, 0.15);
    }
    .category-icon-wrapper {
        width: 70px;
        height: 70px;
        margin: 0 auto;
        background: var(--accent-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }
    .category-card:hover .category-icon-wrapper {
        background: var(--main-color);
    }
    .category-card:hover .category-icon-wrapper i {
        color: white !important;
    }

    .section-title {
        font-weight: 800;
        color: var(--text-dark);
        position: relative;
        display: inline-block;
        padding-bottom: 15px;
        margin-bottom: 40px;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: var(--gold-color);
    }

    .feature-box {
        text-align: center;
        padding: 30px;
        border-radius: 10px;
        background: #fff;
        border: 1px solid #eee;
    }
    .feature-box i {
        font-size: 2.5rem;
        color: var(--gold-color);
        margin-bottom: 15px;
        display: block;
    }

    .special-offers {
        background: linear-gradient(135deg, #2c2c2c 0%, #000000 100%);
        position: relative;
    }
    
    .btn-custom {
        background-color: var(--main-color);
        color: white;
        border-radius: 30px;
        padding: 12px 35px;
        font-weight: bold;
        border: none;
        transition: 0.3s;
    }
    .btn-custom:hover {
        background-color: #b02a6b;
        color: white;
        transform: scale(1.05);
    }
</style>

<section class="p-0 mb-5">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
        
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1616683693504-3ea7e9ad6fec?q=80&w=1920&auto=format&fit=crop" class="d-block w-100 hero-image" alt="الحملة الرئيسية">
                <div class="hero-overlay"></div> <div class="carousel-caption d-none d-md-block">
                    <span class="badge bg-white text-dark mb-3 px-3 py-2 rounded-pill fs-6">جديد الموسم 🍂</span>
                    <h1 class="display-3 fw-bold mb-4 text-white">إشراقة جمالك <br> تبدأ من هنا</h1>
                    <p class="lead mb-5 text-white-50">
                        اكتشفي مجموعة مختارة بعناية من أرقى منتجات التجميل والعناية بالبشرة. 
                        لأنك تستحقين الأفضل، وفرنا لكِ الماركات العالمية بين يديك.
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-custom btn-lg shadow">
                         تسوقي الآن <i class="bi bi-arrow-left me-2"></i>
                    </a>
                </div>
            </div>

            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1596462502278-27bfdd403348?q=80&w=1920&auto=format&fit=crop" class="d-block w-100 hero-image" alt="عروض الصيف">
                <div class="hero-overlay" style="background: linear-gradient(90deg, rgba(214, 51, 132, 0.3) 0%, rgba(0,0,0,0.5) 100%);"></div>
                <div class="carousel-caption d-none d-md-block">
                    <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill fs-6">تخفيضات كبرى ⚡</span>
                    <h1 class="display-3 fw-bold mb-4 text-white">تألقي في الصيف <br> بخصم 40%</h1>
                    <p class="lead mb-5 text-white-50">
                        لا تفوتي الفرصة! تسوقي أحدث مجموعات المكياج بأسعار لا تقبل المنافسة. 
                        العرض ساري لفترة محدودة.
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg shadow text-dark fw-bold">
                         اكتشفي العروض <i class="bi bi-arrow-left me-2"></i>
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

<section class="container mb-5">
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="feature-box">
                <i class="bi bi-shield-check"></i>
                <h5>منتجات أصلية 100%</h5>
                <p class="text-muted small mb-0">نضمن لك جودة جميع منتجاتنا</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <i class="bi bi-truck"></i>
                <h5>شحن سريع وآمن</h5>
                <p class="text-muted small mb-0">توصيل لجميع المناطق خلال 24 ساعة</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <i class="bi bi-headset"></i>
                <h5>دعم متواصل</h5>
                <p class="text-muted small mb-0">فريق خدمة عملاء جاهز لمساعدتك</p>
            </div>
        </div>
    </div>
</section>

<section class="categories-section mb-5 py-4 bg-light">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">تسوقي حسب الفئة</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @forelse($mainCategories ?? [] as $mainCategory)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('main-categories.show', $mainCategory->slug) }}" class="text-decoration-none">
                        <div class="card text-center h-100 category-card py-4">
                            <div class="category-icon-wrapper mb-3">
                                @if($mainCategory->icon)
                                    <i class="{{ $mainCategory->icon }} fs-3 text-primary"></i>
                                @elseif($mainCategory->image)
                                    <img src="{{ $mainCategory->image }}" alt="{{ $mainCategory->name }}" class="img-fluid" style="max-width: 50px; max-height: 50px;">
                                @else
                                    <i class="bi bi-palette fs-3 text-primary"></i>
                                @endif
                            </div>
                            <h6 class="card-title text-dark fw-bold m-0">{{ $mainCategory->name }}</h6>
                        </div>
                    </a>
                </div>
            @empty
                {{-- Fallback للبيانات الثابتة إذا لم تكن هناك بيانات من API --}}
                @foreach([
                    ['name' => 'مكياج', 'icon' => 'bi-palette', 'slug' => 'makeup'],
                    ['name' => 'عناية بالبشرة', 'icon' => 'bi-droplet', 'slug' => 'skincare'],
                    ['name' => 'العطور', 'icon' => 'bi-flower1', 'slug' => 'perfumes'],
                    ['name' => 'الشعر', 'icon' => 'bi-scissors', 'slug' => 'hair'],
                    ['name' => 'اكسسوارات', 'icon' => 'bi-handbag', 'slug' => 'accessories'],
                ] as $category)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="text-decoration-none">
                            <div class="card text-center h-100 category-card py-4">
                                <div class="category-icon-wrapper mb-3">
                                    <i class="bi {{ $category['icon'] }} fs-3 text-primary"></i>
                                </div>
                                <h6 class="card-title text-dark fw-bold m-0">{{ $category['name'] }}</h6>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<section class="featured-products mb-5 pt-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h2 class="fw-bold m-0">الأكثر مبيعاً</h2>
                <p class="text-muted m-0">اختيارات عملائنا المفضلة هذا الأسبوع</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark rounded-pill px-4">عرض الكل</a>
        </div>
        
        <div class="row g-4">
            @forelse($featuredProducts ?? [] as $product)
                <div class="col-md-6 col-lg-3">
                    @include('components.product-card', ['product' => $product])
                </div>
            @empty
                {{-- Fallback للبيانات التجريبية إذا لم تكن هناك منتجات من API --}}
                @for($i = 1; $i <= 8; $i++)
                    <div class="col-md-6 col-lg-3">
                        @include('components.product-card', ['product' => (object)[
                            'id' => $i,
                            'name' => 'منتج تجميل فاخر ' . $i,
                            'description' => 'وصف مختصر للمنتج يظهر هنا...',
                            'price' => rand(150, 800),
                            'discount_percentage' => $i % 4 == 0 ? 15 : 0,
                            'is_new' => $i <= 2,
                            'rating' => rand(4, 5),
                            'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdd403348?w=500&h=500&fit=crop&sig=' . $i
                        ]])
                    </div>
                @endfor
            @endforelse
        </div>
    </div>
</section>

<section class="special-offers py-5 mb-5 rounded-3 container overflow-hidden">
    <div class="row align-items-center">
        <div class="col-lg-6 p-5">
            <span class="text-warning text-uppercase letter-spacing-2 fw-bold">عرض محدود</span>
            <h2 class="display-5 text-white fw-bold mt-2 mb-3">مجموعة العناية المسائية</h2>
            <p class="lead text-white-50 mb-4">احصلي على خصم 40% عند شراء المجموعة الكاملة. العرض ساري حتى نفاذ الكمية.</p>
            <div class="d-flex gap-3">
                <a href="#" class="btn btn-light rounded-pill px-4 py-2">تسوقي العرض</a>
            </div>
        </div>
        <div class="col-lg-6 text-center d-none d-lg-block">
            <img src="https://images.unsplash.com/photo-1629198688000-71f23e745b6e?w=600&fit=crop" class="img-fluid rounded-circle border border-4 border-light shadow-lg" alt="Special Offer" style="max-height: 400px; object-fit: cover;">
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // لا حاجة لكود JS إضافي لتشغيل الـ Carousel
    // خاصية data-bs-ride="carousel" في HTML تقوم بالمهمة.
    
    // إضافة تأثير بسيط عند إضافة المنتج للسلة
    document.addEventListener('click', function(e) {
        if (e.target.closest('.add-to-cart')) {
            const btn = e.target.closest('.add-to-cart');
            const originalHtml = btn.innerHTML;
            
            btn.innerHTML = '<i class="bi bi-check2"></i> ';
            btn.classList.add('btn-success');
            btn.classList.remove('btn-primary');
            
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-primary');
            }, 2000);
        }
    });
</script>
@endpush