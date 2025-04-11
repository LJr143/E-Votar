<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Gate::before(function ($user, $ability) {
//            return $user->hasRole('superadmin') ? true : null;
//        });

        Livewire::setScriptRoute(function ($handle) {
            return Route::get('/evotar/public/livewire/livewire.js', $handle);
        });

        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/evotar/public/livewire/update', $handle)
                ->middleware(['web']);
        });

        // Force Livewire to use HTTPS
        Livewire::forceAssetInjection();
        Paginator::useTailwind();
    }
}
