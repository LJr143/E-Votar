<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

Route::get('/labels', [DashboardController::class, 'getLabels']);
Route::get('/registration/voter', [ViewController::class, 'voterRegistration'])->name('votar.registration');
Route::post('/registration/voter', [RegisterController::class, 'registerVoter'])->name('admin.register.voter');

Route::get('/api/register-face/{id}', [RegisterController::class, 'viewFacialRegistration'])->name('voter.facial.registration.get');
Route::post('/api/register-face/{id}', [RegisterController::class, 'registerFace'])->name('voter.facial.registration.post');
Route::post('/face/upload', [RegisterController::class, 'uploadFace'])->name('face.upload');

