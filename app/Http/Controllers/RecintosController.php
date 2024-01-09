<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Recintos;
use App\Models\Servicios;
use App\Models\Agenda;
use App\Models\Reservas;
use App\Models\TipoUsers;
use App\Models\User;
use App\Models\UserClubes;
use App\Models\Clubes;
use App\Models\Transaction;
use App\Models\Galerias;
use App\Models\RecintosPrecios;
use App\Models\RecintosConvenios;
use DateTime;
use Flash;
use File;
use Validator;
use Storage;

use App\Traits\MultiClases;

class RecintosController extends Controller
{
	use MultiClases;
	public function test ()
	{
		$recinto = Recintos::find(18);
		$agendas = Agenda::where('recintos_id', 18)->where('fecha', '2022-05-18')->get();
		foreach ($agendas as $key => $agenda) {
			$var = [$agenda->valor_hora, $agenda->hora_inicio_bloque];
			dump($var);
		}
		// dd($agendas);
	}
	public function index($servicio)
	{
		return view('sistema.recintos.index')->with([
			'recintos' => Recintos::whereServiciosId($servicio)->latest()->get(),
			'servicio' => Servicios::find($servicio)
		]);
	}
	public function todos ()
	{
		/* ##### VISTA PARA VER TODOS LOS RECINTOS, PARA ADMIN DE CLUB SOLAMENTE ##### */
		if (auth()->user()->tipo_usuarios_id == 1) {
			$recintos = Recintos::all();
			return view('sistema.recintos.todos')
			->with(['club' => auth()->user()->getClubes(), 'recintos' => $recintos, 'servicios' => auth()->user()->getServicios(),]);
		}
		$clubid = !is_null(auth()->user()->clubes) ? auth()->user()->clubes->first()->clubes_id : 0;
		$club = Clubes::find($clubid);
		(!is_null($club)) ? $recintos = Recintos::where('clubes_id', $club->id)->get() : $recintos = null;
		(!is_null($club)) ? $servicios = Servicios::where('clubes_id', $club->id)->get() : $servicios = null;
		return view('sistema.recintos.todos')
		->with(['club' => $club, 'recintos' => auth()->user()->getRecintos(), 'servicios' => $servicios,]);
	}

	public function getData ($id)
	{
		$agenda = Agenda::find(base64_decode($id));
		if (!is_null($agenda->reserva_id)) {
			$reserva = Reservas::find($agenda->reserva_id)->load('users');
		} else {
			$reserva = null;
		}
		return response()->json(['agenda' => $agenda,'reserva' => $reserva,]);
	}

