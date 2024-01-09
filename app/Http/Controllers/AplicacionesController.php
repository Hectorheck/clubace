<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clubes;
use App\Models\Recintos;
use App\Models\Reservas;
use App\Models\Agenda;
use App\Models\Aplicaciones;
use App\Models\RecursosCompartidos;
use App\Models\ClubesDestacados;
use App\Models\ClubesApiInfo;

use Flash;
use Str;

use App\Traits\AppCheck;

class AplicacionesController extends Controller
{
	use AppCheck;
	public function test (Request $request)
	{
		$var = self::removeClub();
		return $var;
	}
	public function creaAceMatchTest ()
	{
		Aplicaciones::firstOrCreate([
			'aplicacion' => 'acematch',
		],[
			'apikey' => Str::random(40),
			'secretkey' => Str::random(80),
		]);
		return response()->json('OK');
	}
	public function store (Request $request)
	{
		// aplicacion	apikey	secretkey
		$request->validate([
			'aplicacion' => 'required|string',
		],[
			'aplicacion.required' => 'Debe registrar el nombre de su aplicacion',
		]);
		Aplicaciones::create([
			'aplicacion' => $request->aplicacion,
			'apikey' => Str::random(40),
			'secretkey' => Str::random(80),
		]);
		Flash::success('Aplicacion y tokens creados');
		return redirect()->back();
		/* ########## CREA REGISTROS EN APLICACIONES, PARA COMPARTIR ########## */
	}
	public function compartirTodo ()
	{
		$clubes = Clubes::all();
		foreach ($clubes as $key => $club) {
			RecursosCompartidos::create([
				'recurso' => 'Clubes',
				'recurso_id' => $club->id,
				'aplicaciones_id' => 1,
				'estado' => 'compartido',
			]);
		}
		Flash::success('Clubes compartidos con acematch');
		return redirect()->back();
		/* ########## FUNCION INICIAL PARA COMPARTIR TODOS LOS CLUBES CON ACEMATCH ########## */
	}
	public function clubes (Request $request)
	{
		$aplicacion = $request->get('application');
		$recursos = RecursosCompartidos::where(['recurso' => 'Clubes', 'aplicaciones_id'=> $aplicacion->id])
			->select('recurso_id')->get()->toArray();
		$clubes = Clubes::whereIn('id', $recursos)->get();
		return $clubes;
	}
}
