@extends('layouts.app')

@section('title', 'إنشاء حساب - متجر المكياج')

@section('content')

<style>
    :root {
        --main-color: #d63384;
        --input-focus-border: #f8d7da;
    }

    .register-container {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .register-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 0 50px rgba(0,0,0,0.08);
    }

    /* قسم الصورة الجانبية - قمت بتغيير الصورة لتناسب سياق "البداية الجديدة" */
    .register-image-side {
        background: url('https://images.unsplash.com/photo-1522335789203-abd6523f7216?q=80&w=1000&auto=format&fit=crop') no-repeat center center;
        background-size: cover;
        position: relative;
        min-height: 700px;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(214, 51, 132, 0.4), rgba(0,0,0,0.3));
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
        color: white;
    }

    /* تنسيق الحقول */
    .form-control {
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #eee;
        background-color: #fcfcfc;
    }
    .form-control:focus {
        border-color: var(--main-color);
        box-shadow: 0 0 0 0.25rem rgba(214, 51, 132, 0.15);
        background-color: #fff;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #eee;
        color: #6c757d;
    }

    .btn-register {
        background-color: var(--main-color);
        color: white;
        padding: 12px;
        border-radius: 10px;
        font-weight: bold;
        transition: all 0.3s;
        border: none;
    }
    .btn-register:hover {
        background-color: #b02a6b;
        transform: translateY(-2px);
        color: white;
    }

    .social-btn {
        border: 1px solid #eee;
        background: white;
        padding: 10px;
        border-radius: 10px;
        color: #555;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
    }
    .social-btn:hover {
        background: #f8f9fa;
        border-color: #ddd;
    }
</style>

<div class="container register-container py-5">
    <div class="row w-100 justify-content-center">
        <div class="col-lg-11">
            <div class="card register-card">
                <div class="row g-0">
                    
                    <div class="col-lg-5 d-none d-lg-block register-image-side order-lg-last">
                        <div class="image-overlay">
                            <h2 class="display-6 fw-bold mb-3">انضمي لعالم الجمال</h2>
                            <p class="lead mb-4 fs-6">أنشئي حسابك الآن واحصلي على نقاط مكافأة فورية مع كل عملية شراء، وكوني أول من يعرف عن عروضنا الحصرية.</p>
                        </div>
                    </div>

                    <div class="col-lg-7 bg-white p-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-dark">إنشاء حساب جديد ✨</h3>
                            <p class="text-muted small">املئي البيانات التالية للبدء رحلتك معنا</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small">الاسم الكامل</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               name="name" value="{{ old('name') }}" required autofocus placeholder="الاسم هنا">
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small">رقم الهاتف</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               name="phone" value="{{ old('phone') }}" required placeholder="05xxxxxxxx">
                                    </div>
                                    @error('phone')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small">البريد الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" required placeholder="name@example.com">
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small">كلمة المرور</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               name="password" required placeholder="••••••••">
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small">تأكيد كلمة المرور</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                                        <input type="password" class="form-control" 
                                               name="password_confirmation" required placeholder="••••••••">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label text-muted small" for="terms">
                                    أوافق على <a href="#" class="text-decoration-none fw-bold" style="color: var(--main-color)">الشروط والأحكام</a> و <a href="#" class="text-decoration-none fw-bold" style="color: var(--main-color)">سياسة الخصوصية</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-register w-100 mb-4 shadow-sm">
                                إنشاء الحساب
                            </button>

                            <div class="text-center position-relative mb-4">
                                <hr class="text-muted opacity-25">
                                <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">أو سجل باستخدام</span>
                            </div>

                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <a href="#" class="social-btn small">
                                        <i class="bi bi-google text-danger"></i> جوجل
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="social-btn small">
                                        <i class="bi bi-facebook text-primary"></i> فيسبوك
                                    </a>
                                </div>
                            </div>

                            <div class="text-center">
                                <p class="mb-0 text-muted small">لديك حساب بالفعل؟ 
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: var(--main-color);">تسجيل الدخول</a>
                                </p>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection