<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    AdminAuthController,
    DashboardController,
    CategoryController,
    ProductController,
    OrderController,
    NotificationController
};

/*
|--------------------------------------------------------------------------
| PUBLIC (WELCOME)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | GUEST (NOT LOGGED IN ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    /*
    |--------------------------------------------------------------------------
    | PROTECTED ADMIN AREA
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Profile
        Route::get('/profile', [AdminAuthController::class, 'profile'])
            ->name('profile');
        Route::put('/profile', [AdminAuthController::class, 'updateProfile'])
            ->name('profile.update');
        Route::put('/profile/password', [AdminAuthController::class, 'updatePassword'])
            ->name('profile.password');

        // Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('logout');

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])
            ->name('notifications.index');
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
            ->name('notifications.readAll');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
            ->name('notifications.destroy');
        Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])
            ->name('notifications.unreadCount');

        /*
        |--------------------------------------------------------------------------
        | CATEGORY CRUD
        |--------------------------------------------------------------------------
        */
        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])
            ->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');
        Route::get('/categories/{id}', [CategoryController::class, 'show'])
            ->name('categories.show');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])
            ->name('categories.edit');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])
            ->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');

        /*
        |--------------------------------------------------------------------------
        | PRODUCT CRUD
        |--------------------------------------------------------------------------
        */
        Route::get('/products', [ProductController::class, 'index'])
            ->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])
            ->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])
            ->name('products.destroy');

        /*
        |--------------------------------------------------------------------------
        | ORDERS
        |--------------------------------------------------------------------------
        */
        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/{id}', [OrderController::class, 'show'])
            ->name('orders.show');

        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

    });

});