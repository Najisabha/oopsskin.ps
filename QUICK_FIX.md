# حل سريع لمشكلة النشر

## إذا كان النشر لا يعمل، جرب هذه الخطوات بالترتيب:

### 1. تحقق من الملفات الأساسية
تأكد من وجود هذه الملفات في الجذر:
- ✅ `index.php`
- ✅ `.htaccess`
- ✅ `robots.txt`
- ✅ `favicon.ico`

### 2. النشر اليدوي (الأفضل)

#### الطريقة الأولى: عبر cPanel File Manager
1. سجّل دخول إلى cPanel
2. اذهب إلى **File Manager**
3. ارفع جميع ملفات المشروع إلى `public_html/`
4. تأكد من رفع:
   - جميع المجلدات (`app`, `bootstrap`, `config`, إلخ)
   - جميع الملفات في الجذر (`index.php`, `.htaccess`, إلخ)

#### الطريقة الثانية: عبر SSH
```bash
# ارفع الملفات أولاً (via FTP أو File Manager)
# ثم شغّل:
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

### 3. تحقق من ملف `.env`

تأكد من وجود ملف `.env` في `public_html/` مع هذه الإعدادات:

```env
APP_NAME=YourAppName
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

**مهم:** استخدم `php artisan key:generate` لإنشاء `APP_KEY`

### 4. تحقق من الأخطاء

شوف ملف السجلات:
```bash
tail -f /home/oopsszwf/public_html/storage/logs/laravel.log
```

### 5. مسح الكاش

```bash
cd /home/oopsszwf/public_html
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

### 6. إذا استمرت المشكلة

- تحقق من إصدار PHP (يجب أن يكون 8.1+)
- تحقق من صلاحيات المجلدات
- تحقق من إعدادات قاعدة البيانات
- راجع ملف `TROUBLESHOOTING.md` للحلول التفصيلية

