<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::match(['get', 'post'], 'logout', [AuthController::class, 'logout'])->name('logout');
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('verify-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp.form');
Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
Route::get('reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    });
});
Route::resource('suppliers', SupplierController::class)->except(['create', 'show', 'edit']);
Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
Route::get('/api/suppliers', [SupplierController::class, 'getSuppliers'])->name('suppliers.fetch');
Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
Route::resource('customers', CustomerController::class)->except(['create', 'show']);
Route::get('/api/customers/fetch', [CustomerController::class, 'getCustomers'])->name('customers.fetch');
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
Route::post('/medicines/store', [MedicineController::class, 'store'])->name('medicines.store');
Route::put('/medicines/{id}', [MedicineController::class, 'update'])->name('medicines.update');
Route::delete('/medicines/{id}', [MedicineController::class, 'destroy'])->name('medicines.destroy');
Route::get('/purchase-orders', [PurchaseOrderController::class, 'index'])->name('po.index');
// Ye routes lazmi honay chahiyen
Route::get('/purchase-orders/{id}/edit', [PurchaseOrderController::class, 'edit'])->name('po.edit');
Route::put('/purchase-orders/{id}', [PurchaseOrderController::class, 'update'])->name('po.update');
Route::post('/purchase-orders/store', [PurchaseOrderController::class, 'store'])->name('po.store');
Route::delete('/purchase-orders/{id}', [PurchaseOrderController::class, 'destroy'])->name('po.destroy');

/*
|--------------------------------------------------------------------------
| Static Page Routes
|--------------------------------------------------------------------------
*/

Route::view('/audit-logs', 'pages.audit')->name('audit.logs');

Route::view('/blank', 'pages.blank')->name('blank.page');

Route::view('/branch-management', 'pages.branch-management')->name('branch.management');


Route::view('/medicine-database', 'pages.medicine-database')->name('medicine.database');

Route::view('/pos', 'pages.pos')->name('pos');

// Route::view('/purchases', 'pages.purchases')->name('purchases');

Route::view('/reports', 'pages.reports')->name('reports');

Route::view('/roles-permissions', 'pages.rules-permission')->name('roles.permissions');

Route::view('/sales', 'pages.sales')->name('sales');

Route::view('/settings', 'pages.settings')->name('settings');
