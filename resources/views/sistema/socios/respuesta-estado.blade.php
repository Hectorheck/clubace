@php
$logotipo = $agenda->recintos->clubes->logo_url ? Storage::disk('public')->url($agenda->recintos->clubes->logo_url) : asset('img/clubes/logotipo.png');
@endphp
@section('title'){{ 'Arrendamiento' }}@endsection
@extends('sistema.socios.layout')
@section('content')
@include('sistema.socios.menu')
<header class="bg-anaranjado" style="background-color:{{$agenda->recintos->clubes->color_2 }}!important">
	<div class="degradado">
		<div class="iconos-header">
			<div class="row">
				<div class="col">
					<a href="{{ asset('/') }}">
						<img class="iconos" src="{{ asset('recursos/img/iconos/volver.svg') }}">
					</a>
				</div>
				<div class="col text-right">
					{{-- <span class="notificacion">412</span> --}}
					<a href="#">
						<img class="iconos" src="{{ asset('recursos/img/iconos/notificacion.svg') }}">
					</a>
					<a onclick="showmenu()" href="#">
						<img class="iconos icono-menu" src="{{ asset('recursos/img/iconos/menu.svg') }}">
					</a>
				</div>
			</div>
		</div>
		<h1>Transacción Transbank</h1>

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
								<h3>{{ $agenda->recintos->clubes->display_name }}</h3>
								<p>{{ $agenda->recintos->clubes->direccion_calle }} {{ $agenda->recintos->clubes->direccion_numero }}, {{ $agenda->recintos->clubes->comunas->nombre }},{{-- La Reina, --}} {{ $agenda->recintos->clubes->comunas->regiones->codigo }}</p>

							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="bloque-cuadro logo-cuadro d-flex align-items-center ">
							<img src="{{ $logotipo }}" alt="{{ $agenda->recintos->clubes->display_name }}">
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
				<h4 class="text-lg">Estado Transbank</h4>
			</div>
		</div>
	</div>
	<div class="bloque-footer pd-cuadro box-cuadro pt-25">
		<div class="container">
			<div class="row">

				<div class="col-12">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Código Transacción:</th>
								<td>{{$agenda['id']}}</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">Código Reserva</th>
								<td>{{$agenda['reserva_id']}}</td>
							</tr>
							<tr>
								<th scope="row">Numero de Tarjeta</th>
								<td>**** **** **** {{ $response_transbank->getCardNumber() }}</td>
							</tr>
							<tr>
								<th scope="row">Código de Autorización</th>
								<td>@foreach ($response_transbank->getDetails() as $detail)
										{{$detail->getAuthorizationCode()}}
								@endforeach</td>
							</tr>
							<tr>
								<th scope="row">Valor</th>
								<td>@foreach ($response_transbank->getDetails() as $detail)
										{{$detail->getAmount()}}
								@endforeach</td>
							</tr>
							<tr>
								<th scope="row">Estado</th>
								<td>@foreach ($response_transbank->getDetails() as $detail)
										{{$detail->getStatus()}}
								@endforeach</td>
							</tr>
							
							<tr>
								<th scope="row">Fecha</th>
								<td>{{$agenda['fecha']}}</td>
							</tr>
							<tr>
								<th scope="row">Hora Inicio</th>
								<td>{{$agenda['hora_inicio_bloque']}}</td>
							</tr>
							<tr>
								<th scope="row">Hora Termino</th>
								<td>{{$agenda['hora_fin_bloque']}}</td>
							</tr>
							<tr>
								<th scope="row">Recinto</th>
								<td>{{$agenda['recintos']['nombre']}}</td>
							</tr>
						</tbody>
					</table>
				</div>


			</div>


		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>

@endsection