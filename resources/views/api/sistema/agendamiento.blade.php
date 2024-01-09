{{-- @php
$logotipo = $club->logo_url ? Storage::disk('public')->url($club->logo_url) : asset('img/clubes/logotipo.png');
@endphp
@section('title'){{ 'Agendamiento' }}@endsection
@extends('sistema.socios.layout')
@section('content')
@include('sistema.socios.menu') --}}
@php
$logotipo = $club->logo_url ? Storage::disk('public')->url($club->logo_url) : asset('img/clubes/logotipo.png');
@endphp
<!doctype html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>@yield('title')</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="shortcut icon" href="{{ asset('/recursos/img/logoaceclub.png') }}" />
	<link rel="stylesheet" href="{{ asset('/recursos/css/estilos.css') }}">
	<link rel="stylesheet" href="{{ asset('/recursos/css/responsive.css') }}">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
	@yield('style')
</head>
<body class="d-flex flex-column h-100 @if(Request::is('/') || Request::is('home')) bg-login @endif">
	<header class="bg-azul" style="background-color:{{ $club->color_1 }}!important">
		<div class="degradado">
			{{-- <div class="iconos-header">
				<div class="row">
					<div class="col">
						<a href="{{ asset('/') }}">
							<img class="iconos" src="{{ asset('recursos/img/iconos/volver.svg') }}">
						</a>
					</div>
					<div class="col text-right">
						{{-- <span class="notificacion">412</span> --}}
						{{-- <a href="#">
							<img class="iconos" src="{{ asset('recursos/img/iconos/notificacion.svg') }}">
						</a>
						<a onclick="showmenu()" href="#">
							<img class="iconos icono-menu" src="{{ asset('recursos/img/iconos/menu.svg') }}">
						</a>
					</div>
				</div>
			</div> --}}
			<h1>Agendamiento {{ $servicio->nombre }}</h1>
		</div>
	</header>

	<div class="container mt-contenido">
		<div class="row">
			<div class="col-12 col-md-6 mb-25">
				<a href="#">
					<div class="row align-items-center">
						<div class="col-10">
							<div class="bloque-cuadro mb-0 pd-cuadro">
								<div class="info-cuadro">
									<img src="{{asset('recursos/img/iconos/ubicacion.svg')}}" alt="">
									<h3>{{ $club->display_name }}</h3>
									<p>{{ $club->direccion_calle }} {{ $club->direccion_numero }}, {{ $club->comunas->nombre }},{{--  La Reina, --}} {{ $club->comunas->regiones->codigo }}</p>
								</div>
							</div>
						</div>
						<div class="col-2">
							<div class="bloque-cuadro logo-cuadro d-flex align-items-center bg-azul" style="background-color:{{ $club->color_2 }}!important">
								<img src="{{ $logotipo }}" alt="{{ $club->display_name }}">
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>


	<div class="mt-auto pt-0">
		<div class="container">
			<div class="row">
				<div class="col">
					<h4>Agendar Recinto</h4>
				</div>
			</div>
		</div>
		<div class="bloque-footer pd-cuadro box-cuadro pt-25">
			<div class="container">
				<form action="{{ route('agendar', $servicio->id) }}" method="post" class="w-100">
					@csrf
					@method('PUT')
					<div class="row">
						<div class="col-12 col-sm-6">
							<div class="form-group {{-- error --}}"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
								<label for="">Seleccionar Recinto</label>
								<select class="form-control" id="recintos_id" name="recintos_id">
									@forelse($recintos as $recinto)
									<option value="{{ $recinto->id }}">{{ $recinto->nombre }}</option>
									@empty
									<option disabled="">No tiene recintos aun cargados</option>
									@endforelse
								</select>
								<small class="mensaje-error">Error al ingresar este campo</small>
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
								<label for="">Fecha</label>
								<input type="date" class="form-control" id="fecha_select" value="{{ date('Y-m-d') }}">
								<small class="mensaje-error">Error al ingresar este campo</small>
							</div>
						</div>
						{{-- <div class="col-12">
							<div class="form-group error">
								<select class="form-control select-edit" id="">
									<option>AM</option>
									<option>PM</option>
								</select>
							</div>
						</div> --}}
						<div class="col-12" >
							<input type="hidden" readonly name="horario_selected" id="horario_selected">
							<div class="row" id="bloques" style="display: none;">
							{{-- <div class="row">
								<div class="col">
									<a class="hora hora-personalizada" href="#">08:00</a>
								</div>
								<div class="col">
									<a class="hora no-disponible" href="#">08:30</a>
								</div>
								<div class="col">
									<a class="hora no-disponible" href="#">09:00</a>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<a class="hora hora-personalizada" href="#">09:30</a>
								</div>
								<div class="col">
									<a class="hora hora-personalizada" href="#">10:00</a>
								</div>
								<div class="col">
									<a class="hora hora-personalizada" href="#">10:30</a>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<a class="hora hora-personalizada" href="#">11:00</a>
								</div>
								<div class="col">
									<a class="hora hora-personalizada" href="#">11:30</a>
								</div>
								<div class="col">
									<a class="hora hora-personalizada" href="#">12:00</a>
								</div>
							</div> --}}
							</div>
							<div class="row" id="terminos_div" style="display: none;">
								<div class="col">
									<h5>Terminos y condiciones</h5>
									<div class="form-group form-check">
										<input type="checkbox" class="form-check-input" id="tyc">
										<label class="form-check-label" for="tyc">Estoy de acuerdo con los términos y condiciones.</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<button type="submit" {{-- href="participantes-agendamiento.html" --}} class="btn btn-success mb-25 mt-25">Finalizar</button>
								</div>
							</div>
						</div>
					</div>
				 </form>
			</div>
		</div>
	</div>
{{-- @endsection --}}
</body>
{{-- @section('script') --}}
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function($) {
		// $("#bloques").empty();
		// let fecha = $("#fecha_select").val();
		// let id = $("#recintos_id").val();
		// console.log(id, fecha);
		loadAgenda();
	});
	function loadAgenda () {
		$("#bloques").empty();
		let fecha = $("#fecha_select").val();
		let id = $("#recintos_id").val();
		$.ajax({
			url: `/api/load/${id}/agenda/${fecha}/webview`,
			type: 'GET',
			headers: { Authorization: `Bearer {{ $tkn }}` },
		})
		.done(function(response) {
			// console.log(response);
			// SACAR SEGUNDOS DE LA FECHA
			$("#bloques").show();
			$.each(response, function(index, val) {
				// console.log(val);
				$("#bloques").append(`
					<div class="col-4">
						<a class="hora ${(val.estado == 'Disponible') ? 'hora-personalizada' : 'no-disponible'} ${val.estado=='Reservado' ? 'desactivado' : ''}"
							id="hour_${val.id}" data-id="${val.id}" 
							onclick="selecHora(${val.id})">
								${val.hora_inicio_bloque} - ${val.hora_fin_bloque}
						</a>
					</div>
				`);
			});
		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
	};
	$("#fecha_select").change(function(event) {
		/* Act on the event */
		// console.log($(this),$(this).val());
		$("#bloques").empty();
		let id = $("#recintos_id").val();
		let cont = 0;
		$.ajax({
			url: `/api/load/${id}/agenda/${$(this).val()}/webview`,
			type: 'GET',
			headers: { Authorization: `Bearer {{ $tkn }}` },
		})
		.done(function(response) {
			alert(response);
			console.log(response);
			$("#bloques").show();
			$.each(response, function(index, val) {
				// console.log(val);
				$("#bloques").append(`
					<div class="col-4">
						<a class="hora ${(val.estado == 'Disponible') ? 'hora-personalizada' : 'no-disponible'} ${val.estado=='Reservado' ? 'desactivado' : ''}" 
							id="hour_${val.id}" data-id="${val.id}" 
							onclick="selecHora(${val.id})">
								${val.hora_inicio_bloque} - ${val.hora_fin_bloque}
						</a>
					</div>
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
	function selecHora (id) {
		// console.log($(this));
		let element = document.querySelector(`#hour_${id}`);
		if ( $(`#hour_${id}`).hasClass('desactivado') ) {
			return;
		};
		let current = $("#horario_selected").val();
		if (id != current) {
			$(`#hour_${current}`).removeClass('no-disponible');
			$(`#hour_${current}`).addClass('hora-personalizada');
		};
		/* hora-personalizada SELECCIONAR NUEVO ########## */
		$("#horario_selected").val(id);
		// console.log(element.classList.contains("no-disponible"), element);
		if ( $(`#hour_${id}`).hasClass('no-disponible') ) {
			$(`#hour_${id}`).removeClass('no-disponible');
			$(`#hour_${id}`).addClass('hora-personalizada');
		} else {
			$(`#hour_${id}`).removeClass('hora-personalizada');
			$(`#hour_${id}`).addClass('no-disponible');
		};
		$("#terminos_div").show();
	}
</script>

{{-- @endsection --}}
