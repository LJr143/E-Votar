<?php

use App\Http\Controllers\FaceAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth')->group(function () {
    // Get registered descriptors for current user
    Route::get('/face/descriptors', [FaceAuthController::class, 'getDescriptors'])
        ->name('api.face.get-descriptors');

    // Verify face against registered data
    Route::post('/face/verify', [FaceAuthController::class, 'verify'])
        ->name('api.face.verify');
});
