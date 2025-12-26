@extends('layouts.app')

@section('title', 'السلة - متجر المكياج')

@section('content')
<div class="container py-5">
    <h1 class="mb-5">سلة التسوق</h1>
    
    @if(true) {{-- Check if cart has items --}}
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @for($i = 1; $i <= 3; $i++)
                            <div class="row align-items-center mb-4 pb-4 border-bottom">
                                <div class="col-md-2">
                                    <img src="https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=100&h=100&fit=crop" class="img-fluid rounded" alt="Product">
                                </div>
                                <div class="col-md-4">
                                    <h6>منتج المكياج {{ $i }}</h6>
                                    <p class="text-muted small mb-0">لون: أحمر</p>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary btn-sm" type="button">-</button>
                                        <input type="number" class="form-control form-control-sm text-center" value="{{ $i }}" min="1">
                                        <button class="btn btn-outline-secondary btn-sm" type="button">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <strong>{{ number_format(rand(100, 300)) }} ₪</strong>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">ملخص الطلب</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>المجموع الفرعي:</span>
                            <strong>450 ₪</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>الشحن:</span>
                            <strong class="text-success">مجاني</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>الضريبة:</span>
                            <strong>67.5 ₪</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-5">الإجمالي:</span>
                            <strong class="fs-5 text-primary">517.5 ₪</strong>
                        </div>
                        <a href="{{ route('checkout') }}" class="btn btn-primary w-100 btn-lg mb-2">
                            <i class="bi bi-arrow-left"></i> إتمام الشراء
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-right"></i> متابعة التسوق
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-cart-x fs-1 text-muted"></i>
            <h3 class="mt-3">السلة فارغة</h3>
            <p class="text-muted">لم تقم بإضافة أي منتجات للسلة بعد</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-right"></i> ابدأ التسوق
            </a>
        </div>
    @endif
</div>
@endsection

