<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Models\Clubes;
use App\Models\Servicios;
use App\Models\Regiones;
use App\Models\Comunas;
use App\Models\TipoUsers;
use App\Models\UsersClubes;
use App\Models\Agenda;
use App\Models\Recintos;
use App\Models\Reservas;
use App\Models\User;
use App\Models\Convenios;
use App\Models\UserConvenios;

use DateTime, Flash, Auth, Validator;

use App\Traits\MultiClases;

class SociosController extends Controller
{
	use MultiClases;
	public function __construct ()
	{
		//
	}
	/* ########## ADMIN ########## */
	public function index ()
	{
		// PARA ADMIN DE CLUBES, VER SUS SOCIOS
		$clubid = auth()->user()->getClubes()->pluck('id');
		$recintos = auth()->user()->getRecintos()->pluck('id')->toArray();
		$agenda = Agenda::whereIn('recintos_id', $recintos)->whereNotNull('reserva_id')->pluck('reserva_id')->toArray();
		$reservas = Reservas::whereIn('id', $agenda)->pluck('users_id')->toArray();
		$usuarios = User::whereIn('id', $reservas)->get();
		$convenios = Convenios::whereIn('clubes_id', $clubid)->select('id')->get()->toArray();
		$users_conv = UserConvenios::where('convenios_id', $convenios)->get();
		$trainers = UsersClubes::where('tipo_usuarios_id', 5)->select('users_id')->get();
		$entrenadores = User::whereIn('id', $trainers)->get();
		$tipos = TipoUsers::whereIn('id', [2,4,5,7])->get();
		return view('sistema.adminclub.socios.index')
		->with(['usuarios' => $usuarios,'users_conv' => $users_conv,'entrenadores' => $entrenadores, 'tipos' => $tipos]);
	}
	public function upgrade (Request $request, $id)
	{
		$request->validate([
			'clubes_id' => 'required|array',
		],[
			'clubes_id.required' => 'Debe seleccionar club/es',
			'clubes_id.array' => 'Debe seleccionar club/es',
		]);
		$user = User::find($id);
		foreach ($request->clubes_id as $key => $value) {
			$registro = UsersClubes::firstOrCreate([
				'users_id' => $id,
				'estado' => 'ACEPTADO',
				'tipo_usuarios_id' => 5,
				'clubes_id' => $value,
			]);
		}
		Flash::success('Usuario actualizado');
		return redirect()->route('socios.index');
	}
	public function aceptar ($id)
	{
		$user = UsersClubes::find($id);
		if (is_null($user)) {
			Flash::warning('Lo sentimos, no encontramos la solicitud, el usuario ya es socio de otro club');
			return redirect()->back();
		}
		/* ########## VALIDAR SI YA A SIDO ACEPTADO EN OTRAS ########## */
		$check = UsersClubes::where('users_id', $user->users_id)
			->where('estado', 'ACEPTADO')
			->where('tipo_usuarios_id', 3)
			->get();
		if (count($check) > 0) {
			Flash::warning('Lo sentimos, el usuario ya es socio de otro club');
			return redirect()->back();
		}
		/* ########## VALIDAR SI YA A SIDO ACEPTADO EN OTRAS ########## */
		$user->estado="ACEPTADO";
		$user->tipo_usuarios_id = 3;
		$user->update();
		/* ########## SI ES ACEPTADO; BORRAR TODAS LAS DEMAS SOLICITUDES ########## */
		$check = UsersClubes::where('users_id', $user->users_id)
			// ->whereNotIn('id', [$id])
			->where('estado', 'PENDIENTE')
			->delete();
		/* ########## SI ES ACEPTADO; BORRAR TODAS LAS DEMAS SOLICITUDES ########## */
		User::find($user->users_id)->update(['tipo_usuarios_id' => 3,]);
		Flash::success('Estado cambiado exitosamente');
		return redirect()->back();
	}
	public function rechazar ($id)
	{
		$user = UsersClubes::find($id);
		$user->estado="RECHAZADO";
		$user->update();
		Flash::success('Estado cambiado exitosamente');
		return redirect()->back();
	}
	public function create (Request $request)
	{
		$clubid = auth()->user()->getClubes()->pluck('id');
		//dd($request);
		$val = $request->validate([
			'email' => 'required|email|unique:users',
			'rut' => 'required|unique:users',
			'nombres' => 'required',
			'apellido_paterno' => 'nullable',
			'apellido_materno' => 'nullable',
			'tipo_usuarios_id' => 'required',
			'ciudad' => 'nullable',
			'direccion' => 'nullable',
			'telefono' => 'nullable',
			'fecha_nacimiento' => 'nullable',
			'password' => 'required|confirmed|min:8',
		],[
			'email.required' => 'Ingrese un email valido',
			'email.unique' => 'Email ya esta en uso por otro usuario',
			'rut.required' => 'Ingrese un rut',
			'rut.unique' => 'Ingrese un rut unico de usuario (el ingresado ya esta registrado en el sistema)',
			'nombres.required' => 'Ingrese un nombre',
			'password.required' => 'Debe ingresar una contraseña',
			'tipo_usuarios_id.required' => 'Debe seleccionar tipo de usuario',
			'password.min' => 'Debe ingresar una contraseña valida (mínimo 8 caracteres)',
			'password.confirmed' => 'Debe confirmar su contraseña',
		]);
		$val['password'] = bcrypt($val['password']);
		$user = User::create($val);

		if ($request->tipo_usuarios_id == 2 || $request->tipo_usuarios_id == 5 || $request->tipo_usuarios_id == 7) {
			foreach ($clubid as $key => $value) {
				UsersClubes::create([
					'clubes_id' => $value,
					'users_id' => $user->id,
					'estado' => 'ACEPTADO',
					'tipo_usuarios_id' => $request->tipo_usuarios_id,
				]);
			}
		}
		Flash::success('Usuario añadido al sistema');
		return redirect()->back();
	}
	/* ########## ADMIN ########## */
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
		Flash::success('Membresía solicitada');
		return redirect()->back();
	}

	public function csv(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'csv' => 'required|file|mimes:csv,txt',
		],[
			'csv.required' => 'Debe subir un archivo',
			'csv.file' => 'Debe subir un archivo válido',
			'csv.mimes' => 'El formato no es el adecuado',
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()], 400);
		}

		$archivo = $request->file('csv');

		$dir = fopen($archivo, "r");
		$filas = [];
		fgetcsv($dir);
		while ($value = fgetcsv($dir, 3000, ";")) {
			$email = utf8_encode($value[1]);
			if (!$email || $email == "") {
				$email = "sin-mail@aceclub.cl";
			}
			$user = User::firstOrCreate([
				'email' => $email
			],[
				'nombres' => utf8_encode($value[0]),
				'rut' => utf8_encode($value[2]),
				'password' => Hash::make(utf8_encode($value[2])),
				'tipo_usuarios_id' => $request->tipo_usuario == "Entrenador" ? 5 : 4
			]);
			if ($request->tipo_usuario == "Entrenador") {
				$user->update(['tipo_usuarios_id' => 5]);
			}

			if (!is_null($request->clubes_id) && $request->tipo_usuario == "Entrenador") {
				foreach ($request->clubes_id as $key => $value) {
					UsersClubes::firstOrCreate([
						'users_id' => $user->id,
						'estado' => 'ACEPTADO',
						'tipo_usuarios_id' => 5,
						'clubes_id' => $value,
					]);
				}
			}
		}
		fclose($dir);
		return response()->json(['status' => 'success'], 200);
	}
}
