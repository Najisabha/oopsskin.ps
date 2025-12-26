@extends('layouts.app')

@section('title', $product->name ?? 'تفاصيل المنتج')

@section('content')
<div class="product-details-page py-5 bg-light">
    <div class="container-xl">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb border-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-muted text-decoration-none">المكياج</a></li>
                <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">{{ $product->name ?? 'أحمر الشفاه المميز' }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <div class="row g-2">
                        <div class="col-md-2 order-2 order-md-1">
                            <div class="d-flex flex-md-column gap-2 overflow-auto custom-scrollbar h-100" style="max-height: 500px;">
                                @php
                                    $images = [
                                        'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=600&h=600&fit=crop',
                                        'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=600&h=600&fit=crop',
                                        'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600&h=600&fit=crop',
                                        'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=600&h=600&fit=crop'
                                    ];
                                @endphp
                                @foreach($images as $key => $img)
                                    <img src="{{ $img }}" 
                                         class="img-fluid rounded-3 cursor-pointer thumbnail-img {{ $key == 0 ? 'active-thumb' : '' }}" 
                                         alt="View {{ $key }}"
                                         onclick="changeImage(this.src, this)">
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="col-md-10 order-1 order-md-2">
                            <div class="main-image-wrapper position-relative rounded-4 overflow-hidden bg-white">
                                <span class="badge bg-danger position-absolute top-0 start-0 m-3 py-2 px-3 rounded-pill z-2">خصم 20%</span>
                                <img src="{{ $images[0] }}" class="img-fluid w-100 object-fit-cover" id="mainImage" alt="Main Product">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mt-4 p-4">
                    <ul class="nav nav-pills nav-fill mb-4 p-1 bg-light rounded-pill" id="productTabs" role="tablist">
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
                                استمتعي بإطلالة ساحرة مع أحمر الشفاه هذا. تركيبة فريدة تدوم طويلاً، غنية بالفيتامينات التي تغذي شفتيك وتمنحها مظهراً ممتلئاً وجذاباً. متوفر بعدة ألوان تناسب جميع الأذواق والمناسبات.
                            </p>
                            <ul class="list-unstyled text-muted small">
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> ثبات يدوم حتى 12 ساعة.</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> مقاوم للماء والتلطخ.</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> خالي من البارابين.</li>
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
                                <h1 class="fw-bold m-0 me-3">4.5</h1>
                                <div>
                                    <div class="text-warning small mb-1">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                                    </div>
                                    <small class="text-muted">بناءً على 120 تقييم</small>
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
                            <small class="text-uppercase text-primary fw-bold mb-2 d-block">مكياج شفاه</small>
                            <button class="btn btn-light rounded-circle btn-sm p-2 text-danger"><i class="bi bi-heart-fill"></i></button>
                        </div>
                        
                        <h2 class="fw-bold mb-2">أحمر الشفاه فيلفت مات</h2>
                        
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="text-warning small">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                            </div>
                            <span class="text-muted small">(4.5 تقييم)</span>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <h3 class="fw-bold text-dark m-0">200 ₪</h3>
                            <span class="text-decoration-line-through text-muted fs-5">250 ₪</span>
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
</div>

{{-- Custom CSS --}}
@push('css')
<style>
    /* تنسيق الصور */
    .thumbnail-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        opacity: 0.6;
        transition: all 0.2s;
        border: 2px solid transparent;
    }
    .thumbnail-img:hover, .thumbnail-img.active-thumb {
        opacity: 1;
        border-color: #000;
    }
    .main-image-wrapper {
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: zoom-in;
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
    .nav-pills .nav-link {
        color: #6c757d;
        font-weight: 500;
    }
    .nav-pills .nav-link.active {
        background-color: #000;
        color: #fff;
    }
    
    /* عام */
    .cursor-pointer { cursor: pointer; }
</style>
@endpush

{{-- Scripts --}}
@push('scripts')
<script>
    function changeImage(src, element) {
        // تغيير الصورة الرئيسية مع تأثير ناعم
        const mainImg = document.getElementById('mainImage');
        mainImg.style.opacity = 0;
        
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = 1;
        }, 150);

        // تحديث حالة الـ Active للمصغرات
        document.querySelectorAll('.thumbnail-img').forEach(img => img.classList.remove('active-thumb'));
        element.classList.add('active-thumb');
    }

    function updateQty(change) {
        const input = document.getElementById('qtyInput');
        let newVal = parseInt(input.value) + change;
        if(newVal < 1) newVal = 1;
        input.value = newVal;
    }
</script>
@endpush

@endsection