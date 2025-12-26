@extends('layouts.app')

@section('title', 'استعادة كلمة المرور - متجر المكياج')

@section('content')

<style>
    :root {
        --main-color: #d63384;
        --input-focus-border: #f8d7da;
    }

    .reset-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .reset-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 0 40px rgba(0,0,0,0.1);
    }

    /* قسم الصورة الجانبية */
    .reset-image-side {
        /* صورة توحي بالهدوء/التفكير */
        background: url('https://images.unsplash.com/photo-1596462502278-27bfdd403348?q=80&w=1000&auto=format&fit=crop') no-repeat center center;
        background-size: cover;
        position: relative;
        min-height: 500px;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(214, 51, 132, 0.8), rgba(0,0,0,0.4));
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px;
        color: white;
        text-align: center;
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

    .btn-reset {
        background-color: var(--main-color);
        color: white;
        padding: 12px;
        border-radius: 10px;
        font-weight: bold;
        transition: all 0.3s;
        border: none;
    }
    .btn-reset:hover {
        background-color: #b02a6b;
        transform: translateY(-2px);
        color: white;
    }

    .icon-box {
        width: 80px;
        height: 80px;
        background-color: var(--input-focus-border);
        color: var(--main-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
    }
</style>

<div class="container reset-container py-5">
    <div class="row w-100 justify-content-center">
        <div class="col-lg-10">
            <div class="card reset-card">
                <div class="row g-0">
                    
                    <div class="col-lg-6 bg-white p-5">
                        
                        @if (session('status'))
                            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success mb-4 rounded-3" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                            </div>
                        @endif

                        <div class="text-center mb-4">
                            <div class="icon-box">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <h3 class="fw-bold text-dark">نسيت كلمة المرور؟</h3>
                            <p class="text-muted">لا تقلقي، يحدث ذلك! أدخلي بريدك الإلكتروني وسنرسل لك تعليمات استعادة الحساب.</p>
                        </div>

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="form-label text-muted small">البريد الإلكتروني المسجل</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-reset w-100 mb-4 shadow-sm">
                                إرسال رابط إعادة التعيين
                            </button>
                        </form>
                        
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none text-secondary d-inline-flex align-items-center gap-2 transition-hover">
                                <i class="bi bi-arrow-right"></i> العودة لتسجيل الدخول
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6 d-none d-lg-block reset-image-side">
                        <div class="image-overlay">
                            <i class="bi bi-stars fs-1 mb-3"></i>
                            <h2 class="fw-bold mb-3">حمايتك أولويتنا</h2>
                            <p class="lead opacity-75">نستخدم أحدث تقنيات التشفير للحفاظ على أمان بياناتك الشخصية.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection