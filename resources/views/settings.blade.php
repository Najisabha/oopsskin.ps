@extends('layouts.app')

@section('title', 'الإعدادات - متجر المكياج')

@section('content')
<div class="container py-5">
    <h1 class="mb-5">الإعدادات</h1>
    
    <div class="row">
        <div class="col-lg-3">
            <div class="list-group">
                <a href="#profile" class="list-group-item list-group-item-action active" data-bs-toggle="tab">
                    <i class="bi bi-person"></i> الملف الشخصي
                </a>
                <a href="#password" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-lock"></i> كلمة المرور
                </a>
                <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-bell"></i> الإشعارات
                </a>
                <a href="#privacy" class="list-group-item list-group-item-action" data-bs-toggle="tab">
                    <i class="bi bi-shield-check"></i> الخصوصية
                </a>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="tab-content">
                <!-- Profile Tab -->
                <div class="tab-pane fade show active" id="profile">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">الملف الشخصي</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3 text-center">
                                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&h=150&fit=crop" class="rounded-circle mb-3" alt="Profile">
                                    <br>
                                    <button type="button" class="btn btn-outline-primary btn-sm">تغيير الصورة</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الاسم</label>
                                        <input type="text" class="form-control" value="اسم المستخدم">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">البريد الإلكتروني</label>
                                        <input type="email" class="form-control" value="user@example.com">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم الهاتف</label>
                                        <input type="tel" class="form-control" value="0501234567">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ الميلاد</label>
                                        <input type="date" class="form-control" value="1990-01-01">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Password Tab -->
                <div class="tab-pane fade" id="password">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">تغيير كلمة المرور</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">كلمة المرور الحالية</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">كلمة المرور الجديدة</label>
                                    <input type="password" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">تأكيد كلمة المرور الجديدة</label>
                                    <input type="password" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">تغيير كلمة المرور</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Notifications Tab -->
                <div class="tab-pane fade" id="notifications">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">إعدادات الإشعارات</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="email-notifications" checked>
                                <label class="form-check-label" for="email-notifications">
                                    إشعارات البريد الإلكتروني
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="sms-notifications">
                                <label class="form-check-label" for="sms-notifications">
                                    إشعارات الرسائل النصية
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="order-updates" checked>
                                <label class="form-check-label" for="order-updates">
                                    تحديثات الطلبات
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="promotions" checked>
                                <label class="form-check-label" for="promotions">
                                    العروض والترقيات
                                </label>
                            </div>
                            <button type="button" class="btn btn-primary">حفظ الإعدادات</button>
                        </div>
                    </div>
                </div>
                
                <!-- Privacy Tab -->
                <div class="tab-pane fade" id="privacy">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">الخصوصية</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="profile-public">
                                <label class="form-check-label" for="profile-public">
                                    جعل الملف الشخصي عامًا
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="show-email" checked>
                                <label class="form-check-label" for="show-email">
                                    إظهار البريد الإلكتروني
                                </label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="data-sharing">
                                <label class="form-check-label" for="data-sharing">
                                    مشاركة البيانات مع الشركاء
                                </label>
                            </div>
                            <button type="button" class="btn btn-primary">حفظ الإعدادات</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

