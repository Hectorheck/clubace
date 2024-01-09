@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
Transacciones recinto
@parent
@stop
{{-- page level styles --}}
@section('header_styles')
<!--plugin styles-->
<link rel="stylesheet" href="{{asset('vendors/intl-tel-input/css/intlTelInput.css')}}">
<link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrapvalidator/css/bootstrapValidator.min.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('vendors/sweetalert/css/sweetalert2.min.css')}}" />
<!--End of plugin styles-->
<!--Page level styles-->
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/sweet_alert.css')}}" />
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/form_layouts.css')}}" />
<!-- end of page level styles -->

<!-- additions -->
<style>
	#mapa {
		border-radius: .25rem;
		min-height: 250px;
		max-height: 350px;
		height: -webkit-fill-available
	}
</style>
<!-- End additions -->
@stop
@section('content')
<header class="head">
	<div class="main-bar">
		<div class="row no-gutters">
			<div class="col-sm-5 col-lg-6 skin_txt">
				<h4 class="nav_top_align">
					<i class="fa fa-pencil"></i>
					Lista de transacciones
				</h4>
			</div>
			<div class="col-sm-7 col-lg-6">
				<ol class="breadcrumb float-right nav_breadcrumb_top_align">
					<li class="breadcrumb-item">
						<a href="{{ route('/') }}"><i class="fa fa-home" data-pack="default" data-tags=""></i> Inicio</a>
					</li>
					<li class="breadcrumb-item">
						<a href="{{ route('servicios.index', $servicio->clubes->id) }}">Servicios</a>
					</li>
					<li class="active breadcrumb-item">Transacciones {{-- Transbank --}}</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="outer">
	<div class="inner bg-container">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-white">Listado Transacciones {{-- Transbank --}} de las Instalaciones
					</div>

					<div class="card-body">
						<div class="table-responsive">
							<table class="table  table-striped table-bordered table-hover dataTable no-footer" id="sample_5" {{--  role="grid" --}}>
								<thead>
									<tr>
										<th width="2%">#</th>
										<th width="8%">Tipo</th>
										<th>Fecha transacción</th>
										<th>Horario bloque</th>
										<th>Estado</th>
										<th>Usuario</th>
										<th>Valor</th>
										<th {{-- width="15%" --}}></th>
									</tr>
								</thead>
								<tbody>
									@php $c = 0; @endphp
									@foreach ($transacciones as $key => $transaccion)
									@if(!is_null($transaccion->transaction))
									@php $c++; @endphp
									<tr>
										<td>{{ ($c) }}</td>
										<td>{{ $transaccion->transaction->tipo ?? 'No registrado' }}</td>
										<td>{{ date('d-m-Y', strtotime($transaccion->transaction->created_at)) }}</td>
										<td>{{ $transaccion->dia }}-{{ $transaccion->mes }}-{{ $transaccion->agno }} ({{ date('H:i', strtotime($transaccion->hora_inicio_bloque)) }} - {{ date('H:i', strtotime($transaccion->hora_fin_bloque)) }})</td>
										<td>{{ $transaccion->estado }}</td>
										<td>{{ !is_null($transaccion->transaction->user_reserva) ? $transaccion->transaction->user_reserva->full_name : 'No encontrado' }}</td>
										<td>${{ number_format($transaccion->transaction->amount, 0, ',', '.') }}</td>
										<td align="center">
										@if($transaccion->estado == "Reservado")
										<div class="btn-group">
											<button type="button" data-target="#modalReembolso" data-toggle="modal" class="btn btn-primary">Reembolso</button>
											{{-- <form action="{{ route('arrendamiento.reembolso') }}" method="post">
												@csrf
												<input type="hidden" name="token" id="token" value="{{ $transaccion->transaction->token }}">
												<input type="hidden" name="commerce_code" value="597055555536">
												<input type="hidden" name="buy_order" value="{{ $transaccion->id  }}">
												<input type="hidden" name="amount" id="amount" value="{{ $transaccion->transaction->amount }}">
												<button type="submit" class="btn btn-primary">Solicitar reembolso</button>
											</form> --}}
											</div>
											@elseif ($transaccion->estado == "Por Pagar")
											<div class="btn-group">
											<form action="{{ route('recintos.liberacion') }}" method="post">
												@csrf
												<input type="hidden" name="buy_order" value="{{ $transaccion->id  }}">
												<button type="submit" class="btn btn-primary">Liberar Bloque</button>
											</form>
											</div>

											@endif
										</td>
										
									</tr>
									@endif
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.inner -->
</div>
<!-- /.outer -->
@foreach ($transacciones as $key => $transaccion)
@if($transaccion->transaction)
<div class="modal fade" id="modalReembolso" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="">
		<form method="post" action="{{ route('transacciones.reembolsos.store', $transaccion->transaction->id) }}">
			@csrf
			@method('PUT')
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">
						<i class="fa fa-info"></i> Solicitar Reembolso ({{$transaccion->transaction->tipo}})
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" id="mbody_motivos">
					<h3>Datos transaccion</h3>
					<label>Usuario</label>
					<input type="text" readonly class="form-control" name="userName" value="{{ $transaccion->transaction->user_reserva->full_name }}">
					<label>Monto transacción</label>
					<input type="text" readonly class="form-control" name="amountMonto" value="{{ $transaccion->transaction->amount }}">
					<input type="hidden" name="token" id="token" value="{{ $transaccion->transaction->token }}">
					<input type="hidden" name="commerce_code" value="597055555536">
					<input type="hidden" name="buy_order" value="{{ $transaccion->id  }}">
					<input type="hidden" name="amount" id="amount" value="{{ $transaccion->transaction->amount }}">
					<div class="form-row">
						<div class="col-12 mb-2">
							<label>Monto reembolso</label>
							<input type="number" name="monto" placeholder="0" class="form-control" max="{{ $transaccion->transaction->amount }}">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger float-right" data-dismiss="modal">
						Cerrar
						<i class="fa fa-times"></i>
					</button>
					<button type="submit" class="btn btn-success pull-left text_save">Solicitar reembolso</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endif
@endforeach
@stop

@section('footer_scripts')
<!--Plugin scripts-->
<script type="text/javascript" src="{{asset('vendors/intl-tel-input/js/intlTelInput.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/sweetalert/js/sweetalert2.min.js')}}"></script>
<!--End of Plugin scripts-->
<!--Page level scripts-->
<script type="text/javascript" src="{{asset('js/pages/form_layouts.js')}}"></script>
@stop