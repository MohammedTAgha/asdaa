<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;

class LogSessionActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        if (auth()->check()) {
            $user = auth()->user();
            // Log::info('log');

            // Log::info($request);
            // Log successful login
            if ($request->is('login') && $request->isMethod('post')) {
                ActivityLog::log(
                    'LOGIN',
                    'User',
                    $user->id,
                    'User logged in successfully -LogSessionActivity'
                );
            }
            
            // Log logout
            if ($request->is('logout')) {
                Log::alert('LOGOUT');
                ActivityLog::log(
                    'LOGOUT',
                    'User',
                    $user->id,
                    'User logged out'
                );
            }

            // Log session timeouts
            if ($request->is('session/expired')) {
                ActivityLog::log(
                    'SESSION_TIMEOUT',
                    'User',
                    $user->id,
                    'User session timed out'
                );
            }
        }

        return $response;
    }
}
