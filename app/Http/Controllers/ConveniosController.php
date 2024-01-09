<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Convenios;
use App\Models\UserConvenios;
use App\Models\RecintosConvenios;
use App\Models\User;
use App\Models\TipoUsers;
use App\Models\UsersClubes;
use App\Models\Clubes;
use Flash, Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class ConveniosController extends Controller
{
	// CREAR CONVENIOS, asociar usuarios.
	// eliminar un convenio, eliminar usuarios asiciados.
	// crear los precios y valores
	public function index ()
	{
		$usuarios = User::where('tipo_usuarios_id', '>', '2')->get();
		$convenios = Convenios::whereIn('clubes_id', auth()->user()->getClubes()->pluck('id'))->with('clubes')->get();
		return view('sistema.adminclub.convenios.index')
		->with(['convenios' => $convenios,'usuarios' => $usuarios,]);
	}
	public function store (Request $request)
	{
		// titulo	descripcion	clubes_id
		$val = $request->validate([
			'titulo' => 'required',
			'descripcion' => 'nullable',
			'clubes_id' => 'required|array',
		],[
			'titulo.required' => 'Ingrese el titulo/nombre del convenio',
			'clubes_id.required' => 'Debe seleccionar al menos un club',
			'clubes_id.required' => 'Debe seleccionar al menos un club',
		]);
		foreach ($val['clubes_id'] as $key => $value) {
			Convenios::create([
				'titulo' => $val['titulo'],
				'descripcion' => $val['descripcion'],
				'clubes_id' => $value,
			]);
		}
		Flash::success('Convenios creados exitosamente');
		return redirect()->route('convenios.index');
	}
	public function update (Request $request, $id)
	{
		$val = $request->validate([
			'titulo' => 'required',
			'descripcion' => 'nullable',
		],[
			'titulo.required' => 'Ingrese el titulo/nombre del convenio',
		]);
		$convenio = Convenios::find($id)->update($val);
		Flash::success('Convenio actualizado exitosamente');
		return redirect()->route('convenios.index');
	}
	public function delete ($id)
	{
		$convenio = Convenios::find($id)->delete();
		// BORRAR USUARIOS ASOCIADOS
		Flash::success('Convenio eliminado exitosamente');
		return redirect()->route('convenios.index');
	}
	public function addUsers (Request $request, $id)
	{
		$val = $request->validate([
			'usuarios' => 'required|array',
		],[
			'usuarios.required' => 'Seleccione al menos un usuario',
			'usuarios.array' => 'Seleccione al menos un usuario',
		]);
		// convenios_id users_id
		$convenio = Convenios::find($id);
		$club = Clubes::find($convenio->clubes_id);
		$convenios = Convenios::where('clubes_id', $convenio->clubes_id)->select('id')->get()->toArray();
		foreach ($val['usuarios'] as $key => $value) {
			$check = UserConvenios::whereIn('convenios_id', $convenios)->where('users_id', $value)->get();
			// if (count($check) > 1) {
			// 	// NO HACEMOS NADA, NO SE PUEDE REGISTRAR NI NOTIFICAR POR ACA.
			// 	// dd($check,'1');
			// } elseif (count($check) == 1) {
			// 	// SE REEMPLAZA/ACTUALIZA
			// 	foreach ($check as $key => $val) {
			// 		$val->convenios_id = $id;
			// 		$val->update();
			// 	}
			// 	// dd($check,'2');
			// } elseif (count($check) == 0) {
			// 	// dd($check, '3');
			// 	// SE CREA
			// 	UserConvenios::firstOrCreate([
			// 		'convenios_id' => $id,
			// 		'users_id' => $value,
			// 	]);
			// }
			// VALIDACION ANTIGUA ELIMINADA ACA, AHORA PUEDE TENER MAS DE UN CONVENIO DENTRO DEL MISMO CLUB.
			UserConvenios::firstOrCreate([
				'convenios_id' => $id,
				'users_id' => $value,
			]);
		}
		Flash::success('Usuarios añadidos a convenio exitosamente');
		return redirect()->route('convenios.index');
	}
	public function addUsersCsv (Request $request)
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
		fgetcsv($dir);
		while ($value = fgetcsv($dir, 3000, ";")) {
			$email = utf8_encode($value[1]);
			if (is_null($email) || $email == "") {
				$email = "sin-mail@aceclub.cl";
			}
			$user = User::whereEmail($email)->first();
			if (is_null($user)) {
				$user = User::create([
					'nombres' => utf8_encode($value[0]),
					'email' => $email,
					'rut' => utf8_encode($value[2]),
					'password' => Hash::make(utf8_encode($value[2])),
					'tipo_usuarios_id' => 4
				]);
			}
			UserConvenios::firstOrCreate([
				'convenios_id' => $request->_conv,
				'users_id' => $user->id,
			]);
		}
		fclose($dir);

		return response()->json(['status' => 'success'], 200);
	}

	public function infoUsers($id, $str = null)
	{
		// $users2 = DB::select('SELECT a.id,b.nombres,b.apellido_paterno,b.apellido_materno FROM user_convenios a inner join users b on b.id=a.users_id WHERE a.convenios_id='.$id.'');

		// $users = DB::table('user_convenios')
		// ->join('users', 'users.id', '=', 'user_convenios.users_id')
		// ->select('user_convenios.id', 'users.nombres', 'users.apellido_paterno', 'users.apellido_materno')->where('user_convenios.convenios_id', '=', $id);
		if (is_null($str)) {
			$users = UserConvenios::where('convenios_id', $id)->with('users')->paginate(10);
		} else {
			$users = UserConvenios::where('convenios_id', $id)
				->whereHas('users', function ($query) use ($str) {
					$query->where('nombres', 'like', '%'.$str.'%')
						->orWhere('email', 'like', '%'.$str.'%');
				})->with('users')
				->paginate(10);
		}
		return response()->json($users);
	}
	public function get ($id)
	{
		$convenios = Convenios::find($id);
		return response()->json($convenios, 200);
	}

	public function deleteUsers ($id)
	{
		$conv = UserConvenios::find($id);
		if (!is_null($conv)) {
			$conv->delete();
		}
		Flash::success('Usuarios eliminado del convenio exitosamente');
		return redirect()->route('convenios.index');
	}
	/* ########## RecintosConvenios ########## */
	// CRUD para crear los precios asociados a los convenios, hecho aca
	public function saveRecintoConvenio (Request $request, $id)
	{
		// recintos_id	convenios_id	valor	porcentaje
		$val = $request->validate([
			'porcentaje' => 'required|array',
			"porcentaje.*"  => "required|min:0",
		],[
			'porcentaje.required' => 'Debe ingresar al menos un porcentaje',
			'porcentaje.array' => 'Debe ingresar al menos un porcentaje',
			'porcentaje.*.min' => ['min' => 'Debe ingresar al menos un porcentaje'],
		]);
		// dd($val['valor']);
		foreach ($val['porcentaje'] as $key => $value) {
			RecintosConvenios::updateOrCreate([
				'recintos_id' => $id,
				'convenios_id' => $key,
			],[
				'porcentaje' => $value,
			]);
		}
		Flash::success('Valores registrados correctamente');
		return redirect()->back();
	}
	public function getConvenios ($id, $recinto)
	{
		// UserConvenios RecintosConvenios
		$userconv = UserConvenios::where('users_id', $id)->get();
		$recinconv = RecintosConvenios::where('recintos_id', $recinto)->get();
		// dd($recinconv,$userconv->pluck('convenios_id'));
		$recinconv = RecintosConvenios::where('recintos_id', $recinto)
			->whereIn('convenios_id', $userconv->pluck('convenios_id'))
			->with(['recintos','convenios',])
			->get();
		return $recinconv;
	}
}










