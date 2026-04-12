# Siri API Documentation
**Base URL:** `https://duniakarya.store/api`  
**Auth:** Bearer Token (Sanctum) — kirim di header `Authorization: Bearer {token}`  
**Format:** Semua request/response dalam JSON. Selalu sertakan header `Accept: application/json`

---

## Response Format
Semua response menggunakan format yang konsisten:
```json
{ "success": true, "message": "...", "data": { ... } }
{ "success": false, "message": "...", "errors": { ... } }
```

---

## AUTH

### POST /register
```json
// Request
{ "name": "John", "email": "john@mail.com", "phone": "081200000099",
  "password": "password", "password_confirmation": "password", "role": "user",
  "device": "Samsung Galaxy S24", "platform": "android", "app_version": "1.0.0" }

// Response
{ "data": { "user": { "id": "uuid", "name": "John", "email": "...", "role": "user", ... }, "token": "1|abc..." } }
```

### POST /login
```json
// Request
{ "identifier": "john@mail.com", // atau nomor HP
  "password": "password",
  "device": "Samsung Galaxy S24",   // opsional tapi direkomendasikan
  "platform": "android",            // android | ios
  "app_version": "1.0.0" }

// Response — sama seperti register
{ "data": { "user": { ... }, "token": "1|abc..." } }
```

### POST /logout *(auth required)*
Hapus token yang sedang aktif. Tidak ada request body.

---

## PROFILE *(auth required)*

### GET /profile
```json
// Response
{ "data": { "id": "uuid", "name": "...", "email": "...", "phone": "...",
    "role": "user", "address": "...", "latitude": -6.2088, "longitude": 106.8456,
    "driver_profile": null, "created_at": "2026-04-12T..." } }
```

### PUT /profile/update
```json
// Request (semua field opsional)
{ "name": "New Name", "email": "new@mail.com", "phone": "081200000099",
  "address": "Jl. Sudirman No. 5", "latitude": -6.2088, "longitude": 106.8456 }
```

### POST /profile/fcm-token
Panggil setiap app launch setelah login untuk update FCM token push notification.
```json
// Request
{ "fcm_token": "fcm_token_dari_firebase_messaging" }
```

---

## HOME

### GET /home *(public)*
Ambil semua section untuk halaman utama mobile.
```json
// Response
{ "data": [
  { "id": "uuid", "title": "Banner Promo", "key": "banner_promo", "type": "banner",
    "order": 1, "is_active": true,
    "items": [
      { "id": "uuid", "title": "Promo Ramadan", "subtitle": "Diskon 50%",
        "image": "https://...", "action_type": "url", "action_value": "https://...",
        "order": 1, "is_active": true }
    ] }
] }
```

**Tipe section:** `banner` | `store_list` | `food_list` | `service_list` | `promo` | `custom`  
**action_type:** `url` | `route` | `store` | `food` | `service`  
**action_value:** URL string / UUID store / UUID food_item / UUID service

---

## SERVICES *(public)*

### GET /services
```json
{ "data": [
  { "id": "uuid", "name": "Pesan Makanan", "slug": "food", "icon": "storage/...", "base_price": 5000 }
] }
```

---

## STORES *(public)*

### GET /stores
Query params: tidak ada (paginated 15)
```json
{ "data": { "stores": [ { "id": "uuid", "name": "Warung Siri", "slug": "warung-siri",
    "description": "...", "image": "storage/...", "address": "...",
    "latitude": -6.2088, "longitude": 106.8456, "is_open": true } ],
  "pagination": { "current_page": 1, "last_page": 1, "total": 8 } } }
```

### GET /stores/{id}
Response include `food_items` array.

### GET /stores/{id}/foods
List food items yang available dari store tersebut.

---

## FOODS *(public)*

### GET /foods
Query params: `?store_id=uuid` `?search=keyword` (paginated 20)

### GET /foods/{id}
Detail food item + info store + semua menu lain dari store yang sama.
```json
{ "data": {
  "food_item": { "id": "uuid", "name": "Nasi Goreng", "price": "25000.00",
    "description": "...", "image": "storage/...", "is_available": true },
  "store": { "id": "uuid", "name": "Warung Siri", ..., "food_items": [ ... ] }
} }
```

---

## SEARCH *(public)*

### GET /search?q=nasi
Minimal 2 karakter.
```json
{ "data": { "query": "nasi", "stores": [ ... ], "foods": [ ... ], "total": 5 } }
```

---

## ORDERS *(auth required)*

### POST /orders — Buat order ride/delivery
```json
// Request
{ "service_id": "uuid", "pickup_location": "Jl. Sudirman No. 5",
  "destination_location": "Jl. Gatot Subroto No. 20", "price": 25000, "notes": "Cepat ya" }
```

### POST /food-orders — Buat order makanan
```json
// Request
{ "service_id": "uuid", "pickup_location": "Nama Resto, Alamat",
  "destination_location": "Alamat tujuan", "price": 45000, "notes": "Jangan pedas",
  "food_items": [
    { "food_item_id": "uuid", "qty": 2, "price": 15000 }
  ] }
```

