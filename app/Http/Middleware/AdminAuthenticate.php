<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if(!empty(Auth::guard('admin')->check())) {
            return $next($request);
        } else {
            return redirect()->route('admin-login');
        }
    }
}
