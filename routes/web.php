<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::match(['get','post'],'logout', [AuthController::class, 'logout'])->name('logout');
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




/*
|--------------------------------------------------------------------------
| Static Page Routes
|--------------------------------------------------------------------------
*/

Route::view('/audit-logs', 'pages.audit')->name('audit.logs');

Route::view('/blank', 'pages.blank')->name('blank.page');

Route::view('/branch-management', 'pages.branch-management')->name('branch.management');

Route::view('/customers', 'pages.customers')->name('customers');

Route::view('/inventory', 'pages.inventory')->name('inventory');

Route::view('/medicine-database', 'pages.medicine-database')->name('medicine.database');

Route::view('/pos', 'pages.pos')->name('pos');

Route::view('/purchases', 'pages.purchases')->name('purchases');

Route::view('/reports', 'pages.reports')->name('reports');

Route::view('/roles-permissions', 'pages.rules-permission')->name('roles.permissions');

Route::view('/sales', 'pages.sales')->name('sales');

Route::view('/settings', 'pages.settings')->name('settings');

Route::view('/suppliers', 'pages.supplier')->name('suppliers');
