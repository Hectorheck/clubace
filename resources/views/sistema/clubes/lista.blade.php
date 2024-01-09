@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Clubes
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
						Clubes
					</h4>
				</div>
				<div class="col-sm-7 col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
							</a>
						</li>
						{{-- <li class="breadcrumb-item">
							<a href="{{ route('/') }}">Dashboard</a>
						</li> --}}
						<li class="active breadcrumb-item">Clubes</li>
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
						<div class="card-header bg-white">Lista de clubes</div>

						<div class="card-body">
							@if(auth()->user()->tipo_usuarios_id == 1)
							<div class="my-3">
								<a href="{{ route('clubes.index') }}" class="btn btn-primary">Agregar club</a>
								{{-- <a href="{{ route('clubes.compartir') }}" class="btn btn-info">Compartir con AceMatch</a> --}}
							</div>
							@endif
							<div class="table-responsive">
								<table class="table  table-striped table-bordered table-hover dataTable no-footer" id="editable_table" role="grid">
									<thead>
										<tr>
											<th width="5%">#</th>
											<th>Club</th>
											<th>Direccion</th>
											<th width="10%">Estado TB</th>
											@if(auth()->user()->tipo_usuarios_id == 1)
											<th width="5%">Destacado</th>
											@endif
											<th width="15%">Acciones</th>
										</tr>
									</thead>

									<tbody>
										@foreach ($clubes as $key => $club)
										<tr>
											<td>{{ $key+1 }}</td>
											<td>{{ $club->display_name }}</td>
											<td>{{ $club->direccion_calle.' '.$club->direccion_numero }}</td>
											<td>{{ ($club->estado_transbank) ? 'Producción' : 'Integración' }}</td>
											@if(auth()->user()->tipo_usuarios_id == 1)
											<td>
												@if(is_null($club->destacados))
												No
												@else
												Si
												@endif
											</td>
											@endif
											<td align="center">
												<div class="btn-group">
													<a href="{{ route('clubes.config', $club->id) }}" class="btn btn-mint"><i class="fa fa-cog fa-2x"></i></a>
													<a href="{{ route('clubes.edit', $club->id) }}" class="btn btn-primary">Editar</a>
													<a href="{{ route('servicios.index', $club->id) }}" class="btn btn-success">Servicios</a>
													@if(auth()->user()->tipo_usuarios_id == 1)
													<a href="{{ route('destacar.club', $club->id) }}" class="btn btn-primary">
														@if(!is_null($club->destacados))
														No
														@endif
														Destacar
													</a>
													<a href="{{ route('info.app.club', $club->id) }}" class="btn btn-warning"><i class="fa fa-mobile fa-2x"></i></a>
													<a href="{{-- route('clubes.destroy', $club->id) --}}" data-toggle="modal" data-target="#del-{{ $club->id }}" class="btn btn-danger">Eliminar</a>
													@endif
													{{-- <a href="#" class="btn btn-info" data-toggle="modal" data-target="#share-{{ $club->id }}" >Compartir</a> --}}
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

@foreach ($clubes as $key => $club)
@if(auth()->user()->tipo_usuarios_id == 1)
<div class="modal fade" id="del-{{ $club->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="container d-flex pl-0"><i class="fa fa-trash {{-- fa-2x --}}"></i>
					<h5 class="modal-title ml-2" id="exampleModalLabel">¿Seguro que desea borrar el Club?</h5>
				</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<p class="text-muted">Si lo borras, se borrarán tambien los registros relacionados y no podras recuperarlos</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
				<a href="{{ route('clubes.destroy', $club->id) }}" class="btn btn-danger">Borrar</a>
			</div>
		</div>
	</div>
</div>
@endif
{{-- PARA COMPARTIR --}}
<div class="modal fade" id="share-{{ $club->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="container d-flex pl-0"><i class="fa fa-share {{-- fa-2x --}}"></i>
					<h5 class="modal-title ml-2" id="exampleModalLabel">Permitir que club esté disponible en otras apps de Acegroup</h5>
				</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<table class="table table-striped table-bordered table-hover dataTable no-footer">
					<thead>
						<tr>
							<th width="70%">Aplicacion</th>
							<th width="30%">Compartir</th>
							{{-- <th width="20%">Remover</th> --}}
						</tr>
					</thead>
					<tbody>
						@foreach($apps as $app)
						<tr>
							<td>{{ $app->aplicacion }}</td>
							<td>
								<input type="checkbox" onclick="return shareClub({{ $app->id }}, {{ $club->id }})" class="form-control" name="compartir" value="1">
							</td>
							{{-- <td></td> --}}
						</tr>
						@endforeach
					</tbody>
				</table>
				{{-- <p class="text-muted">Si lo borras, se borrarán tambien los registros relacionados y no podras recuperarlos</p> --}}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
				<a href="{{ route('clubes.destroy', $club->id) }}" class="btn btn-danger">Borrar</a>
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
<script type="text/javascript">
	function shareClub (id, club) {
		// console.log(id, club);
		$.ajax({
			url: '/path/to/file',
			type: 'default GET (Other values: POST)',
			dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
			data: {param1: 'value1'},
		})
		.done(function() {
			console.log("success");
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
