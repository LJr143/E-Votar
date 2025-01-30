<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;
use App\Models\Election;

require __DIR__.'/admin/routes.php';

Route::group(['middleware' => ['superadmin.check', 'redirect.auth']], function () {

    Route::get('/', function () {
        return view('auth.login');
    });



});


Route::get('/labels', [DashboardController::class, 'getLabels']);

Route::get('/registration/voter', [ViewController::class, 'voterRegistration'])->name('votar.registration');
Route::post('/registration/voter', [RegisterController::class, 'registerVoter'])->name('admin.register.voter');

Route::get('/api/register-face', [RegisterController::class, 'viewFacialRegistration'])->name('voter.facial.registration.get');
Route::post('/api/register-face', [RegisterController::class, 'registerFace'])->name('voter.facial.registration.post');
Route::post('/face/upload', [RegisterController::class, 'uploadFace'])->name('face.upload');







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

// Campus Management Routes
Route::get('/campuses', [CampusController::class, 'index']);
Route::get('/colleges/{campusId}', [CampusController::class, 'getColleges']);
Route::get('/programs/{collegeId}', [CampusController::class, 'getPrograms']);
Route::get('/majors/{programId}', [CampusController::class, 'getMajors']);
Route::get('/roles', [CampusController::class, 'getRoles']);
