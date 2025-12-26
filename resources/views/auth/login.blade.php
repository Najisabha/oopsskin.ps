@extends('layouts.app')

@section('title', 'تسجيل الدخول - متجر المكياج')

@section('content')

<style>
    /* تخصيص الألوان */
    :root {
        --main-color: #d63384;
        --input-focus-border: #f8d7da;
    }

    .login-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 0 40px rgba(0,0,0,0.1);
    }

    /* قسم الصورة الجانبية */
    .login-image-side {
        background: url('https://images.unsplash.com/photo-1512496015851-a90fb38ba796?q=80&w=1000&auto=format&fit=crop') no-repeat center center;
        background-size: cover;
        position: relative;
        min-height: 600px;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(214, 51, 132, 0.2), rgba(0,0,0,0.6));
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
        color: white;
    }

    /* تخصيص حقول الإدخال */
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

    .btn-login {
        background-color: var(--main-color);
        color: white;
        padding: 12px;
        border-radius: 10px;
        font-weight: bold;
        transition: all 0.3s;
        border: none;
    }

    .btn-login:hover {
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
        color: #000;
        border-color: #ddd;
    }

    .form-check-input:checked {
        background-color: var(--main-color);
        border-color: var(--main-color);
    }
</style>

<div class="container login-container py-5">
    <div class="row w-100 justify-content-center">
        <div class="col-lg-10">
            <div class="card login-card">
                <div class="row g-0">
                    
                    <div class="col-lg-6 bg-white p-5">
                        <div class="text-center mb-5">
                            <h3 class="fw-bold text-dark">مرحباً بعودتك! ✨</h3>
                            <p class="text-muted">سجلي الدخول لمتابعة تسوق منتجاتك المفضلة</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">البريد الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label text-muted small mb-0">كلمة المرور</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-decoration-none small text-secondary">
                                            نسيت كلمة المرور؟
                                        </a>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" 
                                           name="password" required placeholder="••••••••">
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label text-muted small" for="remember">تذكر بياناتي</label>
                            </div>

                            <button type="submit" class="btn btn-login w-100 mb-4 shadow-sm">
                                تسجيل الدخول
                            </button>

                            <div class="text-center position-relative mb-4">
                                <hr class="text-muted">
                                <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">أو</span>
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
                                <p class="mb-0 text-muted small">ليس لديك حساب؟ 
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: var(--main-color);">إنشاء حساب جديد</a>
                                </p>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-6 d-none d-lg-block login-image-side">
                        <div class="image-overlay">
                            <h2 class="fw-bold mb-3">اكتشفي الجمال الحقيقي</h2>
                            <p class="lead mb-0 opacity-75">انضمي إلينا واستمتعي بأفضل العروض الحصرية على منتجات العناية والمكياج.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection