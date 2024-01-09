<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Transbank\Webpay\Options;
use Transbank\Webpay\WebpayPlus;

class TransbankController extends Controller
{
	 /*
	// MALL TIENE CODIGO Y NO VENDE, SE ENTREGA UN COD DE TIENDA DE PRUEBAS
	// Padre, acematch, firma el contrato, tiene cod y no vende.
	// se llena el contrato PST mall (proveedor) y solo se marca esa opcion => retorna un cod de comercio
	// Por cada seller del mall (tienda) se hace un contrato PST comercio, se ingresa el cod anterior y asi se relacionan los cods
	// esta seria la tienda Nº 114 de tiendas mall
	 */
	// COD COMMERCIO MALL => 43237396
	// APIKEY productiva MALL => ea06051520cd217b2168fd7dd29fc057
	 // 76.846.088-4
	public function __construct(){
		if (app()->environment('production')) {
			WebpayPlus::configureForProduction(config('services.transbank.webpay_plus_mall_cc'), config('services.transbank.webpay_plus_mall_api_key'));
		} else {
			WebpayPlus::configureForTestingMall();
		}
	}

	public function crearTransaccionMall(Request $request)
	{

		$req = $request->except('_token');
		$resp = (new WebpayPlus\MallTransaction)->create($req["buy_order"], $req["session_id"],  $req["return_url"], $req["detail"]);

		//Vista de la Transacción Creada
		return view('/', [ "params" => $req,"response" => $resp]);

	}

	public function commitTransaccionMall(Request $request)
	{
		$req = $request->except('_token');
		$token = $req["token_ws"];
		$resp = (new WebpayPlus\MallTransaction)->commit($token);
		
		//Vista de la Transacción Comitted
		return view('/', ["params" => $req, "response" => $resp]);

	}

	public function obtenerEstadoTransaccionMall(Request $request)
	{
		$req = $request->except('_token');
		$token = $req["token"];
		$resp = (new WebpayPlus\MallTransaction)->status($token);

		//Vista Para obtener el estado de una Transacción
		return view('', ["resp" => $resp, "req" => $req]);
	}

	public function reembolsoTransaccionMall(Request $request)
	{
		$req = $request->except('_token');
		$token = $req["token"];
		try {
			$resp = (new WebpayPlus\MallTransaction)->refund($token, $req["buy_order"],$req["commerce_code"], $req["amount"]);
		} catch (WebpayPlus\Exceptions\TransactionRefundException $e) {
			dd($e);
		}

		//Vista de la Respuesta del Reembolso
		return view('/', ["req" => $req,"resp" => $resp]);
	}


}
