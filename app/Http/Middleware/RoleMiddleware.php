<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // if (auth()->check() && auth()->user()->role->name === $role) {
        //     return $next($request);
        // }
        // return redirect('/');

        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        if (!in_array($user->role->name, $roles)) {
            abort(403, 'Unauthorized');
        }
        
        return $next($request);
    }
}
