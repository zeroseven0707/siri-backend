# 🚀 Cara Menjalankan Admin Panel

Panduan lengkap untuk menjalankan admin panel SIRI yang sudah lengkap.

## ✅ Prerequisites

- PHP 8.2+
- Composer
- Database (MySQL/SQLite)
- Laravel 12

## 📋 Step-by-Step

### 1. Install Dependencies

```bash
cd siri-backend
composer install
```

### 2. Setup Environment

Copy `.env.example` ke `.env` (jika belum):

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 3. Configure Database

Edit `.env`:

```env
DB_CONNECTION=sqlite
# atau untuk MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=siri_db
# DB_USERNAME=root
# DB_PASSWORD=
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Create Admin User

```bash
php artisan tinker
```

Kemudian jalankan:

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@siri.app',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'phone' => '+6281234567890'
]);
exit
```

### 6. Create Storage Link (untuk upload images)

```bash
php artisan storage:link
```

### 7. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 8. Start Server

```bash
php artisan serve
```

Server akan berjalan di: `http://localhost:8000`

### 9. Login ke Admin Panel

Buka browser: `http://localhost:8000/admin/login`

**Login dengan:**
- Email: `admin@siri.app`
- Password: `password`

## 🎯 Fitur yang Tersedia

Setelah login, Anda bisa akses:

1. **Dashboard** - Overview statistik
2. **Users** - Kelola users, drivers, admins
3. **Orders** - Lihat dan kelola pesanan
4. **Stores** - Kelola toko/restoran
5. **Home Sections** - Kelola section homepage
6. **Services** - Kelola layanan jasa
7. **Push Notifications** - Kirim notifikasi
8. **Transactions** - Lihat transaksi
9. **Account Deletions** - Handle permintaan hapus akun

## 🐛 Troubleshooting

### Error: Route not found

```bash
php artisan route:clear
php artisan cache:clear
```

### Error: View not found

```bash
php artisan view:clear
```

### Error: Class not found

```bash
composer dump-autoload
```

### Error: Storage link not working

```bash
php artisan storage:link
```

### Error: Permission denied (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
```

### Error: Cannot login

Pastikan:
1. User sudah dibuat dengan role 'admin'
2. Email dan password benar
3. Session driver dikonfigurasi di `.env`

```env
SESSION_DRIVER=database
# atau
SESSION_DRIVER=file
```

## 🔧 Development Tips

### Watch for Changes (Optional)

Jika menggunakan Vite untuk assets:

```bash
npm install
npm run dev
```

### Queue Worker (Optional)

Jika menggunakan queue untuk notifications:

```bash
php artisan queue:work
```

### Logs

Monitor logs untuk debugging:

```bash
tail -f storage/logs/laravel.log
```

Atau gunakan Laravel Pail:

```bash
php artisan pail
```

## 📊 Seed Data (Optional)

Jika ingin data dummy untuk testing:

```bash
php artisan db:seed
```

Atau buat seeder custom:

```bash
php artisan make:seeder StoreSeeder
php artisan db:seed --class=StoreSeeder
```

## 🚀 Production Deployment

### 1. Optimize

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Set Environment

Edit `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 3. Security

- Gunakan HTTPS
- Set strong `APP_KEY`
- Gunakan strong passwords
- Enable rate limiting
- Setup firewall

### 4. Backup

Setup automatic backup:

```bash
# Install backup package
composer require spatie/laravel-backup

# Configure in config/backup.php
# Run backup
php artisan backup:run
```

## 📱 Mobile Testing

Test responsive design:

1. Open Chrome DevTools (F12)
2. Click device toolbar (Ctrl+Shift+M)
3. Test different screen sizes:
   - Mobile: 375px
   - Tablet: 768px
   - Desktop: 1920px

## 🎨 Customization

### Change Colors

Edit `resources/views/admin/layout.blade.php`:

```css
:root {
    --primary: #EC4899;      /* Change primary color */
    --secondary: #F472B6;    /* Change secondary color */
    --accent: #A855F7;       /* Change accent color */
}
```

### Add Menu Item

Edit sidebar in `resources/views/admin/layout.blade.php`:

```html
<a href="{{ route('admin.your-route') }}" class="menu-item">
    <span class="menu-icon">🎯</span>
    Your Menu
</a>
```

## 📞 Support

Jika ada masalah:

1. Check error logs: `storage/logs/laravel.log`
2. Clear all cache
3. Check database connection
4. Verify file permissions
5. Read documentation

## ✅ Checklist

Sebelum production:

- [ ] Database configured
- [ ] Admin user created
- [ ] Storage link created
- [ ] All cache cleared
- [ ] Environment set to production
- [ ] Debug mode disabled
- [ ] HTTPS enabled
- [ ] Backup configured
- [ ] Monitoring setup
- [ ] Team trained

## 🎉 Done!

Admin panel siap digunakan!

**Quick Commands:**

```bash
# Start development
php artisan serve

# Clear everything
php artisan optimize:clear

# Optimize for production
php artisan optimize
```

---

**Happy Coding! 🚀💖**
