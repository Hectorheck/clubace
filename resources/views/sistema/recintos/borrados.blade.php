@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Recintos Eliminados
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
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/dataTables.bootstrap.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/tables.css')}}"/>
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
					<h4 class="nav_top_align">
						<i class="fa fa-pencil"></i>
						Recintos
					</h4>
				</div>
				<div class="col-sm-7 col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="#">Dashboard</a>
						</li>
						<li class="active breadcrumb-item">Recintos eliminados</li>
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
						<div class="card-header bg-white">Lista de recintos eliminados</div>

						<div class="card-body">
							<div class="my-3">
								{{-- <a href="{{ route('clubes.index') }}" class="btn btn-primary">Agregar club</a> --}}
							</div>
							<div class="table-responsive">
								<table class="table  table-striped table-bordered table-hover dataTable no-footer" id="editable_table" role="grid">
									<thead>
										<tr>
											<th>Servicio/Club</th>
											<th>Recinto</th>
											{{-- <th>Direccion</th> --}}
											<th width="15%">Acciones</th>
										</tr>
									</thead>

									<tbody>
										@foreach ($recintos as $recinto)
										{{-- @dump($recinto->servicios()->withTrashed()->first()) --}}
										<tr>
											<td>
												{{ ($recinto->servicios()->withTrashed()->first()) ? $recinto->servicios()->withTrashed()->first()->nombre : 'ELIMINADO' }}/{{ ($recinto->clubes()->withTrashed()->first()) ? $recinto->clubes()->withTrashed()->first()->display_name : 'ELIMINADO' }}
											</td>
											<td>{{ $recinto->nombre }}</td>
											<td>
												<div class="btn-group">
													<a href="{{ route('papelera.recintos.restaurar', $recinto->id) }}" class="btn btn-primary"><i class="fa fa-rotate-left"></i> Restaurar</a>
													<a href="{{-- route('papelera.recintos.borrar', $recinto->id) --}}" data-toggle="modal" data-target="#del-{{ $recinto->id }}" class="btn btn-danger">Eliminar</a>
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

@foreach ($recintos as $recinto)
<div class="modal fade" id="del-{{ $recinto->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="container d-flex pl-0"><i class="fa fa-trash {{-- fa-2x --}}"></i>
					<h5 class="modal-title ml-2" id="exampleModalLabel">¿Seguro que desea borrar el Recinto {{ $recinto->nombre }} de manera PERMANENTE?</h5>
				</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<p class="text-muted">Si lo borras, se borrarán tambien los registros relacionados y no podras recuperarlos</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
				<a href="{{ route('papelera.recintos.borrar', $recinto->id) }}" class="btn btn-danger">Borrar</a>
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
<!-- end of page level js -->
<script type="text/javascript" src="{{asset('vendors/datatables/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.responsive.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.print.min.js')}}"></script>
@stop
