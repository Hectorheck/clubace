@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Centro de notificaciones
	@parent
@stop
@section('header_styles')
<link href="{{asset('css/pages/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css">
<link type="text/css" rel="stylesheet" href="{{asset('vendors/modal/css/component.css')}}"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.4.1/dist/chart.min.js"></script>
@stop

@section('content')
<header class="head">
	<div class="main-bar">
		<div class="row no-gutters">
			<div class="col-lg-6">
				<h4 class="nav_top_align skin_txt">
					<i class="fa fa-file-o"></i>
					Lista de notificaciones
				</h4>
			</div>
		</div>
	</div>
</header>

<div class="outer">
	<div class="inner bg-container">
		<button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#normal">Nueva notificacion</button>
		&nbsp;
		<table class="table table-bordered" id="tabla_notis">
			<thead>
				<tr>
					<th width="10%" style="text-align: center;">Club</th>
					<th width="10%" style="text-align: center;">Titulo</th>
					<th width="60%" style="text-align: center;">Notificacion</th>
					<th width="10%" style="text-align: center;">Detalle</th>
					<th class="col col-lg-2" style="text-align: center;">Enviar</th>
				</tr>
			</thead>
			<tbody>
				@foreach($notificaciones as $noti)
				<tr>
					<td>{{ $noti->clubes->display_name }}</td>
					<td>{{ $noti->titulo }}</td>
					<td>{{ $noti->mensaje }}</td>
					<td>
						<div class="buttongroup text-center">
							<button type="button" class="btn btn-primary lista_users" data-toggle="modal" data-target="#enviadas" data-id="{{ $noti->id }}"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></i> {{ count($noti->users) }}</button>
							<button type="button" class="btn btn-secondary lista_leidos" data-toggle="modal" data-target="#leidas" data-id="{{ $noti->id }}"><i class="fa fa-eye" aria-hidden="true"></i></i></i> {{ count($noti->users->where('estado', 'leido')) }}</button>
						</div>
					</td>
					<td>
						@if($noti->creada == "manual")
						<div class="buttongroup text-center">
							<button type="button" data-toggle="modal" data-id="{{ $noti->id }}" data-target="#enviar" class="btn btn-success enviarbtn"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
							<button type="button" data-toggle="modal" data-id="{{ $noti->id }}" data-target="#enviarconvenio" class="btn btn-success enviarconveniobtn"><i class="fa fa-handshake-o" aria-hidden="true"></i></button>
							<a href="{{ route('notificaciones.delete', $noti->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
						</div>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		  </table>
	</div>
</div>

