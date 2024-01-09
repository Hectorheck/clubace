<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Servicios;
use App\Models\Recintos;
use App\Models\Agenda;
use App\Models\Clubes;
use Flash;

class ServiciosController extends Controller
{
	public function index($club)
	{
		$data = Clubes::find($club);
		return view('sistema.servicios.index')->with([
			'servicios' => Servicios::whereClubesId($club)->latest()->get(),
			'club' => $club,
			'data' => $data,
		]);
	}

	public function todos ()
	{
		/* ########## PARA EL SUPERADMIN ########## */
		/* ########## Ahora tambien para el admin de clubes, quien podra ver sus clubes ########## */
		if (auth()->user()->tipo_usuarios_id == 1) {
			$servicios = Servicios::all()->load(['clubes']); // ANTIGUO
		} elseif (auth()->user()->tipo_usuarios_id == 2) {
			$servicios = auth()->user()->getServicios();
		}
		return view('sistema.servicios.todos')->with(['servicios' => $servicios]);
	}

	public function getRecinto ($id)
	{
		/* getRecinto CARGA RECINTO ID SERVICIO ########## */
		$recinto = Recintos::where('servicios_id', $id)->get();
		return response()->json($recinto);
	}

	public function loadServicios ($id)
	{
		if ($id == 0) {
			$servicios = auth()->user()->getServicios();
		} else {
			$servicios = Servicios::where('clubes_id', $id)->get();
		}
		return response()->json($servicios);
	}

	public function store(Request $post, $club)
	{
		$post->validate([
			'nombre' => 'required',
			'valor' => 'nullable',
		],[
			'nombre.required' => 'Debe ingresar el nombre',
		]);

		$servicio = Servicios::create([
			'clubes_id' => $club,
			'nombre' => $post->nombre,
		]);
		!isset($post->imagen) ? : $post->file('imagen')->storeAs('img/servicios', $servicio->id.'.png', 'public');

		Flash::success('Registro creado correctamente');
		return redirect()->route('servicios.index', $club);
	}

	public function edit($club, $id)
	{
		return view('sistema.servicios.edit')->with([
			'servicio' => Servicios::find($id),
			'club' => $club
		]);
	}

	public function update(Request $post, $club, $id)
	{
		$post->validate([
			'nombre' => 'required',
		],[
			'nombre.required' => 'Debe ingresar el nombre',
		]);

		$servicio = Servicios::find($id);
		$servicio->update([
			'nombre' => $post->nombre,
		]);
		!isset($post->imagen) ? : $post->file('imagen')->storeAs('img/servicios', $servicio->id.'.png', 'public');

		Flash::success('Registro modificado correctamente');
		return redirect()->route('servicios.index', $club);
	}

	public function destroy($club, $id)
	{
		Servicios::find($id)->delete();
		/* ########## BORRAR REGISTROS RELACIONADOS ########## */
		$recintos = Recintos::where('servicios_id', $id)->get();
		foreach ($recintos as $key => $recinto) {
			/* BORRA SOLO AGENDA, NO RESERVAS NI TRANSACCIONES. */
			$agenda = Agenda::where('recintos_id', $recinto->id)->delete();
			$recinto->delete();
		}
		/* ########## BORRAR REGISTROS RELACIONADOS ########## */
		Flash::success('Servicio y recintos eliminados correctamente');
		return redirect()->route('servicios.index', $club);
	}
	public function get($club, $id)
	{
		$servicios = Servicios::all()->load(['clubes']);
		return response()->json($servicios);
	}
	/* ########## SOFTDELETES ########## */
	public function eliminados ()
	{
		$users = Servicios::onlyTrashed()->get();
		return view('sistema.servicios.borrados')
		->with('servicios',$users);
	}
	public function borrar ($id)
	{
		$user = Servicios::withTrashed()->find($id);
		$user->forceDelete();
		Flash::success('Servicio eliminado completamente del sistema');
		return redirect()->route('servicios.todos');
	}
	public function restaurar ($id)
	{
		$user = Servicios::withTrashed()->find($id);
		$user->restore();
		Flash::success('Servicio restaurado al sistema');
		return redirect()->route('servicios.todos');
	}
	/* ########## SOFTDELETES ########## */
}
