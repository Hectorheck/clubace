<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDevices;
use App\Models\UsersClubes;
use App\Models\User;
use App\Models\Notificaciones;
use App\Models\NotificacionesUsers;
use App\Models\Reservas;
use App\Models\Recintos;
use App\Models\Agenda;
use App\Models\Clubes;
use App\Models\Convenios;
use App\Models\UserConvenios;
use Flash;
use Illuminate\Support\Facades\Http;
use App\Traits\MultiClases;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
	use MultiClases;
	public function __construct()
	{
		/* ########## COPIADO DEL FIREBASE ########## */
		// <!-- The core Firebase JS SDK is always required and must be listed first -->
		// <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>

		// <!-- TODO: Add SDKs for Firebase products that you want to use
		// 	 https://firebase.google.com/docs/web/setup#available-libraries -->
		// <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-analytics.js"></script>

		// <script>
		//   // Your web app's Firebase configuration
		//   // For Firebase JS SDK v7.20.0 and later, measurementId is optional
		//   var firebaseConfig = {
		// 	apiKey: "AIzaSyCPW9OPomsK8tQCTP59_QV_RwONwen_bSc",
		// 	authDomain: "ace-test-81900.firebaseapp.com",
		// 	projectId: "ace-test-81900",
		// 	storageBucket: "ace-test-81900.appspot.com",
		// 	messagingSenderId: "728374216419",
		// 	appId: "1:728374216419:web:b3bab21f894826ae57a7d6",
		// 	measurementId: "G-YW4M5HE1Z1"
		//   };
		//   // Initialize Firebase
		//   firebase.initializeApp(firebaseConfig);
		//   firebase.analytics();
		// </script>
	}
	public function users ($id)
	{
		/* Funcion para identificar usuarios NOTIFICABLES segun id de notificacion. */
		$recintos = auth()->user()->getRecintos()->pluck('id')->toArray();
		$agenda = Agenda::whereIn('recintos_id', $recintos)->whereNotNull('reserva_id')->pluck('reserva_id')->toArray();
		$reservas = Reservas::whereIn('id', $agenda)->pluck('users_id')->toArray();
		$usuarios = User::whereIn('id', $reservas)->get();
		return $usuarios;
		// $data = self::usersGral($clubid);
		// return response()->json($data);
	}
	public function enviadas ($id)
	{

		$data = Notificaciones::find($id)->load(['users','users.user',]);
		return response()->json($data);
	}

    public function enviadasconvenio ($id)
	{

		$data = DB::select('SELECT a.id,a.titulo,b.razon_social FROM convenios a inner join clubes b on a.clubes_id=b.id;');
		return response()->json($data);
	}
	public function leidas ($id)
	{
		$data = Notificaciones::find($id)->load(['users' => function ($query) {
			$query->where('estado', 'leido');
		},'users.user',]);
		return response()->json($data);
	}
	public function index ()
	{
		$ides = auth()->user()->getClubes()->pluck('id')->toArray();
		$notificaciones = Notificaciones::whereIn('clubes_id', $ides)->orderBy('id', 'DESC')->get();
		return view('sistema.adminclub.notificaciones.index')->with([
			'notificaciones' => $notificaciones,
		]);
	}
	public function store (Request $request)
	{
		// mensaje - tipo - clubes_id
		$val = $request->validate([
			'titulo' => 'required',
			'mensaje' => 'required',
			'tipo' => 'required',
			'clubes_id' => 'required',
		],[
			'titulo.required' => 'Ingrese titulo',
			'mensaje.required' => 'Ingrese mensaje',
			'tipo.required' => 'Ingrese tipo',
			'clubes_id.required' => 'Seleccione los clubes con los que trabajará',
		]);
		foreach ($request->clubes_id as $key => $value) {
			$notificacion = Notificaciones::create([
				'clubes_id' => $value,
				'titulo' => $val['titulo'],
				'mensaje' => $val['mensaje'],
				'tipo' => $val['tipo'],
				'creada' => 'manual',
			]);
		}
		Flash::success('Notificacion creada exitosamente');
		return redirect()->route('notificaciones.index');
	}
	public function delete ($id)
	{
		$notificacion = Notificaciones::find($id);
		$lista = NotificacionesUsers::where('notificaciones_id', $id)->delete();
		$notificacion->delete();
		Flash::success('Notificacion eliminada');
		return redirect()->route('notificaciones.index');
	}
	public function send (Request $request, $id, $SERVER_API_KEY = null)
	{
		// notificaciones_id = $id
		// user_id - notificaciones_id - estado - leido - message_id - multicast_id - success - failure - canonical_ids
		// dd($request->user_id);
		$notificacion = Notificaciones::find($id);
		$devices = UserDevices::whereIn('user_id', $request->user_id)->pluck('fcm_token');
		// CHEQUEAR SI EL CLUB TIENE APP ACA Y MANDAR SEGUN CORRESPONDA
		$club = Clubes::find($notificacion->clubes_id)->load('api_info');
		if (!is_null($club->api_info) && $club->api_info->app == 1) {
			$SERVER_API_KEY = $club->api_info->fbase_api_key;
		} else {
			$SERVER_API_KEY = env('SERVER_API_KEY');
		}
		/* VALIDACIONES */
		if (is_null($SERVER_API_KEY)) {
			Flash::error('No tiene el token de firebase cargado');
			return redirect()->back();
		}
		if (count($devices) < 1) {
			Flash::error('No hay dispositivos registrados');
			return redirect()->back();
		}
		$data = [
			"registration_ids" => $devices,
			"notification" => [
				"title" => "$notificacion->titulo",
				"body" => $notificacion->mensaje,
				"content_available" => true,
				"priority" => "high",
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
		// dd($res);
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
		foreach ($request->user_id as $key => $value) {
			// $noti = new NotificacionesUsers;
			// $noti->notificaciones_id = $notificacion->id;
			// $noti->user_id = $value;
			// $noti->estado = 'enviado';
			// $noti->message_id = $res['results'][0]['message_id'];
			// $noti->multicast_id = $res["multicast_id"];
			// $noti->success = $res["success"];
			// $noti->failure = $res["failure"];
			// $noti->canonical_ids = $res["canonical_ids"];
			// dump($noti);
			$noti = NotificacionesUsers::create([
				'notificaciones_id' => $notificacion->id,
				'user_id' => $value,
				'estado' => 'enviado',
				'leido' => null,
				'message_id' => $message_id,
				'multicast_id' => $res["multicast_id"],
				'success' => $res["success"],
				'failure' => $res["failure"],
				'canonical_ids' => $res["canonical_ids"],
			]);
		}
		// dd($response, $res, 'Notificaciones enviadas');
		Flash::success('Notificaciones enviadas');
		return redirect()->route('notificaciones.index');
	}

    public function sendconvenio (Request $request, $id, $SERVER_API_KEY = null)
	{


		// notificaciones_id = $id
		// user_id - notificaciones_id - estado - leido - message_id - multicast_id - success - failure - canonical_ids
		// dd($request->user_id);
        $users = UserConvenios::whereIn('convenios_id',$request->convenio_id)->select('users_id')->get()->toArray();
        $users2 = [];
        for ($i=0; $i < count($users); $i++) {
            array_push($users2, $users[$i]['users_id']);
        }
        //dd($users2);
		$notificacion = Notificaciones::find($id);
		$devices = UserDevices::whereIn('user_id', $users2)->pluck('fcm_token');
		// CHEQUEAR SI EL CLUB TIENE APP ACA Y MANDAR SEGUN CORRESPONDA
		$club = Clubes::find($notificacion->clubes_id)->load('api_info');
		if (!is_null($club->api_info) && $club->api_info->app == 1) {
			$SERVER_API_KEY = $club->api_info->fbase_api_key;
		} else {
			$SERVER_API_KEY = env('SERVER_API_KEY');
		}
		/* VALIDACIONES */
		if (is_null($SERVER_API_KEY)) {
			Flash::error('No tiene el token de firebase cargado');
			return redirect()->back();
		}
		if (count($devices) < 1) {
			Flash::error('No hay dispositivos registrados');
			return redirect()->back();
		}
		$data = [
			"registration_ids" => $devices,
			"notification" => [
				"title" => "$notificacion->titulo",
				"body" => $notificacion->mensaje,
				"content_available" => true,
				"priority" => "high",
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
		// dd($res);
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
		foreach ($users2 as $key => $value) {
			// $noti = new NotificacionesUsers;
			// $noti->notificaciones_id = $notificacion->id;
			// $noti->user_id = $value;
			// $noti->estado = 'enviado';
			// $noti->message_id = $res['results'][0]['message_id'];
			// $noti->multicast_id = $res["multicast_id"];
			// $noti->success = $res["success"];
			// $noti->failure = $res["failure"];
			// $noti->canonical_ids = $res["canonical_ids"];
			// dump($noti);
			$noti = NotificacionesUsers::create([
				'notificaciones_id' => $notificacion->id,
				'user_id' => $value,
				'estado' => 'enviado',
				'leido' => null,
				'message_id' => $message_id,
				'multicast_id' => $res["multicast_id"],
				'success' => $res["success"],
				'failure' => $res["failure"],
				'canonical_ids' => $res["canonical_ids"],
			]);
		}
		// dd($response, $res, 'Notificaciones enviadas');
		Flash::success('Notificaciones enviadas');
		return redirect()->route('notificaciones.index');
	}
	public function test ()
	{
		/* ########## FUNCION PARA TEST MIGRACION A HTTP v1 ########## */
		$info = Clubes::whereHas('api_info')->first()->api_info;
		$firebaseToken = UserDevices::whereNotNull('fcm_token')->pluck('fcm_token')->all();
		$url = 'https://fcm.googleapis.com/v1/projects/myproject-b5ae1/messages:send';
		dd($info, $firebaseToken);
	}
	public function sendNotification()
	{
		// auth()->user()->update(['device_token'=>$request->token]);
		$firebaseToken = UserDevices::whereNotNull('fcm_token')->pluck('fcm_token')->all();

		$SERVER_API_KEY = 'AAAAqZZ8huM:APA91bF7HMXgq97raoQOPMcqlZY-tMZssp5Moo6YNi18lA5N9-ikJ8y8Vb9lUZPmIrWbJ08lv6ukMzoKgfbz-J7-_xRAliINSwMHokuMFR8SlBiqFA-DdP_Gjs2qGiW-DaWqFAyJGt1k';

		$data = [
			"registration_ids" => $firebaseToken,
			"notification" => [
				"title" => "Prueba de notificacion Leo ".date('H:i:s'),
				"body" => "Cuerpo de la notificacion",
				"content_available" => true,
				"priority" => "high",
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
		$res = json_decode($response);
		dd($dataString, $response, $res);
	}
}
