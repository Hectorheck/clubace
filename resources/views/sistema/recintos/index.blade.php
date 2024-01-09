@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Registrar Instalación
	@parent
@stop
{{-- page level styles --}}
@section('header_styles')
<!--plugin styles-->
<link rel="stylesheet" href="{{asset('vendors/intl-tel-input/css/intlTelInput.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrapvalidator/css/bootstrapValidator.min.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('vendors/sweetalert/css/sweetalert2.min.css')}}" />
<!--End of plugin styles-->
<!--Page level styles-->
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/sweet_alert.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/form_layouts.css')}}" />
<!-- end of page level styles -->

{{-- <!-- additions -->
<style>#mapa{border-radius:.25rem;min-height:250px;max-height:350px;height:-webkit-fill-available}</style> --}}
<!-- End additions -->
@stop
@section('content')
	<header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-sm-5 col-lg-6 skin_txt">
					<h4 class="nav_top_align">
						<i class="fa fa-pencil"></i>
						Registrar Instalación - {{ $servicio->nombre }}/{{ $servicio->clubes->display_name }}
					</h4>
				</div>
				<div class="col-sm-7 col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}"><i class="fa fa-home" data-pack="default" data-tags=""></i> Inicio</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route('servicios.index', $servicio->clubes->id) }}">Servicios</a>
						</li>
						<li class="active breadcrumb-item">Registrar Instalaciones - {{ $servicio->nombre }}</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="outer">
		<div class="inner bg-container">
			<div class="row">
				<div class="col-12 mt-3">
					<div class="card">
						<div class="card-header bg-white">Lista de Instalaciones</div>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped mt-3">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Observaciones</th>
											{{-- <th width="7%">Valor</th> --}}
											<th width="7%">Hora inicio</th>
											<th width="7%">Hora termino</th>
											<th></th>
										</tr>
									</thead>

									<tbody>
										@foreach ($recintos as $recinto)
										<tr>
											<td>{{ $recinto->nombre }}</td>
											<td>{{ $recinto->observaciones_privadas }}</td>
											{{-- <td>{{ number_format($recinto->tipo, 0, ',', '.') }}</td> --}}
											<td>{{ $recinto->hora_inicio ?? 'No registrado' }}</td>
											<td>{{ $recinto->hora_fin ?? 'No registrado' }}</td>
											<td align="center">
												<div class="btn-group">
													<a href="{{ route('recintos.edit', [$servicio, $recinto->id]) }}" class="btn btn-primary">Editar</a>
													<a href="{{ route('recintos.horarios', $recinto->id) }}" class="btn btn-success">Horarios</a>
													<a href="{{ route('recintos.transacciones', [$servicio, $recinto->id]) }}" class="btn btn-success">Transacciones</a>
													<button type="button" data-toggle="modal" data-target="#img-{{ $recinto->id }}" class="btn btn-secondary"><i class="fa fa-file-image-o"></i> Galeria</button>
													<button type="button" data-toggle="modal" data-target="#precios-{{ $recinto->id }}" class="btn btn-info"><i class="fa fa-clock-o"></i> Valores</button>
													@if(count($recinto->clubes->convenios) > 0)
													<button type="button" data-toggle="modal" data-target="#convenios-{{ $recinto->id }}" class="btn btn-warning"><i class="fa fa-handshake-o"></i> Convenios</button>
													@endif
													<a href="{{-- route('recintos.destroy', [$servicio, $recinto->id]) --}}" data-toggle="modal" data-target="#del-{{ $recinto->id }}" class="btn btn-danger">Eliminar</a>
												</div>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-6 mb-15">
								<button class="btn btn-success mb-15" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Nueva Instalación</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 mt-3 collapse" id="collapseExample">
					<div class="card">
						<div class="card-header bg-white">Registra una Instalación</div>

						<div class="card-body">
							<!-- checkbox -->
							<div class="justify-content-center">
								<form action="{{ route('recintos.store', $servicio->id) }}" method="POST" class="form-horizontal" onsubmit="return validarrecinto(this)">
									@method('PUT')
									@csrf
									<!-- Name input-->
									<div class="row form-group">
										<div class="col-12 col-md-4 mt-3">
											<label for="nombre" class="form-group-horizontal">Nombre</label>
											<div class="input-group">
												<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" value="{{ old('nombre') }}">
											</div>
											<span style="color: red;display:none;" id="mostrarnombre">Debe Ingresar un Nombre correspondiente</span>
										</div>

										<div class="col-12 col-md-6 mt-3" style="display: none;">
											<label for="valor" class="form-group-horizontal">Valor</label>
											<div class="input-group">
												<input type="text" name="valor" id="valor" class="form-control" placeholder="Valor" value="0" hidden>
											</div>
											<span style="color: red;display:none;" id="mostrarvalor">Debe Ingresar un Valor correspondiente</span>
										</div>

										<div class="col-12 col-md-4 mt-3">
											<label for="codigo" class="form-group-horizontal">Codigo</label>
											<div class="input-group">
												<input type="text" name="codigo" id="codigo" class="form-control" placeholder="Codigo" value="{{ old('codigo') }}">
											</div>
											<span style="color: red;display:none;" id="mostrarcod">Debe Ingresar un Codigo correspondiente</span>
										</div>

										<div class="col-12 col-md-4 mt-3">
											<label for="year" class="form-group-horizontal">Año de construccion</label>
											<div class="input-group">
												<input type="number" name="agno_construccion" id="year" class="form-control" placeholder="Año de construccion" value="{{ old('agno_construccion') }}">
											</div>
											<span style="color: red;display:none;" id="mostraraño">Debe Ingresar un Año de const. correspondiente</span>
										</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="obser_publicas" class="form-group-horizontal">Observaciones publicas</label>
											<div class="input-group">
												<textarea name="observaciones_publicas" id="obser_publicas" rows="4" class="form-control" placeholder="Observaciones publicas">{{ old('observaciones_publicas') }}</textarea>
											</div>
											<span style="color: red;display:none;" id="mostrarpub">Debe Ingresar una Observacion publica correspondiente</span>
										</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="obser_privadas" class="form-group-horizontal">Observaciones privadas</label>
											<div class="input-group">
												<textarea name="observaciones_privadas" id="obser_privadas" rows="4" class="form-control" placeholder="Observaciones privadas">{{ old('observaciones_privadas') }}</textarea>
											</div>
											<span style="color: red;display:none;" id="mostrarpriv">Debe Ingresar una Observacion privada correspondiente</span>
										</div>

										<div class="col-12 col-md-6 mt-3" hidden>
											<label for="tipo" class="form-group-horizontal">Tipo de clientela</label>
											<div class="input-group row">
												<div class="col-12 col-sm-6">
													<label class="custom-control custom-checkbox mr-3 d-inline">
														<input type="checkbox" name="socios" class="custom-control-input" checked>
														<span class="custom-control-label"></span>
														<span class="custom-control-description">Socio Club</span>
													</label>
												</div>

												<div class="col-12 col-sm-6">
													<label class="custom-control custom-checkbox mr-3 d-inline">
														<input type="checkbox" name="arriendo" class="custom-control-input" checked>
														<span class="custom-control-label"></span>
														<span class="custom-control-description">Arriendo</span>
													</label>
												</div>
											</div>
										</div>
										<div class="col-12 mt-3">
											<h3>Los siguientes datos permiten la creación de bloques horarios, posteriormente a esto no podrán ser editados.</h3>
										</div>

										<div class="col-12 col-md-4 mt-3">
											<label for="bloque_horario" class="form-group-horizontal">Bloque horario</label>
											<div class="input-group">
												<select name="bloque_horario" id="bloque_horario" class="form-control">
													{{-- @php
													$array = ['+45 minutes', '+80 minutes', '+1 hour +45 minutes'];
													list($hr, $cnt) = [0, 0];
													@endphp
													@while ($hr < 2)
													@php
													$min = $cnt % 2 == 0 ? '30' : '00';
													$array = $array + ['+'.$hr.' hour +'.$min.' minutes'];
													@endphp
													<option value="{{ '+'.$hr.' hour +'.$min.' minutes' }}" @if($hr=='1' && $min=='00') selected @endif>{{ $hr.' : '.$min.' Hr' }}</option>
													@php
													$cnt % 2 != 0 ? : $hr++;
													$cnt++;
													@endphp
													@endwhile --}}
													<option value="+0 hour +30 minutes">0 : 30 Hr</option>
													<option value="+0 hour +45 minutes">0 : 45 Hr</option>
													<option value="+1 hour +00 minutes" selected>1 : 00 Hr</option>
													<option value="+1 hour +20 minutes">1 : 20 Hr</option>
													<option value="+1 hour +30 minutes">1 : 30 Hr</option>
													<option value="+1 hour +45 minutes">1 : 45 Hr</option>
													<option value="+2 hour +00 minutes">2 : 00 Hr</option>
													<option value="+3 hour +00 minutes">3 : 00 Hr</option>
													<option value="+4 hour +00 minutes">4 : 00 Hr</option>
													<option value="+5 hour +00 minutes">5 : 00 Hr</option>
													<option value="+6 hour +00 minutes">6 : 00 Hr</option>
												</select>
											</div>
										</div>

										<div class="col-12 col-md-4 mt-3">
											<label for="hora_inicio" class="form-group-horizontal">Hora inicio</label>
											<div class="input-group">
												<input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="06:00" min="06:00">
											</div>
										</div>

										<div class="col-12 col-md-4 mt-3">
											<label for="hora_fin" class="form-group-horizontal">Hora fin</label>
											<div class="input-group">
												<input type="time" name="hora_fin" id="hora_fin" class="form-control" value="23:00" max="23:45">
											</div>
										</div>

										{{-- <div class="row form-group"> --}}
										<div class="col-12 card-title pt-3 head">
											<h4>Días de atención</h4>
										</div>

										<div class="col-12">
											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="1" checked>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Lunes</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="2" checked>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Martes</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="3" checked>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Miercoles</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="4" checked>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Jueves</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="5" checked>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Viernes</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="6" checked>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Sábado</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="7" checked>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Domingo</span>
											</label>
											<span style="color: red;display:none;" id="mostrardias">Debe Seleccionar Dias correspondiente</span>
										</div>
										{{-- </div> --}}
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Registrar</button>
										<button class="btn btn-warning" onclick="limpiarerror()" type="reset" id="clear">
											<i class="fa fa-refresh"></i>
											Limpiar
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.inner -->
	</div>
	<!-- /.outer -->
