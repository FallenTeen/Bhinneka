<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            switch ($user->role->role) {
                case 'Admin':
                    return redirect()->route('admin.dashboard');
                case 'Creator':
                    return redirect()->route('creator.dashboard');
                case 'Investor':
                    return redirect()->route('investor.dashboard');
                default:
                    return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
