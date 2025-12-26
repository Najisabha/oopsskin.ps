@extends('layouts.app')

@section('title', 'نتائج البحث - متجر المكياج')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">نتائج البحث عن: "{{ request('q') }}"</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="mb-0">تم العثور على <strong>24</strong> منتج</p>
        <select class="form-select" style="width: auto;">
            <option>الأكثر صلة</option>
            <option>السعر: من الأقل للأعلى</option>
            <option>السعر: من الأعلى للأقل</option>
            <option>الأحدث</option>
        </select>
    </div>
    
    <div class="row g-4">
        @for($i = 1; $i <= 12; $i++)
            <div class="col-md-6 col-lg-3">
                @include('components.product-card', ['product' => (object)[
                    'id' => $i,
                    'name' => 'منتج البحث ' . $i,
                    'description' => 'نتيجة البحث عن: ' . request('q'),
                    'price' => rand(50, 500),
                    'discount' => $i % 3 == 0 ? 15 : 0,
                    'is_new' => false,
                    'rating' => rand(3, 5),
                    'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=300&h=300&fit=crop&sig=' . $i
                ]])
            </div>
        @endfor
    </div>
    
    <nav aria-label="Page navigation" class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">السابق</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item">
                <a class="page-link" href="#">التالي</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

