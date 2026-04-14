# SIRI Admin Panel

Admin panel ringan untuk mengelola aplikasi SIRI tanpa menggunakan Filament. Dibuat dengan vanilla PHP, HTML, CSS, dan JavaScript untuk performa yang lebih cepat.

## 🎨 Fitur

- **Dashboard**: Overview statistik aplikasi
- **User Management**: Kelola users, drivers, dan admins
- **Order Management**: Lihat dan kelola pesanan
- **Store Management**: Kelola toko dan restoran
- **Responsive Design**: Tampil sempurna di semua device
- **Pink Theme**: Tema pink modern yang konsisten dengan landing page

## 📁 Struktur File

```
siri-backend/
├── app/Http/Controllers/Admin/
│   ├── AdminController.php      # Dashboard & Auth
│   ├── UserController.php       # User CRUD
│   ├── OrderController.php      # Order Management
│   └── StoreController.php      # Store CRUD
├── resources/views/admin/
│   ├── layout.blade.php         # Layout utama
│   ├── login.blade.php          # Halaman login
│   ├── dashboard.blade.php      # Dashboard
│   ├── users/                   # User views
│   ├── orders/                  # Order views
│   └── stores/                  # Store views
└── routes/web.php               # Admin routes
```

## 🚀 Instalasi

### 1. Hapus Filament (Opsional)

Jika ingin menghapus Filament sepenuhnya:

```bash
cd siri-backend
composer remove filament/filament
```

### 2. Setup Database

Pastikan database sudah dikonfigurasi di `.env`:

```env
DB_CONNECTION=sqlite
# atau
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siri_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Jalankan Migration

```bash
php artisan migrate
```

### 4. Buat Admin User

Buat user admin pertama menggunakan tinker:

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
```

### 5. Jalankan Server

```bash
php artisan serve
```

## 🔐 Login

Akses admin panel di: `http://localhost:8000/admin/login`

**Default Credentials:**
- Email: `admin@siri.app`
- Password: `password`

## 📱 Fitur Admin Panel

### Dashboard
- Total users, orders, stores, revenue
- Pending & completed orders count
- Recent orders list
- Quick stats overview

### User Management
- List all users with pagination
- Filter by role (admin, user, driver)
- Search by name or email
- Create new users
- Edit user details
- Delete users
- Role management

### Order Management
- List all orders with pagination
- Filter by status
- Search by order number
- View order details
- Update order status
- View customer, store, and driver info
- Order items breakdown
- Delete orders

### Store Management
- List all stores with pagination
- Search stores
- Create new stores
- Edit store details
- Upload store images
- Toggle store open/closed status
- Delete stores

## 🎨 Customization

### Mengubah Warna

Edit file `resources/views/admin/layout.blade.php` pada bagian CSS variables:

```css
:root {
    --primary: #EC4899;      /* Pink utama */
    --primary-dark: #DB2777; /* Pink gelap */
    --secondary: #F472B6;    /* Pink terang */
    --accent: #A855F7;       /* Purple accent */
}
```

### Menambah Menu

Edit sidebar di `resources/views/admin/layout.blade.php`:

```html
<a href="{{ route('admin.your-route') }}" class="menu-item">
    <span class="menu-icon">🎯</span>
    Your Menu
</a>
```

## 🔧 Menambah Fitur Baru

### 1. Buat Controller

```bash
php artisan make:controller Admin/YourController
```

### 2. Buat Routes

Tambahkan di `routes/web.php`:

```php
Route::resource('your-resource', YourController::class);
```

### 3. Buat Views

Buat folder dan file di `resources/views/admin/your-resource/`:
- `index.blade.php` - List
- `create.blade.php` - Form create
- `edit.blade.php` - Form edit
- `show.blade.php` - Detail (opsional)

## 📊 Perbandingan dengan Filament

| Aspek | Admin Custom | Filament |
|-------|-------------|----------|
| **Loading Time** | ⚡ Sangat Cepat | 🐌 Lambat |
| **Bundle Size** | 📦 ~50KB | 📦 ~2MB+ |
| **Customization** | ✅ Mudah | ⚠️ Terbatas |
| **Learning Curve** | ✅ Mudah | ⚠️ Perlu belajar |
| **Dependencies** | ✅ Minimal | ❌ Banyak |
| **Performance** | ⚡ Excellent | ⚠️ Good |

## 🛠️ Troubleshooting

### Error: Class not found

```bash
composer dump-autoload
```

### Error: Route not found

```bash
php artisan route:clear
php artisan cache:clear
```

### Error: View not found

Pastikan struktur folder views sudah benar:
```
resources/views/admin/
```

### Error: Unauthorized

Pastikan user sudah login dan memiliki role yang sesuai.

## 🔒 Security

### Middleware

Admin routes sudah dilindungi dengan middleware `auth`. Untuk menambah role-based access:

1. Buat middleware:
```bash
php artisan make:middleware AdminMiddleware
```

2. Implementasi di middleware:
```php
if (auth()->user()->role !== 'admin') {
    abort(403);
}
```

3. Daftarkan di `app/Http/Kernel.php`

4. Gunakan di routes:
```php
Route::middleware(['auth', 'admin'])->group(function () {
    // admin routes
});
```

## 📝 Best Practices

1. **Validation**: Selalu validasi input di controller
2. **Authorization**: Cek permission sebelum action
3. **Pagination**: Gunakan pagination untuk data besar
4. **Search**: Implementasi search untuk UX lebih baik
5. **Feedback**: Tampilkan success/error message
6. **Responsive**: Test di berbagai device

## 🚀 Production Deployment

### 1. Optimize

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

### 2. Security

- Ubah `APP_DEBUG=false` di `.env`
- Gunakan HTTPS
- Set strong `APP_KEY`
- Gunakan strong passwords
- Implementasi rate limiting

### 3. Performance

- Enable OPcache
- Use Redis/Memcached untuk cache
- Optimize database queries
- Use CDN untuk assets

## 📞 Support

Untuk pertanyaan atau bantuan:
- Email: dev@siri.app
- Documentation: [Laravel Docs](https://laravel.com/docs)

## 📄 License

© 2026 SIRI. All rights reserved.

---

**Dibuat dengan ❤️ menggunakan Laravel & Vanilla CSS**
