<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRegionManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $regionId = $request->route('region');  // Assuming region_id is passed in the route
    
        if (!$user->regions()->where('region_id', $regionId)->exists()) {
            return redirect()->route('unauthorized')->with('error', 'You do not have access to this region.');
        }
    
        return $next($request);
    }
}
