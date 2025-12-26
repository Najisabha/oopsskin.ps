# متجر المكياج - دليل الإعداد

## المتطلبات
- PHP 8.2 أو أحدث
- Composer
- Node.js و npm

## خطوات الإعداد

1. تثبيت المكتبات:
```bash
composer install
npm install
```

2. إعداد ملف البيئة:
```bash
cp .env.example .env
php artisan key:generate
```

3. إعداد قاعدة البيانات:
```bash
php artisan migrate
```

4. لتشغيل المشروع:
```bash
php artisan serve
npm run dev
```

## تثبيت مكتبة PDF للفواتير

لتشغيل ميزة تحميل الفواتير بصيغة PDF، قم بتثبيت المكتبة التالية:

```bash
composer require barryvdh/laravel-dompdf
```

ثم قم بتحديث `app/Http/Controllers/InvoiceController.php` لإلغاء التعليق عن كود PDF.

## البنية

### الواجهات (Views)
- `resources/views/layouts/app.blade.php` - Layout الرئيسي مع Navbar و Footer
- `resources/views/components/product-card.blade.php` - مكون Card موحد للمنتجات
- `resources/views/home.blade.php` - الصفحة الرئيسية
- `resources/views/categories/` - صفحات الأنواع
- `resources/views/products/` - صفحات المنتجات
- `resources/views/cart/` - صفحة السلة
- `resources/views/auth/` - صفحات المصادقة
- `resources/views/invoices/` - صفحات الفواتير
- وغيرها...

### Controllers
- `HomeController` - الصفحة الرئيسية
- `CategoryController` - إدارة الأنواع
- `ProductController` - إدارة المنتجات
- `CartController` - إدارة السلة
- `CheckoutController` - إتمام الشراء
- `InvoiceController` - إدارة الفواتير
- وغيرها...

### Routes
جميع المسارات محددة في `routes/web.php`

## المميزات

✅ Layout متجاوب مع Navbar و Footer  
✅ مكون Card موحد للمنتجات  
✅ صفحة رئيسية مع عروض مميزة  
✅ صفحات الأنواع والمنتجات  
✅ صفحة تفاصيل المنتج  
✅ صفحة السلة  
✅ صفحة إتمام الشراء  
✅ صفحة البحث  
✅ صفحة الإعدادات  
✅ صفحة العناوين  
✅ صفحات المصادقة (تسجيل الدخول، إنشاء حساب، نسيت كلمة المرور)  
✅ صفحات المعلومات (من نحن، تواصل معنا، قصتنا)  
✅ صفحات الفواتير مع دعم PDF  

## استخدام Bootstrap

المشروع يستخدم Bootstrap 5.3 عبر CDN. يمكنك تغيير ذلك لاستخدام npm إذا رغبت.

