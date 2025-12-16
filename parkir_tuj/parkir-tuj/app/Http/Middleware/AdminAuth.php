<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah admin sudah login (ada session admin_id)
        if (!Session::has('admin_id')) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }
        
        return $next($request);
    }
}


