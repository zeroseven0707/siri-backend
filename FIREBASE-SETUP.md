# 🔔 Firebase Cloud Messaging Setup

Panduan lengkap untuk setup Firebase Cloud Messaging (FCM) untuk push notifications.

## ✅ Yang Sudah Diimplementasikan

### 1. FirebaseService (`app/Services/FirebaseService.php`)

Service class untuk mengirim push notifications via FCM dengan fitur:

- ✅ Send to single device
- ✅ Send to multiple devices (batch up to 1000 per request)
- ✅ Send to topic
- ✅ Subscribe/unsubscribe to topics
- ✅ Error handling & logging
- ✅ Automatic chunking for large recipient lists

### 2. PushNotificationController

Controller sudah terintegrasi dengan FirebaseService:

- ✅ Send notifications immediately
- ✅ Schedule notifications for later
- ✅ Target specific user groups (all, users, drivers)
- ✅ Track sent count
- ✅ Error handling

### 3. Configuration

Config sudah ditambahkan di `config/services.php`:

```php
'firebase' => [
    'server_key'  => env('FCM_SERVER_KEY'),
    'project_id'  => env('FCM_PROJECT_ID'),
    'credentials' => env('FCM_CREDENTIALS'),
],
```

## 🚀 Setup Instructions

### Step 1: Get Firebase Server Key

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Select your project (or create new one)
3. Go to **Project Settings** (gear icon)
4. Go to **Cloud Messaging** tab
5. Copy the **Server Key**

### Step 2: Configure Environment

Add to your `.env` file:

```env
# Firebase Cloud Messaging
FCM_SERVER_KEY=your_server_key_here
FCM_PROJECT_ID=your_firebase_project_id
FCM_CREDENTIALS=storage/app/firebase-service-account.json
```

### Step 3: Download Service Account (Optional)

For advanced features, download service account JSON:

1. In Firebase Console, go to **Project Settings**
2. Go to **Service Accounts** tab
3. Click **Generate New Private Key**
4. Save the JSON file to `storage/app/firebase-service-account.json`

### Step 4: Test Configuration

```bash
php artisan tinker
```

```php
// Test sending notification
$firebase = app(\App\Services\FirebaseService::class);

// Send to single device (replace with real FCM token)
$firebase->sendToDevice(
    'fcm_token_here',
    'Test Notification',
    'This is a test message'
);
```

## 📱 Mobile App Integration

### Android Setup

1. **Add Firebase to your Android app**
   - Download `google-services.json` from Firebase Console
   - Place it in `android/app/` directory

2. **Add dependencies** in `android/app/build.gradle`:
   ```gradle
   dependencies {
       implementation 'com.google.firebase:firebase-messaging:23.0.0'
   }
   ```

3. **Get FCM Token** in your app:
   ```kotlin
   FirebaseMessaging.getInstance().token.addOnCompleteListener { task ->
       if (task.isSuccessful) {
           val token = task.result
           // Send this token to your backend
           sendTokenToServer(token)
       }
   }
   ```

4. **Send token to backend**:
   ```kotlin
   // API call to save FCM token
   POST /api/user/fcm-token
   {
       "fcm_token": "device_fcm_token_here"
   }
   ```

### iOS Setup

1. **Add Firebase to your iOS app**
   - Download `GoogleService-Info.plist` from Firebase Console
   - Add it to your Xcode project

2. **Enable Push Notifications**
   - In Xcode, go to Capabilities
   - Enable Push Notifications

3. **Get FCM Token**:
   ```swift
   Messaging.messaging().token { token, error in
       if let token = token {
           // Send this token to your backend
           sendTokenToServer(token)
       }
   }
   ```

## 🎯 Usage Examples

### Send to All Users

```php
use App\Models\PushNotification;

PushNotification::create([
    'title' => 'New Promo!',
    'body' => 'Get 50% off on all orders today!',
    'target' => 'all',
    'status' => 'sent',
    'sent_at' => now(),
]);
```

### Send to Specific Group

```php
// Send to customers only
PushNotification::create([
    'title' => 'Order Update',
    'body' => 'Your order is on the way!',
    'target' => 'users',
    'status' => 'sent',
    'sent_at' => now(),
]);

// Send to drivers only
PushNotification::create([
    'title' => 'New Order Available',
    'body' => 'Check the app for new delivery requests',
    'target' => 'drivers',
    'status' => 'sent',
    'sent_at' => now(),
]);
```

### Schedule Notification

