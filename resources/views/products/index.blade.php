@extends('layouts.app')

@section('title', 'جميع المنتجات - متجر المكياج')

@section('content')
<div class="container py-5">
    <h1 class="mb-5 text-center">جميع المنتجات</h1>
    
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-funnel"></i> الفلتر</h5>
                </div>
                <div class="card-body">
                    <!-- Price Filter -->
                    <div class="mb-4">
                        <h6>السعر</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="price1">
                            <label class="form-check-label" for="price1">أقل من 100 ₪</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="price2">
                            <label class="form-check-label" for="price2">100 - 200 ₪</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="price3">
                            <label class="form-check-label" for="price3">200 - 300 ₪</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="price4">
                            <label class="form-check-label" for="price4">أكثر من 300 ₪</label>
                        </div>
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="mb-4">
                        <h6>النوع</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cat1">
                            <label class="form-check-label" for="cat1">أحمر الشفاه</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cat2">
                            <label class="form-check-label" for="cat2">ماسكارا</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cat3">
                            <label class="form-check-label" for="cat3">أحمر الخدود</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cat4">
                            <label class="form-check-label" for="cat4">أساس</label>
                        </div>
                    </div>
                    
                    <!-- Brand Filter -->
                    <div class="mb-4">
                        <h6>الماركة</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brand1">
                            <label class="form-check-label" for="brand1">ماركة A</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brand2">
                            <label class="form-check-label" for="brand2">ماركة B</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="brand3">
                            <label class="form-check-label" for="brand3">ماركة C</label>
                        </div>
                    </div>
                    
                    <!-- Rating Filter -->
                    <div class="mb-4">
                        <h6>التقييم</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rating5">
                            <label class="form-check-label" for="rating5">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rating4">
                            <label class="form-check-label" for="rating4">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star text-warning"></i>
                            </label>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary w-100">تطبيق الفلتر</button>
                    <button class="btn btn-outline-secondary w-100 mt-2">إعادة تعيين</button>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="mb-0">عرض <strong>24</strong> منتج من أصل <strong>156</strong></p>
                <select class="form-select" style="width: auto;">
                    <option>عرض 24</option>
                    <option>عرض 48</option>
                    <option>عرض 96</option>
                </select>
            </div>
            
            <div class="row g-4">
                @for($i = 1; $i <= 24; $i++)
                    <div class="col-md-6 col-lg-4">
                        @include('components.product-card', ['product' => (object)[
                            'id' => $i,
                            'name' => 'منتج المكياج ' . $i,
                            'description' => 'وصف المنتج المميز',
                            'price' => rand(50, 500),
                            'discount' => $i % 5 == 0 ? 25 : 0,
                            'is_new' => $i <= 5,
                            'rating' => rand(3, 5),
                            'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=300&h=300&fit=crop&sig=' . $i
                        ]])
                    </div>
                @endfor
            </div>
            
            <nav aria-label="Page navigation" class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">السابق</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">التالي</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