### Response Order (create/detail)
```json
{ "data": {
  "id": "uuid", "status": "pending",
  "pickup_location": "...", "destination_location": "...",
  "price": "25000.00", "notes": "...",
  "service": { "id": "uuid", "name": "Ojek", "slug": "ojek" },
  "user": { ... }, "driver": null,
  "assigned_driver": { "id": "uuid", "name": "Driver Demo", "phone": "..." },
  "food_items": [ { "food_item": { "name": "...", "price": "..." }, "qty": 2, "price": "15000.00" } ],
  "created_at": "2026-04-12T...",
  "cancel_deadline": "2026-04-12T...+10detik",
  "can_cancel": true,
  "can_confirm": false
} }
```

> **Flow order:**
> 1. `POST /orders` → status `pending`, `assigned_driver` sudah ada, `can_cancel: true`
> 2. Mobile hitung countdown 10 detik dari `cancel_deadline`
> 3. Jika user cancel → `PUT /orders/{id}/cancel`
> 4. Jika tidak cancel → `PUT /orders/{id}/confirm` → status `accepted`, driver resmi di-assign
> 5. Driver antar → status `on_progress`
> 6. User konfirmasi terima → `PUT /orders/{id}/confirm` saat `can_confirm: true` → `completed`

### GET /orders
Query params: `?status=pending|accepted|on_progress|completed|cancelled`

### GET /orders/{id}
### PUT /orders/{id}/cancel — Batalkan (hanya dalam 10 detik pertama, status pending)
### PUT /orders/{id}/confirm — Konfirmasi (pending→accepted ATAU on_progress→completed)

---

## DRIVER *(auth required, role: driver)*

### GET /driver/orders — List order pending yang tersedia
### PUT /driver/orders/{id}/accept — Ambil order
### PUT /driver/orders/{id}/complete — Selesaikan order (→ on_progress)

---

## TRANSACTIONS *(auth required)*

### GET /transactions
```json
{ "data": { "transactions": [
  { "id": "uuid", "amount": "25000.00", "type": "payment",
    "status": "success", "reference": "PAY-XXXX", "order_id": "uuid",
    "created_at": "..." }
] } }
```
**type:** `topup` | `payment` | `refund`  
**status:** `pending` | `success` | `failed`

---

## NOTIFICATIONS *(auth required)*

### GET /notifications
```json
{ "data": {
  "notifications": [
    { "id": "uuid", "title": "Promo Ramadan", "body": "Diskon 50%...",
      "image": "storage/...", "type": "promo", "target": "user",
      "is_read": false, "sent_at": "2026-04-12T...", "data": { } }
  ],
  "unread_count": 3,
  "pagination": { ... }
} }
```
**type:** `promo` | `order_status` | `system`

### POST /notifications/{id}/read — Tandai satu notif sudah dibaca
### POST /notifications/read-all — Tandai semua sudah dibaca

---

## ACCOUNT SECURITY *(auth required)*

### POST /account/change-password
```json
{ "current_password": "password", "password": "newpass123", "password_confirmation": "newpass123" }
```

### GET /account/login-history
```json
{ "data": [
  { "id": 1, "ip_address": "192.168.1.1", "device": "Samsung Galaxy S24",
    "platform": "android", "app_version": "1.0.0",
    "success": true, "logged_in_at": "2026-04-12T..." }
] }
```

### GET /account/devices
```json
{ "data": [
  { "id": 35, "device": "Samsung Galaxy S24", "platform": "android",
    "ip_address": "192.168.1.1", "last_used_at": "2026-04-12T...",
    "created_at": "2026-04-12T...", "is_current": true }
] }
```

### POST /account/devices/{id}/logout — Remote logout perangkat lain
### POST /account/logout-all — Logout semua perangkat kecuali yang aktif

### POST /account/delete-request — Ajukan hapus akun
```json
{ "reason": "Saya tidak ingin menggunakan aplikasi ini lagi" }
// Response: { "data": { "id": 1, "status": "pending", ... } }
```

### GET /account/delete-request — Cek status request hapus akun
```json
{ "data": { "id": 1, "status": "pending|approved|rejected",
    "reason": "...", "rejection_note": "...", "reviewed_at": "..." } }
```

### DELETE /account/delete-request — Batalkan request hapus akun

---

## IMAGE URLs
Semua field `image` yang diupload via admin panel menggunakan path relatif storage.  
Untuk menampilkan gambar di mobile, prefix dengan base URL tanpa `/api`:
```
https://duniakarya.store/storage/{path}
```
Contoh: `image: "stores/abc.jpg"` → `https://duniakarya.store/storage/stores/abc.jpg`

---

## STATUS CODES
| Code | Keterangan |
|------|-----------|
| 200 | Success |
| 201 | Created |
| 401 | Unauthenticated (token tidak valid/expired) |
| 403 | Forbidden (role tidak sesuai) |
| 404 | Not found |
| 422 | Validation error |
| 500 | Server error |
