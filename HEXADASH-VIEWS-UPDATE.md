# Update Views dengan Komponen HexaDash

## Yang Sudah Diupdate

### ✅ 1. Dashboard (`resources/views/admin/dashboard.blade.php`)
**Komponen yang digunakan:**
- **Stats Cards** dengan icon dan gradient background
- **Table** dengan styling HexaDash
- **Badges** untuk status orders
- **Breadcrumb** navigation
- **Empty state** untuk data kosong

**Fitur:**
- 4 stat cards utama (Users, Orders, Stores, Revenue)
- 2 stat cards untuk order status (Pending, Completed)
- Tabel recent orders dengan styling modern
- Icon Unicons untuk visual yang lebih baik

### ✅ 2. Users Index (`resources/views/admin/users/index.blade.php`)
**Komponen yang digunakan:**
- **Card** dengan header dan actions
- **Form filters** dengan grid layout Bootstrap
- **Table** dengan hover effect
- **Badges** untuk role indicators
- **Action buttons** dengan icon (Edit, Delete)
- **Pagination** HexaDash style

**Fitur:**
- Search dan filter by role
- Reset filter button
- Icon untuk setiap role (Admin, Driver, User)
- Action buttons dengan hover effect
- Responsive design

### ✅ 3. Orders Index (`resources/views/admin/orders/index.blade.php`)
**Komponen yang digunakan:**
- **Card** dengan header
- **Form filters** untuk search dan status
- **Table** dengan informasi lengkap
- **Badges** untuk status orders dengan icon
- **Action buttons** (View, Delete)
- **Icon indicators** untuk store/service dan driver

**Fitur:**
- Search by order number
- Filter by status (Pending, Accepted, On Progress, Completed, Cancelled)
- Icon untuk membedakan food order dan service order
- Status badges dengan warna dan icon yang sesuai
- Driver information display

## Komponen HexaDash yang Digunakan

### 1. Stats Cards
```html
<div class="ap-po-details ap-po-details--2 p-25 radius-xl">
    <div class="overview-content w-100">
        <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
            <div class="ap-po-details__titlebar">
                <h1>Value</h1>
                <p>Label</p>
            </div>
            <div class="ap-po-details__icon-area">
                <div class="svg-icon order-bg-opacity-primary color-primary">
                    <i class="uil uil-icon"></i>
                </div>
            </div>
        </div>
    </div>
</div>
```

### 2. Table
```html
<table class="table table-hover mb-0">
    <thead>
        <tr class="userDatatable-header">
            <th><span class="userDatatable-title">Column</span></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="userDatatable-content">Content</div>
            </td>
        </tr>
    </tbody>
</table>
```

### 3. Badges
```html
<span class="badge badge-round badge-success">
    <i class="uil uil-check"></i> Text
</span>
```

### 4. Action Buttons
```html
<ul class="orderDatatable_actions mb-0 d-flex">
    <li>
        <a href="#" class="edit">
            <i class="uil uil-edit"></i>
        </a>
    </li>
    <li>
        <button class="remove">
            <i class="uil uil-trash-alt"></i>
        </button>
    </li>
</ul>
```

### 5. Breadcrumb
```html
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#"><i class="uil uil-estate"></i>Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Page</li>
    </ol>
</nav>
```

## Icon Library (Unicons)

Semua icon menggunakan **Unicons** dari `https://unicons.iconscout.com/`

**Icon yang sering digunakan:**
- `uil-users-alt` - Users
- `uil-shopping-cart-alt` - Orders
- `uil-store` - Stores
- `uil-usd-circle` - Money/Revenue
- `uil-car` - Driver/Service
- `uil-edit` - Edit action
- `uil-trash-alt` - Delete action
- `uil-eye` - View action
- `uil-check-circle` - Success/Completed
- `uil-clock` - Pending
- `uil-times-circle` - Cancelled

## Warna Tema Pink

Semua komponen sudah disesuaikan dengan tema pink:
- Primary: `#EC4899`
- Secondary: `#F472B6`
- Accent: `#A855F7`

## Halaman yang Masih Perlu Diupdate

Untuk konsistensi, halaman berikut juga perlu diupdate dengan komponen HexaDash:

1. ❌ Users Create/Edit
2. ❌ Orders Show
3. ❌ Stores Index/Create/Edit
4. ❌ Services Index/Create/Edit
5. ❌ Home Sections Index/Create/Edit
6. ❌ Push Notifications Index/Create
7. ❌ Transactions Index/Show
8. ❌ Account Deletions Index/Show

## Cara Update Halaman Lain

1. Gunakan `@extends('admin.layout')` untuk layout
2. Tambahkan `@section('breadcrumb')` untuk navigasi
3. Gunakan komponen HexaDash dari template
4. Tambahkan icon Unicons untuk visual yang lebih baik
5. Gunakan class Bootstrap untuk responsive design
6. Tambahkan custom CSS di `@push('styles')` jika diperlukan

## Referensi

- Template: `template-admin/index.html`
- Komponen: Lihat berbagai halaman di folder `template-admin/`
- Icon: https://unicons.iconscout.com/
- Bootstrap 5: https://getbootstrap.com/docs/5.0/
