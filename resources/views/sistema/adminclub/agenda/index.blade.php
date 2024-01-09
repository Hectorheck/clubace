@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Agendar multiples bloques
	@parent
@stop

@section('content')

	<header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-sm-5 col-lg-6 skin_txt">
					<h4 class="nav_top_align">
						<i class="fa fa-pencil"></i>
						Agendar multiples bloques para entrenadores
					</h4>
				</div>
				<div class="col-sm-7 col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
							</a>
						</li>
					</ol>
				</div>
			</div>
		</div>
	</header>

	<div class="outer">
		<div class="inner bg-container">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<form method="post" action="{{ route('multi.store') }}" id="form_1" onsubmit="return validarae(this)">
							@csrf
							<div class="card-header bg-white">Registra</div>
							<div class="card-body">
								<div class="row">
									<div class="col-12">
										<label for="exampleDataList" class="form-label">Seleccione entrenador</label>
										<input class="form-control" {{-- name="clientes_id" --}} list="datalistOptions" id="exampleDataList" name="exampleDataList" value="{{old('exampleDataList')}}" placeholder="Buscar por nombre...">
										<datalist id="datalistOptions" style="overflow: scroll">
											@foreach($users as $user)
											<option value="{{ $user->full_name }}" data-id="{{ $user->id }}"></option>
											@endforeach
										</datalist>
										<input type="hidden" name="usr_id" id="usr_id">
										<span style="color: red;display:none;" id="mostrarexampleDataList" class="form-group mx-sm-3 mb-2">Debes seleccionar un Entrenador correspondiente</span>
									</div>
									<div class="col-2 mt-2" style="text-align: center">
										<label for="cuadro" >Club: </label>
									</div>
									<div class="col-4 mt-2">
										<select class="form-control" name="clubes" id="clubes">
											<option value="0">Todos</option>
											@foreach(auth()->user()->getClubes() as $club)
												<option value="{{ $club->id }}"> {{ $club->display_name}}</option>
											@endforeach
										</select>
										<span style="color: red;display:none;" id="mostrarclubes" class="form-group mx-sm-3 mb-2">Debes seleccionar un Club correspondiente</span>
									</div>
									<div class="col-2 mt-2" style="text-align: center">
										<label for="cuadro" >Servicio: </label>
									</div>
									<div class="col-4 mt-2">
										<select class="form-control" name="servicio" id="servicio">
											<option value="0">Seleccione</option>
											{{-- @foreach(auth()->user()->getServicios() as $servicio)
												<option value="{{ $servicio->id }}"> {{ $servicio->nombre}}</option>
											@endforeach --}}
										</select>
										<span style="color: red;display:none;" id="mostrarservicio" class="form-group mx-sm-3 mb-2">Debes seleccionar un Servicio correspondiente</span>
									</div>
									<div class="col-12 mt-2">
										<div class="col-lg input_field_sections">
											<label>Instalaciones</label>
											<select size="3" multiple class="form-control chzn-select" name="recintos[]" id="recintos" name="test_me_form" tabindex="8">
												{{-- @foreach(auth()->user()->getRecintos() as $recinto)
												<option value="{{ $recinto->id }}">{{ $recinto->nombre }}</option>
												@endforeach --}}
											</select>
										</div>
										<span style="color: red;display:none;" id="mostrarrecintos" class="form-group mx-sm-3 mb-2">Debes seleccionar una Instalacion correspondiente</span>
									</div>
									<div class="col-6 mt-2">
										<label class="custom-control custom-checkbox mr-3 d-inline">
											<input type="checkbox" name="dias[]" class="custom-control-input dias" value="1">
											<span class="custom-control-label"></span>
											<span class="custom-control-description">Lunes</span>
										</label>

										<label class="custom-control custom-checkbox mr-3 d-inline">
											<input type="checkbox" name="dias[]" class="custom-control-input dias" value="2">
											<span class="custom-control-label"></span>
											<span class="custom-control-description">Martes</span>
										</label>

										<label class="custom-control custom-checkbox mr-3 d-inline">
											<input type="checkbox" name="dias[]" class="custom-control-input dias" value="3">
											<span class="custom-control-label"></span>
											<span class="custom-control-description">Miercoles</span>
										</label>

										<label class="custom-control custom-checkbox mr-3 d-inline">
											<input type="checkbox" name="dias[]" class="custom-control-input dias" value="4">
											<span class="custom-control-label"></span>
											<span class="custom-control-description">Jueves</span>
										</label>

										<label class="custom-control custom-checkbox mr-3 d-inline">
											<input type="checkbox" name="dias[]" class="custom-control-input dias" value="5">
											<span class="custom-control-label"></span>
											<span class="custom-control-description">Viernes</span>
										</label>

										<label class="custom-control custom-checkbox mr-3 d-inline">
											<input type="checkbox" name="dias[]" class="custom-control-input dias" value="6">
											<span class="custom-control-label"></span>
											<span class="custom-control-description">Sábado</span>
										</label>

										<label class="custom-control custom-checkbox mr-3 d-inline">
											<input type="checkbox" name="dias[]" class="custom-control-input dias" value="7">
											<span class="custom-control-label"></span>
											<span class="custom-control-description">Domingo</span>
										</label>
										<span style="color: red;display:none;" id="mostrardias" class="form-group mx-sm-3 mb-2">Debes seleccionar Dias correspondiente</span>
									</div>
									<div class="col-6">
										<label for="">Estado pago</label>
										<select class="form-control" name="estado" required>
											<option value="Pendiente de Pago">Pendiente de Pago</option>
											<option value="Facturación Mensual">Facturación Mensual</option>
											<option value="Pagado">Pagado</option>
											{{-- <option value="Cancelado">Cancelado</option> --}}
										</select>
									</div>
									<div class="col-4 mt-2">
										<label>Semanas</label><input type="number" name="semanas" id="semanas" min="1" max="8" class="form-control" value="{{old('semanas')}}" >
										<span style="color: red;display:none;" id="mostrarsemanas" class="form-group mx-sm-3 mb-2">Debes seleccionar Semanas correspondiente</span>
									</div>
									<div class="col-4 mt-2">
										<label>Hora Inicio Bloque</label><input type="time" name="inicio" id="inicio" class="form-control" value="{{old('inicio')}}" >
										<span style="color: red;display:none;" id="mostrarinicio" class="form-group mx-sm-3 mb-2">Debes seleccionar hora inicio correspondiente</span>
									</div>
									<div class="col-4 mt-2">
										<label>Hora Fin Bloque</label><input type="time" name="fin" id="fin" class="form-control" value="{{old('fin')}}" >
										<span style="color: red;display:none;" id="mostrarfin" class="form-group mx-sm-3 mb-2">Debes seleccionar hora fin correspondiente</span>
									</div>
								</div>
							</div>
							<div>
								<button type="submit" class="btn btn-success m-2" id="save_form" {{-- disabled --}}>Guardar</button>
								<button class="btn btn-warning" onclick="limpiarerror()" type="reset" id="clear">
									<i class="fa fa-refresh"></i>
									Limpiar
								</button>
								<button type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#modalAgenda" onclick="return horariosDisponibles()">Ver horarios disponibles</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="outer">
		<div class="inner bg-container">
			{{-- <table class="table table-bordered" id="preview">
			</table> --}}
		</div>
	</div>
	{{-- <div class="outer">
		<div class="inner bg-container">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="" style="text-align: center;">#</th>
						<th width="" style="text-align: center;">Usuario</th>
						<th width="" style="text-align: center;">Recinto</th>
						<th width="" style="text-align: center;">Fechas</th>
						<th width="" style="text-align: center;">Horas</th>
						<th width="" style="text-align: center;">Dias</th>
						<th width="5%" style="text-align: center;">Cantidad bloques</th>
						<th width="5%" style="text-align: center;">Detalle</th>
						<th width="5%" style="text-align: center;">Eliminar</th>
					</tr>
				</thead>
				<tbody>
					@foreach($agendas as $key => $agenda)
					@if(!is_null($agenda->users))
					@php
					$days = [1=>'Lunes',2=>'Martes',3 =>'Miércoles',4=>'Jueves',5=>'Viernes',6=>'Sábado',7=>'Domingo'];
					$dias = explode(',', $agenda->dias);
					@endphp
					<tr>
						<td align="center">{{ ($key + 1) }}</td>
						<td align="center">{{ $agenda->users->full_name }}</td>
						<td align="center">{{ $agenda->recintos->nombre }}</td>
						<td align="center">
							{{ date('d-m-Y', strtotime($agenda->fecha_inicio)).'/'.date('d-m-Y', strtotime($agenda->fecha_termino)) }}
						</td>
						<td align="center">{{ $agenda->hora_inicio.'/'.$agenda->hora_termino }}</td>
						<td>@foreach($dias as $day)  {{ $days[$day] }} @endforeach</td>
						<td align="center"><span>{{ count($agenda->agendas) }}</span></td>
						<td align="center">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bloques-{{ $agenda->id }}"><i class="fa fa-list" aria-hidden="true"></i></button>
						</td>
						<td>
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-{{ $agenda->id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
						</td>
					</tr>
					@endif
					@endforeach
				</tbody>
			  </table>
		</div>
	</div> --}}

<div class="modal fade" id="modalAgenda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="container d-flex pl-0">
					<h5 class="modal-title ml-2" id="exampleModalLabel">Vista previa de horarios disponibles</h5>
				</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<p class="text-muted" id="texto_warning"></p>
				<table class="table table-bordered" id="preview">
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
				{{-- <a href="{{ route('multi.delete', $agenda->id) }}" class="btn btn-danger">Borrar</a> --}}
			</div>
		</div>
	</div>
</div>

@foreach($agendas as $key => $agenda)
{{-- <div class="modal fade" id="bloques-{{ $agenda->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post" action="">
				@csrf
				<div class="modal-header">
					<div class="container d-flex pl-0">
						<i class="fa fa-pencil" aria-hidden="true"></i>
						<h5 class="modal-title ml-2" id="exampleModalLabel">Lista de bloques agendados</h5>
					</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="10%">#</th>
								<th width="30%">Info</th>
								<th width="60%">Detalle</th>
							</tr>
						</thead>
						<tbody>
							@foreach($agenda->agendas as $key => $bloque)
							<tr>
								<td>{{ $key + 1 }}</td>
								<td align="center">{{ date('d-m-Y', strtotime($bloque->fecha)).' - '.$bloque->bloque }}</td>
								<td align="center">
									Valor ${{ number_format($bloque->valor_hora, 0, ',', '.') }} {{ ($bloque->reserva) ? $bloque->reserva->estado : 'No hay reserva' }} {{ ($bloque->reserva->users) ? $bloque->reserva->users->full_name : 'Usuario no encontrado' }}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
				</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="delete-{{ $agenda->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="container d-flex pl-0"><i class="fa fa-trash"></i>
					<h5 class="modal-title ml-2" id="exampleModalLabel">¿Seguro que desea borrar el registro?</h5>
				</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<p class="text-muted">Si lo borras, este dato no se podrá recuperar, los bloques agendados por el usuario serán liberados</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
				<a href="{{ route('multi.delete', $agenda->id) }}" class="btn btn-danger">Borrar</a>
			</div>
		</div>
	</div>
</div> --}}
@endforeach

@stop
@section('footer_scripts')

<script type="text/javascript">
	window.onload = function() {
		let uri = `/load/0/servicios`;
		$.ajax({
			url: uri,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response);
			$("#servicio").empty();
			$("#servicio").append(`<option value="0">Seleccione</option>`);
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
	};
	function horariosDisponibles () {
		$("#preview").empty();
		let form = $("#form_1").serialize();
		let semanas = $("#semanas").val();
		let inicio = $("#inicio").val();
		let fin = $("#fin").val();
		if (semanas != '' || inicio != '' || fin != '') {
			$("#texto_warning").empty();
			$.ajax({
				url: `/multi-agenda/load/data`,
				type: 'POST',
				data: form,
			})
			.done(function(response) {
				console.log(response);
				$("#preview").show();
				$("#preview").append(`
					<thead>
						<tr>
							<td colspan="2">Total ${response.total}</td>
							<td colspan="2">Reservados ${response.reservados}</td>
							<td colspan="2">Disponibles ${response.disponibles}</td>
						</tr>
					</thead>
					total :${response.total}
				`);
				$.each(response.agenda, function(index, val) {
					$("#preview").append(`
						<tr>
							<td>#${index + 1}</td>
							<td>${(val.recintos) ? val.recintos.nombre : ''}</td>
							<td>Bloque ${val.bloque}</td>
							<td>Fecha ${val.fecha}</td>
							<td>valor $${val.valor_hora}</td>
							<td>${val.estado}</td>
						</tr>
					`);
				});
			})
			.fail(function() {
				// console.log("error");
			})
			.always(function() {
				// console.log("complete");
			});
		} else {
			$("#texto_warning").empty();
			$("#texto_warning").append('Faltan datos, por favor llene el formulario');
			console.log('Faltan datos, por favor llene el formulario');
		}
	}
	$('#exampleDataList').on('input', function() {
		let value = $(this).val();
		let id = $(`#datalistOptions [value ="${value}"]`).data('id');
		let id2 = $(`#datalistOptions [value ="${value}"]`).attr('data-id');
		// console.log(id, value, id2);FUNCIONAN LOS TRES!3
		if (typeof id === 'undefined') {
			console.log('valor no valido');
			$("#usr_id").val('');
		} else {
			console.log('valor valido');
			$("#usr_id").val(id);
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
			$("#servicio").append(`<option value="0">Seleccione</option>`);
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
	$("#servicio").change(function(event) {
		let id = $(this).val();
		let uri = `/load/${id}/recintos`;
		// console.log(uri);
		$.ajax({
			url: uri,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response);
			$("#recintos").empty();
			$.each(response, function(index, val) {
				/* iterate through array or object */
				$("#recintos").append(`
					<option value="${val.id}">${val.nombre}</option>
				`);
			});
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			// loadAgendaModal();
		});
	});
	function validarae(f) {
		//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
		//document.getElementById("mensajeerroruser").style.display = "none";
		var ok = true;
		//var msg = "Se encontraron los siguientes errores:";

		if(f.elements["exampleDataList"].value == ""){
					//msg += "<br>- Debe ingresar un Nombre.\n";
					document.getElementById("mostrarexampleDataList").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarexampleDataList").style.display = "none";
		}

		if(f.elements["clubes"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarclubes").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarclubes").style.display = "none";
		}

		if(f.elements["servicio"].value == 0){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarservicio").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarservicio").style.display = "none";
		}

		if(f.elements["recintos"].value == 0){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarrecintos").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarrecintos").style.display = "none";
		}

		// if(f.elements["dias"].checked == false){
		//             //msg += "<br>- Debe ingresar un rut.\n";
		//             document.getElementById("mostrardias").style.display = "block";
		//             ok = false;
		// }else{
		//     document.getElementById("mostrardias").style.display = "none";
		// }

		//this es el formulario

		//todos=document.getElementsByTagName('dias');
		todos = document.getElementsByClassName('dias');
		//console.log(todos);
		var cant = 0;
		for(x=0;x<todos.length;x++){
			if(todos[x].checked){
				cant++;
				console.log("hola");
			}
		}

		if (cant==0) {
			document.getElementById("mostrardias").style.display = "block";
			ok = false;
		}else{
			document.getElementById("mostrardias").style.display = "none";
		}



		if(f.elements["semanas"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarsemanas").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarsemanas").style.display = "none";
		}

		if(f.elements["inicio"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarinicio").style.display = "block";
					ok = false;
		}else{
					document.getElementById("mostrarinicio").style.display = "none";

		}

		if(f.elements["fin"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarfin").style.display = "block";
					ok = false;
		}else{
					document.getElementById("mostrarfin").style.display = "none";

		}







		if(ok == false)
			//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = msg;
			//document.getElementById("mensajeerroruser").style.display = "block";
			//alert(msg);

		return ok;
	}
	function limpiarerror() {
		document.getElementById("mostrarexampleDataList").style.display = "none";
		document.getElementById("mostrarclubes").style.display = "none";
		document.getElementById("mostrarservicio").style.display = "none";
		document.getElementById("mostrarrecintos").style.display = "none";
		document.getElementById("mostrardias").style.display = "none";
		document.getElementById("mostrarsemanas").style.display = "none";
		document.getElementById("mostrarinicio").style.display = "none";
		document.getElementById("mostrarfin").style.display = "none";
		var ok = true;

		return ok;
	}
</script>



@stop




