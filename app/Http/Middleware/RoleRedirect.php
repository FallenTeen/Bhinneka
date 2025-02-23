<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirect
{
    protected $roleRedirects = [
        'Admin' => 'admin.dashboard',
        'Investor' => 'investor.dashboard',
        'Creator' => 'creator.dashboard',
        'User' => 'user.dashboard'
    ];

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role->role;
            $redirectRoute = $this->roleRedirects[$userRole] ?? 'home';
            return redirect()->route($redirectRoute);
        }

        return $next($request);
    }
}