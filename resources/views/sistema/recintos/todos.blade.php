{{-- @dd($recintos) --}}
@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Instalaciones
	@parent
@stop
@section('header_styles')
<link type="text/css" rel="stylesheet" href="{{asset('vendors/Buttons/css/buttons.min.css')}}"/>
<!--End of global styles-->
<!--Page level styles-->
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/buttons.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/dataTables.bootstrap.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/tables.css')}}"/>
@stop
@section('content')
<!-- Content Header (Page header) -->
<header class="head">
	<div class="main-bar">
		<div class="row no-gutters">
			<div class="col-lg-6">
				<h4 class="nav_top_align skin_txt"><i class="fa fa-book"></i> Instalaciones</h4>
			</div>
			<div class="col-lg-6">
				<ol class="breadcrumb float-right nav_breadcrumb_top_align">
					<li class="breadcrumb-item">
						<a href="{{ route('/') }}">
							<i class="fa ti-file" data-pack="default" data-tags=""></i>Inicio
						</a>
					</li>
					<li class="breadcrumb-item active">Instalaciones</li>
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
					<div class="card-header bg-white">Lista de Instalaciones</div>
					<div class="card-body p-t-25">
						<div class="">
							<div class="pull-sm-right">
								<div class="tools pull-sm-right"></div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
									<tr>
										<th width="15%">Club/Servicio</th>
										<th width="15%">Nombre</th>
										<th width="15%">Observaciones</th>
										{{-- <th width="6%">Valor</th> --}}
										<th width="6%">Hora inicio</th>
										<th width="6%">Hora termino</th>
										<th width="">Acciones</th>
									</tr>
								</thead>

								<tbody>
									@foreach ($recintos as $recinto)
									@php
									$servicio = $recinto->servicios_id;
									@endphp
									<tr>
										<td>
											{{ !is_null($recinto->clubes) ? $recinto->clubes->display_name : '' }}/
											{{ !is_null($recinto->servicios) ? $recinto->servicios->nombre : '' }}
										</td>
										<td>{{ $recinto->nombre }}</td>
										<td>{{ $recinto->observaciones_privadas }}</td>
										{{-- <td>{{ number_format($recinto->valor, 0, ',', '.') }}</td> --}}
										<td>{{ $recinto->hora_inicio }}</td>
										<td>{{ $recinto->hora_fin }}</td>
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
				</div>
			</div>
		</div>
	</div>
	<!-- /.inner -->
</div>
@stop

@foreach ($recintos as $recinto)
@php
$servicio = $recinto->servicios_id;
@endphp
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
						<input name="imagen[]" class="form-control" type="file" multiple>
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
											<input type="text" name="nombre" class="form-control" placeholder="Diurno, Nocturno...">
										</div>
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
<div class="modal fade" id="convenios-{{ $recinto->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="{{ route('convenios.add.recinto', $recinto->id) }}" method="post">
				@csrf
				@method('PUT')
				<div class="modal-header">
					<div class="container d-flex pl-0">
						<h3 class="modal-title ml-2" id="exampleModalLabel">Convenios de la Instalacion {{ $recinto->nombre }} </h3>
					</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					{{-- <p>Valor ${{$recinto->}}</p> --}}
					@foreach($recinto->clubes->convenios as $key => $convenio)
					@php
					$data = $recinto->recintos_convenios->where('convenios_id', $convenio->id)->first();
					@endphp
					<div class="row">
						<div class="col-1 mt-3"></div>
						<div class="col-2 mt-3">
							<h4 class="text-muted">{{ $key + 1 }}</h4>
						</div>
						<h4 class="text-muted col-6 mt-3">{{ $convenio->titulo }}</h4>
						<div class="col-2 mt-3">
							<input type="number" name="porcentaje[{{ $convenio->id }}]" min="0" max="100" data-convenio="{{ $convenio->id }}" data-recinto="{{ $recinto->id }}" class="form-control calc_por" placeholder="%0" value="{{ (is_null($data)) ? '' : $data->porcentaje }}">
						</div>
						{{-- <div class="col-6">
							<label>% Dscto.</label>
							<input type="number" name="porcentaje[{{ $convenio->id }}]" id="desc_{{ $convenio->id }}" data-convenio="{{ $convenio->id }}" data-recinto="{{ $recinto->id }}" class="form-control calc_por" placeholder="%0" value="{{ (is_null($data)) ? '' : $data->porcentaje }}">
						</div> --}}
					</div>
					@endforeach
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
<script type="text/javascript" src="{{asset('vendors/select2/js/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{asset('js/pluginjs/dataTables.tableTools.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.colReorder.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.responsive.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.rowReorder.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.print.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.scroller.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.responsive.js')}}"></script>

<script type="text/javascript" src="{{asset('js/pages/datatable.js')}}"></script>
<script type="text/javascript">
	/*$(".calc_por").keyup(function(event) {
		console.log($(this).val());
	});*/
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
			console.log('exito',response);
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






</script>
@stop