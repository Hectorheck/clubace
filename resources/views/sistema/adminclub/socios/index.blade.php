@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Socios
	@parent
@stop
{{-- page level styles --}}
@section('header_styles')
	<!--Plugin styles-->
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/select2/css/select2.min.css')}}"/>
	<link type="text/css" rel="stylesheet" href="{{asset('css/pages/dataTables.bootstrap.css')}}"/>
	<!--End of plugin styles-->
	<!--Page level styles-->
	<link type="text/css" rel="stylesheet" href="{{asset('css/pages/tables.css')}}"/>
	<!-- end of page level styles -->
	<style>
	.custom-file-label::after {
		content: "Buscar";
	}
	*:disabled {
    	cursor: no-drop;
	}
	.progress {
    	font-size: .90rem;
    }
	</style>
@stop
@section('content')
	<header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-lg-6 col-sm-4">
					<h4 class="nav_top_align">
						<i class="fa fa-user"></i>
						Listado de usuarios
					</h4>
				</div>
				<div class="col-lg-6 col-sm-8 col-12">
					<ol class="breadcrumb float-right  nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="#">Usuarios</a>
						</li>
						<li class="active breadcrumb-item">Listado de usuarios</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="outer">
		<div class="inner bg-container">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-header bg-white">
							Usuarios
							{{-- USUARIOS POR CONVENIO --}}
						</div>
						<div class="card-header bg-black">
							<div class="brn-group">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newUser"><i class="fa fa-user-plus" aria-hidden="true"></i> Nuevo</button>
								<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#masivoUser">Cargar masivo</button>
							</div>
						</div>
						<div class="card-body" id="tabs">
							<ul class="nav nav-tabs m-t-35">
								{{-- <li class="nav-item">
									<a class="nav-link active" href="#actuales" data-toggle="tab">Socios actuales</a>
								</li> --}}
								{{-- <li class="nav-item" id="themify_icon">
									<a class="nav-link" href="#pendientes" data-toggle="tab">Pendientes</a>
								</li>
								<li class="nav-item" id="ionicons_tab">
									<a class="nav-link" href="#rechazados" data-toggle="tab">Rechazados</a>
								</li> --}}
								<li class="nav-item" id="ionicons_tab">
									<a class="nav-link active" href="#usuarios" data-toggle="tab">Usuarios Activos</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#usuarios_conv" data-toggle="tab">Usuarios por convenio</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#entrenadores" data-toggle="tab">Entrenadores</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane" id="usuarios_conv">
									<div class="row">
										<div class="col-12">
											<div class="card-box">
												<table class="table  table-striped table-bordered table-hover dataTable no-footer" id="editable_table_2" role="grid">
													<thead>
													<tr role="row">
														<th class="sorting_asc wid-25" tabindex="0" rowspan="1" colspan="1">Nombres</th>
														<th class="sorting wid-25" tabindex="0" rowspan="1" colspan="1">E-Mail</th>
														{{-- <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Estado</th> --}}
														<th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Club</th>
														<th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Convenio</th>
														{{-- <th class="sorting wid-5" width="5%" tabindex="0" rowspan="1" colspan="1">Acciones</th> --}}
													</tr>
													</thead>
													<tbody>
														@foreach($users_conv as $user)
														@if(!is_null($user->users))
														{{-- @dump($users) --}}
														<tr role="row" class="even">
															<td class="sorting_1">{{ $user->users->nombres }}</td>
															<td>{{ $user->users->email }}</td>
															<td>{{ $user->convenios->clubes->display_name }}</td>
															<td>{{ $user->convenios->titulo }}</td>
															{{-- <td>
																<a href="#usuarios_conv" data-toggle="tooltip" data-placement="top" title="ACEPTAR"><i class="fa fa-check text-success"></i></a>
																&nbsp; &nbsp;
																<a class="delete hidden-xs hidden-sm" data-toggle="tooltip" data-placement="top" title="RECHAZAR" href="#usuarios_conv"><i class="fa fa-trash text-danger"></i></a>
															</td> --}}
														</tr>
														@endif
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane active" id="usuarios">
									<div class="row">
										<div class="col-12">
											<div class="card-box">
												<table class="table  table-striped table-bordered table-hover dataTable no-footer" id="editable_table_4" role="grid">
													<thead>
													<tr role="row">
														<th width="50%" class="sorting_asc wid-25" tabindex="0">Nombres</th>
														<th width="30%" class="sorting wid-25" tabindex="0">E-Mail</th>
														<th width="10%" class="sorting wid-25" tabindex="0"></th>
														{{-- <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Estado</th> --}}
														{{-- <th class="sorting wid-5" width="5%" tabindex="0" rowspan="1" colspan="1">Acciones</th> --}}
													</tr>
													</thead>
													<tbody>
														@foreach($usuarios as $user)
														<tr role="row" class="even">
															<td class="sorting_1">{{ $user->nombres }}</td>
															<td>{{ $user->email }}</td>
															<td align="center">
																<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCoach-{{ $user->id }}"> @if($user->tipo_usuarios_id == "5") <i class='fa fa-check'></i>   @else   @endif Entrenador</button>
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="entrenadores">
									<div class="row">
										<div class="col-12">
											<div class="card-box">
												<table class="table  table-striped table-bordered table-hover dataTable no-footer" id="editable_table_4" role="grid">
													<thead>
													<tr role="row">
														<th width="50%" class="sorting_asc wid-25" tabindex="0">Nombres</th>
														<th width="30%" class="sorting wid-25" tabindex="0">E-Mail</th>
														<th width="10%" class="sorting wid-25" tabindex="0">Club/es</th>
													</tr>
													</thead>
													<tbody>
														@foreach($entrenadores as $user)
														{{-- @if($user->clubes > 0) --}}
														<tr role="row" class="even">
															<td class="sorting_1">{{ $user->nombres }}</td>
															<td>{{ $user->email }}</td>
															<td>
																@foreach($user->clubes as $club) {{ !is_null($club->clubes) ? $club->clubes->display_name : '' }}<br> @endforeach
															</td>
														</tr>
														{{-- @endif --}}
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.outer -->
@foreach($usuarios as $user)
<div class="modal fade" id="modalCoach-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
			 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form action="{{ route('socios.upgrade', $user->id) }}" method="post">
			@csrf
			@method('PUT')
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="modalLabel">Actualizar usuario a "Entrenador"</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Seleccione club al cual desea asociar el usuario</p>
					@foreach(auth()->user()->getClubes() as $club)
					@php
					$var = $user->clubes->where('clubes_id', $club->id);
					@endphp
					<label class="text-muted">{{ $club->display_name }}
						<input type="checkbox" class="form-control" name="clubes_id[]" value="{{ $club->id }}" @if(count($var) > 0) checked @endif>
					</label>
					@endforeach
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary mb-2">Guardar</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endforeach
{{-- MODAL --}}
<div class="modal fade" id="infoUser" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
			 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modalLabel">Detalle del usuario</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row m-t-25">
					<div class="col-12 col-lg-3 text-lg-right">
						<label for="u-name" class="col-form-label">Nombres:  </label>
					</div>
					<div class="col-12 col-xl-6 col-lg-8"><span id="span_name"></span></div>
				</div>
				<div class="form-group row m-t-25">
					<div class="col-12 col-lg-3 text-lg-right">
						<label for="u-name" class="col-form-label">Email:  </label>
					</div>
					<div class="col-12 col-xl-6 col-lg-8"><span id="span_email"></span></div>
				</div>
				<div class="form-group row m-t-25">
					<div class="col-12 col-lg-3 text-lg-right">
						<label for="u-name" class="col-form-label">Rut:  </label>
					</div>
					<div class="col-12 col-xl-6 col-lg-8"><span id="span_rut"></span></div>
				</div>
				<div class="form-group row m-t-25">
					<div class="col-12 col-lg-3 text-lg-right">
						<label for="u-name" class="col-form-label">Fecha nacimiento:  </label>
					</div>
					<div class="col-12 col-xl-6 col-lg-8"><span id="span_date"></span></div>
				</div>
			</div>
			<div class="modal-footer">
				{{-- <button type="submit" class="btn btn-primary mb-2">Guardar</button> --}}
			</div>
		</div>
	</div>
