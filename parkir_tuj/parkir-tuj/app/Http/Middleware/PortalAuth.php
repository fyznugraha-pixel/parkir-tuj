<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PortalAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('portal_user_id')) {
            return redirect()->route('portal.login')
                ->with('error', 'Silakan login terlebih dahulu');
        }
        
        return $next($request);
    }
}