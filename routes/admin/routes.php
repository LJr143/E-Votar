<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

// Admin Authentication Routes
Route::middleware(['superadmin.check'])->group(function () {
    Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');
    Route::post('admin/login', [LoginController::class, 'authenticate'])->name('admin.login');
});

// Admin Protected Routes
Route::middleware('splash.screen', 'track.ip.user')->prefix('admin')->group(function () {
    Route::get('register', [ViewController::class, 'view'])->name('admin.register');
    Route::post('register', [ViewController::class, 'register'])->name('admin.register');

    Route::get('dashboard', [ViewController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('admin.auth');
    Route::get('elections', [ViewController::class, 'elections'])->name('admin.elections')->middleware('admin.auth:view election');
    Route::get('election/candidates', [ViewController::class, 'candidates'])->name('admin.candidates')->middleware('admin.auth:view candidate');
    Route::get('election/positions', [ViewController::class, 'positions'])->name('admin.positions');
    Route::get('vote/tally', [ViewController::class, 'voteTally'])->name('admin.vote.tally')->middleware('admin.auth:view vote tally');
    Route::get('election/results', [ViewController::class, 'electionResult'])->name('admin.election.result')->middleware('admin.auth:view election results');
    Route::get('voters', [ViewController::class, 'voter'])->name('admin.voters')->middleware('admin.auth');
    Route::get('system/users', [ViewController::class, 'systemUsers'])->name('admin.system.user')->middleware('admin.auth:view users');
    Route::get('unregistered/admins', [ViewController::class, 'unregisteredAdmins'])->name('admin.unregistered.admin')->middleware('admin.auth');
    Route::post('unregistered/admins', [ViewController::class, 'registerAdmins'])->name('admin.unregistered.admin')->middleware('admin.auth');
    Route::get('election/party-list', [ViewController::class, 'partyList'])->name('admin.election.party.list')->middleware('admin.auth:view party list');
    Route::get('system/logs', [ViewController::class, 'systemLogs'])->name('admin.system.logs')->middleware('admin.auth:view system logs');

    // Technical Officer Based Routes
    Route::get('dashboard/technical-officer', [ViewController::class, 'technicalOfficerDashboard'])->name('technical-officer.dashboard');
    Route::get('active-users', [ViewController::class, 'activeUsers'])->name('technical-officer.active.user');
    Route::get('ip-records', [ViewController::class, 'ipRecords'])->name('technical-officer.ip.records');
});
