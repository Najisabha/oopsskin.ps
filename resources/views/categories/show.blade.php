@extends('layouts.app')

@section('title', 'المنتجات - متجر المكياج')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">الأنواع</a></li>
            <li class="breadcrumb-item active">أحمر الشفاه</li>
        </ol>
    </nav>
    
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>أحمر الشفاه</h1>
            <p class="text-muted">مجموعة واسعة من ألوان أحمر الشفاه من أشهر الماركات</p>
        </div>
        <div class="col-md-4">
            <select class="form-select" id="sortSelect">
                <option value="latest">الأحدث</option>
                <option value="price-low">السعر: من الأقل للأعلى</option>
                <option value="price-high">السعر: من الأعلى للأقل</option>
                <option value="popular">الأكثر شعبية</option>
            </select>
        </div>
    </div>
    
    <div class="row g-4">
        @for($i = 1; $i <= 12; $i++)
            <div class="col-md-6 col-lg-3">
                @include('components.product-card', ['product' => (object)[
                    'id' => $i,
                    'name' => 'أحمر شفاه ' . $i,
                    'description' => 'لون طبيعي وطويل الأمد',
                    'price' => rand(50, 300),
                    'discount' => $i % 4 == 0 ? 15 : 0,
                    'is_new' => $i <= 3,
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
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">التالي</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