	public function store(Request $post, $servicio)
	{
		$post->validate([
			'codigo' => 'required',
			'nombre' => 'required',
			'valor' => 'required',
			'observaciones_publicas' => 'required',
			'observaciones_privadas' => 'required',
			'agno_construccion' => 'required',
			'bloque_horario' => 'required',
			'hora_inicio' => 'required',
			'hora_fin' => 'required',
		],[
			'codigo.required' => 'Debe ingresar el codigo',
			'nombre.required' => 'Debe ingresar el nombre',
			'valor.required' => 'Debe ingresar el tipo',
			'observaciones_publicas.required' => 'Debe ingresar las observaciones publicas',
			'observaciones_privadas.required' => 'Debe ingresar las observaciones privadas',
			'agno_construccion.required' => 'Debe ingresar el año de construccion',
			'bloque_horario.required' => 'Debe seleccionar el bloque horario',
			'hora_inicio.required' => 'Debe ingresar la hora de apertura',
			'hora_fin.required' => 'Debe ingresar la hora de cierre',
		]);

		set_time_limit(0);
		$serv = Servicios::find($servicio);
		$recinto = Recintos::create([
			'clubes_id' => $serv->clubes_id,
			'servicios_id' => $servicio,
			'nombre' => $post->nombre,
			'tipo' => $post->valor,
			'codigo' => $post->codigo,
			'agno_construccion' => $post->agno_construccion,
			'observaciones_publicas' => $post->observaciones_publicas,
			'observaciones_privadas' => $post->observaciones_privadas,
			'socios' => $post->socios ? 1 : 0,
			'arriendo' => $post->arriendo ? 1 : 0,
			'bloque_horario' => $post->bloque_horario,
			'hora_inicio' => $post->hora_inicio,
			'hora_fin' => $post->hora_fin,
			'dias_atencion' => implode(',', $post->dias),
		]);

		$primero = new DateTime();
		$primero->modify('first day of this month');
		$ultimo = new DateTime();
		/* $ultimo->modify('last day of next month'); */
		$ultimo->modify('+ 6 months');

		$dias = explode(',', $recinto->dias_atencion);
		$days = $this->dias_semana($dias);

		$inicio = date_create($primero->format('Y-m-d').' '.$recinto->hora_inicio);
		$final = date_create($ultimo->format('Y-m-d').' '.$recinto->hora_fin);

		/* $inicio = date_create(date('Y-m').'-'.$primero->format('d').' '.$recinto->hora_inicio);
		$final = date_create(date('Y-m').'-'.$ultimo->format('d').' '.$recinto->hora_fin); */

		while ($inicio < $final) {
			$agenda = null;
			if ($inicio->format('H:i:s') >= $recinto->hora_inicio && $inicio->format('H:i:s') < $recinto->hora_fin && in_array($inicio->format('l'), $days)) {
				$data = [
					'agno' => $inicio->format('Y'),
					'mes' => $inicio->format('m'),
					'dia' => $inicio->format('d'),
					'fecha' => $inicio->format('Y-m-d'),
					'hora_inicio_bloque' => $inicio->format('H:i:s'),
					'estado' => 'Disponible',
					'recintos_id' => $recinto->id
				];
				$agenda = Agenda::create($data);
			}
			$inicio->modify($recinto->bloque_horario);

			if (!is_null($agenda)) {
				Agenda::find($agenda->id)->update(['hora_fin_bloque' => $inicio->format('H:i:s')]);
			}
		}

		return redirect()->route('recintos.index', $servicio);
	}

	public function edit($servicio, $id)
	{
		return view('sistema.recintos.edit')->with([
			'recinto' => Recintos::find($id),
			'servicio' => Servicios::find($servicio),
		]);
	}

	public function update(Request $post, $servicio, $id)
	{
		// AL EDITAR, CREAR HORARIOS NUEVAMENTE
		$recinto = Recintos::find($id);

		if ($recinto->codigo != $post->codigo) {
			$post->validate([
				'codigo' => 'required|unique:recintos',
			],[
				'codigo.required' => 'Debe ingresar el codigo',
				'codigo.unique' => 'El codigo ingresado ya se ha registrado',
			]);
		}
		$post->validate([
		//	'codigo' => 'required|unique:recintos',
			'codigo' => 'required',
			'nombre' => 'required',
			'valor' => 'required',
			'obser_publicas' => 'required',
			'obser_privadas' => 'required',
			'year' => 'required',
			'bloque_horario' => 'required',
			'hora_inicio' => 'required',
			'hora_fin' => 'required',
		],[
			'codigo.required' => 'Debe ingresar el codigo',
			'codigo.unique' => 'El codigo ingresado ya se ha registrado',
			'nombre.required' => 'Debe ingresar el nombre',
			'valor.required' => 'Debe ingresar el valor',
			'obser_publicas.required' => 'Debe ingresar las observaciones publicas',
			'obser_privadas.required' => 'Debe ingresar las observaciones privadas',
			'year.required' => 'Debe ingresar el año de construccion',
			'bloque_horario.required' => 'Debe seleccionar el bloque horario',
			'hora_inicio.required' => 'Debe ingresar la hora de apertura',
			'hora_fin.required' => 'Debe ingresar la hora de cierre',
		]);

		$recinto->update([
			'nombre' => $post->nombre,
			'tipo' => $post->valor,
			'codigo' => $post->codigo,
			'agno_construccion' => $post->year,
			'observaciones_publicas' => $post->obser_publicas,
			'observaciones_privadas' => $post->obser_privadas,
			'socios' => $post->socios ? 1 : 0,
			'arriendo' => $post->arriendo ? 1 : 0,
			'bloque_horario' => $post->bloque_horario,
			'hora_inicio' => $post->hora_inicio,
			'hora_fin' => $post->hora_fin,
		]);

		return redirect()->route('recintos.index', $servicio);
	}

