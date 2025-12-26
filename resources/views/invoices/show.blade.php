@extends('layouts.app')

@section('title', 'فاتورة #' . $invoiceId . ' - متجر المكياج')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>فاتورة #INV-{{ str_pad($invoiceId ?? 1, 6, '0', STR_PAD_LEFT) }}</h1>
        <a href="{{ route('invoices.download', $invoiceId ?? 1) }}" class="btn btn-danger">
            <i class="bi bi-download"></i> تحميل PDF
        </a>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-body p-5">
            <!-- Invoice Header -->
            <div class="row mb-5">
                <div class="col-md-6">
                    <h4 class="text-primary mb-3">متجر المكياج</h4>
                    <p class="mb-1">شارع الملك فهد، حي النخيل</p>
                    <p class="mb-1">الرياض، المملكة العربية السعودية</p>
                    <p class="mb-0">الرمز البريدي: 12345</p>
                </div>
                <div class="col-md-6 text-end">
                    <h5>فاتورة</h5>
                    <p class="mb-1"><strong>رقم الفاتورة:</strong> #INV-{{ str_pad($invoiceId ?? 1, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="mb-1"><strong>التاريخ:</strong> {{ now()->format('Y-m-d') }}</p>
                    <p class="mb-0"><strong>الحالة:</strong> <span class="badge bg-success">مكتمل</span></p>
                </div>
            </div>
            
            <!-- Customer Info -->
            <div class="row mb-5">
                <div class="col-md-6">
                    <h6 class="mb-3">معلومات العميل:</h6>
                    <p class="mb-1"><strong>الاسم:</strong> اسم المستخدم</p>
                    <p class="mb-1"><strong>البريد الإلكتروني:</strong> user@example.com</p>
                    <p class="mb-0"><strong>رقم الهاتف:</strong> 0501234567</p>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3">عنوان الشحن:</h6>
                    <p class="mb-0">
                        شارع الملك فهد، حي النخيل<br>
                        الرياض، 12345<br>
                        المملكة العربية السعودية
                    </p>
                </div>
            </div>
            
            <!-- Invoice Items -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 3; $i++)
                            <tr>
                                <td>منتج المكياج {{ $i }}</td>
                                <td>{{ $i }}</td>
                                <td>{{ number_format(rand(100, 300)) }} ₪</td>
                                <td>{{ number_format(rand(100, 300)) }} ₪</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            
            <!-- Invoice Summary -->
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <table class="table">
                        <tr>
                            <td>المجموع الفرعي:</td>
                            <td class="text-end">450.00 ₪</td>
                        </tr>
                        <tr>
                            <td>الضريبة (15%):</td>
                            <td class="text-end">67.50 ₪</td>
                        </tr>
                        <tr>
                            <td>الشحن:</td>
                            <td class="text-end text-success">مجاني</td>
                        </tr>
                        <tr class="table-primary">
                            <td><strong>الإجمالي:</strong></td>
                            <td class="text-end"><strong>517.50 ₪</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="text-center text-muted">
                <p class="mb-0">شكرًا لك على تسوقك معنا!</p>
            </div>
        </div>
    </div>
</div>
@endsection