```php
PushNotification::create([
    'title' => 'Reminder',
    'body' => 'Don\'t forget to check our new menu!',
    'target' => 'all',
    'status' => 'scheduled',
    'scheduled_at' => now()->addHours(2),
]);
```

### Send via Admin Panel

1. Login to admin panel: `http://localhost:8000/admin/login`
2. Go to **Push Notifications**
3. Click **Send New Notification**
4. Fill in:
   - Title
   - Message
   - Target audience (All Users / Customers / Drivers)
   - Schedule (optional)
5. Click **Send Notification**

## 🔧 Advanced Features

### Send with Custom Data

```php
use App\Services\FirebaseService;

$firebase = app(FirebaseService::class);

$firebase->sendToDevice(
    $fcmToken,
    'Order Update',
    'Your order #12345 is ready',
    [
        'order_id' => '12345',
        'type' => 'order_update',
        'action' => 'view_order',
    ]
);
```

### Send to Topic

```php
// Subscribe users to topic first
$firebase->subscribeToTopic($fcmToken, 'promotions');

// Send to topic
$firebase->sendToTopic(
    'promotions',
    'Flash Sale!',
    'Limited time offer - 70% off!'
);
```

### Batch Sending

```php
$fcmTokens = User::whereNotNull('fcm_token')
    ->pluck('fcm_token')
    ->toArray();

$results = $firebase->sendToMultipleDevices(
    $fcmTokens,
    'Important Announcement',
    'Please update your app to the latest version'
);

// Results:
// [
//     'success' => 150,
//     'failed' => 5,
//     'errors' => [...]
// ]
```

## 📊 Monitoring & Logs

### Check Logs

```bash
tail -f storage/logs/laravel.log | grep FCM
```

### Success Log Example

```
[2026-04-14 12:00:00] local.INFO: FCM notification sent successfully
{
    "response": {
        "success": 1,
        "failure": 0,
        "results": [...]
    }
}
```

### Error Log Example

```
[2026-04-14 12:00:00] local.ERROR: FCM notification failed
{
    "status": 401,
    "response": "Unauthorized"
}
```

## 🐛 Troubleshooting

### Error: Unauthorized (401)

**Cause:** Invalid or missing FCM Server Key

**Solution:**
1. Check `.env` file has correct `FCM_SERVER_KEY`
2. Verify key in Firebase Console
3. Clear config cache: `php artisan config:clear`

### Error: Invalid Registration Token

**Cause:** FCM token is invalid or expired

**Solution:**
1. User needs to refresh FCM token in mobile app
2. Remove invalid tokens from database:
   ```php
   User::where('fcm_token', $invalidToken)->update(['fcm_token' => null]);
   ```

### Notifications Not Received

**Checklist:**
- ✅ FCM token saved in database
- ✅ User has granted notification permission
- ✅ App is properly configured with Firebase
- ✅ Server key is correct
- ✅ Check device logs for errors

### Testing Without Mobile App

Use Firebase Console to test:

1. Go to Firebase Console
2. Cloud Messaging → Send test message
3. Enter FCM token
4. Send

## 📱 Mobile App Code Examples

### Save FCM Token (API Endpoint)

Create this endpoint in your API:

```php
// routes/api.php
Route::post('/user/fcm-token', function (Request $request) {
    $request->validate([
        'fcm_token' => 'required|string',
    ]);

    $request->user()->update([
        'fcm_token' => $request->fcm_token,
    ]);

    return response()->json(['message' => 'FCM token saved']);
})->middleware('auth:sanctum');
```

### Handle Notification (Android)

```kotlin
class MyFirebaseMessagingService : FirebaseMessagingService() {
    override fun onMessageReceived(remoteMessage: RemoteMessage) {
        // Handle notification
        remoteMessage.notification?.let {
            showNotification(it.title, it.body)
        }

        // Handle data payload
        remoteMessage.data.isNotEmpty().let {
            val orderId = remoteMessage.data["order_id"]
            val type = remoteMessage.data["type"]
            // Handle custom data
        }
    }

    override fun onNewToken(token: String) {
        // Send new token to server
        sendTokenToServer(token)
    }
}
```

## 🎉 Summary

✅ Firebase Cloud Messaging fully implemented
✅ Send to single or multiple devices
✅ Target specific user groups
✅ Schedule notifications
✅ Topic-based messaging
✅ Error handling & logging
✅ Admin panel integration

## 📞 Support

If you encounter issues:
1. Check logs: `storage/logs/laravel.log`
2. Verify Firebase configuration
3. Test with Firebase Console
4. Check mobile app integration

---

**Made with ❤️ for better user engagement**
