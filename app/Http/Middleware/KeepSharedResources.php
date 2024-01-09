<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Aplicaciones;

class KeepSharedResources
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
		/* ########## FORMA CORRECTA ########## */
		if ($token = $request->bearerToken()) {
			$app = Aplicaciones::where(['apikey' => $request->api_key, 'secretkey' => $request->bearerToken()])->first();
			if ($app) {
				$request->attributes->add(['application' => $app]);
				return $next($request);
			}
		}
		return response()->json('Debe autenticar correctamente su aplicación');
		/* ########## FORMA CORRECTA ########## */
	}
}
