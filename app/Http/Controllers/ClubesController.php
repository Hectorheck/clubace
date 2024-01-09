<?php

namespace App\Http\Controllers;

use App\Models\ConfigClub;
use App\Models\ConfigDefault;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Clubes;
use App\Models\Regiones;
use App\Models\Comunas;
use App\Models\Servicios;
use App\Models\Recintos;
use App\Models\Agenda;
use App\Models\Aplicaciones;
use App\Models\RecursosCompartidos;
use App\Models\ClubesDestacados;
use App\Models\ClubesApiInfo;
use App\Models\TerminosYCondiciones;
use Flash;

class ClubesController extends Controller
{
	public function index()
	{
		return view('sistema.clubes.index')->with([
			'regiones' => Regiones::all()
		]);
	}

	public function formConfig(Request $res){
	// 	return redirect()->route('clubes.lista');
		$clubId = $res->clubId;

		unset($res->clubId);
		ConfigClub::create([
			'idClub' => $clubId,
			'Configuracion' => json_encode($res->all()),
		]);
		return redirect()->route('clubes.lista');;
	}

	public function config($id)
	{
		$varDefault = ConfigDefault::all();
		$club = Clubes::find($id);
		return view('sistema.clubes.configuracion')->with([
			'club' => $club,
			'varDefault' => $varDefault
		]);
		
	}

	public function loadClubes ()
	{
		$json = Clubes::all();
		return response()->json($json);
	}

	public function lista()
	{
		$apps = Aplicaciones::all();
		$shared = RecursosCompartidos::where('recurso', 'Clubes')->get();
		return view('sistema.clubes.lista')->with([
			'clubes' => Clubes::latest()->get(),
			'apps' => $apps,
			'compartidos' => $shared,
		]);
	}
	public function lista_admin ()
	{
		// dd(auth()->user()->getTipos()); // tipo_usuarios_id
		$apps = Aplicaciones::all();
		$shared = RecursosCompartidos::where('recurso', 'Clubes')->get();
		return view('sistema.clubes.lista')->with([
			'clubes' => auth()->user()->getClubes(),
			'apps' => $apps,
			'compartidos' => $shared,
		]);
	}

	public function store(Request $post)
	{
		$post->validate([
			'rut' => 'required|unique:clubes',
			'color1' => 'nullable',
			'color2' => 'nullable',
			'estado_transbank' => 'required',
			'lat' => 'required',
			'lng' => 'required',
		],[
			'rut.required' => 'Debe ingresar el rut',
			'rut.unique' => 'El rut ingresado ya se ha registrado',
			'estado_transbank.required' => 'Debe Seleccionar el estado de Transbank',
			'lat.required' => 'Debe seleccionar una ubicacion en el mapa',
			'lng.required' => 'Debe seleccionar una ubicacion en el mapa',
		]);

		// $geo = str_replace("(", "", $post->geo);
		// $geo = str_replace(")", "", $geo);
		// $cntLat = strpos($geo, ",");
		// $cntLat = $cntLat + 2;
		// $lng = substr($geo, $cntLat);
		// $lat = str_replace($lng, "", $geo);
		// $lat = str_replace(", ", "", $lat);

		$data = [
			'rut' => $post->rut,
			'razon_social' => $post->razon_social,
			'display_name' => $post->display_name,
			'representante_legal_rut' => $post->rut_rep_legal,
			'representante_legal_nombre' => $post->nom_rep_legal,
			'geo_lat' => $post->lat,
			'geo_lng' => $post->lng,
			'direccion_calle' => $post->direccion,
			'direccion_numero' => $post->numero,
			'direccion_apartado_especial' => $post->apartado,
			'comunas_id' => $post->comuna,
			'color_1' => $post->color1 ?? '',
			'color_2' => $post->color2 ?? '',
			'estado_transbank' => $post->estado_transbank,
			'codigo_comercio_transbank' => $post->codigo_comercio_transbank
		];
		$club = Clubes::create($data);
		if (isset($post->logotipo)) {
			$path = $post->file('logotipo')->storeAs('img/clubes', $club->id.'.png', 'public');
			$newarr['logo_url'] = $path;
			$club->update($newarr);
		}
		Flash::success('Registro creado correctamente');
		return redirect()->route('clubes.lista');
	}

	public function edit($id)
	{
		$club = Clubes::find($id);
		$comuna = Comunas::find($club->comunas_id);
		is_null($comuna)
			? $comunas = []
			: $comunas = Comunas::whereRegionesId($comuna->regiones_id)->get();
		// $comunas = Comunas::whereRegionesId($comuna->regiones_id)->get();
		return view('sistema.clubes.edit')->with([
			'club' => $club,
			'comuna' => $comuna,
			'comunas' => $comunas,
			'regiones' => Regiones::all()
		]);
	}

