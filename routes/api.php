<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    AuthController,
    ProductController,
    CategoryController,
    CartController,
    WishlistController,
    OrderController,
    ProfileController,
    ReviewController
};

Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    /*
    |--------------------------------------------------------------------------
    | PUBLIC DATA
    |--------------------------------------------------------------------------
    */
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/products/{id}/reviews', [ReviewController::class, 'productReviews']);
    Route::get('/categories', [CategoryController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | PROTECTED ROUTES (SANCTUM REQUIRED)
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {

        // Profile
        Route::get('/me', [ProfileController::class, 'me']);
        Route::put('/me', [ProfileController::class, 'update']);
        Route::put('/me/password', [ProfileController::class, 'updatePassword']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Cart
        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart', [CartController::class, 'store']);
        Route::put('/cart/{id}', [CartController::class, 'update']);
        Route::delete('/cart/{id}', [CartController::class, 'destroy']);

        // Wishlist
        Route::get('/wishlist', [WishlistController::class, 'index']);
        Route::post('/wishlist', [WishlistController::class, 'store']);
        Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);

        // Orders
        Route::post('/checkout', [OrderController::class, 'checkout']);
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{id}', [OrderController::class, 'show']);

        // Reviews
        Route::post('/review', [ReviewController::class, 'store']);
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN TEST ENDPOINTS (for testing admin features)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {
        Route::post('/login', [App\Http\Controllers\Admin\AdminAuthController::class, 'apiLogin']);
        
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/dashboard/stats', [App\Http\Controllers\Admin\DashboardController::class, 'apiStats']);
            Route::get('/dashboard/charts', [App\Http\Controllers\Admin\DashboardController::class, 'apiCharts']);
            Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'apiIndex']);
            Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'apiIndex']);
            Route::get('/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'apiIndex']);
            Route::get('/notifications/unread-count', [App\Http\Controllers\Admin\NotificationController::class, 'getUnreadCount']);
        });
    });

});