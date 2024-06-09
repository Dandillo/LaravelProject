<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Проверка роли пользователя
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role1, $role2 = null)
    {
        if (!auth()->user()) {
            abort(404);
        }
        if (isset($role2)) {
            if (!auth()->user()->hasRole($role1, $role2)) {
                abort(404);
            }
        } else {
            if (!auth()->user()->hasRole($role1)) {
                abort(404);
            }
        }

        return $next($request);
    }
}
