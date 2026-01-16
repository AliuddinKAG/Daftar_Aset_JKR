<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Sila log masuk terlebih dahulu.');
        }

        if (!Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak mempunyai akses ke halaman ini.');
        }

        return $next($request);
    }
}