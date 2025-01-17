<?php

use App\Http\Controllers\CampusController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware(['superadmin.check', 'redirect.auth'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
    });

});


