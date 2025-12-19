# تعليمات النشر (Deployment Instructions)

## الملفات والبنية

### الملفات في المكان الصحيح ✓
- جميع الملفات المرفوعة موجودة في `storage/app/public/` ✓
- هذا هو المكان الصحيح لـ Laravel

### ملفات الجذر الرئيسي (للنشر على cPanel)
تم نسخ هذه الملفات إلى الجذر الرئيسي لتتوافق مع متطلبات cPanel:
- `index.php` - نقطة الدخول الرئيسية (في الجذر)
- `.htaccess` - إعدادات خادم الويب (في الجذر)
- `favicon.ico` - أيقونة الموقع (في الجذر)
- `robots.txt` - إعدادات محركات البحث (في الجذر)

**ملاحظة:** هذه الملفات موجودة أيضاً في `public/` ويمكن استخدام أي نسخة.

### مجلد `public/storage`
- `public/storage` يجب أن يكون **symlink** (رابط رمزي) يشير إلى `storage/app/public`
- هذا المجلد موجود في `.gitignore` ولن يتم رفعه مع المشروع
- **يتم إنشاء symlink على السيرفر بعد النشر**

## خطوات النشر

### 1. رفع الملفات
- ارفع جميع ملفات المشروع إلى السيرفر
- تأكد من أن `public/storage` غير موجود أو مجلد فارغ

### 2. إنشاء Symlink على السيرفر
بعد رفع الملفات، قم بتشغيل:
```bash
cd /path/to/your/project
php artisan storage:link
```

هذا الأمر سينشئ `public/storage` كـ symlink يشير إلى `storage/app/public`

### 3. التحقق
بعد إنشاء symlink، يجب أن تكون الملفات قابلة للوصول عبر:
```
https://yoursite.com/storage/categories/image.png
https://yoursite.com/storage/products/image.webp
```

## ملاحظات مهمة

1. **لا تنقل الملفات من `storage/app/public`** - هذا هو المكان الصحيح
2. **لا تضع ملفات فعلية داخل `public/storage`** - يجب أن يكون symlink فقط
3. **تأكد من الصلاحيات** - المجلدات يجب أن تكون قابلة للكتابة:
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

## إعدادات cPanel
تم تحديث ملف `cpanel.yml` لإنشاء symlink تلقائياً بعد النشر.

