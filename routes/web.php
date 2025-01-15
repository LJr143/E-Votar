<?php

use App\Http\Controllers\ElectionDashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;
use App\Models\Election;

Route::group(['middleware' => ['superadmin.check']], function () {

    Route::get('/', function () {
        return view('auth.login');
    });

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

    });


});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/register', [ViewController::class, 'view'])->name('register');
    Route::post('/register', [ViewController::class, 'register'])->name('register');

});


Route::group(['middleware' => ['admin.auth']], function () {

    Route::middleware(['role:superadmin, admin'])->group(function () {
        Route::get('/dashboard', 'AdminController@dashboard');

    });


    Route::middleware(['role:watcher'])->group(function () {
        Route::get('/watcher-dashboard', 'WatcherController@dashboard');

    });

    Route::middleware(['role:technical_officer'])->group(function () {
        Route::get('/technical-dashboard', 'TechnicalOfficerController@dashboard');

    });

    Route::middleware(['role:voter'])->group(function () {
        Route::get('/technical-dashboard', 'TechnicalOfficerController@dashboard');

    });
});


Route::get('/labels', [ElectionDashboardController::class, 'getLabels']);

Route::get('/api/election-end-time', function () {
    $latestElection = Election::latest()->first();

    // Check if an election exists
    if ($latestElection) {
        $startTime = $latestElection->date_started;
        $endTime = $latestElection->date_ended;
        return response()->json(['start_time' => $startTime, 'end_time' => $endTime]);
    }

    return response()->json(['error' => 'No election found'], 404);
});
