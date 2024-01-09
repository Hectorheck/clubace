@section('title'){{ 'Agenda' }}@endsection
@extends('sistema.socios.layout')
@section('content')
@include('sistema.socios.menu')
@php
/* ########## Variables globales para la vista ########## */
setlocale(LC_TIME, "ES");
$head = strftime('%B %Y', $fecha->format('U'));
$anterior = date_create($fecha->format('d-m-Y'))->modify('-1 month');
$posterior = date_create($fecha->format('d-m-Y'))->modify('+1 month');
// dump($anterior,$posterior, $fecha);
@endphp
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
		<h1>Agenda</h1>
	</div>
</header>

<div class="container mt-contenido">
	<div class="row">
		<div class="col-12 mb-25">
			<div class="row">
				<div class="col-12">
					<div class="bloque-cuadro mb-0 pd-cuadro calendario">
						<!-- CALENDARIO-->
						<div class="row mes">
							<div class="col-3">
								<a href="{{ route('agenda', ['mes' => $anterior->format('m'), 'ano' => $anterior->format('Y')]) }}">
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									  <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
									</svg>
								</a>
							</div>
							<div class="col-6 text-center"><a href="{{ route('agenda', ['mes' => date('m'), 'ano' => date('Y')]) }}">{{ ucfirst($head) }}</a></div>
							<div class="col-3 text-right">
								<a href="{{ route('agenda', ['mes' => $posterior->format('m'), 'ano' => $posterior->format('Y')]) }}">
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									  <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
									</svg>
								</a>
							</div>
						</div>
						<div class="row semana text-center">
							<div class="col">L</div>
							<div class="col">M</div>
							<div class="col">M</div>
							<div class="col">J</div>
							<div class="col">V</div>
							<div class="col">S</div>
							<div class="col">D</div>
						</div>
						@foreach($semanas as $semana)
						@php
						foreach ($semana as $key => $val) {
							$date = $fecha->format('Y-m-').$val;
							// dump($date);
							$event = $agenda->where('dia', $val);
							if (count($event) > 0) {
								$clase[$key] = "activo day";
								$data[$key] = $date;
							} else {
								$clase[$key] = "";
								$data[$key] = $date;
							}
						}
						@endphp
						<div class="row dias text-center">
							{!! isset($semana[1]) ? '<div class="col"><a class="'.$clase[1].'" href="#" data-date="'.$data[1].'">'.$semana[1].'</a></div>' : '<div class="col"><a class="" href="#"></a></div>' !!}
							{!! isset($semana[2]) ? '<div class="col"><a class="'.$clase[2].'" href="#" data-date="'.$data[2].'">'.$semana[2].'</a></div>' : '<div class="col"><a class="" href="#"></a></div>' !!}
							{!! isset($semana[3]) ? '<div class="col"><a class="'.$clase[3].'" href="#" data-date="'.$data[3].'">'.$semana[3].'</a></div>' : '<div class="col"><a class="" href="#"></a></div>' !!}
							{!! isset($semana[4]) ? '<div class="col"><a class="'.$clase[4].'" href="#" data-date="'.$data[4].'">'.$semana[4].'</a></div>' : '<div class="col"><a class="" href="#"></a></div>' !!}
							{!! isset($semana[5]) ? '<div class="col"><a class="'.$clase[5].'" href="#" data-date="'.$data[5].'">'.$semana[5].'</a></div>' : '<div class="col"><a class="" href="#"></a></div>' !!}
							{!! isset($semana[6]) ? '<div class="col"><a class="'.$clase[6].'" href="#" data-date="'.$data[6].'">'.$semana[6].'</a></div>' : '<div class="col"><a class="" href="#"></a></div>' !!}
							{!! isset($semana[7]) ? '<div class="col"><a class="'.$clase[7].'" href="#" data-date="'.$data[7].'">'.$semana[7].'</a></div>' : '<div class="col"><a class="" href="#"></a></div>' !!}
						</div>
						@endforeach
						{{-- <div class="row dias text-center">
							<div class="col"><a class="" href="#"></a></div>
							<div class="col"><a class="" href="#"></a></div>
							<div class="col"><a class="" href="#">1</a></div>
							<div class="col"><a class="" href="#">2</a></div>
							<div class="col"><a class="" href="#">3</a></div>
							<div class="col"><a class="" href="#">4</a></div>
							<div class="col"><a class="" href="#">5</a></div>
						</div>
						<div class="row dias text-center">
							<div class="col"><a class="" href="#">6</a></div>
							<div class="col"><a class="" href="#">7</a></div>
							<div class="col"><a class="" href="#">8</a></div>
							<div class="col"><a class="" href="#">9</a></div>
							<div class="col"><a class="" href="#">10</a></div>
							<div class="col"><a class="" href="#">11</a></div>
							<div class="col"><a class="" href="#">12</a></div>
						</div>
						<div class="row dias text-center">
							<div class="col"><a class="" href="#">13</a></div>
							<div class="col"><a class="" href="#">14</a></div>
							<div class="col"><a class="" href="#">15</a></div>
							<div class="col"><a class="" href="#">16</a></div>
							<div class="col"><a class="" href="#">17</a></div>
							<div class="col"><a class="" href="#">18</a></div>
							<div class="col"><a class="" href="#">19</a></div>
						</div>
						<div class="row dias text-center">
							<div class="col"><a class="" href="#">20</a></div>
							<div class="col"><a class="activo" href="#">21</a></div>
							<div class="col"><a class="" href="#">22</a></div>
							<div class="col"><a class="" href="#">23</a></div>
							<div class="col"><a class="" href="#">24</a></div>
							<div class="col"><a class="" href="#">25</a></div>
							<div class="col"><a class="" href="#">26</a></div>
						</div>
						<div class="row dias text-center">
							<div class="col"><a class="" href="#">27</a></div>
							<div class="col"><a class="" href="#">28</a></div>
							<div class="col"><a class="" href="#">29</a></div>
							<div class="col"><a class="" href="#">30</a></div>
							<div class="col"><a class="" href="#"></a></div>
							<div class="col"><a class="" href="#"></a></div>
							<div class="col"><a class="" href="#"></a></div>
						</div> --}}
						<!-- TERMINO CALENDARIO-->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="mt-auto pt-0">
	@foreach($agenda as $evento)
	{{-- @dump($evento) --}}
	@php
	setlocale(LC_TIME, "ES");
	$date = date_create($evento->fecha)->format('U');
	$dia = ucfirst(strftime('%A', $date));
	$num = strftime('%e', $date);
	$mes = ucfirst(strftime('%B', $date));
	$ano = strftime('%G', $date);
	@endphp
	<div class="container">
		<div class="row">
			<div class="col">
				<h4>{{ strtoupper($evento->recintos->servicios->nombre) }} {{-- $dia.' '.$num.' de '.$mes.', '.$ano --}}{{-- Martes 21 de Enero, 2021 --}}</h4>
			</div>
		</div>
	</div>
	<div class="bloque-footer pd-cuadro box-cuadro pt-25">
		<div class="container">
			<form action="" class="w-100">
				<div class="row">
					<div class="col-12">
						<div class="row">
							<div class="col-3">
								<a class="hora hora-neutro" data-toggle="modal" data-target="#ModalEvento-{{ $evento->id }}">Detalle {{-- $evento->hora_inicio_bloque --}}{{-- 08:00 --}}</a>
							</div>
							<div class="col-9">
								<p>{{ $evento->recintos->clubes->display_name }}, {{ $evento->recintos->nombre }}{{-- Club de tenis Vitacura --}} ({{ $dia.' '.$num.' de '.$mes.', '.$ano }}).</p>
							</div> 
							<div class="col-12"><hr></div>    
						</div>
					</div>
				</div>
			 </form>
		</div>
	</div>
	@endforeach
	{{-- <div class="container">
		<div class="row">
			<div class="col">
				<h4>Martes 21 de Enero, 2021</h4>
			</div>
		</div>
	</div>
	<div class="bloque-footer pd-cuadro box-cuadro pt-25">
		<div class="container">
			<form action="" class="w-100">
				<div class="row">
					<div class="col-12">
						<div class="row">
							<div class="col-3">
								<a class="hora hora-neutro" href="#">08:00</a>
							</div>
							<div class="col-9">
								<p>Club de tenis Vitacura</p>
							</div> 
							<div class="col-12"><hr></div>    
						</div>
						<div class="row">
							<div class="col-3">
								<a class="hora hora-neutro" href="#">09:00</a>
							</div>
							<div class="col-9">
								<p>Club de tenis La Reina</p>
							</div> 
							<div class="col-12"><hr></div>    
						</div>
						<div class="row">
							<div class="col-3">
								<a class="hora hora-neutro" href="#">18:00</a>
							</div>
							<div class="col-9">
								<p>Evento de prueba, ipsum dolor sit amet consectetur adipisicing elit.</p>
							</div> 
							<div class="col-12"><hr></div>
						</div>
					</div>
				</div>
			 </form>
		</div>
	</div> --}}
