@props(['product'])

@php
    // تجهيز البيانات لتقليل المنطق داخل الـ View
    $price = $product->price ?? 0;
    // دعم discount_percentage من Model أو discount من البيانات الثابتة
    $discount = $product->discount_percentage ?? ($product->discount ?? 0);
    $hasDiscount = $discount > 0;
    // استخدام finalPrice من Model إذا كان موجوداً، وإلا حسابها
    $finalPrice = isset($product->final_price) ? $product->final_price : ($hasDiscount ? $price * (1 - ($discount / 100)) : $price);
    // استخدام image من Model (getImageAttribute) أو من البيانات الثابتة
    $image = is_object($product) && method_exists($product, 'getImageAttribute') ? $product->image : ($product->image ?? 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=300&h=300&fit=crop');
@endphp

<div class="card product-card-pro border-0 rounded-4 overflow-hidden h-100">
    <div class="product-image-wrapper position-relative">
        <img src="{{ $image }}" 
             class="card-img-top product-img" 
             alt="{{ $product->name }}">
        
        <div class="product-badges position-absolute top-0 start-0 p-3 d-flex flex-column gap-2">
            @if($hasDiscount)
                <span class="badge bg-danger rounded-pill shadow-sm">
                    -{{ number_format($discount) }}%
                </span>
            @endif
            @if(isset($product->is_new) && $product->is_new)
                <span class="badge bg-success rounded-pill shadow-sm">
                    جديد
                </span>
            @endif
            @if(isset($product->is_featured) && $product->is_featured)
                <span class="badge bg-warning rounded-pill shadow-sm">
                    مميز
                </span>
            @endif
        </div>

        <div class="product-actions position-absolute top-50 start-50 translate-middle d-flex gap-2">
            @php
                // بناء رابط المنتج بناءً على الهيكلية الجديدة
                $productUrl = '#';
                
                // محاولة بناء الرابط من العلاقات
                if (isset($product->slug)) {
                    $type = $product->type ?? null;
                    $section = null;
                    $mainCategory = null;
                    
                    if ($type) {
                        $section = $type->section ?? null;
                        if ($section) {
                            $mainCategory = $section->mainCategory ?? null;
                        }
                    }
                    
                    // إذا لم تكن العلاقات محملة، جرب من المنتج مباشرة
                    if (!$section && isset($product->section)) {
                        $section = $product->section;
                    }
                    if (!$mainCategory && isset($product->mainCategory)) {
                        $mainCategory = $product->mainCategory;
                    }
                    
                    // بناء الرابط الكامل إذا كانت جميع البيانات متوفرة
                    if ($mainCategory && $section && $type && isset($mainCategory->slug) && isset($section->slug) && isset($type->slug)) {
                        try {
                            $productUrl = route('products.show', [
                                'mainCategorySlug' => $mainCategory->slug,
                                'sectionSlug' => $section->slug,
                                'typeSlug' => $type->slug,
                                'productSlug' => $product->slug
                            ]);
                        } catch (\Exception $e) {
                            // Fallback للرابط البسيط
                            $productUrl = route('products.show.simple', ['slug' => $product->slug]);
                        }
                    } else {
                        // استخدام الرابط البسيط إذا لم تكن العلاقات كاملة
                        $productUrl = route('products.show.simple', ['slug' => $product->slug]);
                    }
                } elseif (isset($product->id)) {
                    // Fallback للبيانات القديمة
                    $productUrl = route('products.index') . '?product=' . $product->id;
                }
            @endphp
            <a href="{{ $productUrl }}" 
               class="btn btn-light rounded-circle shadow-sm action-btn" 
               title="عرض التفاصيل"
               data-bs-toggle="tooltip">
                <i class="bi bi-eye"></i>
            </a>
            <button class="btn btn-light rounded-circle shadow-sm action-btn add-to-cart" 
                    data-product-id="{{ $product->id ?? 1 }}"
                    title="إضافة للسلة">
                <i class="bi bi-bag-plus"></i>
            </button>
        </div>
    </div>

    <div class="card-body d-flex flex-column p-3">
        <small class="text-muted mb-1">{{ $product->type->name ?? ($product->section->name ?? 'عام') }}</small>
        
        <h6 class="card-title fw-bold text-dark mb-2 text-truncate">
            {{-- استخدام نفس $productUrl من الأعلى --}}
            <a href="{{ $productUrl }}" class="text-decoration-none text-dark stretched-link">
                {{ $product->name ?? 'اسم المنتج' }}
            </a>
        </h6>

        @if(isset($product->rating))
        <div class="mb-2 fs-7">
            @for($i = 1; $i <= 5; $i++)
                <i class="bi bi-star{{ $i <= $product->rating ? '-fill' : '' }} text-warning"></i>
            @endfor
            <span class="text-muted ms-1 small">({{ $product->reviews_count ?? 0 }})</span>
        </div>
        @endif

        <div class="mt-auto d-flex align-items-center justify-content-between">
            <div class="price-wrapper">
                @if($hasDiscount)
                    <span class="text-danger fw-bolder fs-5">{{ number_format($finalPrice, 2) }} ₪</span>
                    <small class="text-muted text-decoration-line-through ms-1">{{ number_format($price, 2) }} ₪</small>
                @else
                    <span class="fw-bolder fs-5 text-dark">{{ number_format($price, 2) }} ₪</span>
                @endif
            </div>
            
            <button class="btn btn-sm btn-outline-primary rounded-pill d-md-none z-index-2 position-relative">
                شراء
            </button>
        </div>
    </div>
</div>

{{-- CSS مخصص لهذا الكومبوننت --}}
<style>
    .product-card-pro {
        background: #fff;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }

    .product-card-pro:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    /* تنسيق الصورة */
    .product-image-wrapper {
        height: 260px;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card-pro:hover .product-img {
        transform: scale(1.1); /* تأثير الزوم */
    }

    /* أزرار الإجراءات */
    .product-actions {
        opacity: 0;
        visibility: hidden;
        transform: translate(-50%, -40%); /* يبدأ من أعلى قليلاً */
        transition: all 0.3s ease;
        z-index: 2;
    }

    .product-card-pro:hover .product-actions {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%);
    }

    .action-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
    }

    .action-btn:hover {
        background-color: #0d6efd; /* لون البراند الأساسي */
        color: white;
    }

    /* رابط الكارد الكامل لا يجب أن يغطي أزرار الإجراءات */
    .stretched-link::after {
        z-index: 1;
    }
    
    .product-actions, .product-badges {
        z-index: 2; /* التأكد من أن الأزرار فوق الرابط */
    }
</style>