@php
function month ($m){
	switch ($m) {
		case 1: $mes = "Enero"; break;
		case 2: $mes = "Febrero"; break;
		case 3: $mes = "Marzo"; break;
		case 4: $mes = "Abril"; break;
		case 5: $mes = "Mayo"; break;
		case 6: $mes = "Junio"; break;
		case 7: $mes = "Julio"; break;
		case 8: $mes = "Agosto"; break;
		case 9: $mes = "Septiembre"; break;
		case 10: $mes = "Octubre"; break;
		case 11: $mes = "Noviembre"; break;
		case 12: $mes = "Diciembre"; break;
	}
	return $mes;
}
@endphp

@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Agendar multiples bloques
	@parent
@stop

@section('content')
<header class="head">
	<div class="main-bar">
		<div class="row no-gutters">
			<div class="col-sm-5 col-lg-6 skin_txt">
				<h4 class="nav_top_align">
					<i class="fa fa-pencil"></i>
					Reporte de agenda multiple
				</h4>
			</div>
			<div class="col-sm-7 col-lg-6">
				<ol class="breadcrumb float-right nav_breadcrumb_top_align">
					<li class="breadcrumb-item">
						<a href="{{ route('/') }}">
							<i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
						</a>
					</li>
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
					<div class="card-header bg-white">Buscar registros</div>
					<div class="card-body pt-3">
						<div class="row">
							<div class="col-12 col-md-4 mb-3">
								<label for="usersList" class="form-label">Entrenador</label>
								<input class="form-control" {{-- name="clientes_id" --}} list="users" id="usersList" placeholder="Buscar por nombre...">
								<datalist id="users" style="overflow: scroll">
									@foreach($users as $user)
									<option value="{{ $user->full_name }}" data-id="{{ $user->id }}"></option>
									@endforeach
								</datalist>
								<input type="hidden" id="user_id">
							</div>
							<div class="col-12 col-md-4 mb-3">
								<label for="examplemonth" class="form-label">Mes</label>
								<select class="form-control" id="month">
									@for ($i = 1; $i <= 12; $i++)
									<option value="{{ $i }}"{{ $i == date('n') ? ' selected' : '' }}>{{ month($i) }}</option>
									@endfor
								</select>
							</div>
							<div class="col-12 col-md-4 mb-3">
								<label for="exampleyear" class="form-label">Año</label>
								<select class="form-control" id="year">
									@php
									$inicio = date_create("2020-01-01 00:00:00");
									$fin = date_modify(date_create(date('Y-m-d').' 23:59:59'), '+3 year');
									@endphp
									@while($inicio <= $fin)
									<option value="{{ $inicio->format('Y') }}"{{ date('Y') == $inicio->format('Y') ? ' selected' : '' }}>{{ $inicio->format('Y') }}</option>
									@php
									$inicio->modify("+1 year");
									@endphp
									@endwhile
								</select>
							</div>
							<div class="col-12">
								<button type="button" id="buscar" class="btn btn-success">Buscar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="outer">
	<div class="inner bg-container">
		{{-- <table class="table table-bordered" id="preview">
		</table> --}}
	</div>
</div>
<div class="outer">
	<div class="inner bg-container table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="10%" style="text-align: center;">Fecha</th>
					<th width="10%" style="text-align: center;">Bloque Horario</th>
					<th width="30%" style="text-align: center;">Instalación</th>
					<th width="20%" style="text-align: center;">Estado</th>
					<th width="10%" style="text-align: center;">Valor</th>
				</tr>
			</thead>
			<tbody id="result"></tbody>
			<tfoot>
				<tr>
					<td colspan="5" align="right" id="totalBloques">Total bloques: 0</td>
				</tr>
				<tr>
					<td colspan="5" align="right" id="valorBloques">Monto Total bloques: 0</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@stop

@section('footer_scripts')
<script>
$('#usersList').on('input', function() {
	let value = $(this).val();
	let id = $(`#users [value ="${value}"]`).attr('data-id');
	if (typeof id !== 'undefined') {
		$("#user_id").val(id);
	}
});
$('#buscar').click(function(){
	let user = $('#user_id').val(), month = $('#month').val(), year = $('#year').val();
	$('#result').empty();
	$('#result').append(`
		<tr>
			<td colspan="5" align="center">
				<img src="{{ asset('img/loader.gif') }}" style=" width:40px;">
			</td>
		</tr>
	`);
	$('#totalBloques').text(`Total bloques: 0`);
	$('#valorBloques').text(`Monto Total bloques: 0`);
	$.ajax({
		url: `{{ asset('multi-agenda/reporte/search') }}/${user}/${month}/${year}`,
		type: 'GET',
		cache: false
	})
	.done(function(resp) {
		console.log(resp);
		$('#result').empty();
		let totalBloques = 0, valorBloques = 0;
		$.each(resp.agendas, function(i, val) {
			// $.each(val.agendas, function(i, bloque) {
				totalBloques++;
				valorBloques = parseInt(valorBloques) + parseInt(val.valor_hora);
				$('#result').append(`
					<tr>
						<td>${val.fecha}</td>
						<td>${val.bloque}</td>
						<td>${val.instalacion_full}</td>
						<td>${val.estado}</td>
						<td>${new Intl.NumberFormat("de-DE").format(val.valor_hora)}</td>
					</tr>
				`);
			// });
		});
		$('#totalBloques').text(`Total bloques: ${totalBloques}`);
		$('#valorBloques').text(`Monto Total bloques: ${new Intl.NumberFormat("de-DE").format(valorBloques)}`);
	})
	.fail(function() {
		$('#result').append(`
			<tr>
				<td colspan="5" align="center">Faltan datos en el formulario</td>
			</tr>
		`);
	});
})
</script>
@stop




