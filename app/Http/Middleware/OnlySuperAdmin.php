<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlySuperAdmin
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
		if (auth()->user()->tipo_usuarios_id > 1) {
			return redirect('/');
		}
		return $next($request);
	}
}
