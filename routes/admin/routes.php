<?php


use App\Http\Controllers\Auth\AdminAuth;
use Illuminate\Support\Facades\Route;

// Routes for Super-Admin
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [AdminAuth::class, 'dashboard'])->name('dashboard');
        Route::get('/elections', [AdminAuth::class, 'elections'])->name('elections');
        Route::get('/candidates', [AdminAuth::class, 'candidates'])->name('candidates');
        Route::get('/vote/tally', [AdminAuth::class, 'voteTally'])->name('vote.tally');
        Route::get('/election/results', [AdminAuth::class, 'electionResult'])->name('election.result');
        Route::get('/voters', [AdminAuth::class, 'voter'])->name('voters');
        Route::get('/system/users', [AdminAuth::class, 'systemUsers'])->name('system.user');
        Route::get('/election/party list', [AdminAuth::class, 'partyList'])->name('election.party.list');
        Route::get('/system/logs', [AdminAuth::class, 'systemLogs'])->name('system.logs');
    });
});

