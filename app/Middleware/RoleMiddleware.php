<?php

namespace App\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class RoleMiddleware
{
  public function handle($request, Closure $next, ...$roles)
  {
    if (!Auth::check()) {
      return redirect()->route('login');
    }

    $userRoles = $request->user()->roles()->pluck('name')->toArray();

    // If no matching role, block access
    if (!array_intersect($roles, $userRoles)) {
      abort(403, 'Unauthorized.');
    }

    return $next($request);
  }
}
