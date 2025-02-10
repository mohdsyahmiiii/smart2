<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if ($role === 'lecturer' && !$request->user()->isLecturer()) {
            abort(403, 'Unauthorized action.');
        }

        if ($role === 'student' && !$request->user()->isStudent()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 