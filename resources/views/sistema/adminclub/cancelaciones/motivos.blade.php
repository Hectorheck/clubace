{{-- @dd(auth()->user()->getClubes()) --}}
@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Motivos de cancelacion
	@parent
@stop
@section('header_styles')
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/dataTables.bootstrap.css')}}"/>
@stop
@section('content')

<header class="head">
	<div class="main-bar">
		<div class="row no-gutters">
			<div class="col-lg-6">
				<h4 class="nav_top_align skin_txt">
					<i class="fa fa-file-o"></i>
					Motivos de cancelacion 
				</h4>
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
						Lista de motivos de cancelación
					</div>
					<div class="card-header bg-black">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newMotivo"><i class="fa fa-list" aria-hidden="true"></i> Nuevo</button>
					</div>
					<div class="card-body">
						<table class="table table-bordered mt-2" id="editable_table_2">
							{{-- motivo	clubes_id --}}
							<thead>
								<tr>
									<th width="" style="text-align: center;">#</th>
									<th width="40%" style="text-align: center;">Motivo</th>
									<th width="40%" style="text-align: center;">Clubes</th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($motivos as $key => $mot)
								<tr>
									<td>{{ ($key + 1) }}</td>
									<td>{{ $mot->motivo }}</td>
									<td>{{ $mot->clubes->display_name }}</td>
									<td align="center">
										<div class="btn-group">
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-{{ $mot->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
											<a href="{{-- route('cancelaciones.motivos.delete', $mot->id) --}}#" data-toggle="modal" data-target="#delete-{{ $mot->id }}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
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


{{-- NUEVO MOTIVO --}}
<div class="modal fade" id="newMotivo" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="">
		<form method="post" action="{{ route('cancelaciones.store') }}">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">
						<i class="fa fa-info"></i> Nuevo motivo
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
											<input type="text" name="motivo" id="motivo" class="form-control" placeholder="Detalle el motivo" required>
										</div>
										<div class="col">
											@foreach(auth()->user()->getClubes() as $club)
											<label class="p-3">
												<input type="checkbox" name="clubes[]" class="form-control" value="{{ $club->id }}">
												{{ $club->display_name }}
											</label>
											@endforeach
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
@foreach($motivos as $key => $mot)
{{-- DELETE --}}
<div class="modal fade" id="delete-{{ $mot->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="container d-flex pl-0"><i class="fa fa-trash {{-- fa-2x --}}"></i>
					<h5 class="modal-title ml-2" id="exampleModalLabel">¿Seguro que desea borrar el registro?</h5>
				</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<p class="text-muted">Si lo borras, este dato no se podrá recuperar</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
				<a href="{{ route('cancelaciones.motivos.delete', $mot->id) }}" class="btn btn-danger">Borrar</a>
			</div>
		</div>
	</div>
</div>
{{-- EDIT --}}
<div class="modal fade" id="edit-{{ $mot->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{ route('cancelaciones.motivos.edit', $mot->id) }}">
				@csrf
				@method('PUT')
				<div class="modal-header">
					<div class="container d-flex pl-0">
						<i class="fa fa-pencil" aria-hidden="true"></i>
						<h5 class="modal-title ml-2" id="exampleModalLabel">Editar registro</h5>
					</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<div class="form-row">
						<div class="col-12 mb-2">
							<input type="text" name="motivo" id="motivo" class="form-control" value="{{ $mot->motivo }}" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-danger">Actualizar</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach


@stop
@section('footer_scripts')
<script type="text/javascript" src="{{asset('vendors/datatables/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.responsive.js')}}"></script>
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
	});
</script>
@stop