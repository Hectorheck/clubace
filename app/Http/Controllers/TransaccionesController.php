<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Reservas;
use App\Models\Agenda;
use App\Models\Recintos;
use App\Models\Reembolsos;

use Flash;

use Transbank\Webpay\WebpayPlus\MallTransaction;

class TransaccionesController extends Controller
{
	public function loadReembolsos ()
	{
		$agenda = Agenda::whereIn('recintos_id', auth()->user()->getRecintos()->pluck('id'))
			// ->whereNotNull('reserva_id')->where('estado', 'Reservado')
			->get();
		// $reservas = Reservas::whereIn('id', $agenda->pluck('reserva_id')->toArray())->get();
		// $transacciones = Transaction::whereIn('agenda_id', $agenda->pluck('id')->toArray())->orderBy('id', 'DESC')->get();
		$reembolsos = Reembolsos::with(['transactions','transactions.agenda',])
			->whereIn('agenda_id', $agenda->pluck('id')->toArray())
			->get();
		return $reembolsos;
	}
	public function index ()
	{
		$agenda = Agenda::whereIn('recintos_id', auth()->user()->getRecintos()->pluck('id'))
			// ->whereNotNull('reserva_id')->where('estado', 'Reservado')
			->get();
		// $reservas = Reservas::whereIn('id', $agenda->pluck('reserva_id')->toArray())->get();
		$transacciones = Transaction::whereIn('agenda_id', $agenda->pluck('id')->toArray())->orderBy('id', 'DESC')->get();
		$array = $this->dataTransactions();
		return view('sistema.adminclub.transacciones.index')->with([
			'transacciones' => $transacciones,
			'array' => $array,
		]);
	}
	public function dataTransactions ($array = [])
	{
		/* ########## SIN FECHAS NI DATOS ########## */
		$agenda = Agenda::whereIn('recintos_id', auth()->user()->getRecintos()->pluck('id'))
			->whereNotNull('reserva_id')->where('estado', 'Reservado')
			->get();
		$transacciones = Transaction::whereIn('agenda_id', $agenda->pluck('id')->toArray())
			->orderBy('id', 'DESC')->get();
		$array = [
			'movil' => $transacciones->where('tipo','transbank')->sum('amount'),
			'web' => $transacciones->where('tipo', 'web')->sum('amount'),
			'reembolsos' => 0,
		];
		return $array;
	}
	public function dataTransactionsFilter (
		$desde,
		$hasta,
		$club,
		$servicio,
		$recinto,
		$filtros = [])
	{
		($recinto != 0) ? $filtros['id'] = $recinto : null;
		($servicio != 0) ? $filtros['servicios_id'] = $servicio : null;
		($club != 0) ? $filtros['clubes_id'] = $club : null;
		$recintos = Recintos::where($filtros)->get();
		// ($recinto != 0) ? $recintos = Recintos::where('id', $recinto)->get() : $recintos = auth()->user()->getRecintos();
		// ($servicio != 0) ? $recintos = Recintos::where('servicios_id', $servicio)->get() : $recintos = auth()->user()->getRecintos();
		// ($club != 0) ? $recintos = Recintos::where('clubes_id', $club)->get() : $recintos = auth()->user()->getRecintos();
		$agenda = Agenda::whereIn('recintos_id', $recintos->pluck('id'))
			->whereBetween('fecha', [$desde, $hasta])
			->whereNotNull('reserva_id')->where('estado', 'Reservado')
			->get();
		$transacciones = Transaction::whereIn('agenda_id', $agenda->pluck('id')->toArray())->orderBy('id', 'DESC')->get();
		$array = [
			'movil' => $transacciones->where('tipo','transbank')->sum('amount'),
			'web' => $transacciones->where('tipo', 'web')->sum('amount'),
			'reembolsos' => 0,
		];
		return $array;
	}
	public function dataListaFilter ($desde,
		$hasta,
		$club,
		$servicio,
		$recinto,
		$filtros = [])
	{
		($recinto != 0) ? $filtros['id'] = $recinto : null;
		($servicio != 0) ? $filtros['servicios_id'] = $servicio : null;
		($club != 0) ? $filtros['clubes_id'] = $club : null;
		$recintos = Recintos::where($filtros)->get();
		// ($recinto != 0) ? $recintos = Recintos::where('id', $recinto)->get() : $recintos = auth()->user()->getRecintos();
		// ($servicio != 0) ? $recintos = Recintos::where('servicios_id', $servicio)->get() : $recintos = auth()->user()->getRecintos();
		// ($club != 0) ? $recintos = Recintos::where('clubes_id', $club)->get() : $recintos = auth()->user()->getRecintos();
		$agenda = Agenda::whereIn('recintos_id', $recintos->pluck('id'))
			->whereBetween('fecha', [$desde, $hasta])
			->whereNotNull('reserva_id')->where('estado', 'Reservado')
			->get();
		$transacciones = Transaction::whereIn('agenda_id', $agenda->pluck('id')->toArray())
			->with(['agenda','agenda.recintos',])->orderBy('id', 'DESC')->get();
		return $transacciones;
	}
	public function reembolsos ()
	{
		return view('sistema.adminclub.transacciones.reembolsos')
		->with([
			'reembolsos' => $this->loadReembolsos(),
		],);
	}
	public function storeReembolsos (Request $request, $id)
	{
		// RECIBE ID DE TRANSACCION
		$request->validate([
			'monto' => 'required',
		], [
			'monto.required' => 'Ingrese el monto a reembolsar',
		]);
		$transaccion = Transaction::find($id);
		if ($transaccion->tipo == "web") {
			$reembolso = Reembolsos::create([
				'agenda_id' => $transaccion->agenda_id,
				'users_id' => $transaccion->user_reserva->id,
				'transactions_id' => $id,
				'amount' => $request->monto,
			]);
			Flash::success('Reembolso registrado correctamente');
			return redirect()->back();
		} elseif ($transaccion->tipo == "transbank") {
			$agenda = Agenda::find($request->buy_order);
			$token = $request->token;
			try {
				$response_transbank = (new MallTransaction)->refund($token,"OrdenCompra_".$request->buy_order,$request->commerce_code,$request->monto);
			} catch (WebpayPlus\Exceptions\TransactionRefundException $e) {
				Flash::error($e->getTransbankErrorMessage());
				return redirect()->back();
			}
			if($response_transbank->getType() == 'NULLIFIED') {
				//Anulación de la compra, no por el monto total
				if($response_transbank->getResponseCode() == 0) {
				//La anulación fue exitosa
				$reserva = Reservas::find($agenda->reserva_id);
				$reserva->delete();
				// $transaction = Transaction::where('agenda_id', $agenda->id)->delete();
				$agenda->estado = "Disponible";
				$agenda->reserva_id = null;
				$agenda->update();
				$reembolso = Reembolsos::create([
					'transactions_id' => $id,
					'agenda_id' => $transaccion->agenda_id,
					'users_id' => $transaccion->user_reserva->id,
					'amount' => $request->monto,
					'token' => $token,
					'buy_order' => $request->buy_order,
					'commerce_code' => $request->commerce_code,
					'response' => serialize($response_transbank),
					'type' => $response_transbank->getType(),
					'authorization_code' => $response_transbank->getAuthorizationCode(),
					'authorization_date' => $response_transbank->getAuthorizationDate(),
					'balance' => $response_transbank->getBalance(),
					'nullified_amount' => $response_transbank->getNullifiedAmount(),
					'response_code' => $response_transbank->getResponseCode(),
				]);
				Flash::success('Transacción rembolsada con éxito y el bloque ha sido liberado');	
				return redirect()->back();
				}else {
					//hubo un problema con la anulación
					Flash::error(' Error al rembolsar transacción');
					return redirect()->back();
				}
				
			} else if ($response_transbank->getType() == 'REVERSED') {
				//Reversado
				$reserva = Reservas::find($agenda->reserva_id);
				$reserva->delete();
				$transaction = Transaction::where('agenda_id', $agenda->id)->delete();
				$agenda->estado = "Disponible";
				$agenda->reserva_id = null;
				$agenda->update();
				$reembolso = Reembolsos::create([
					'transactions_id' => $id,
					'agenda_id' => $transaccion->agenda_id,
					'users_id' => $transaccion->user_reserva->id,
					'amount' => $request->monto,
					'token' => $token,
					'buy_order' => $request->buy_order,
					'commerce_code' => $request->commerce_code,
					'response' => serialize($response_transbank),
					'type' => $response_transbank->getType(),
					'authorization_code' => $response_transbank->getAuthorizationCode(),
					'authorization_date' => $response_transbank->getAuthorizationDate(),
					'balance' => $response_transbank->getBalance(),
					'nullified_amount' => $response_transbank->getNullifiedAmount(),
					'response_code' => $response_transbank->getResponseCode(),
				]);
				Flash::success('Transacción revesada, se libera el bloque');
				return redirect()->back();
			} else {
				Flash::error('Error Inesperado');
				return redirect()->back();
			}
		}
	}
	/* ########## REEMBOLSOS ########## */
	// $response = (new \Transbank\Webpay\WebpayPlus\MallTransaction)->refund($token, $buy_order, $commerce_code, $amount);
	// $response->getAuthorizationCode();
	// $response->getAuthorizationDate();
	// $response->getBalance();
	// $response->getNullifiedAmount();
	// $response->getResponseCode();
	// $response->getType();
	/* ########## REEMBOLSOS ########## */
}
