<?php

use App\Http\Controllers\Auth\SuperadminAuth;
use Illuminate\Support\Facades\Route;

// Routes for super-admin registration
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/register', [SuperadminAuth::class, 'view'])->name('register');
    Route::post('/register', [SuperadminAuth::class, 'register'])->name('register');

    // Routes for super-admin login (protected by middleware)
    Route::middleware(['superadmin.check'])->group(function () {
        Route::get('/login', [SuperadminAuth::class, 'login'])->name('login');
        Route::post('/login', [SuperadminAuth::class, 'authenticate'])->name('login');

        Route::group(['middleware' => ['superadmin.auth'], 'prefix' => 'super-admin', 'as' => 'super-admin.'], function () {
            Route::get('/dashboard', [SuperadminAuth::class, 'dashboard'])->name('dashboard');
            Route::get('/elections', [SuperadminAuth::class, 'elections'])->name('elections');
            Route::get('/candidates', [SuperadminAuth::class, 'candidates'])->name('candidates');
        });
    });
});
