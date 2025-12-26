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
    
    <div class="row g-3 g-md-4">
        @php
            $categoryProducts = [
                ['id' => 1, 'name' => 'أحمر شفاه ماتي أحمر', 'price' => 120, 'discount_percentage' => 15, 'is_new' => true, 'rating' => 5, 'image' => 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=500&h=500&fit=crop&q=80'],
                ['id' => 2, 'name' => 'أحمر شفاه وردي', 'price' => 110, 'discount_percentage' => 0, 'is_new' => true, 'rating' => 4, 'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500&h=500&fit=crop&q=80'],
                ['id' => 3, 'name' => 'أحمر شفاه برتقالي', 'price' => 95, 'discount_percentage' => 20, 'is_new' => false, 'rating' => 5, 'image' => 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=500&h=500&fit=crop&q=80'],
                ['id' => 4, 'name' => 'أحمر شفاه بني', 'price' => 130, 'discount_percentage' => 0, 'is_new' => false, 'rating' => 4, 'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=500&h=500&fit=crop&q=80'],
            ];
        @endphp
        @foreach($categoryProducts as $product)
            <div class="col-6 col-md-6 col-lg-3">
                @include('components.product-card', ['product' => (object)$product])
            </div>
        @endforeach
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

