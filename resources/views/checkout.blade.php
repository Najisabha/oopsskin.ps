@extends('layouts.app')

@section('title', 'إتمام الشراء - متجر المكياج')

@section('content')
<div class="container py-5">
    <h1 class="mb-5">إتمام الشراء</h1>
    
    <form action="{{ route('purchase.complete') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Shipping Address -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-geo-alt"></i> عنوان الشحن</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="tel" class="form-control" name="phone" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">العنوان</label>
                                <input type="text" class="form-control" name="address" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">المدينة</label>
                                <select class="form-select" name="city" required>
                                    <option>الرياض</option>
                                    <option>جدة</option>
                                    <option>الدمام</option>
                                    <option>مكة المكرمة</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">الحي</label>
                                <input type="text" class="form-control" name="district" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">الرمز البريدي</label>
                                <input type="text" class="form-control" name="postal_code" required>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-credit-card"></i> طريقة الدفع</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" checked>
                            <label class="form-check-label" for="cash">
                                <i class="bi bi-cash-coin"></i> الدفع عند الاستلام
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                            <label class="form-check-label" for="card">
                                <i class="bi bi-credit-card-2-front"></i> بطاقة ائتمانية
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="mada" value="mada">
                            <label class="form-check-label" for="mada">
                                <i class="bi bi-credit-card"></i> مدى
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">ملخص الطلب</h5>
                    </div>
                    <div class="card-body">
                        @for($i = 1; $i <= 2; $i++)
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <small class="d-block">منتج المكياج {{ $i }}</small>
                                    <small class="text-muted">الكمية: {{ $i }}</small>
                                </div>
                                <strong>{{ number_format(rand(100, 300)) }} ₪</strong>
                            </div>
                        @endfor
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>المجموع الفرعي:</span>
                            <strong>450 ₪</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
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
                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            <i class="bi bi-check-circle"></i> تأكيد الطلب
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

