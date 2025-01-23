<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AccessibilityController;
use App\Http\Controllers\EmployeeOrderController;
use App\Http\Controllers\Employee\OrderManagementController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return view('home', ['error' => null]);
})->name('home');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::middleware(['auth'])->group(function () {
        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        
        // Updated route for images
        Route::get('/storage/reviews/{filename}', [ReviewController::class, 'getImage'])
        ->name('reviews.image');
    });
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Accessibility routes
Route::post('/accessibility/font-size', [AccessibilityController::class, 'toggleFontSize'])
    ->name('accessibility.font-size');
Route::post('/accessibility/contrast', [AccessibilityController::class, 'toggleContrast'])
    ->name('accessibility.contrast');

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/orders/from-cart', [OrderController::class, 'storeFromCart'])->name('orders.storeFromCart');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [MenuController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.suck');
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::get('/admin/create', [MenuController::class, 'create'])->name('admin.menu.create');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    });

    // Employee routes (requires authentication and employee role)
    Route::middleware(['auth', 'role:employee'])->group(function () {
        Route::get('/employee/orders', [OrderManagementController::class, 'index'])
            ->name('employee.orders.index');
        Route::put('/employee/orders/{order}/status', [OrderManagementController::class, 'updateStatus'])
            ->name('employee.orders.updateStatus');
    });

});

Route::middleware(['auth', 'role:employee'])->group(function () {
    // Panel pracownika
    Route::get('/employee/orders', [OrderManagementController::class, 'index'])->name('employee.orders.index');
    Route::put('/employee/orders/{order}/status', [OrderManagementController::class, 'updateStatus'])->name('employee.orders.updateStatus');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';