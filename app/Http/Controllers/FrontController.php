<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Clubes;
use App\Models\Servicios;
use App\Models\Regiones;
use App\Models\Comunas;
use App\Models\TipoUsers;
use App\Models\UsersClubes;
use App\Models\Agenda;
use App\Models\Recintos;
use App\Models\Reservas;
use App\Models\Transaction;
use App\Models\Convenios;
use App\Models\UserConvenios;
use App\Models\RecintosConvenios;

use DateTime;
use Flash;
use Auth;

use App\Traits\MultiClases;

//Transbank SDK
use Transbank\Webpay\Options;
use Transbank\Webpay\WebpayPlus;

use Transbank\Webpay\WebpayPlus\MallTransaction;


class FrontController extends Controller
{
	use MultiClases;
	public function __construct(){
		if (app()->environment('production')) {
			WebpayPlus::configureForProduction(config('services.transbank.webpay_plus_mall_cc'), config('services.transbank.webpay_plus_mall_api_key'));
		} else {
			WebpayPlus::configureForTestingMall();
		}
	}
	public function testWP ()
	{
		$agenda = Agenda::find(4194);
		$costo_total = $agenda->valor_hora;
		$cc = ($agenda->recintos->clubes->estado_transbank == 0) ?  "597055555536" : $agenda->recintos->clubes->codigo_comercio_transbank;
		// dd($agenda->recintos->clubes, $costo_total, $cc);
		$val = $agenda->id;
		$request_transbank = [
			'buy_order' => $val,
			'session_id' => uniqid(),
			'return_url' => url('tb/arrendamiento/respuesta'), 
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
		Flash::success('Bloque pendiente por pagar, continue con el pago.');
		return view('sistema.socios.confirmar-arriendo')
		->with(['agenda' => $agenda, 'response_transbank' => $response_transbank, 'request_transbank' => $request_transbank]);
		// dd('test webpay', $request_transbank, $response_transbank);
	}
	public function createTransaction (Agenda $agenda, $valor)
	{
		$costo_total = $valor;
		$cc = ($agenda->recintos->clubes->estado_transbank == 0) ?  "597055555536" : $agenda->recintos->clubes->codigo_comercio_transbank;
		$val = $agenda->id;
		$request_transbank = [
			'buy_order' => $val,
			'session_id' => uniqid(),
			'return_url' => url('tb/arrendamiento/respuesta'), 
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

	public function agenda($mes = null, $ano = null)
	{
		is_null($mes) ? $mes = date('m') : $mes;
		(is_null($ano)) ? $ano = date('Y') : $ano;
		$reservas = Reservas::where('users_id', auth()->user()->id)
			->where('estado', 'Reservado')
			->select('id')
			->get()->toArray();
		$agenda = Agenda::whereIn('reserva_id', $reservas)
			->where('mes', $mes)
			->where('agno', $ano)
			->get();
		$fecha = DateTime::createFromFormat('m-Y', "$mes-$ano");
		$arr = $this->dates_month($mes,$ano);
		$array = self::weeks_in_month($mes,$ano);
		// dd($fecha, $mes, $ano);
		return view('sistema.socios.agenda')
		->with([
			'dias' => $arr,
			'semanas' => $array,
			'fecha' => $fecha,
			'agenda' => $agenda,
		]);
	}

	public function agendamiento($id)
	{
		// agendar ID de servicio se recibe
		$servicio = Servicios::find($id)->load(['clubes','recintos']);
		/* VALIDAR SI EL SERVICIO ES PAGO O NO, PARA MANDAR A ARRENDAMIENTO SEGUN SEA EL CASO. */
		return view('sistema.socios.agendamiento')
		->with([
			'servicio' => $servicio,
			'club' => $servicio->clubes,
			'recintos' => $servicio->recintos,
		]);
	}

	public function arrendamiento($id)
	{
		// agendar ID de servicio se recibe
		$servicio = Servicios::find($id)->load(['clubes']);
		return view('sistema.socios.arrendamiento')
		->with([
			'servicio' => $servicio,
			'club' => $servicio->clubes,
			'recintos' => $servicio->recintos,
		]);
	}

	public function servicios($id)
	{
		// SE RECIBE ID DE CLUB
		$club = Clubes::find($id);
		if (is_null($club)) {
			Flash::error('Club no encontrado');
			return redirect()->route('/');
		}
		$servicios = Servicios::where('clubes_id', $club->id)->get();
		// los servicios del clueb al cual el socio pertenece
		return view('sistema.socios.servicios')
		->with(['club' => $club, 'servicios' => $servicios,]);
	}

	public function home()
	{
		return view('sistema.socios.home');
	}

	public function listaClubes()
	{
		// todos los clubes
		$clubes = Clubes::all()->load(['comunas','comunas.regiones']);
		return view('sistema.socios.lista-clubes')
		->with(['clubes' => $clubes,]);
	}

	public function pagar()
	{
		return view('sistema.socios.pagar');
	}

	public function editarPerfil()
	{
		return view('sistema.socios.editar-perfil');
	}

	public function participantesAgenda()
	{
		return view('sistema.socios.participantes-agenda');
	}

	public function participantesArriendo()
	{
		return view('sistema.socios.participantes-arriendo');
	}

	public function perfil()
	{
		return view('sistema.socios.perfil');
	}

	public function recuperar()
	{
		return view('sistema.socios.recuperar');
	}

	public function registro()
	{
		return view('sistema.socios.registro');
	}
	/* ########## FUNCIONES AJAX ########## */
	public function loadAgenda ($id, $date)
	{
		// recibe ID de recinto
		// $maxtime = date_create()->modify('+1 hour')->format('H:i:s');
		$recinto = Recintos::find($id);
		$agenda = Agenda::where('recintos_id', $id)
			->whereDate('fecha', $date)
			->get();
		// dd($agenda, date('Y-m-d'));
		return response()->json($agenda);
	}
	public function agendar (Request $request, $id)
	{
		// ID del servicio al cual se está agendando
		$val = $request->validate([
			'horario_selected' => 'required',
			'recintos_id' => 'required',
		],[
			'horario_selected.required' => 'Debe seleccionar un bloque horario',
			'recintos_id.required' => 'Debe seleccionar un recinto del club',
		]);
		$agenda = Agenda::find($request->horario_selected);
		$costo_total = $agenda->valor_hora;
		if ($costo_total == 0) {
			if ($agenda->estado == "Reservado") {
				Flash::success('El bloque seleccionado ya está reservado');
				return redirect()->back();
			}
			$reserva = Reservas::create([
				'users_id' => auth()->user()->id,
				'estado' => 'Reservado',
			]);
			$agenda->reserva_id = $reserva->id;
			$agenda->estado = $reserva->estado;
			$agenda->update();
			Flash::success('Bloque reservado exitosamente');
			return redirect()->route('agenda');
		} elseif ($costo_total > 0) {
			if (isset($request->recintos_convenio_id) && !(is_null($request->recintos_convenio_id))) {
				// REEMPLAZAR VALOR
				$rec_conv = RecintosConvenios::find($request->recintos_convenio_id);
				if (!is_null($rec_conv) && !is_null($rec_conv->porcentaje) && $rec_conv->porcentaje > 0) {
					$descuento = round(($rec_conv->porcentaje * $costo_total) / 100);
				} else {
					$descuento = 0;
				}
				$costo_total = ($costo_total - $descuento);
				// $costo_total = !is_null($rec_conv) ? ($costo_total - $rec_conv->valor) : $costo_total;
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
			// dd($costo_total);
			$array = $this->createTransaction($agenda, $costo_total);
			Flash::success('Bloque pendiente por pagar, continue con el pago.');
			return view('sistema.socios.confirmar-arriendo')->with([
				'agenda' => $agenda,
				'response_transbank' => $array['response_transbank'],
				'request_transbank' => $array['request_transbank']
			]);
		}
	}
	public function arrendar (Request $request, $id)
	{
		
		// ID del servicio al cual se está agendando
		$val = $request->validate([
			'horario_selected' => 'required',
			'recintos_id' => 'required',
		],[
			'horario_selected.required' => 'Debe seleccionar un bloque horario',
			'recintos_id.required' => 'Debe seleccionar un recinto del club',
		]);
		$agenda = Agenda::find($request->horario_selected);

		if($agenda->reserva_id != null)
		{
			//No permite que continue si la agenda tiene una reserva Por Pagar o Reservada
			Flash::error('Bloque Reservado, Intente nuevamente');
			return redirect()->route('lista-clubes');
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
		

		$costo_total = $agenda->valor_hora;

		$request_transbank = [
			'buy_order' => $agenda->id,
			'session_id' => $request->session()->get('_token'),
			'return_url' => url('tb/arrendamiento/respuesta'), 
			'details' => [
				//En Este Array Puedo Mandar Multiples Cobros CASAU 43127652
				["amount" => $costo_total,
				"commerce_code" => ($agenda->recintos->clubes->estado_transbank == 0) ?  "597055555536" : $agenda->recintos->clubes->codigo_comercio_transbank,
				"buy_order" => "OrdenCompra_".$agenda->id]
				
			]
		];

		$response_transbank = (new WebpayPlus\MallTransaction)->create($request_transbank['buy_order'], $request_transbank['session_id'],  $request_transbank['return_url'], $request_transbank['details']);

		$transaction = Transaction::create([
			'tipo' => 'transbank',
			'agenda_id' => $agenda->id,
			'token' => $response_transbank->token,
			'return_url' => $response_transbank->url,
			'amount' => $costo_total
		]);

		//Ruta Original
		//return redirect()->route('agenda');

		Flash::success('Bloque pendiente por pagar, continue con el pago.');
		return view('sistema.socios.confirmar-arriendo')
		->with(['agenda' => $agenda, 'response_transbank' => $response_transbank, 'request_transbank' => $request_transbank]);
	}

	public function commitTransaccionMall(Request $request)
	{
		// dd($request, $_GET, $_POST);
		if (!isset($request->token_ws)) {
			Flash::error('Transaccion cancelada TKN: '.$request->TBK_TOKEN);
			$agnd = Agenda::find($request->TBK_ORDEN_COMPRA);
			$agnd->update([
				'reserva_id' => null,
				'estado' => 'Disponible',
			]);
			// $transaction = Transaction::where('agenda_id', $request->TBK_ORDEN_COMPRA)
			return redirect()->route('lista-clubes');
		}
		$token = $request->token_ws;
		// if (is_null($token) &&  !is_null($request->TBK_TOKEN)) {
		// 	Flash::error("TKN: ".$request->TBK_TOKEN);
		// 	return redirect()->route('lista-clubes');
		// }
		try{
			$response_transbank = (new WebpayPlus\MallTransaction)->commit($token);
		
		} catch (WebpayPlus\Exceptions\MallTransactionCommitException $e) {
			Flash::error($e->getTransbankErrorMessage());
			return redirect()->route('lista-clubes');
		}
		
		if($response_transbank->isApproved()){
			$agenda = Agenda::find($response_transbank->buyOrder);
			$reserva = Reservas::find($agenda->reserva_id);
			if($reserva)
			{
				$agenda->estado = "Reservado";
				$agenda->update();
		
				$reserva->estado = "Reservado";
				$reserva->update();
				Flash::success('Bloque reservado con éxito');
			}else{
				Flash::error('El numero de reserva ya no existe, Contacte con un administrador');
				return redirect()->route('lista-clubes');
			}

		}else{
			//Si la transacción se rechaza se borra la reserva y se limpian los datos en la agenda
			$agenda = Agenda::find($response_transbank->buyOrder);

			$reserva = Reservas::find($agenda->reserva_id);
			$reserva->delete();

			$agenda->estado = "Disponible";
			$agenda->reserva_id = null;
			$agenda->update();
			Flash::error('Transacción Rechazada, intente nuevamente');
		}

		

		
		//Vista de la Transacción Comitted
		return view('sistema.socios.respuesta-arriendo', ["token" => $token, "response_transbank" => $response_transbank, "agenda" => $agenda]);

	}

	public function reembolsoTransaccionMall(Request $request)
	{
		$req = $request->except('_token');
		$token = $req["token"];
		$agenda = Agenda::find($req["buy_order"]);
		try {
			$response_transbank = (new WebpayPlus\MallTransaction)->refund($token, $req["buy_order"],$req["commerce_code"], $req["amount"]);
		} catch (WebpayPlus\Exceptions\TransactionRefundException $e) {
			Flash::error($e->getTransbankErrorMessage());
			return redirect()->route('recintos.todos');
		}
		if($response_transbank->getType() == 'NULLIFIED') //Anulación de la compra
		{
			if($response_transbank->getResponseCode() == 0) //La anulación fue exitosa
			{	
			$reserva = Reservas::find($agenda->reserva_id);
			$reserva->delete();
			$transaction = Transaction::where('agenda_id', $agenda->id)->delete();
			$agenda->estado = "Disponible";
			$agenda->reserva_id = null;
			$agenda->update();
			Flash::success('Transacción rembolsada con éxito y el bloque ha sido liberado');	
			return redirect()->route('recintos.todos');
			}else //hubo un problema con la anulación
			{
				Flash::error(' Error al rembolsar transacción');
				return redirect()->route('recintos.todos');
			}
			
		}
		else if ($response_transbank->getType() == 'REVERSED') //Reversado
		{
			$reserva = Reservas::find($agenda->reserva_id);
			$reserva->delete();
			$transaction = Transaction::where('agenda_id', $agenda->id)->delete();
			$agenda->estado = "Disponible";
			$agenda->reserva_id = null;
			$agenda->update();
			Flash::success('Transacción revesada, se libera el bloque');
			return redirect()->route('recintos.todos');
			

		}else{
			Flash::error('Error Inesperado');
			return redirect()->route('recintos.todos');
		}
		//Vista de la Respuesta del Reembolso
		
	}

	public function obtenerEstadoTransaccionMall(Request $request)
	{
		$req = $request->except('_token');
		$token = $req["token_ws"];
		
		$response_transbank = (new WebpayPlus\MallTransaction)->status($token);
		$agenda = Agenda::find($response_transbank->buyOrder);

		//Vista Para obtener el estado de una Transacción
		return view('sistema.socios.respuesta-estado', ["response_transbank" => $response_transbank, "req" => $req,  "agenda" => $agenda]);
	}
}
