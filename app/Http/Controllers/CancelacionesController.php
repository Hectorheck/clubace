<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UsersClubes;
use App\Models\Notificaciones;
use App\Models\NotificacionesUsers;
use App\Models\Cancelaciones;
use App\Models\MotivosCancelaciones;
use App\Models\Agenda;
use App\Models\Reservas;
use App\Models\UserDevices;

use Flash;

use App\Traits\MultiClases;

class CancelacionesController extends Controller
{
	use MultiClases;
	public function __construct ()
	{
		//
	}
	public function index ()
	{
		$recintos = auth()->user()->getRecintos()->pluck('id');
		$agenda = Agenda::whereIn('recintos_id', $recintos)->get()->pluck('id');
		$cancelaciones = Cancelaciones::whereIn('agenda_id', $agenda)->latest()->get();
		return view('sistema.adminclub.cancelaciones.index')->with(['cancelaciones' => $cancelaciones,]);
	}
	/* ########## motivos CRUD ########## */
	public function motivos ()
	{
		$clubes = auth()->user()->getClubes()->pluck('id');
		$motivos = MotivosCancelaciones::whereIn('clubes_id', $clubes)->orderBy('clubes_id', 'DESC')->get();
		return view('sistema.adminclub.cancelaciones.motivos')->with(['motivos' => $motivos,]);
	}
	public function store (Request $request)
	{
		$var = $request->validate([
			'motivo' => 'required',
			'clubes' => 'required',
		],[
			'motivo.required' => 'Ingrese el motivo',
			'clubes.required' => 'Selecciones club(es) para el registro',
		]);
		foreach ($var['clubes'] as $key => $club) {
			MotivosCancelaciones::create([
				'motivo' => $var['motivo'],
				'clubes_id' => $club,
			]);
		}
		Flash::success('Registros creados');
		return redirect()->route('cancelaciones.motivos');
	}
	public function delete ($id)
	{
		$motivo = MotivosCancelaciones::find($id);
		$motivo->delete();
		Flash::success('Registro eliminado');
		return redirect()->route('cancelaciones.motivos');
	}
	public function edit (Request $request, $id)
	{
		$var = $request->validate([
			'motivo' => 'required',
		],[
			'motivo.required' => 'Ingrese el motivo',
		]);
		$motivo = MotivosCancelaciones::find($id);
		$motivo->update($var);
		Flash::success('Registros actualizado');
		return redirect()->route('cancelaciones.motivos');
	}
	/* ########## motivos CRUD ########## */
	/* ########## USER END ########## */
	public function sendCancelNotification ($user_id, $agenda_id)
	{
		$agenda = Agenda::find($agenda_id);
		$users = $this->usersGral($agenda->recintos->clubes_id);
		$noti = [
			'titulo' => 'Horario liberado en la agenda, quizá te pueda interesar',
			'mensaje' => "Se ha liberado el horario del recinto {$agenda->recintos->nombre} de {$agenda->recintos->servicios->nombre} ({$agenda->fecha} {$agenda->hora_inicio_bloque}) ",
			'tipo' => 'cancelacion',
			'creada' => 'automatica',
			'clubes_id' => $agenda->recintos->clubes_id,
		];
		$notificacion = Notificaciones::create($noti);
		$SERVER_API_KEY = env('SERVER_API_KEY');
		$users->map(function ($item, $key) use ($user_id, $users) {
			if ($item->id == $user_id) {
				unset($users[$key]);
			}
		});
		$devices = UserDevices::whereIn('user_id', $users->pluck('id'))->pluck('fcm_token');
		if (count($devices) > 0) {
			$data = [
				"registration_ids" => $devices,
				"notification" => [
					"title" => $noti['titulo'],
					"body" => $noti['mensaje'],
					"content_available" => true,
					"priority" => "high",
				],
				"data" => [
					"agenda_id" => $agenda->id,
					"agenda" => $agenda,
				]
			];
			$dataString = json_encode($data);

			$headers = [
				'Authorization: key=' . $SERVER_API_KEY,
				'Content-Type: application/json',
			];

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

			$response = curl_exec($ch);
			$res = json_decode($response, true);
			$var = $res['canonical_ids'];
			$message_id = null;
			foreach ($res['results'] as $key => $array) {
				foreach ($array as $k => $value) {
					if ($k == "message_id") {
						$message_id = $value;
					} else {
						$message_id = null;
					}
				}
			}
			foreach ($users as $key => $value) {
				$noti = NotificacionesUsers::create([
					'notificaciones_id' => $notificacion->id,
					'user_id' => $value->id,
					'estado' => 'enviado',
					'leido' => null,
					'message_id' => $message_id,
					'multicast_id' => $res["multicast_id"],
					'success' => $res["success"],
					'failure' => $res["failure"],
					'canonical_ids' => $res["canonical_ids"],
				]);
			}
			// NOTIFICACION ENVIADA E INFO GUARDADA
		}
	}
	public function getMotivos ($id)
	{
		// RECIBE ID DE CLUB para APP
		// $ids = auth()->user()->getClubes()->pluck('id'); ID de clubes del usuario
		$motivos = MotivosCancelaciones::where('clubes_id', $id)->get();
		return $motivos;
	}
	public function cancelar (Request $request)
	{
		// users_id agenda_id reservas_id motivos_cancelaciones_id comentario
		/* ########## MOTIVO DE CANCELAR, ID DE AGENDA ########## */
		$val = $request->validate([
			'agenda_id' => 'required',
			'motivos_cancelaciones_id' => 'required',
			'comentario' => 'nullable',
		]);
		$agenda = Agenda::find($val['agenda_id']);
		$val['reservas_id'] = $agenda->reserva_id;
		$val['users_id'] = auth()->user()->id;
		$cancelacion = Cancelaciones::create($val);
		$agenda->estado = "Disponible";
		$agenda->reserva_id = null;
		$agenda->update();
		$reserva = Reservas::find($val['reservas_id']);
		$reserva->estado = "cancelada";
		$reserva->update();
		$response = [
			'message' => 'Hora cancelada correctamente',
			'reserva' => $reserva
		];
		$this->sendCancelNotification(auth()->user()->id, $val['agenda_id']);
		return response($response, 201);
	}
	public function cancelarAdmin (Request $request, $users_id)
	{
		// users_id agenda_id reservas_id motivos_cancelaciones_id comentario
		/* ########## MOTIVO DE CANCELAR, ID DE AGENDA ########## */
		/* ########## CANCELAR DESDE EL ADMIN ########## */
		$val = $request->validate([
			'agenda_id' => 'required',
			'motivos_cancelaciones_id' => 'required',
			'comentario' => 'nullable',
		]);
		$agenda = Agenda::find($val['agenda_id']);
		$val['reservas_id'] = $agenda->reserva_id;
		$val['users_id'] = $users_id;
		$cancelacion = Cancelaciones::create($val);
		$agenda->estado = "Disponible";
		$agenda->reserva_id = null;
		$agenda->update();
		$reserva = Reservas::find($val['reservas_id']);
		// $reserva->estado = "cancelada";
		// $reserva->update();
		// $response = [
		// 	'message' => 'Hora cancelada correctamente',
		// 	'reserva' => $reserva
		// ];
		$this->sendCancelNotification($users_id, $val['agenda_id']);
		Flash::success('Hora cancelada correctamente');
		return redirect()->back();
	}
}
