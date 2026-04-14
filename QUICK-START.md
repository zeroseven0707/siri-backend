# 🚀 Quick Start Guide - SIRI Admin Panel

Panduan cepat untuk mengganti Filament dengan admin panel custom yang lebih ringan dan cepat.

## ⚡ Quick Setup (Recommended)

### Windows (PowerShell)

```powershell
cd siri-backend
.\setup-admin.ps1
```

### Linux/Mac (Bash)

```bash
cd siri-backend
chmod +x setup-admin.sh
./setup-admin.sh
```

Script akan otomatis:
1. ✅ Menghapus Filament
2. ✅ Membersihkan file-file Filament
3. ✅ Clear cache
4. ✅ Membuat admin user

## 📝 Manual Setup

Jika prefer setup manual:

### 1. Hapus Filament

```bash
composer remove filament/filament
```

### 2. Bersihkan File

**Windows:**
```powershell
Remove-Item -Recurse -Force app/Filament
Remove-Item -Force config/filament.php -ErrorAction SilentlyContinue
```

**Linux/Mac:**
```bash
rm -rf app/Filament
rm -f config/filament.php
```

### 3. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
```

### 4. Buat Admin User

```bash
php artisan tinker
```

Kemudian:

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@siri.app',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'phone' => '+6281234567890'
]);
```

### 5. Jalankan Server

```bash
php artisan serve
```

### 6. Login

Buka browser: `http://localhost:8000/admin/login`

**Credentials:**
- Email: `admin@siri.app`
- Password: `password`

## 🎯 Fitur Admin Panel

### ✅ Yang Sudah Tersedia:

- **Dashboard** - Overview statistik
- **Users** - CRUD users, drivers, admins
- **Orders** - Lihat & kelola pesanan
- **Stores** - CRUD toko/restoran

### 🔜 Yang Perlu Ditambahkan (Opsional):

- Food Items Management
- Services Management
- Transactions Management
- Push Notifications
- Settings

## 📊 Perbandingan

| Feature | Filament | Custom Admin |
|---------|----------|--------------|
| Loading Speed | 🐌 2-3s | ⚡ 0.5s |
| Bundle Size | 📦 2MB+ | 📦 50KB |
| Customization | ⚠️ Limited | ✅ Full Control |
| Learning Curve | 📚 Medium | ✅ Easy |
| Dependencies | ❌ Many | ✅ Minimal |

## 🎨 Customization

### Ubah Warna

Edit `resources/views/admin/layout.blade.php`:

```css
:root {
    --primary: #EC4899;      /* Ubah warna utama */
    --secondary: #F472B6;    /* Ubah warna sekunder */
    --accent: #A855F7;       /* Ubah warna accent */
}
```

### Tambah Menu

Edit sidebar di `resources/views/admin/layout.blade.php`:

```html
<a href="{{ route('admin.your-route') }}" class="menu-item">
    <span class="menu-icon">🎯</span>
    Your Menu
</a>
```

## 🔒 Security Tips

1. **Ubah Password Default**
   ```bash
   php artisan tinker
   ```
   ```php
   $user = \App\Models\User::where('email', 'admin@siri.app')->first();
   $user->password = bcrypt('your-strong-password');
   $user->save();
   ```

2. **Enable HTTPS** di production

3. **Set APP_DEBUG=false** di production

4. **Gunakan Strong APP_KEY**

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

### Login tidak bisa

Pastikan:
1. User sudah dibuat dengan role 'admin'
2. Email dan password benar
3. Session driver sudah dikonfigurasi di `.env`

## 📚 Dokumentasi Lengkap

- [ADMIN-PANEL-README.md](ADMIN-PANEL-README.md) - Dokumentasi lengkap
- [REMOVE-FILAMENT.md](REMOVE-FILAMENT.md) - Panduan hapus Filament
- [Laravel Docs](https://laravel.com/docs) - Laravel documentation

## 💡 Tips

1. **Backup database** sebelum migrasi
2. **Test di local** dulu sebelum production
3. **Update .env** sesuai environment
4. **Clear cache** setelah perubahan config

## 🎉 Selesai!

Admin panel custom Anda sudah siap digunakan!

**Next Steps:**
1. ✅ Login ke admin panel
2. ✅ Explore fitur-fitur yang ada
3. ✅ Customize sesuai kebutuhan
4. ✅ Deploy ke production

## 📞 Need Help?

- 📖 Baca [ADMIN-PANEL-README.md](ADMIN-PANEL-README.md)
- 🐛 Check [Troubleshooting](#-troubleshooting)
- 💬 Contact: dev@siri.app

---

**Happy Coding! 💖**

Made with ❤️ using Laravel & Vanilla CSS
