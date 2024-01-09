<div class="menu" id="menu">
	<div class="header">
		<img src="{{ auth()->user()->profile_photo_url ?? asset('recursos/img/generic-profile.jpg') }}">
		<h5>{{ auth()->user()->nombres }}</h5>
		@if(!is_null(auth()->user()->comunas))
		<p>{{ auth()->user()->ciudad }}, {{ is_null(auth()->user()->comunas) ? '' : auth()->user()->comunas->nombre }}</p>
		@endif
	</div>
	<ul>
		<li>
			<a href="{{ route('editar-perfil') }}">
				<img src="{{ asset('recursos/img/iconos/perfil.svg') }}">
				Perfil
			</a>
		</li>
		<li>
			@php
			use App\Models\Clubes;
			$clubid = (count(auth()->user()->clubes) > 0) ? auth()->user()->clubes->first()->clubes_id : 0;
			$club = Clubes::find($clubid);
			@endphp
			@if(is_null($club))
			<a href="{{ route('lista-clubes') }}">
			@else
			<a href="{{ route('servicios', $club->id) }}">
			@endif
				<img src="{{ asset('recursos/img/iconos/club.svg') }}">
				Mi Club
			</a>
		</li>
		<li>
			<a href="{{ route('lista-clubes') }}">
				<img src="{{ asset('recursos/img/iconos/ubicacion.svg') }}">
				Clubes
			</a>
		</li>
		<li>
			<a href="{{ route('agenda') }}">
				<img src="{{ asset('recursos/img/iconos/agenda.svg') }}">
				Agenda
			</a>
		</li>
		{{-- <li>
			<center>
				<button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
			</center>
		</li>
		<li>
			<form action="{{ route('notification') }}" method="POST">
				@csrf
				<button type="submit" class="btn btn-primary">Send Notification</button>
			</form>
		</li> --}}
		<li class="cerrar">
			<form method="post" id="close_session" action="{{ route('logout') }}">
			@csrf
			{{-- <button type="submit"><img src="{{ asset('recursos/img/iconos/sesion.svg') }}"> Cerrar Sesión</button> --}}
			<a href="#" onclick="return logoutJs()">
				<img src="{{ asset('recursos/img/iconos/sesion.svg') }}">
				Cerrar Sesión
			</a>
			</form>
		</li>
	</ul>
</div>