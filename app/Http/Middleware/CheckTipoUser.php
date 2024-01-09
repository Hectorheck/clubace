<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTipoUser
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
		// PARA TIPO DE ADMIN O SUPERADMIN?
		if (auth()->user()->tipo_usuarios_id > 2) {
			return redirect('/');
		}
		return $next($request);
	}
}
