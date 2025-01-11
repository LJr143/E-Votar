<?php

use App\Http\Controllers\CampusController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware(['superadmin.check', 'redirect.auth'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

});

// Campus Management Routes
Route::get('/campuses', [CampusController::class, 'index']);
Route::get('/colleges/{campusId}', [CampusController::class, 'getColleges']);
Route::get('/programs/{collegeId}', [CampusController::class, 'getPrograms']);
Route::get('/majors/{programId}', [CampusController::class, 'getMajors']);