</div>
{{-- NUEVO USUARIO --}}
<div class="modal fade" id="newUser" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="">
		<form method="post" action="{{ route('socios.create') }}" onsubmit="return validarsocio(this)">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">
						<i class="fa fa-info"></i> Nuevo usuario
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" id="mbody">
					<div class="input-group">
						<div class="container">
							<div class="row">
								<div class="col-12 mt-3 mb-3">
									<div class="form-row">

										<div class="col-12 mb-2">
											<input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                            <span style="color: red;display:none;" id="mostraremail">Debe Ingresar un Email correspondiente</span>
										</div>
                                        <div class="col-6 mb-2">
											<select class="form-control" name="tipo_usuarios_id" id="tipo_usuarios_id" placholder="Tipo Usuario"  required>
                                                <option value="0">Seleccione Tipo de Usuario</option>
                                                @foreach($tipos as $tipo)
                                                <option value="{{ $tipo->id }}" >{{ $tipo->tipo }}</option>
                                                @endforeach
                                            </select>
                                            <span style="color: red;display:none;" id="mostrartipouser">Debe Seleccionar un Tipo de Usuario correspondiente</span>
										</div>
										<div class="col-6 mb-2">
											<input type="text" name="rut" id="rut" class="rut form-control" placeholder="Rut">
                                            <span style="color: red;display:none;" id="mostrarrut">Debe Ingresar un Rut correspondiente</span>
										</div>
										<div class="col-6 mb-2">
											<input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombre">
                                            <span style="color: red;display:none;" id="mostrarnombre">Debe Ingresar un Nombre correspondiente</span>
										</div>
										<div class="col-6 mb-2">
											<input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" placeholder="Apellido paterno">
                                            <span style="color: red;display:none;" id="mostrarapep">Debe Ingresar un Apellido Paterno correspondiente</span>
										</div>
										<div class="col-6 mb-2">
											<input type="text" name="apellido_materno" id="apellido_materno" class="form-control" placeholder="Apellido materno">
                                            <span style="color: red;display:none;" id="mostrarapem">Debe Ingresar un Apellido Materno correspondiente</span>
										</div>
										<div class="col-6 mb-2">
											<input type="text" name="ciudad" id="ciudad" class="form-control" placeholder="Ciudad">
                                            <span style="color: red;display:none;" id="mostrarciudad">Debe Ingresar un Ciudad correspondiente</span>
										</div>
										<div class="col-6 mb-2">
											<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Direccion">
                                            <span style="color: red;display:none;" id="mostrardire">Debe Ingresar una Direccion correspondiente</span>
										</div>
										<div class="col-6 mb-2">
											<input type="text" name="telefono" id="telefono" class="form-control" placeholder="Telefono">
                                            <span style="color: red;display:none;" id="mostrarfono">Debe Ingresar un Telefono correspondiente</span>
										</div>
										<div class="col-6 mb-2">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text" id="basic-addon1">Fecha de nacimiento</span>
												</div>
												<input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" placeholder="Fecha de nacimiento" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                                                <span style="color: red;display:none;" id="mostrarfnacimiento">Debe Ingresar una Fecha de nacimiento correspondiente</span>
											</div>
										</div>
										<div class="col-6 mb-2">
											<input type="password" name="password" id="password" class="form-control" placeholder="Contraseña">
                                            <span style="color: red;display:none;" id="mostrarpassword">Debe Ingresar una Password correspondiente</span>
										</div>
										<div class="col-6 mb-2">
											<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirmar Contraseña">
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
					<button type="submit" class="btn btn-success pull-left text_save">Guardar</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal fade" id="masivoUser" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="">
		<form {{-- action="{{ route('socios.csv') }}" method="POST" enctype="multipart/form-data" --}} id="formCsv">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">
						<i class="fa fa-info"></i> Cargar CSV de Usuarios
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="">Tipo de usuario</label>
						<select name="tipo_usuario" id="tipo_usuario" class="form-control">
							<option>Entrenador</option>
							<option>Invitado</option>
						</select>
					</div>
					<div class="form-group" id="clubes">
						<label class="d-block">Seleccione club al cual desea asociar el usuario</label>
						@foreach(auth()->user()->getClubes() as $club)
						<label class="text-white mr-3 btn btn-primary">
							<input type="checkbox" name="clubes_id[]" value="{{ $club->id }}" style="top:2px;position:relative;">
							{{ $club->display_name }}
						</label>
						@endforeach
					</div>
					<div class="custom-file mb-3">
						<input type="file" name="csv" id="csv" class="form-control" required>
						<label for="csv" class="custom-file-label">Buscar archivo CSV</label>
					</div>
					<div class="progress" style="height: 20px;">
						<div class="progress-bar" id="progressbar" style="display: none; width: 0%;">0%</div>
						<div class="progress-bar" id="progressbar2" style="display: none; width: 0%;">0%</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger float-right" data-dismiss="modal">
						Cerrar
						<i class="fa fa-times"></i>
					</button>
					<a href="{{ asset('recursos/ejemplo.csv') }}" target="_new" class="btn btn-info float-right">CSV de Ejemplo</a>
					<button type="button" class="btn btn-success pull-left text_save cargarCsv">Cargar</button>
				</div>
			</div>
		</form>
	</div>
