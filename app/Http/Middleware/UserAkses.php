<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$type): Response
    {

        // Cek apakah pengguna terautentikasi dan memiliki peran admin
        if (Auth::check()) {
            if (in_array(Auth::user()->type, $type)) {
                
                return $next($request);
            }
            
            abort(403);
            // return redirect()->route('login');
            // if (Auth::user()->type === $type) {
        }
        
        // return $next($request);
        // Jika tidak, redirect atau tampilkan error
        abort(401);
        
    }
}
