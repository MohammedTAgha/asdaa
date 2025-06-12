<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if (Auth::check()) {
            if ($request->route()->getName() === 'logout') {
                ActivityLog::log(
                    'LOGOUT',
                    'User',
                    auth()->id(),
                    'User logged out'
                );
            }
        }
    }
}