</div>
@stop
@section('footer_scripts')
	<!--Plugin scripts-->
	<script type="text/javascript" src="{{asset('vendors/select2/js/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/datatables/js/jquery.dataTables.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.responsive.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.buttons.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.colVis.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.print.min.js')}}"></script>
	<!--End of plugin scripts-->
	<!--Page level scripts-->
	<script type="text/javascript" src="{{asset('js/pages/users.js')}}"></script>
	<script src="{{ asset('js/validateRut.js') }}"></script>
	<!-- end page level scripts -->
	<script type="text/javascript">
		$(document).ready(function() {
			/* ########## TABLA 2 ########## */
			var table = $('#editable_table_2');
			table.DataTable({
				dom: "<'text-right'B><f>lr<'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
				buttons: [
					'copy', 'csv', 'print'
				]
			});
			var tableWrapper = $("#editable_table_wrapper_2");
			tableWrapper.find(".dataTables_length select").select2({
				showSearchInput: false //hide search box with special css class
			}); // initialize select2 dropdown
			$("#editable_table_wrapper_2 .dt-buttons .btn").addClass('btn-light').removeClass('btn-default');
			$(".dataTables_wrapper").removeClass("form-inline");
			$(".dataTables_paginate .pagination").addClass("float-right");
			/* ########## TABLA 3 ########## */
			var table = $('#editable_table_3');
			table.DataTable({
				dom: "<'text-right'B><f>lr<'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
				buttons: [
					'copy', 'csv', 'print'
				]
			});
			var tableWrapper = $("#editable_table_wrapper_3");
			tableWrapper.find(".dataTables_length select").select2({
				showSearchInput: false //hide search box with special css class
			}); // initialize select2 dropdown
			$("#editable_table_wrapper_3 .dt-buttons .btn").addClass('btn-light').removeClass('btn-default');
			$(".dataTables_wrapper").removeClass("form-inline");
			$(".dataTables_paginate .pagination").addClass("float-right");
			/* ########## TABLA 4 ########## */
			var table = $('#editable_table_4');
			table.DataTable({
				dom: "<'text-right'B><f>lr<'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
				buttons: [
					'copy', 'csv', 'print'
				]
			});
			var tableWrapper = $("#editable_table_wrapper_4");
			tableWrapper.find(".dataTables_length select").select2({
				showSearchInput: false //hide search box with special css class
			}); // initialize select2 dropdown
			$("#editable_table_wrapper_4 .dt-buttons .btn").addClass('btn-light').removeClass('btn-default');
			$(".dataTables_wrapper").removeClass("form-inline");
			$(".dataTables_paginate .pagination").addClass("float-right");
		});
		$(".InfoUserData").click(function(event) {
			let id = $(this).attr('data-id');
			$("#span_name").empty();
			$("#span_email").empty();
			$("#span_rut").empty();
			$("#span_date").empty();
			$.ajax({
				url: `/load/${id}/user/from-id`,
				type: 'GET',
			})
			.done(function(response) {
				// console.log(response);
				$("#span_name").append(`${response.nombres}`);
				$("#span_email").append(`${response.email}`);
				$("#span_rut").append(`${response.rut ?? 'No registrado'}`);
				$("#span_date").append(`${response.fecha_nacimiento ?? 'No registrado'}`);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		});
    function validarsocio(f) {
        //document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
        //document.getElementById("mensajeerroruser").style.display = "none";
        var ok = true;
        //var msg = "Se encontraron los siguientes errores:";

        if(f.elements["email"].value == ""){
                    //msg += "<br>- Debe ingresar un Nombre.\n";
                    document.getElementById("mostraremail").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostraremail").style.display = "none";
        }

        if(f.elements["nombres"].value == ""){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostrarnombre").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarnombre").style.display = "none";
        }

        if(f.elements["rut"].value == ""){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostrarrut").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarrut").style.display = "none";
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
                    document.getElementById("mostrardire").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrardire").style.display = "none";
        }

        if(f.elements["telefono"].value == ""){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostrarfono").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarfono").style.display = "none";
        }

        if(f.elements["fecha_nacimiento"].value == ""){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostrarfnacimiento").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarfnacimiento").style.display = "none";
        }



        if(f.elements["password"].value == ""){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostrarpassword").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarpassword").style.display = "none";
        }

        if(f.elements["tipo_usuarios_id"].value == "0"){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostrartipouser").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrartipouser").style.display = "none";
        }


        if(ok == false)
            //document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = msg;
            //document.getElementById("mensajeerroruser").style.display = "block";
            //alert(msg);

        return ok;
    }

	$('#tipo_usuario').change(function () {
		if (this.value == "Entrenador") {
			$('#clubes').fadeIn(300);
		} else {
			$('#clubes').fadeOut(300);
		}
	});
	function loading(){
		var time = 400;
		$.each(new Array(101), function(n) {
		    setTimeout(function(){
		    	$('#progressbar').css('width', n+'%').text(n+'%');
		    }, time);
		    time += 400;
		});
	}

	$('.cargarCsv').click(function(){
		var form = $('#formCsv')[0];
        var data = new FormData(form);
        let self = $(this);
        self.prop("disabled", true);

		$.ajax({
            type: "POST",
            enctype: "multipart/form-data",
            url: "{{ route('socios.csv') }}",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            beforeSend: function () {
                $('#progressbar2').css('display', 'none');
		        $('#progressbar2').css('width', '0%').text('0%');
		        $('#progressbar').css('display', 'inherit');
		        loading();
            },
            success: function (resp) {
				$('#progressbar2').css('display', 'inherit');
				$('#progressbar2').css('width', '100%').text('100%');
	        	$('#progressbar').css('display', 'none');
	        	$('#progressbar').css('width', '100%').text('100%');
	        	alert('Archivo cargado correctamente');

	        	setTimeout(function () {
	        		$('#masivoUser').modal('toggle');
	        	}, 2000);
            },
        })
        .fail(function(e) {
        	alert(e.responseJSON.errors);

            $('#progressbar2').css('display', 'inherit');
			$('#progressbar2').css('width', '0%').text('0%');
        	$('#progressbar').css('display', 'none');
        	$('#progressbar').css('width', '0%').text('0%');

        	location.reload();
			return;
        })
        .always(function() {
        	self.removeAttr("disabled");
        });
	});
</script>
@stop
