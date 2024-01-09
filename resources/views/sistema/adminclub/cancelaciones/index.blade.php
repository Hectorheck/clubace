@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Cancelaciones
	@parent
@stop
@section('header_styles')
@stop
@section('content')

<header class="head">
	<div class="main-bar">
		<div class="row no-gutters">
			<div class="col-lg-6">
				<h4 class="nav_top_align skin_txt">
					<i class="fa fa-file-o"></i>
					Lista de cancelaciones 
				</h4>
			</div>
		</div>
	</div>
</header>

<div class="outer">
	<div class="inner bg-container">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="" style="text-align: center;">#</th>
					<th width="20%" style="text-align: center;">Usuario</th>
					<th width="20%" style="text-align: center;">Recinto</th>
					<th width="20%" style="text-align: center;">Fecha/Hora</th>
					<th width="40%" style="text-align: center;">Motivo</th>
				</tr>
			</thead>
			<tbody>
				@foreach($cancelaciones as $key => $can)
				@if(!is_null($can->users) && !is_null($can->agenda))
				<tr>
					<td>{{ ($key + 1) }}</td>
					<td>{{ $can->users->full_name }}</td>
					<td>{{ $can->agenda->recintos->nombre }}</td>
					<td>{{ $can->agenda->fecha }} {{ $can->agenda->hora_inicio_bloque }}</td>
					<td>{{ !is_null($can->motivos_cancelaciones) ? $can->motivos_cancelaciones->motivo : '' }}</td>
				</tr>
				@endif
				@endforeach
			</tbody>
		  </table>
	</div>
</div>







@stop
@section('footer_scripts')
@stop