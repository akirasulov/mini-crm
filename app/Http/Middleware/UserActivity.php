<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $now = Carbon::now();
            $expires_after = $now->addSeconds(30);
            auth()->user()->update(['updated_at' => $now]);
            Cache::put('user-online' . Auth::user()->id, true, $expires_after);
        }
        return $next($request);
    }
}
