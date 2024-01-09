<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TerminosYCondiciones;
use App\Models\Clubes;

use App\Traits\AppCheck;

use Flash;

class TerminosYCondController extends Controller
{
	use AppCheck;
	public function __construct ()
	{
		// 
	}
	/* ########## TERMINOS Y CONDICIONES ########## */
	public function index ()
	{
		$terminos = TerminosYCondiciones::all();
		$clubes = Clubes::whereHas('api_info', function ($query) {
			$query->where('app', 1);
		})->get();
		return view('sistema.clubes.terminosycondiciones')
		->with(['terminos' => $terminos,'clubes' => $clubes,]);
	}
	public function get ($id)
	{
		$terminos = TerminosYCondiciones::find($id);
		return response()->json($terminos, 200);
		// response($content = '', $status = 200, array $headers = [])
	}
	public function apiGetTerminos (Request $request)
	{
		$var = self::checkApp($request);
		if ($var) {
			$terminos = TerminosYCondiciones::where('clubes_id', $var->id)
				->whereDate('fecha_actualizacion', '<=', date('Y-m-d'))
				->orderBy('fecha_actualizacion', 'DESC')
				->first();
			return $terminos;
		}
		$terminos = TerminosYCondiciones::where('clubes_id', 0)
			->whereDate('fecha_actualizacion', '<=', date('Y-m-d'))
			->orderBy('fecha_actualizacion', 'DESC')
			->first();
		return $terminos;
		// $terminos = TerminosYCondiciones::find($id);
		// return response()->json($terminos, 200);
		// response($content = '', $status = 200, array $headers = [])
	}
	public function store (Request $request)
	{
		/* ########## Crear nuevos terminos segun app general o para clubes específicos ########## */
		$val = $request->validate([
			'terminos' => 'required',
			'fecha_actualizacion' => 'required',
			'clubes_id' => 'required',
		]);
		$nuevo = TerminosYCondiciones::create($val);
		// RETORNAR VISTA => terminosycondiciones
		Flash::success('Cambios realizados');
		return redirect()->route('terminos.index');
	}
	public function update (Request $request, $id)
	{
		$val = $request->validate([
			'terminos' => 'required',
			'fecha_actualizacion' => 'required',
			'clubes_id' => 'required',
		]);
		$terminos = TerminosYCondiciones::findOrFail($id);
		$terminos->update($val);
		Flash::success('Cambios realizados');
		return redirect()->route('terminos.index');
	}
	public function delete ($id)
	{
		$terminos = TerminosYCondiciones::findOrFail($id);
		$terminos->delete($id);
		Flash::error('Registro eliminado');
		return redirect()->route('terminos.index');
	}
}










