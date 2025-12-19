# دليل حل مشاكل النشر (Deployment Troubleshooting)

## المشاكل الشائعة وحلولها

### 1. المشروع لا يعمل بعد النشر

#### التحقق من:
- [ ] ملف `index.php` موجود في الجذر الرئيسي
- [ ] ملف `.htaccess` موجود في الجذر
- [ ] ملف `.env` موجود وبه الإعدادات الصحيحة
- [ ] قاعدة البيانات متصلة بشكل صحيح

#### الحل:
```bash
# تأكد من وجود الملفات الأساسية
ls -la /home/oopsszwf/public_html/index.php
ls -la /home/oopsszwf/public_html/.htaccess
ls -la /home/oopsszwf/public_html/.env

# تحقق من الصلاحيات
chmod -R 755 /home/oopsszwf/public_html/storage
chmod -R 755 /home/oopsszwf/public_html/bootstrap/cache
```

### 2. خطأ 500 Internal Server Error

#### الأسباب المحتملة:
- صلاحيات خاطئة على المجلدات
- ملف `.env` غير موجود أو به أخطاء
- خطأ في قاعدة البيانات

#### الحل:
```bash
# تحقق من ملف السجلات
tail -f /home/oopsszwf/public_html/storage/logs/laravel.log

# تأكد من الصلاحيات
chmod 644 /home/oopsszwf/public_html/.env
chmod -R 775 /home/oopsszwf/public_html/storage
chmod -R 775 /home/oopsszwf/public_html/bootstrap/cache

# مسح الكاش
cd /home/oopsszwf/public_html
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 3. الصور والملفات المرفوعة لا تظهر

#### الحل:
```bash
cd /home/oopsszwf/public_html
php artisan storage:link

# تحقق من وجود symlink
ls -la public/storage

# يجب أن يظهر شيء مثل:
# lrwxrwxrwx 1 user user ... public/storage -> ../storage/app/public
```

### 4. مشكلة في قاعدة البيانات

#### التحقق:
```bash
# تحقق من إعدادات قاعدة البيانات في .env
cat /home/oopsszwf/public_html/.env | grep DB_

# تشغيل migrations
cd /home/oopsszwf/public_html
php artisan migrate --force
```

### 5. خطأ Composer أو Vendor

#### الحل:
```bash
cd /home/oopsszwf/public_html
composer install --no-dev --optimize-autoloader
```

### 6. مشاكل في cPanel Deployment

#### إذا كان النشر التلقائي لا يعمل:
1. استخدم ملف `deploy.sh` يدوياً
2. أو ارفع الملفات يدوياً عبر File Manager في cPanel
3. تأكد من أن rsync متاح على السيرفر

#### استخدام deploy.sh:
```bash
# اجعل الملف قابلاً للتنفيذ
chmod +x deploy.sh

# شغّل النشر
./deploy.sh
```

## خطوات النشر اليدوي

1. **ارفع الملفات** إلى `/home/oopsszwf/public_html/`
2. **تأكد من ملف `.env`** يحتوي على:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   DB_HOST=localhost
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
3. **شغّل الأوامر التالية:**
   ```bash
   cd /home/oopsszwf/public_html
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan migrate --force
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   chmod -R 775 storage bootstrap/cache
   ```

## تحقق سريع من المشاكل

```bash
# تحقق من بنية المشروع
cd /home/oopsszwf/public_html
ls -la index.php
ls -la .htaccess
ls -la .env
ls -la vendor/

# تحقق من الصلاحيات
ls -ld storage
ls -ld bootstrap/cache

# تحقق من symlink
ls -la public/storage

# تحقق من السجلات
tail -20 storage/logs/laravel.log
```

