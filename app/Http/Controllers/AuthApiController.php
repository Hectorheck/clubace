<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Clubes;
use App\Models\UserConvenios;
use App\Models\Convenios;
use App\Models\UserDevices;
use App\Models\UsersTerminos;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Actions\Jetstream\DeleteUser;
use Exception;
use DB;

use App\Notifications\WelcomeEmailNotification;

use App\Traits\AppCheck;

class AuthApiController extends Controller
{
	use AppCheck;
	public function __construct ()
	{
		// 
	}
	public function register (Request $request)
	{
		$var = self::checkApp($request);
		$termn = self::checkTerminos($var);
		if (!$termn) {
			return response()->json(['error' => 'No existen terminos y condiciones'], 500);
		}
		$fields = $request->validate([
			'nombres' => 'required|string',
			'email' => 'required|string|unique:users,email',
			'password' => 'required|string|confirmed',
			'terminos' => 'required',
		],[
			'nombres.required' => 'Debe indicar su nombre',
			'email.required' => 'Debe indicar su correo electronico',
			'password.required' => 'Debe indicar su contraseña',
			'password.confirmed' => 'Debe confirmar su contraseña',
			'terminos.required' => 'Debe aceptar los terminos y condiciones para utilizar la app',
		]);
		DB::beginTransaction();
		$user = User::create([
			'nombres' => $fields['nombres'],
			'email' => $fields['email'],
			'password' => bcrypt($fields['password']),
			'tipo_usuarios_id' => 4,
			'estado_cuenta' => 1,
		]);
		// $request->user()->sendEmailVerificationNotification();
		// $user->sendEmailVerificationNotification();
		$user->sendApiEmailVerificationNotification();
		$user->notify(new WelcomeEmailNotification());
		UsersTerminos::create([
			'fecha_actualizacion' => date('Y-m-d H:i:s'),
			'fecha' => date('Y-m-d'),
			'hora' => date('H:i:s'),
			'terminos_y_condiciones_id' => $termn->id,
			'users_id' => $user->id,
			'clubes_id' => $termn->clubes_id,
		]);
		DB::commit();
		// 'terminos' => $fields['terminos'],
		$token = $user->createToken('myapptoken')->plainTextToken;
		$response = [
			'user' => $user,
			'token' => $token
		];
		return response($response, 201);
	}

