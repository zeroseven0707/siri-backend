<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\HomeSectionController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// ─── Public ───────────────────────────────────────────────
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Public: home sections (mobile home page)
Route::get('/home', [HomeSectionController::class, 'index']);

// Public: stores & food
Route::get('/stores',              [StoreController::class, 'index']);
Route::get('/stores/{id}',         [StoreController::class, 'show']);
Route::get('/stores/{id}/foods',   [StoreController::class, 'foodItems']);
Route::get('/foods',               [FoodController::class, 'index']);
Route::get('/foods/{id}',          [FoodController::class, 'show']);
Route::get('/services',            [ServiceController::class, 'index']);
Route::get('/search',              SearchController::class);

// ─── Authenticated ────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profile
    Route::get('/profile',         [UserController::class, 'profile']);
    Route::put('/profile/update',  [UserController::class, 'updateProfile']);
    Route::post('/profile/update', [UserController::class, 'updateProfile']); // method spoofing for multipart
    Route::post('/profile/fcm-token', [UserController::class, 'updateFcmToken']);

    // Account security
    Route::post('/account/change-password',       [AccountController::class, 'changePassword']);
    Route::get('/account/login-history',          [AccountController::class, 'loginHistory']);
    Route::get('/account/devices',                [AccountController::class, 'activeDevices']);
    Route::delete('/account/devices/{id}',        [AccountController::class, 'revokeDevice']);
    Route::post('/account/devices/{id}/logout',   [AccountController::class, 'revokeDevice']);
    Route::delete('/account/devices',             [AccountController::class, 'revokeAllDevices']);
    Route::post('/account/logout-all',            [AccountController::class, 'revokeAllDevices']);
    Route::post('/account/delete-request',        [AccountController::class, 'requestDeletion']);
    Route::get('/account/delete-request',         [AccountController::class, 'deletionStatus']);
    Route::delete('/account/delete-request',      [AccountController::class, 'cancelDeletion']);

    // Orders (user)
    Route::middleware('role:user,admin')->group(function () {
        Route::post('/orders',      [OrderController::class, 'store']);
        Route::post('/food-orders', [OrderController::class, 'store']);
    });

    Route::get('/orders',             [OrderController::class, 'index']);
    Route::get('/orders/counts',      [OrderController::class, 'counts']);
    Route::get('/orders/{id}',        [OrderController::class, 'show']);
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancel']);
    Route::put('/orders/{id}/confirm',[OrderController::class, 'confirm']);
    Route::post('/orders/complete-by-token', [OrderController::class, 'completeByToken']);

    // Driver
    Route::middleware('role:driver')->prefix('driver')->group(function () {
        Route::get('/orders',                    [DriverController::class, 'availableOrders']);
        Route::post('/toggle-active',            [DriverController::class, 'toggleActive']);
        Route::put('/orders/{id}/accept',        [DriverController::class, 'acceptOrder']);
        Route::put('/orders/{id}/pickup',        [DriverController::class, 'pickupOrder']);
        Route::put('/orders/{id}/process',       [DriverController::class, 'processOrder']);
    });

    // Transactions (history only)
    Route::get('/transactions', [TransactionController::class, 'index']);

    // Notifications
    Route::get('/notifications',          [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);

    // Store management (owner or admin)
    Route::middleware('role:user,admin')->group(function () {
        Route::post('/stores',                                    [StoreController::class, 'store']);
        Route::put('/stores/{id}',                                [StoreController::class, 'update']);
        Route::delete('/stores/{id}',                             [StoreController::class, 'destroy']);
        Route::post('/stores/{id}/foods',                         [StoreController::class, 'addFoodItem']);
        Route::put('/stores/{storeId}/foods/{itemId}',            [StoreController::class, 'updateFoodItem']);
        Route::delete('/stores/{storeId}/foods/{itemId}',         [StoreController::class, 'deleteFoodItem']);
    });

    // ─── Posts (social feed) ─────────────────────────────
    Route::get('/posts',                                    [PostController::class, 'index']);
    Route::get('/posts/saved',                              [PostController::class, 'saved']);
    Route::get('/posts/my',                                 [PostController::class, 'myPosts']);
    Route::get('/posts/{id}',                               [PostController::class, 'show']);
    Route::post('/posts',                                   [PostController::class, 'store']);
    Route::delete('/posts/{id}',                            [PostController::class, 'destroy']);
    Route::post('/posts/{id}/like',                         [PostController::class, 'toggleLike']);
    Route::post('/posts/{id}/save',                         [PostController::class, 'toggleSave']);
    Route::post('/posts/{id}/report',                       [PostController::class, 'report']);
    Route::get('/posts/{id}/comments',                      [PostController::class, 'comments']);
    Route::post('/posts/{id}/comments',                     [PostController::class, 'addComment']);
    Route::delete('/posts/{postId}/comments/{commentId}',   [PostController::class, 'deleteComment']);

    // Users public profile
    Route::get('/users/{id}',                               [UserController::class, 'show']);
    Route::get('/users/{id}/posts',                         [PostController::class, 'userPosts']);

    // ─── Admin only ───────────────────────────────────────
    Route::middleware('role:admin')->prefix('admin')->group(function () {

        // Home section management
        Route::get('/home-sections',                              [HomeSectionController::class, 'adminIndex']);
        Route::post('/home-sections',                             [HomeSectionController::class, 'store']);
        Route::put('/home-sections/reorder',                      [HomeSectionController::class, 'reorder']);
        Route::put('/home-sections/{id}',                         [HomeSectionController::class, 'update']);
        Route::delete('/home-sections/{id}',                      [HomeSectionController::class, 'destroy']);

        // Section items
        Route::post('/home-sections/{sectionId}/items',           [HomeSectionController::class, 'addItem']);
        Route::put('/home-sections/{sectionId}/items/reorder',    [HomeSectionController::class, 'reorderItems']);
        Route::put('/home-sections/{sectionId}/items/{itemId}',   [HomeSectionController::class, 'updateItem']);
        Route::delete('/home-sections/{sectionId}/items/{itemId}',[HomeSectionController::class, 'deleteItem']);
    });
});
