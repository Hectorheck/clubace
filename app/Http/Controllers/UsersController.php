<?php

namespace App\Http\Controllers;

use App\Models\Clubes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use View;
use Artisan;
use Str;
use Flash;
use Hash;
use App\Models\User;
use App\Models\TipoUsers;
use App\Models\UsersClubes;
use Laracasts\Flash\Flash as FlashFlash;

class UsersController extends Controller
{
	public function __construct ()
	{
		//
	}
	public function test ()
	{
		foreach (User::all() as $key => $user) {
			foreach ($user->clubes as $key => $userclub) {
				$userclub->tipo_usuarios_id = $user->tipo_usuarios_id;
				$userclub->update();
			}
		}
		// Función a ejecutar una vez para equiparar tipos de users con sus respectivos clubes
		return "listo";
	}
	public function index ()
	{
		$users = User::all();
		return view('sistema.users.index')
		->with('users',$users);
	}
	public function create ()
	{
		$tipos = TipoUsers::whereIn('id', [1,2,4,5,7])->get();
        $clubs = Clubes::all();
		return view('sistema.users.add_user')
		->with('tipos',$tipos)
        ->with('clubs',$clubs);
	}
	public function store (Request $request)
	{
		// dd($request->file('imagen'),$request->user());
		$val = $request->validate([
			'email' => 'required|unique:users|email',
			'nombres' => 'required',
			'rut' => 'required|unique:users',
			'tipo_usuarios_id' => 'required',
			'password' => 'required|confirmed',
			'apellido_paterno' => 'required',
			'apellido_materno' => 'required',
			'fecha_nacimiento' => 'required',
			'direccion' => 'required',
			'ciudad' => 'required',
			'imagen' => 'required|file|image|mimes:jpg,png,jpeg|max:2024KB',
		],[
			'email.required' => 'Debe ingresar el correo',
			'nombres.required' => 'Debe ingresar el nombre',
			'rut.required' => 'Debe ingresar el rut',
			'apellido_paterno.required' => 'Debe ingresar un apellido paterno',
			'apellido_materno.required' => 'Debe ingresar un apellido materno',
			'fecha_nacimiento.required' => 'Debe ingresar una fecha de nacimiento correspondiente',
			'direccion.required' => 'Debe ingresar una direccion',
			'ciudad.required' => 'Debe ingresar una ciudad',
			'rut.unique' => 'Rut ya esta en uso en el sistema',
			'password.required' => 'Debe ingresar la password',
			'tipo_usuarios_id.required' => 'Debe ingresar el tipo de usuario',
			'imagen.required' => 'Debe subir una imagen',
			'imagen.file' => 'Debe subir una imagen',
			'imagen.image' => 'El formato no es correcto',
			'imagen.mimes' => 'El formato no es correcto, formatos aceptados son: jpg,png,jpeg',
			'imagen.max' => 'El tamaño máximo de archivo es 2MB',
		]);
		if ($request->tipo_usuarios_id == 2 || $request->tipo_usuarios_id == 5) {
			$request->validate([
				'clubes_id' => 'required|array',
			],[
				'clubes_id.required' => 'Debe seleccionar al menos un club',
			]);
		}
		$val['password'] = bcrypt($request->password);
		$user = User::create($val);
		if (isset($request->imagen)) {
			$path = $request->file('imagen')->storeAs(
				'avatars', 'photo_perfil_'.$user->id.'.jpg', 'public'
			);
			$val['profile_photo_path'] = $path;
			$user->update($val);
		}
		if ($request->tipo_usuarios_id == 2 || $request->tipo_usuarios_id == 5) {
			$request->validate([
				'clubes_id' => 'required|array',
			],[
				'clubes_id.required' => 'Debe seleccionar al menos un club',
			]);
			foreach ($request->clubes_id as $key => $value) {
				UsersClubes::create([
					'clubes_id' => $value,
					'users_id' => $user->id,
					'estado' => 'ACEPTADO',
					'tipo_usuarios_id' => $user->tipo_usuarios_id,
				]);
			}
		}
		Flash::success('Nuevo usuario creado');
		return redirect()->route('users.index');
	}
	public function edit ($id)
	{
		$user = User::find($id);
		$tipos = TipoUsers::whereIn('id', [1,2,4,5])->get();
        $clubs = Clubes::all();
        $clubselects = UsersClubes::where('users_id', $id)->get();
		return view('sistema.users.view_user')
		->with('tipos',$tipos)
		->with('user',$user)
		->with('clubs',$clubs)
		->with('clubsselects',$clubselects);
	}
	public function update (Request $request, $id)
	{
		$user = User::find($id);
		$val = $request->validate([
			'nombres' => 'required',
			'email' => 'required|unique:users,email,'.$user->id,
			'apellido_paterno' => 'nullable',
			'apellido_materno' => 'nullable',
			'fecha_nacimiento' => 'required',
			'direccion' => 'nullable',
			'ciudad' => 'nullable',
			'imagen' => 'nullable|file|image|mimes:jpg,png,jpeg|max:2024KB',
		],[
			'nombre.required' => 'Debe ingresar el nombre',
			'email.required' => 'Debe ingresar el nombre',
			'fecha_nacimiento.required' => 'Debe ingresar fecha de nacimiento',
			'imagen.file' => 'Debe subir una imagen',
			'imagen.image' => 'El formato no es correcto',
			'imagen.mimes' => 'El formato no es correcto, formatos aceptados son: jpg,png,jpeg',
			'imagen.max' => 'El tamaño máximo de archivo es 2MB',
		]);
		if (isset($request->imagen)) {
			$path = $request->file('imagen')->storeAs(
				'avatars', 'photo_perfil_'.$user->id.'.jpg', 'public'
			);
			$val['profile_photo_path'] = $path;
		}

		if ($request->tipo_usuarios_id == 2 || $request->tipo_usuarios_id == 5) {

			$val['tipo_usuarios_id'] = $request->tipo_usuarios_id;
			$request->validate([
				'clubes_id' => 'required|array',
			],[
				'clubes_id.required' => 'Debe seleccionar al menos un club',
			]);

            $deleteesta = UsersClubes::where('users_id','=',$user->id)->delete();

			foreach ($request->clubes_id as $key => $value) {
				UsersClubes::Create([
					'clubes_id' => $value,
					'users_id' => $user->id,
					'estado' => 'ACEPTADO',
				],[
					'tipo_usuarios_id' => $request->tipo_usuarios_id,
				]);
			}
		}
		$user->update($val);
		Flash::success('Usuario actualizado');
		return redirect()->route('users.index');
	}
	public function delete ($id)
	{
		$user = User::find($id)->delete();
		Flash::success('Usuario eliminado del sistema');
		return redirect()->route('users.index');
	}
	public function eliminados ()
	{
		$users = User::onlyTrashed()->get();
		return view('sistema.users.index')
		->with('users',$users);
	}
	public function borrar ($id)
	{
		$user = User::withTrashed()->find($id);
		$user->forceDelete();
		Flash::success('Usuario eliminado completamente del sistema');
		return redirect()->route('users.index');
	}
	public function restaurar ($id)
	{
		$user = User::withTrashed()->find($id);
		$user->restore();
		Flash::success('Usuario restaurado al sistema');
		return redirect()->route('users.index');
	}
	public function updatePass (Request $request)
	{
		$val = $request->validate([
			'old_password' => 'required',
			'password' => 'required|confirmed|min:8',
		],[
			'old_password.required' => 'Debe ingresar su contraseña actual',
			'password.required' => 'Debe ingresar su nueva contraseña',
			'password.confirmed' => 'Debe confirmar su nueva contraseña',
			'password.min' => 'Su contraseña nueva debe tener minimo 8 caracteres',
		]);
		if (Hash::check($request->old_password, auth()->user()->password)) {
			// ACTUALIZAR PASS
			User::find(auth()->user()->id)->update([
				'password' => bcrypt($request->password),
			]);
			Flash::success('Contraseña actualizada');
			return redirect()->back();
		} else {
			Flash::error('La contraseña ingresada no coincide con su contraseña actual');
			return redirect()->back();
		}
	}
	/* ########## PERFIL USUARIO, VER ACTUALIZAR ########## */
	public function perfil ()
	{
		return view('sistema.users.edit_perfil');
	}
	public function updatePerfil (Request $request)
	{
		$val = $request->validate([
			'email' => 'required|email',
			'nombres' => 'required',
			'apellido_paterno' => 'nullable',
			'apellido_materno' => 'nullable',
			'direccion' => 'nullable',
			'ciudad' => 'nullable',
			'imagen' => 'nullable|file|image',
		],[
			'email.required' => 'Debe ingresar su correo',
			'nombres.required' => 'Debe ingresar su nombre',
		]);
		if (isset($request->imagen)) {
			$path = $request->file('imagen')->storeAs(
				'avatars', 'photo_perfil_'.$request->user()->id.'.jpg', 'public'
			);
			$val['profile_photo_path'] = $path;
		}
		$us = User::where('email', $request->email)->whereNotIn('id', [auth()->user()->id])->first();
		if (!is_null($us)) {
			Flash::error('Correo ya utilizado');
			return redirect()->back();
		}
		User::find(auth()->user()->id)->update($val);
		Flash::success('Datos actualizados');
		return redirect()->route('perfil');
	}
	public function getUsersPaginado ()
	{
		// USERS TIPO DOS O MAS
		$user = User::where('tipo_usuarios_id', '>', '2')->paginate(10);
		return $user;
	}
	public function verificado (User $user)
	{
		return view('sistema.socios.verificado')->with(['user' => $user]);
	}
}










