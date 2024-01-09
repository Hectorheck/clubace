{{-- @dd($dias) --}}
@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Agendamiento
	@parent
@stop
@section('header_styles')
<link type="text/css" rel="stylesheet" href="{{asset('vendors/Buttons/css/buttons.min.css')}}"/>
<!--End of global styles-->
<!--Page level styles-->
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/buttons.css')}}"/>
@stop

{{-- Page content --}}
@section('content')
	<!-- Content Header (Page header) -->
	<header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-lg-6">
					<h4 class="nav_top_align skin_txt">
						<i class="fa fa-file-o"></i>
						Horarios Instalacion {{ strtoupper($recinto->nombre) }}
					</h4>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}">
								<i class="fa ti-file" data-pack="default" data-tags=""></i>Inicio
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route('servicios.index', $recinto->clubes_id) }}">Servicio</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route('recintos.index', $recinto->servicios_id) }}">Instalacion</a>
						</li>
						<li class="breadcrumb-item active">Horarios</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="outer">
		<div class="inner bg-light lter bg-container">
			<div class="row">
				@php
				use App\Models\Agenda;
				setlocale(LC_TIME, "ES");
				@endphp
				<div class="col">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="card m-t-35">
						<div class="card-header bg-white">
							<i class="fa fa-table"></i> Fechas
						</div>
						<div class="card-body">
							<div class="table-responsive-sm m-t-35" style="overflow-x:auto;">
								<table class="table table-striped table-advance table-responsive">
									<thead>
										<tr>
											@foreach ($dias as $ag)
											@php
											$dia = date_create($ag->fecha)
											@endphp
											<th>{{-- date('l d M', strtotime($ag->fecha)) --}}
												<button type="button" class="btn" data-toggle="modal" data-target="#modalDia-{{ $ag->dia }}">
													{{ utf8_encode(strftime('%a %d %b', $dia->format('U'))) }}
													@if($ag->estado=="Disponible")
													<span><i class="fa fa-ban"></i></span>
													@else
													<span><i class="fa fa-check-circle"></i></span>
													@endif
												</button>
											</th>
											@endforeach
										</tr>
									</thead>
									<tbody>
										<tr>
											@foreach ($dias as $ag)
											<td class="highlight">
												@foreach (Agenda::where('recintos_id', $recinto->id)->whereFecha($ag->fecha)->get() as $hora)
												@php
												switch ($hora->estado) {
													case 'Disponible': list($btn, $stat) = ['primary', '']; break;
													case 'Bloqueado': list($btn, $stat) = ['danger', '']; break;
													case 'Reservado': list($btn, $stat) = ['warning', 'reservado']; break;
													default: list($btn, $stat) = ['primary', '']; break;
												}
												@endphp
												<button type="button" class="btn btn-block btn-{{ $btn }} btn-lg hora" data-toggle="modal" data-target="#modalHora" data-status="{{ $stat }}" id="{{ base64_encode($hora->id) }}" style="min-width:115px">{!! $hora->hora_inicio_bloque."<br>".$hora->hora_fin_bloque !!}</button>
												@endforeach
											</td>
											@endforeach
										</tr>
									</tbody>
								</table>
							</div>
							<a href="{{ route('recintos.index', $recinto->servicios_id) }}" class="btn btn-primary">Volver</a>
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->
				</div>
			</div>
		</div>
		<!-- /.inner -->
	</div>
	<!-- /.outer -->
	<!-- /.content -->
<div class="modal fade" id="modalHora" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modalLabel">Detalle horario</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form method="post" id="form_horario">
				@csrf
				@method('PUT')
				<div class="modal-body" id="modal_body">
					{{-- <p>This is a modal window. You can do the following things with it:</p>
					<ul>
						<li>
							<strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.
						</li>
						<li>
							<strong>Look:</strong> a modal window enjoys a certain kind of attention; just look at it and appreciate its presence.
						</li>
						<li>
							<strong>Close:</strong> click on the button below to close the modal.
						</li>
					</ul> --}}
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="submit" {{-- data-dismiss="modal" --}}>Cambiar Estado</button>
				</div>
			</form>
		</div>
	</div>
