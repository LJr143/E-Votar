<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfFaceNotRegistered
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Check if user needs face registration
        if ($user && $user->needsFaceRegistration()) {
            // Store intended URL only if it's not already set
            if (!$request->session()->has('url.intended')) {
                $request->session()->put('url.intended', url()->current());
            }

            // For AJAX/Livewire requests, return a JSON response
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'redirect' => route('voter.facial.registration.get', ['id' => $user->id]),
                    'requires_face_registration' => true
                ], 403);
            }

            // For normal requests, redirect directly
            return redirect()->route('voter.facial.registration.get', ['id' => $user->id]);
        }

        return $next($request);
    }
}
