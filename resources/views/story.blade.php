@extends('layouts.app')

@section('title', 'قصتنا - متجر المكياج')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 mb-3">قصتنا</h1>
        <p class="lead text-muted">رحلة بدأت بحلم</p>
    </div>
    
    <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h2 class="mb-4">البداية</h2>
                    <p class="lead">
                        بدأت قصتنا في عام 2020 عندما قررنا إنشاء متجر مكياج يوفر للمرأة العربية 
                        أفضل منتجات المكياج والعناية بالبشرة من جميع أنحاء العالم.
                    </p>
                    <p>
                        كنا نؤمن بأن كل امرأة تستحق الوصول إلى منتجات عالية الجودة تساعدها على 
                        إبراز جمالها الطبيعي والثقة بنفسها. ومن هنا بدأت رحلتنا.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h2 class="mb-4">النمو والتطور</h2>
                    <p>
                        على مر السنين، نمينا من متجر صغير إلى منصة رائدة في مجال المكياج والعناية بالبشرة. 
                        تعاونا مع أشهر الماركات العالمية لنوفر لعملائنا مجموعة واسعة من المنتجات.
                    </p>
                    <p>
                        اليوم، نخدم آلاف العملاء في جميع أنحاء المملكة العربية السعودية، ونواصل التوسع 
                        لتقديم أفضل تجربة تسوق ممكنة.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h2 class="mb-4">قيمنا</h2>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-heart-fill text-primary fs-3 me-3"></i>
                                <div>
                                    <h5>الشغف</h5>
                                    <p class="text-muted">نحن شغوفون بمساعدة عملائنا على إبراز جمالهم</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-shield-check-fill text-primary fs-3 me-3"></i>
                                <div>
                                    <h5>الجودة</h5>
                                    <p class="text-muted">نضمن جودة وأصالة جميع منتجاتنا</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-people-fill text-primary fs-3 me-3"></i>
                                <div>
                                    <h5>خدمة العملاء</h5>
                                    <p class="text-muted">عملاؤنا هم أولويتنا الأولى</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-lightbulb-fill text-primary fs-3 me-3"></i>
                                <div>
                                    <h5>الابتكار</h5>
                                    <p class="text-muted">نواصل التطوير والتحسين المستمر</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body p-5 text-center">
                    <h2 class="mb-4">المستقبل</h2>
                    <p class="lead mb-4">
                        نحن متحمسون للمستقبل ونتطلع إلى مواصلة خدمة عملائنا وتوسيع نطاق منتجاتنا 
                        وخدماتنا. هدفنا هو أن نكون الوجهة الأولى لكل عاشقة للمكياج والعناية بالبشرة.
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-arrow-left"></i> ابدأي التسوق الآن
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

