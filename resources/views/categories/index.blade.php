@extends('layouts.app')

@section('title', 'الأنواع - متجر المكياج')

@section('content')
<div class="container py-5">
    <h1 class="mb-5 text-center">أنواع المنتجات</h1>
    
    <div class="row g-4">
        @foreach([
            ['id' => 1, 'name' => 'أحمر الشفاه', 'description' => 'مجموعة واسعة من ألوان أحمر الشفاه', 'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=400&h=300&fit=crop', 'count' => 45],
            ['id' => 2, 'name' => 'ماسكارا', 'description' => 'ماسكارا لتكثيف وتطويل الرموش', 'image' => 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=400&h=300&fit=crop', 'count' => 32],
            ['id' => 3, 'name' => 'أحمر الخدود', 'description' => 'ألوان طبيعية لإشراقة الوجه', 'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400&h=300&fit=crop', 'count' => 28],
            ['id' => 4, 'name' => 'أساس', 'description' => 'أساس بجودة عالية لجميع أنواع البشرة', 'image' => 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=400&h=300&fit=crop', 'count' => 38],
            ['id' => 5, 'name' => 'ظلال العيون', 'description' => 'ظلال بألوان متنوعة ومتدرجة', 'image' => 'https://images.unsplash.com/photo-1512201078372-9c6b2a0d5280?w=400&h=300&fit=crop', 'count' => 52],
            ['id' => 6, 'name' => 'عناية بالبشرة', 'description' => 'منتجات العناية والترطيب', 'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400&h=300&fit=crop', 'count' => 67],
        ] as $category)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm category-card">
                    <img src="{{ $category['image'] }}" class="card-img-top" alt="{{ $category['name'] }}" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $category['name'] }}</h5>
                        <p class="card-text text-muted">{{ $category['description'] }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-secondary">{{ $category['count'] }} منتج</span>
                            <a href="{{ route('categories.show', $category['id']) }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left"></i> عرض المنتجات
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .category-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    }
</style>
@endsection

