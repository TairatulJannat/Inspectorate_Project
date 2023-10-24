<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::guard('user')->check()) {
            return redirect('user/userdashboard');
        }
        if (Auth::guard('provider')->check()) {
            return redirect('provider/providerdashboard');
        }
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->type == 'admin') {
            return redirect('admin/adminDashboard');
        }
        if (Auth::guard('admin')->check()) {
            Toastr::error('you dont have that Permission', 'Permission Denied');
            return $next($request);
        }
        return $next($request);
    }
}
