<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\FaceAuthController;
use App\Http\Controllers\FaceRegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\VoterElectionController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Election;
use Illuminate\Support\Facades\Session;

require __DIR__ . '/admin/routes.php';
require __DIR__ . '/voter/routes.php';
require __DIR__ . '/common/routes.php';
require __DIR__ . '/comelec-website/routes.php';


Route::get('/campuses', [CampusController::class, 'index'])->name('campuses');
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
    $redirectRoute = 'admin.login';

    if (Auth::check()) {
        $user = Auth::user();

        if ($user->hasRole('voter')) {
            $redirectRoute = 'voter.login';
        }

        if (config('session.driver') === 'database') {
            DB::table('sessions')->where('user_id', $user->id)->delete();
        }

        Session::flush();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    return redirect()->route($redirectRoute);
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

Route::post('/face/registration', [FaceRegistrationController::class, 'register'])->name('api.face.registration');

Route::get('/api/face/descriptors', [FaceAuthController::class, 'getDescriptors'])->name('api.face.get-descriptors');
Route::post('/api/face/verification', [FaceAuthController::class, 'verify'])->name('api.face.verification');

