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
    
    <div class="row g-3 g-md-4">
        @php
            $searchProducts = [
                ['id' => 1, 'name' => 'أحمر شفاه ماتي', 'price' => 120, 'discount_percentage' => 15, 'is_new' => true, 'rating' => 5, 'image' => 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=500&h=500&fit=crop&q=80'],
                ['id' => 2, 'name' => 'ماسكارا طويلة الأمد', 'price' => 85, 'discount_percentage' => 0, 'is_new' => false, 'rating' => 4, 'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500&h=500&fit=crop&q=80'],
                ['id' => 3, 'name' => 'أحمر خدود', 'price' => 95, 'discount_percentage' => 20, 'is_new' => true, 'rating' => 5, 'image' => 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=500&h=500&fit=crop&q=80'],
                ['id' => 4, 'name' => 'أساس سائل', 'price' => 180, 'discount_percentage' => 0, 'is_new' => false, 'rating' => 4, 'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=500&h=500&fit=crop&q=80'],
                ['id' => 5, 'name' => 'ظلال عيون', 'price' => 150, 'discount_percentage' => 25, 'is_new' => false, 'rating' => 5, 'image' => 'https://images.unsplash.com/photo-1622618990740-ce57d7f904d4?w=500&h=500&fit=crop&q=80'],
                ['id' => 6, 'name' => 'كونسيلر', 'price' => 75, 'discount_percentage' => 0, 'is_new' => true, 'rating' => 4, 'image' => 'https://images.unsplash.com/photo-1612817288484-6f916006741a?w=500&h=500&fit=crop&q=80'],
            ];
        @endphp
        @foreach($searchProducts as $product)
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
            <li class="page-item">
                <a class="page-link" href="#">التالي</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

