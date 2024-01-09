@php
// dd(auth()->user()->checkAdmin());
// dd($recintos);
@endphp
@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Inicio
	@parent
@stop
@section('header_styles')
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">
<link href="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/sticky-header/bootstrap-table-sticky-header.css" rel="stylesheet">

{{-- <link rel="stylesheet" href="{{ asset('extensions/sticky-header/bootstrap-table-sticky-header.scss') }}"> --}}

<style type="text/css">
.cabecera {
	color: white;
	background-color: #646464;
}
.disponible {
	/*background-color: #DBDBDB;*/
	background-color: #18B2F1;
}
.no-disponible {
	color: white;
	background-color: #EE2C23;
	opacity:  0.7;
	font-weight: bold;
}
.ocupado {
	color: black;
	background-color: #1EDEDE;
}
.pagado {
	color: white;  /* TEXTO */
	background-color: #00bf86;  /* CASILLA */
}
.mensual {
	color: white;
	background-color: #424cff;
}
.pendiente {
	color: white;
	background-color: #c7535b;
}
.hora {
	text-align: center;
	display: block;
	border-radius: 5px;
	padding: 5px 0;
	margin-bottom: 20px;
}
.hora.hora-personalizada {
	background: #C4FE02;
	color: #0C284F;
}
.hora.hora-personalizada2 {
	background: #2C4527;
	color: white;
}
.hora.hora-neutro {
	color: white;
	background: #00963F;
	margin-bottom: 0;
}
.hora.no-disponible {
	background: #646464;
	color: #AAAAAA;
}
.card-text {
	font-size: x-large;
	text-align: center;
}
.card-header {
	/*font-size: large;*/
	text-align: center;
}
@media print {
	table div, .cabecera, td.cabecera, td {
		background-color: #646464!important;
		-webkit-print-color-adjust: exact;
	}
	.horario.disponible, td.horario.disponible {
		background-color: #646464!important;
		-webkit-print-color-adjust: exact;
	}
	.fixed-table-toolbar {
		display: none;
	}
}
</style>
@stop
@section('content')
	<!-- Content Header (Page header) -->
	{{-- <header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-lg-6">
					<h4 class="nav_top_align skin_txt">
						<i class="fa fa-file-o"></i>
						Inicio
					</h4>
				</div>
			</div>
		</div>
	</header> --}}

	{{-- <div class="outer">
		<div class="inner bg-container">
			<div class="row">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgendar">AGENDAR</button>
			</div>
		</div>
	</div> --}}

	<div class="outer">
		<div class="inner {{-- bg-container --}}" {{-- style="height: 0%;" --}}>
			<form class="form inline">
				<div class="row">
					@if(auth()->user()->tipo_usuarios_id != 7)
					<div class="col-md-4 col-lg-1 pr-lg-1 mb-2" style="text-align: center">
						<button type="button" class="btn btn-success btn-block" onclick="cleanForm()" data-toggle="modal" data-target="#modalAgendar">AGENDAR</button>
					</div>
					@endif
					<div class="col-md-4 col-lg-1 pr-lg-1 mb-2" style="text-align: center">
						<button type="button" class="btn btn-warning btn-block" id="imprimir">IMPRIMIR</button>
					</div>
					<div class="col-md-4 col-lg-1 pr-lg-1 mb-2" style="text-align: center">
						<button type="button" class="btn btn-info btn-block dropdown-toggle" id="datos">Datos</button>
					</div>
					<div class="col-md-1 pr-md-1 d-flex align-items-center text-right">
						<label for="fecha" class="mb-0 w-100">Fecha: </label>
					</div>
					<div class="col-md-2">
						<input type="date" name="fecha" class="form-control h-100" id="fecha" value="{{ date('Y-m-d') }}" onchange="return getAgenda()">
					</div>
					<div class="col-md-1 pr-md-1 d-flex align-items-center text-right">
						<label for="cuadro" class="mb-0 w-100">Club: </label>
					</div>
					<div class="col-md-2">
						<select class="form-control h-100" name="cuadro2" id="clubes" onchange="return getAgenda()">
							<option value="0">Todos</option>
							@foreach(auth()->user()->getClubes() as $club)
								<option value="{{ $club->id }}"> {{ $club->display_name}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-1 pr-md-1 d-flex align-items-center text-right">
						<label for="cuadro" class="mb-0 w-100">Servicio: </label>
					</div>
					<div class="col-md-2">
						<select class="form-control h-100" name="cuadro" id="servicio" onchange="return getAgenda()">
							<option value="0">Todos</option>
							@foreach(auth()->user()->getServicios() as $servicio)
								<option value="{{ $servicio->id }}"> {{ $servicio->nombre}}</option>
							@endforeach
						</select>
					</div>
					{{-- <div class="col-sm-2" style="text-align: center">
						<label for="cuadro" >Recinto: </label>
					</div>
					<div class="col-sm-2 ">
						<select class="form-control" name="recinto" id="recinto" onchange="return getAgenda()">
							@foreach(auth()->user()->getRecintos() as $recinto)
								<option value="{{ $recinto->id }}"> {{ $recinto->nombre}} <small>({{$recinto->servicios->nombre}})</small></option>
							@endforeach
						</select>
					</div>--}}
					{{-- <div class="col-sm-2" style=" align-items: center; justify-content: center;">
						<button type="submit" class="btn btn-primary mb-2">Consultar</button>
					</div> --}}
				</div>
			</form>
			<div class="dropdown my-3 show" id="dropdown">
				<div class="dropdown-menu p-0 show" id="dropdown-menu" style="position:initial;border:none">
					<div class="card-body p-0">
						<div class="card-columns">
							{{-- NUMEROS DEL DIA --}}
							<div class="card border-primary mb-0">
								<div class="card-header bg-white">Bloques agendados <span class="fecha_seleccionada"></span></div>
								<div class="card-body">
									<p class="card-text"><span id="box_1">{{ $data['reservados'] }}</span> Bloques agendados</p>
								</div>
							</div>
							<div class="card border-primary mb-0">
								<div class="card-header bg-white">% Uso x instalaciones <span class="fecha_seleccionada"></span></div>
								<div class="card-body">
									<p class="card-text"><span id="box_2">{{ number_format($data['ocupados'], 0, ',', '.') }}</span>% Bloques agendados</p>
								</div>
							</div>
							<div class="card border-primary mb-0">
								<div class="card-header bg-white">% Bloques disponibles <span class="fecha_seleccionada"></span></div>
								<div class="card-body">
									<p class="card-text"><span id="box_3">{{ number_format($data['libres'], 0, ',', '.') }}</span>% Bloques disponibles</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="canvas" class="panel panel-default">
				{{-- @dd(count($recintos)) --}}
				@if(count($recintos) > 0)
				<table class="table table-bordered table-striped" id="tabla_ppal" data-show-columns="true" bgcolor="#4b49ac">
					<thead id="thead" style="align-self: flex-start;">
						<tr>
							<th class="cabecera" style="text-align: center;" width="4%">hora</th>
							@foreach($recintos as $key => $recinto)
							<th class="cabecera">
								{{ $recinto->nombre }}
								<!--
								@if(auth()->user()->getClubes()->count() > 1)
								<small>({{ $recinto->servicios->nombre }}/{{ $recinto->clubes->display_name }})</small>
								@else
								<small>({{ $recinto->servicios->nombre }})</small>
								@endif
								-->
							</th>
							@endforeach
						</tr>
					</thead>
					<tbody id="tbody">
						@php
						// BUSCAR EL QUE PARTE PRIMERO PARA COMENZAR LA AGENDA
						// dd($recintos->sortBy(['hora_inicio', 'asc'])->first()->hora_inicio);
						// $rec = $recintos->first()->agenda->first();
						// $ser = $recintos->first()->servicios;
						// dd($ser, $rec);
						// $inicio = date_create("$rec->fecha $recinto->hora_inicio");
						// $termino = date_create("$rec->fecha $recinto->hora_fin");
						$inicio = date_create($recintos->sortBy(['hora_inicio', 'asc'])->first()->hora_inicio);
						$termino = date_create("23:00:00");
						// dump($inicio, $termino);
						@endphp
						@while($inicio <= $termino)
						 <tr>
							<td style="text-align: center;">
								<span>{{ $inicio->format('H:i') }}</span>
							</td>
							@foreach($recintos as $key => $recinto)
							@php
							$var = $recinto->agenda->where('hora_inicio_bloque', $inicio->format('H:i:s'))
								->where('fecha', date('Y-m-d'))
								->first();
							// $fin = $recinto->agenda->where('hora_fin_bloque', $inicio->format('H:i:s'))
							// 	->where('fecha', date('Y-m-d'))
							// 	->first();
							$mid = $recinto->agenda->where('hora_inicio_bloque', '<', $inicio->format('H:i:s'))
								->where('hora_fin_bloque', '>',$inicio->format('H:i:s'))
								->where('fecha', date('Y-m-d'))
								->first();
							@endphp
								@if(!is_null($var))
								@php
								if ($var->estado=='Reservado') {
									$clase = "ocupado";
								} elseif ($var->estado=='Facturación Mensual') {
									$clase = "mensual";
								} elseif ($var->estado=='Pendiente de Pago') {
									$clase = "pendiente";
								} elseif ($var->estado=='Pagado') {
									$clase = "pagado";
								} elseif ($var->estado=='Disponible') {
									$clase = "disponible";
								} else {
									$clase = "";
								}
								@endphp
								<td style="text-align: center;" data-agenda="{{ $var->id }}" onclick="loadModalHorario(this)" data-toggle="modal" data-target="#modalHorario" class="horario {{ $clase }} {{ ($var->estado=='Bloqueado') ? 'no-disponible' : '' }}">
									@if(!is_null($var->reserva))
									{{ date_create($var->hora_inicio_bloque)->format('H:i') }} <br> {{ date_create($var->hora_fin_bloque)->format('H:i') }}
									<br>{{ !is_null($var->reserva->users) ? $var->reserva->users->full_name : 'Usuario no encontrado' }}
									@endif
									@if(!is_null($var->reserva))
									<br>{{ ($var->reserva->estado == "Reservado") ? 'Reservado/Pagado' : $var->estado }}
									{{-- ESTADO DE RESERVA (PAGO) --}}
									@endif
								</td>
								@endif
								@if(!is_null($mid))
								@php
								if ($mid->estado=='Reservado') {
									$clase = "ocupado";
								} elseif ($mid->estado=='Facturación Mensual') {
									$clase = "mensual";
								} elseif ($mid->estado=='Pendiente de Pago') {
									$clase = "pendiente";
								} elseif ($mid->estado=='Pagado') {
									$clase = "pagado";
								} else {
									$clase = "";
								}
								@endphp
								<td data-agenda="{{ $mid->id }}" onclick="loadModalHorario(this)" data-toggle="modal" data-target="#modalHorario" class="horario {{ $mid->estado=='Disponible' ? 'disponible' : '' }} {{ $clase }} {{ ($mid->estado=='Bloqueado') ? 'no-disponible' : '' }}">
									{{-- {{ $mid->estado }} --}}{{ $mid->comentario ?? '' }}
								</td>
								@endif
								{{-- @if(!is_null($fin))
								<td class="{{ $fin->estado=='Disponible' ? 'disponible' : '' }} {{ ($fin->estado=='Reservado') ? 'ocupado' : '' }} {{ ($fin->estado=='Bloqueado') ? 'no-disponible' : '' }}">
									Fin {{ date_create($fin->hora_fin_bloque)->format('H:i') }}
								</td>
								@endif --}}
								@if(is_null($var) && is_null($mid))
								<td></td>
								@endif
							@endforeach
						</tr>
						@php
						$inicio->modify("+30 min");
						@endphp
						@endwhile
						{{-- <tr>
							<td style="text-align: center;">7:00</td>
						</tr> --}}
					</tbody>
				</table>
				@else
				<p>No tiene recintos cargados aun</p>
				@endif
			</div>
		</div>
	</div>

	@if(auth()->user()->checkAdmin())
	{{-- AGENDAR --}}
	<div class="modal fade" id="modalAgendar" tabindex="-1" role="dialog" aria-hidden="true" >
		<div class="modal-dialog modal-lg" style="">
			<form method="post" action="{{ route('agendar.admin') }}" onsubmit="return validaragenda(this)">
				@csrf
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">
							{{-- <i class="fa fa-info"></i> --}} Agendar
						</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						{{-- LIMPIAR EL FORMULARIO AL ABRIR O CERRAR. --}}
					</div>
					<div class="modal-body" id="mbody">
						<div class="input-group">
							<div class="container">
								<div class="row">
									<div class="col-12">
										<label for="exampleDataList" class="form-label">Seleccione usuario</label>
										<input class="form-control" {{-- name="clientes_id" --}} list="datalistOptions" id="exampleDataList" placeholder="Buscar por nombre...">
										<datalist id="datalistOptions" style="overflow: scroll">
											@foreach($users as $user)
											<option value="{{ $user->full_name }}" data-id="{{ $user->id }}"></option>
											@endforeach
										</datalist>
										<span style="color: red;display:none;" id="mostraruser" class="form-group mx-sm-3 mb-2">Debe ingresar un Usuario correspondiente</span>
									</div>
									<input type="hidden" name="usr_id" id="usr_id">
									<div class="col-12 mt-3 mb-3">
										<div class="form-row" id="info_user">
											<div class="col-12 mb-2">
												<div class="">
													<input type="email" name="email" id="email" class="form-control" placeholder="Email">
												</div>
												<span style="color: red;display:none;" id="mostraremaill" class="form-group mx-sm-3 mb-2">Debe ingresar un E-mail correspondiente</span>
											</div>
											<div class="col-6 mb-2">
												<div >
													<input type="text" name="rut" id="rut" class="rut form-control" placeholder="Rut">
													<span style="color: red; display: none;" id="resultQuery"></span>
												</div>
												<span style="color: red;display:none;" id="mostrarrutt" class="form-group mx-sm-3 mb-2">Debe ingresar un Rut correspondiente</span>
											</div>
											<div class="col-6 mb-2">
												<div>
													<input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombre">
												</div>
												<span style="color: red;display:none;" id="mostranombre" class="form-group mx-sm-3 mb-2">Debe ingresar un Nombre correspondiente</span>
											</div>
											<div class="col-6 mb-2">
												<div>
													<input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" placeholder="Apellido paterno">
												</div>
												<span style="color: red;display:none;" id="mostrarapep" class="form-group mx-sm-3 mb-2">Debe ingresar un Apellido Paterno correspondiente</span>
											</div>
											<div class="col-6 mb-2">
												<div>
													<input type="text" name="apellido_materno" id="apellido_materno" class="form-control" placeholder="Apellido materno">
												</div>
												<span style="color: red;display:none;" id="mostrarapem" class="form-group mx-sm-3 mb-2">Debe ingresar un Apellido Materno correspondiente</span>
											</div>
											<div class="col-6 mb-2">
												<div>
													<input type="text" name="ciudad" id="ciudad" class="form-control" placeholder="Ciudad">
												</div>
												<span style="color: red;display:none;" id="mostrarciudad" class="form-group mx-sm-3 mb-2">Debe ingresar un Ciudad correspondiente</span>
											</div>
											<div class="col-6 mb-2">
												<div>
													<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Direccion">
												</div>
												<span style="color: red;display:none;" id="mostrardirecci" class="form-group mx-sm-3 mb-2">Debe ingresar una Direccion correspondiente</span>
											</div>
											<div class="col-6 mb-2">
												<div>
													<input type="text" name="telefono" id="telefono" class="form-control" placeholder="Telefono">
												</div>
												<span style="color: red;display:none;" id="mostrartelefono" class="form-group mx-sm-3 mb-2">Debe ingresar un Telefono correspondiente</span>
											</div>
											<div class="col-6 mb-2">
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">Fecha de nacimiento</span>
													</div>
													<input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ date('Y-m-d') }}" class="form-control" max="{{ date('Y-m-d') }}" onchange="calcularEdad()" placeholder="Fecha de nacimiento">
												</div>
												<span style="color: red;display:none;" id="mostrarfnaci" class="form-group mx-sm-3 mb-2">Debe ingresar un F. Nacimiento correspondiente</span>
												<div id="validaredad">
													<span>Haga Click aqui para confirmar menor de edad: </span>
													<input type="checkbox" id="vaedad" name="valedad">
													<span style="color: red;display:none;" id="mostrarvaliedad" class="form-group mx-sm-3 mb-2">Debe confirmar persona menor de edad</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-6">
										<label><b>Servicio</b></label>
										<select class="form-control" name="servicio" onchange="return loadAgendaModal()" id="servicio2">
											<option value="0">Seleccione servicio</option>
											@foreach(auth()->user()->getServicios() as $servicio)
											<option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
											@endforeach
										</select>
										<span style="color: red;display:none;" id="mostrarservi" class="form-group mx-sm-3 mb-2">Debe seleccionar un Servicio correspondiente</span>
									</div>
									<div class="col-6">
										<label><b>Instalación</b></label>
										<select class="form-control" onchange="return loadAgendaModal()" name="recintos_id" id="recinto2">
											<option value="0">Seleccione Instalación</option>
										</select>
										<span style="color: red;display:none;" id="mostrarrecinto" class="form-group mx-sm-3 mb-2">Debe seleccionar una Instalacion correspondiente</span>
									</div>
									<div class="col-6">
										<label for="">Fecha</label>
										<input type="date" class="form-control" onchange="return loadAgendaModal()" id="fecha_select" value="{{ date('Y-m-d') }}">
										<span style="color: red;display:none;" id="mostrarfech" class="form-group mx-sm-3 mb-2">Debe seleccionar una Fecha correspondiente</span>
									</div>
									<div class="col-6">
										<label for="">Estado pago</label>
										<select class="form-control" name="estado">
											<option value="Pendiente de Pago">Pendiente de Pago</option>
											<option value="Facturación Mensual">Facturación Mensual</option>
											<option value="Pagado">Pagado</option>
											{{-- <option value="Cancelado">Cancelado</option> --}}
										</select>
									</div>
									<div class="col-12">
										<div id="bloque_convenios">
											{{-- <input type="radio" name="recintos_convenio_id" value=""> --}}
										</div>
									</div>
									<div  class="col-12" >
										<div>
											{{-- <input type="hidden" readonly name="horario_selected" id="horario_selected"> --}}
											<div class="row mt-4" id="bloques" style="display: none;"></div>
										</div>
										<span style="color: red;display:none;" id="mostrarhoras" class="form-group mx-sm-3 mb-2">Debe seleccionar Horas correspondiente</span>
									</div>
									<div class="col-12">
										<div class="row mt-3">
											<div class="col-12 col-sm-4 text-right">
												<h5>Valor: <span class="valor_total" id="valor_hrs"></span></h5>
												<hr class="d-block d-sm-none">
											</div>
											<div class="col-12 col-sm-4 text-right">
												<h5>Descuento: <span id="porcent_dcto">0%</span></h5>
												<hr class="d-block d-sm-none">
											</div>
											<div class="col-12 col-sm-4 text-right">
												<h5>Valor total: <span class="valor_total" id="valor_total"></span></h5>
												<hr class="d-block d-sm-none">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger float-right" data-dismiss="modal">
							Cerrar
							<i class="fa fa-times"></i>
						</button>
						<button class="btn btn-warning" type="reset" id="clear" onclick="limpiarerroragenda()">
							<i class="fa fa-refresh"></i>
							Limpiar
						</button>
						<button type="submit" class="btn btn-success pull-left text_save">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	@endif

	@if(auth()->user()->tipo_usuarios_id != 7)
	{{-- MODAL HORARIO CANCElAR BLOQUEAR REAGENDAR --}}
	<div class="modal fade" id="modalHorario" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" style="">
			<form method="post" action="{{-- route('agendar.admin') --}}" id="form_cancelar">
				@csrf
				@method('PUT')
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">
							<i class="fa fa-info"></i> Info horario
						</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body" id="mbody_horario">
						{{-- PARA LIBERAR/REAGENDAR/ETC. --}}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger float-right" data-dismiss="modal">
							Cerrar
							<i class="fa fa-times"></i>
						</button>
						{{-- <button type="button" class="btn btn-success pull-left text_save">Guardar</button> --}}
					</div>
				</div>
			</form>
		</div>
	</div>
	@endif

	@if(auth()->user()->tipo_usuarios_id == 7)
	{{-- MODAL HORARIO CANCElAR BLOQUEAR REAGENDAR USUARIO VISUALIZADOR --}}
	<div class="modal fade" id="modalHorario" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" style="">
			<form method="post" action="{{-- route('agendar.admin') --}}" id="form_cancelar">
				@csrf
				@method('PUT')
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">
							<i class="fa fa-info"></i> Info horario
						</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body" id="mbody_horario_v">
						{{-- PARA LIBERAR/REAGENDAR/ETC. --}}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger float-right" data-dismiss="modal">
							Cerrar
							<i class="fa fa-times"></i>
						</button>
						{{-- <button type="button" class="btn btn-success pull-left text_save">Guardar</button> --}}
					</div>
				</div>
			</form>
		</div>
	</div>
	@endif


	{{-- MODAL CANCELAR MOTIVOS --}}
	<div class="modal fade" id="modalCancelar" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" style="">
			<form method="post" action="{{-- route('agendar.admin') --}}" id="form_motivos" onsubmit="return valida(this)">
				@csrf
				@method('PUT')
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">
							<i class="fa fa-info"></i> Cancelar agenda
						</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body" id="mbody_motivos">
						{{-- PARA LIBERAR/REAGENDAR/ETC. --}}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger float-right" data-dismiss="modal">
							Cerrar
							<i class="fa fa-times"></i>
						</button>
						<button type="submit" class="btn btn-success pull-left text_save" id="botoncancelar" >Enviar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	{{-- MODAL CAMBIAR ESTADO DE PAGO --}}
	<div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" style="">
			<form method="post" action="#" id="form_pagos" onsubmit="return valida(this)">
				@csrf
				@method('PUT')
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">
							<i class="fa fa-info"></i> Editar estado de pago
						</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body" id="mbody_pagos">
						<div class="col-4">
							<label for="">Estado pago</label>
						</div>
						<div class="col-8">
							<select class="form-control" name="estado">
								<option value="Pendiente de Pago">Pendiente de Pago</option>
								<option value="Facturación Mensual">Facturación Mensual</option>
								<option value="Pagado">Pagado</option>
								{{-- <option value="Cancelado">Cancelado</option> --}}
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger float-right" data-dismiss="modal">
							Cerrar
							<i class="fa fa-times"></i>
						</button>
						<button type="submit" class="btn btn-success pull-left text_save">Enviar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	{{-- MODAL RE AGENDAR --}}
	<div class="modal fade" id="modalReAgendar" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" style="">
			<form method="post" action="{{-- route('agendar.admin') --}}" id="form_reagenda" onsubmit="return validareaegnda(this)">
				@csrf
				@method('PUT')
				<input type="hidden" name="horario_antiguo" id="horario_antiguo">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">
							<i class="fa fa-info"></i> Re-agendar agenda
						</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body" id="mbody_reagendar">
						<div class="row">
							<div class="col-6">
								<label><b>Servicio</b></label>
								<select class="form-control" name="servicio" onchange="return loadReAgendaModal()" id="servicio_3">
									<option value="0">Seleccione servicio</option>
									@foreach(auth()->user()->getServicios() as $servicio)
									<option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-6">
								<label><b>Instalación</b></label>
								<select class="form-control" onchange="return loadReAgendaModal()" name="recintos_id" id="recinto_3">
									<option value="0">Seleccione Instalación</option>
								</select>
							</div>
							<div class="col-6">
								<label for="">Fecha</label>
								<input type="date" class="form-control" onchange="return loadReAgendaModal()" id="fecha_select_2" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
							</div>
							<div class="col-12" >
								{{-- <input type="hidden" readonly name="horario_selected" id="horario_selected"> --}}
								<div class="row mt-4" id="bloques_2" style="display: none;"></div>
							</div>
							{{-- <div class="col-12 text-right"><h5>Valor total: </h5><span id="valor_reagendar"></span></div> --}}
						</div>
					</div>
					<div  class="textoreagenda">
						<span id="mensajeerrorreagen" class="alert-danger"></span>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger float-right" data-dismiss="modal">
							Cerrar
							<i class="fa fa-times"></i>
						</button>
						<button type="submit" class="btn btn-success pull-left text_save">Enviar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@stop
