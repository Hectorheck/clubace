@section('title'){{ 'Servicios' }}@endsection
@extends('sistema.socios.layout')
@section('content')
@include('sistema.socios.menu')
	<header class="">
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
			<h1>{{-- Servicios --}} {{ $club->display_name }}</h1>
		</div>
	</header>
	@if(count(auth()->user()->clubes->where('estado', 'ACEPTADO')) < 1)
	{{-- <div class="container mt-contenido">
		<a href="{{ route('solicitar', $club->id) }}" class="btn btn-warning"><i class="fas fa-sign-in-alt"></i> Solicitar Membresía</a>
	</div> --}}
	@endif

	<div class="container mt-contenido">
		<div class="row">
			@foreach($servicios as $servicio)
			@php
			$imagen = Storage::disk('public')->url('img/servicios/'.$servicio->id.'.png');
			@endphp
			<div class="col-12 col-sm-6">
				<a href="{{ ((bool)$servicio->socios) ? route('agendamiento', $servicio->id) : route('arrendamiento', $servicio->id) }}">
				<div class="bloque-cuadro img-bg-cuadro" style="background-image: url('{{ $imagen }}');">
					<div class="degradado">
						<div class="row align-items-end">
							<div class="col"><strong class="fz20">{{ $servicio->nombre }}</strong></div>
							<!-- <div class="col text-right fz14">432 Clubes</div> -->
						</div>
					</div>
				</div>
				</a>
			</div>
			@endforeach
			{{-- <div class="col-12 col-sm-6">
				<a href="lista-clubes.html">
				<div class="bloque-cuadro img-bg-cuadro img-tenis">
					<div class="degradado">
						<div class="row align-items-end">
							<div class="col"><strong class="fz20">Tenis</strong></div>
							<!-- <div class="col text-right fz14">432 Clubes</div> -->
						</div>
					</div>
				</div>
				</a>
			</div>
			<div class="col-12 col-sm-6">
				<a href="lista-clubes.html">
				<div class="bloque-cuadro img-bg-cuadro img-futbol">
					<div class="degradado">
						<div class="row align-items-end">
							<div class="col"><strong class="fz20">Fútbol</strong></div>
							<!-- <div class="col text-right fz14">432 Clubes</div> -->
						</div>
					</div>
				</div>
				</a>
			</div>
			<div class="col-12 col-sm-6">
				<a href="lista-clubes.html">
				<div class="bloque-cuadro img-bg-cuadro img-basketball">
					<div class="degradado">
						<div class="row align-items-end">
							<div class="col"><strong class="fz20">Basketball</strong></div>
							<!-- <div class="col text-right fz14">432 Clubes</div> -->
						</div>
					</div>
				</div>
				</a>
			</div> --}}
		</div>
	</div>
@endsection
