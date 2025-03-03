<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\VoterElectionController;
use Illuminate\Support\Facades\Route;

// Voter Authentication Routes
Route::group(['middleware' => ['superadmin.check', 'redirect.auth']], function () {
    Route::get('/', [LoginController::class, 'loginVoter'])->name('voter.login');
    Route::post('/', [LoginController::class, 'authenticateVoter'])->name('voter.login');
});

// Voter Protected Routes
Route::middleware('splash.screen', 'track.ip.user', 'facial.verified')->prefix('voter')->group(function () {
    Route::get('available/election', [VoterElectionController::class, 'voterElectionRedirect'])->name('voter.election.redirect')->middleware('voter.auth');
    Route::get('/dashboard/{slug}', [VoterElectionController::class, 'voterDashboard'])->name('dashboard')->middleware(['voter.auth', 'voter.access']);
    Route::get('step-1-tutorial', [ViewController::class, 'step1Tutorial'])->name('voter.step1')->middleware('voter.auth');
    Route::get('step-2-tutorial', [ViewController::class, 'step2Tutorial'])->name('voter.step2')->middleware('voter.auth');
    Route::get('/voting-process/{slug}', [VoterElectionController::class, 'voting'])->name('voter.voting')->middleware(['voter.auth', 'vote.checker']);
    Route::get('/voting/vote-submission', [VoterElectionController::class, 'confirmVoting'])->name('voter.voting.confirm')->middleware('voter.auth');

    Route::get('/verify-vote', [VoterElectionController::class, 'showVerifyVotePage']) ->name('verify.vote.page')->middleware('auth');
    Route::post('/verify-vote', [VoterElectionController::class, 'verifyVote'])->name('verify.vote.submit')->middleware('auth');
    Route::get('/download-receipt/{id}', [VoterElectionController::class, 'downloadReceipt'])->name('voter.download.receipt');
});