@section('footer_scripts')
<script src="{{ asset('js/validateRut.js') }}"></script>
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js"></script>





<script type="text/javascript">

	function cleanForm () {
		var fecha = new Date(); //Fecha actual
		var mes = fecha.getMonth()+1; //obteniendo mes
		var dia = fecha.getDate(); //obteniendo dia
		var ano = fecha.getFullYear(); //obteniendo año
		if(dia<10)
			dia='0'+dia; //agrega cero si el menor de 10
		if(mes<10)
			mes='0'+mes //agrega cero si el menor de 10

		$(`#exampleDataList`).val('');
		$("#email").val('');
		$("#rut").val('');
		$("#nombres").val('');
		$("#apellido_paterno").val('');
		$("#apellido_materno").val('');
		$("#ciudad").val('');
		$("#direccion").val('');
		$("#telefono").val('');
		$("#fecha_nacimiento").val(ano+"-"+mes+"-"+dia);
		$("#bloques").empty();
		$("#fecha_select").val(ano+"-"+mes+"-"+dia);
		$("#bloque_convenios").empty();
		document.getElementById("mostraruser").style.display = "none";
		document.getElementById("mostraremaill").style.display = "none";
		document.getElementById("mostrarrutt").style.display = "none";
		document.getElementById("mostranombre").style.display = "none";
		document.getElementById("mostrarapep").style.display = "none";
		document.getElementById("mostrarapem").style.display = "none";
		document.getElementById("mostrarciudad").style.display = "none";
		document.getElementById("mostrardirecci").style.display = "none";
		document.getElementById("mostrartelefono").style.display = "none";
		document.getElementById("mostrarfnaci").style.display = "none";
		document.getElementById("mostrarservi").style.display = "none";
		document.getElementById("mostrarrecinto").style.display = "none";
		document.getElementById("mostrarfech").style.display = "none";
		document.getElementById("mostrarhoras").style.display = "none";
		document.getElementById("mostrarvaliedad").style.display = "none";
		document.getElementById("validaredad").style.display = "block";
		document.getElementById('vaedad').checked = false;
	}
	var $table = $('#tabla_ppal');

	function buildTable($el) {
		$el.bootstrapTable('destroy').bootstrapTable({
			showFullscreen: true,
			search: false,
			stickyHeader: true,
			stickyHeaderOffsetLeft: parseInt($('body').css('padding-left'), 10),
			stickyHeaderOffsetRight: parseInt($('body').css('padding-right'), 10),
			onClickCell: function (field, value, row, $element) {
				console.log($element);
				loadModalHorario($element.attr('data-agenda'));
			},
		})
	}
	buildTable($table);
	// let parent = document.querySelector('#tabla_ppal').parentElement;
	// while (parent) {
	// 	const hasOverflow = getComputedStyle(parent).overflow;
	// 	if (hasOverflow !== 'visible') {
	// 		// $(`#${parent.id}`).css('overflow', '');
	// 		console.log(hasOverflow, parent, parent.height);
	// 	}
	// 	parent = parent.parentElement;
	// }
	/* LISTA DE CLIENTES */
	$('#exampleDataList').on('input', function() {
		var fecha = new Date(); //Fecha actual
		var mes = fecha.getMonth()+1; //obteniendo mes
		var dia = fecha.getDate(); //obteniendo dia
		var ano = fecha.getFullYear(); //obteniendo año
		if(dia<10)
			dia='0'+dia; //agrega cero si el menor de 10
		if(mes<10)
			mes='0'+mes //agrega cero si el menor de 10
		let value = $(this).val();
		let id = $(`#datalistOptions [value ="${value}"]`).data('id');
		let id2 = $(`#datalistOptions [value ="${value}"]`).attr('data-id');
		// console.log(id, value, id2);FUNCIONAN LOS TRES!3
		if (typeof id === 'undefined') {
			console.log('valor no valido');
			$("#email").val('');
			$("#rut").val('');
			$("#nombres").val(value);
			$("#apellido_paterno").val('');
			$("#apellido_materno").val('');
			$("#ciudad").val('');
			$("#direccion").val('');
			$("#telefono").val('');
			$("#fecha_nacimiento").val(ano+"-"+mes+"-"+dia);
			document.getElementById("validaredad").style.display = "block";
		} else {
			$("#resultQuery").hide();
			$.ajax({
				url: `load/${id}/user/from-id`,
				type: 'GET',
			})
			.done(function(response) {
				if (!response) {
					$("#usr_id").val('');
					$("#email").val('');
					$("#rut").val('');
					$("#nombres").val('');
					$("#apellido_paterno").val('');
					$("#apellido_materno").val('');
					$("#ciudad").val('');
					$("#direccion").val('');
					$("#telefono").val('');
					$("#fecha_nacimiento").val(ano+"-"+mes+"-"+dia);
					document.getElementById("validaredad").style.display = "block";
				} else {
					$("#usr_id").val(response.id);
					$("#email").val(response.email);
					$("#rut").val(response.rut);
					$("#nombres").val(response.nombres);
					$("#apellido_paterno").val(response.apellido_paterno);
					$("#apellido_materno").val(response.apellido_materno);
					$("#ciudad").val(response.ciudad);
					$("#direccion").val(response.direccion);
					$("#telefono").val(response.telefono);
					$("#fecha_nacimiento").val(response.fecha_nacimiento);
					var fecha_nacimiento = response.fecha_nacimiento
					var hoy = new Date();
					var cumpleanos = new Date(fecha_nacimiento);
					var edad = hoy.getFullYear() - cumpleanos.getFullYear();
					var m = hoy.getMonth() - cumpleanos.getMonth();
					if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
						edad--;
					}
					if(edad < 18){
							document.getElementById("validaredad").style.display = "block";
					}else{
							document.getElementById("validaredad").style.display = "none";
					}
				}
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				// console.log("complete");
			});
		}
	});
	$("#clubes").change(function(event) {
		let id = $("#clubes").val();
		let uri = `/load/${id}/servicios`;
		$.ajax({
			url: uri,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response);
			$("#servicio").empty();
			$("#servicio").append(`<option value="0">Todos</option>`);
			$.each(response, function(index, val) {
				$("#servicio").append(`
					<option value="${val.id}"> ${val.nombre}</option>
				`);
			});
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
	});
	function getAgenda () {
		let fecha = $("#fecha").val();
		let day = new Date(`${fecha}T06:00:00`);
		let fecha_espanol = day.toLocaleDateString('es-ES', { weekday: 'short', year: 'numeric', month: 'numeric', day: 'numeric' });
		// console.log(fecha_espanol, fecha, day.getUTCDate());
		$(".fecha_seleccionada").empty();
		$(".fecha_seleccionada").append(fecha_espanol);
		let id = $("#servicio").val();
		let clubid = $("#clubes").val();
		let url = `/load/${fecha}/${id}/recintos/${clubid}`;
		// console.log(url);
		$.ajax({
			url: url,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response);
			$("#canvas").empty();
			$("#canvas").append(response);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			// console.log("complete");
			var $table = $('#tabla_ppal');
			console.log($table);
			/* console.log('error'); */
			buildTable($table);
		});
	}
	/* ########## AJAX NUEVOS ########## */
	$("#servicio2").change(function(event) {
		let id = $(this).val();
		let uri = `/load/${id}/recintos`;
		// console.log(uri);
		$.ajax({
			url: uri,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response);
			$("#recinto2").empty();
			$.each(response, function(index, val) {
				/* iterate through array or object */
				$("#recinto2").append(`
					<option value="${val.id}">${val.nombre}</option>
				`);
			});
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			loadAgendaModal();
		});

	});
	$("#rut").keyup(function(event) {
		let rut = $("#rut").val();
		let uri = `/load/${rut}/user`;
		if (rut.length > 9) {
			$.ajax({
				url: uri,
				type: 'GET',
			})
			.done(function(response) {
				if (!response) {
					/* ##### FALSO; SIN CLIENTE ##### */
					$("#resultQuery").hide();
				} else {
					// ##### USUARIO ENCONTRADO #####
					$("#resultQuery").empty();
					let str = `<label>Usuario ya existe con este rut</label>`;
					$("#resultQuery").append(`${str}`);
					$("#resultQuery").show();
				};
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
			});
		};
	});

	function loadAgendaModal () {
		resetValor();
		let date = $("#fecha_select").val()
		// console.log(date, 'test');
		if (date !== null && date != "") {
			$("#bloques").empty();
			let id = $("#recinto2").val();
			let cont = 0;
			$.ajax({
				url: `/load/${id}/agenda/${date}`,
				type: 'GET',
			})
			.done(function(response) {
				// console.log(response);
				$("#bloques").show();
				$.each(response, function(index, val) {
					let str = `<div class="col-4">
									<input class="horas" type="checkbox" value="${val.id}" ${(val.estado == 'Disponible') ? '' : 'disabled'} hidden name="horario_selected[]" id="horario_selected_${val.id}">
									<a class="hora ${(val.estado == 'Disponible') ? 'hora-personalizada' : 'no-disponible'}" id="hour_${val.id}" data-id="${val.id}" data-valor="${val.valor_hora}" onclick="return selecHora(${(val.estado == 'Disponible') ? val.id : 0}, this)">${val.hora_inicio_bloque} - ${val.hora_fin_bloque}</a>
								</div>`;
					$("#bloques").append(str);
				});
				loadConvenios();
			});
		}
	}
	var valor_total = 0, descuento = 0;
	function selecHora (id, el) {
		if (id == 0) { return; } // BLOQUEADOS PREVIAMENTE
		// let element = document.querySelector(`#hour_${id}`);
		// let current = $("#horario_selected").val(); // CUANDO ERA UNO SOLO
		// if (id != current) {
		// 	$(`#hour_${current}`).removeClass('no-disponible');
		// 	$(`#hour_${current}`).addClass('hora-personalizada');
		// };  // CUANDO ERA UNO SOLO ESTE IF
		// $("#horario_selected").val(id);  // CUANDO ERA UNO SOLO
		// console.log(element.classList.contains("no-disponible"), element);
		if ( $(`#hour_${id}`).hasClass('no-disponible') ) {
			valor_total = (valor_total - parseInt($(`#${el.id}`).attr('data-valor')));
			$(`#hour_${id}`).removeClass('no-disponible');
			$(`#hour_${id}`).addClass('hora-personalizada');
			$(`#horario_selected_${id}`).attr('checked', false);
		} else {
			valor_total = (valor_total + parseInt($(`#${el.id}`).attr('data-valor')));
			$(`#hour_${id}`).removeClass('hora-personalizada');
			$(`#hour_${id}`).addClass('no-disponible');
			/* ########## SELECCIONAR MAS DE UNO ########## */
			$(`#horario_selected_${id}`).attr('checked', true);
		};
		$(".valor_total").empty();
		// $(".valor_total").append(valor_total);
		if (valor_total > 0) {
			$(".valor_total").append(`$${new Intl.NumberFormat("de-DE").format(valor_total)}`);
			calcularDescuento();
		}
	}
	function resetValor () {
		valor_total = 0;
		descuento = 0;
		$(".valor_total").empty();
		$(".valor_total").append(`$${new Intl.NumberFormat("de-DE").format(valor_total)}`);
	}
	$("#fecha").change(function () {
		let date = $(this).val();
		$.ajax({
			url: `/load/${date}/estadisticas`,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response);
			$("#box_1").empty();
			$("#box_2").empty();
			$("#box_3").empty();
			$("#box_1").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.reservados)}`);
			$("#box_2").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.ocupados)}`);
			$("#box_3").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.libres)}`);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
	});
	$("#servicio").change(function () {
		let date = $("#fecha").val();
		let club = $("#clubes").val();
		let servicio = $(this).val();
		$.ajax({
			url: `/load/estadisticas/${date}/${club}/${servicio}`,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response);
			$("#box_1").empty();
			$("#box_2").empty();
			$("#box_3").empty();
			$("#box_1").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.reservados)}`);
			$("#box_2").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.ocupados)}`);
			$("#box_3").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.libres)}`);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
	});
	$("#clubes").change(function () {
		let date = $("#fecha").val();
		let club = $("#clubes").val();
		// let servicio = $(this).val();
		$.ajax({
			url: `/load/estadisticas/${date}/${club}`,
			type: 'GET',
		})
		.done(function(response) {
			console.log(response);
			$("#box_1").empty();
			$("#box_2").empty();
			$("#box_3").empty();
			$("#box_1").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.reservados)}`);
			$("#box_2").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.ocupados)}`);
			$("#box_3").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.libres)}`);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
		});
	});
	// $(".horario").click(function(event) {
	// 	let element = $(this);
	// 	// console.log(element.attr('data-agenda'), element[0]);
	// 	loadModalHorario(element.attr('data-agenda'));
	// });
	// let fecha = new Date(`${response.fecha}`);
	// console.log(fecha.toLocaleString());
	function loadModalHorario (agenda) {
		// console.log(agenda);
		// let id = agenda.dataset.agenda;//antiguo, con el this de la funcion directa
		let id = agenda;
		$.ajax({
			url: `/load/${id}/agenda`,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response);
			if (response.estado == 'Disponible') {
				$("#form_cancelar").attr('action', `/recintos/horarios/status/${btoa(id)}`);
			} else if (response.estado == "Bloqueado") {
				$("#form_cancelar").attr('action', `/recintos/horarios/status/${btoa(id)}`);
				$("#mbody_horario").empty();
				$("#mbody_horario").append(`
					<div class="row">
					<div class="col-12">
						<div class="card card-header">REACTIVAR HORARIO</div>
						<div class="card card-body">
							<div class="card-text">${response.dia}/${response.mes} ${response.hora_inicio_bloque} - ${response.hora_fin_bloque}</div>
							<div class="card-text">Estado  ${response.estado}</div>
							<div class="">
								<input type="hidden" value="${response.id}" name="agenda_id" />
								<div class=""></div><textarea class="form-control" name="comentario">${response.comentario ?? ''}</textarea>
							</div>
							<div  class="textocancelacion">
								<span id="mensajeerrorcanc" class="alert-danger"></span>
							</div>
							<div class="card card-footer">
								<button type="submit" class="btn btn-success pull-left text_save">Cambiar estado</button>
							</div>
						</div>
					</div>
				`);


				$("#mbody_horario_v").empty();
				$("#mbody_horario_v").append(`
					<div class="row">
					<div class="col-12">
						<div class="card card-header">INFORMACIÓN HORARIO</div>
						<div class="card card-body">
							<div class="card-text">${response.dia}/${response.mes} ${response.hora_inicio_bloque} - ${response.hora_fin_bloque}</div>
							<div class="card-text">Estado  ${response.estado}</div>
							
							<div  class="textocancelacion">
								<span id="mensajeerrorcanc" class="alert-danger"></span>
							</div>
							
						</div>
					</div>
				`);


				return;
			}
			$("#mbody_horario").empty();
			$("#mbody_horario").append(`
				<div class="row">
					<div class="col-12">
						<div class="card card-header">${response.recintos.nombre}</div>
						<div class="card card-body">
							<div class="card-text">${response.dia}/${response.mes} ${response.hora_inicio_bloque} - ${response.hora_fin_bloque}</div>
							<div class="card-text">Estado  ${response.estado}</div>
							${(response.estado !== 'Disponible') ? `<h6 class="card-text">Usuario: ${(response.reserva.users) ? response.reserva.users.full_name : 'Usuario no encontrado'} Valor: $${response.valor_hora}</h6>
						<div class="card card-footer">
							<div class="btn-group text-center">
								${(response.reserva.users) ?
									`<a class="btn btn-warning" onclick="return cancelHorario(${response.recintos.clubes_id}, ${response.id}, ${(response.reserva.users) ? response.reserva.users.id : 0});">Cancelar</a>
									${response.reserva.users ? `<button class="btn btn-primary" type="button" onclick="return reAgendar(${(response.reserva.users) ? response.reserva.users.id : 0}, ${response.id});">RE-AGENDAR</button><button class="btn btn-secondary" type="button"onclick="return cambiaEstadoPago(${response.id})">Estado Pago</button></div>` : ``}`
									: `Usuario no encontrado`}

						</div>`
							: `<div class="form-row m-2"><textarea class="form-control" name="comentario" placeholder="Comentario/motivos"></textarea></div>
							<div class="card card-footer">
								<div class="btn-group text-center"><button type="submit" class="btn btn-danger" onclick="return blockHorario();">Cambiar estado</button></div>
							</div>`}
						</div>
					</div>
				</div>
			`);




			$("#mbody_horario_v").empty();
			$("#mbody_horario_v").append(`
				<div class="row">
					<div class="col-12">
						<div class="card card-header">${response.recintos.nombre}</div>
						<div class="card card-body">
							<div class="card-text">${response.dia}/${response.mes} ${response.hora_inicio_bloque} - ${response.hora_fin_bloque}</div>
							<div class="card-text">Estado  ${response.estado}</div>
							${(response.estado !== 'Disponible') ? `<h6 class="card-text">Usuario: ${(response.reserva.users) ? response.reserva.users.full_name : 'Usuario no encontrado'} Valor: $${response.valor_hora}</h6>
						<div class="card card-footer">
							<div class="btn-group text-center">
								${(response.reserva.users) ?
									`<a class="btn btn-warning" onclick="return cancelHorario(${response.recintos.clubes_id}, ${response.id}, ${(response.reserva.users) ? response.reserva.users.id : 0});">Cancelar</a>
									${response.reserva.users ? `<button class="btn btn-primary" type="button" onclick="return reAgendar(${(response.reserva.users) ? response.reserva.users.id : 0}, ${response.id});">RE-AGENDAR</button><button class="btn btn-secondary" type="button"onclick="return cambiaEstadoPago(${response.id})">Estado Pago</button></div>` : ``}`
									: `Usuario no encontrado`}

						</div>`
							: `
							`}
						</div>
					</div>
				</div>
			`);

		})
	}

	function cancelHorario (clubid, agendaid, userid) {
		// console.log('cancela', clubid, agendaid, userid);
		//document.getElementById("botoncancelar").disabled = true;
		$("#mbody_motivos").empty();
		let action = `/cancelaciones/${userid}/cancela`;
		$("#form_motivos").attr('action', action);
		let str = ``;
		$.ajax({
			url: `/load/${clubid}/motivos`,
			type: 'GET',
		})
		.done(function(response) {
			$.each(response, function(index, val) {
				str += `<input type="radio" value="${val.id}" name="motivos_cancelaciones_id" >${val.motivo}</input><br>`;
			});
			let form = `
			<div class="">
				<input type="hidden" value="${agendaid}" name="agenda_id" />
				<div class="">${str}</div><textarea class="form-control" name="comentario"></textarea>
			</div>
			<div  class="textocancelacion">
				<span id="mensajeerrorcanc" class="alert-danger"></span>
			</div>
			`;
			$("#mbody_motivos").append(form);
		});
		$("#modalCancelar").modal("show");
	}

	function cambiaEstadoPago (data) {
		console.log(data);
		let action = `/agenda/${data}/cambiar-estado`;
		$("#form_pagos").attr('action', action);
		$("#modalPago").modal("show");
	}

	function valida(f) {
		document.getElementsByClassName('textocancelacion')[0].firstElementChild.innerHTML = '';
		document.getElementById("mensajeerrorcanc").style.display = "none";
		var ok = true;
		var msg = "";
		console.log(f);
		if(!document.querySelector('input[name="motivos_cancelaciones_id"]:checked')) {
			msg += "- Debe ingresar un motivo de cancelacion.\n";
			ok = false;
		}else{
			if (f.elements["motivos_cancelaciones_id"].value == 5 || f.elements["motivos_cancelaciones_id"].value == 9 ) {
				if(f.elements["comentario"].value == ""){
					msg += "- Debe ingresar un comentario.\n";
					ok = false;
				}
			}
		}

		if(ok == false)
			document.getElementsByClassName('textocancelacion')[0].firstElementChild.innerHTML = msg;
			document.getElementById("mensajeerrorcanc").style.display = "block";
			//alert(msg);

		return ok;
	}

	function validareaegnda(f) {
	document.getElementsByClassName('textoreagenda')[0].firstElementChild.innerHTML = '';
	document.getElementById("mensajeerrorreagen").style.display = "none";
	var ok = true;
	var msg = "Se encontraron los siguientes errores:";

	if(f.elements["servicio_3"].value == 0){
				msg += "<br>- Debe ingresar un Servicio.\n";
				ok = false;
	}


	if(f.elements["recintos_id"].value == 0){
				msg += "<br>- Debe ingresar un Recinto.\n";
				ok = false;
	}


	if(!document.querySelector('input[name="horario_selected[]"]:checked')){
				msg += "<br>- Debe ingresar un horario.\n";
				ok = false;
	}


	if(ok == false)
		document.getElementsByClassName('textoreagenda')[0].firstElementChild.innerHTML = msg;
		document.getElementById("mensajeerrorreagen").style.display = "block";
		//alert(msg);

	return ok;
	}


	function blockHorario () {
		// console.log('bloquea'); NO SE UTILIZA
	}
	function reAgendar (user, old) {
		let action = `/re-agendar/${user}/admin`;
		$("#form_reagenda").attr('action', action);
		$("#horario_antiguo").val(old);
		$("#modalReAgendar").modal("show");
	}
	$("#servicio_3").change(function(event) {
		let id = $(this).val();
		let uri = `/load/${id}/recintos`;
		// console.log(uri);
		$.ajax({
			url: uri,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response);
			$("#recinto_3").empty();
			$.each(response, function(index, val) {
				/* iterate through array or object */
				$("#recinto_3").append(`
					<option value="${val.id}">${val.nombre}</option>
				`);
			});
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			loadReAgendaModal();
			// console.log("complete");
		});

	});
	function loadReAgendaModal () {
		// resetValor();
		let date = $("#fecha_select_2").val()
		$("#bloques_2").empty();
		let id = $("#recinto_3").val();
		let cont = 0;
		$.ajax({
			url: `/load/${id}/agenda/${date}`,
			type: 'GET',
		})
		.done(function(response) {
			console.log(response);
			$("#bloques_2").show();
			$.each(response, function(index, val) {
				let str = `<div class="col-4">
								<input type="checkbox" value="${val.id}" ${(val.estado == 'Disponible') ? '' : 'disabled'} hidden name="horario_selected[]" id="horario_selected_${val.id}">
								<a class="hora ${(val.estado == 'Disponible') ? 'hora-personalizada' : 'no-disponible'}" id="hour_${val.id}" data-id="${val.id}" data-valor="${val.valor_hora}" onclick="return selecHora(${(val.estado == 'Disponible') ? val.id : 0}, this)">${val.hora_inicio_bloque} - ${val.hora_fin_bloque}</a>
							</div>`;
				$("#bloques_2").append(str);
			});
		})
	}
	function loadConvenios () {
		let user = $('#usr_id').val();
		let recinto = $("#recinto2").val();
		let url = `/load/${user}/convenios/${recinto}`;
		$.ajax({
			url: url,
			type: 'GET',
		})
		.done(function(response) {
			$("#bloque_convenios").empty();
			$("#bloque_convenios").append('Convenios disponibles<br>');
			$.each(response, function(index, val) {
				console.log(index, val);
				$("#bloque_convenios").append(`
					<input type="radio" name="recintos_convenio_id" value="${val.id}" data-porcentaje="${val.porcentaje ?? 0}" class="recinto"> ${val.porcentaje ?? 0}% - ${val.convenios.titulo}
				`);
			});
		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
	}

	function calcularDescuento(){
		var porcentaje = 0;
		$.each($('.recinto'), function(i, item) {
			if ($(this).is(':checked') ) {
				porcentaje = $(this).data('porcentaje');
				console.log(porcentaje);
			}
		});
		descuento = Math.round((porcentaje * valor_total) / 100);
		let total = valor_total - descuento;
		$('#porcent_dcto').text(`${porcentaje}%`);
		$('#valor_total').text(`$${new Intl.NumberFormat("de-DE").format(total)}`);
	}

	$(document).on('click', '.recinto', function(){
		calcularDescuento();
	});

	$(document).on('click', '#imprimir', function(){
		const printContents = document.getElementById('canvas').innerHTML;
		const originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	});

	$('#datos').click(function(){
		if ($('#dropdown').hasClass('show')) {
			$('#dropdown').removeClass('show');
			$('#dropdown-menu').removeClass('show');
		} else {
			$('#dropdown').addClass('show');
			$('#dropdown-menu').addClass('show');
		}
	});
	function validaragenda(f) {
		//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
		//document.getElementById("mensajeerroruser").style.display = "none";
		var ok = true;
		//var msg = "Se encontraron los siguientes errores:";

		// if(f.elements["exampleDataList"].value == ""){
		// 			//msg += "<br>- Debe ingresar un Nombre.\n";
		// 			document.getElementById("mostraruser").style.display = "block";
		// 			ok = false;
		// }else{
		// 	document.getElementById("mostraruser").style.display = "none";
		// }

		if(f.elements["email"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostraremaill").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostraremaill").style.display = "none";
		}

		if(f.elements["rut"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarrutt").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarrutt").style.display = "none";
		}

		if(f.elements["nombres"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostranombre").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostranombre").style.display = "none";
		}

		if(f.elements["apellido_paterno"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarapep").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarapep").style.display = "none";
		}

		if(f.elements["apellido_materno"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarapem").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarapem").style.display = "none";
		}

		if(f.elements["ciudad"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarciudad").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarciudad").style.display = "none";
		}

		if(f.elements["direccion"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrardirecci").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrardirecci").style.display = "none";
		}

		// if(f.elements["telefono"].value == ""){
		// 			//msg += "<br>- Debe ingresar un rut.\n";
		// 			document.getElementById("mostrartelefono").style.display = "block";
		// 			ok = false;
		// }else{
		// 	document.getElementById("mostrartelefono").style.display = "none";
		// }

		// if(f.elements["fecha_nacimiento"].value == ""){
		// 			//msg += "<br>- Debe ingresar un rut.\n";
		// 			document.getElementById("mostrarfnaci").style.display = "block";
		// 			ok = false;
		// }else{
		// 	document.getElementById("mostrarfnaci").style.display = "none";
		// }

		// var fecha_nacimiento = f.elements["fecha_nacimiento"].value
		// var hoy = new Date();
		// var cumpleanos = new Date(fecha_nacimiento);
		// var edad = hoy.getFullYear() - cumpleanos.getFullYear();
		// var m = hoy.getMonth() - cumpleanos.getMonth();
		// if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
		// 	edad--;
		// }
		// if(edad < 18){
		// 	if (document.getElementById('vaedad').checked){
		// 		document.getElementById("mostrarvaliedad").style.display = "none";

		// 	}else{
		// 		document.getElementById("mostrarvaliedad").style.display = "block";
		// 		ok = false;
		// 	}
		// }

		if(f.elements["servicio2"].value == "0"){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarservi").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarservi").style.display = "none";
		}

		if(f.elements["recinto2"].value == "0"){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarrecinto").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarrecinto").style.display = "none";
		}

		if(f.elements["fecha_select"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarfech").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarfech").style.display = "none";
		}

		//todos=document.getElementsByTagName('dias');
		todos = document.getElementsByClassName('horas');
		//console.log(todos);
		var cant = 0;
		for(x=0;x<todos.length;x++){
			if(todos[x].checked){
				cant++;
			}
		}

		if (cant==0) {
			document.getElementById("mostrarhoras").style.display = "block";
			ok = false;
		}else{
			document.getElementById("mostrarhoras").style.display = "none";
		}


		if(ok == false)
			//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = msg;
			//document.getElementById("mensajeerroruser").style.display = "block";
			//alert(msg);

		return ok;
	}
	function limpiarerroragenda() {
		document.getElementById("mostraruser").style.display = "none";
		document.getElementById("mostraremaill").style.display = "none";
		document.getElementById("mostrarrutt").style.display = "none";
		document.getElementById("mostranombre").style.display = "none";
		document.getElementById("mostrarapep").style.display = "none";
		document.getElementById("mostrarapem").style.display = "none";
		document.getElementById("mostrarciudad").style.display = "none";
		document.getElementById("mostrardirecci").style.display = "none";
		document.getElementById("mostrartelefono").style.display = "none";
		document.getElementById("mostrarfnaci").style.display = "none";
		document.getElementById("mostrarservi").style.display = "none";
		document.getElementById("mostrarrecinto").style.display = "none";
		document.getElementById("mostrarfech").style.display = "none";
		document.getElementById("mostrarhoras").style.display = "none";
		document.getElementById("mostrarvaliedad").style.display = "none";
		document.getElementById('vaedad').checked = false;
		var ok = true;

		return ok;
	}
	function calcularEdad() {
		var fecha_nacimiento = document.getElementById('fecha_nacimiento').value
		var hoy = new Date();
		var cumpleanos = new Date(fecha_nacimiento);
		var edad = hoy.getFullYear() - cumpleanos.getFullYear();
		var m = hoy.getMonth() - cumpleanos.getMonth();
		if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
			edad--;
		}
		if(edad >= 18){
			document.getElementById("validaredad").style.display = "none";
		}else{
			document.getElementById("validaredad").style.display = "block";
		}
	}
</script>



{{--  <script src="{{ asset('extensions/sticky-header/bootstrap-table-sticky-header.js') }}"></script> --}}  
@stop
