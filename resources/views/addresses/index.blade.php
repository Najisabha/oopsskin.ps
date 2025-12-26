@extends('layouts.app')

@section('title', 'العناوين - متجر المكياج')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>العناوين</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
            <i class="bi bi-plus-circle"></i> إضافة عنوان جديد
        </button>
    </div>
    
    <div class="row g-4">
        @for($i = 1; $i <= 3; $i++)
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title">عنوان {{ $i }}</h5>
                            @if($i == 1)
                                <span class="badge bg-success">افتراضي</span>
                            @endif
                        </div>
                        <p class="card-text">
                            <i class="bi bi-person"></i> اسم المستخدم<br>
                            <i class="bi bi-telephone"></i> 0501234567<br>
                            <i class="bi bi-geo-alt"></i> شارع الملك فهد، حي النخيل<br>
                            الرياض، 12345
                        </p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil"></i> تعديل
                            </button>
                            @if($i != 1)
                                <button class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-check-circle"></i> تعيين كافتراضي
                                </button>
                            @endif
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i> حذف
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
    
    <!-- Add Address Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة عنوان جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">الاسم الكامل</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="tel" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">المدينة</label>
                            <select class="form-select" required>
                                <option>الرياض</option>
                                <option>جدة</option>
                                <option>الدمام</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الحي</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الشارع</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الرمز البريدي</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="setDefault">
                            <label class="form-check-label" for="setDefault">
                                تعيين كعنوان افتراضي
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

