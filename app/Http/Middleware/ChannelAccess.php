<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChannelAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user->role->id == 4) {
            if ($user->channels->isNotEmpty()) {
                $channel = $user->channels->first();
                if (!$channel->verified) {
                    if ($request->is('channel/*') && !$request->routeIs('channel.waiting')) {
                        return redirect()->route('channel.waiting');
                    }
                }
            } else {
                if (!$request->routeIs('user.channel.create')) {
                    return redirect()->route('user.channel.create');
                }
            }
        }
        if ($user->role->id == 3) {
            if ($user->channels->isNotEmpty()) {
                if ($request->routeIs('user.channel.create') || $request->routeIs('channel.waiting')) {
                    return redirect()->route('creator.dashboard');
                }
            } else {
                if (!$request->routeIs('channel.waiting')) {
                    return redirect()->route('channel.waiting');
                }
            }
        }

        return $next($request);
    }
}