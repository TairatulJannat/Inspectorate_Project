<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;


class dealWithPrefix
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
        $role = $request->user()->role->slag;
        URL::defaults([
            'roleBased' => $role
        ]);
        $request->route()->forgetParameter('roleBased');
        return $next($request);
    }
}
