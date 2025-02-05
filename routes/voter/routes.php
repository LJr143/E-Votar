<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

// Voter Authentication Routes
Route::group(['middleware' => ['superadmin.check', 'redirect.auth']], function () {
    Route::get('/', [LoginController::class, 'loginVoter'])->name('voter.login');
    Route::post('/', [LoginController::class, 'authenticateVoter'])->name('voter.login');
});

// Voter Protected Routes
Route::middleware('splash.screen', 'track.ip.user', 'facial.verified')->prefix('voter')->group(function () {
    Route::get('dashboard', [ViewController::class, 'voterDashboard'])->name('voter.dashboard')->middleware('voter.auth');
});
