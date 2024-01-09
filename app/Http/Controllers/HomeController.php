<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoUsers;
use App\Models\User;
use App\Models\UserClubes;
use App\Models\Clubes;
use App\Models\Recintos;
use App\Models\Servicios;
use App\Models\Reservas;
use App\Models\Agenda;

use Illuminate\Support\Facades\Route;

use Flash;
use Illuminate\Support\Facades\Auth;
use DateTime;

use App\Traits\MultiClases;

class HomeController extends Controller
{
	use MultiClases;
	/* ########## PAUTA ACTUAL 14-12-2021 ########## */
	// Añadir comentario e IDENTIFICACION para los horarios de agenda agendados por el admin de manera retroactiva
	/* ########## PAUTA ACTUAL 14-12-2021 ########## */
	/* ########## 5-1-2022 ########## */
	// ACECLUB
	// - Excel exportable en transacciones.
	// - Quitar admin de un club específico.
	public function __construct ()
	{
		// 
	}
	public function testView ()
	{
		return view('sistema.adminclub.test');
	}
	public function checkAdmin ()
	{
		// Chequear si el usuario es admin en algun club, si lo es, se mandará al menú admin.
		if (count(auth()->user()->getClubes()) > 0) {
			return true;
		}
		return false;
	}
	public function menuAdmin ()
	{
		/* ########## ADMINCLUB ########## */
		$clubid = (count(auth()->user()->clubes) > 0) ? auth()->user()->clubes->first()->clubes_id : 0;
		$club = Clubes::find($clubid);
		(!is_null($club)) ? $recintos = Recintos::with('agenda')->where('clubes_id', $club->id)->get() : $recintos = null;
		(!is_null($club)) ? $servicios = Servicios::where('clubes_id', $club->id)->get() : $servicios = null;
		$eventos = self::carga_eventos($clubid);
		$id = is_null(auth()->user()->getServicios()->first()) ? 0 : auth()->user()->getServicios()->first()->id;
		// $recintos = $this->agendaRecintos(date('Y-m-d'), $id);
		$recintos = self::getAllAgenda(date('Y-m-d'), $id, 0);
		$users = User::all();
		$data = $this->getDataDia();
		return view('sistema.adminclub.index')
		->with([
			'data' => $data,
			'users' => $users,
			'club' => $club,
			'recintos' => $recintos,
			'servicios' => $servicios,
			'eventos' => $eventos,
		]);
	}
	public function menuVisualizador ()
	{
		/* ########## ADMINCLUB ########## */
		$clubid = (count(auth()->user()->clubes) > 0) ? auth()->user()->clubes->first()->clubes_id : 0;
		$club = Clubes::find($clubid);
		(!is_null($club)) ? $recintos = Recintos::with('agenda')->where('clubes_id', $club->id)->get() : $recintos = null;
		(!is_null($club)) ? $servicios = Servicios::where('clubes_id', $club->id)->get() : $servicios = null;
		$eventos = self::carga_eventos($clubid);
		$id = is_null(auth()->user()->getServicios()->first()) ? 0 : auth()->user()->getServicios()->first()->id;
		// $recintos = $this->agendaRecintos(date('Y-m-d'), $id);
		$recintos = self::getAllAgenda(date('Y-m-d'), $id, 0);
		$data = $this->getDataDia();
		return view('sistema.adminclub.index')
		->with([
			'data' => $data,
			'club' => $club,
			'recintos' => $recintos,
			'servicios' => $servicios,
			'eventos' => $eventos,
		]);
	}
	public function index (Request $request)
	{
		/* ########## TODOS LOS USUARIOS LLEGAN ACA ########## */
		// VER QUE TIPO DE USUARIO
		if (is_null(auth()->user()->tipo_usuarios) || auth()->user()->tipo_usuarios->tipo == "INVITADO" || auth()->user()->tipo_usuarios->tipo == "SOCIO") {
			$user = Auth::user();
			$request->session()->invalidate();
			$request->session()->regenerateToken();
			Auth::guard('web')->logout();
			Flash::error('Debe acceder desde la app');
			return redirect()->route('login');
		}
		if (auth()->user()->tipo_usuarios->tipo == "SUPERADMIN") {
			return view('sistema.index');
		// } elseif (auth()->user()->tipo_usuarios->tipo == "ADMIN") {
		} elseif (auth()->user()->checkAdmin()) {
			/* ########## ADMINCLUB ########## */
			return $this->menuAdmin();
		} elseif (auth()->user()->tipo_usuarios->tipo == "SOCIO") {
			$clubid = (count(auth()->user()->clubes) > 0) ? auth()->user()->clubes->first()->clubes_id : 0;
			$club = Clubes::find($clubid);
			return view('sistema.socios.home')->with(['club' => $club,]);
		} elseif (auth()->user()->tipo_usuarios->tipo == "INVITADO") {
			$clubid = (count(auth()->user()->clubes) > 0) ? auth()->user()->clubes->first()->clubes_id : 0;
			$club = Clubes::find($clubid);
			return view('sistema.socios.home')->with(['club' => $club,]);
		} elseif (auth()->user()->tipo_usuarios_id == 7) {
			/* ########## VISUALIZADOR ########## */
			return $this->menuVisualizador();
		}
	}
	public function cambioMenu ()
	{
		/* ##### FUNCION PARA CAMBIAR A LA VISTA DE SOCIO ##### */
		if (auth()->user()->tipo_usuarios->tipo == "SUPERADMIN") {
			return redirect()->route('home');
		} elseif (auth()->user()->tipo_usuarios->tipo == "ADMIN") {
			return redirect()->route('home');
		}
	}
	public function home ()
	{
		/* ########## IR AL HOME PARA SOCIOS/INVITADOS ########## */
		$clubid = (count(auth()->user()->clubes) > 0) ? auth()->user()->clubes->first()->clubes_id : 0;
		$club = Clubes::find($clubid);
		return view('sistema.socios.home')->with(['club' => $club,]);
	}
	public function getUser ($rut = null)
	{
		/* ########## OBTIENE RUT POR AJAX Y RETORNA CLIENTE ########## */
		// $clubid = (count(auth()->user()->clubes) > 0) ? auth()->user()->clubes->first()->clubes_id : 0;
		$arr = [
			'rut' => $rut,
		];
		$usuario = User::where($arr)->first() ?? false;
		return response()->json($usuario);
	}
	public function getUserFromId ($id)
	{
		/* ########## OBTIENE ID POR AJAX Y RETORNA CLIENTE ########## */
		// $clubid = (count(auth()->user()->clubes) > 0) ? auth()->user()->clubes->first()->clubes_id : 0;
		$usuario = User::find($id) ?? false;
		return response()->json($usuario);
	}
	public function agendaRecintos ($date, $id, $clubid)
	{
		/* ##### SE OBTIENE DIA Y SERVICIO (id) ##### */
		if($id == 0) {
			$recintos = self::getAllAgenda($date, $id, $clubid);
		} else {
			$recintos = self::getAgenda($date, $id, $clubid);
		}
		if (count($recintos) < 1) {
			$tabla = "<p>No tiene recintos cargados aun.</p>";
			return $tabla;
		}
		// foreach ($recintos as $key => $recinto) {
		// 	dump($recinto->nombre);
		// }
		$tabla = "
		<table class='table table-bordered table-striped' id='tabla_ppal'>
			<thead id='thead'>
				<tr>
					<th width='4%' class='cabecera' style='text-align: center;'>hora</th>";
					foreach ($recintos as $key => $recinto) {
						$tabla = $tabla."<th class='cabecera'>$recinto->nombre<!--<small>(".$recinto->servicios->nombre.")</small>--></th>";
					}
			$tabla = $tabla."</tr>
			</thead>
			<tbody id='tbody'>";
				$inicio = date_create($recintos->sortBy(['hora_inicio', 'asc'])->first()->hora_inicio);
				$termino = date_create("23:00:00");
				// $rec = $recintos->first()->agenda->first();
				// $ser = $recintos->first()->servicios;
				// $inicio = date_create("$rec->fecha $ser->hora_inicio");
				// $termino = date_create("$rec->fecha $ser->hora_fin");
				while ($inicio < $termino) {
				$tabla = $tabla."<tr>
					<td style='text-align: center;'>".$inicio->format('H:i')."</td>";
					foreach ($recintos as $key => $recinto) {
					$var = $recinto->agenda->where('hora_inicio_bloque', $inicio->format('H:i:s'))->first();
					$mid = $recinto->agenda->where('hora_inicio_bloque', '<', $inicio->format('H:i:s'))
						->where('hora_fin_bloque', '>',$inicio->format('H:i:s'))
						->where('fecha', $date)
						->first();
						if (!is_null($var)) {
							/* ##### PARA EL TEXTO DEL ESTADO BAJO EL NOMBRE  */
							$var->load('reserva');
							if(!is_null($var->reserva)) {
								$pago = "<br>".($var->reserva->estado == "Reservado" ? 'Reservado/Pagado' : $var->estado);
							} else {
								$pago = "";
							}
							/* ##### PARA LA CLASE-COLOR ##### */
							if ($var->estado=='Reservado') {
								$clase = "ocupado";
							} elseif ($var->estado=='Facturación Mensual') {
								$clase = "mensual";
							} elseif ($var->estado=='Pendiente de Pago') {
								$clase = "pendiente";
							} elseif ($var->estado=='Pagado') {
								$clase = "pagado";
							} elseif ($var->estado=='Disponible') {
								$clase = "disponible";
							} else {
								$clase = "";
							}
							$dia = date_create($var->hora_inicio_bloque)->format('H:i')."<br>".date_create($var->hora_fin_bloque)->format('H:i');
							$tabla = $tabla."<td style='text-align: center;' data-agenda='$var->id' onclick='return loadModalHorario(this)' data-toggle='modal' data-target='#modalHorario' class='horario $clase ".($var->estado=='Bloqueado' ? 'no-disponible' : '')."'><br>".(!is_null($var->reserva_id) ? ($var->reserva->users) ? $dia."<br>".$var->reserva->users->full_name : 'Usuario no encontrado' : '' ).$pago."</td>";
						}
						if(!is_null($mid)) {
							if ($mid->estado=='Reservado') {
								$clase = "ocupado";
							} elseif ($mid->estado=='Facturación Mensual') {
								$clase = "mensual";
							} elseif ($mid->estado=='Pendiente de Pago') {
								$clase = "pendiente";
							} elseif ($mid->estado=='Pagado') {
								$clase = "pagado";
							} elseif ($mid->estado=='Disponible') {
								$clase = "disponible";
							} else {
								$clase = "";
							}
							$tabla = $tabla."<td data-agenda='$mid->id' onclick='return loadModalHorario(this)' data-toggle='modal' data-target='#modalHorario' class='horario $clase ".($mid->estado=='Bloqueado' ? 'no-disponible' : '')."'>$mid->comentario</td>";
							// if($mid->reserva_id) {
							// 	foreach($mid->reserva as $key => $reserva) {
							// 		$tabla = $tabla."test-$key";
							// 	}
							// }
						}
						if(is_null($var) && is_null($mid)) {
							$tabla = $tabla."<td></td>";
						}
					}
				$tabla = $tabla."</tr>";
				$inicio->modify("+30 min");
				}
			$tabla = $tabla."</tbody>
		</table>";
		return $tabla;
	}

	
	public function getDataDia ($dia = null)
	{
		/* ########## DATOS DE TODOS LOS RECINTOS ########## */
		if (is_null($dia)) {
			$dia = date('Y-m-d');
		}
		$recintos = auth()->user()->getRecintos()->pluck('id');
		$agenda = Agenda::whereIn('recintos_id', $recintos)->where('fecha', $dia)->get();
		$total = $agenda->count();
		if ($total == 0) {
			$arr = [
				'total' => 0,
				'disponibles' => 0,
				'reservados' => 0,
				'bloqueados' => 0,
				'ocupados' => 0,
				'libres' => 0,
			];
			return $arr;
		}
		$disponibles = $agenda->where('estado', 'Disponible')->count();
		$reservados = $agenda->whereIn('estado', ['Reservado','Facturación Mensual','Pendiente de Pago','Pagado'])->count();
		$bloqueados = $agenda->where('estado', 'Bloqueado')->count();
		$ocupados = (($reservados * 100)/$total);
		$libres = (($disponibles * 100)/$total);
		$arr = [
			'total' => $total,
			'disponibles' => $disponibles,
			'reservados' => $reservados,
			'bloqueados' => $bloqueados,
			'ocupados' => $ocupados,
			'libres' => $libres,
		];
		return $arr;
	}
	public function getDataDiaFiltrado ($dia, $club, $servicio = null)
	{
		/* ########## DATOS DE TODOS LOS RECINTOS ########## */
		$club = ($club == 0) ? auth()->user()->getClubes()->pluck('id') : Clubes::where('id',$club)->get()->pluck('id');
		if (is_null($servicio)) {
			$recintos = Recintos::whereIn('clubes_id', $club)->get();
		} elseif($servicio == 0) {
			$recintos = Recintos::whereIn('clubes_id', $club)->get();
		} else {
			$recintos = Recintos::where('servicios_id', $servicio)->get();
		}
		$agenda = Agenda::whereIn('recintos_id', $recintos->pluck('id'))->where('fecha', $dia)->get();
		$total = $agenda->count();
		$disponibles = $agenda->where('estado', 'Disponible')->count();
		$reservados = $agenda->where('estado', 'Reservado')->count();
		$bloqueados = $agenda->where('estado', 'Bloqueado')->count();
		$ocupados = (($reservados * 100)/$total);
		$libres = (($disponibles * 100)/$total);
		$arr = [
			'total' => $total,
			'disponibles' => $disponibles,
			'reservados' => $reservados,
			'bloqueados' => $bloqueados,
			'ocupados' => $ocupados,
			'libres' => $libres,
		];
		return $arr;
	}
	public function test ()
	{
		phpinfo();
		dd('test');
		$agenda = Agenda::find(14279);
		dd(round(($agenda->valor_hora * 25) / 100));
	}
}