	public function destroy($servicio, $id)
	{
		Recintos::find($id)->delete();
		Agenda::whereRecintosId($id)->delete();
		/* ########## ELIMINAR IMAGENES ########## */
		return redirect()->route('recintos.index', $servicio);
	}

	/* ########## SOFTDELETES ########## */
	public function eliminados ()
	{
		$users = Recintos::onlyTrashed()->get();
		// dd('En desarrollo');
		return view('sistema.recintos.borrados')
		->with('recintos',$users);
	}
	public function borrar ($id)
	{
		$user = Recintos::withTrashed()->find($id);
		$user->forceDelete();
		Flash::success('Recintos eliminado completamente del sistema');
		return redirect()->route('recintos.todos');
	}
	public function restaurar ($id)
	{
		$user = Recintos::withTrashed()->find($id);
		$user->restore();
		Agenda::whereRecintosId($id)->onlyTrashed()->restore();
		Flash::success('Recintos restaurado al sistema');
		return redirect()->route('papelera.recintos.eliminados');
	}
	/* ########## SOFTDELETES ########## */

	public function transacciones($servicio, $id)
	{
		$recinto = Recintos::find($id);
		$servicio = Servicios::find($servicio);
		$transacciones = Agenda::with('transaction')
			->where('recintos_id', $recinto->id)
			->whereNotNull('reserva_id')
			->orderBy('id', 'desc')
			->get();
		// dd($transacciones, $transacciones->count());
		return view('sistema.recintos.transacciones')->with([
			'recinto' => $recinto,
			'servicio' => $servicio,
			'transacciones' => $transacciones
		]);
	}

	public function anularPorPagar(Request $request)
	{
		$req = $request->except('_token');
		$agenda = Agenda::find($req["buy_order"]);
		$reserva = Reservas::find($agenda->reserva_id);
		$reserva->delete();
		$transaction = Transaction::where('agenda_id', $agenda->id)->delete();
		$agenda->estado = "Disponible";
		$agenda->reserva_id = null;
		$agenda->update();
		Flash::success('Bloque Liberado con Éxito');
		return redirect()->route('recintos.todos');

	}

	public function horarios($id)
	{
		return view('sistema.recintos.horarios')->with([
			'recinto' => Recintos::find($id),
			'dias' => Agenda::whereRecintosId($id)->where('mes', date('m'))->where('agno', date('Y'))->groupBy('fecha')->get()
		]);
	}

