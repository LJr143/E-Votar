<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'admin.auth'=> \App\Http\Middleware\AdminAuth::class,
            'voter.auth' => \App\Http\Middleware\VoterAuth::class,
            'superadmin.check' => \App\Http\Middleware\SuperadminChecker::class,
            'redirect.auth' =>\App\Http\Middleware\RedirectMiddleware::class,
            'splash.screen' => \App\Http\Middleware\SplashScreenMiddleware::class,
            'track.ip.user' => \App\Http\Middleware\TrackIpAddress::class,
            'facial.verified' => \App\Http\Middleware\FacialVerificationMiddleware::class,
            'voter.access' => \App\Http\Middleware\EnsureVoterCanAccessElection::class,
            'vote.checker' => \App\Http\Middleware\ElectionVoteChecker::class,
            'single.voter.session' => \App\Http\Middleware\SingleVoterSession::class,
            'set.selected.election' => \App\Http\Middleware\SetSelectedElection::class,
            'check.blocked.ip' => \App\Http\Middleware\CheckBlockedIp::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->withSchedule(function (Schedule $schedule) {
        $schedule->command('session:clean')->everyFiveMinutes();
        $schedule->command('backups:run')->everyMinute();
        $schedule->command('elections:update-status')->everyMinute();
    })->create();
