<?php

use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('home', [WebsiteController::class, 'Home'])->name('comelec-website.home');
Route::get('tutorial', [WebsiteController::class, 'Tutorial'])->name('comelec-website.tutorial');
Route::get('list-of-elections', [WebsiteController::class, 'List0fElections'])->name('comelec-website.list-of-elections');


Route::get('user-feedback', [WebsiteController::class, 'UserFeedback'])->name('comelec-website.user-feedback');

