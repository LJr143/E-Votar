<?php

use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('home', [WebsiteController::class, 'Home'])->name('comelec-website.home');
Route::get('tutorial', [WebsiteController::class, 'Tutorial'])->name('comelec-website.tutorial');
Route::get('list-of-elections', [WebsiteController::class, 'List0fElections'])->name('comelec-website.list-of-elections');

Route::get('contact-us', [WebsiteController::class, 'ContactUs'])->name('comelec-website.contact-us');
Route::get('user-feedback', [WebsiteController::class, 'UserFeedback'])->name('comelec-website.user-feedback');

Route::get('website-login', [WebsiteController::class, 'WebsiteLogin'])->name('comelec-website.website-login');

Route::get('faqs', [WebsiteController::class, 'FAQs'])->name('comelec-website.faqs');


Route::get('selected-announcement', [WebsiteController::class, 'SelectedAnnouncement'])->name('comelec-website.selected-announcement');
Route::get('selected-election', [WebsiteController::class, 'SelectedElection'])->name('comelec-website.selected-election');
Route::get('selected-partylist', [WebsiteController::class, 'SelectedPartylist'])->name('comelec-website.selected-partylist');
