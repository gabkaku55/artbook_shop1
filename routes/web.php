<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UnboxingVideoController as AdminUnboxingVideoController;

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [ProductController::class, 'index'])->name('catalog');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/about', function () { return view('pages.about'); })->name('about');
Route::get('/delivery', function () { return view('pages.delivery'); })->name('delivery');
Route::get('/contacts', function () { return view('pages.contacts'); })->name('contacts');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/login/2fa', 'show2FA')->name('login.2fa');
    Route::post('/login/2fa', 'verify2FA');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');

    Route::get('/forgot-password', 'showForgotPassword')->name('password.request');
    Route::post('/forgot-password', 'sendResetCode')->name('password.email');
    Route::get('/reset-password', 'showResetPassword')->name('password.reset.form');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

Route::prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/add/{product}', 'add')->name('add');
    Route::post('/update', 'update')->name('update');
    Route::post('/remove/{product}', 'remove')->name('remove');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store']);
    Route::get('/checkout/bank-details', [CheckoutController::class, 'showBankDetails'])->name('checkout.bank-details');
    Route::post('/checkout/bank-details', [CheckoutController::class, 'submitBankReceipt']);
    
    Route::get('/payment/{order}', [CheckoutController::class, 'payment'])->name('payment');
    Route::post('/payment/{order}', [CheckoutController::class, 'processPayment']);
    Route::get('/payment/success/{order}', [CheckoutController::class, 'success'])->name('payment.success');

    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('review.store');
    
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/profile', [HomeController::class, 'updateProfile'])->name('profile.update');
    Route::get('/order/{order}', [CheckoutController::class, 'showOrder'])->name('order.show');
    Route::post('/order/{order}/cancel', [CheckoutController::class, 'cancelOrder'])->name('order.cancel');
    Route::post('/order/{order}/receipt', [CheckoutController::class, 'uploadReceipt'])->name('order.receipt');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', AdminCategoryController::class)
        ->except(['show', 'create', 'edit'])
        ->names([
            'index' => 'categories.index',
            'store' => 'categories.store',
            'update' => 'categories.update',
            'destroy' => 'categories.delete',
        ]);

    Route::resource('products', AdminProductController::class)
        ->except(['show'])
        ->names([
            'index' => 'products.index',
            'create' => 'products.create',
            'store' => 'products.store',
            'edit' => 'products.edit',
            'update' => 'products.update',
            'destroy' => 'products.delete',
        ]);

    Route::resource('orders', AdminOrderController::class)
        ->only(['index', 'create', 'store', 'show', 'destroy'])
        ->names([
            'index' => 'orders.index',
            'create' => 'orders.create',
            'store' => 'orders.store',
            'show' => 'orders.show',
            'destroy' => 'orders.delete',
        ]);
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

    Route::resource('users', AdminUserController::class)
        ->only(['index', 'destroy'])
        ->names([
            'index' => 'users.index',
            'destroy' => 'users.delete',
        ]);
    Route::post('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.role');

    Route::resource('unboxing-videos', AdminUnboxingVideoController::class)
        ->except(['show'])
        ->names([
            'index' => 'unboxing-videos.index',
            'create' => 'unboxing-videos.create',
            'store' => 'unboxing-videos.store',
            'edit' => 'unboxing-videos.edit',
            'update' => 'unboxing-videos.update',
            'destroy' => 'unboxing-videos.delete',
        ]);

    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/2fa', [AdminProfileController::class, 'toggle2FA'])->name('profile.2fa');

    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'adminIndex'])->name('chat.index');
    Route::get('/chat/{user}', [\App\Http\Controllers\ChatController::class, 'adminShow'])->name('chat.show');
    Route::post('/chat/{user}', [\App\Http\Controllers\ChatController::class, 'adminStore'])->name('chat.store');
});

Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat');
Route::post('/chat', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.send');
