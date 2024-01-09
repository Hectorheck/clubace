@php
$dias = explode(',', $recinto->dias_atencion);
@endphp
@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Editar Instalacion
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
					<h4 class="nav_top_align">
						<i class="fa fa-pencil"></i>
						Editar Instalacion
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
						<li class="active breadcrumb-item">Registrar Instalacion</li>
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
						<div class="card-header bg-white">Editar Instalacion</div>

						<div class="card-body">
							<!-- checkbox -->
							<div class="justify-content-center">
								<form action="{{ route('recintos.update', [$servicio, $recinto->id]) }}" method="POST" enctype="multipart/form-data" class="form-horizontal" onsubmit="return validarrecinto(this)">
									@method('PUT')
									@csrf
									<!-- Name input-->
									<div class="row form-group">
										<div class="col-12 col-md-4 mt-3">
											<label for="nombre" class="form-group-horizontal">Nombre</label>
											<div class="input-group">
												<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" value="{{ $recinto->nombre }}">
											</div>
                                            <span style="color: red;display:none;" id="mostrarnombre">Debe Ingresar un Nombre correspondiente</span>
										</div>

										<div class="col-12 col-md-6 mt-3" style="display: none;">
											<label for="valor" class="form-group-horizontal">Valor</label>
											<div class="input-group">
												<input type="text" name="valor" id="valor" class="form-control" placeholder="Valor" value="{{ $recinto->tipo }}" hidden>
											</div>
                                            <span style="color: red;display:none;" id="mostrarvalor">Debe Ingresar un Valor correspondiente</span>
										</div>

										<div class="col-12 col-md-4 mt-3">
											<label for="codigo" class="form-group-horizontal">Codigo</label>
											<div class="input-group">
												<input type="text" name="codigo" id="codigo" class="form-control" placeholder="Codigo" value="{{ $recinto->codigo }}">
											</div>
                                            <span style="color: red;display:none;" id="mostrarcod">Debe Ingresar un Codigo correspondiente</span>
										</div>

                                        <div class="col-12 col-md-4 mt-3">
											<label for="year" class="form-group-horizontal">Año de construccion</label>
											<div class="input-group">
												<input type="number" name="year" id="year" class="form-control" placeholder="Año de construccion" value="{{ $recinto->agno_construccion }}">
											</div>
                                            <span style="color: red;display:none;" id="mostraraño">Debe Ingresar un Año de const. correspondiente</span>
										</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="obser_publicas" class="form-group-horizontal">Observaciones publicas</label>
											<div class="input-group">
												<textarea name="obser_publicas" id="obser_publicas" rows="4" class="form-control" placeholder="Observaciones publicas">{{ $recinto->observaciones_publicas }}</textarea>
											</div>
                                            <span style="color: red;display:none;" id="mostrarpub">Debe Ingresar una Observacion publica correspondiente</span>
										</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="obser_privadas" class="form-group-horizontal">Observaciones privadas</label>
											<div class="input-group">
												<textarea name="obser_privadas" id="obser_privadas" rows="4" class="form-control" placeholder="Observaciones privadas">{{ $recinto->observaciones_privadas }}</textarea>
											</div>
                                            <span style="color: red;display:none;" id="mostrarpriv">Debe Ingresar una Observacion privada correspondiente</span>
										</div>

										<div class="col-12 col-md-6 mt-3" hidden>
											<label for="tipo" class="form-group-horizontal">Tipo de clientela</label>
											<div class="input-group row">
												<div class="col-12 col-sm-6">
													<label class="custom-control custom-checkbox mr-3 d-inline">
														<input type="checkbox" name="socios" class="custom-control-input"{{ $recinto->socios ? ' checked' : '' }}>
														<span class="custom-control-label"></span>
														<span class="custom-control-description">Socio Club</span>
													</label>
												</div>

												<div class="col-12 col-sm-6">
													<label class="custom-control custom-checkbox mr-3 d-inline">
														<input type="checkbox" name="arriendo" class="custom-control-input"{{ $recinto->arriendo ? ' checked' : '' }}>
														<span class="custom-control-label"></span>
														<span class="custom-control-description">Arriendo</span>
													</label>
												</div>
											</div>
										</div>

										<div class="col-12 mt-3">
											<h3>Los siguientes datos permiten la creación de bloques horarios, por lo tanto ya no es posible modificarlos.</h3>
										</div>

										<div class="col-12 col-md-4 mt-3">
											<label for="bloque_horario" class="form-group-horizontal">Bloque horario</label>
											<div class="input-group">
												<select name="bloque_horario" id="bloque_horario" class="form-control" readonly>
													@php
													list($hr, $cnt) = [0, 0];
													@endphp
													@while ($hr < 2)
													@php
													$min = $cnt % 2 == 0 ? '30' : '00';
													@endphp
													<option value="{{ '+'.$hr.' hour +'.$min.' minutes' }}"{{ $recinto->bloque_horario == '+'.$hr.' hour +'.$min.' minutes' ? ' selected' : '' }}>{{ $hr.' : '.$min.' Hr' }}</option>
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

										<div class="col-12 col-md-4 mt-3">
											<label for="hora_inicio" class="form-group-horizontal">Hora inicio</label>
											<div class="input-group">
												<input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ $recinto->hora_inicio }}" readonly>
											</div>
										</div>

										<div class="col-12 col-md-4 mt-3">
											<label for="hora_fin" class="form-group-horizontal">Hora fin</label>
											<div class="input-group">
												<input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ $recinto->hora_fin }}" readonly>
											</div>
										</div>

										<div class="col-12 card-title pt-3 head">
											<h4>Días de atención</h4>
										</div>

										<div class="col-12">
											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="1"{{ in_array(1, $dias) ? ' checked' : '' }} readonly disabled>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Lunes</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="2"{{ in_array(2, $dias) ? ' checked' : '' }} readonly disabled>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Martes</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="3"{{ in_array(3, $dias) ? ' checked' : '' }} readonly disabled>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Miercoles</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="4"{{ in_array(4, $dias) ? ' checked' : '' }} readonly disabled>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Jueves</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="5"{{ in_array(5, $dias) ? ' checked' : '' }} readonly disabled>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Viernes</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="6"{{ in_array(6, $dias) ? ' checked' : '' }} readonly disabled>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Sábado</span>
											</label>

											<label class="custom-control custom-checkbox mr-3 d-inline">
												<input type="checkbox" name="dias[]" class="custom-control-input dias" value="7"{{ in_array(7, $dias) ? ' checked' : '' }} readonly disabled>
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Domingo</span>
											</label>
                                            <span style="color: red;display:none;" id="mostrardias">Debe Seleccionar Dias correspondiente</span>
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
    function validarrecinto(f) {
        //document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
        //document.getElementById("mensajeerroruser").style.display = "none";
        var ok = true;
        //var msg = "Se encontraron los siguientes errores:";


        if(f.elements["nombre"].value == ""){
                    //msg += "<br>- Debe ingresar un Nombre.\n";
                    document.getElementById("mostrarnombre").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarnombre").style.display = "none";
        }

        if(f.elements["valor"].value == ""){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostrarvalor").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarvalor").style.display = "none";
        }

        if(f.elements["codigo"].value == ""){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostrarcod").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarcod").style.display = "none";
        }

        if(f.elements["year"].value == ""){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostraraño").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostraraño").style.display = "none";
        }

        if(f.elements["obser_publicas"].value == ""){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostrarpub").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarpub").style.display = "none";
        }

        if(f.elements["obser_privadas"].value == ""){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostrarpriv").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarpriv").style.display = "none";
        }

        //todos=document.getElementsByTagName('dias');
        todos = document.getElementsByClassName('dias');
        //console.log(todos);
        var cant = 0;
        for(x=0;x<todos.length;x++){
            if(todos[x].checked){
                cant++;
            }
        }

        if (cant==0) {
            document.getElementById("mostrardias").style.display = "block";
            ok = false;
        }else{
            document.getElementById("mostrardias").style.display = "none";
        }







        if(ok == false)
            //document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = msg;
            //document.getElementById("mensajeerroruser").style.display = "block";
            //alert(msg);

        return ok;
    }
    function limpiarerror() {
        //document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
        //document.getElementById("mensajeerroruser").style.display = "none";
        document.getElementById("mostrarnombre").style.display = "none";
        document.getElementById("mostrarvalor").style.display = "none";
        document.getElementById("mostrarcod").style.display = "none";
        document.getElementById("mostraraño").style.display = "none";
        document.getElementById("mostrarpub").style.display = "none";
        document.getElementById("mostrarpriv").style.display = "none";
        document.getElementById("mostrardias").style.display = "none";
        var ok = true;

        return ok;
    }
</script>
@stop