	public function login(Request $request)
	{
		// terminos 25
		// terminos 31 text
		// $this->checkTerminos($request->email); terminos (1 o 0) fecha_termino (26 -5 -2022)
		$var = self::checkApp($request);
		$termn = self::checkTerminos($var);
		if (!$termn) {
			return response()->json(['error' => 'No existen terminos y condiciones'], 500);
		}
		$fields = $request->validate([
			'email' => 'required|string',
			'password' => 'required|string'
		], [
			'email.required' => 'Debe ingresar su correo',
			'password.required' => 'Debe ingresar su password',
		]);
		// Check email
		$user = User::where('email', $fields['email'])->first();
		if(!$user || !Hash::check($fields['password'], $user->password)) {
			return response([
				'message' => 'Credenciales no coindicen con nuestros registros'
			], 401);
		}
		/* ########## CHEQUEAR TERMINOS ACEPTADOS Y RETORNAR DATOS ########## */
		$aceptado = UsersTerminos::where(['terminos_y_condiciones_id' => $termn->id, 'users_id' => $user->id,])->first();
		// if (is_null($aceptado)) {
		// 	return response(['message' => 'Debe aceptar los terminos y condiciones para iniciar sesión'], 401);
		// }
		if ($var) {
			// si viene token de club, ver si doy acceso o no, solo si es app privada
			if ($var->api_info->compartido == 0) {
				// SOLO ACCESO SI PERTENECE A CONVENIO
				$convenios = Convenios::where('clubes_id', $var->id)->get()->pluck('id')->toArray();
				$registros = UserConvenios::whereIn('convenios_id', $convenios)
					->where('users_id', $user->id)
					->count();
				if ($registros == 0) {
					return response([
						'message' => 'No tiene acceso a la app'
					], 401);
				}
			}
		}
		$token = $user->createToken('myapptoken')->plainTextToken;
		$user->terminos = is_null($aceptado) ? false : true;
		$response = [
			'user' => $user,
			'token' => $token,
			'respuesta' => 'OK',
		];
		return response($response, 201);
	}
	public function device (Request $request)
	{
		$fields = $request->validate([
			'os' => 'required|string',
			'device' => 'required|string',
			'fcm_token' => 'required|string',
		], [
			'os.required' => 'Debe enviar los datos del servicio operativo',
			'device.required' => 'Debe ingresar el nombre del dispositivo',
			'fcm_token.required' => 'Debe ingresar el token FCM',
		]);
		$user = auth()->user();
		$device = UserDevices::updateOrCreate([
			'user_id' => $user->id,
			'os' => $fields['os'],
			'device' => $fields['device'],
			'fcm_token' => $fields['fcm_token'],
		],[
			'last_activity' => date('Y-m-d H:i:s'),
		]);
		return response([
				'message' => 'Dispositivo guardado exitosamente'
			], 401);
	}
	public function update (Request $request)
	{
		$var = self::checkApp($request);
		$termn = self::checkTerminos($var);
		if (!$termn) {
			return response()->json(['error' => 'No existen terminos y condiciones'], 500);
		}
		$user = User::find(auth()->user()->id);
		/* $user = User::where(['id' => auth()->user()->id, 'deleted_at' => null])->first(); */
		$val = $request->validate([
			'rut' => 'required|unique:users,rut,'.$user->id,
			'nombres' => 'required|string',
			'email' => 'required|unique:users,email,'.$user->id,
			'apellido_paterno' => 'nullable',
			'apellido_materno' => 'nullable',
			'direccion' => 'nullable',
			'ciudad' => 'nullable',
			'comunas_id' => 'nullable',
			'regiones_id' => 'nullable',
			'image' => 'nullable',
			'fecha_nacimiento' => 'required|date|before:-18 years',
		],[
			'rut.required' => 'Debe indicar su rut',
			'rut.unique' => 'Rut ya está registrado',
			'nombres.required' => 'Debe indicar su nombre',
			'email.required' => 'Debe indicar su correo electronico',
		]);
		$aceptado = UsersTerminos::where(['terminos_y_condiciones_id' => $termn->id, 'users_id' => $user->id,])->first();
		$user->rut = $request->rut;
		$user->nombres = $request->nombres;
		$user->email = $request->email;
		$user->apellido_paterno = $request->apellido_paterno;
		$user->apellido_materno = $request->apellido_materno;
		$user->direccion = $request->direccion;
		$user->ciudad = $request->ciudad;
		$user->fecha_nacimiento = $val['fecha_nacimiento'];
		if (isset($request->image)) {
			$path = $request->file('image')->storeAs(
				'avatars', 'photo_perfil_'.$user->id.'.jpg', 'public'
			);
			$val['profile_photo_path'] = $path;
			$user->profile_photo_path = $val['profile_photo_path'];
			$user->save();
			$user = User::find(auth()->user()->id);
			$user->terminos = is_null($aceptado) ? false : true;
			return [
				'user' => $user->makeHidden(['deleted_at','created_at','updated_at','comunas_id','regiones_id','fecha_nacimiento','rol_admin_general','rol_admin_club','rol_socio_club','estado_cuenta','motivo_suspencion','email_verified_at','profile_photo_path',]),
				'message' => 'Datos actualizados correctamente',
				'photo' => $val['profile_photo_path']
			];
		}else{
			$user->save();
			$user = User::find(auth()->user()->id);
			$user->terminos = is_null($aceptado) ? false : true;
			return [
				'user' => $user->makeHidden(['deleted_at','created_at','updated_at','comunas_id','regiones_id','rol_admin_general','rol_admin_club','rol_socio_club','estado_cuenta','motivo_suspencion','email_verified_at','profile_photo_path',]),
				'message' => 'Datos actualizados correctamente',
			];
		}
	}
	public function aceptarTerminos (Request $request)
	{
		$var = self::checkApp($request);
		$termn = self::checkTerminos($var);
		if (!$termn) {
			return response()->json(['error' => 'No existen terminos y condiciones'], 500);
		}
		$val = $request->validate([
			'terminos' => 'required',
		]);
		$user = auth()->user()->id;
		// $user->terminos = $val['terminos'];
		// $user->fecha_termino = date('Y-m-d H:i:s');
		// $user->update();
		UsersTerminos::create([
			'fecha_actualizacion' => date('Y-m-d H:i:s'),
			'fecha' => date('Y-m-d'),
			'hora' => date('H:i:s'),
			'terminos_y_condiciones_id' => $termn->id,
			'users_id' => $user,
			'clubes_id' => $termn->clubes_id,
		]);

		return ['user' => $user,'message' => 'Datos actualizados correctamente',];
	}

	public function selfDelete (Request $request)
	{
		$val = $request->validate([
			'password' => 'required',
		],[
			'password.required' => 'Debe ingresar su contraseña',
		]);
		if (Hash::check($request->password, auth()->user()->password)) {
			/* ########## SE PUEDE ELIMINAR EL USER ########## */
			$data = new DeleteUser;
			$data->delete($request->user());
			return response()->json(['message' => 'Cuenta eliminada'], 200);
		} else {
			throw new Exception("Contraseña no coincide con nuestros registros", 1);
		}
	}

	public function logout(Request $request)
	{
		auth()->user()->tokens()->delete();
		return [
			'message' => 'Sesión cerrada con exito.'
		];
	}
}
