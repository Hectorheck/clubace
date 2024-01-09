@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Usuarios
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

@stop
@section('content')
	<header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-lg-6 col-sm-4">
					<h4 class="nav_top_align">
						<i class="fa fa-user"></i>
						Tabla de usuarios
					</h4>
				</div>
				<div class="col-lg-6 col-sm-8 col-12">
					<ol class="breadcrumb float-right  nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="index1">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="#">Usuarios</a>
						</li>
						<li class="active breadcrumb-item">Tabla de usuarios</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="outer">
		<div class="inner bg-container">
			<div class="card">
				<div class="card-header bg-white">
					Tabla de usuarios
				</div>
				<div class="card-body m-t-35" id="user_body">
					<div class="table-toolbar">
						<div class="btn-group">
						<a href="{{ route('users.create') }}" id="editable_table_new" class=" btn btn-default">
								Nuevo usuario  <i class="fa fa-plus"></i>
							</a>
						</div>
						<div class="btn-group float-right users_grid_tools">
							<div class="tools"></div>
						</div>
					</div>
					<div>
						<div>
							<table class="table  table-striped table-bordered table-hover dataTable no-footer" id="editable_table" role="grid">
								<thead>
								<tr role="row">
									<th class="sorting_asc wid-25" tabindex="0" rowspan="1" colspan="1">Nombres</th>
									<th class="sorting_asc wid-25" width="15%" tabindex="0" rowspan="1" colspan="1">Rut</th>
									<th class="sorting wid-25" tabindex="0" rowspan="1" colspan="1">E-Mail</th>
									<th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Tipo</th>
									{{-- <th class="sorting wid-10" tabindex="0" rowspan="1" colspan="1">Rut</th>
									<th class="sorting wid-20" tabindex="0" rowspan="1" colspan="1">Ciudad</th>
									<th class="sorting wid-15" tabindex="0" rowspan="1" colspan="1">Status</th> --}}
									<th class="sorting wid-5" width="5%" tabindex="0" rowspan="1" colspan="1">Acciones</th>
								</tr>
								</thead>
								<tbody>
									@foreach($users as $user)
									<tr role="row" class="even">
										<td class="sorting_1">{{ $user->nombres }}</td>
										<td class="sorting_1">{{ $user->rut }}</td>
										<td>{{ $user->email }}</td>
										<td>{{ is_null($user->tipo_usuarios) ? '' : $user->tipo_usuarios->tipo }}</td>
										{{-- <td>{{ $user->rut }}</td>
										<td class="center">{{ $user->ciudad }}</td>
										<td class="center">Approved</td> --}}
										<td>
											{{-- <a class="edit" data-toggle="tooltip" data-placement="top" title="Edit" href="edit_user"><i class="fa fa-pencil text-warning"></i></a>
											&nbsp; &nbsp; --}}
											@if(Request::is('users'))
											<a href="{{ route('users.edit', $user->id) }}" data-toggle="tooltip" data-placement="top" title="Ver/Editar Usuario"><i class="fa fa-eye text-success"></i></a>
											&nbsp; &nbsp;
											<a class="delete hidden-xs hidden-sm" data-toggle="tooltip" data-placement="top" title="Eliminar usuario" href="{{route('users.delete', $user->id)}}"><i class="fa fa-trash text-danger"></i></a>
											@elseif(Request::is('users/eliminados'))
											<a href="{{ route('users.restaurar', $user->id) }}" data-toggle="tooltip" data-placement="top" title="Restaurar usuario"><i class="fa fa-rotate-left text-success"></i></a>
											&nbsp; &nbsp;
											<a class="delete hidden-xs hidden-sm" href="{{-- route('users.borrar', $user->id) --}}" data-toggle="modal" data-target="#del-{{ $user->id }}"><i class="fa fa-trash text-danger"></i></a>
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
		</div>
		<!-- /.inner -->
	</div>
	<!-- /.outer -->
@stop

@foreach ($users as $user)
<div class="modal fade" id="del-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<div class="container d-flex pl-0"><i class="fa fa-trash {{-- fa-2x --}}"></i>
					<h5 class="modal-title ml-2" id="exampleModalLabel">¿Seguro que desea borrar el Usuario {{ $user->nombres }} de manera PERMANENTE?</h5>
				</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<p class="text-muted">Si lo borras, se borrarán tambien los registros relacionados y no podras recuperarlos</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
				@if(Request::is('users'))
				<a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger">Borrar</a>
				@elseif(Request::is('users/eliminados'))
				<a href="{{ route('users.borrar', $user->id) }}" class="btn btn-danger">Borrar</a>
				@endif
			</div>
		</div>
	</div>
</div>
@endforeach


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
	<!-- end page level scripts -->
@stop
