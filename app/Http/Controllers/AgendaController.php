<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MultiAgenda;
use App\Models\Agenda;
use App\Models\User;
use App\Models\Reservas;
use Illuminate\Support\Collection;

use Flash, DateTime;

class AgendaController extends Controller
{
	public function __construct ()
	{
		//
	}
	public function index ()
	{
		$agendas = MultiAgenda::orderBy('id', 'DESC')->whereIn('clubes_id', auth()->user()->getClubes()->pluck('id'))->get();
		$clubes = auth()->user()->getClubes()->pluck('id');
		$users = User::whereHas('clubes', function ($query) use ($clubes) {
			$query->whereIn('clubes_id', $clubes)->where('tipo_usuarios_id', 5);
		})->get();
		return view('sistema.adminclub.agenda.index')
		->with([
			'agendas' => $agendas,
			'users' => $users,
		]);
	}
	public function store (Request $request)
	{
		// OBtener lista de recintos, dias de la semana y horas inicio, termino y cantidad de semanas.
		// Luego buscar los horarios dentro de estos rangos, agendarlos al usuario seleccionado de estar disponibles.
		// En caso de no estar disponibles, consultar comportamiento.
		// users_id clubes_id recintos_id fecha_inicio fecha_termino hora_inicio hora_termino dias
		$request->validate([
			'exampleDataList' => 'required|string',
			'usr_id' => 'required',
			'semanas' => 'required|min:1|max:8',
			'recintos' => 'required',
			'dias' => 'required',
			'inicio' => 'required',
			'fin' => 'required',
			'estado' => 'required',
		],[
			'exampleDataList.required' => 'Debe Seleccionar un entrenador',
			'semanas.required' => 'Debe ingresar la cantidad de semanas',
			'semanas.min' => 'Debe ingresar al menos una semana',
			'semanas.max' => 'Debe ingresar máximo cuatro semana',
			'recintos.required' => 'Debe seleccionar al menos un recinto',
			'dias.required' => 'Debe seleccionar al menos un dia',
			'inicio.required' => 'Debe ingresar las hora de inicio del bloque',
			'fin.required' => 'Debe ingresar las hora de inicio del bloque',
			'usr_id.required' => 'Debe ingresar un usuario válido',
			'estado.required' => 'Debe seleccionar el estado del pago',
		]);
		$inicio = new DateTime();
		$fin = new DateTime();
		// ANTES DE CREAR EL REGISTRO, AVISAR LOS HORARIOS YA OCUPADOS.
		// SI NO EXISTEN BLOQUES QUE AGENDAR, NO CREAR EL REGISTRO
		// $inicio->modify("+1 week"); // no considera el primer dia si se pasa, revisar.
		$inicio->modify("sunday this week");
		$fin->modify("+".$request->semanas." week");
		foreach ($request->recintos as $key => $value) {
			MultiAgenda::firstOrCreate([
				'users_id' => $request->usr_id,
				'clubes_id' => $request->clubes,
				'recintos_id' => $value,
				'fecha_inicio' => $inicio->format('Y-m-d'),
				'fecha_termino' => $fin->format('Y-m-d'),
				'hora_inicio' => $request->inicio,
				'hora_termino' => $request->fin,
				'dias' => implode(',', $request->dias)
			]);
		}
		$fin->modify('sunday this week'); // FECHAS OK, COMIENZA PRIMER DOMINGO, TERMINA EL ULTIMO DOMINGO
		$reserva = Reservas::create([
			'users_id' => $request->usr_id,
			'estado' => $request->estado ?? 'Reservado',
			'forma_pago' => null,
		]);
		// SOLO SE CREA UNA RESERVA AHORA
		while ($inicio <= $fin) {
			if (in_array($inicio->format('N'), $request->dias)) {
				// $inicio = $inicio->format('d-m-Y').' '.$request->inicio;
				// $fin = $inicio->format('d-m-Y').' '.$request->fin;
				if ($request->recintos) {
					for ($i = 0; $i < count($request->recintos); $i++) {
						$agenda = Agenda::where([
							['fecha', $inicio->format('Y-m-d')],
							['recintos_id', $request->recintos[$i]],
							['hora_inicio_bloque', '>=', $request->inicio],
							['hora_fin_bloque', '<=', $request->fin],
							['estado', 'Disponible']
						])->update([
							'estado' => $request->estado ?? 'Reservado',
							'reserva_id' => $reserva->id,
						]);
						// REPORTAR LOS NO DISPONIBLES AL CLIENTE
					}
				}
			}
			$inicio->modify("+1 days");
		}
		// dd("FIN", $request);

		Flash::success('Registro creado correctamente');
		return redirect()->back();
	}
	// FALTA FUNCION BORRAR QUE LIBERA LAS AGENDAS TOMADAS.
	public function delete ($id)
	{
		$data = MultiAgenda::find($id);
		$agenda = new Collection();
		$inicio = new DateTime($data->fecha_inicio);
		$fin = new DateTime($data->fecha_termino);
		$var = (explode(',', $data->dias));
		while ($inicio <= $fin) {
			if (in_array($inicio->format('N'), $var)) {
				$result = Agenda::where('fecha',$inicio->format('Y-m-d'))
					->where('recintos_id',$data->recintos_id)
					->where('hora_inicio_bloque','>=',$data->hora_inicio)
					->where('hora_fin_bloque','<=',$data->hora_termino)
					->whereIn('estado',['Reservado','Facturación Mensual','Pendiente de Pago','Pagado'])
					->whereHas('reserva', function ($query) use ($data) {
						$query->where('users_id', $data->users_id);
					})->get();
				$agenda = $agenda->merge($result);
			}
			$inicio->modify("+1 days");
		}
		foreach ($agenda as $key => $value) {
			$value->update([
				'estado' => 'Disponible',
				'reserva_id' => null,
			]);
		}
		$data->delete();
		Flash::success('Registro eliminado, bloques disponibles nuevamente');
		return redirect()->route('multi.index');
	}
	public function preLoadAgenda (Request $request)
	{
		$agenda = new Collection();
		$inicio = new DateTime();
		$fin = new DateTime();
		$inicio->modify("sunday this week");
		$fin->modify("+".$request->semanas." week");
		$fin->modify('sunday this week');
		while ($inicio <= $fin) {
			if (in_array($inicio->format('N'), $request->dias)) {
				if ($request->recintos) {
					for ($i = 0; $i < count($request->recintos); $i++) {
						$data = Agenda::where([
							['fecha', $inicio->format('Y-m-d')],
							['recintos_id', $request->recintos[$i]],
							['hora_inicio_bloque', '>=', $request->inicio],
							['hora_fin_bloque', '<=', $request->fin],
						])->with('recintos')->get();
						// $agenda = $agenda->push($data); devuelve 6 arrays de 3, el de abajo los 18 juntos
						$agenda = $agenda->merge($data);
					}
				}
			}
			$inicio->modify("+1 days");
		}
		$response = [
			'agenda' => $agenda,
			'total' => count($agenda),
			'reservados' => $agenda->whereIn('estado',['Reservado','Facturación Mensual','Pendiente de Pago','Pagado'])->count(),
			'disponibles' => $agenda->where('estado','Disponible')->count(),
		];
		return $response;
	}

