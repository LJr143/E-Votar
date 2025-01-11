<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/superadmin/routes.php';
require __DIR__ . '/common/routes.php';

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

