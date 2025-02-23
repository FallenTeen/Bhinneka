<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    protected $roleIds = [
        'Admin' => 1,
        'Investor' => 2,
        'Creator' => 3,
        'User' => 4
    ];

    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role->role;
        $userRoleId = Auth::user()->role_id;

        if (is_numeric($roles[0])) {
            if (in_array($userRoleId, $roles)) {
                return $next($request);
            }
        } elseif (in_array($userRole, $roles)) {
            return $next($request);
        }

        return abort(404, 'Not Found');
    }
}