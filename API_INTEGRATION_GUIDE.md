# دليل تكامل API

## الهيكلية المطلوبة من API

يجب أن يكون API يتبع الهيكلية التالية:

```
الصنف الرئيسي (Main Category)
    └── القسم (Section)
        └── النوع (Type)
            └── المنتج (Product)
```

## مثال على استجابة API

### 1. جلب الأصناف الرئيسية
```json
GET /api/main-categories

Response:
{
    "data": [
        {
            "id": 1,
            "name": "مكياج",
            "name_en": "Makeup",
            "slug": "makeup",
            "description": "...",
            "image": "https://...",
            "icon": "bi-palette",
            "is_active": true,
            "sort_order": 1,
            "sections": [...]
        }
    ]
}
```

### 2. جلب الأقسام
```json
GET /api/main-categories/{slug}/sections

Response:
{
    "data": [
        {
            "id": 1,
            "main_category_id": 1,
            "name": "للوجه",
            "name_en": "Face",
            "slug": "face",
            "is_active": true,
            "types": [...]
        }
    ]
}
```

### 3. جلب الأنواع
```json
GET /api/sections/{id}/types

Response:
{
    "data": [
        {
            "id": 1,
            "section_id": 1,
            "name": "أحمر الشفاه",
            "name_en": "Lipstick",
            "slug": "lipstick",
            "is_active": true
        }
    ]
}
```

### 4. جلب المنتجات
```json
GET /api/types/{id}/products

Response:
{
    "data": [
        {
            "id": 1,
            "type_id": 1,
            "main_category_id": 1,
            "section_id": 1,
            "name": "أحمر شفاه أحمر",
            "slug": "red-lipstick-001",
            "price": 150.00,
            "discount_percentage": 15,
            "images": [
                "https://...",
                "https://..."
            ],
            "is_active": true,
            "is_featured": true,
            "is_new": true,
            "rating": 4.5,
            "reviews_count": 120
        }
    ]
}
```

## كيفية التكامل

### الطريقة 1: استخدام Models مباشرة (موصى به)
الموقع جاهز لاستخدام Models مباشرة من قاعدة البيانات. فقط قم بتشغيل:

```bash
php artisan migrate
```

ثم املأ البيانات من API أو من خلال Seeders.

### الطريقة 2: استخدام API مباشرة
إذا كنت تريد استخدام API مباشرة، قم بإنشاء Service Class:

```php
// app/Services/ApiService.php
class ApiService {
    public function getMainCategories() {
        // استدعاء API
    }
}
```

ثم استخدمه في Controllers.

## ملاحظات مهمة

1. **Slugs**: يجب أن تكون unique في كل مستوى
2. **العلاقات**: المنتج يجب أن يحتوي على معرفات للثلاثة (main_category_id, section_id, type_id)
3. **الصور**: يمكن أن تكون string واحدة أو array من strings
4. **الحقول المطلوبة**: 
   - `is_active` للفلترة
   - `sort_order` للترتيب
   - `slug` للروابط

## Routes المتوقعة من API

```
GET /api/main-categories
GET /api/main-categories/{slug}
GET /api/main-categories/{slug}/sections
GET /api/sections/{id}
GET /api/sections/{id}/types
GET /api/types/{id}
GET /api/types/{id}/products
GET /api/products
GET /api/products/{slug}
```