</div>
<!-- Modal -->
@foreach($agenda as $evento)
<div class="modal fade" id="ModalEvento-{{ $evento->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Evento {{ $evento->recintos->clubes->display_name }}, {{ $evento->recintos->nombre }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				@if($evento->transaction()->exists())
				<p><b>Metodo de Pago: </b>{{ $evento->reserva->forma_pago }} </p>
					@endif
				<p><b>Código Transacción: </b>{{ $evento->id }} </p>
				<p><b>Bloque: </b>{{ $evento->hora_inicio_bloque }} - {{ $evento->hora_fin_bloque }}</p>
			</div>
			<div class="modal-footer">
			<div class="col-12">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Volver</button>
				</div>
				<div class="col-12">
				@if($evento->transaction()->exists())
				<form action="{{ route('arrendamiento.estado') }}" method="post">
				@csrf
				<input type="hidden" name="token_ws" value={{ $evento->transaction->token }} />
				<button type="submit" class="btn btn-success">Consultar Transacción Transbank</button>
				</form>
				@endif
			</div>
			</div>
		</div>
	</div>
</div>
@endforeach

{{-- MODAL DIA AJAX --}}
{{-- <div class="modal fade" id="ModalEvento-{{ $evento->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Evento {{ $evento->recintos->clubes->display_name }}, {{ $evento->recintos->nombre }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				@if($evento->transaction()->exists())
				<p><b>Metodo de Pago: </b>{{ $evento->reserva->forma_pago }} </p>
					@endif
				<p><b>Código Transacción: </b>{{ $evento->id }} </p>
				<p><b>Bloque: </b>{{ $evento->hora_inicio_bloque }} - {{ $evento->hora_fin_bloque }}</p>
			</div>
			<div class="modal-footer">
			<div class="col-12">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Volver</button>
				</div>
				<div class="col-12">
				@if($evento->transaction()->exists())
				<form action="{{ route('arrendamiento.estado') }}" method="post">
				@csrf
				<input type="hidden" name="token_ws" value={{ $evento->transaction->token }} />
				<button type="submit" class="btn btn-success">Consultar Transacción Transbank</button>
				</form>
				@endif
			</div>
			</div>
		</div>
	</div>
</div> --}}
{{-- MODAL DIA AJAX --}}

@endsection
@section('script')
<script type="text/javascript">
	$(".day").click(function(event) {
		/* Act on the event */
		console.log($(this).attr('data-date'));
	});
</script>
@endsection
