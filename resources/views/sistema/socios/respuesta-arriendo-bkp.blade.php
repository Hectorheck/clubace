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
		<h1>Respuesta Arriendo</h1>

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
				<h4>Respuesta Arriendo Transbank</h4>
			</div>
		</div>
	</div>
	<div class="bloque-footer pd-cuadro box-cuadro pt-25">
		<div class="container">
			<div class="row">

				<div class="col-6">
					<h2 class="text-lg">Token Transbank</h2>
					<pre>{{ print_r($token , true)  }}</pre>
				</div>

				<div class="col-6">
					<h2 class="text-lg">Respuesta Transbank</h2>
					@if ($response_transbank->isApproved())
					<span class="text-green-700 text-xl my-2 inline-block font-bold">Transacción aprobada</span>
					@else
					<span class="text-red-700 text-xl my-2 inline-block font-bold">Transacción rechazada</span>
					@endif
					<pre>{{ print_r($response_transbank, true) }}</pre>
				</div>
			</div>
			<h2 class="text-lg">Obtener status de la transacción</h2>
			<form class="w-100" action="{{ route('arrendamiento.estado') }}" method="post">
			@csrf
			<input type="hidden" name="token" id="token" value="{{ $token }}">
				<button type="submit">Consultar estado</button>
			</form>
			<h2 class="text-lg">Reembolso de la transacción</h2>
			<form action="{{ route('arrendamiento.reembolso') }}" method="post" class="w-100">
				@csrf
				<input type="hidden" name="token" id="token" value="{{ $token }}">

				<input type="hidden" name="commerce_code" value="{{ $response_transbank->getDetails()[0]->commerceCode }}">

				<input type="hidden" name="buy_order" value="{{ $response_transbank->getDetails()[0]->buyOrder }}">

				<input type="hidden" name="amount" id="amount" value="{{ $response_transbank->getDetails()[0]->amount }}">

				<button type="submit">Solicitar reembolso</button>
			</form>
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>

@endsection