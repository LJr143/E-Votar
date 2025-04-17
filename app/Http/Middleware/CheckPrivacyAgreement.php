<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckPrivacyAgreement
{
    public function handle(Request $request, Closure $next)
    {
        // Skip for privacy agreement route if you have one
        if ($request->is('privacy-policy')) {
            return $next($request);
        }

        // Check if cookie exists
        if (!Cookie::get('privacy_agreed')) {
            return redirect()->route('privacy.agreement');
        }

        return $next($request);
    }
}
