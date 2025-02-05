<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;
use App\Models\Election;

require __DIR__.'/admin/routes.php';
require __DIR__.'/voter/routes.php';
require __DIR__.'/common/routes.php';




Route::get('/api/election-end-time', function () {
    $latestElection = Election::latest()->first();

    if ($latestElection) {
        $startTime = $latestElection->date_started;
        $endTime = $latestElection->date_ended;
        return response()->json(['start_time' => $startTime, 'end_time' => $endTime]);
    }

    return response()->json(['error' => 'No election found'], 404);
});


// Campus Management Routes
Route::get('/campuses', [CampusController::class, 'index']);
Route::get('/colleges/{campusId}', [CampusController::class, 'getColleges']);
Route::get('/programs/{collegeId}', [CampusController::class, 'getPrograms']);
Route::get('/majors/{programId}', [CampusController::class, 'getMajors']);
Route::get('/roles', [CampusController::class, 'getRoles']);

Route::get('/facial-authentication', function () {
    return view('evotar.auth.facial-recognition');
})->name('face.verify');

Route::get('/profile-image/{filename}', function ($filename) {
    $path = storage_path("app/private/private/assets/profile/{$filename}");

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});

Route::post('/update-face-verified', [LoginController::class, 'updateFaceVerified']);

Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);


Route::post('/logout', function (Request $request) {
    Auth::logout(); // Logout from Laravel

    // Invalidate the session
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirect to Google Logout
    return redirect('https://accounts.google.com/Logout');
})->name('logout');