	public function update(Request $post, $id)
	{
		$club = Clubes::find($id);

		if ($club->rut != $post->rut) {
			$post->validate([
				'rut' => 'required|unique:clubes',
			],[
				'rut.required' => 'Debe ingresar el rut',
				'rut.unique' => 'El rut ingresado ya se ha registrado',
			]);
		}
		$post->validate([
			'color1' => 'nullable',
			'color2' => 'nullable'
		]);

		// $geo = str_replace("(", "", $post->geo);
		// $geo = str_replace(")", "", $geo);
		// $cntLat = strpos($geo, ",");
		// $cntLat = $cntLat + 2;
		// $lng = substr($geo, $cntLat);
		// $lat = str_replace($lng, "", $geo);
		// $lat = str_replace(", ", "", $lat);

		$data = [
			'rut' => $post->rut,
			'razon_social' => $post->razon_social,
			'display_name' => $post->display_name,
			'representante_legal_rut' => $post->rut_rep_legal,
			'representante_legal_nombre' => $post->nom_rep_legal,
			'geo_lat' => $post->lat,
			'geo_lng' => $post->lng,
			'direccion_calle' => $post->direccion,
			'direccion_numero' => $post->numero,
			'direccion_apartado_especial' => $post->apartado,
			'comunas_id' => $post->comuna,
			'color_1' => $post->color1,
			'color_2' => $post->color2,
			'tiene_servicio_agendamiento' => $post->agendamiento ? 1 : 0,
			'tiene_servicio_arrendamiento' => $post->arrendamiento ? 1 : 0,
			'tiene_servicio_escalerilla' => $post->escalerilla ? 1 : 0,
			'tiene_servicio_clases' => $post->clases ? 1 : 0,
			'estado_transbank' => $post->estado_transbank,
			'codigo_comercio_transbank' => $post->codigo_comercio_transbank
		];

		if (isset($post->logotipo)) {
			$path = $post->file('logotipo')->storeAs('img/clubes', $club->id.'.png', 'public');
			$data['logo_url'] = $path;
		}
		$club->update($data);

		Flash::success('Registro actualizado correctamente');
		if (auth()->user()->tipo_usuarios->tipo == "SUPERADMIN") {
			return redirect()->route('clubes.lista');
		} elseif (auth()->user()->tipo_usuarios->tipo == "ADMIN") {
			//return redirect()->route('clubes.edit', $club->id);
            return redirect()->route('clubes.lista_admin');
		}
	}

	public function destroy($id)
	{
		Clubes::find($id)->delete();
		/* ########## BORRAR REGISTROS RELACIONADOS ########## */
		$servicios = Servicios::where('clubes_id', $id)->get();
		foreach ($servicios as $key => $servicio) {
			$recintos = Recintos::where('servicios_id', $servicio->id)->get();
			foreach ($recintos as $key => $recinto) {
				/* BORRA SOLO AGENDA, NO RESERVAS NI TRANSACCIONES. */
				$agenda = Agenda::where('recintos_id', $recinto->id)->delete();
				$recinto->delete();
			}
			$servicio->delete();
		}
		/* ########## BORRAR REGISTROS RELACIONADOS ########## */
		return redirect()->route('clubes.lista');
	}

	public function destacar ($id)
	{
		// $club = Clubes::find($id);
		$count = ClubesDestacados::all()->count();
		$exists = ClubesDestacados::where(['clubes_id' => $id,'destacado' => 1,])->first();
		if (!is_null($exists)) {
			$exists->delete();
			Flash::success('Club removido de lista destacados');
			return redirect()->back();
		}
		$destacado = ClubesDestacados::firstOrCreate([
			'clubes_id' => $id,
			'destacado' => 1,
		], [
			'user_id' => auth()->user()->id,
			'lugar' => ($count + 1),
		]);
		Flash::success('Club añadido a lista destacados');
		return redirect()->back();
	}
	public function infoApp ($id)
	{
		$club = Clubes::find($id)->load('api_info');
		return view('sistema.clubes.info')->with(['club' => $club,'info' => $club->api_info,]);
	}
	public function infoAppStore (Request $request, $id)
	{
		$val = $request->validate([
			'compartido' => 'required',
			'app' => 'required',
			'fbase_api_key' => 'required',
			'token_club' => 'required',
		],[
			'compartido.required' => 'Seleccione si los datos serán compartidos o no',
			'app.required' => 'Seleccione si tendrá app móvil o no',
			'fbase_api_key.required' => 'Ingrese Api Key',
			'token_club.required' => 'Ingrese Token',
		]);
		$info = ClubesApiInfo::updateOrCreate([
			'clubes_id' => $id,
		],$val);
		return redirect()->route('clubes.lista');
	}
	/* ########## SOFTDELETES ########## */
	public function eliminados ()
	{
		$users = Clubes::onlyTrashed()->get();
		return view('sistema.clubes.borrados')
		->with('clubes',$users);
	}
	public function borrar ($id)
	{
		$user = Clubes::withTrashed()->find($id);
		$user->forceDelete();
		Flash::success('Club eliminado completamente del sistema');
		return redirect()->route('clubes.index');
	}
	public function restaurar ($id)
	{
		$user = Clubes::withTrashed()->find($id);
		$user->restore();
		Flash::success('Club restaurado al sistema');
		return redirect()->route('clubes.index');
	}
	/* ########## SOFTDELETES ########## */
}










