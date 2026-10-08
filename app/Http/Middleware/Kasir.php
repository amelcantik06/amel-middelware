<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Kasir
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'kasir') {
            abort(403, 'Akses ditolak. Halaman ini khusus Kasir.');
        }

        return $next($request);
    }
}