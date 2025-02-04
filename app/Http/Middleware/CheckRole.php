<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if ($request->path() === '/') {
            return $next($request);
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $adminRoutes = [
            '/dashboard',
            '/',
        ];
        $userRoutes = [
            '/',
        ];

        if ($user->role->role === ['Admin','Investor','Creator']) {
            // Admin dapat mengakses semua route yang ada di whitelist
            return $next($request);
            
        } 
        elseif ($user->role->role === ['user','Guest']) {
            // User hanya dapat mengakses route yang ada di whitelist
            if (!in_array($request->path(), $userRoutes)) {
                return redirect('/'); // Redirect ke /
            }
            return $next($request);
        }

        return $next($request);
    }
}
