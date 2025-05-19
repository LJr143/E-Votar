<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

// Admin Authentication Routes
Route::group(['middleware' => ['superadmin.check', 'redirect.auth']], function () {
    Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');
    Route::post('admin/login', [LoginController::class, 'authenticate'])->name('admin.login.post');
});

// Admin Protected Routes
Route::prefix('admin')->middleware(['splash.screen', 'check.deactivated', 'set.selected.election','single.voter.session', 'facial.verified', 'track.ip.user', 'clear.admin.voting'])->group(function () {
    Route::get('register', [ViewController::class, 'view'])->name('admin.register');
    Route::post('register', [ViewController::class, 'register'])->name('admin.register.post');
    Route::get('dashboard', [ViewController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('admin.auth');
    Route::get('elections', [ViewController::class, 'elections'])->name('admin.elections')->middleware('admin.auth:view election');
    Route::get('election/candidates', [ViewController::class, 'candidates'])->name('admin.candidates')->middleware('admin.auth:view candidate');
    Route::get('election/positions', [ViewController::class, 'positions'])->name('admin.positions');

    Route::get('election/results', [ViewController::class, 'electionResult'])->name('admin.election.result')->middleware('admin.auth:view election results');
    Route::get('voters', [ViewController::class, 'voter'])->name('admin.voters')->middleware('admin.auth:view voter');
    Route::get('system/users', [ViewController::class, 'systemUsers'])->name('admin.system.user')->middleware('admin.auth:view users');
    Route::get('college', [ViewController::class, 'college'])->name('admin.college')->middleware('admin.auth');
    Route::get('program', [ViewController::class, 'program'])->name('admin.program')->middleware('admin.auth');
    Route::get('program/major', [ViewController::class, 'programMajor'])->name('admin.program.major')->middleware('admin.auth');
    Route::get('council', [ViewController::class, 'council'])->name('admin.council')->middleware('admin.auth');
    Route::get('unregistered/admins', [ViewController::class, 'unregisteredAdmins'])->name('admin.unregistered.admin')->middleware('admin.auth');
    Route::post('unregistered/admins', [ViewController::class, 'registerAdmins'])->name('admin.unregistered.admin.post')->middleware('admin.auth');
    Route::get('election/party-list', [ViewController::class, 'partyList'])->name('admin.election.party.list')->middleware('admin.auth:view party list');
    Route::get('system/logs', [ViewController::class, 'systemLogs'])->name('admin.system.logs')->middleware('admin.auth:view system logs');
    Route::get('feedback', [ViewController::class, 'feedback'])->name('admin.feedback')->middleware('admin.auth:view feedback');
    Route::get('announcement', [ViewController::class, 'announcement'])->name('admin.announcement')->middleware('admin.auth:view website management');

    Route::get('account-settings', [ViewController::class, 'AccountSettings'])->name('admin.account-settings')->middleware('admin.auth');


    // Technical Officer Based Routes
    Route::get('technical/dashboard', [ViewController::class, 'technicalOfficerDashboard'])->name('technical-officer.dashboard')->middleware('admin.auth');
    Route::get('active-users', [ViewController::class, 'activeUsers'])->name('technical-officer.active.user')->middleware('admin.auth');
    Route::get('ip-records', [ViewController::class, 'ipRecords'])->name('technical-officer.ip.records')->middleware('admin.auth');
    Route::get('technical/database/backup', [ViewController::class, 'databaseBackup'])->name('technical-officer.database.backup')->middleware('admin.auth');

    // Watcher Based Routes
    Route::get('watcher/dashboard', [ViewController::class, 'watcherDashboard'])->name('watcher.dashboard')->middleware('admin.auth');

});
Route::get('vote/tally', [ViewController::class, 'voteTally'])->name('admin.vote.tally')->middleware('admin.auth:view vote tally');
