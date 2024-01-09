<?php

namespace App\Http\Controllers;

use App\Exports\CanchasExport;
use Illuminate\Http\Request;
use App\Models\Clubes;
use App\Models\Servicios;
use App\Models\TipoUsers;
use App\Models\UsersClubes;
use App\Models\Agenda;
use App\Models\Recintos;
use App\Models\Reservas;

use DateTime;
use Flash;
use Auth;

use App\Traits\MultiClases;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;

class EstadisticasController extends Controller
{
	// GRAFICOS MENSUALES, INDICADORES POR DETALLE
	use MultiClases;
	public function __construct ()
	{
		$this->middleware(function ($request, $next) {
			$this->recintos = auth()->user()->getRecintos();
			return $next($request);
		});
	}
	public function test ($array = [])
	{
		/* ########## ACCESIBLE A LOS ADMIN DE CLUBES ########## */
		$recintos = $this->recintos;
		/* PORCENTAJE DE OCUPADOS DEL TOTAL DE BLOQUES DEL MES */
		foreach ($recintos as $key => $recinto) {
			$total = ($recinto->getEstado()->count() + $recinto->getEstado('Disponible')->count() + $recinto->getEstado('Por Pagar')->count() + $recinto->getEstado('Bloqueado')->count() + $recinto->getEstado('Facturación Mensual')->count() + $recinto->getEstado('Pendiente de Pago')->count() + $recinto->getEstado('Pagado')->count());
			if ($total > 0) {
				$suma_parcial = ($recinto->getEstado()->count() + $recinto->getEstado('Por Pagar')->count() + $recinto->getEstado('Bloqueado')->count() + $recinto->getEstado('Facturación Mensual')->count() + $recinto->getEstado('Pendiente de Pago')->count() + $recinto->getEstado('Pagado')->count());
				$array['labels'][$key] = $recinto->nombre." - ".$recinto->servicios->nombre." - ".$recinto->clubes->display_name;
				$array['data'][$key] = (($suma_parcial * 100)/$total);
				$array['color'][$key] = self::getColor();
			}
		}
		return $array;
	}
	public function thirdGraph (
		$array = [],
		$cant = 12
	)
	{
		/* LINEA POR CADA RECINTO, QUE INDIQUE VALORES EN DINERO, MAS OTRA QUE SEA EL TOTAL / DEBE INCLUIR EL MES ACTUAL */
		$recintos = $this->recintos;
		$meses = array_reverse(self::getMonths($arr = [], $cant));
		foreach ($recintos as $key => $recinto) {
			/* ##### CADA RECINTO SERA UN DATASET EN EL GRÁFICO ##### */
			foreach ($meses as $k => $value) {
				$agenda = Agenda::where('recintos_id', $recinto->id)
					->whereIn('estado', ['Reservado','Facturación Mensual','Pendiente de Pago','Pagado'])
					->where('mes', $value['mes'])
					->where('agno', $value['ano'])
					->get();
				$array[$key][$k]["data"] = $agenda->sum('valor_hora');
				// $array[$key][$k]["labels"] = strftime('%B %G', DateTime::createFromFormat('d-m-Y',$value['fecha'])->getTimestamp());
				$array[$key][$k]["labels"] = $value['labels']." ".$value["ano"];
				$array[$key][$k]["color"] = self::getColor();
			}
			$array[$key]["nombre"] = $recinto->nombre." - ".$recinto->servicios->nombre." - ".$recinto->clubes->display_name;
		}
		// foreach ($array as $key => $value) {
		// 	foreach ($value as $key => $val) {
		// 		dump($val, $val['data']);
		// 	}
		// }
		// dd(count($meses), count($array));
		return $array;
	}
	public function secondGraph ($array = [])
	{
		// DINERO MENSUAL POR INSTALACION RECIBIDO
		// $clubes = auth()->user()->getClubes();
		// $servicios = auth()->user()->getServicios();
		$recintos = $this->recintos;
		foreach ($recintos as $key => $value) {
			// OBTENER PARES DE RECINTO => DINERO
			$array['labels'][$key] = $value->nombre." - ".$value->servicios->nombre." - ".$value->clubes->display_name;
			$agenda = Agenda::where('recintos_id', $value->id)
				->whereIn('estado', ['Reservado','Facturación Mensual','Pendiente de Pago','Pagado'])
				->where('mes', date('m'))
				->where('agno', date('Y'))
				->get();
			$array['data'][$key] = $agenda->sum('valor_hora');
			$array['color'][$key] = self::getColor();
		}
		return $array;
	}
	public function firstGraph ($array = [])
	{
		/* ########## ACCESIBLE A LOS ADMIN DE CLUBES ########## */
		$recintos = $this->recintos;
		/* PORCENTAJE DE OCUPADOS DEL TOTAL DE BLOQUES DEL MES */
		foreach ($recintos as $key => $recinto) {
			$total = ($recinto->getEstado()->count() + $recinto->getEstado('Disponible')->count() + $recinto->getEstado('Por Pagar')->count() + $recinto->getEstado('Bloqueado')->count() + $recinto->getEstado('Facturación Mensual')->count() + $recinto->getEstado('Pendiente de Pago')->count() + $recinto->getEstado('Pagado')->count());
			if ($total > 0) {
				$suma_parcial = ($recinto->getEstado()->count() + $recinto->getEstado('Por Pagar')->count() + $recinto->getEstado('Bloqueado')->count() + $recinto->getEstado('Facturación Mensual')->count() + $recinto->getEstado('Pendiente de Pago')->count() + $recinto->getEstado('Pagado')->count());
				$array['labels'][$key] = $recinto->nombre." - ".$recinto->servicios->nombre." - ".$recinto->clubes->display_name;
				$array['data'][$key] = (($suma_parcial * 100)/$total);
				$array['color'][$key] = self::getColor();
			}
		}
		return $array;
	}
	public function index ()
	{
		// dd(self::thirdGraph(), array_reverse(self::thirdGraph()));
		return view('sistema.adminclub.estadisticas.estadisticas')
		->with([
			'cards' => $this->loadCardsData(),
			'array' => self::firstGraph(),
			'barras' => self::secondGraph(),
			'lineas' => self::thirdGraph($array = [], 12),
		]);
	}
	public function periodo ($data)
	{
		// Recibe periodo para cargar grafico 3, cantidad de meses.
		return ['lineas' => self::thirdGraph($array=null, $data)];
	}
	public function loadCardsData ()
	{
		/* ##### Instalaciones agendadas - % Uso de instalaciones - Bloques disponibles - Bloques no disponibles ##### */
		// No usara desde hasta, parte desde el dia actual
		$agenda = Agenda::whereIn('recintos_id', $this->recintos->pluck('id')->toArray())
			->where('fecha', date('Y-m-d'))
			->get();
		$agendadas = $agenda->whereIn('estado', ['Reservado','Facturación Mensual','Pendiente de Pago','Pagado'])->count();
		$disponibles = $agenda->where('estado', 'Disponible')->count();
		$nodis = $agenda->where('estado', '!=', 'Disponible')->count();
		$uso = ($agendadas * 100)/$disponibles;
		$array = [
			'agendadas' => $agendadas,
			'disponibles' => $disponibles,
			'uso' => $uso,
			'nodis' => $nodis,
		];
		return ($array);
	}
	public function dataBoxesFilter (
		$desde,
		$hasta,
		$club,
		$servicio,
		$recinto,
		$filtros = [])
	{
		/* ##### Instalaciones agendadas - % Uso de instalaciones - Bloques disponibles - Bloques no disponibles ##### */
		($recinto != 0) ? $filtros['id'] = $recinto : null;
		($servicio != 0) ? $filtros['servicios_id'] = $servicio : null;
		($club != 0) ? $filtros['clubes_id'] = $club : null;
		$recintos = Recintos::where($filtros)->get();
		$agenda = Agenda::whereIn('recintos_id', $recintos->pluck('id')->toArray())
			->whereBetween('fecha', [$desde, $hasta])
			->get();
		$agendadas = $agenda->whereIn('estado', ['Reservado','Facturación Mensual','Pendiente de Pago','Pagado'])->count();
		$disponibles = $agenda->where('estado', 'Disponible')->count();
		$nodis = $agenda->where('estado', '!=', 'Disponible')->count();
		$uso = ($agendadas * 100)/$disponibles;
		$array = [
			'agendadas' => $agendadas,
			'disponibles' => $disponibles,
			'uso' => $uso,
			'nodis' => $nodis,
		];
		return ($array);
	}

