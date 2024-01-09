<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use Auth;
use Mail;
use View;
use Storage;
// use PDF;
use App;
use DateTime;
use DateInterval;

use App\Models\TipoUsers;
use App\Models\User;
use App\Models\UserClubes;
use App\Models\Clubes;
use App\Models\Recintos;
use App\Models\Servicios;
use App\Models\Reservas;
use App\Models\Agenda;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


trait MultiClases
{
	/* ########## PENDIENTE ########## */
	// - Separar los servicios según socios o arrendamiento, según el check del admin.
	// - Continuar a pago (arrendamiento) si es arrendamiento con valor.
	// - El dashboard con los gráficos y datos de recintos y utilización.
	// - LISTA de socios, pendientes y eliminados, etc.
	/* ########## PENDIENTE ########## */
	public function __construct()
	{
		//
	}
	/* ########## PAGINAR COLECCIONES ########## */
	private function paginate($items, $perPage = 8, $page = null, $options = [])
	{
		$page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
		$items = $items instanceof Collection ? $items : Collection::make($items);
		return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
	}
	public function dias_semana ($array)
	{
		foreach ($array as $key => $value) {
			switch ($value) {
				case 1:
					$new[$key] = "Monday";
					break;
				case 2:
					$new[$key] = "Tuesday";
					break;
				case 3:
					$new[$key] = "Wednesday";
					break;
				case 4:
					$new[$key] = "Thursday";
					break;
				case 5:
					$new[$key] = "Friday";
					break;
				case 6:
					$new[$key] = "Saturday";
					break;
				case 7:
					$new[$key] = "Sunday";
					break;
				default:
					$new = [];
					break;
			}
		}
		return $new;
	}
	public static function dates_month ($month, $year)
	{
		$num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$dates_month = [];
		for ($i = 1; $i <= $num; $i++) {
			$mktime = mktime(0, 0, 0, $month, $i, $year);
			$date = date("d-m-Y", $mktime);
			$dates_month[$i] = $date;
		}
		return $dates_month;
	}
	public static function weeks_in_month($month, $year, $dates = [])
	{

		$week = 1;
		$date = new DateTime("$year-$month-01");
		$days = (int)$date->format('t'); // total number of days in the month

		$oneDay = new DateInterval('P1D');

		for ($day = 1; $day <= $days; $day++) {
			// $date->format('N')."-".$date->format('l')."-".$date->format('w')
			$dates["Semana $week"] [$date->format('N')]= $date->format('j');// j es dia sin ceros
			$dayOfWeek = $date->format('l');
			// if ($dayOfWeek === 'Saturday') {
			if ($dayOfWeek === 'Sunday') {
				$week++;
			}

			$date->add($oneDay);
		}

		return $dates;
	}
	public static function carga_eventos ($id)
	{
		/* ########## CARGA EVENTOS ########## */
		// Carga los eventos de un club, recibe el id del club del admin logueado, y retorna
		// los eventos agendados, agrupados por servicio, para mostrar todos los de un servicio
		// de un dia en el calendario
		$eventos = Agenda::where('mes', date('m'))->where('agno', date('Y'))
			->where('estado', 'Reservado')
			->with('recintos', function ($query) {
				$query->where('clubes_id', $id);
			})
			->with(['recintos','recintos.servicios',])
			->groupBy('dia')
			->get();
		// $servicios = Servicios::where('clubes_id', $id)
		// 	->with(['recintos','recintos.agenda',])
		// 	->get();
		return $eventos;
		/* ########## CARGA EVENTOS ########## */
	}
	public static function getColor ($rgb = [])
	{
		//Create a loop.
		foreach(['r', 'g', 'b'] as $color){
			//Generate a random number between 0 and 255.
			$rgb[$color] = mt_rand(0, 255);
		}
		return implode(',', $rgb);
	}
	public static function getMonths (
		$meses = [],
		$cant = 12
	)
	{
		// Devuelve los ultimos 12 meses a partir del mes actual.
		$meses = [];
		setlocale(LC_ALL,"es_ES", "Spanish_Spain", "Spanish");
		for ($i = 0; $i <= $cant; $i++) {
			// $meses[($i-1)] = ['dia' => date("d-m-Y", strtotime( date( 'Y-m-01' )." -$i months"))];
			$meses[($i)] = ['fecha' => '01-'.date("m-Y", strtotime( date( 'Y-m-01' )." -$i months"))];
			$meses[($i)]['mes'] = date("m", strtotime( date( 'Y-m-01' )." -$i months"));
			$meses[($i)]['ano'] = date("Y", strtotime( date( 'Y-m-01' )." -$i months"));
			$meses[($i)]['labels'] = strftime('%B', DateTime::createFromFormat('d-m-Y',$meses[($i)]['fecha'])->getTimestamp());
		}
		return($meses);
	}
	public static function getAgenda ($date, $id, $clubid)
	{
		/* ##### SE OBTIENE DIA Y SERVICIO (id) ##### */
		// $servicio = Servicios::find($id);
		$arr = ['servicios_id' => $id];
		if ($clubid == 0) {
			// code...
		} else {
			$arr['clubes_id'] = $clubid;
		}
		// dd($arr);
		$recintos = Recintos::whereHas('servicios')
			->where($arr)
			// ->where('servicios_id', $id)
			// ->where('clubes_id', $clubid)
			->with('agenda', function ($query) use ($date) {
				$query->where('fecha', $date);
			})
			->orderBy('nombre', 'ASC')
			->orderBy('servicios_id', 'ASC')
			->get();
		// $fecha = DateTime:: createFromFormat('Y-m-d', $date);
		return $recintos;
	}
	public static function getAllAgenda ($date, $id, $clubid)
	{
		/* ##### SE OBTIENE DIA ##### */
		/*
		 * Cargara todos los recintos, AHORA FILTRA POR CLUB ID
		*/
		$ids = auth()->user()->getRecintos()->pluck('id')->toArray();
		if ($clubid == 0) {
			$recintos = Recintos::whereHas('servicios')
				->whereIn('id', $ids)->with('agenda', function ($query) use ($date) {
					$query->where('fecha', $date);
				})->orderBy('servicios_id', 'ASC')
				->orderBy('nombre', 'ASC')->get();
		} else {
			$recintos = Recintos::whereHas('servicios')
				->where('clubes_id', $clubid)
				->whereIn('id', $ids)->with('agenda', function ($query) use ($date) {
					$query->where('fecha', $date);
				})->orderBy('servicios_id', 'ASC')
				->orderBy('nombre', 'ASC')->get();
		}
		// $fecha = DateTime:: createFromFormat('Y-m-d', $date);
		return $recintos;
	}
	public static function usersGral ($clubes_id)
	{
		/* Usuarios seran los usuarios que hayan usado servicios del club, catalogados como usuarios generales */
		if (is_numeric($clubes_id)) {
			$rec = Recintos::where('clubes_id', $clubes_id)->pluck('id')->toArray();
			$agenda1 = Agenda::where('recintos_id',$rec)->whereNotNull('reserva_id')->pluck('id')->toArray();
			$agenda = Agenda::where('recintos_id',$rec)->whereNotNull('reserva_id')->pluck('reserva_id')->toArray();
			$res = Reservas::whereIn('id', $agenda)->pluck('users_id')->toArray();
			$users = User::whereIn('id', $res)->get();
			return $users;
		}
		if (!is_array($clubes_id)) {
			$users = new Collection();
			return $users;
		}
		$rec = Recintos::whereIn('clubes_id', $clubes_id)->pluck('id')->toArray();
		$agenda = Agenda::where('recintos_id',$rec)->whereNotNull('reserva_id')->pluck('reserva_id')->toArray();
		$res = Reservas::whereIn('id', $agenda)->pluck('users_id')->toArray();
		$users = User::whereIn('id', $res)->whereDoesntHave('clubes', function ($qry) use ($clubes_id) {
			$qry->whereNotIn('clubes_id', $clubes_id);
		})->get();
		return $users;
	}
}