@stop

@foreach ($recintos as $recinto)
{{-- @php
$servicio = $recinto->servicios_id;
@endphp --}}
<div class="modal fade" id="del-{{ $recinto->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="container d-flex pl-0"><i class="fa fa-trash {{-- fa-2x --}}"></i>
					<h5 class="modal-title ml-2" id="exampleModalLabel">¿Seguro que desea borrar la Instalación {{ $recinto->nombre }}?</h5>
				</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<p class="text-muted">Si lo borras, se borrarán tambien los registros relacionados y no podras recuperarlos</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
				<a href="{{ route('recintos.destroy', [$servicio, $recinto->id]) }}" class="btn btn-danger">Borrar</a>
			</div>
		</div>
	</div>
</div>

{{-- MODAL GALERIA --}}
<div class="modal fade" id="img-{{ $recinto->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form method="post" enctype="multipart/form-data" action="{{ route('recintos.upload', $recinto->id) }}">
				@csrf
				@method('PUT')
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Imagen {{ $recinto->nombre }}</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					@php
					$carpeta = ('storage/recintos/'.$recinto->id);
					// $dir = opendir($carpeta);
					// while ($file = readdir($dir)) {
					// 	dump($file);
					// }
					if (is_dir($carpeta)) {
						$files = scandir($carpeta, SCANDIR_SORT_ASCENDING);
						// dump($files);
					} else {
						$files = [];
						// dump($files);
					}
					// dump($files);
					@endphp
					<div class="mb-3 row">
						@foreach($files as $file)
						@if($file != "." && $file != "..")
						<figure class="col-3">
							<a href="{{ route('recintos.eliminar', ['name' => $file,'id' => $recinto->id]) }}" class="close AClass btn-danger" style="border-radius:50%;width:25px;height:25px;text-align:center;opacity:1;color:#fff;text-shadow:none">
								<span>&times;</span>
							</a>
							<img class="rounded mx-auto d-block img-thumbnail" src="{{ asset($carpeta.'/'.$file) }}">
						</figure>
						@endif
						@endforeach
					</div>
					<div class="mb-3">
						<label for="formFile" class="form-label">Seleccione imagen</label>
						<input name="imagen[]" class="form-control" type="file" id="formFile" multiple>
						<span style="color: red;display:none;" id="mostrarimg">Debe Seleccionar una Imagen correspondiente</span>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
					<button class="btn btn-primary" type="submit">Subir IMG</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="precios-{{ $recinto->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form method="post" enctype="multipart/form-data" action="{{ route('recintos.store.precio', $recinto->id) }}" id="valoresForm_{{ $recinto->id }}">
				@csrf
				@method('PUT')
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Valores segun horas {{ $recinto->nombre }}</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					@php
					@endphp
					<div class="mb-3 row">
						<div class="card-body">
							<fieldset>
								<!-- Name input-->
								<div class="form-group row m-t-35">
									<div class="col-lg-3 text-lg-right">
										<label for="name3" class="col-form-label">Nombre</label>
									</div>
									<div class="col-lg-8">
										<div class="input-group input-group-prepend">
											<input type="text" name="nombre" id="nombre2" class="form-control" placeholder="Diurno, Nocturno...">
										</div>
										<span style="color: red;display:none;" id="mostrarnom">Debe registrar un Nombre correspondiente</span>
									</div>
								</div>
								<!-- first name-->
								<div class="form-group row">
									<div class="col-lg-3 text-lg-right">
										<label for="lastname3" class="col-form-label">Desde</label>
									</div>
									<div class="col-lg-8">
										<div class="input-group input-group-append">
											<input type="time" name="desde" class="form-control" min="{{ date('H:i', strtotime($recinto->hora_inicio)) }}">
										</div>
										<span style="color: red;display:none;" id="mostrardesde">Debe Ingresar una Hora correspondiente</span>
									</div>
								</div>
								<!-- last name-->
								<div class="form-group row">
									<div class="col-lg-3 text-lg-right">
										<label for="email3" class="col-form-label">Hasta</label>
									</div>
									<div class="col-lg-8">
										<div class="input-group input-group-prepend">
											<input type="time" name="hasta" class="form-control" max="{{ date('H:i', strtotime($recinto->hora_fin))}} ">
										</div>
										<span style="color: red;display:none;" id="mostrarhasta">Debe Ingresar una Hora correspondiente</span>
									</div>
								</div>
								<div class="form-group row m-t-35">
									<div class="col-lg-3 text-lg-right">
										<label for="name3" class="col-form-label">Precio</label>
									</div>
									<div class="col-lg-8">
										<div class="input-group input-group-prepend">
											<input type="number" name="precio" class="form-control" placeholder="Valor">
										</div>
										<span style="color: red;display:none;" id="mostrarprecio">Debe Ingresar un Precio correspondiente</span>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
					<div class="mb-3 row card-body">
						<table class="table table-striped table-bordered table-hover m-2">
							<thead>
								<th></th>
								<th>Nombre</th>
								<th>Desde</th>
								<th>hasta</th>
								<th>Precio</th>
								<th></th>
							</thead>
							<tbody id="responseValue_{{ $recinto->id }}">
								@foreach($recinto->precios as $key => $precio)
								<tr>
									<td>{{ ($key + 1) }}</td>
									<td>{{ $precio->nombre }}</td>
									<td>{{ $precio->desde }}</td>
									<td>{{ $precio->hasta }}</td>
									<td>{{ $precio->precio }}</td>
									<td align="center">
										<a href="#{{-- route('recintos.delete.precio', ['id' => $precio->id, 'recinto' => $recinto->id]) --}}" class="btn btn-danger" data-id="{{ $precio->id }}" onclick="eliminarDato(this, {{$precio->id}})">Eliminar</a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
					<button class="btn btn-primary" type="button" onclick="sendValores({{ $recinto->id }})">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
