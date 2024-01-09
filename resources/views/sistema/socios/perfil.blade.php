@section('title'){{ 'Agendamiento' }}@endsection
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
		<h1>Perfil</h1>
	</div>
</header>

<div class="container mt-contenido text-center">
    <div class="row">
        <div class="col-12">
            <img class="avatar-perfil" src="{{ auth()->user()->profile_photo_url ?? asset('recursos/img/generic-profile.jpg') }}" alt="">
        </div>
        <div class="col-12">
            <h3>Juan Cavieres</h3>
            <p>Santiago,Chile</p>
        </div>
    </div>
</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bloque-cuadro pd-cuadro">
                <small>Nombre</small>
					<p>Juan Cavieres</p>
                <small>E-mail</small>
                <p>jca2213@example.com</p>
                <small>Teléfono</small>
                <p>+569 1245 5233</p>
                <small>Contraseña</small>
                <p>****</p>
                <a href="#" class="btn btn-secondary">Editar Datos</a>
				</div>
			</div>
		</div>
  <div class="row">    
    <div class="col-12">
        <div class="row">
            <div class="col">
                <a href="#" class="btn btn-secondary2 mb-25 mt-25">Cerrar Sesion</a>
            </div>
        </div>
    </div>
	</div>
@endsection
