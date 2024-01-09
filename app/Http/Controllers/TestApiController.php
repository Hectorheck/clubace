<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\WelcomeEmail;

class TestApiController extends Controller
{
	public function testQuery ()
	{
		dd(DB::getQueryLog());
	}
	public function phptest ()
	{
		$res1 = explode('-', '17331-17332-17333');
		$res2 = explode('-', '17331');
		$res3 = explode('-', 17331);
		$RESPUESTA_ = '{
		    "res1": [
		        "17331",
		        "17332",
		        "17333"
		    ],
		    "res2": [
		        "17331"
		    ],
		    "res3": [
		        "17331"
		    ]
		}';
		return ["res1" => $res1,"res2" => $res2,"res3" => $res3,];
	}
	public function mailView ()
	{
		// return view('');
		$user = User::find(1029);
		return new WelcomeEmail($user);
	}
	public function newAgendar (Request $request)
	{
		$val = $request->validate([
			'horario_selected' => 'required|array',
		],[
			'horario_selected.required' => 'Debe seleccionar un bloque horario',
		]);
		if (count($val['horario_selected']) < 1) {
			throw new Exception("Debe seleccionar una lista de horarios para agendar, min 1", 1);
		}
		return count($val['horario_selected']);
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
}
