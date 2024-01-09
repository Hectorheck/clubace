<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Clubes;
use App\Models\Recintos;
use App\Models\Servicios;
use App\Models\Reservas;
use App\Models\Agenda;
use App\Models\Asistencia;
use App\Models\TipoUsers;
use App\Models\User;
use App\Models\UsersClubes;
use App\Models\Transaction;
use App\Models\Notificaciones;
use App\Models\NotificacionesUsers;
use App\Models\Convenios;
use App\Models\UserConvenios;
use App\Models\RecintosConvenios;
use App\Models\ClubesDestacados;

use DateTime;

use App\Traits\MultiClases;
use App\Traits\AppCheck;

use Illuminate\Support\Facades\DB;
use Transbank\Webpay\Options;
use Transbank\Webpay\WebpayPlus;

use Transbank\Webpay\WebpayPlus\MallTransaction;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ApiWebController extends Controller
{
	use MultiClases, AppCheck;
	public function __construct ()
	{
		if (app()->environment('production')) {
			WebpayPlus::configureForProduction(config('services.transbank.webpay_plus_mall_cc'), config('services.transbank.webpay_plus_mall_api_key'));
		} else {
			WebpayPlus::configureForTestingMall();
		}
	}
	public function createTransaction (Agenda $agenda, $valor)
	{
		$costo_total = $valor;
		$cc = ($agenda->recintos->clubes->estado_transbank == 0) ?  "597055555536" : $agenda->recintos->clubes->codigo_comercio_transbank;
		$val = $agenda->id;
		$request_transbank = [
			'buy_order' => $val,
			'session_id' => uniqid(),
			'return_url' => url('api/arrendamiento/respuesta'),
			'details' => [
				//En Este Array Puedo Mandar Multiples Cobros
				[
					"amount" => $costo_total,
					"commerce_code" => $cc,
					"buy_order" => "OrdenCompra_".$val]
				]
		];
		$response_transbank = (new MallTransaction)->create(
			$request_transbank['buy_order'],
			$request_transbank['session_id'],
			$request_transbank['return_url'],
			$request_transbank['details']
		);
		$transaction = Transaction::create([
			'tipo' => 'transbank',
			'agenda_id' => $agenda->id,
			'token' => $response_transbank->token,
			'return_url' => $response_transbank->url,
			'amount' => $costo_total
		]);
		$array = [
			'transaction' => $transaction,
			'request_transbank' => $request_transbank,
			'response_transbank' => $response_transbank,
		];
		return $array;
	}
	public function createTransactionMulti ($agendas, $valor, $cc)
	{
		// if (!is_array($agendas)) {
		if (!$agendas instanceof \Illuminate\Database\Eloquent\Collection) {
			return $array = ['error' => "Debe enviar más de un registro de agenda",];
		}
		$costo_total = $valor;
		$val = implode('-', $agendas->pluck('id')->toArray());
		$request_transbank = [
			'buy_order' => $val,
			'session_id' => uniqid(),
			'return_url' => url('api/arrendamiento/respuesta'),
			'details' => [
				[
					"amount" => $costo_total,
					"commerce_code" => $cc,
					"buy_order" => "OC_".$val]
				]
		];
		$response_transbank = (new MallTransaction)->create(
			$request_transbank['buy_order'],
			$request_transbank['session_id'],
			$request_transbank['return_url'],
			$request_transbank['details']
		);
		$transaction = Transaction::create([
			'tipo' => 'transbank',
			'agenda_id' => 0,
			'agendas_id' => $val,
			'token' => $response_transbank->token,
			'return_url' => $response_transbank->url,
			'amount' => $costo_total
		]);
		$array = [
			'transaction' => $transaction,
			'request_transbank' => $request_transbank,
			'response_transbank' => $response_transbank,
		];
		return $array;
	}
	public function dashboard ()
	{
		// return auth()->user();
		$clubid = (count(auth()->user()->clubes) > 0) ? auth()->user()->clubes->first()->clubes_id : 0;
		$club = Clubes::find($clubid);
		return response()->json(['club' => $club,]);
	}
	public function clubes (Request $request)
	{
		$privados = self::removeClub();
		$var = self::checkApp($request);
		if ($var) {
			$clubes = Clubes::where('clubes.id', $var->id)->join('comunas as c', 'clubes.comunas_id', '=', 'c.id')
				->join('regiones as r', 'c.regiones_id', '=', 'r.id')
				->get(['clubes.id', 'clubes.display_name', 'clubes.rut', 'clubes.direccion_calle', 'clubes.direccion_numero', 'clubes.logo_url', 'clubes.geo_lat', 'clubes.geo_lng', 'clubes.color_1', 'clubes.color_2', 'clubes.dias_atencion', 'clubes.comunas_id', 'c.nombre as comuna', 'r.nombre as region']);
			$response = [
				'clubes' => $clubes,
			];
			return response($response, 201);
		}
		$clubes = Clubes::whereNotIn('clubes.id', $privados)
			->join('comunas as c', 'clubes.comunas_id', '=', 'c.id')
			->join('regiones as r', 'c.regiones_id', '=', 'r.id')
			->get(['clubes.id', 'clubes.display_name', 'clubes.rut', 'clubes.direccion_calle', 'clubes.direccion_numero', 'clubes.logo_url', 'clubes.geo_lat', 'clubes.geo_lng', 'clubes.color_1', 'clubes.color_2', 'clubes.dias_atencion', 'clubes.comunas_id', 'c.nombre as comuna', 'r.nombre as region']);
		// $clubes = Clubes::all('id', 'display_name', 'rut', 'direccion_calle', 'direccion_numero', 'logo_url', 'color_1', 'color_2', 'dias_atencion', 'comunas_id')->load(['comunas','comunas.regiones']);
		$response = [
			'clubes' => $clubes,
		];
		return response($response, 201);
		// ->with(['clubes' => $clubes,]);
	}

	public function getAlrededores($lat, $lng, $distance, $earthRadius = 6371)
	{
		$return = array();

		// Los angulos para cada dirección
		$cardinalCoords = array('north' => '0',
								'south' => '180',
								'east' => '90',
								'west' => '270');

		$rLat = deg2rad($lat);
		$rLng = deg2rad($lng);
		$rAngDist = $distance/$earthRadius;

		foreach ($cardinalCoords as $name => $angle)
		{
			$rAngle = deg2rad($angle);
			$rLatB = asin(sin($rLat) * cos($rAngDist) + cos($rLat) * sin($rAngDist) * cos($rAngle));
			$rLonB = $rLng + atan2(sin($rAngle) * sin($rAngDist) * cos($rLat), cos($rAngDist) - sin($rLat) * sin($rLatB));

			$return[$name] = array('lat' => (float) rad2deg($rLatB),
									'lng' => (float) rad2deg($rLonB));
		}

		return array('min_lat'  => $return['south']['lat'],
					'max_lat' => $return['north']['lat'],
					'min_lng' => $return['west']['lng'],
					'max_lng' => $return['east']['lng']);
	}

	public function clubesDistancia ($lat,$lng,$km)
	{
		// todos los clubes
		// $clubes = Clubes::join('comunas as c', 'clubes.comunas_id', '=', 'c.id')
		// 	->join('regiones as r', 'c.regiones_id', '=', 'r.id')
		// 	->get(['clubes.id', 'clubes.display_name', 'clubes.rut', 'clubes.direccion_calle', 'clubes.direccion_numero', 'clubes.logo_url', 'clubes.geo_lat', 'clubes.geo_lng', 'clubes.color_1', 'clubes.color_2', 'clubes.dias_atencion', 'clubes.comunas_id', 'c.nombre as comuna', 'r.nombre as region']);
		// $clubes = Clubes::all('id', 'display_name', 'rut', 'direccion_calle', 'direccion_numero', 'logo_url', 'color_1', 'color_2', 'dias_atencion', 'comunas_id')->load(['comunas','comunas.regiones']);
		$distancia = $km;
		$box = $this->getAlrededores($lat,$lng,$distancia);
		$clubes = DB::select('SELECT clubes.id,clubes.display_name,clubes.rut,clubes.direccion_calle,clubes.direccion_numero,clubes.logo_url, clubes.color_1,clubes.color_2,clubes.dias_atencion,clubes.geo_lat,clubes.geo_lng,comunas.id as comunas_id,comunas.nombre as comuna,regiones.nombre as region, (6371 * ACOS(
			SIN(RADIANS(geo_lat))
			* SIN(RADIANS(' . $lat . '))
			+ COS(RADIANS(geo_lng - ' . $lng . '))
			* COS(RADIANS(geo_lat))
			* COS(RADIANS(' . $lat . '))
			)
			) AS distance
			FROM clubes,comunas,regiones
			WHERE (geo_lat BETWEEN ' . $box['min_lat']. ' AND ' . $box['max_lat'] . ')
			AND (geo_lng BETWEEN ' . $box['min_lng']. ' AND ' . $box['max_lng']. ') AND (comunas.id = clubes.comunas_id) AND (regiones.id = comunas.regiones_id) AND (deleted_at IS NULL)
			HAVING distance  < ' . $distancia . '
			ORDER BY distance ASC');
		$response = [
			'clubes' => $clubes,
		];
		return response($response, 201);
		// ->with(['clubes' => $clubes,]);
	}
	public function miClub ($id)
	{
		$club = Clubes::find($id);
		$uc = UsersClubes::where('clubes_id', $id)
			->where('users_id', auth()->user()->id)
			->first();
		$servicios = Servicios::join('clubes as c','servicios.clubes_id','=','c.id')
			->where('clubes_id', $id)
			->get(['servicios.*','c.display_name as club']);
		$response = [
			'estado' => ($uc) ? $uc->estado : 'sin membresía',
			'servicios' => $servicios,
		];
		return response($response, 201);
	}
	public function misClubes ()
	{
		$arr = ['clubes.id', 'clubes.display_name', 'clubes.rut', 'clubes.direccion_calle', 'clubes.direccion_numero', 'clubes.logo_url', 'clubes.geo_lat', 'clubes.geo_lng', 'clubes.color_1', 'clubes.color_2', 'clubes.dias_atencion', 'clubes.comunas_id', 'c.nombre as comuna', 'r.nombre as region'];
		$ids = UsersClubes::where('users_id', auth()->user()->id)
			->where('estado', 'ACEPTADO')
			->select('clubes_id')
			->get()->toArray();
		$clubes = Clubes::whereIn('clubes.id', $ids)
			->join('comunas as c', 'clubes.comunas_id', '=', 'c.id')
			->join('regiones as r', 'c.regiones_id', '=', 'r.id')
			->get($arr);
		return response($clubes, 201);
	}
	public function ClubesDestacados ()
	{
		// Retornar clubes destacados
		$destacados = ClubesDestacados::with('clubes')->get();
		return $destacados;
	}
	public function ClubesDestacadosDist (Request $request)
	{
		$val = $request->validate([
			'lat' => 'required',
			'lng' => 'required',
			'distancia' => 'required',
		]);
		$clubes = Clubes::selectRaw("clubes.id, clubes.display_name, clubes.rut, clubes.direccion_calle, clubes.direccion_numero, clubes.logo_url, clubes.geo_lat ,clubes.geo_lng, clubes.color_1, clubes.color_2, clubes.dias_atencion, clubes.comunas_id, c.nombre as comuna, r.nombre as region,
				( 6371 * acos( cos( radians(?) ) *
				cos( radians( geo_lat ) )
				* cos( radians( geo_lng ) - radians(?)
				) + sin( radians(?) ) *
				sin( radians( geo_lat ) ) )
				) AS distance", [$val['lat'], $val['lng'], $val['lat']])
		->having("distance", "<", $val['distancia'])
		->join('comunas as c', 'clubes.comunas_id', '=', 'c.id')
		->join('regiones as r', 'c.regiones_id', '=', 'r.id')
		->orderBy("distance",'asc')
		->whereHas('destacados')
		->get();
		return $clubes;
	}
	public function agenda (Request $request, $mes = null, $ano = null)
	{
		is_null($mes) ? $mes = date('m') : $mes;
		(is_null($ano)) ? $ano = date('Y') : $ano;
		$dia = date('d');
		$privados = self::removeClub();
		$var = self::checkApp($request);
		if ($var) {
			$recintos = Recintos::where('clubes_id', $var->id)->get()->pluck('id')->toArray();
			$reservas = Reservas::where('users_id', auth()->user()->id)
				->where('estado', 'Reservado')
				->select('id')
				->get()
				->toArray();
			// No debera cargar las borradas de la agenda, obviamente, entonces solo cargara en las que exista en recinto
			$agenda = Agenda::whereIn('reserva_id', $reservas)->whereIn('recintos_id', $recintos)
				->has('recintos')
				->where('mes', $mes)
				->where('agno', $ano)
				->with(['recintos','recintos.servicios','recintos.servicios.clubes','asistencia'])
				->orderBy('id', 'asc')
				->get();
			$filtrada = Agenda::whereIn('reserva_id', $reservas)->whereIn('recintos_id', $recintos)
				->has('recintos')
				->where('mes', $mes)
				->where('agno', $ano)
				->where('fecha', '>=', date('Y-m-d'))
				->with(['recintos','recintos.servicios','recintos.servicios.clubes','asistencia'])
				->orderBy('id', 'asc')
				->get();
			return response(['agenda' => $agenda, 'filtrada' => $filtrada], 201);
		}
		$recintos = Recintos::whereNotIn('clubes_id', $privados)->get()->pluck('id')->toArray();
		$reservas = Reservas::where('users_id', auth()->user()->id)
			->where('estado', 'Reservado')
			->select('id')
			->get()
			->toArray();
		// No debera cargar las borradas de la agenda, obviamente, entonces solo cargara en las que exista en recinto
		$agenda = Agenda::whereIn('reserva_id', $reservas)->whereIn('recintos_id', $recintos)
			->has('recintos')
			->where('mes', $mes)
			->where('agno', $ano)
			->with(['recintos','recintos.servicios','recintos.servicios.clubes','asistencia'])
			->orderBy('id', 'asc')
			->get();
		$filtrada = Agenda::whereIn('reserva_id', $reservas)->whereIn('recintos_id', $recintos)
			->has('recintos')
			->where('mes', $mes)
			->where('agno', $ano)
			->where('fecha', '>=', date('Y-m-d'))
			->with(['recintos','recintos.servicios','recintos.servicios.clubes','asistencia'])
			->orderBy('id', 'asc')
			->get();
		return response(['agenda' => $agenda, 'filtrada' => $filtrada], 201);
	}
	public function recintos ($id)
	{
		// ID SERVICIO
		$servicios = Servicios::find($id);
		$recintos = Recintos::where('servicios_id', $id)
			->get();
		// 'servicio' => $servicios->makeHidden(['deleted_at','created_at','updated_at',]),
		$response = [
			'recintos' => $recintos->makeHidden(['deleted_at','created_at','updated_at',]),
		];
		return response($response, 201);
	}
	public function solicitar ($id)
	{
		// FUNCION PARA SOLICITAR MEMBRESÍA
		$user = User::find(auth()->user()->id);
		$club = Clubes::find($id);
		UsersClubes::firstOrCreate([
			'clubes_id' => $club->id,
			'users_id' => $user->id,
		],[
			'estado' => 'PENDIENTE',
			'tipo_usuarios_id' => 3,
		]);
		$response = [
			'message' => 'Membresía al club solicitada',
		];
		return response($response, 201);
	}
	public function loadAgenda ($id, $date = null)
	{
		// recibe ID de recinto y fecha, desde APP
		if (is_null($date) || $date==date('Y-m-d')) {
			$date = date('Y-m-d');
			$hora = new DateTime();
			// $hora->modify('+2 hours');
		} else {
			$hora = new DateTime('00:00:00');
			// return $hora->format('H:i:s');
		}
		// $hora->modify('+2 hours');
		// * hora_inicio_bloque
		// * Se podrá agendar/arrendar de 2 horas más a partir de la hora actual
		$recinto = Recintos::find($id);
		$agenda = Agenda::where('recintos_id', $id)
			->whereTime('hora_inicio_bloque', '>=', $hora->format('H:i:s'))
			->whereDate('fecha', $date)
			->get(['id','agno','mes','dia','fecha','hora_inicio_bloque','hora_fin_bloque','estado','recintos_id',]);
		$user_conv = auth()->user()->user_convenios;
		// return $user_conv->pluck('convenios_id');
		$reales = Convenios::whereIn('id', $user_conv->pluck('convenios_id')->toArray())->count();
		// dd($user_conv->pluck('convenios_id'));
		/*
		production.ERROR: Trying to get property 'recintos_convenios' of non-object {"userId":42,"exception":"[object] (ErrorException(code: 0): Trying to get property 'recintos_convenios' of non-object at /var/www/html/aceclubwebapp/app/Http/Controllers/ApiWebController.php:380)
		*/
		if (count($user_conv) > 0 && $reales > 0) {
			$convenios = $recinto->recintos_convenios
				->whereIn('convenios_id', $user_conv->pluck('convenios_id'))
				->load('convenios')->whereNotNull('convenios');
			// dd($user_conv->pluck('convenios_id'), $recinto->recintos_convenios, $recinto);
		} else {
			$convenios = [];
		}
		return response()->json(['agenda' => $agenda, 'convenio' => $convenios,]);
	}
	public function notificaciones (Request $request)
	{
		$var = self::checkApp($request);
		$privados = self::removeClub();
		if ($var) {
			$notificaciones = Notificaciones::where('clubes_id', $var->id)->get()->pluck('id')->toArray();
			$data = NotificacionesUsers::where('user_id', auth()->user()->id)
				->orderBy('id', 'DESC')
				->whereIn('notificaciones_id', $notificaciones)
				->with(['notificaciones',])
				->get();
			return $data;
		}
		$notis = Notificaciones::whereNotIn('clubes_id', $privados)->get()->pluck('id')->toArray();
		$data = NotificacionesUsers::where('user_id', auth()->user()->id)
			->orderBy('id', 'DESC')
			->whereIn('notificaciones_id', $notis)
			->with(['notificaciones',])->get();
		return $data;
	}
	public function notificacionesleida ($id)
	{
		$data = NotificacionesUsers::find($id)->update([
			'estado' => 'leido',
			'leido' => date('Y-m-d H:i:s'),
		]);
		$response = [
			'message' => 'Notificacion actualizada',
		];
		return response($response, 201);
	}
	// public function agendamiento (Request $request, $id)
	// {
	// 	// agendar ID de servicio se recibe
	// 	$tkn = $request->bearerToken();
	// 	// dd($tkn);
	// 	$servicio = Servicios::find($id)->load(['clubes','recintos']);
	// 	return view('api.sistema.agendamiento')
	// 	->with([
	// 		'servicio' => $servicio,
	// 		'club' => $servicio->clubes,
	// 		'recintos' => $servicio->recintos,
	// 		'tkn' => $tkn,
	// 	]);
	// }
	public function agendar (Request $request)
	{
		// ID del servicio al cual se está agendando
		$val = $request->validate([
			'horario_selected' => 'required',
		],[
			'horario_selected.required' => 'Debe seleccionar un bloque horario',
		]);
		/* ##### Validar si tiene valor o no el servicio y recinto, si uno tiene, es arriendo ##### */
		// recibo horario, obtengo recinto a traves del horario. decido si es agenda o arriendo. si es agenda, se guarda
		// de manera simple, si es arriendo, se hace la transaccion y se retorna el webview.

		/* ########## NUEVA VALIDACION ########## */
		// Si el usuario ya tiene agendada una hora de cierto dia, que no pueda agendar a esa misma hora en otro recinto.
		/* ########## NUEVA VALIDACION ########## */
		$agenda = Agenda::find($request->horario_selected);
		if (is_null($agenda)) {
			return response([
				'message' => 'Valor seleccionado no existe'
			], 401);
		}
		// $recinto = Recintos::find($agenda->recintos_id);
		// $servicio = Servicios::find($recinto->servicios_id);
		// $costo_total = $agenda->recintos->servicios->valor + $agenda->recintos->tipo;
		$costo_total = $agenda->valor_hora;
		$recinto = Recintos::find($agenda["recintos_id"]);
		if ($costo_total == 0 || $recinto["clubes_id"] == 7) {
			if ($agenda->estado == "Reservado") {
				return response()->json(['mensaje' => 'El horario seleccionado ya está reservado']);
			}
			$reserva = Reservas::create([
				'users_id' => auth()->user()->id,
				'estado' => 'Reservado',
			]);
			$agenda->reserva_id = $reserva->id;
			$agenda->estado = $reserva->estado;
			$agenda->update();
			return response()->json(['agenda' => $agenda, 'reserva' => $reserva,]);
		} elseif ($costo_total > 0) {
			// recintos_convenio_id
			// chequear convenio existente, y aplicar precio nuevo
			if (isset($request->recintos_convenio_id) && !(is_null($request->recintos_convenio_id))) {
				// REEMPLAZAR VALOR
				$rec_conv = RecintosConvenios::find($request->recintos_convenio_id);
				if (!is_null($rec_conv) && !is_null($rec_conv->porcentaje) && $rec_conv->porcentaje > 0) {
					$descuento = round(($rec_conv->porcentaje * $costo_total) / 100);
				} else {
					$descuento = 0;
				}
				$costo_total = ($costo_total - $descuento);
				if ($costo_total == 0 || $costo_total < 0) {
					// NUEVAMENTE, POR EL CONV CHECK si es 0
					$reserva = Reservas::create([
						'users_id' => auth()->user()->id,
						'estado' => 'Reservado',
					]);
					$agenda->reserva_id = $reserva->id;
					$agenda->estado = $reserva->estado;
					$agenda->update();
					return response()->json(['agenda' => $agenda, 'reserva' => $reserva,]);
				} else {
					$reserva = Reservas::create([
						'users_id' => auth()->user()->id,
						'estado' => 'Por Pagar',
						'forma_pago' => "Transbank",
					]);
					$agenda->reserva_id = $reserva->id;
					$agenda->estado = $reserva->estado;
					// $agenda->reserva_temporal_inicio = date('H:i:s');
					$agenda->update();
					$array = $this->createTransaction($agenda, $costo_total);
					$transaction = $array['transaction'];
					return response()->json(['url' => url("/api/agendamiento/$transaction->id/confirmar"),]);
				}
			}
			$reserva = Reservas::create([
				'users_id' => auth()->user()->id,
				'estado' => 'Por Pagar',
				'forma_pago' => "Transbank",
			]);
			$agenda->reserva_id = $reserva->id;
			$agenda->estado = $reserva->estado;
			// $agenda->reserva_temporal_inicio = date('H:i:s');
			$agenda->update();
			$array = $this->createTransaction($agenda, $costo_total);
			$transaction = $array['transaction'];
			return response()->json(['url' => url("/api/agendamiento/$transaction->id/confirmar"),]);
		}
	}
	public function agendaMulti (Request $request, $array = [])
	{
		$val = $request->validate([
			'horario_selected' => 'required|array',
		],[
			'horario_selected.required' => 'Debe seleccionar un bloque horario',
		]);
		if (!is_array($val['horario_selected'])) {
			$response['error'] = "Debe seleccionar una lista de horarios para agendar";
			return $response;
		}
		if (count($val['horario_selected']) > 3 || count($val['horario_selected']) < 1) {
			$response['error'] = "Debe seleccionar un mínimo de 1 horario y un máximo de 3";
			return $response;
		}
		$registros = Agenda::whereIn('id', $val['horario_selected'])->get();
		$costo_total = $registros->sum('valor_hora');
		/* ##### VALIDAR QUE SEAN DEL MISMO RECINTO ES INNECESARIO ACA ##### */
		if (isset($request->recintos_convenio_id) && !(is_null($request->recintos_convenio_id))) {
			$rec_conv = RecintosConvenios::find($request->recintos_convenio_id);
			if (!is_null($rec_conv) && !is_null($rec_conv->porcentaje) && $rec_conv->porcentaje > 0) {
				$descuento = round(($rec_conv->porcentaje * $costo_total) / 100);
			} else {
				$descuento = 0;
			}
			$costo_total = ($costo_total - $descuento);
		}
		if ($costo_total > 0) {
			$agenda = $registros->first();
			$cc = $agenda->recintos->clubes->estado_transbank == 0 ? "597055555536" : $agenda->recintos->clubes->codigo_comercio_transbank;
			$reserva = Reservas::create([
				'users_id' => auth()->user()->id,
				'estado' => 'Por Pagar',
				'forma_pago' => "Transbank",
			]);
			foreach ($registros as $key => $agenda) {
				$agenda->update(['reserva_id' => $reserva->id, 'estado' => $reserva->estado,]);
			}
			/* ##### CREAR TRANSACCIÓN. ##### */
			$array = $this->createTransactionMulti($registros, $costo_total, $cc);
			$transaction = $array['transaction'];
			return response()->json(['url' => url("/api/agendamiento/$transaction->id/confirmar"),]);
		} else {
			$reserva = Reservas::create([
				'users_id' => auth()->user()->id,
				'estado' => 'Reservado',
			]);
			foreach ($registros as $key => $agenda) {
				$agenda->update(['reserva_id' => $reserva->id, 'estado' => $reserva->estado,]);
			}
			return response()->json(['agenda' => $registros, 'reserva' => $reserva,]);
		}
	}
	public function urlTransaction ($id)
	{
		$transaction = Transaction::find($id);
		if (($transaction->agenda_id) == 0) {
			$registros = $transaction->agendas_id;
			$var = explode('-', $registros);
			$agenda = Agenda::whereIn('id', $var)->get();
		} else {
			$agenda = Agenda::find($transaction->agenda_id);
		}
		return view('api.sistema.confirmar-arriendo')
		->with(['transaction' => $transaction,'agenda' => $agenda,]);
	}
	public function commitTransaccionMall (Request $request)
	{
		if (!isset($request->token_ws)) {
			$mensaje = 'Transaccion cancelada, puede volver a intentar la compra';
			$ordenCompra = explode('-', $request->TBK_ORDEN_COMPRA);
			$agnd = Agenda::whereIn('id', $ordenCompra)->update([
				'reserva_id' => null,
				'estado' => 'Disponible',
			]);
			// $transaction = Transaction::where('agenda_id', $request->TBK_ORDEN_COMPRA)
			return view('sistema.socios.mensaje')->with(['mensaje' => $mensaje,]);
		}
		$token = $request->token_ws;
		try{
			$response_transbank = (new WebpayPlus\MallTransaction)->commit($token);

		} catch (WebpayPlus\Exceptions\MallTransactionCommitException $e) {
			// Flash::error($e->getTransbankErrorMessage());
			return response()->json(['mensaje' => 'Error al reservar con transbank => '.$e->getTransbankErrorMessage()]);
		}
		if($response_transbank->isApproved()){
			$ordenCompra = explode('-', $response_transbank->buyOrder);
			// $agenda = Agenda::find($response_transbank->buyOrder); // buy_order
			$agenda = Agenda::whereIn('id', $ordenCompra)->get();
			$reserva = Reservas::find($agenda->first()->reserva_id);
			if($reserva) {
				foreach ($agenda as $key => $value) {
					$value->estado = "Reservado";
					$value->update();
				}

				$reserva->estado = "Reservado";
				$reserva->update();
				// Flash::success('Bloque reservado con éxito');
			} else{
				// Flash::error('El numero de reserva ya no existe, Contacte con un administrador');
				return response()->json(['mensaje' => 'El numero de reserva ya no existe, Contacte con un administrador']);
			}
		}else{
			//Si la transacción se rechaza se borra la reserva y se limpian los datos en la agenda
			$ordenCompra = explode('-', $response_transbank->buyOrder);
			// $agenda = Agenda::find($response_transbank->buyOrder); // buy_order
			$agenda = Agenda::whereIn('id', $ordenCompra)->get();
			$reserva = Reservas::find($agenda->first()->reserva_id);
			$reserva->delete();
			foreach ($agenda as $key => $value) {
				$value->estado = "Disponible";
				$value->reserva_id = null;
				$value->update();
			}
			return response()->json(['mensaje' => 'Transacción Rechazada, intente nuevamente']);
		}
		//Vista de la Transacción Comitted
		return view('api.sistema.respuesta-arriendo',
			["token" => $token, "response_transbank" => $response_transbank, "agenda" => $agenda, "ordenCompra" => $ordenCompra]);
	}
	// public function agendarApi (Request $request, $id)
	// {
	// 	// ID del servicio al cual se está agendando
	// 	$val = $request->validate([
	// 		'horario_selected' => 'required',
	// 		'recintos_id' => 'required',
	// 	],[
	// 		'horario_selected.required' => 'Debe seleccionar un bloque horario',
	// 		'recintos_id.required' => 'Debe seleccionar un recinto del club',
	// 	]);
	// 	$agenda = Agenda::find($request->horario_selected);
	// 	if ($agenda->estado == "Reservado") {
	// 		Flash::success('El bloque seleccionado ya está reservado');
	// 		return redirect()->back();
	// 	}
	// 	$reserva = Reservas::create([
	// 		'users_id' => auth()->user()->id,
	// 		'estado' => 'Reservado',
	// 	]);
	// 	$agenda->reserva_id = $reserva->id;
	// 	$agenda->estado = $reserva->estado;
	// 	$agenda->update();
	// 	Flash::success('Bloque reservado exitosamente');
	// 	return redirect()->route('agenda');
	// }

	public function confirmarAsistencia(Request $request)
	{
		$val = $request->validate([
			'agenda_id'=>'required',
			'club_id'=> 'required',
			'reserva_id'=> 'required',
			'lat' => 'required',
			'lng' => 'required'
		]);
		$idAgenda = $val['agenda_id'];
		$idClub = $val['club_id'];
		$idReserva = $val['reserva_id'];
		$lat = $val['lat'];
		$lng = $val['lng'];
		$distancia = 1;
		$ano = null;
		$mes = null;
		$box = $this->getAlrededores($lat,$lng,$distancia);
		$clubes = DB::select('SELECT clubes.id,clubes.display_name,clubes.rut,clubes.direccion_calle,clubes.direccion_numero,clubes.logo_url, clubes.color_1,clubes.color_2,clubes.dias_atencion,comunas.id as comunas_id,comunas.nombre as comuna,regiones.nombre as region, (6371 * ACOS(
			SIN(RADIANS(geo_lat))
			* SIN(RADIANS(' . $lat . '))
			+ COS(RADIANS(geo_lng - ' . $lng . '))
			* COS(RADIANS(geo_lat))
			* COS(RADIANS(' . $lat . '))
			)
			) AS distance
			FROM clubes,comunas,regiones
			WHERE (geo_lat BETWEEN ' . $box['min_lat']. ' AND ' . $box['max_lat'] . ')
			AND (geo_lng BETWEEN ' . $box['min_lng']. ' AND ' . $box['max_lng']. ') AND (comunas.id = clubes.comunas_id) AND (regiones.id = comunas.regiones_id) AND clubes.id = '.$idClub.'
			HAVING distance  < ' . $distancia . '
			ORDER BY distance ASC');
		if (empty($clubes)) {
			return response(["msj"=> 'Debe estar en un radio de 1km',$clubes], 200);
		}else{
				$reservas = Reservas::where('id', $idReserva)
				->where('estado', 'Reservado')
				->select('id')
				->get()
				->toArray();
				is_null($mes) ? $mes = date('m') : $mes;
				(is_null($ano)) ? $ano = date('Y') : $ano;
				$agenda = Agenda::whereIn('reserva_id', $reservas)
				->has('recintos')
				->where('mes', $mes)
				->where('agno', $ano)
				->with(['recintos','recintos.servicios','recintos.servicios.clubes','asistencia'])
				->orderBy('id', 'asc')
				->get();
				$asistencia = Asistencia::create([
					"users_id" => auth()->user()->id,
					"agenda_id" => $idAgenda,
					"reservas_id" => $idReserva,
					"estado" => 'Confirmado',
					"confirmado" => 1,
					"time_confirmado" => date('Y-m-d H:i:s')
				]);
				return response(["msj" => "Confirmado", $agenda], 200);
		}
	}

}





