@extends('layouts.app')

@section('title', 'تسجيل الدخول - متجر المكياج')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">تسجيل الدخول</h2>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                تذكرني
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-box-arrow-in-right"></i> تسجيل الدخول
                        </button>
                    </form>
                    
                    <div class="text-center">
                        <a href="{{ route('password.request') }}" class="text-decoration-none">
                            نسيت كلمة المرور؟
                        </a>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">ليس لديك حساب؟ 
                            <a href="{{ route('register') }}" class="text-decoration-none">إنشاء حساب جديد</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

