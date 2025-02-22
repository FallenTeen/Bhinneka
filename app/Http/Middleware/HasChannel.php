<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HasChannel
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || !$user->channels()->exists()) {
            if (!$request->is('channel/create')) {
                return redirect()->route('user.channel.create');
            }
        }
        if ($request->is('channel/create') && $user->channels()->exists()) {
            return redirect()->route('creator.channel');
        }
        return $next($request);
    }

}
