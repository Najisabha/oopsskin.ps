@extends('layouts.app')

@section('title', (property_exists($product, 'name') ? $product->name : 'تفاصيل المنتج'))

@section('content')
<div class="product-details-page py-5">
    <div class="container-xl">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb border-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">الرئيسية</a></li>
                @if(isset($product) && is_object($product) && property_exists($product, 'type') && $product->type && isset($product->type->section) && isset($product->type->section->mainCategory))
                    <li class="breadcrumb-item"><a href="{{ route('main-categories.show', $product->type->section->mainCategory->slug) }}" class="text-muted text-decoration-none">{{ $product->type->section->mainCategory->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sections.show', ['mainCategorySlug' => $product->type->section->mainCategory->slug, 'sectionSlug' => $product->type->section->slug]) }}" class="text-muted text-decoration-none">{{ $product->type->section->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('categories.show', ['mainCategorySlug' => $product->type->section->mainCategory->slug, 'sectionSlug' => $product->type->section->slug, 'typeSlug' => $product->type->slug]) }}" class="text-muted text-decoration-none">{{ $product->type->name }}</a></li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-muted text-decoration-none">المنتجات</a></li>
                @endif
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">{{ property_exists($product, 'name') ? $product->name : 'تفاصيل المنتج' }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    @php
                        // استخدام صور المنتج من Model أو صور تجريبية واقعية
                        if (isset($product) && property_exists($product, 'images') && $product->images) {
                            $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                            if (empty($images)) {
                                // إذا كانت الصور فارغة، استخدم الصورة الرئيسية
                                $images = [property_exists($product, 'image') && $product->image ? $product->image : 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=800&h=800&fit=crop&q=80'];
                            }
                        } else {
                            // صور تجريبية واقعية للمكياج
                            $mainImage = property_exists($product, 'image') && $product->image ? $product->image : 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=800&h=800&fit=crop&q=80';
                            $productImages = [
                                $mainImage,
                                'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=800&h=800&fit=crop&q=80',
                                'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=800&h=800&fit=crop&q=80',
                                'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=800&h=800&fit=crop&q=80',
                                'https://images.unsplash.com/photo-1622618990740-ce57d7f904d4?w=800&h=800&fit=crop&q=80'
                            ];
                            $images = $productImages;
                        }
                    @endphp
                    <div class="main-image-wrapper position-relative rounded-4 bg-white" style="overflow: visible;">
                        @if(isset($product) && property_exists($product, 'discount_percentage') && $product->discount_percentage > 0)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3 py-2 px-3 rounded-pill z-3">خصم {{ $product->discount_percentage }}%</span>
                        @elseif(isset($product) && property_exists($product, 'is_new') && $product->is_new)
                            <span class="badge bg-success position-absolute top-0 start-0 m-3 py-2 px-3 rounded-pill z-3">جديد</span>
                        @endif
                        
                        <div id="productImageCarousel" class="carousel slide" data-bs-ride="false">
                            <div class="carousel-inner">
                                @foreach($images as $key => $img)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ $img }}" 
                                             class="d-block w-100 img-fluid" 
                                             alt="{{ property_exists($product, 'name') ? $product->name : 'Product' }} - {{ $key + 1 }}" 
                                             style="height: 600px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            @if(count($images) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mt-4 p-4">
                    <ul class="nav nav-pills nav-fill mb-4 rounded-pill" id="productTabs" role="tablist" style="padding: 0 !important; margin-bottom: 1rem !important; background: transparent !important; background-color: transparent !important;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill" data-bs-toggle="pill" data-bs-target="#desc">الوصف</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill" data-bs-toggle="pill" data-bs-target="#specs">المواصفات</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill" data-bs-toggle="pill" data-bs-target="#reviews">التقييمات (120)</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="productTabsContent">
                        <div class="tab-pane fade show active" id="desc">
                            <h5 class="fw-bold mb-3">تفاصيل المنتج</h5>
                            <p class="text-muted leading-relaxed">
                                @if(property_exists($product, 'description') && $product->description)
                                    {{ $product->description }}
                                @elseif(property_exists($product, 'short_description') && $product->short_description)
                                    {{ $product->short_description }}
                                @else
                                    استمتعي بإطلالة ساحرة مع هذا المنتج. تركيبة فريدة تدوم طويلاً، غنية بالفيتامينات التي تغذي بشرتك وتمنحها مظهراً ممتلئاً وجذاباً. متوفر بعدة ألوان تناسب جميع الأذواق والمناسبات.
                                @endif
                            </p>
                            <ul class="list-unstyled text-muted small">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> ثبات يدوم حتى 12 ساعة.</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> مقاوم للماء والتلطخ.</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> خالي من البارابين.</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> مناسب لجميع أنواع البشرة.</li>
                            </ul>
                        </div>
                        
                        <div class="tab-pane fade" id="specs">
                            <table class="table table-borderless table-striped small">
                                <tbody>
                                    <tr><td class="text-muted w-25">الماركة</td><td class="fw-bold">L'Oreal Paris</td></tr>
                                    <tr><td class="text-muted">نوع المنتج</td><td class="fw-bold">أحمر شفاه سائل</td></tr>
                                    <tr><td class="text-muted">اللمسة النهائية</td><td class="fw-bold">مات (Matte)</td></tr>
                                    <tr><td class="text-muted">الحجم</td><td class="fw-bold">5 مل</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="reviews">
                            <div class="d-flex align-items-center mb-4">
                                <h1 class="fw-bold m-0 me-3">{{ isset($product) && property_exists($product, 'rating') && $product->rating ? number_format($product->rating, 1) : '4.5' }}</h1>
                                <div>
                                    <div class="text-warning small mb-1">
                                        @php
                                            $rating = isset($product) && property_exists($product, 'rating') && $product->rating ? $product->rating : 4.5;
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= round($rating) ? '-fill' : ($i <= $rating + 0.5 ? '-half' : '') }}"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">بناءً على {{ isset($product) && property_exists($product, 'reviews_count') && $product->reviews_count ? $product->reviews_count : '120' }} تقييم</small>
                                </div>
                            </div>
                            <div class="review-item border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold">سارة أحمد</h6>
                                    <small class="text-muted">منذ يومين</small>
                                </div>
                                <div class="text-warning small mb-2">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                </div>
                                <p class="text-muted small">اللون رائع جداً وثابت، أنصح به بشدة!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="sticky-top" style="top: 20px; z-index: 10;">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <small class="text-uppercase text-primary fw-bold mb-2 d-block">
                                @if(isset($product->type) && is_object($product->type) && property_exists($product->type, 'name'))
                                    {{ $product->type->name }}
                                @elseif(isset($product->section) && is_object($product->section) && property_exists($product->section, 'name'))
                                    {{ $product->section->name }}
                                @else
                                    منتج
                                @endif
                            </small>
                            <button class="btn btn-light rounded-circle btn-sm p-2 text-danger"><i class="bi bi-heart-fill"></i></button>
                        </div>
                        
                        <h2 class="fw-bold mb-2">{{ property_exists($product, 'name') ? $product->name : 'أحمر الشفاه فيلفت مات' }}</h2>
                        
                        <div class="d-flex align-items-center gap-2 mb-3">
                            @if(isset($product) && property_exists($product, 'rating') && $product->rating)
                                <div class="text-warning small">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= round($product->rating) ? '-fill' : ($i <= $product->rating + 0.5 ? '-half' : '') }}"></i>
                                    @endfor
                                </div>
                                <span class="text-muted small">({{ number_format($product->rating, 1) }} تقييم - {{ property_exists($product, 'reviews_count') ? $product->reviews_count : 0 }} مراجعة)</span>
                            @else
                                <div class="text-warning small">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                                </div>
                                <span class="text-muted small">(4.5 تقييم)</span>
                            @endif
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            @php
                                $price = property_exists($product, 'price') ? $product->price : 200;
                                $discount = property_exists($product, 'discount_percentage') ? $product->discount_percentage : (property_exists($product, 'discount') ? $product->discount : 0);
                                $finalPrice = $discount > 0 ? $price * (1 - ($discount / 100)) : $price;
                            @endphp
                            <h3 class="fw-bold text-dark m-0">{{ number_format($finalPrice, 2) }} ₪</h3>
                            @if($discount > 0)
                                <span class="text-decoration-line-through text-muted fs-5">{{ number_format($price, 2) }} ₪</span>
                            @endif
                        </div>

                        <form action="#" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="fw-bold small mb-2">اختر الدرجة:</label>
                                <div class="d-flex gap-2">
                                    <div class="color-selector">
                                        <input type="radio" name="color_id" id="color1" value="1" checked>
                                        <label for="color1" style="background-color: #d63384;" title="وردي"></label>
                                    </div>
                                    <div class="color-selector">
                                        <input type="radio" name="color_id" id="color2" value="2">
                                        <label for="color2" style="background-color: #dc3545;" title="أحمر"></label>
                                    </div>
                                    <div class="color-selector">
                                        <input type="radio" name="color_id" id="color3" value="3">
                                        <label for="color3" style="background-color: #795548;" title="بني"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-2 mb-4">
                                <div class="col-4">
                                    <div class="input-group input-group-lg border rounded-3 overflow-hidden">
                                        <button class="btn btn-light border-0" type="button" onclick="updateQty(-1)">-</button>
                                        <input type="number" name="quantity" id="qtyInput" class="form-control text-center border-0 bg-light p-0" value="1" min="1" readonly>
                                        <button class="btn btn-light border-0" type="button" onclick="updateQty(1)">+</button>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <button type="submit" class="btn btn-dark w-100 btn-lg rounded-3">
                                        إضافة للسلة <i class="bi bi-cart2 ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="row text-center mt-3 g-2">
                            <div class="col-4">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-truck fs-4 text-primary"></i>
                                    <div class="small fw-bold mt-1" style="font-size: 10px;">شحن سريع</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-shield-check fs-4 text-primary"></i>
                                    <div class="small fw-bold mt-1" style="font-size: 10px;">منتج أصلي</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 bg-light rounded-3">
                                    <i class="bi bi-arrow-repeat fs-4 text-primary"></i>
                                    <div class="small fw-bold mt-1" style="font-size: 10px;">استرجاع سهل</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="container-xl mt-5">
        <h3 class="fw-bold mb-4">منتجات مشابهة</h3>
        <div class="row g-3 g-md-4">
            @foreach($relatedProducts as $relatedProduct)
                <div class="col-6 col-md-6 col-lg-3">
                    @include('components.product-card', ['product' => $relatedProduct])
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- Custom CSS --}}
@push('styles')
<style>
    
    /* تنسيق carousel الصور الرئيسية */
    #productImageCarousel {
        border-radius: 1rem;
        overflow: visible !important;
        position: relative !important;
    }
    body #productImageCarousel .carousel-control-prev,
    body #productImageCarousel .carousel-control-next {
        width: 50px !important;
        height: 50px !important;
        top: 50% !important;
        left: auto !important;
        right: auto !important;
        transform: translateY(-50%) !important;
        background-color: #d63384 !important;
        background: #d63384 !important;
        border-radius: 50% !important;
        opacity: 1 !important;
        transition: all 0.3s ease !important;
        border: none !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2) !important;
        z-index: 10 !important;
    }
    body #productImageCarousel .carousel-control-prev {
        right: 20px !important;
        left: auto !important;
    }
    body #productImageCarousel .carousel-control-next {
        left: 20px !important;
        right: auto !important;
    }
    body #productImageCarousel .carousel-control-prev:hover,
    body #productImageCarousel .carousel-control-next:hover {
        background-color: #c02669 !important;
        background: #c02669 !important;
        transform: translateY(-50%) scale(1.1) !important;
        box-shadow: 0 4px 12px rgba(214, 51, 132, 0.4) !important;
    }
    body #productImageCarousel .carousel-control-prev-icon {
        width: 24px !important;
        height: 24px !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
        background-size: 24px 24px !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        filter: none !important;
        opacity: 1 !important;
    }
    body #productImageCarousel .carousel-control-next-icon {
        width: 24px !important;
        height: 24px !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e") !important;
        background-size: 24px 24px !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        filter: none !important;
        opacity: 1 !important;
    }
    .main-image-wrapper {
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: zoom-in;
        background: #f8f9fa;
        overflow: visible !important;
    }
    .main-image-wrapper .carousel-inner {
        border-radius: 1rem;
        overflow: hidden;
    }
    
    /* تنسيق اختيار الألوان */
    .color-selector input[type="radio"] {
        display: none;
    }
    .color-selector label {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px #dee2e6;
        transition: transform 0.2s;
        position: relative;
    }
    .color-selector input[type="radio"]:checked + label {
        transform: scale(1.1);
        box-shadow: 0 0 0 2px #000; /* حلقة سوداء حول اللون المختار */
    }
    .color-selector input[type="radio"]:checked + label::after {
        content: '\F26E'; /* علامة صح Bootstrap Icon */
        font-family: 'bootstrap-icons';
        color: #fff;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 14px;
        text-shadow: 0 0 2px rgba(0,0,0,0.5);
    }

    /* التبويبات */
    ul#productTabs.nav-pills {
        background: transparent !important;
        background-color: transparent !important;
        padding: 0 !important;
        margin-bottom: 1rem !important;
    }
    ul#productTabs.nav-pills::before,
    ul#productTabs.nav-pills::after {
        display: none !important;
    }
    #productTabs .nav-item {
        background: transparent !important;
        background-color: transparent !important;
    }
    #productTabs .nav-link {
        color: #6c757d !important;
        font-weight: 500;
        background: transparent !important;
        background-color: transparent !important;
    }
    #productTabs .nav-link.active {
        background-color: #fce4ec !important;
        background: #fce4ec !important;
        color: #d63384 !important;
    }
    
    /* عام */
    .cursor-pointer { cursor: pointer; }
</style>
@endpush

{{-- Scripts --}}
@push('scripts')
<script>
    function updateQty(change) {
        const input = document.getElementById('qtyInput');
        let newVal = parseInt(input.value) + change;
        if(newVal < 1) newVal = 1;
        input.value = newVal;
    }
</script>
@endpush

@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<div class="container-xl mt-5 py-5">
        <h3 class="fw-bold mb-4">منتجات مشابهة</h3>
        <div class="row g-3 g-md-4">
            @foreach($relatedProducts as $relatedProduct)
                <div class="col-6 col-md-6 col-lg-3">
                    @include('components.product-card', ['product' => $relatedProduct])
                </div>
            @endforeach
        </div>
</div>
@endif

@endsection