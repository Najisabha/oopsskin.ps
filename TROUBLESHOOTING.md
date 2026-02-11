# 🔧 حل المشاكل - Troubleshooting Guide

## 🚨 المشاكل الشائعة وحلولها

### المشكلة: الموقع بطيء جداً أو لا يعمل

#### الحل 1: مسح الـ Cache
```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

#### الحل 2: إعادة تشغيل السيرفر
```bash
# أوقف السيرفر (Ctrl+C)
# ثم شغله مرة أخرى
php artisan serve
```

#### الحل 3: تحقق من الأخطاء
افتح المتصفح واضغط F12 للتحقق من وجود أخطاء JavaScript أو CSS

---

### المشكلة: صفحة بيضاء فارغة (White Screen)

#### السبب: خطأ في الـ Syntax

#### الحل:
1. افتح Terminal
2. نفذ الأمر:
```bash
php artisan serve
```
3. افتح الموقع واقرأ رسالة الخطأ
4. أو تحقق من ملف الـ logs:
```bash
tail -f storage/logs/laravel.log
```

---

### المشكلة: الصور لا تظهر

#### الأسباب المحتملة:
- ❌ رابط الصورة غير صحيح
- ❌ الصورة محذوفة من السيرفر
- ❌ مشكلة في الأذونات

#### الحل:
1. تحقق من رابط الصورة
2. تأكد من رفع الصور في مجلد `public/images`
3. تحقق من الأذونات:
```bash
chmod -R 755 public/images
```

---

### المشكلة: الـ CSS/JavaScript لا يعمل

#### الحل:
1. امسح الـ cache:
```bash
php artisan view:clear
```

2. تحقق من console في المتصفح (F12)

3. تأكد من تحميل Bootstrap:
```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
```

---

### المشكلة: خطأ 404 - الصفحة غير موجودة

#### الحل:
1. تحقق من الـ routes:
```bash
php artisan route:list
```

2. تأكد من وجود Route في `routes/web.php`

3. امسح route cache:
```bash
php artisan route:clear
```

---

### المشكلة: خطأ 500 - Internal Server Error

#### الأسباب:
- خطأ في الكود
- مشكلة في قاعدة البيانات
- ملف `.env` غير صحيح

#### الحل:
1. فعّل Debug mode في `.env`:
```
APP_DEBUG=true
```

2. اقرأ رسالة الخطأ

3. تحقق من ملف logs:
```bash
storage/logs/laravel.log
```

---

### المشكلة: المتغيرات غير معرّفة (Undefined Variable)

#### السبب:
متغير مستخدم في Blade لكنه غير ممرر من Controller

#### الحل:
1. افتح Controller المسؤول
2. تأكد من تمرير المتغير:
```php
return view('home', [
    'featuredProducts' => $products
]);
```

3. أو استخدم ?? للقيم الافتراضية:
```blade
@foreach($products ?? [] as $product)
```

---

## 🛠️ أدوات مساعدة

### تحقق من الأخطاء في Blade
```bash
php artisan view:clear
```

### تحقق من syntax errors في PHP
```bash
php -l resources/views/layouts/app.blade.php
```

### عرض جميع الـ Routes
```bash
php artisan route:list
```

### تحديث Composer packages
```bash
composer update
```

### تحديث NPM packages
```bash
npm update
```

---

## 🔍 التحقق من الأداء

### 1. تحسين الصور
- استخدم WebP format
- ضغط الصور (TinyPNG, ImageOptim)
- استخدم lazy loading

### 2. تفعيل Cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. تحسين Database Queries
- استخدم eager loading
- أضف indexes للجداول
- استخدم pagination

---

## 📞 الحصول على المساعدة

### إذا استمرت المشكلة:

1. **اقرأ رسالة الخطأ بالكامل**
   - معظم الأخطاء تحتوي على معلومات مفيدة

2. **تحقق من الـ Logs**
   ```bash
   storage/logs/laravel.log
   ```

3. **ابحث عن الخطأ في Google**
   - انسخ رسالة الخطأ وابحث عنها

4. **تحقق من Laravel Documentation**
   - https://laravel.com/docs

---

## ✅ Checklist للتحقق من صحة التثبيت

- [ ] PHP >= 8.1
- [ ] Composer installed
- [ ] Node.js & NPM installed
- [ ] `.env` file exists
- [ ] Database configured
- [ ] `php artisan key:generate` executed
- [ ] `composer install` executed
- [ ] `npm install` executed
- [ ] Storage permissions correct (777)
- [ ] Public permissions correct (755)

---

## 🎯 نصائح للوقاية من المشاكل

1. **احتفظ بنسخة احتياطية دائماً**
   ```bash
   git commit -m "backup before changes"
   ```

2. **اختبر التغييرات أولاً**
   - اختبر على localhost قبل Production

3. **استخدم Git**
   - Commit بانتظام
   - استخدم branches للميزات الجديدة

4. **امسح الـ Cache بعد التعديلات**
   ```bash
   php artisan optimize:clear
   ```

5. **راقب ملفات الـ Logs**
   - تحقق منها بانتظام

---

## 🚀 أوامر مفيدة سريعة

```bash
# مسح جميع أنواع الـ Cache
php artisan optimize:clear

# إعادة تحميل الـ Autoloader
composer dump-autoload

# إصلاح الأذونات
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# التحقق من نسخة Laravel
php artisan --version

# عرض معلومات البيئة
php artisan about
```

---

**💡 نصيحة**: احتفظ بهذا الملف في مكان سهل الوصول للرجوع إليه عند الحاجة!
