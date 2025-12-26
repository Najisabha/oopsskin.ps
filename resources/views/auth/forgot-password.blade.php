@extends('layouts.app')

@section('title', 'نسيت كلمة المرور - متجر المكياج')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">نسيت كلمة المرور</h2>
                    <p class="text-center text-muted mb-4">
                        أدخل بريدك الإلكتروني وسنرسل لك رابط لإعادة تعيين كلمة المرور
                    </p>
                    
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-envelope"></i> إرسال رابط إعادة التعيين
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            <i class="bi bi-arrow-right"></i> العودة لتسجيل الدخول
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