<div class="modal fade" id="normal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
			 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form class="form" method="post" action="{{route('notificaciones.store')}}" onsubmit="return validarnoti(this)">
				<div class="modal-header">
					<h4 class="modal-title" id="modalLabel">Registrar notificacion</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					@csrf
					<div class="form-group row m-t-25" id="div_clubes">
						<div class="col-lg-3 text-lg-right">
							<label for="u-name" class="col-form-label"> Club (es) *</label>
						</div>
						<div class="col-xl-6 col-lg-8">
							<div class="input-group input-group-prepend" id="multiple_close">
								<select class="form-control chzn-select" name="clubes_id[]" id="clubes_id" multiple size="3">
									@foreach(auth()->user()->getClubes() as $club)
									<option value="{{ $club->id }}">{{ $club->display_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<span style="color: red;display:none;" id="mostrarclub" class="form-group mx-sm-3 mb-2">Debe seleccionar un club correspondiente</span>
					<div class="form-group mx-sm-3 mb-2">
						<input type="text" name="titulo" id="titulo" placeholder="Titulo" class="form-control">
					</div>
					<span style="color: red;display:none;" id="mostrartitulo" class="form-group mx-sm-3 mb-2">Debe Ingresar un Titulo correspondiente</span>
					<div class="form-group mx-sm-3 mb-2">
						<textarea name="mensaje" id="mensaje" placeholder="Mensaje" class="form-control"></textarea>
					</div>
					<span style="color: red;display:none;" id="mostrarmsg" class="form-group mx-sm-3 mb-2">Debe Ingresar una Mensaje correspondiente</span>
					<div class="form-group mx-sm-3 mb-2">
						<select name="tipo" id="tipo" class="form-control">
							<option value="Informcion">Informacion</option>
						</select>
					</div>
					<span style="color: red;display:none;" id="mostrarinfo" class="form-group mx-sm-3 mb-2">Debe Ingresar una Informacion correspondiente</span>
					{{-- <button type="submit" class="btn btn-primary mb-2">Guardar</button> --}}
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary mb-2">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="enviar" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
			 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form class="form" id="form_send" method="post" action="{{--route('notificaciones.store')--}}">
				<div class="modal-header">
					<h4 class="modal-title" id="modalLabel">Enviar notificacion</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					@csrf
					@method('PUT')
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="10%" style="text-align:center;">#</th>
								<th width="70%" style="text-align:center;">Nombre</th>
								<th width="10%" style="text-align:center;">
									<label>
										<input type="checkbox" name="todos" id="todos">  Seleccionar todos
									</label>
								</th>
							</tr>
						</thead>
						<tbody id="tbody_users">
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary mb-2">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="enviarconvenio" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
			 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form class="form" id="form_sendconvenio" method="post" action="{{--route('notificaciones.store')--}}">
				<div class="modal-header">
					<h4 class="modal-title" id="modalLabel">Enviar notificacion Convenios</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					@csrf
					@method('PUT')
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="10%" style="text-align:center;">#</th>
								<th width="70%" style="text-align:center;">Nombre</th>
								<th width="70%" style="text-align:center;">Club</th>
								<th width="10%" style="text-align:center;">
									<label>
										<input type="checkbox" name="todosconvenios" id="todosconvenios">  Seleccionar todos
									</label>
								</th>
							</tr>
						</thead>
						<tbody id="tbody_usersconvenios">
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary mb-2">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="enviadas" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
			 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modalLabel">Notificaciones enviadas</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="10%" style="text-align:center;">#</th>
							<th width="70%" style="text-align:center;">Nombre</th>
							<th width="10%" style="text-align:center;">Fecha</th>
						</tr>
					</thead>
					<tbody id="tbody_enviadas">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				{{-- <button type="submit" class="btn btn-primary mb-2">Guardar</button> --}}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="leidas" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
			 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modalLabel">Notificaciones leidas</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="10%" style="text-align:center;">#</th>
							<th width="70%" style="text-align:center;">Nombre</th>
							<th width="10%" style="text-align:center;">Fecha leida</th>
						</tr>
					</thead>
					<tbody id="tbody_leidas">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				{{-- <button type="submit" class="btn btn-primary mb-2">Guardar</button> --}}
			</div>
		</div>
	</div>
</div>

@stop

@section('footer_scripts')
<script type="text/javascript" src="{{asset('vendors/datatables/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.responsive.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		/* ########## TABLA 2 ########## */
		var table = $('#tabla_notis');
		table.DataTable({
			dom: "<'text-right'B><f>lr<'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
			buttons: [
				'copy', 'csv', 'print'
			]
		});
	});
	function validarnoti(f) {
		//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
		//document.getElementById("mensajeerroruser").style.display = "none";
		var ok = true;
		//var msg = "Se encontraron los siguientes errores:";

		if(f.elements["titulo"].value == ""){
					//msg += "<br>- Debe ingresar un Nombre.\n";
					document.getElementById("mostrartitulo").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrartitulo").style.display = "none";
		}

		if(f.elements["mensaje"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarmsg").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarmsg").style.display = "none";
		}

		if(f.elements["tipo"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarinfo").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarinfo").style.display = "none";
		}

		if(f.elements["clubes_id"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarclub").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarclub").style.display = "none";
		}
		if(ok == false)
			//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = msg;
			//document.getElementById("mensajeerroruser").style.display = "block";
			//alert(msg);

		return ok;
	}

	$("#normal").on("hidden.bs.modal", function () {
		document.getElementById("mostrartitulo").style.display = "none";
		document.getElementById("mostrarmsg").style.display = "none";
		document.getElementById("mostrarinfo").style.display = "none";
		document.getElementById("mostrarclub").style.display = "none";
	});
	document.getElementById("todos").onclick = function(){
		let checkboxes = document.getElementsByName('user_id[]');
		for(let i = 0; i < checkboxes.length; i++) {
			if(this.checked){
				checkboxes[i].checked = true;
			}else{
				checkboxes[i].checked = false;
			}
		}
	}
    document.getElementById("todosconvenios").onclick = function(){
		let checkboxes = document.getElementsByName('convenio_id[]');
		for(let i = 0; i < checkboxes.length; i++) {
			if(this.checked){
				checkboxes[i].checked = true;
			}else{
				checkboxes[i].checked = false;
			}
		}
	}
	$(".enviarbtn").click(function(event) {
		/* enviarbtn Act on the event */
		let id = $(this).attr('data-id');
		let action = `/notificaciones/${id}/send`;
		let uri = `/notificaciones/${id}/users`;
		$("#form_send").attr('action', action);
		$("#tbody_users").empty();
		$.ajax({
			url: `/notificaciones/${id}/users`,
			type: 'GET',
		})
		.done(function(response) {
			console.log(uri, response);
			$.each(response, function(index, val) {
				$("#tbody_users").append(`
					<tr>
						<td>${index + 1}</td>
						<td>${val.full_name}</td>
						<td>
							<input type="checkbox" name="user_id[]" value="${val.id}" class="">
						</td>
					</tr>
				`);
			});
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
    $(".enviarconveniobtn").click(function(event) {
		/* enviarbtn Act on the event */
		let id = $(this).attr('data-id');
		let action = `/notificaciones/${id}/sendconvenio`;
		let uri = `/notificaciones/${id}/enviadasconvenio`;
		$("#form_sendconvenio").attr('action', action);
		$("#tbody_usersconvenios").empty();
		$.ajax({
			url: `/notificaciones/${id}/enviadasconvenio`,
			type: 'GET',
		})
		.done(function(response) {
			console.log(uri, response);
			$.each(response, function(index, val) {
				$("#tbody_usersconvenios").append(`
					<tr>
						<td>${index + 1}</td>
						<td>${val.titulo}</td>
						<td>${val.razon_social}</td>
						<td>
							<input type="checkbox" name="convenio_id[]" value="${val.id}" class="">
						</td>
					</tr>
				`);
			});
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
	$(".lista_users").click(function(event) {
		let id = $(this).attr('data-id');
		$("#tbody_enviadas").empty();
		$.ajax({
			url: `/notificaciones/${id}/enviadas`,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response.users);
			$.each(response.users, function(index, val) {
				var date = new Date(val.created_at);
				console.log(date);
				$("#tbody_enviadas").append(`
					<tr>
						<td>${index + 1}</td>
						<td>${val.user.full_name}</td>
						<td>${date.toLocaleDateString()}</td>
					</tr>
				`);
			});
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
	$(".lista_leidos").click(function(event) {
		let id = $(this).attr('data-id');
		$("#tbody_leidas").empty();
		$.ajax({
			url: `/notificaciones/${id}/leidas`,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response);
			$.each(response.users, function(index, val) {
				var date = new Date(val.leido);
				console.log(date);
				$("#tbody_leidas").append(`
					<tr>
						<td>${index + 1}</td>
						<td>${val.user.full_name}</td>
						<td>${date.toLocaleDateString()}</td>
					</tr>
				`);
			});
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
</script>
@endsection