	public function reportes()
	{
		$clubid = auth()->user()->getClubes()->pluck('id')->toArray();
		$users = $this->usersGral($clubid);
		return view('sistema.adminclub.estadisticas.reportes')->with('usuarios',$users);
	}
	public function excelCancha()
	{
		return Excel::download(new CanchasExport, 'users.xlsx');
	}
	public function instalaciones ($desde,$hasta)
	{
		/* ########## DATOS DE TODOS LOS RECINTOS ########## */
		$club = auth()->user()->getClubes()->pluck('id');
		$recintos = Recintos::whereIn('clubes_id', $club)->get();
		$reservas = [];
		foreach ($recintos as $clave => $valor) {
			$agenda = Agenda::where('recintos_id', $valor->id)->where('fecha','>=', $desde)->where('fecha','<=',$hasta)
			->where('agenda.estado','Reservado')
			->join('recintos','recintos.id','=','agenda.recintos_id')
			->join('clubes','clubes.id','=','recintos.clubes_id')
			->join('reservas','reservas.id','=','agenda.reserva_id')
			->join('users','users.id','=','reservas.users_id')
			->get()->toArray();
			// array_push($reservas,$agenda);
			$reservas = array_merge($reservas,$agenda);
		}
		return datatables()->of($reservas)->toJson();
	}

	public function instalacionSinFecha()
	{
		/* ########## DATOS DE TODOS LOS RECINTOS ########## */
		$club = auth()->user()->getClubes()->pluck('id');
		$recintos = Recintos::whereIn('clubes_id', $club)->get();
		$year = date('Y');
		$desde = $year.'-01-01';
		$hasta = $year.'-12-31';
		$reservas = [];
		foreach ($recintos as $clave => $valor) {
			$agenda = Agenda::where('recintos_id', $valor->id)->where('fecha','>=', $desde)->where('fecha','<=',$hasta)
			->where('agenda.estado','Reservado')
			->join('recintos','recintos.id','=','agenda.recintos_id')
			->join('clubes','clubes.id','=','recintos.clubes_id')
			->join('reservas','reservas.id','=','agenda.reserva_id')
			->join('users','users.id','=','reservas.users_id')
			->get()->toArray();
			// array_push($reservas,$agenda);
			$reservas = array_merge($reservas,$agenda);
		}
		// dd($reservas);
		// $total = $agenda->count();
		// $disponibles = $agenda->where('estado', 'Disponible')->count();
		// $reservados = $agenda->where('estado', 'Reservado');
		// $bloqueados = $agenda->where('estado', 'Bloqueado')->count();
		// $ocupados = (($reservados * 100)/$total);
		// $libres = (($disponibles * 100)/$total);
		return datatables()->of($reservas)->toJson();
	}
}
