# 🚀 Firebase Push Notifications - Quick Start

## ⚡ 5-Minute Setup

### 1. Get Firebase Server Key

```
Firebase Console → Project Settings → Cloud Messaging → Server Key
```

### 2. Add to .env

```env
FCM_SERVER_KEY=your_server_key_here
FCM_PROJECT_ID=your_project_id
```

### 3. Clear Cache

```bash
php artisan config:clear
```

### 4. Test

```bash
php artisan tinker
```

```php
$firebase = app(\App\Services\FirebaseService::class);
$firebase->sendToDevice('test_token', 'Hello', 'Test message');
```

## 📱 Send Notification

### Via Admin Panel

```
1. Login: http://localhost:8000/admin/login
2. Go to: Push Notifications
3. Click: Send New Notification
4. Fill form and send
```

### Via Code

```php
use App\Models\PushNotification;

PushNotification::create([
    'title' => 'Hello!',
    'body' => 'This is a test notification',
    'target' => 'all', // or 'users', 'drivers'
    'status' => 'sent',
    'sent_at' => now(),
]);
```

## 🎯 Target Options

- `all` - All users with FCM tokens
- `users` - Customers only
- `drivers` - Drivers only

## 📊 Check Results

```php
$notification = PushNotification::latest()->first();
echo "Sent to: " . $notification->sent_count . " devices";
```

## 🐛 Troubleshooting

**Not working?**

1. Check `.env` has `FCM_SERVER_KEY`
2. Run `php artisan config:clear`
3. Check logs: `tail -f storage/logs/laravel.log`
4. Verify users have `fcm_token` in database

## 📚 Full Documentation

See [FIREBASE-SETUP.md](FIREBASE-SETUP.md) for complete guide.

---

**That's it! You're ready to send push notifications! 🎉**
