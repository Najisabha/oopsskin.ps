# 🎨 دليل المكونات - Huda Beauty Style

دليل شامل لجميع المكونات والعناصر المتاحة في التصميم الجديد.

## 📋 جدول المحتويات

1. [الألوان](#الألوان)
2. [الأزرار](#الأزرار)
3. [البطاقات](#البطاقات)
4. [الشارات](#الشارات)
5. [الأقسام](#الأقسام)
6. [أمثلة الاستخدام](#أمثلة-الاستخدام)

---

## 🎨 الألوان

### الألوان الأساسية
```css
--brand-primary: #000000      /* أسود (الرئيسي) */
--brand-secondary: #E91E63    /* وردي (ثانوي) */
--brand-accent: #FF6B9D       /* وردي فاتح (مميز) */
--brand-gold: #D4AF37         /* ذهبي (فاخر) */
```

### الألوان المحايدة
```css
--bg-light: #FFFFFF          /* أبيض */
--bg-cream: #FAF9F6          /* كريمي */
--text-dark: #000000         /* نص داكن */
--text-gray: #666666         /* نص رمادي */
```

### استخدام الألوان
```html
<!-- نص وردي -->
<span style="color: var(--brand-secondary);">نص وردي</span>

<!-- خلفية سوداء -->
<div style="background: var(--brand-primary);">محتوى</div>

<!-- خلفية كريمية -->
<section style="background-color: var(--bg-cream);">قسم</section>
```

---

## 🔘 الأزرار

### الزر الأساسي (أسود)
```html
<a href="#" class="btn btn-primary-brand">
    تسوقي الآن
</a>
```

### الزر الثانوي (شفاف بإطار)
```html
<a href="#" class="btn btn-secondary-brand">
    عرض المزيد
</a>
```

### زر التسوق
```html
<a href="#" class="btn btn-shop-now">
    ابدأي التسوق
</a>
```

### زر عرض الكل
```html
<a href="#" class="btn btn-view-all">
    VIEW ALL PRODUCTS
</a>
```

### أحجام الأزرار
```html
<!-- صغير -->
<button class="btn btn-primary-brand btn-sm">صغير</button>

<!-- متوسط (افتراضي) -->
<button class="btn btn-primary-brand">متوسط</button>

<!-- كبير -->
<button class="btn btn-primary-brand btn-lg">كبير</button>
```

---

## 🎴 البطاقات

### بطاقة منتج أساسية
```blade
@include('components.product-card', ['product' => $product])
```

### بطاقة فئة
```html
<div class="card text-center h-100 category-card py-4">
    <div class="category-icon-wrapper mb-3">
        <i class="bi bi-palette fs-3" style="color: var(--brand-pink);"></i>
    </div>
    <h6 class="card-title text-dark fw-bold m-0">اسم الفئة</h6>
</div>
```

### بطاقة مميزات
```html
<div class="feature-box">
    <i class="bi bi-shield-check"></i>
    <h5>منتجات أصلية 100%</h5>
    <p class="text-muted mb-0">نضمن لك جودة جميع منتجاتنا</p>
</div>
```

---

## 🏷️ الشارات

### شارة جديد
```html
<span class="badge bg-success">جديد</span>
```

### شارة خصم
```html
<span class="badge bg-danger">-25%</span>
```

### شارة مميز
```html
<span class="badge bg-warning">مميز</span>
```

### شارات مخصصة
```html
<span class="badge" style="background-color: var(--brand-pink);">
    NEW COLLECTION
</span>
```

---

## 📦 الأقسام

### قسم العنوان
```html
<div class="text-center mb-5">
    <h2 class="section-title mb-2">SHOP BY CATEGORY</h2>
    <p class="section-subtitle">اكتشفي مجموعتنا المتنوعة من منتجات الجمال</p>
</div>
```

### قسم بخلفية كريمية
```html
<section class="py-5" style="background-color: var(--bg-cream);">
    <div class="container">
        <!-- المحتوى -->
    </div>
</section>
```

### قسم بخلفية سوداء
```html
<section class="py-5" style="background: var(--brand-primary);">
    <div class="container">
        <div class="text-white">
            <!-- المحتوى -->
        </div>
    </div>
</section>
```

---

## 💡 أمثلة الاستخدام

### 1. قسم المنتجات المميزة

```html
<section class="featured-products py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-2">TRENDING NOW</h2>
            <p class="section-subtitle">المنتجات الأكثر رواجاً هذا الأسبوع</p>
        </div>
        
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('components.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-view-all">
                VIEW ALL PRODUCTS
            </a>
        </div>
    </div>
</section>
```

### 2. بانر عرض خاص

```html
<section class="special-offers py-5 mb-5" style="background: var(--brand-primary);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 p-5 text-white">
                <span class="badge mb-3" style="background-color: var(--brand-secondary);">
                    LIMITED TIME OFFER
                </span>
                <h2 class="display-4 fw-bold mb-4">عنوان العرض</h2>
                <p class="lead mb-4" style="color: #ccc;">
                    وصف العرض هنا...
                </p>
                <a href="#" class="btn btn-shop-now" style="background: white; color: black;">
                    تسوقي الآن
                </a>
            </div>
            <div class="col-lg-6">
                <img src="صورة.jpg" class="img-fluid" alt="العرض">
            </div>
        </div>
    </div>
</section>
```

### 3. شبكة فئات

```html
<section class="categories-section py-5" style="background-color: var(--bg-cream);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-2">SHOP BY CATEGORY</h2>
            <p class="section-subtitle">اكتشفي مجموعتنا المتنوعة</p>
        </div>
        
        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ $category->url }}" class="text-decoration-none">
                        <div class="card text-center h-100 category-card py-4">
                            <div class="category-icon-wrapper mb-3">
                                <i class="bi {{ $category->icon }} fs-3" 
                                   style="color: var(--brand-pink);"></i>
                            </div>
                            <h6 class="card-title text-dark fw-bold m-0">
                                {{ $category->name }}
                            </h6>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
```

### 4. نموذج Newsletter

```html
<section class="newsletter-section py-5" 
         style="background: linear-gradient(135deg, #000000 0%, #434343 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0 text-white">
                <h3 class="fw-bold mb-3">اشتركي في نشرتنا البريدية</h3>
                <p class="mb-0" style="color: #ccc;">
                    احصلي على خصومات حصرية وكوني أول من يعلم
                </p>
            </div>
            <div class="col-lg-6">
                <form class="d-flex gap-2">
                    <input type="email" 
                           class="form-control border-0 p-3" 
                           placeholder="بريدك الإلكتروني"
                           style="background: rgba(255,255,255,0.9); border-radius: 0;">
                    <button type="submit" class="btn btn-primary-brand px-4">
                        اشتراك
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
```

### 5. معرض Instagram

```html
<section class="instagram-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-2">FOLLOW US @OOPSSKIN</h2>
            <p class="section-subtitle">تابعينا على انستغرام</p>
        </div>
        
        <div class="row g-3">
            @foreach($instaPosts as $post)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="#" class="d-block position-relative overflow-hidden insta-post">
                        <img src="{{ $post->image }}" 
                             alt="Instagram" 
                             class="w-100" 
                             style="aspect-ratio: 1/1; object-fit: cover;">
                        <div class="insta-overlay">
                            <i class="bi bi-instagram fs-2 text-white"></i>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
```

---

## 🎯 نصائح للاستخدام

### 1. التباعد والمسافات
```html
<!-- استخدم py-5 للمسافات العمودية -->
<section class="py-5">

<!-- استخدم mb-5 للمسافة السفلية -->
<div class="mb-5">

<!-- استخدم g-4 للمسافات بين العناصر في Grid -->
<div class="row g-4">
```

### 2. الاستجابة للشاشات
```html
<!-- اعرض على الموبايل عمودين وعلى الديسكتوب 4 -->
<div class="col-6 col-lg-3">

<!-- اخفِ على الموبايل -->
<div class="d-none d-lg-block">

<!-- اظهر فقط على الموبايل -->
<div class="d-lg-none">
```

### 3. الألوان والخلفيات
```html
<!-- نص أبيض -->
<p class="text-white">

<!-- نص رمادي -->
<p class="text-muted">

<!-- خلفية وردية -->
<div style="background-color: var(--brand-secondary);">
```

---

## 📱 الأيقونات المتاحة (Bootstrap Icons)

```html
<i class="bi bi-palette"></i>        <!-- مكياج -->
<i class="bi bi-droplet-fill"></i>   <!-- عناية بالبشرة -->
<i class="bi bi-flower1"></i>        <!-- عطور -->
<i class="bi bi-scissors"></i>       <!-- شعر -->
<i class="bi bi-heart-fill"></i>     <!-- أحمر شفاه -->
<i class="bi bi-brush"></i>          <!-- أظافر -->
<i class="bi bi-shield-check"></i>   <!-- ضمان -->
<i class="bi bi-truck"></i>          <!-- شحن -->
<i class="bi bi-arrow-clockwise"></i> <!-- إرجاع -->
<i class="bi bi-instagram"></i>      <!-- انستغرام -->
<i class="bi bi-tiktok"></i>         <!-- تيك توك -->
<i class="bi bi-snapchat"></i>       <!-- سناب شات -->
<i class="bi bi-facebook"></i>       <!-- فيسبوك -->
```

---

## 🚀 التطبيق السريع

### إضافة قسم جديد للصفحة الرئيسية:

1. افتح `resources/views/home.blade.php`
2. أضف القسم قبل `@endsection`
3. استخدم أحد الأمثلة أعلاه
4. خصص المحتوى حسب حاجتك

### تخصيص الألوان:

1. افتح `resources/views/layouts/app.blade.php`
2. ابحث عن `:root {`
3. عدّل قيم المتغيرات
4. احفظ الملف

---

**💡 نصيحة**: استخدم نفس الأنماط والمسافات للحفاظ على تناسق التصميم!

**🎨 ملاحظة**: جميع المكونات responsive وتعمل على جميع الأجهزة!
