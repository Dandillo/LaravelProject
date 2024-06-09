<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_banned) {
            $message = "Ваш аккаунт был заблокирован";
            if (isset(auth()->user()->ban_desc)) {
                $message .= " Причина: ". auth()->user()->ban_desc;
            }
            auth()->logout();

            return redirect()->route('login')->withMessage($message);
        }
        return $next($request);
    }
}
