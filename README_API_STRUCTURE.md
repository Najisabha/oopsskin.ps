# هيكلية API للموقع

## الهيكلية الأساسية

الموقع مبني على هيكلية متدرجة من 4 مستويات:

```
الصنف الرئيسي (Main Category)
    └── القسم (Section)
        └── النوع (Type)
            └── المنتج (Product)
```

## الجداول والعلاقات

### 1. main_categories (الأصناف الرئيسية)
- `id` - المعرف
- `name` - الاسم بالعربية
- `name_en` - الاسم بالإنجليزية
- `slug` - الرابط
- `description` - الوصف
- `image` - الصورة
- `icon` - الأيقونة
- `is_active` - نشط/غير نشط
- `sort_order` - ترتيب العرض

### 2. sections (الأقسام)
- `id` - المعرف
- `main_category_id` - معرف الصنف الرئيسي
- `name` - الاسم بالعربية
- `name_en` - الاسم بالإنجليزية
- `slug` - الرابط
- `description` - الوصف
- `image` - الصورة
- `icon` - الأيقونة
- `is_active` - نشط/غير نشط
- `sort_order` - ترتيب العرض

### 3. types (الأنواع)
- `id` - المعرف
- `section_id` - معرف القسم
- `name` - الاسم بالعربية
- `name_en` - الاسم بالإنجليزية
- `slug` - الرابط
- `description` - الوصف
- `image` - الصورة
- `icon` - الأيقونة
- `is_active` - نشط/غير نشط
- `sort_order` - ترتيب العرض

### 4. products (المنتجات)
- `id` - المعرف
- `type_id` - معرف النوع
- `main_category_id` - معرف الصنف الرئيسي
- `section_id` - معرف القسم
- `name` - الاسم بالعربية
- `name_en` - الاسم بالإنجليزية
- `slug` - الرابط
- `sku` - رمز المنتج
- `description` - الوصف الكامل
- `short_description` - الوصف المختصر
- `price` - السعر
- `compare_price` - سعر المقارنة
- `discount_percentage` - نسبة الخصم
- `stock_quantity` - الكمية المتوفرة
- `is_active` - نشط/غير نشط
- `is_featured` - مميز
- `is_new` - جديد
- `rating` - التقييم
- `reviews_count` - عدد التقييمات
- `images` - الصور (JSON)
- `meta_title` - عنوان SEO
- `meta_description` - وصف SEO
- `sort_order` - ترتيب العرض

## Routes (المسارات)

### الأصناف الرئيسية
```
GET /main-categories - عرض جميع الأصناف الرئيسية
GET /main-categories/{slug} - عرض صنف رئيسي معين
```

### الأقسام
```
GET /main-categories/{mainCategorySlug}/sections/{sectionSlug} - عرض قسم معين
```

### الأنواع
```
GET /categories - عرض جميع الأنواع
GET /main-categories/{mainCategorySlug}/sections/{sectionSlug}/types/{typeSlug} - عرض نوع معين
```

### المنتجات
```
GET /products - عرض جميع المنتجات (مع فلترة)
GET /main-categories/{mainCategorySlug}/sections/{sectionSlug}/types/{typeSlug}/products/{productSlug} - عرض منتج معين
```

## مثال على الاستخدام

### مثال 1: عرض منتج
```
URL: /main-categories/makeup/sections/face/types/lipstick/products/red-lipstick-001
```

### مثال 2: عرض نوع معين
```
URL: /main-categories/makeup/sections/face/types/lipstick
```

### مثال 3: عرض قسم معين
```
URL: /main-categories/makeup/sections/face
```

## Controllers

- `MainCategoryController` - إدارة الأصناف الرئيسية
- `SectionController` - إدارة الأقسام
- `CategoryController` - إدارة الأنواع (Types)
- `ProductController` - إدارة المنتجات

## Models

- `App\Models\MainCategory`
- `App\Models\Section`
- `App\Models\Type`
- `App\Models\Product`

## العلاقات

```php
MainCategory -> hasMany(Section)
Section -> belongsTo(MainCategory) -> hasMany(Type)
Type -> belongsTo(Section) -> hasMany(Product)
Product -> belongsTo(Type) -> belongsTo(Section) -> belongsTo(MainCategory)
```

