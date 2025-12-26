@extends('layouts.app')

@section('title', $section->name . ' - أنواع المتجر')

@section('content')
<style>
    .type-circle {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 3px solid var(--primary-color);
        transition: all 0.3s;
        text-decoration: none;
        color: var(--text-dark);
        margin: 0 auto;
    }
    
    .type-circle:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 30px rgba(214, 51, 132, 0.3);
        background: linear-gradient(135deg, var(--primary-color) 0%, #c2185b 100%);
        color: white;
    }
    
    .type-circle:hover i,
    .type-circle:hover h6 {
        color: white !important;
    }
    
    .type-circle i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 10px;
        transition: all 0.3s;
    }
    
    .type-circle h6 {
        font-size: 0.9rem;
        font-weight: bold;
        margin: 0;
        color: var(--text-dark);
        transition: all 0.3s;
    }
    
    .campaign-banner {
        height: 300px;
        object-fit: cover;
        border-radius: 15px;
    }
</style>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('main-categories.show', $section->mainCategory->slug) }}">{{ $section->mainCategory->name }}</a></li>
            <li class="breadcrumb-item active">{{ $section->name }}</li>
        </ol>
    </nav>

    <!-- Campaign Banner -->
    @if($section->image)
    <div class="mb-5">
        <img src="{{ $section->image }}" class="img-fluid w-100 campaign-banner shadow-sm" alt="{{ $section->name }}">
    </div>
    @endif

    <!-- Section Title -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">{{ $section->name }}</h1>
        @if($section->description)
        <p class="lead text-muted">{{ $section->description }}</p>
        @endif
    </div>

    <!-- Types Circles -->
    <section class="mb-5">
        <h2 class="text-center mb-4 fw-bold">الأنواع</h2>
        <div class="row g-4 justify-content-center">
            @forelse($section->activeTypes as $type)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('categories.show', [
                        'mainCategorySlug' => $section->mainCategory->slug,
                        'sectionSlug' => $section->slug,
                        'typeSlug' => $type->slug
                    ]) }}" class="text-decoration-none">
                        <div class="type-circle">
                            @if($type->icon)
                                <i class="{{ $type->icon }}"></i>
                            @elseif($type->image)
                                <img src="{{ $type->image }}" alt="{{ $type->name }}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                            @else
                                <i class="bi bi-box"></i>
                            @endif
                            <h6>{{ $type->name }}</h6>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">لا توجد أنواع متاحة حالياً</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Featured Products -->
    @if(isset($featuredProducts) && $featuredProducts->count() > 0)
    <section class="featured-products mb-5 pt-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <h2 class="fw-bold m-0">منتجات مميزة من {{ $section->name }}</h2>
                    <p class="text-muted m-0">اختياراتنا المميزة لك</p>
                </div>
                <a href="{{ route('products.index', ['section' => $section->id]) }}" class="btn btn-outline-dark rounded-pill px-4">عرض الكل</a>
            </div>
            
            <div class="row g-3 g-md-4">
                @foreach($featuredProducts as $product)
                    <div class="col-6 col-md-6 col-lg-3">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
@endsection

