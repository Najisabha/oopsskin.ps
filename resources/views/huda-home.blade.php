@extends('layouts.huda-app')

@section('title', 'OOPSSKIN Official Store | Makeup, Skincare & Fragrance')

@section('content')

<style>
/* ============================================
   HERO SLIDER - PINK THEME LIKE HUDA
============================================ */
.hero-slider {
    position: relative;
    height: 700px;
    overflow: hidden;
    margin-bottom: 60px;
}

.hero-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1s ease-in-out;
    background: #F8F8F8;
}

.hero-slide.active {
    opacity: 1;
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 2;
    width: 100%;
    padding: 0 20px;
}

.hero-product-name {
    font-size: 90px;
    font-weight: 900;
    line-height: 0.9;
    letter-spacing: 5px;
    margin-bottom: 20px;
    color: #F24293;
    text-transform: uppercase;
}

.hero-tagline {
    font-size: 18px;
    font-weight: 700;
    letter-spacing: 6px;
    margin-bottom: 40px;
    color: #333;
}

.hero-btn {
    display: inline-block;
    padding: 16px 45px;
    background: #F24293;
    color: white;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-radius: 30px;
    transition: all 0.3s;
}

.hero-btn:hover {
    background: #E91E7A;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(242, 66, 147, 0.4);
}

/* Slider Navigation Arrows */
.slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.9);
    color: #F24293;
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s;
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.slider-arrow:hover {
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.slider-arrow.prev {
    left: 30px;
}

.slider-arrow.next {
    right: 30px;
}

/* Slider Dots */
.slider-dots {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 12px;
    z-index: 10;
}

.slider-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    border: 2px solid white;
    cursor: pointer;
    transition: all 0.3s;
}

.slider-dot.active {
    background: white;
    transform: scale(1.2);
}

/* ============================================
   TRENDING NOW - EXACTLY LIKE HUDA
============================================ */
.trending-section {
    margin-bottom: 80px;
}

.section-header {
    text-align: center;
    margin-bottom: 50px;
}

/* ============================================
   PRODUCTS SLIDER - WITH PINK ARROWS
============================================ */
.products-slider-section {
    margin-bottom: 80px;
    position: relative;
}

.products-slider-wrapper {
    position: relative;
    padding: 0 60px;
}

.products-slider {
    overflow: hidden;
    position: relative;
    width: 100%;
}

.products-slider-track {
    display: flex;
    gap: 20px;
    transition: transform 0.4s ease;
    width: fit-content;
}

.products-slider-item {
    min-width: calc(16.666% - 17px); /* 6 items on desktop (100% / 6) */
    flex-shrink: 0;
}

@media (max-width: 1199px) {
    .products-slider-item {
        min-width: calc(25% - 15px); /* 4 items on tablet */
    }
}

@media (max-width: 767px) {
    .products-slider-item {
        min-width: calc(33.333% - 14px); /* 3 items on mobile */
    }
}

.products-slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: #F24293;
    color: white;
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.products-slider-arrow:hover {
    background: #E91E7A;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 5px 20px rgba(242, 66, 147, 0.4);
}

.products-slider-arrow.prev {
    left: 0;
}

.products-slider-arrow.next {
    right: 0;
}

.section-title {
    font-size: 28px;
    font-weight: 900;
    letter-spacing: 3px;
    color: #000;
    margin-bottom: 10px;
}

.section-title a {
    color: #000;
    text-decoration: none;
}

.section-title a:hover {
    text-decoration: underline;
}

/* ============================================
   PRODUCT CARD - EXACTLY LIKE HUDA
============================================ */
.product-card-huda {
    position: relative;
    background: white;
    margin-bottom: 30px;
    text-align: left;
    border: 1px solid #f0f0f0;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.product-card-huda:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transform: translateY(-4px);
}

.product-image-wrapper {
    position: relative;
    overflow: hidden;
    background: #FAFAFA;
    aspect-ratio: 1/1;
    margin-bottom: 0;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.3s;
}

.product-image-hover {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    transition: opacity 0.3s;
}

