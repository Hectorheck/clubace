@php
$imagen = Storage::disk('public')->url('img/servicios/'.$servicio->id.'.png');
@endphp
@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Servicios
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
<!-- End additions -->
@stop
@section('content')
	<header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-sm-5 col-lg-6 skin_txt">
					<h4 class="nav_top_align"><i class="fa fa-pencil"></i> Servicios</h4>
				</div>
				<div class="col-sm-7 col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Inicio
							</a>
						</li>
						{{-- <li class="breadcrumb-item">
							<a href="#">Forms</a>
						</li> --}}
						<li class="active breadcrumb-item">Servicios</li>
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
						<div class="card-header bg-white">Editar servicio</div>

						<div class="card-body">
							<!-- checkbox -->
							<div class="justify-content-center">
								<form action="{{ route('servicios.update', [$club, $servicio->id]) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
									@method('PUT')
									@csrf
									<!-- Name input-->
									<div class="row form-group">
										<div class="col-12 col-md-6 mt-3">
											<label for="nombre" class="form-group-horizontal">Nombre</label>
											<div class="input-group">
												<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" value="{{ $servicio->nombre }}">
											</div>
										</div>

										{{-- <div class="col-12 col-md-6 mt-3">
											<label for="valor" class="form-group-horizontal">Valor</label>
											<div class="input-group">
												<input type="number" name="valor" id="valor" class="form-control" placeholder="Valor" value="{{ $servicio->valor }}">
											</div>
										</div> --}}

										{{-- <div class="col-12 col-md-6 mt-3">
											<label for="tipo" class="form-group-horizontal">Tipo de clientela</label>
											<div class="input-group row">
												<div class="col-12 col-sm-6">
													<label class="custom-control custom-checkbox mr-3 d-inline">
														<input type="checkbox" name="socios" class="custom-control-input"{{ $servicio->socios ? ' checked' : '' }}>
														<span class="custom-control-label"></span>
														<span class="custom-control-description">Socio Club</span>
													</label>
												</div>

												<div class="col-12 col-sm-6">
													<label class="custom-control custom-checkbox mr-3 d-inline">
														<input type="checkbox" name="arriendo" class="custom-control-input"{{ $servicio->arriendo ? ' checked' : '' }}>
														<span class="custom-control-label"></span>
														<span class="custom-control-description">Arriendo</span>
													</label>
												</div>
											</div>
										</div> --}}

										{{-- <div class="col-12 col-md-6 mt-3">
											<label for="bloque_horario" class="form-group-horizontal">Bloque horario</label>
											<div class="input-group">
												<select name="bloque_horario" id="bloque_horario" class="form-control">
													@php
													list($hr, $cnt) = [0, 0];
													@endphp
													@while ($hr < 2)
													@php
													$min = $cnt % 2 == 0 ? '30' : '00';
													@endphp
													<option value="{{ '+'.$hr.' hour +'.$min.' minutes' }}"{{ $servicio->bloque_horario == '+'.$hr.' hour +'.$min.' minutes' ? ' selected' : '' }}>{{ $hr.' : '.$min.' Hr' }}</option>
													@php
													$cnt % 2 != 0 ? : $hr++;
													$cnt++;
													@endphp
													@endwhile
													<option value="+2 hour +00 minutes">2 : 00 Hr</option>
													<option value="+3 hour +00 minutes">3 : 00 Hr</option>
													<option value="+4 hour +00 minutes">4 : 00 Hr</option>
													<option value="+5 hour +00 minutes">5 : 00 Hr</option>
													<option value="+6 hour +00 minutes">6 : 00 Hr</option>
												</select>
											</div>
										</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="hora_inicio" class="form-group-horizontal">Hora inicio</label>
											<div class="input-group">
												<input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ $servicio->hora_inicio }}">
											</div>
										</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="hora_fin" class="form-group-horizontal">Hora fin</label>
											<div class="input-group">
												<input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ $servicio->hora_fin }}">
											</div>
										</div> --}}

										<div class="col-12 col-sm-6">
											<div class="mt-3">
												<label for="" class="form-group-horizontal">Imagen Principal</label>
												<div class="custom-file">
													<input type="file" name="imagen" id="imagen" class="custom-file-input" accept="image/*" lang="es">
													<label class="custom-file-label" data-browse="Buscar" for="imagen">Seleccionar Archivo</label>
												</div>
											</div>
											<div class="row mt-3">
												<div class="col-12 col-sm-5 col-md-3">
													<figure class="card p-2 mb-0">
														<img src="{{ $imagen }}" id="img-imagen" class="w-100" onerror="this.onerror=null;this.src='{{ asset('img/default.png') }}';">
													</figure>
												</div>
											</div>
										</div>
									</div>
									</div>

									<div class="form-group">
										<button type="submit" class="btn btn-primary">Actualizar</button>
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

@section('footer_scripts')
<!--Plugin scripts-->
<script type="text/javascript" src="{{asset('vendors/intl-tel-input/js/intlTelInput.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/sweetalert/js/sweetalert2.min.js')}}"></script>
<!--End of Plugin scripts-->
<!--Page level scripts-->
<script type="text/javascript" src="{{asset('js/pages/form_layouts.js')}}"></script>
<script>
function visualizar(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$(`#img-imagen`).attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$('#imagen').change(function(){
	visualizar(this)
});
</script>
@stop
