@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Reportes
	@parent
@stop
@section('header_styles')
<link href="{{asset('css/pages/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.4.1/dist/chart.min.js"></script>
@stop

@section('content')
<header class="head">
	<div class="main-bar">
		<div class="row no-gutters">
			<div class="col-lg-6">
				<h4 class="nav_top_align skin_txt">
					<i class="fa fa-file-o"></i>
					Reportes 
				</h4>
			</div>
		</div>
	</div>
</header>
<div class="outer">
	<div class="inner bg-container">
		<div class="row">
			<div class="col-12 data_tables">
				<div class="card">
					<div class="card-header bg-white">
						<i class="fa fa-table"></i> Usuarios
					</div>
					<div class="card-body p-t-25">
						<div class="">
							<div class="pull-sm-right">
								<div class="tools pull-sm-right"></div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Ciudad</th>
									<th>Telefono</th>
									<th>Email</th>
									<th>Cant Transacciones</th>
								</tr>
								</thead>
								<tbody>
									@foreach ($usuarios as $usuario)
									<tr>
										<td> {{ $usuario->full_name }} </td>
										<td> {{ $usuario->ciudad }} </td>
										<td> {{ $usuario->telefono }} </td>
										<td> {{ $usuario->email }} </td>
										<td> 20 </td>
									</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
									</tr>
								</tfoot>
						</table>
					</div>
				</div>
				<br>
				<div class="card mt-3">
					<div class="card-header bg-white">
						<i class="fa fa-table"></i> Uso de Instalaciones
					</div>
					<div class="card-body p-t-25">
						<form class="form-inline">
							<div class="form-group mx-sm-3 mb-2">
								<label for="periodo" class="">Desde:</label>
								<input type="date" name="desde" id="desde" class="form-control ml-1">
							</div>
							<div class="form-group mx-sm-3 mb-2">
								<label for="periodo" class="">Desde:</label>
								<input type="date" name="hasta" id="hasta" class="form-control ml-1">
							</div>
							<button type="button" id="btnConsultar" name="btnConsultar" onclick="CargarFiltro();" class="btn btn-primary mb-2">Consultar</button>
						</form>
						<div class="">
							<div class="pull-sm-right">
								<div class="tools pull-sm-right"></div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
							<tr>
								<th>Club</th>
								<th>Instalacion</th>
								<th>Arrendatario</th>
								<th>Hora Inicio</th>
								<th>Hora Final</th>
								<th>Valor</th>
							</tr>
							</thead>
							<tbody>

							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th>Total</th>
									<th></th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('footer_scripts')
    <!--plugin scripts-->
    <script type="text/javascript" src="{{asset('vendors/select2/js/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/jquery.dataTables.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/pluginjs/dataTables.tableTools.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.colReorder.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.responsive.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.rowReorder.min.js')}}"></script>
    {{-- <script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.colVis.min.js')}}"></script> --}}
    <script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.html5.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/buttons.print.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.scroller.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.responsive.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/reportes/reportes.js')}}"></script>
@stop