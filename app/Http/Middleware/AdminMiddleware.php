<?php

namespace App\Http\Middleware;

use App\dynamic_route;
use App\permission_role;
use Brian2694\Toastr\Facades\Toastr;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->type == 'admin') {
            $route_name = Request::route()->getName();
            $url = explode(".", $route_name)[1];
            $route_type = dynamic_route::where('url', $url)->first()->ajax;
            
            $role_id = Auth::user()->role->id;
         
            $url_check = permission_role::where('role_id', $role_id)->where('url', $url)->count();
        
            if (Auth::check() && $url_check !== 0) {
                return $next($request);
            } else {
                if ($route_type == 1) {
                    return response()->json(['permission' => false], 200);
                } else {
                    Toastr::error('you dont have that Permission', 'Error');
                    return redirect()->route('admin.adminDashboard');
                }
            }
        } else {
            return redirect()->route('login');
        }
    }
}