	public function reporte ()
	{
		$clubes = auth()->user()->getClubes()->pluck('id');
		$agendas = MultiAgenda::orderBy('id', 'DESC')->whereIn('clubes_id', $clubes)->get();
		$users = User::whereHas('clubes', function ($query) use ($clubes) {
			$query->whereIn('clubes_id', $clubes)
			->where('tipo_usuarios_id', 5);
		})->get();
		return view('sistema.adminclub.agenda.reporte', [
			'agendas' => $agendas,
			'users' => $users,
		]);
	}

	public function reporteSearchOld ($user, $month, $year)
	{
		$month = ($month <= 9) ? "0".$month : $month;
		$desde = $year."-".$month."-01";
		$hasta = $year."-".$month."-31";

		$clubes = User::find($user)->getClubes()->pluck('id');
		$agendas = MultiAgenda::orderBy('id', 'DESC')
			->whereIn('clubes_id', $clubes)
			// ->whereBetween('fecha_termino', [$desde, $hasta])
			->where('fecha_inicio', '>=', $desde)
			->where('fecha_termino', '<=', $hasta)
			->get();
		$users = User::whereHas('clubes', function ($query) use ($clubes) {
			$query->whereIn('clubes_id', $clubes)
			->where('tipo_usuarios_id', 5);
		})->get();

		return response()->json(['agendas' => $agendas]);
	}
	public function reporteSearch ($user, $month, $year)
	{
		$month = ($month <= 9) ? "0".$month : $month;
		$desde = $year."-".$month."-01";
		$hasta = $year."-".$month."-31";

		$clubes = User::find($user)->getClubes()->pluck('id');
		$agendas = MultiAgenda::orderBy('id', 'DESC')
			->whereIn('clubes_id', $clubes)
			// ->whereBetween('fecha_termino', [$desde, $hasta])
			->where('fecha_inicio', '>=', $desde)
			->where('fecha_termino', '<=', $hasta)
			->get();
		// $users = User::whereHas('clubes', function ($query) use ($clubes) {
		// 	$query->whereIn('clubes_id', $clubes)
		// 	->where('tipo_usuarios_id', 5);
		// })->get();
		$agendas = Agenda::whereBetween('fecha', [$desde, $hasta])
			->whereIn('estado', ['Reservado','Facturación Mensual','Pendiente de Pago','Pagado'])
			->whereHas('reserva', function ($query) use ($user) {
				$query->where('users_id', $user);
			})
			->get();
		return response()->json(['agendas' => $agendas]);
	}
	public function cambiarEstadoPago (Request $request, $id)
	{
		$request->validate([
			'estado' => 'required',
		]);
		$agenda = Agenda::find($id);
		$agenda->estado = $request->estado;
		$agenda->update();
		return redirect()->back();
	}
}










