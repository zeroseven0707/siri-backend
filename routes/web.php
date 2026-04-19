<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\PushNotificationController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\AccountDeletionController;

Route::get('/', function () {
    return view('welcome');
});

// Post share page — preview + deep link
Route::get('/post/{id}', function (string $id) {
    $post = \App\Models\Post::with('user')->find($id);
    if (!$post) abort(404);
    return view('post-share', compact('post'));
})->name('post.share');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminController::class, 'login'])->name('login');
        Route::post('login', [AdminController::class, 'authenticate'])->name('authenticate');
    });

    // Protected admin routes
    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');

        // Realtime badge count (lightweight AJAX endpoint)
        Route::get('orders/badge-count', function () {
            return response()->json(['count' => \App\Models\Order::where('status', 'accepted')->count()]);
        })->name('orders.badge-count');

        // Users Management
        Route::resource('users', UserController::class);

        // Orders Management
        Route::resource('orders', OrderController::class)->only(['index', 'show', 'destroy']);
        Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

        // Stores Management
        Route::resource('stores', StoreController::class);

        // Home Sections Management
        Route::resource('home-sections', HomeSectionController::class);

        // Push Notifications Management
        Route::resource('push-notifications', PushNotificationController::class)->except(['edit', 'update']);

        // Services Management
        Route::resource('services', ServiceController::class);

        // Transactions Management
        Route::resource('transactions', TransactionController::class)->only(['index', 'show']);

        // Account Deletion Requests
        Route::get('account-deletions', [AccountDeletionController::class, 'index'])->name('account-deletions.index');
        Route::get('account-deletions/{accountDeletion}', [AccountDeletionController::class, 'show'])->name('account-deletions.show');
        Route::post('account-deletions/{accountDeletion}/approve', [AccountDeletionController::class, 'approve'])->name('account-deletions.approve');
        Route::post('account-deletions/{accountDeletion}/reject', [AccountDeletionController::class, 'reject'])->name('account-deletions.reject');
    });
});
