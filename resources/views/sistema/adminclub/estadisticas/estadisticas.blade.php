@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Estadísticas
	@parent
@stop

{{-- @dump($array,$barras,$lineas) --}}

@section('header_styles')
<link href="{{asset('css/pages/flot_charts.css')}}" rel="stylesheet" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.4.1/dist/chart.min.js"></script>
@stop

@section('content')
<header class="head">
	<div class="main-bar">
		<div class="row no-gutters">
			<div class="col-lg-6">
				<h4 class="nav_top_align skin_txt">
					<i class="fa fa-file-o"></i>
					Estadísticas
				</h4>
			</div>
		</div>
	</div>
</header>
<div class="outer">
	<div class="inner bg-container">
		<div class="card-body" id="tabs">
			<ul class="nav nav-tabs m-t-35">
				<li class="nav-item" id="ionicons_tab">
					<a class="nav-link active" href="#graficos" data-toggle="tab">Graficos Mensuales</a>
				</li>
				<li class="nav-item" id="themify_icon">
					<a class="nav-link" href="#indicadores" data-toggle="tab">INDICADORES POR DETALLE</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="graficos">
					{{-- NUEVOS GRAFICOS --}}
					<div class="row">
						<div class="col-lg-6 m-t-35">
							<div class="card">
								{{-- <div class="card-header bg-white text-black">
									(1er grafico) 
								</div> --}}
								<div class="card-body m-t-35">
									{{-- DINERO MENSUAL POR INSTALACION RECIBIDO --}}
									<canvas id="myChart" width="400" height="400"></canvas>
								</div>
							</div>
						</div>
						<div class="col-lg-6 m-t-35">
							<div class="card">
								<div class="card-header bg-white text-black">
									Porcentaje de usabilidad mensual por instalaciones
									{{-- PORCENTAJE DE OCUPADOS DEL TOTAL DE BLOQUES DEL MES --}}
								</div>
								<div class="card-body m-t-35">
									<canvas id="Chart2" width="400" height="400"></canvas>
								</div>
							</div>
						</div>
						<div class="col-lg-12 m-t-35">
							<div class="card">
								<div class="card-header bg-white text-black">
									{{-- DEBE INCLUIR EL MES ACTUAL --}}
									{{-- LINEA POR CADA RECINTO, QUE INDIQUE VALORES EN DINERO, MAS OTRA QUE SEA EL TOTAL --}}
									Arriendo y agendas mensuales (últimos 12 meses)
								</div>
								<div class="card-body m-t-35">
									<canvas id="Chart3" width="800" height="400"></canvas>
									<hr>
									{{-- <div class="text-center">
										<button type="button" class="btn btn-info" onclick="loadPeriodo(12)">12 Meses</button>
										<button type="button" class="btn btn-info" onclick="loadPeriodo(6)">6 Meses</button>
										<button type="button" class="btn btn-info" onclick="loadPeriodo(3)">3 Meses</button>
									</div> --}}
								</div>
							</div>
						</div>
					</div>
					{{-- NUEVOS GRAFICOS --}}
				</div>
				<div class="tab-pane" id="indicadores">
					{{-- CARD RESUMENES --}}
					<div class="card">
						<form class="form inline mt-2 p-1">
							<div class="row">
								<div class="col-sm-1 " style="text-align: center">
									<label for="fecha">Fecha: </label>
								</div>
								<div class="col-sm-2 ">
									<input type="date" name="desde" class="form-control" id="desde" value="{{ date('Y-m-d') }}" onchange="return loadData();">
								</div>
								<div class="col-sm-2 ">
									<input type="date" name="hasta" class="form-control" id="hasta" value="{{ date('Y-m-d') }}" onchange="return loadData();">
								</div>
								<div class="col-sm-1" style="text-align: center">
									<label for="clubes" >Club: </label>
								</div>
								<div class="col-sm-1 ">
									<select class="form-control" name="clubes" id="clubes" onchange="return loadData();">
										<option value="0">Todos</option>
										@foreach(auth()->user()->getClubes() as $club) 
											<option value="{{ $club->id }}"> {{ $club->display_name}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-sm-1" style="text-align: center">
									<label for="servicio" >Servicio: </label>
								</div>
								<div class="col-sm-1 ">
									<select class="form-control" name="servicio" id="servicio" onchange="return loadData();">
										<option value="0">Todos</option>
										@foreach(auth()->user()->getServicios() as $servicio) 
											<option value="{{ $servicio->id }}"> {{ $servicio->nombre}}</option>
										@endforeach
									</select>
								</div>
								<div class="col-sm-1" style="text-align: center">
									<label for="recinto" >Instalacion: </label>
								</div>
								<div class="col-sm-2 ">
									<select class="form-control" name="recinto" id="recinto" onchange="return loadData();">
										<option value="0">Todos</option>
										@foreach(auth()->user()->getRecintos() as $recinto) 
											<option value="{{ $recinto->id }}"> {{ $recinto->nombre}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</form>
						<div class="card-body p-t-0">
							<div class="card-columns">
								{{-- NUMEROS DEL DIA --}}
								<div class="card border-primary m-t-25">
									<div class="card-header bg-white">Instalaciones agendadas</div>
									<div class="card-body">
										<p class="card-text"><span id="box_1">{{ $cards['agendadas'] }}</span> Bloques agendados</p>
									</div>
								</div>
								<div class="card border-primary m-t-25">
									<div class="card-header bg-white">% Uso de instalaciones</div>
									<div class="card-body">
										<p class="card-text"><span id="box_2">{{ number_format($cards['uso'], 0, ',', '.') }}</span>% Bloques agendados</p>
									</div>
								</div>
								<div class="card border-primary m-t-25">
									<div class="card-header bg-white">Bloques disponibles</div>
									<div class="card-body">
										<p class="card-text"><span id="box_3">{{ $cards['disponibles'] }}</span> Bloques disponibles</p>
									</div>
								</div>
								<div class="card border-primary m-t-25">
									<div class="card-header bg-white">Bloques no disponibles</div>
									<div class="card-body">
										<p class="card-text"><span id="box_4">{{ $cards['nodis'] }}</span> Bloques no disponibles</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop


@section('footer_scripts')
<script type="text/javascript" src="{{asset('vendors/flotchart/js/jquery.flot.js')}}" ></script>
<script type="text/javascript" src="{{asset('vendors/flotchart/js/jquery.flot.resize.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/flotchart/js/jquery.flot.stack.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/flotchart/js/jquery.flot.time.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/flotspline/js/jquery.flot.spline.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/flotchart/js/jquery.flot.categories.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/flotchart/js/jquery.flot.pie.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/flot.tooltip/js/jquery.flot.tooltip.min.js')}}"></script>
<!--plugin scripts-->
<!--Page level scripts-->
{{-- <script type="text/javascript" src="{{asset('js/pages/flot_charts.js')}}"></script> --}}
<!-- end of global scripts-->
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [@foreach($barras['labels'] as $labels) '{{ $labels }}', @endforeach],
		datasets: [{
			label: 'INGRESO MENSUAL POR INSTALACIÓN RECIBIDO',
			data: [@isset($barras['data']) @foreach($barras['data'] as $data) {{ $data }}, @endforeach @endisset],
			backgroundColor: [
				@isset($barras['color'])
				@foreach($barras['color'] as $color)
				'{{ 'rgba('.str_replace('"', '', $color).', 0.2)', }}',
				@endforeach
				@endisset
			],
			borderColor: [
				@isset($barras['color'])
				@foreach($barras['color'] as $color)
				'{{ 'rgba('.str_replace('"', '', $color).', 1)', }}',
				@endforeach
				@endisset
			],
			borderWidth: 1
		}]
	},
	options: {
		scales: {
			y: {
				beginAtZero: true
			}
		}
	}
});
var chart = document.getElementById('Chart2').getContext('2d');
var myChart = new Chart(chart, {
	type: 'pie',
	data: {
		labels: [@isset($array['color']) @foreach($array['labels'] as $labels) '{{ $labels }}', @endforeach @endisset],
		datasets: [{
			label: 'Arriendo de recintos',
			data: [@isset($array['data']) @foreach($array['data'] as $data) {{ $data }}, @endforeach @endisset],
			backgroundColor: [
				@isset($array['color'])
				@foreach($array['color'] as $color)
				'{{ 'rgba('.str_replace('"', '', $color).', 0.2)', }}',
				@endforeach
				@endisset
			],
			borderColor: [
				@isset($array['color'])
				@foreach($array['color'] as $color)
				'{{ 'rgba('.str_replace('"', '', $color).', 1)', }}',
				@endforeach
				@endisset
			],
			borderWidth: 1
		}]
	},
	// options: {
	// 	scales: {
	// 		y: {
	// 			beginAtZero: true
	// 		}
	// 	}
	// }
});
{{-- @dd($lineas[0]) --}}
var chart = document.getElementById('Chart3').getContext('2d');
var myChart = new Chart(chart, {
	type: 'line',
	data: {
		labels: [@foreach($lineas[0] as $key => $linea) @if(is_array($linea)) '{{ $linea["labels"] }}', @endif @endforeach],
		datasets: [
		@foreach($lineas as $key => $linea)
		{
			label: '{{ $linea["nombre"] }}',
			data: [@foreach($linea as $k => $line) {{ (is_array($line)) ? $line['data'] : '' }}, @endforeach],
			backgroundColor: [
				@foreach($linea as $k => $line)
				'{{ (is_array($line)) ? "rgba($line[color], 0.2)" : '' }}',
				@endforeach
				],
			borderColor: [
				@foreach($linea as $k => $line)
				'{{ (is_array($line)) ? "rgba($line[color], 1)" : '' }}',
				@endforeach
				],
			borderWidth: 1
		},
		@endforeach
		]
	},
	options: {
		scales: {
			y: {
				beginAtZero: true
			}
		}
	}
});
function loadPeriodo (int) {
	$.ajax({
		url: `/estadisticas/${int}/periodo`,
		type: 'GET',
	})
	.done(function(response) {
		console.log(response);
		return;
		var newData = {
			labels : response.lineas.labels,
			datasets : [{
				label: 'Arriendo de recintos',
				data : response.lineas.data,
				backgroundColor : "rgba(75,192,192,1)",
				borderColor : "rgba(75,192,192,1)",
				borderWidth: 1
			}],
		}
		console.log(newData);
		myChart.data = newData;
		myChart.update();
		// addData(myChart, response.lineas.labels, response.lineas.data);
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		// console.log("complete");
	});
}
$("#clubes").change(function(event) {
	let id = $("#clubes").val();
	let uri = `/load/${id}/servicios`;
	$.ajax({
		url: uri,
		type: 'GET',
	})
	.done(function(response) {
		// console.log(response);
		$("#servicio").empty();
		$("#servicio").append(`<option value="0">Todos</option>`);
		$.each(response, function(index, val) {
			$("#servicio").append(`
				<option value="${val.id}"> ${val.nombre}</option>
			`);
		});
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		// console.log("complete");
	});
});
$("#servicio").change(function(event) {
	let id = $("#servicio").val();
	let uri = `load/${id}/recintos`;
	$.ajax({
		url: uri,
		type: 'GET',
	})
	.done(function(response) {
		// console.log(response);
		$("#recinto").empty();
		$("#recinto").append(`<option value="0">Todos</option>`);
		$.each(response, function(index, val) {
			$("#recinto").append(`
				<option value="${val.id}"> ${val.nombre}</option>
			`);
		});
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		// console.log("complete");
	});
});
function loadData () {
	getBoxes();
}
function getBoxes () {
	let desde = $("#desde").val();
	let hasta = $("#hasta").val();
	let servicio = $("#servicio").val();
	let club = $("#clubes").val();
	let recinto = $("#recinto").val();
	let url = `/estadisticas/data/${desde}/${hasta}/${club}/${servicio}/${recinto}`;
	// console.log(url);
	$.ajax({
		url: url,
		type: 'GET',
	})
	.done(function(response) {
		// console.log(response);
		$("#box_1").empty();
		$("#box_2").empty();
		$("#box_3").empty();
		$("#box_4").empty();
		$("#box_1").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.agendadas)}`);
		$("#box_2").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.uso)}`);
		$("#box_3").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.disponibles)}`);
		$("#box_4").append(`${new Intl.NumberFormat('de-DE', {maximumFractionDigits: 0,}).format(response.nodis)}`);
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		// console.log("complete");
	});
}
</script>
@stop