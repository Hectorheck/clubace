@section('title'){{ 'Clubes' }}@endsection
@extends('sistema.socios.layout')
@section('content')
@include('sistema.socios.menu')
<header class="bg-club" style="background-image: url(/recursos/img/bg-login.jpg)">
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
		<h1>Clubes</h1>
	</div>
</header>

<div class="container mt-contenido">
	<div class="row">
		<div class="col">
			<h2>Selecciona un Club</h2>
		</div>
	</div>
	<div class="row">
		@foreach($clubes as $club)
		{{-- @dump($club) --}}
		<div class="col-12 col-md-6 mb-25">
			<a href="{{ route('servicios', $club->id) }}">
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
						<div class="bloque-cuadro logo-cuadro d-flex align-items-center">
							<img src="{{ asset('storage/img/clubes/'.$club->id.'.png')}}" alt="{{ $club->display_name }}">
						</div>
					</div>
				</div>
			</a>
		</div>
		@endforeach
		{{-- <div class="col-12 col-md-6 mb-25">
			<a href="agendamiento.html">
				<div class="row align-items-center">
					<div class="col-10">
						<div class="bloque-cuadro mb-0 pd-cuadro">
							<div class="info-cuadro">
								<img src="img/iconos/ubicacion.svg" alt="">
								<h3>Club de Tenis</h3>
								<p>Vitacura 433321, Santiago, Vitacura, RM</p>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="bloque-cuadro logo-cuadro d-flex align-items-center bg-azul">
							<img src="img/logos/tennis.jpg" alt="">
						</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-12 col-md-6 mb-25">
			<a href="">
				<div class="row align-items-center">
					<div class="col-10">
						<div class="bloque-cuadro mb-0 pd-cuadro">
							<div class="info-cuadro">
								<img src="img/iconos/ubicacion.svg" alt="">
								<h3>Tennis One</h3>
								<p>Av. las Condes 43424, Santiago, Las Condes, RM</p>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="bloque-cuadro logo-cuadro d-flex align-items-center">
							<img src="img/logos/tennis-one.jpg" alt="">
						</div>
					</div>
				</div>
			</a>
		</div> --}}
	</div>
</div>
@endsection