.product-card-huda:hover .product-image {
    opacity: 0;
}

.product-card-huda:hover .product-image-hover {
    opacity: 1;
}

/* Product Badges */
.product-badges {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 2;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.badge-new,
.badge-sale {
    padding: 6px 12px;
    font-size: 10px;
    font-weight: 900;
    letter-spacing: 1px;
    border-radius: 0;
}

.badge-new {
    background: #000;
    color: white;
}

.badge-sale {
    background: #E31C1C;
    color: white;
}

/* Product Info */
.product-title {
    font-size: 14px;
    font-weight: 700;
    text-transform: none;
    letter-spacing: 0;
    margin: 15px 15px 8px 15px;
    min-height: auto;
    line-height: 1.4;
}

.product-title a {
    color: #000;
    text-decoration: none;
}

.product-title a:hover {
    color: #F24293;
}

.product-description {
    font-size: 13px;
    color: #666;
    margin: 0 15px 12px 15px;
    min-height: auto;
    line-height: 1.5;
}

/* Product Price */
.product-price {
    margin: 0 15px 8px 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.price-regular {
    font-size: 16px;
    font-weight: 700;
    color: #000;
}

.price-compare {
    font-size: 13px;
    color: #999;
    text-decoration: line-through;
    margin-right: 8px;
}

.price-save {
    font-size: 12px;
    color: #E31C1C;
    font-weight: 700;
}

/* Product Reviews */
.product-reviews {
    font-size: 13px;
    color: #666;
    margin: 0 15px 15px 15px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.product-reviews::before {
    content: "★★★★★";
    color: #F24293;
    font-size: 14px;
    letter-spacing: 2px;
}

/* Color Swatches */
.product-colors {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0 15px 12px 15px;
}

.color-swatch {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid #e0e0e0;
    cursor: pointer;
    transition: all 0.3s;
}

.color-swatch:hover {
    border-color: #F24293;
    transform: scale(1.1);
}

.color-more {
    font-size: 12px;
    color: #666;
    font-weight: 600;
}

/* Product Actions */
.product-actions {
    display: flex;
    gap: 8px;
    justify-content: stretch;
    padding: 0 15px 15px 15px;
}

.btn-notify,
.btn-add-bag,
.btn-select-shades {
    flex: 1;
    padding: 14px 20px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    border: 2px solid #F24293;
    background: white;
    color: #F24293;
    cursor: pointer;
    transition: all 0.3s;
    border-radius: 0;
}

.btn-add-bag {
    background: #F24293;
    color: white;
    border-color: #F24293;
}

.btn-notify:hover,
.btn-select-shades:hover {
    background: #F24293;
    color: white;
}

.btn-add-bag:hover {
    background: #E91E7A;
    border-color: #E91E7A;
}

/* ============================================
   LARGE BANNER - EXACTLY LIKE HUDA
============================================ */
.large-banner {
    position: relative;
    height: 500px;
    margin-bottom: 60px;
    overflow: hidden;
}

.large-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.banner-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    z-index: 2;
}

.banner-title {
    font-size: 80px;
    font-weight: 900;
    line-height: 0.9;
    letter-spacing: 5px;
    margin-bottom: 30px;
}

.banner-btn {
    display: inline-block;
    padding: 16px 45px;
    background: #F24293;
    color: white;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-radius: 30px;
    transition: all 0.3s;
}

.banner-btn:hover {
    background: #E91E7A;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(242, 66, 147, 0.4);
}

/* ============================================
   COMMUNITY SECTION
============================================ */
.community-section {
    margin-bottom: 60px;
}

.community-title {
    text-align: center;
    font-size: 28px;
    font-weight: 900;
    letter-spacing: 3px;
    margin-bottom: 40px;
}

.community-card {
    position: relative;
    height: 400px;
    overflow: hidden;
    margin-bottom: 30px;
}

.community-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.community-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 40px;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: white;
    text-align: center;
}

.community-overlay h3 {
    font-size: 24px;
    font-weight: 900;
    letter-spacing: 2px;
    margin-bottom: 15px;
}

.community-btn {
    display: inline-block;
    padding: 14px 35px;
    background: #F24293;
    color: white;
    text-decoration: none;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    border-radius: 30px;
    transition: all 0.3s;
}

.community-btn:hover {
    background: #E91E7A;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 991px) {
    .hero-slider {
        height: 500px;
        margin-bottom: 40px;
    }

    .hero-product-name {
        font-size: 50px;
        letter-spacing: 3px;
    }

    .hero-tagline {
        font-size: 14px;
        letter-spacing: 3px;
    }

    .hero-btn {
        padding: 14px 35px;
        font-size: 11px;
    }

    .slider-arrow {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }

    .slider-arrow.prev {
        left: 15px;
    }

    .slider-arrow.next {
        right: 15px;
    }

    .banner-title {
        font-size: 50px;
    }

    .section-title {
        font-size: 24px;
        letter-spacing: 2px;
    }

    .trending-section,
    .products-slider-section,
    .banners-section,
    .community-section {
        margin-bottom: 50px;
    }

    .products-slider-wrapper {
        padding: 0 50px;
    }

    .products-slider-arrow {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    .hero-slider {
        height: 550px;
        margin-bottom: 30px;
    }

    .hero-content {
        padding: 0 20px;
    }

    .hero-product-name {
        font-size: 48px;
        letter-spacing: 2px;
        margin-bottom: 15px;
        line-height: 1;
    }

    .hero-tagline {
        font-size: 12px;
        letter-spacing: 2px;
        margin-bottom: 30px;
    }

    .hero-btn {
        padding: 14px 30px;
        font-size: 10px;
        letter-spacing: 1.5px;
        border-radius: 25px;
    }

    .slider-arrow {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }

    .slider-arrow.prev {
        left: 10px;
    }

    .slider-arrow.next {
        right: 10px;
    }

    .slider-dots {
        bottom: 20px;
        gap: 8px;
    }

    .slider-dot {
        width: 10px;
        height: 10px;
    }

    .section-title {
        font-size: 22px;
        letter-spacing: 1.5px;
    }

    .trending-section,
    .products-slider-section {
        margin-bottom: 40px;
    }

    .section-header {
        margin-bottom: 30px;
    }

    .product-grid {
        gap: 15px;
    }

    .products-slider-wrapper {
        padding: 0 40px;
    }

    .products-slider-arrow {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }

    .products-slider-arrow.prev {
        left: 5px;
    }

    .products-slider-arrow.next {
        right: 5px;
    }

    .product-card-huda {
        margin-bottom: 20px;
    }

    .product-image-wrapper {
        margin-bottom: 12px;
    }

    .product-badges {
        top: 8px;
        right: 8px;
    }

    .badge-new,
    .badge-sale {
        padding: 5px 10px;
        font-size: 9px;
    }

    .product-title {
        font-size: 13px;
        margin-bottom: 8px;
    }

    .product-price {
        font-size: 14px;
    }

    .banner-content {
        padding: 40px 20px;
    }

    .banner-title {
        font-size: 40px !important;
        margin-bottom: 15px;
    }

    .banner-subtitle {
        font-size: 14px;
        margin-bottom: 25px;
    }

    .banner-btn {
        padding: 14px 30px;
        font-size: 11px;
    }

    .community-title {
        font-size: 32px;
    }

    .community-btn {
        padding: 14px 35px;
        font-size: 11px;
    }

    .banner-title {
        font-size: 35px;
    }

    .large-banner {
        height: 350px;
    }
}
</style>

<!-- Hero Slider -->
<section class="hero-slider">
    <!-- Slide 1 -->
    <div class="hero-slide active">
        <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=1920&h=700&fit=crop&q=90" 
             alt="New Beauty Collection" 
             class="hero-image">
        <div class="hero-content">
            <h1 class="hero-product-name">
                NEW<br>
                COLLECTION
            </h1>
            <p class="hero-tagline">EXPLORE LATEST ARRIVALS</p>
            <a href="{{ route('products.index') }}" class="hero-btn">SHOP NOW</a>
        </div>
    </div>

    <!-- Slide 2 -->
    <div class="hero-slide">
        <img src="https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=1920&h=700&fit=crop&q=90" 
             alt="Skincare Essentials" 
             class="hero-image">
        <div class="hero-content">
            <h1 class="hero-product-name">
                SKINCARE<br>
                ESSENTIALS
            </h1>
            <p class="hero-tagline">GLOW FROM WITHIN</p>
            <a href="{{ route('products.index') }}" class="hero-btn">DISCOVER MORE</a>
        </div>
    </div>

    <!-- Navigation Arrows -->
    <button class="slider-arrow prev" onclick="changeSlide(-1)">
        <i class="bi bi-chevron-left"></i>
    </button>
    <button class="slider-arrow next" onclick="changeSlide(1)">
        <i class="bi bi-chevron-right"></i>
    </button>

    <!-- Dots -->
    <div class="slider-dots">
        <span class="slider-dot active" onclick="goToSlide(0)"></span>
        <span class="slider-dot" onclick="goToSlide(1)"></span>
    </div>
</section>

<!-- Trending Now Section -->
<section class="trending-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <a href="#">Trending Now</a>
            </h2>
        </div>

        @php
        $products = [
                [
                    'name' => 'Easy Bake Pressed Powder Phone Grip',
                    'description' => 'Your favourite Easy Bake Pressed Powder, now as a phone grip for touch-ups anywhere.',
                    'price' => 29,
                    'compare_price' => null,
                    'reviews' => 52,
                    'rating' => 4.9,
                    'badge' => 'new',
                    'colors' => ['#FFB6C1', '#FFD1DC', '#FFF', '#F5DEB3', '#FFE4B5', '#DDA15E'],
                    'image' => 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=500&h=500&fit=crop',
                    'hover_image' => 'https://images.unsplash.com/photo-1596462502278-27bfdd403348?w=500&h=500&fit=crop',
                    'action' => 'add'
                ],
                [
                    'name' => 'Easy Bake Pressed Powder',
                    'description' => 'Super fine pressed powder with 12hr shine control for a non-caking airbrush matte finish.',
                    'price' => 40,
                    'compare_price' => null,
                    'reviews' => 126,
                    'rating' => 4.9,
                    'badge' => 'new',
                    'colors' => ['#FFE4C4', '#FFF', '#F5E6D3', '#F0D9B5', '#FFD700', '#FFF9E6'],
                    'image' => 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=500&h=500&fit=crop',
                    'hover_image' => 'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?w=500&h=500&fit=crop',
                    'action' => 'add'
                ],
                [
                    'name' => 'Airbrush Made Easy Kit',
                    'description' => 'Easy Bake Pressed Powder and the Marshmallow Sponge, bundled for effortless touch-ups.',
                    'price' => 53,
                    'compare_price' => 59,
                    'reviews' => 8,
                    'rating' => 5.0,
                    'badge' => 'sale',
                    'colors' => null,
                    'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=500&h=500&fit=crop',
                    'hover_image' => 'https://images.unsplash.com/photo-1622618990740-ce57d7f904d4?w=500&h=500&fit=crop',
                    'action' => 'select'
                ],
                [
                    'name' => 'Easy Bake Marshmallow Puff & Sponge',
                    'description' => 'A dual-sided puff and sponge for easy blending and shine-free touch-ups.',
                    'price' => 19,
                    'compare_price' => null,
                    'reviews' => 49,
                    'rating' => 4.9,
                    'badge' => 'new',
                    'colors' => null,
                    'image' => 'https://images.unsplash.com/photo-1612817288484-6f916006741a?w=500&h=500&fit=crop',
                    'hover_image' => 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=500&h=500&fit=crop',
                    'action' => 'add'
                ],
                [
                    'name' => 'Easy Bake Duo Loose Powder',
                    'description' => 'Ultra-blurring & smoothing with a real-life filter effect and airbrushed finish.',
                    'price' => 39,
                    'compare_price' => null,
                    'reviews' => 184,
                    'badge' => null,
                    'image' => 'https://images.unsplash.com/photo-1616683693504-3ea7e9ad6fec?w=500&h=500&fit=crop',
                    'hover_image' => 'https://images.unsplash.com/photo-1596462502278-27bfdd403348?w=500&h=500&fit=crop',
                    'action' => 'add'
                ],
                [
                    'name' => '#FAUXFILTER Color Corrector',
                    'description' => 'Brightens, evens & corrects pigmentation with a long-lasting finish.',
                    'price' => 31,
                    'compare_price' => null,
                    'reviews' => 1397,
                    'badge' => null,
                    'image' => 'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?w=500&h=500&fit=crop',
                    'hover_image' => 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=500&h=500&fit=crop',
                    'action' => 'add'
                ],
            ];
        @endphp

        <div class="products-slider-wrapper">
            <button class="products-slider-arrow prev" onclick="slidePrev()">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div class="products-slider">
                <div class="products-slider-track">
                    @foreach($products as $product)
                    <div class="products-slider-item">
                <div class="product-card-huda">
                    <!-- Product Image -->
                    <div class="product-image-wrapper">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="product-image">
                        <img src="{{ $product['hover_image'] }}" alt="{{ $product['name'] }}" class="product-image-hover">
                        
                        <!-- Badges -->
                        <div class="product-badges">
                            @if($product['badge'] === 'new')
                                <span class="badge badge-new">NEW</span>
                            @elseif($product['badge'] === 'sale' && $product['compare_price'])
                                <span class="badge badge-sale">
                                    SAVE {{ round((($product['compare_price'] - $product['price']) / $product['compare_price']) * 100) }}%
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Product Info -->
                    <h3 class="product-title">
                        <a href="#">{{ $product['name'] }}</a>
                    </h3>

                    <p class="product-description">{{ $product['description'] }}</p>

                    <!-- Price -->
                    <div class="product-price">
                        <span class="price-regular">${{ $product['price'] }}.00</span>
                        @if($product['compare_price'])
                            <span class="price-compare">${{ $product['compare_price'] }}.00</span>
                            <span class="price-save">
                                Save ${{ $product['compare_price'] - $product['price'] }}.00
                            </span>
                        @endif
                    </div>

                    <!-- Color Swatches -->
                    @if(isset($product['colors']) && $product['colors'])
                    <div class="product-colors">
                        @foreach(array_slice($product['colors'], 0, 6) as $color)
                            <span class="color-swatch" style="background-color: {{ $color }};"></span>
                        @endforeach
                        @if(count($product['colors']) > 6)
                            <span class="color-more">+ {{ count($product['colors']) - 6 }}</span>
                        @endif
                    </div>
                    @endif

                    <!-- Reviews -->
                    @if($product['reviews'] > 0)
                    <div class="product-reviews">
                        {{ isset($product['rating']) ? $product['rating'] : '5.0' }} ({{ $product['reviews'] }})
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="product-actions">
                        @if($product['action'] === 'add')
                            <button class="btn-add-bag">Add to Bag</button>
                        @elseif($product['action'] === 'select')
                            <button class="btn-select-shades">Select shades</button>
                        @else
                            <button class="btn-notify">Notify Me</button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
                </div>
            </div>

            <button class="products-slider-arrow next" onclick="slideNext()">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<!-- Best Sellers Slider Section (REMOVED) -->
<section class="products-slider-section" style="display: none;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">
                <a href="#">Best Sellers</a>
            </h2>
        </div>

        <div class="products-slider-wrapper">
            <button class="products-slider-arrow prev" onclick="slidePrev()">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div class="products-slider">
                <div class="products-slider-track">
                    @php
                    $bestSellers = [
                        [
                            'name' => 'Liquid Matte Lipstick',
                            'description' => 'Transfer-proof formula with 16-hour wear and velvet matte finish.',
                            'price' => 20,
                            'reviews' => 2340,
                            'rating' => 4.8,
                            'badge' => null,
                            'colors' => ['#DC143C', '#FF1493', '#C71585', '#8B008B', '#4B0082'],
                            'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=500&h=500&fit=crop',
                            'action' => 'add'
                        ],
                        [
                            'name' => 'The New Nude Eyeshadow Palette',
                            'description' => '18 high-impact shades with matte, shimmer, and duo-chrome finishes.',
                            'price' => 65,
                            'reviews' => 892,
                            'rating' => 4.9,
                            'badge' => null,
                            'colors' => null,
                            'image' => 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=500&h=500&fit=crop',
                            'action' => 'add'
                        ],
                        [
                            'name' => 'Faux Filter Foundation',
                            'description' => 'Full coverage foundation with a natural finish and 12-hour wear.',
                            'price' => 40,
                            'reviews' => 5678,
                            'rating' => 4.7,
                            'badge' => null,
                            'colors' => ['#F5DEB3', '#DEB887', '#D2B48C', '#BC8F8F', '#A0826D'],
                            'image' => 'https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=500&h=500&fit=crop',
                            'action' => 'select'
                        ],
                        [
                            'name' => '#FauxFilter Concealer',
                            'description' => 'Full coverage concealer that blurs imperfections and brightens.',
                            'price' => 28,
                            'reviews' => 3421,
                            'rating' => 4.9,
                            'badge' => null,
                            'colors' => ['#FFE4C4', '#F5DEB3', '#DEB887', '#D2B48C'],
                            'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdd403348?w=500&h=500&fit=crop',
                            'action' => 'add'
                        ],
                        [
                            'name' => 'Wishful Yo Glow Enzyme Scrub',
                            'description' => 'BHA and enzyme exfoliating scrub for smooth, glowing skin.',
                            'price' => 38,
                            'reviews' => 1234,
                            'rating' => 4.8,
                            'badge' => null,
                            'colors' => null,
                            'image' => 'https://images.unsplash.com/photo-1612817288484-6f916006741a?w=500&h=500&fit=crop',
                            'action' => 'add'
                        ],
                        [
                            'name' => 'Legit Lashes Mascara',
                            'description' => 'Double-ended mascara for dramatic volume and length.',
                            'price' => 26,
                            'reviews' => 987,
                            'rating' => 4.6,
                            'badge' => null,
                            'colors' => null,
                            'image' => 'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?w=500&h=500&fit=crop',
                            'action' => 'add'
                        ],
                    ];
                    @endphp

                    @foreach($bestSellers as $product)
                    <div class="products-slider-item">
                        <div class="product-card-huda">
                            <div class="product-image-wrapper">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="product-image">
                            </div>

                            <h3 class="product-title">
                                <a href="#">{{ $product['name'] }}</a>
                            </h3>

                            <p class="product-description">{{ $product['description'] }}</p>

                            <div class="product-price">
                                <span class="price-regular">${{ $product['price'] }}.00</span>
                            </div>

                            @if(isset($product['colors']) && $product['colors'])
                            <div class="product-colors">
                                @foreach(array_slice($product['colors'], 0, 5) as $color)
                                    <span class="color-swatch" style="background-color: {{ $color }};"></span>
                                @endforeach
                                @if(count($product['colors']) > 5)
                                    <span class="color-more">+ {{ count($product['colors']) - 5 }}</span>
                                @endif
                            </div>
                            @endif

                            <div class="product-reviews">
                                {{ $product['rating'] }} ({{ $product['reviews'] }})
                            </div>

                            <div class="product-actions">
                                @if($product['action'] === 'add')
                                    <button class="btn-add-bag">Add to Bag</button>
                                @elseif($product['action'] === 'select')
                                    <button class="btn-select-shades">Select shades</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <button class="products-slider-arrow next" onclick="slideNext()">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<!-- Large Banner 1 -->
<section class="large-banner">
    <img src="https://images.unsplash.com/photo-1629198688000-71f23e745b6e?w=1920&h=500&fit=crop&q=90" alt="Banner">
    <div class="banner-content">
        <h2 class="banner-title">WE PRESSED<br>RESET</h2>
        <a href="{{ route('products.index') }}" class="banner-btn">SHOP NOW</a>
    </div>
</section>

<!-- Large Banner 2 -->
<section class="large-banner" style="background: linear-gradient(135deg, #FFE5EC 0%, #FFC2D4 100%);">
    <div class="banner-content" style="color: #000;">
        <h2 class="banner-title" style="color: #000;">FIND MY<br>SHADE</h2>
        <a href="#" class="banner-btn">START NOW</a>
    </div>
</section>

<!-- Community Section -->
<section class="community-section">
    <div class="container">
        <h2 class="community-title">OUR COMMUNITY</h2>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="community-card">
                    <img src="https://images.unsplash.com/photo-1596462502278-27bfdd403348?w=800&h=400&fit=crop&q=90" alt="VIPs">
                    <div class="community-overlay">
                        <h3>JOIN OOPSSKIN'S VIPS</h3>
                        <a href="#" class="community-btn">LEARN MORE</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="community-card">
                    <img src="https://images.unsplash.com/photo-1522338242992-e1a54906a8da?w=800&h=400&fit=crop&q=90" alt="Ambassadors">
                    <div class="community-overlay">
                        <h3>JOIN AMBASSADORS</h3>
                        <a href="#" class="community-btn">LEARN MORE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Product card interactions
document.querySelectorAll('.btn-add-bag, .btn-select-shades').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const originalText = this.textContent;
        this.textContent = 'ADDED ✓';
        this.style.background = '#28a745';
        this.style.borderColor = '#28a745';
        this.style.color = 'white';

        setTimeout(() => {
            this.textContent = originalText;
            this.style.background = '';
            this.style.borderColor = '';
            this.style.color = '';
        }, 2000);
    });
});

