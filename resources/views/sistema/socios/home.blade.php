@section('title'){{ 'Inicio' }}@endsection
@extends('sistema.socios.layout')
@section('content')
@include('sistema.socios.menu')
<header class="bg-transparente">
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
	</div>
</header>

<div class="mt-auto mb-25">
	<div class="container">
		<div class="row">
			<div class="col text-center">
				<img class="logo-blanco" src="{{asset('recursos/img/logoaceclub-blanco.png')}}" alt="">
			</div>
		</div>
		<div class="row">
			<div class="col-6">
				<div class="bloque-home-menu">
					<a href="{{ route('editar-perfil') }}">
						<img src="{{asset('recursos/img/iconos/perfil-b.svg')}}" alt="">
						Perfil 
					</a>
				</div>
			</div>
			<div class="col-6">
				<div class="bloque-home-menu">
					@if(is_null($club))
					<a href="{{ route('lista-clubes') }}">
					@else
					<a href="{{ route('servicios', $club->id) }}">
					@endif
						<img src="{{asset('recursos/img/iconos/club-b.svg')}}" alt="">
						Mi Club
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-6">
				<div class="bloque-home-menu">
					<a href="{{ route('lista-clubes' )}}">
						<img src="{{asset('recursos/img/iconos/ubicacion-b.svg')}}" alt="">
						Clubes 
					</a>
				</div>
			</div>
			<div class="col-6">
				<div class="bloque-home-menu">
					<a href="{{ route('agenda') }}">
						<img src="{{asset('recursos/img/iconos/agenda-b.svg')}}" alt="">
						Agenda
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

@endsection
