@php
$geo = "(".$club->geo_lat.", ".$club->geo_lng.")";
$dias = explode(',', $club->dias_atencion);
$logotipo = $club->logo_url ? Storage::disk('public')->url($club->logo_url) : asset('img/clubes/logotipo.png');
@endphp
@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Configurar Club
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
<style>#mapa{border-radius:.25rem;min-height:250px;max-height:350px;height:-webkit-fill-available}</style>
<style>
.colorpicker-alpha,.colorpicker-color{display:none!important}.colorpicker-2x .colorpicker-saturation{width:150px!important;height:150px!important;}.colorpicker-2x .colorpicker-hue,.colorpicker-2x .colorpicker-alpha{width:30px;height:150px!important;}.colorpicker-2x .colorpicker-color,.colorpicker-2x .colorpicker-color div{height:30px;}.colorpicker-selectors i+i{margin-left:5px;}.colorpicker-selectors i{height:16px;width:16px;}#color-preview{padding:15px;}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<!-- End additions -->
@stop
@section('content')
	<header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-sm-5 col-lg-6 skin_txt">
					<h4 class="nav_top_align">
						<i class="fa fa-cog"></i>
						Configurar {{ $club->display_name }}
					</h4>
				</div>
				<div class="col-sm-7 col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="index1">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
							</a>
						</li>
						{{-- <li class="breadcrumb-item">
							<a href="#">Forms</a>
						</li> --}}
						<li class="active breadcrumb-item">{{ $club->display_name }}</li>
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
						<div class="card-header bg-white">Configurar club</div>

						<div class="card-body">
							<!-- checkbox -->
							<div class="justify-content-center">
								<br>
								<form action="{{route('clubes.storeConfig')}}" method="post">
									@csrf
									<input name="clubId" type="hidden" value="{{$club->id}}">
									<div>
										<table class="table table-striped table-bordered table-hover dataTable no-footer" id="editable_table" role="grid">
											<thead>
												<tr>
													<th width="80%">Nombre variable</th>
													<th width="20%" >Acción</th>
												</tr>
											</thead>
											@foreach($varDefault as $varDef)
												<tbody>
													<tr>
														<td>
															<label>{{$varDef->Descripcion}}</label>
														</td>
														@if($varDef->TipoVariable == "int")
															<td align="center">
																<input type="number" name="{{$varDef->Nombre}}" min="1" max="60" value="{{$varDef->ValorDefault}}">
																<label>minutos</label>
															</td>
														@endif
														@if($varDef->TipoVariable == "bool")
															<td align="center">
																<input type="radio" name="{{$varDef->Nombre}}" checked value="{{$varDef->ValorDefault}}"> Si
																<input type="radio" name="{{$varDef->Nombre}}" value="No"> No
															</td>
														@endif
													</tr>
												</tbody>
											@endforeach
										</table>
									</div>
									<div>
										<label for="">¿Desea asociar la configuración al club?</label>
										<br>
										<button type="submit" class="btn btn-danger" onclick="history.back()">Volver</button>
										<button type="submit" class="btn btn-mint">Aceptar</button>
									</div>
								</form>
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
