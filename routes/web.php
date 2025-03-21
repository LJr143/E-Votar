<?php

use App\Http\Controllers\CampusController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VoterElectionController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\Models\Election;

require __DIR__ . '/admin/routes.php';
require __DIR__ . '/voter/routes.php';
require __DIR__ . '/common/routes.php';
require __DIR__ . '/comelec-website/routes.php';



//Route::get('/api/election-end-time', function () {
//    $latestElection = Election::latest()->first();
//
//    if ($latestElection) {
//        $startTime = $latestElection->date_started;
//        $endTime = $latestElection->date_ended;
//        return response()->json(['start_time' => $startTime, 'end_time' => $endTime]);
//    }
//
//    return response()->json(['error' => 'No election found'], 404);
//})->name('election.date.time');


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

Route::post('/update-face-verified', [LoginController::class, 'updateFaceVerified'])->name('update.face.verified');

Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);


Route::post('/logout', function (Request $request) {
    if (Auth::check()) {
        Auth::logout();

        Session::flush();
        Auth::logout();

        if (config('session.driver') === 'database') {
            \DB::table('sessions')->where('user_id', Auth::id())->delete();
        }
    }
    // Redirect to Google Logout
    return redirect('https://accounts.google.com/Logout');
})->name('logout');

Route::get('/fetch-elections/{voterId}', [VoterElectionController::class, 'getElectionsForVoter'])->name('fetch.elections');
Route::get('/api/election-end-time/{electionId?}', [VoterElectionController::class, 'getElectionEndTime']);
Route::get('/api/election-end-time/{electionId}', function ($electionId) {
    $election = Election::find($electionId);

    if ($election) {
        $startTime = Carbon::parse($election->date_started)->toIso8601String();
        $endTime = Carbon::parse($election->date_ended)->toIso8601String();
        return response()->json(['start_time' => $startTime, 'end_time' => $endTime]);
    }

    return response()->json(['error' => 'Election not found'], 404);

})->name('election.end.time');