@if(count($recinto->clubes->convenios) > 0)
{{-- PONER LOS CONVENIOS HORIZONTAL --}}
<div class="modal fade" id="convenios-{{ $recinto->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="{{ route('convenios.add.recinto', $recinto->id) }}" method="post">
				@csrf
				@method('PUT')
				<div class="modal-header">
					<div class="container d-flex pl-0">
						<h5 class="modal-title ml-2" id="exampleModalLabel">Convenios del club?</h5>
					</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<div class="row">
						@foreach($recinto->clubes->convenios as $convenio)
						@php
						$data = $recinto->recintos_convenios->where('convenios_id', $convenio->id)->first();
						@endphp
						<div class="col-4 mt-3">
							<label class="text-muted">{{ $convenio->titulo }}</label>
						</div>
						<div class="col-8 mt-3">
							<input type="number" name="porcentaje[{{ $convenio->id }}]" class="form-control" placeholder="%000" min="0" max="100" value="{{ (is_null($data)) ? '' : $data->porcentaje }}">
						</div>
						@endforeach
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-success">Enviar</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
@endforeach

@section('footer_scripts')
<!--Plugin scripts-->
<script type="text/javascript" src="{{asset('vendors/intl-tel-input/js/intlTelInput.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/sweetalert/js/sweetalert2.min.js')}}"></script>
<!--End of Plugin scripts-->
<!--Page level scripts-->
<script type="text/javascript" src="{{asset('js/pages/form_layouts.js')}}"></script>
<script>
	function sendValores (id) {
		let data = $(`#valoresForm_${id}`).serialize();
		let action = $(`#valoresForm_${id}`).attr('action');
		$.ajax({
			url: action,
			type: 'POST',
			data: data,
			headers : 'Accept: application/json',
		})
		.done(function(response) {
			// console.log('exito',response);
			if (response.status == 1) {
				let row = `<tr>
					<td>#</td>
					<td>${response.valor.nombre}</td>
					<td>${response.valor.desde}</td>
					<td>${response.valor.hasta}</td>
					<td>${response.valor.precio}</td>
					<td align="center">
						<a href="#" class="btn btn-danger" onclick="eliminarDato(this, ${response.valor.id})">Eliminar</a>
					</td>
				</tr>`;
				$(`#responseValue_${id}`).append(row);
			} else {
				// MOSTRAR MENSAJE ALERTA ROJA
			}
		})
		.fail(function(response) {
			console.log('error',response.responseJSON.errors);
		})
		.always(function() {
			console.log("complete");
		});
	}
	function eliminarDato (e, id) {
		// e.parentNode.parentNode.remove()
		// let id = e.attr('data-id');
		$.ajax({
			url: `/recintos/delete/${id}/precio`,
			type: 'GET',
		})
		.done(function(response) {
			console.log(response);
			if (response.status == 0) {
				// no elimina
			} else if (response.status == 1) {
				e.parentNode.parentNode.remove();
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	}
	function validarrecinto(f) {
		//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
		//document.getElementById("mensajeerroruser").style.display = "none";
		var ok = true;
		//var msg = "Se encontraron los siguientes errores:";


		if(f.elements["nombre"].value == ""){
					//msg += "<br>- Debe ingresar un Nombre.\n";
					document.getElementById("mostrarnombre").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarnombre").style.display = "none";
		}

		if(f.elements["valor"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarvalor").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarvalor").style.display = "none";
		}

		if(f.elements["codigo"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarcod").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarcod").style.display = "none";
		}

		if(f.elements["year"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostraraño").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostraraño").style.display = "none";
		}

		if(f.elements["obser_publicas"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarpub").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarpub").style.display = "none";
		}

		if(f.elements["obser_privadas"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrarpriv").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarpriv").style.display = "none";
		}

		//todos=document.getElementsByTagName('dias');
		todos = document.getElementsByClassName('dias');
		//console.log(todos);
		var cant = 0;
		for(x=0;x<todos.length;x++){
			if(todos[x].checked){
				cant++;
			}
		}

		if (cant==0) {
			document.getElementById("mostrardias").style.display = "block";
			ok = false;
		}else{
			document.getElementById("mostrardias").style.display = "none";
		}







		if(ok == false)
			//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = msg;
			//document.getElementById("mensajeerroruser").style.display = "block";
			//alert(msg);

		return ok;
	}
	function limpiarerror() {
		//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
		//document.getElementById("mensajeerroruser").style.display = "none";
		document.getElementById("mostrarnombre").style.display = "none";
		document.getElementById("mostrarvalor").style.display = "none";
		document.getElementById("mostrarcod").style.display = "none";
		document.getElementById("mostraraño").style.display = "none";
		document.getElementById("mostrarpub").style.display = "none";
		document.getElementById("mostrarpriv").style.display = "none";
		document.getElementById("mostrardias").style.display = "none";
		var ok = true;

		return ok;
	}
	function validarimg(f) {
		//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
		//document.getElementById("mensajeerroruser").style.display = "none";
		var ok = true;
		//var msg = "Se encontraron los siguientes errores:";


		if(f.elements["formFile"].value == ""){
					//msg += "<br>- Debe ingresar un Nombre.\n";
					document.getElementById("mostrarimg").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarimg").style.display = "none";
		}


		if(ok == false)
			//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = msg;
			//document.getElementById("mensajeerroruser").style.display = "block";
			//alert(msg);

		return ok;
	}
	function validarprecio(f) {
		//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
		//document.getElementById("mensajeerroruser").style.display = "none";
		var ok = true;
		//var msg = "Se encontraron los siguientes errores:";


		if(f.elements["nombre2"].value == ""){
					//msg += "<br>- Debe ingresar un Nombre.\n";
					document.getElementById("mostrarnom").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarnom").style.display = "none";
		}

		if(f.elements["desde"].value == ""){
					//msg += "<br>- Debe ingresar un Nombre.\n";
					document.getElementById("mostrardesde").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrardesde").style.display = "none";
		}

		if(f.elements["hasta"].value == ""){
					//msg += "<br>- Debe ingresar un Nombre.\n";
					document.getElementById("mostrarhasta").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarhasta").style.display = "none";
		}

		if(f.elements["precio"].value == ""){
					//msg += "<br>- Debe ingresar un Nombre.\n";
					document.getElementById("mostrarprecio").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrarprecio").style.display = "none";
		}


		if(ok == false)
			//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = msg;
			//document.getElementById("mensajeerroruser").style.display = "block";
			//alert(msg);

		return ok;
	}
</script>
@stop