	public function horariosStatus($id)
	{
		// ANTIGUO, AHORA ABAJO CON PUT
		$agenda = Agenda::find(base64_decode($id));
		$agenda->update(['estado' => $agenda->estado == "Disponible" ? 'Bloqueado' : 'Disponible']);
		return response()->json('success');
	}
	public function status (Request $request, $id)
	{
		$agenda = Agenda::find(base64_decode($id));
		$agenda->update([
			'estado' => $agenda->estado == "Disponible" ? 'Bloqueado' : 'Disponible',
			'comentario' => $request->comentario ?? null,
		]);
		return redirect()->back();
	}
	// public function
	public function blockDay (Request $request, $id)
	{
		/* ########## FUNCION PARA BLOQUEAR UN DIA ENTERO ########## */
		$request->validate([
			'dia' => 'required',
			'agno' => 'required',
			'mes' => 'required',
			'comentario' => 'required|max:30',
		],[
			'dia.required' => 'Debe seleccionar el día',
			'agno.required' => 'Debe seleccionar el día',
			'mes.required' => 'Debe seleccionar el día',
			'comentario.required' => 'Debe ingresar un comentario/motivo',
			'comentario.max' => 'no puede tener mas de 30  caracteres',
		]);
		/* ########## DETALLE ########## */
		// AÑADIR COMENTARIO con detalle, max 25 caracteres y que se vean en agenda general
		/* ########## DETALLE ########## */
		$agenda = Agenda::where(['dia' => $request->dia,'agno' => $request->agno,'mes' => $request->mes,'recintos_id' => $id,])->update(['estado' => 'Bloqueado','comentario' => $request->comentario,]);
		Flash::success('Dia bloqueado exitosamente');
		return redirect()->back();
		/* ########## FUNCION PARA BLOQUEAR UN DIA ENTERO ########## */
	}
	public function unblockDay (Request $request, $id)
	{
		/* ########## FUNCION PARA DESBLOQUEAR UN DIA ENTERO ########## */
		$request->validate([
			'dia' => 'required',
			'agno' => 'required',
			'mes' => 'required',
		],[
			'dia.required' => 'Debe seleccionar el día',
			'agno.required' => 'Debe seleccionar el día',
			'mes.required' => 'Debe seleccionar el día',
		]);
		$agenda = Agenda::where(['dia' => $request->dia,'agno' => $request->agno,'mes' => $request->mes,'recintos_id' => $id,])->update(['estado' => 'Disponible',]);
		Flash::success('Dia desbloqueado exitosamente');
		return redirect()->back();
		/* ########## FUNCION PARA DESBLOQUEAR UN DIA ENTERO ########## */
	}
	public function showEvento ($id)
	{
		/* ########## CARGAR LOS DATOS DE AGENDA ########## */
		$evento = Agenda::find($id)
			->load(['recintos','recintos.servicios','reserva','reserva.users',]);
		return response()->json($evento);
	}
	public function showEventoFecha ($fecha, $id)
	{
		/* ########## CARGAR LOS DATOS DE AGENDA DE UN DIA ########## */
		/* ID DEL SERVICIO */
		$clubid = (count(auth()->user()->clubes) > 0) ? auth()->user()->clubes->first()->clubes_id : 0;
		// $servicios = Servicios::where('clubes_id', $clubid)->select('id')->get();
		$recintos = Recintos::where('clubes_id', $clubid)
			->where('servicios_id', $id)
			->select('id')
			->get();
		$eventos = Agenda::where('fecha', $fecha)
			->whereIn('recintos_id', $recintos->toArray())
			->whereIn('estado', ['Reservado', 'Por Pagar'])
			->with(['recintos','recintos.servicios','reserva','reserva.users',])
			->get();
		return response()->json($eventos);
	}
	/* ########## NUEVOS ESTADOS DE AGENDA ########## */
	// Pendiente de Pago
	// Facturación Mensual
	// Pagado
	// Cancelado *ANTIGUO*
	/* ########## NUEVOS ESTADOS DE AGENDA ########## */
	public function agendarAdmin (Request $request)
	{
		$val = $request->validate([
			'horario_selected' => 'required',
			'recintos_id' => 'required',
			'estado' => 'required',
		],[
			'horario_selected.required' => 'Debe seleccionar un bloque horario',
			'recintos_id.required' => 'Debe seleccionar un recinto del club',
			'estado.required' => 'Debe seleccionar el estado del pago',
		]);
		$usr = $request->validate([
			'email' => 'required',
			'rut' => 'required',
			'nombres' => 'required',
		], [
			'email.required' => 'Ingrese el email del cliente',
			'rut.required' => 'Ingrese el rut del cliente',
			'nombres.required' => 'Ingrese el nombre del cliente',
		]);

		/* ########## VALIDAR RUT Y CORREO UNICO AL CREAR ########## */
		$data_rut = User::where('rut', $usr['rut'])->first();
		$data_email = User::where('email', $usr['email'])->first();

        /* ########## VALIDAR Y HACER UPDATE A USER EXISTENTE ########## */
        if ($request->usr_id == null) {
            if (!User::where($usr)->first()) {
                if (!is_null($data_rut) ||!is_null($data_email)) {
                    Flash::warning('Rut o correo ya utilizado por otro usuario');
                    return redirect()->back();
                }
            }
        }

        if (!$request->usr_id == null) {
            if (User::find($request->usr_id)->first()) {
                $user = User::find($request->usr_id)->update([
                    // 'email' => $request->email,
                    // 'rut' => $request->rut,
                    // 'nombres' => $request->nombres,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'ciudad' => $request->ciudad,
                    'direccion' => $request->direccion,
                    'telefono' => $request->telefono,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                ]);
            }

        }


		/* ########## VALIDAR RUT Y CORREO UNICO AL CREAR ########## */
		$user = User::firstOrCreate($usr, [
			'apellido_paterno' => $request->apellido_paterno,
			'apellido_materno' => $request->apellido_materno,
			'ciudad' => $request->ciudad,
			'direccion' => $request->direccion,
			'telefono' => $request->telefono,
			'fecha_nacimiento' => $request->fecha_nacimiento,
			'tipo_usuarios_id' => 4,
		]);


		/* ########## VALIDAR VALOR Y CREAR TRANSACCION ########## */
		// $transaction = Transaction::create([
		// 	'tipo' => 'transbank',
		// 	'agenda_id' => $agenda->id,
		// 	'token' => $response_transbank->token,
		// 	'return_url' => $response_transbank->url,
		// 	'amount' => $costo_total
		// ]);
		/* ########## VALIDAR VALOR Y CREAR TRANSACCION ########## */
		foreach ($request->horario_selected as $key => $value) {
			$agenda = Agenda::find($value);
			// chequear convenio
			if (isset($request->recintos_convenio_id) && !(is_null($request->recintos_convenio_id))) {
				// REEMPLAZAR VALOR
				$rec_conv = RecintosConvenios::find($request->recintos_convenio_id);
				$costo_total = !is_null($rec_conv) ? $rec_conv->valor : $costo_total;
			} else {
				$costo_total = $agenda->valor_hora;
			}
			// if ($agenda->valor_hora > 0) {
			$transaction = Transaction::create([
				'tipo' => 'web',
				'agenda_id' => $agenda->id,
				'token' => 'null',
				'return_url' => 'null',
				'amount' => $costo_total ?? 0,
			]);
			// }
			$reserva = Reservas::create([
				'users_id' => $user->id,
				'estado' => $request->estado ?? 'Reservado',
			]);
			$agenda->reserva_id = $reserva->id;
			$agenda->estado = $reserva->estado;
			$agenda->update();
		}
		Flash::success('Bloque/s reservado exitosamente');
		return redirect()->back();
	}
	public function reAgendarAdmin (Request $request, $id)
	{
		/* ########## PARA REAGENDAR DESDE EL ADMIN ########## */
		$val = $request->validate([
			'horario_selected' => 'required',
			'horario_antiguo' => 'required',
			'recintos_id' => 'required',
		],[
			'horario_selected.required' => 'Debe seleccionar un bloque horario',
			'horario_antiguo.required' => 'Debe seleccionar un bloque horario',
			'recintos_id.required' => 'Debe seleccionar un recinto del club',
		]);
		$user = User::find($id);
		// dd($val, $user);
		$agenda = Agenda::find($val['horario_antiguo']);
		$agenda->estado = "Disponible";
		$agenda->reserva_id = null;
		$agenda->update();
		foreach ($request->horario_selected as $key => $value) {
			$agenda = Agenda::find($value);
			if ($agenda->valor_hora > 0) {
				$transaction = Transaction::create([
					'tipo' => 'web',
					'agenda_id' => $agenda->id,
					'token' => 'null',
					'return_url' => 'null',
					'amount' => $agenda->valor_hora
				]);
			}
			$reserva = Reservas::create([
				'users_id' => $user->id,
				'estado' => 'Reservado',
			]);
			$agenda->reserva_id = $reserva->id;
			$agenda->estado = $reserva->estado;
			$agenda->update();
		}
		Flash::success('Bloque/s reservado exitosamente, bloque anterior cancelado');
		return redirect()->back();
	}
	public function upload (Request $request, $id)
	{
		/* ########## SUBIR IMAGENS A GALERIA ########## */
		$archivos = $request->file('imagen');
		if (!is_null($archivos)) {
			$cnt = Galerias::where(['modelo' => 'Recintos', 'modelo_id' => $id,])->count();
			$cnt++;
			foreach($archivos as $key => $archivo) {
				$validator = Validator::make([
					'file' => $archivo
				],[
					'file' => 'required|mimes:JPEG,jpeg,png,jpg,gif,svg|max:2048'
				]);
				if($validator->passes()){
					$nombre = $archivo->getClientOriginalName();
					// $archivo->move('img/recintos/'.$id, $nombre);
					$path = $archivo->storeAs(
						'recintos/'.$id, $nombre, 'public'
					);
					Galerias::firstOrCreate([
						'modelo' => 'Recintos',
						'modelo_id' => $id,
						'nombre' => $nombre,
						'extension' => $archivo->getClientOriginalExtension(),
						'ruta' => $path,
					],[
						'orden' => $cnt,
					]);
					$cnt++;
				} else {
					Flash::error('Debe seleccionar una imagen en los siguientes formatos: JPEG,jpeg,png de no más de 2MB.');
					return redirect()->back();
				}
			}
		} else {
			Flash::success('Debe seleccionar al menos una imagen');
			return redirect()->back();
		}
		Flash::success('Archivo(s) cargado(s) correctamente');
		return redirect()->back();
	}
	public function eliminar ($name, $id)
	{
		$ruta = "recintos/$id/$name";
		if(Storage::disk('public')->exists($ruta)) {
			Storage::disk('public')->delete($ruta);
			Galerias::where(['modelo' => 'Recintos','modelo_id' => $id,'nombre'=>$name,])->delete();
			$message = "Archivo eliminado";
			Flash($message);
			return redirect()->back();
		} else{
			$message = "Archivo no encontrado";
			Flash($message);
			return redirect()->back();
		}
	}
	/* ########## CRUD de precios segun horario del recinto ########## */
	public function storePrecio (Request $request, $id)
	{
		/* ########## Insertar precio de rango hora para recinto ########## */
		$request->validate([
			'desde' => 'required',
			'hasta' => 'required',
			'nombre' => 'required',
			'precio' => 'required',
			'comentario' => 'nullable',
		],[
			'desde.required' => 'Ingrese hora desde',
			'hasta.required' => 'Ingrese hora hasta',
			'nombre.required' => 'Ingrese nombre',
			'precio.required' => 'Ingrese nombre',
		]);
		if ($request->desde >= $request->hasta) {
			$message = "Horario Incorrecto";
			$response = ['status' => 0,'message' => $message,'valor' => null];
			return $response;
		}
		/* ########## CHEQUEO DE VALORES EXISTENTES ########## */
		$lista = RecintosPrecios::where('recintos_id', $id)->get();
		// $array = [
		// 	'1' => $lista->where('desde', '<=', $request->desde)->where('hasta', '>=', $request->hasta)->count(),
		// 	'2' => $lista->where('desde', '>=', $request->desde)->where('hasta', '<=', $request->hasta)->count(),
		// 	'3' => $lista->where('desde', '>=', $request->desde)->where('desde', '<=', $request->hasta)->count(),
		// 	'4' => $lista->where('hasta', '>', $request->desde)->where('hasta', '<=', $request->hasta)->count(), <= SE QUITA ESTA
		// ];
		// return $array;
		if ($lista->where('desde', '<=', $request->desde)->where('hasta', '>=', $request->hasta)->count() > 0 ||
			$lista->where('desde', '>=', $request->desde)->where('hasta', '<=', $request->hasta)->count() > 0 ||
			$lista->where('desde', '>=', $request->desde)->where('desde', '<=', $request->hasta)->count() > 0) {
			$message = "Horario no puede solapar uno ya existente para el recinto";
			$response = ['status' => 0,'message' => $message,'valor' => null,];
			return $response;
		}
		// $lista1 = RecintosPrecios::where('recintos_id', $id)->whereBetween('desde', [$request->desde,$request->hasta])->count();
		// $lista2 = RecintosPrecios::where('recintos_id', $id)->whereBetween('hasta', [$request->desde,$request->hasta])->count();
		// dd($lista1, $lista2);
		$valor = RecintosPrecios::updateOrCreate([
			'recintos_id' => $id,
			'desde' => $request->desde,
			'hasta' => $request->hasta,
		],[
			'precio' => $request->precio,
			'nombre' => $request->nombre,
			'comentario' => $request->comentario,
		]);
		$message = "Horario definido";
		// Flash($message);
		$response = ['status' => 1,'message' => $message,'valor' => $valor,];
		return $response;
	}
	public function deletePrecio ($id, $recinto = null)
	{
		$precio = RecintosPrecios::find($id);
		if (is_null($precio)) {
			$message = "Registro no encontrado";
			$response = ['status' => 0,'message' => $message];
			return $response;
		}
		$precio->delete();
		$message = "Dato eliminado";
		$response = ['status' => 1,'message' => $message];
		return $response;
	}
}










