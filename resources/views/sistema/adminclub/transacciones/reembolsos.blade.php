@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
Reembolsos
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
					Lista de reembolsos
				</h4>
			</div>
			<div class="col-sm-7 col-lg-6">
				<ol class="breadcrumb float-right nav_breadcrumb_top_align">
					<li class="breadcrumb-item">
						<a href="{{ route('/') }}"><i class="fa fa-home" data-pack="default" data-tags=""></i> Inicio</a>
					</li>
					<li class="active breadcrumb-item">Reembolsos {{-- Transbank --}}</li>
				</ol>
			</div>
		</div>
	</div>
</header>
<div class="outer">
	<div class="inner bg-container">
		{{-- <form class="form inline">
			<div class="row">
				<div class="col-sm-1 " style="text-align: center">
					<label for="fecha">Fecha: </label>
				</div>
				<div class="col-sm-1 ">
					<input type="date" name="desde" class="form-control" id="desde" value="{{ date('Y-m-d') }}" onchange="return loadData();">
				</div>
				<div class="col-sm-1 ">
					<input type="date" name="hasta" class="form-control" id="hasta" value="{{ date('Y-m-d') }}" onchange="return loadData();">
				</div>
				<div class="col-sm-2" style="text-align: center">
					<label for="clubes" >Club: </label>
				</div>
				<div class="col-sm-1 ">
					<select class="form-control" name="clubes" id="clubes" onchange="return loadData();">
						<option value="0">Todos</option>
						@foreach(auth()->user()->getClubes() as $club) 
							<option value="{{ $club->id }}"> {{ $club->display_name}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-1" style="text-align: center">
					<label for="servicio" >Servicio: </label>
				</div>
				<div class="col-sm-2 ">
					<select class="form-control" name="servicio" id="servicio" onchange="return loadData();">
						<option value="0">Todos</option>
						@foreach(auth()->user()->getServicios() as $servicio) 
							<option value="{{ $servicio->id }}"> {{ $servicio->nombre}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-sm-1" style="text-align: center">
					<label for="recinto" >Instalacion: </label>
				</div>
				<div class="col-sm-2 ">
					<select class="form-control" name="recinto" id="recinto" onchange="return loadData();">
						<option value="0">Todos</option>
						@foreach(auth()->user()->getRecintos() as $recinto) 
							<option value="{{ $recinto->id }}"> {{ $recinto->nombre}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</form> --}}
		{{-- CARDS --}}
		{{-- <div class="card-body p-t-0">
			<div class="card-columns">
				<div class="card border-primary m-t-25">
					<div class="card-header bg-white">Total Transacciones Web</div>
					<div class="card-body">
						<p class="card-text"><span id="box_1">$ {{ number_format($array['web'], 0, ',', '.') }}</span></p>
					</div>
				</div>
				<div class="card border-primary m-t-25">
					<div class="card-header bg-white">Total Transacciones App</div>
					<div class="card-body">
						<p class="card-text"><span id="box_2">$ {{ number_format($array['movil'], 0, ',', '.') }}</span></p>
					</div>
				</div>
				<div class="card border-primary m-t-25">
					<div class="card-header bg-white">Total Reembolsos</div>
					<div class="card-body">
						<p class="card-text"><span id="box_3">$ {{ number_format($array['reembolsos'], 0, ',', '.') }}</span></p>
					</div>
				</div>
			</div>
		</div> --}}
		{{-- /CARDS --}}
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header bg-white">Listado reembolsos</div>
					<div class="card-body">
						<div class="table-responsive mt-2">
							<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_5">
								<thead>
									<tr>
										<th width="2%">#</th>
										<th width="7%">Tipo</th>
										<th width="7%">Fecha reembolso</th>
										<th width="34%">Informacion agenda</th>
										<th width="5%">Valor</th>
										<th width="5%">Total</th>
										<th width="10%">Usuario</th>
									</tr>
								</thead>
								<tbody id="lista">
									@foreach($reembolsos as $key => $reem)
									<tr>
										<td>{{ ($key + 1) }}</td>
										<td>{{ $reem->tipo }}</td>
										<td>{{ date('d/m/Y', strtotime($reem->created_at)) }}</td>
										<td>
											{{ $reem->transactions->agenda->dia }}-{{ $reem->transactions->agenda->mes }}-{{ $reem->transactions->agenda->agno }} ({{ date('H:i', strtotime($reem->transactions->agenda->hora_inicio_bloque)) }} - {{ date('H:i', strtotime($reem->transactions->agenda->hora_fin_bloque)) }})
										</td>
										<td>${{ number_format($reem->amount, 0, ',', '.') }}</td>
										<td>${{ number_format($reem->transactions->amount, 0, ',', '.') }}</td>
										<td>{{ ($reem->transactions->user_reserva) ? $reem->transactions->user_reserva->full_name : 'No encontrado' }}</td>
									</tr>
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
@stop

@section('footer_scripts')
<!--Plugin scripts-->
<script type="text/javascript" src="{{asset('vendors/intl-tel-input/js/intlTelInput.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/sweetalert/js/sweetalert2.min.js')}}"></script>
<!--End of Plugin scripts-->
<!--Page level scripts-->
<script type="text/javascript" src="{{asset('js/pages/form_layouts.js')}}"></script>
<script type="text/javascript">
	/* ########## AJAX ########## */
</script>
@stop








