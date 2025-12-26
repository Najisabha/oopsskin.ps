@extends('layouts.app')

@section('title', 'الفواتير - متجر المكياج')

@section('content')
<div class="container py-5">
    <h1 class="mb-5">الفواتير</h1>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>التاريخ</th>
                            <th>المبلغ</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 10; $i++)
                            <tr>
                                <td>#INV-{{ str_pad($i, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ now()->subDays($i)->format('Y-m-d') }}</td>
                                <td>{{ number_format(rand(100, 1000)) }} ₪</td>
                                <td>
                                    @if($i % 3 == 0)
                                        <span class="badge bg-success">مكتمل</span>
                                    @elseif($i % 3 == 1)
                                        <span class="badge bg-warning">قيد المعالجة</span>
                                    @else
                                        <span class="badge bg-info">قيد الشحن</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('invoices.show', $i) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                    <a href="{{ route('invoices.download', $i) }}" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-download"></i> PDF
                                    </a>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

