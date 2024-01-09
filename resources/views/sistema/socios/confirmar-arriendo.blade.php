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
		<h1>Pagar Arriendo</h1>

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
				<h4>Confirmar Arriendo</h4>
			</div>
		</div>
	</div>
	{{-- @dd($response_transbank,$request_transbank) --}}
	<div class="bloque-footer pd-cuadro box-cuadro pt-25">
		<div class="container">
			<form action={{  $response_transbank->getUrl() }}>
				@csrf
				@method('PUT')
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
									<th scope="row">Valor</th>
									<td>{{$request_transbank['details'][0]['amount']}}</td>
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

					<div class="col-12">
						<div class="col">
							<a href="#" data-toggle="modal" data-target="#modalPay" class="btn btn-success mb-25 mt-25">Continuar</a>
						</div>
					</div>




				</div>
				{{-- MODAL --}}
				<div class="modal fade bd-example-modal-lg" id="modalPay" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Transbank</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<div class="modal-body">
								<p>Continuar en Transbank</p>
								<input type="hidden" name="token_ws" value={{ $response_transbank->getToken() }} />


							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" data-dismiss="modal">Volver</button>
								<button type="submit" class="btn btn-success">Confirmar</button>
							</div>
						</div>
					</div>
				</div>
				{{-- MODAL --}}
			</form>
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>

@endsection