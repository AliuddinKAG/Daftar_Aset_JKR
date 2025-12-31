<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Sila log masuk terlebih dahulu.');
        }

        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses Ditolak. Hanya admin yang dibenarkan.');
        }

        return $next($request);
    }
}