<?php

use App\Http\Controllers\Auth\CustomNewPasswordController;
use App\Http\Controllers\Auth\CustomPasswordResetLinkController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\FaceAuthController;
use App\Http\Controllers\FaceRegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\VoterElectionController;
use App\Livewire\ConfirmAcademicDetails;
use App\Livewire\VoterVerification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Election;
use Illuminate\Http\Request;

require __DIR__ . '/admin/routes.php';
require __DIR__ . '/voter/routes.php';
require __DIR__ . '/common/routes.php';
require __DIR__ . '/comelec-website/routes.php';

Route::group(['middleware' => ['check.first.creation.superadmin']], function () {
    Route::get('register/first', [ViewController::class, 'viewSuperadminRegister'])->name('admin.register.get.superadmin');
    Route::post('register/first', [ViewController::class, 'registerSuperadminRegister'])->name('admin.register.post.superadmin');
});

Route::get('login', function () {
   return redirect(route('voter.login'));
});

Route::get('/login', fn () => redirect('/'))->name('login');


Route::post('/forgot-password', [CustomPasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [CustomNewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');


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

//        Session::flush();
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
        $startTime = Carbon::parse($election->date_started)->timezone('Asia/Manila')->toIso8601String();
        $endTime = Carbon::parse($election->date_ended)->timezone('Asia/Manila')->toIso8601String();
        return response()->json(['start_time' => $startTime, 'end_time' => $endTime]);
    }

    return response()->json(['error' => 'Election not found'], 404);

})->name('election.end.time');

Route::post('/face/registration', [FaceRegistrationController::class, 'register'])->name('api.face.registration');

Route::get('/api/face/descriptors', [FaceAuthController::class, 'getDescriptors'])->name('api.face.get-descriptors');
Route::post('/api/face/verification', [FaceAuthController::class, 'verify'])->name('api.face.verification');



