@extends('layouts.app')

@section('title', 'من نحن - متجر المكياج')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 mb-3">من نحن</h1>
        <p class="lead text-muted">نحن متجر المكياج الرائد في المنطقة</p>
    </div>
    
    <div class="row mb-5">
        <div class="col-lg-6">
            <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=600&h=400&fit=crop" class="img-fluid rounded shadow" alt="About Us">
        </div>
        <div class="col-lg-6">
            <h2 class="mb-4">رؤيتنا</h2>
            <p class="lead">
                نسعى لأن نكون الوجهة الأولى لعشاق المكياج والعناية بالبشرة في المنطقة، 
                من خلال توفير أفضل المنتجات من أشهر الماركات العالمية.
            </p>
            <p>
                نحن نؤمن بأن الجمال يبدأ من الداخل، ونساعد عملائنا على إبراز جمالهم الطبيعي 
                من خلال منتجات عالية الجودة وخدمة عملاء متميزة.
            </p>
        </div>
    </div>
    
    <div class="row mb-5">
        <div class="col-lg-6 order-lg-2">
            <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600&h=400&fit=crop" class="img-fluid rounded shadow" alt="Mission">
        </div>
        <div class="col-lg-6 order-lg-1">
            <h2 class="mb-4">مهمتنا</h2>
            <ul class="list-unstyled">
                <li class="mb-3">
                    <i class="bi bi-check-circle-fill text-primary me-2"></i>
                    توفير منتجات مكياج عالية الجودة من أشهر الماركات العالمية
                </li>
                <li class="mb-3">
                    <i class="bi bi-check-circle-fill text-primary me-2"></i>
                    تقديم خدمة عملاء متميزة ومساعدة العملاء في اختيار المنتجات المناسبة
                </li>
                <li class="mb-3">
                    <i class="bi bi-check-circle-fill text-primary me-2"></i>
                    ضمان جودة المنتجات وأصالتها
                </li>
                <li class="mb-3">
                    <i class="bi bi-check-circle-fill text-primary me-2"></i>
                    توفير تجربة تسوق ممتعة وسهلة
                </li>
            </ul>
        </div>
    </div>
    
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-award fs-1 text-primary mb-3"></i>
                    <h5>جودة عالية</h5>
                    <p class="text-muted">منتجات أصلية من أشهر الماركات العالمية</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-truck fs-1 text-primary mb-3"></i>
                    <h5>شحن سريع</h5>
                    <p class="text-muted">توصيل سريع وآمن لجميع أنحاء المملكة</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-headset fs-1 text-primary mb-3"></i>
                    <h5>دعم 24/7</h5>
                    <p class="text-muted">فريق دعم متاح على مدار الساعة لمساعدتك</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center">
        <h2 class="mb-4">انضمي إلينا</h2>
        <p class="lead mb-4">كوني جزءًا من مجتمع عشاق المكياج</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">
            <i class="bi bi-person-plus"></i> إنشاء حساب
        </a>
        <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg">
            <i class="bi bi-envelope"></i> تواصل معنا
        </a>
    </div>
</div>
@endsection

