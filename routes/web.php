<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaymentController;

// Frontend Routes
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/company', [FrontendController::class, 'company'])->name('company');
Route::get('/order', [FrontendController::class, 'order'])->name('order');
Route::get('/search', [FrontendController::class, 'search'])->name('search');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

// Payment Routes
Route::get('/payment/qris/{orderId}', [PaymentController::class, 'createQRIS'])->name('payment.qris');
Route::post('/payment/notification', [PaymentController::class, 'handleNotification'])->name('payment.notification')->withoutMiddleware(['App\Http\Middleware\VerifyCsrfToken']);
Route::get('/payment/status/{orderId}', [PaymentController::class, 'checkStatus'])->name('payment.status');
Route::get('/payment/receipt/{orderId}', [PaymentController::class, 'showReceipt'])->name('payment.receipt');

// Auth Routes
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('auth.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Admin Routes (Protected - Admin and Cashier)
Route::middleware(['auth', \App\Http\Middleware\IsAdminOrCashier::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
    
    // Menu Items
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{menuItem}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{menuItem}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menuItem}', [MenuController::class, 'destroy'])->name('menu.destroy');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    // Reports
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales/print', [ReportController::class, 'salesPrint'])->name('reports.sales.print');
});
