@extends('layouts.app')

@section('title', 'تواصل معنا - متجر المكياج')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 mb-3">تواصل معنا</h1>
        <p class="lead text-muted">نحن هنا لمساعدتك في أي وقت</p>
    </div>
    
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="mb-4">أرسل لنا رسالة</h3>
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الاسم</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الموضوع</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الرسالة</label>
                            <textarea class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> إرسال الرسالة
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-4"><i class="bi bi-geo-alt-fill text-primary"></i> العنوان</h5>
                    <p class="mb-0">
                        شارع الملك فهد<br>
                        حي النخيل<br>
                        الرياض، المملكة العربية السعودية<br>
                        الرمز البريدي: 12345
                    </p>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-4"><i class="bi bi-telephone-fill text-primary"></i> الهاتف</h5>
                    <p class="mb-0">
                        <a href="tel:+966501234567" class="text-decoration-none">+966 50 123 4567</a><br>
                        <a href="tel:+966112345678" class="text-decoration-none">+966 11 234 5678</a>
                    </p>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-4"><i class="bi bi-envelope-fill text-primary"></i> البريد الإلكتروني</h5>
                    <p class="mb-0">
                        <a href="mailto:info@makeupstore.com" class="text-decoration-none">info@makeupstore.com</a><br>
                        <a href="mailto:support@makeupstore.com" class="text-decoration-none">support@makeupstore.com</a>
                    </p>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-4"><i class="bi bi-clock-fill text-primary"></i> ساعات العمل</h5>
                    <p class="mb-1"><strong>الأحد - الخميس:</strong></p>
                    <p class="mb-3">9:00 صباحًا - 10:00 مساءً</p>
                    <p class="mb-1"><strong>الجمعة - السبت:</strong></p>
                    <p class="mb-0">2:00 ظهرًا - 10:00 مساءً</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center mb-4">تابعنا على وسائل التواصل الاجتماعي</h3>
                    <div class="d-flex justify-content-center gap-4">
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-facebook fs-1 text-primary"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-instagram fs-1 text-danger"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-twitter fs-1 text-info"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-youtube fs-1 text-danger"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

