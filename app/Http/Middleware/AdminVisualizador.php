<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminVisualizador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->tipo_usuarios_id == 7 || auth()->user()->tipo_usuarios_id == 2) {
            return $next($request);
        }else{
			return redirect()->back()->with("message","usuario no autorizado");

        }

    }
}
