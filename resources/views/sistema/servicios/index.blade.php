@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Servicios
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

<!-- additions -->
<style>#mapa{border-radius:.25rem;min-height:250px;max-height:350px;height:-webkit-fill-available}</style>
<!-- End additions -->
@stop
@section('content')
	<header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-sm-5 col-lg-6 skin_txt">
					<h4 class="nav_top_align"><i class="fa fa-pencil"></i> Servicios - {{ $data->display_name }}</h4>
				</div>
				<div class="col-sm-7 col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Inicio
							</a>
						</li>
						{{-- <li class="breadcrumb-item">
							<a href="#">Forms</a>
						</li> --}}
						<li class="active breadcrumb-item">Servicios - {{ $data->display_name }}</li>
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
						<div class="card-header bg-white">Lista de servicios</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped mt-3">
									<thead>
										<tr>
											<th>Nombre</th>
											<th width="10%">Instalaciones</th>
											<th></th>
										</tr>
									</thead>

									<tbody>
										@foreach ($servicios as $servicio)
										<tr>
											<td>{{ $servicio->nombre }}</td>
											<td>{{ $servicio->recintos->count() }}</td>
											<td align="center">
												<div class="btn-group">
													<a href="{{ route('servicios.edit', [$club, $servicio->id]) }}" class="btn btn-primary">Editar</a>
													<a href="{{ route('recintos.index', $servicio->id) }}" class="btn btn-success">Instalaciones</a>
													<a href="{{-- route('servicios.destroy', [$club, $servicio->id]) --}}" data-toggle="modal" data-target="#del-{{ $servicio->id }}" class="btn btn-danger">Eliminar</a>
												</div>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 col-6 mb-15">
								<button class="btn btn-success mb-15" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Nuevo Servicio</button>
							</div>
						</div>
					</div>
				</div>
				&nbsp;<hr>&nbsp;
				<div class="col-12 collapse" id="collapseExample">
					<div class="card">
						<div class="card-header bg-white">Registra un servicio</div>

						<div class="card-body">
							<!-- checkbox -->
							<div class="justify-content-center">
								<form action="{{ route('servicios.store', $club) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
									@method('PUT')
									@csrf
									<!-- Name input-->
									<div class="row form-group">
										<div class="col-12 col-md-6 mt-3">
											<label for="nombre" class="form-group-horizontal">Nombre</label>
											<div class="input-group">
												<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre">
											</div>
										</div>

										{{-- <div class="col-12 col-md-6 mt-3">
											<label for="valor" class="form-group-horizontal">Valor</label>
											<div class="input-group">
												<input type="number" name="valor" id="valor" class="form-control" placeholder="Valor">
											</div>
										</div> --}}

										{{-- <div class="col-12 col-md-6 mt-3">
											<label for="tipo" class="form-group-horizontal">Tipo de clientela</label>
											<div class="input-group row">
												<div class="col-12 col-sm-6">
													<label class="custom-control custom-checkbox mr-3 d-inline">
														<input type="checkbox" name="socios" class="custom-control-input">
														<span class="custom-control-label"></span>
														<span class="custom-control-description">Socio Club</span>
													</label>
												</div>

												<div class="col-12 col-sm-6">
													<label class="custom-control custom-checkbox mr-3 d-inline">
														<input type="checkbox" name="arriendo" class="custom-control-input">
														<span class="custom-control-label"></span>
														<span class="custom-control-description">Arriendo</span>
													</label>
												</div>
											</div>
										</div> --}}

										{{-- <div class="col-12 col-md-6 mt-3">
											<label for="bloque_horario" class="form-group-horizontal">Bloque horario</label>
											<div class="input-group">
												<select name="bloque_horario" id="bloque_horario" class="form-control">
													@php
													list($hr, $cnt) = [0, 0];
													@endphp
													@while ($hr < 2)
													@php
													$min = $cnt % 2 == 0 ? '30' : '00';
													@endphp
													<option value="{{ '+'.$hr.' hour +'.$min.' minutes' }}" @if($hr=='1' && $min=='00') selected @endif>{{ $hr.' : '.$min.' Hr' }}</option>
													@php
													$cnt % 2 != 0 ? : $hr++;
													$cnt++;
													@endphp
													@endwhile
													<option value="+2 hour +00 minutes">2 : 00 Hr</option>
													<option value="+3 hour +00 minutes">3 : 00 Hr</option>
													<option value="+4 hour +00 minutes">4 : 00 Hr</option>
													<option value="+5 hour +00 minutes">5 : 00 Hr</option>
													<option value="+6 hour +00 minutes">6 : 00 Hr</option>
												</select>
											</div>
										</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="hora_inicio" class="form-group-horizontal">Hora inicio</label>
											<div class="input-group">
												<input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="09:00">
											</div>
										</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="hora_fin" class="form-group-horizontal">Hora fin</label>
											<div class="input-group">
												<input type="time" name="hora_fin" id="hora_fin" class="form-control" value="20:00">
											</div>
										</div> --}}

										<div class="col-12 col-sm-6">
											<div class="mt-3">
												<label for="" class="form-group-horizontal">Imagen Principal</label>
												<div class="custom-file">
													<input type="file" name="imagen" id="imagen" class="custom-file-input" accept="image/*" lang="es">
													<label class="custom-file-label" data-browse="Buscar" for="imagen">Seleccionar Archivo</label>
												</div>
											</div>
											<div class="row mt-3">
												<div class="col-12 col-sm-5 col-md-3">
													<figure class="card p-2 mb-0">
														<img src="{{ asset('img/default.png') }}" id="img-imagen" class="w-100">
													</figure>
												</div>
											</div>
										</div>
									</div>

									<div class="form-group">
										<button type="submit" class="btn btn-primary">Registrar</button>
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

@foreach ($servicios as $servicio)
<div class="modal fade" id="del-{{ $servicio->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="container d-flex pl-0"><i class="fa fa-trash {{-- fa-2x --}}"></i>
					<h5 class="modal-title ml-2" id="exampleModalLabel">¿Seguro que desea borrar el Servicio?</h5>
				</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<p class="text-muted">Si lo borras, se borrarán tambien los registros relacionados y no podras recuperarlos</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
				<a href="{{ route('servicios.destroy', [$club, $servicio->id]) }}" class="btn btn-danger">Borrar</a>
			</div>
		</div>
	</div>
</div>
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
function visualizar(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$(`#img-imagen`).attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$('#imagen').change(function(){
	visualizar(this)
});
</script>
@stop
