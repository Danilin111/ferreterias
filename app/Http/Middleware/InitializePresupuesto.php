<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InitializePresupuesto
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('presupuesto')) {
            session(['presupuesto' => 0]); 
        }
        return $next($request);
    }
}
