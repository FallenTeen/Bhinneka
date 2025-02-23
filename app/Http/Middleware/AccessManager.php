<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessManager
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // USERRR (role_id = 4)
        if ($user->role->id == 4) {
            if (
                ($user->channels->isNotEmpty() && !$user->channels->first()->verified) ||
                ($user->investors->isNotEmpty() && !$user->investors->first()->verified)
            ) {
                if (!$request->routeIs('waiting')) {
                    return redirect()->route('waiting');
                }
            }
            else {
                $allowedRoutes = [
                    'user.channel.create',
                    'user.investor.create',
                    'user.dashboard'
                ];

                if (!in_array($request->route()->getName(), $allowedRoutes)) {
                    return redirect()->route('user.dashboard');
                }
            }
        }

        // CCCCC (role_id = 3)
        if ($user->role->id == 3) {
            if ($user->channels->isNotEmpty()) {
                if (!$user->channels->first()->verified) {
                    if (!$request->routeIs('waiting')) {
                        return redirect()->route('waiting');
                    }
                }
                if ($request->routeIs('user.channel.create') || $request->routeIs('waiting')) {
                    return redirect()->route('creator.dashboard');
                }
            } else {
                if (!$request->routeIs('waiting')) {
                    return redirect()->route('waiting');
                }
            }
        }
        // INVESTROS (role_id = 2)
        if ($user->role->id == 2) {
            if ($user->investors->isNotEmpty()) {
                if (!$user->investors->first()->verified) {
                    if (!$request->routeIs('waiting')) {
                        return redirect()->route('waiting');
                    }
                }
                if ($request->routeIs('user.investor.create') || $request->routeIs('waiting')) {
                    return redirect()->route('investor.dashboard');
                }
            } else {
                if (!$request->routeIs('waiting')) {
                    return redirect()->route('waiting');
                }
            }
        }

        return $next($request);
    }
}