// ============================================
// HERO SLIDER FUNCTIONALITY
// ============================================
let currentSlide = 0;
const slides = document.querySelectorAll('.hero-slide');
const dots = document.querySelectorAll('.slider-dot');
const totalSlides = slides.length;

// Change slide function
function changeSlide(direction) {
    slides[currentSlide].classList.remove('active');
    dots[currentSlide].classList.remove('active');
    
    currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
    
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
}

// Go to specific slide
function goToSlide(index) {
    slides[currentSlide].classList.remove('active');
    dots[currentSlide].classList.remove('active');
    
    currentSlide = index;
    
    slides[currentSlide].classList.add('active');
    dots[currentSlide].classList.add('active');
}

// Auto-play slider every 5 seconds
let autoPlayInterval = setInterval(() => {
    changeSlide(1);
}, 5000);

// Pause auto-play on hover
const slider = document.querySelector('.hero-slider');
slider.addEventListener('mouseenter', () => {
    clearInterval(autoPlayInterval);
});

slider.addEventListener('mouseleave', () => {
    autoPlayInterval = setInterval(() => {
        changeSlide(1);
    }, 5000);
});

// ============================================
// PRODUCTS SLIDER FUNCTIONALITY
// ============================================
let currentPosition = 0;
const sliderTrack = document.querySelector('.products-slider-track');
const sliderItems = document.querySelectorAll('.products-slider-item');
const itemsToShow = 6; // Show 6 items at once
const totalItems = sliderItems.length;

function slideNext() {
    if (currentPosition < totalItems - itemsToShow) {
        currentPosition++;
        updateSliderPosition();
    }
}

function slidePrev() {
    if (currentPosition > 0) {
        currentPosition--;
        updateSliderPosition();
    }
}

function updateSliderPosition() {
    // Calculate width of one item (including gap)
    const itemWidth = sliderItems[0].offsetWidth + 20; // 20px gap
    const translateX = -(currentPosition * itemWidth);
    sliderTrack.style.transform = `translateX(${translateX}px)`;
}

// Responsive handling
window.addEventListener('resize', () => {
    currentPosition = 0;
    updateSliderPosition();
});
</script>
@endpush
