<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Public\AuthController as PublicAuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;

// Rotas públicas
Route::get('/login', [PublicAuthController::class, 'login'])->name('public.login');
Route::post('/login', [PublicAuthController::class, 'loginProcess'])->name('public.login.process');

Route::get('/register', [PublicAuthController::class, 'register'])->name('public.register');
Route::post('/register', [PublicAuthController::class, 'registerProcess'])->name('public.register.process');

Route::post('/logout', [PublicAuthController::class, 'logout'])->name('public.logout');


// Rotas admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'loginProcess'])->name('admin.login.process');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['admin'])->group(function () {
    Route::prefix('dash')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
});
