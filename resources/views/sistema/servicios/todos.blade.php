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
					<h4 class="nav_top_align"><i class="fa fa-pencil"></i> Servicios</h4>
				</div>
				<div class="col-sm-7 col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Inicio
							</a>
						</li>
						<li class="active breadcrumb-item">Servicios</li>
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
											<th>Club</th>
											<th width="10%">Instalaciones</th>
											{{-- <th>Valor</th>
											<th>Hora inicio</th>
											<th>Hora termino</th> --}}
											<th></th>
										</tr>
									</thead>

									<tbody>
										@foreach ($servicios as $servicio)
										<tr>
											<td>{{ $servicio->nombre }}</td>
											<td>{{ $servicio->clubes->display_name }}</td>
											<td>{{ $servicio->recintos->count() }}</td>
											{{-- <td>{{ number_format($servicio->valor, 0, ',', '.') }}</td>
											<td>{{ $servicio->hora_inicio }}</td>
											<td>{{ $servicio->hora_fin }}</td> --}}
											<td align="center">
												<div class="btn-group">
													<a href="{{ route('servicios.edit', [$servicio->clubes->id, $servicio->id]) }}" class="btn btn-primary">Editar</a>
													<a href="{{ route('recintos.index', $servicio->id) }}" class="btn btn-success">Instalaciones</a>
													<a href="{{-- route('servicios.destroy', [$servicio->clubes->id, $servicio->id]) --}}" data-toggle="modal" data-target="#del-{{ $servicio->id }}" class="btn btn-danger">Eliminar</a>
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
				<a href="{{ route('servicios.destroy', [$servicio->clubes->id, $servicio->id]) }}" class="btn btn-danger">Borrar</a>
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
@stop
