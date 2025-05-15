<?php

namespace App\Providers;

use App\Auth\EncryptedUserProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
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

//        Livewire::setScriptRoute(function ($handle) {
//            return Route::get('/evotar/public/livewire/livewire.js', $handle);
//        });
//
//        Livewire::setUpdateRoute(function ($handle) {
//            return Route::post('/evotar/public/livewire/update', $handle)
//                ->middleware(['web']);
//        });

        Auth::provider('encrypted', function ($app, array $config) {
            return new EncryptedUserProvider($app['hash'], $config['model']);
        });

        Blade::stringable(function (\Carbon\Carbon $date) {
            return $date->format('M j, Y');
        });
        DB::statement("SET time_zone = '+08:00'");

//        // Force Livewire to use HTTPS
//        Livewire::forceAssetInjection();
        Paginator::useTailwind();
    }
}