</div>

@foreach ($dias as $dia)
{{-- 30 modales aprox por 30 dias --}}
<div class="modal fade" id="modalDia-{{ $dia->dia }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modalLabel">Bloquear dia completo</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ ($dia->estado=="Disponible") ? route('recintos.block.day',$dia->recintos_id) : route('recintos.unblock.day',$dia->recintos_id) }}" method="post">
				@csrf
				@method('PUT')
				<div class="modal-body">
					<input type="hidden" name="dia" value="{{ $dia->dia }}">
					<input type="hidden" name="agno" value="{{ $dia->agno }}">
					<input type="hidden" name="mes" value="{{ $dia->mes }}">
					<textarea name="comentario" placeholder="Comentario" class="form-control" maxlength="30">{{ $dia->comentario }}</textarea>&nbsp;
					@if($dia->estado=="Disponible")
					<p>¿Seguro que desea bloquear el día completo?</p>
					@else
					<p>¿Seguro que desea habilitar el día completo?</p>
					@endif
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger" type="submit" {{-- data-dismiss="modal" --}}>{{ ($dia->estado=="Disponible") ? 'Bloquear' : 'Habilitar'}}</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach
@stop

@section('footer_scripts')
<script>
$('.hora').click(function(e) {
	$("#modal_body").empty();
	var self = $(this);
	let id = self.attr('id')
	let putUri = `/recintos/horarios/status/${id}`;
	$("#form_horario").attr('action', putUri);
	$.ajax({
		url: `/recintos/horarios/${id}/get-data`,
		type: 'GET',
	})
	.done(function(response) {
		console.log(response, response.agenda.comentario);
		if (response.reserva === null) {
			let parrafo = `<p><strong>Estado:</strong> ${response.agenda.estado}</p><ul><li><strong>Fecha:</strong> ${response.agenda.fecha}</li><li><strong>Inicio:</strong> ${response.agenda.hora_inicio_bloque}</li><li><strong>Fin:</strong> ${response.agenda.hora_fin_bloque}</li></ul><br><textarea name="comentario" placeholder="Comentario" class="form-control" maxlength="30">${response.agenda.comentario ?? ''}</textarea>&nbsp;`;
			$("#modal_body").append(parrafo);
			// console.log('No ha sido reservado');
		} else {
			let parrafo = `<p><strong>Estado:</strong> ${response.agenda.estado}</p><p><strong>Usuario:</strong> ${response.reserva.users.nombres} (${response.reserva.users.email})</p><ul><li><strong>Fecha:</strong> ${response.agenda.fecha}</li><li><strong>Inicio:</strong> ${response.agenda.hora_inicio_bloque}</li><li><strong>Fin:</strong> ${response.agenda.hora_fin_bloque}</li></ul><br>
				<textarea name="comentario" class="form-control" maxlength="30"> ${response.agenda.comentario}</textarea>&nbsp;`;
			$("#modal_body").append(parrafo);
			// console.log('Reservado');
		}
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
});
// $('.hora').click(function() {
// 	var self = $(this);
// 	let action = self.hasClass('btn-primary') ? 'deshabilitar' : 'habilitar';
// 	var c = confirm(`Seguro que desea ${action} esta bloque horario?`);
// 	self.prop('disabled', true);
// 	if (c == true) {
// 		if (self.attr('data-status') != "reservado") {
// 			var hora = self.attr('id');
// 			$.ajax({
// 				url: `{{ asset('recintos/horarios/status') }}/${hora}`,
// 				type: 'GET',
// 				cache: false
// 			})
// 			.done(function(resp) {
// 				console.log(resp);
// 				if (resp == "success") {
// 					if (self.hasClass('btn-primary')) {
// 						self.removeClass('btn-primary').addClass('btn-danger');
// 					}else{
// 						self.removeClass('btn-danger').addClass('btn-primary');
// 					}
// 				}
// 			})
// 			.fail(function() {
// 				alert('Algo salio mal, por favor vuelva a cargar la pagina');
// 			})
// 			.always(function() {
// 				self.prop('disabled', false);
// 			});
// 		}
// 	}
// });
</script>
@stop
