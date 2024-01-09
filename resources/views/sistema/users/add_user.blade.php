@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Añadir usuario
	@parent
@stop
{{-- page level styles --}}
@section('header_styles')
	<!-- plugin styles-->
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/jasny-bootstrap/css/jasny-bootstrap.min.css')}}"/>
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
	<!--end of page level css-->
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/multiselect/css/multi-select.css')}}"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<style>
		.br-0{
			border-top-right-radius: 0;
			border-bottom-right-radius: 0;
		}
	</style>
@stop

{{-- Page content --}}
@section('content')
	<header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-lg-6">
					<h4 class="nav_top_align skin_txt">
						<i class="fa fa-user"></i>Añadir usuario
					</h4>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="index1">
								<i class="fa fa-home" data-pack="default" data-tags=""></i>
								Dashboard
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{URL::to('users')}}">Usuarios</a>
						</li>
						<li class="breadcrumb-item active">Añadir usuario</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="outer">
		<div class="inner bg-container">
			<div class="card">

				<div class="card-body m-t-35">
					<div>
						<h4>Información personal</h4>
					</div>
                    <div  class="form-group row textouser">
                        <span id="mensajeerroruser" class="alert-danger col-lg-9 ml-auto"></span>
                    </div>
					<form class="form-horizontal login_validator" id="tryitForm" action="{{route('users.store')}}" method="post" onsubmit="return validaruser(this)" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-12">
								<div class="form-group row m-t-25">
									<div class="col-lg-3 text-center text-lg-right">
										<label class="col-form-label">Imagen de perfil</label>
									</div>
									<div class="col-lg-6 text-center text-lg-left">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new img-thumbnail text-center">
												<img data-src="holder.js/230x170"  id="myImage"  alt="not found"></div>
											<div id="img_probar" class="fileinput-preview fileinput-exists img-thumbnail"></div>
											<div class="m-t-20 text-center">
													<span class="btn btn-primary btn-file">
														<span class="fileinput-new">Seleccionar</span>
														<span class="fileinput-exists">Cambiar</span>
														<input type="file" name="imagen">
													</span>
												<a href="#" class="btn btn-warning fileinput-exists"
												   data-dismiss="fileinput">Quitar</a>
											</div>
										</div>
                                        <span style="color: red;display:none;" id="mostrarimage">Debe Ingresar una imagen correspondiente</span>
									</div>
								</div>
								<div class="form-group row m-t-25">
									<div class="col-lg-3 text-lg-right">
										<label for="u-name" class="col-form-label"> Tipo de usuario *</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="input-group input-group-prepend">
											<span class="input-group-text br-0 border-right-0 rounded-left"> <i class="fa fa-group text-primary"></i></span>
											<select class="form-control" name="tipo_usuarios_id" id="tipo_usuarios_id" onchange="vistaclubes()" required>
												@foreach($tipos as $tipo)
												<option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row m-t-25" id="div_clubes" style="display: none;">
									<div class="col-lg-3 text-lg-right">
										<label for="u-name" class="col-form-label"> Club (es) *</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="input-group input-group-prepend" id="multiple_close">
											<span class="input-group-text br-0 border-right-0 rounded-left"> <i class="fa fa-group text-primary"></i></span>
											{{-- <select class="form-control chzn-select" name="clubes_id[]" id="clubes_id" multiple size="3">
											</select> --}}
                                            <select  name="clubes_id[]" id="clubes_id" class="form-control chzn-select" multiple="multiple" required>
                                                @foreach ($clubs as $club)
                                                <option value="{{ $club->id }}">{{ $club->display_name }}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
								</div>
								<div class="form-group row m-t-25">
									<div class="col-lg-3 text-lg-right">
										<label for="u-name" class="col-form-label"> Nombre *</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="input-group input-group-prepend">
											<span class="input-group-text br-0 border-right-0 rounded-left"> <i class="fa fa-user text-primary"></i></span>
											<input type="text" name="nombres" id="u-name" class="form-control" value="{{ old('nombres') }}">
										</div>
                                        <span style="color: red;display:none;" id="mostrarnombre">Debe Ingresar un Nombre correspondiente</span>
									</div>
								</div>
                                <div class="form-group row m-t-25">
                                    <div class="col-12 col-lg-3 text-lg-right">
                                        <label for="u-lastname1" class="col-form-label">Apellido paterno </label>
                                    </div>
                                    <div class="col-12 col-xl-6 col-lg-8">
                                        <div class="input-group">
                                            <span class="input-group-text br-0"> <i class="fa fa-user text-primary"></i></span>
                                            <input type="text" value="{{ old('apellido_paterno') }}" name="apellido_paterno" id="u-lastname1" class="form-control">
                                        </div>
                                        <span style="color: red; display:none;" id="mostrarapep">Debe Ingresar un Apellido Paterno correspondiente</span>
                                    </div>
                                </div>
                                <div class="form-group row m-t-25">
                                    <div class="col-12 col-lg-3 text-lg-right">
                                        <label for="u-lastname" class="col-form-label">Apellido materno </label>
                                    </div>
                                    <div class="col-12 col-xl-6 col-lg-8">
                                        <div class="input-group">
                                            <span class="input-group-text br-0"> <i class="fa fa-user text-primary"></i></span>
                                            <input type="text" value="{{ old('apellido_materno') }}" name="apellido_materno" id="u-lastname" class="form-control">
                                        </div>
                                        <span style="color: red; display:none;" id="mostrarapem">Debe Ingresar un Apellido Materno correspondiente</span>
                                    </div>
                                </div>
								<div class="form-group row m-t-25">
									<div class="col-lg-3 text-lg-right">
										<label for="u-rut" class="col-form-label"> Rut *</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="input-group input-group-prepend">
											<span class="input-group-text br-0 border-right-0 rounded-left"> <i class="fa fa-user text-primary"></i></span>
											<input type="text" name="rut" id="u-rut" class="form-control rut" value="{{ old('rut') }}">
										</div>
                                        <span style="color: red; display:none;" id="mostrarrut">Debe Ingresar un Rut correspondiente</span>
									</div>
								</div>
                                <div class="form-group row m-t-25">
									<div class="col-lg-3 text-lg-right">
										<label for="u-rut" class="col-form-label"> Fecha de Nacimiento *</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="input-group input-group-prepend">
											<span class="input-group-text br-0 border-right-0 rounded-left"> <i class="fa fa-user text-primary"></i></span>
											<input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" placeholder="Fecha de nacimiento"  value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
										</div>
                                        <span style="color: red;display:none;" id="mostrarfnacimiento">Debe Ingresar una Fecha de nacimiento correspondiente</span>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-3 text-lg-right">
										<label for="email" class="col-form-label">Email
											*</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="input-group input-group-prepend">
											<span class="input-group-text  br-0 border-right-0 rounded-left"><i class="fa fa-envelope text-primary"></i></span>
											<input type="text" placeholder=" " id="email" name="email" class="form-control" value="{{ old('email') }}">
										</div>
									</div>
								</div>
                                <div class="form-group row">
                                    <div class="col-12 col-lg-3 text-lg-right">
                                        <label for="address" class="col-form-label">Direccion *
                                        </label>
                                    </div>
                                    <div class="col-12 col-xl-6 col-lg-8">
                                        <div class="input-group">
                                            <span class="input-group-text  br-0"><i class="fa fa-plus text-primary"></i></span>
                                            <input type="text" value="{{ old('direccion') }}" id="address" name="direccion" class="form-control">
                                        </div>
                                        <span style="color: red; display:none;" id="mostrardireccion">Debe Ingresar una Direccion correspondiente</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 col-lg-3 text-lg-right">
                                        <label for="city" class="col-form-label">Ciudad *</label>
                                    </div>
                                    <div class="col-12 col-xl-6 col-lg-8">
                                        <div class="input-group">
                                            <span class="input-group-text  br-0"><i class="fa fa-plus text-primary"></i></span>
                                            <input type="text" value="{{ old('ciudad') }}" name="ciudad" id="city" class="form-control">
                                        </div>
                                        <span style="color: red; display:none;" id="mostrarciudad">Debe Ingresar una Ciudad correspondiente</span>
                                    </div>
                                </div>
								<div class="form-group row">
									<div class="col-lg-3 text-lg-right">
										<label for="pwd" class="col-form-label">Password
											*</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="input-group input-group-prepend">
											<span class="input-group-text br-0 border-right-0 rounded-left"><i class="fa fa-lock text-primary"></i></span>
											<input type="password" name="password" id="pwd" class="form-control">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-3 text-lg-right">
										<label for="cpwd" class="col-form-label">Confirm
											Password *</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="input-group input-group-prepend">
											<span class="input-group-text br-0 border-right-0 rounded-left"><i class="fa fa-lock text-primary"></i></span>
											<input type="password" name="password_confirmation" placeholder=" " id="cpwd" class="form-control">
										</div>
									</div>
								</div>
								{{-- <div class="form-group row">
									<div class="col-lg-3 text-lg-right">
										<label for="phone" class="col-form-label">Phone
											*</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="input-group input-group-prepend">
											<span class="input-group-text br-0 border-right-0 rounded-left"><i class="fa fa-phone text-primary"></i></span>
											<input type="text" placeholder=" " id="phone" name="cell"
												   class="form-control">
										</div>
									</div>
								</div>
								<div class="form-group gender_message row">
									<div class="col-lg-3 text-lg-right">
										<label class="col-form-label">Gender *</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="custom-controls-stacked">
											<label class="custom-control custom-radio">
												<input id="radio1" type="radio" name="gender"
													   class="custom-control-input">
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Male</span>
											</label>
											<label class="custom-control custom-radio">
												<input id="radio2" type="radio" name="gender"
													   class="custom-control-input">
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Female</span>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-3 text-lg-right">
										<label for="address" class="col-form-label">Address
											*</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="input-group input-group-prepend">
											<span class="input-group-text br-0 border-right-0 rounded-left"><i class="fa fa-plus text-primary"></i></span>
											<input type="text" placeholder=" "  id="address" name="address1"  class="form-control">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-lg-3 text-lg-right">
										<label for="city" class="col-form-label">City
											*</label>
									</div>
									<div class="col-xl-6 col-lg-8">
										<div class="input-group input-group-prepend">
											<span class="input-group-text br-0 border-right-0 rounded-left"><i class="fa fa-plus text-primary"></i></span>
											<input type="text" placeholder=" " name="city" id="city"
												   class="form-control">
										</div>
									</div>
								</div>--}}
								{{-- <div class="form-group row">
									<div class="col-lg-9 add_user_checkbox_error ml-auto">
										<div>
											<label class="custom-control custom-checkbox">
												<input id="checkbox1" type="checkbox" name="check_active"
													   class="custom-control-input">
												<span class="custom-control-label"></span>
												<span class="custom-control-description">Activate your account</span>
											</label>
										</div>
									</div>
								</div> --}}

								<div class="form-group row">
									<div class="col-lg-9 ml-auto">
										<button class="btn btn-primary" type="submit">
											<i class="fa fa-user"></i>
											Crear
										</button>
										<button class="btn btn-warning" onclick="limpiarerror()" type="reset" id="clear">
											<i class="fa fa-refresh"></i>
											Limpiar
										</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- /.inner -->
	</div>


@stop

{{-- page level scripts --}}
@section('footer_scripts')
	<!-- plugin scripts-->
	<script type="text/javascript" src="{{asset('js/pluginjs/jasny-bootstrap.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/holderjs/js/holder.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/pages/validation.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/multiselect/js/jquery.multi-select.js')}}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.3.1/jquery.quicksearch.min.js"></script>
	<script type="text/javascript" src="{{asset('js/form.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/pages/form_elements.js')}}"></script>
	<script src="{{ asset('js/validateRut.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<!-- end of plugin scripts-->
	<script type="text/javascript">
        $(document).ready(function() {
                $('#clubes_id').select2({
                    placeholder: 'Seleccionar...'
                });
            });
        function vistaclubes(){

            var vista = $("#tipo_usuarios_id").val();

            if (vista == 2 || vista == 5) {
                $("#div_clubes").show();
            }else{
                $("#div_clubes").hide();
            }

        };
		// $("#tipo_usuarios_id").change(function(event) {
		// 	if ($(this).val() == 2) {
		// 		$.ajax({
		// 			url: '/load/clubes',
		// 			type: 'GET',
		// 		})
		// 		.done(function(response) {
		// 			console.log(response);
		// 			$("#clubes_id").empty();
		// 			$.each(response, function(index, val) {
		// 				$("#clubes_id").append(`
		// 					<option value="${val.id}">${val.display_name}</option>
		// 				`);
		// 			});
		// 			$("#div_clubes").show();
		// 		})
		// 		.fail(function() {
		// 			console.log("error");
		// 		})
		// 		.always(function() {
		// 			console.log("complete");
		// 		});
		// 	} else {
		// 		$("#div_clubes").hide();
		// 	}
		// });
    function validaruser(f) {
        //document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
        //document.getElementById("mensajeerroruser").style.display = "none";
        var ok = true;
        //var msg = "Se encontraron los siguientes errores:";


        if(f.elements["nombres"].value == ""){
                    //msg += "<br>- Debe ingresar un Nombre.\n";
                    document.getElementById("mostrarnombre").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarnombre").style.display = "none";
        }

        if(f.elements["apellido_paterno"].value == ""){
                    //msg += "<br>- Debe ingresar un Nombre.\n";
                    document.getElementById("mostrarapep").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarapep").style.display = "none";
        }

        if(f.elements["apellido_materno"].value == ""){
                    //msg += "<br>- Debe ingresar un Nombre.\n";
                    document.getElementById("mostrarapem").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarapem").style.display = "none";
        }

        if(f.elements["rut"].value == ""){
                    //msg += "<br>- Debe ingresar un rut.\n";
                    document.getElementById("mostrarrut").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarrut").style.display = "none";
        }

        if (document.getElementById("img_probar").childNodes.length > 0) {
            document.getElementById("mostrarimage").style.display = "none";
        }else{

            document.getElementById("mostrarimage").style.display = "block";
            ok = false;
        }

        if(f.elements["direccion"].value == ""){
                    //msg += "<br>- Debe ingresar un Nombre.\n";
                    document.getElementById("mostrardireccion").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrardireccion").style.display = "none";
        }

        if(f.elements["ciudad"].value == ""){
                    //msg += "<br>- Debe ingresar un Nombre.\n";
                    document.getElementById("mostrarciudad").style.display = "block";
                    ok = false;
        }else{
            document.getElementById("mostrarciudad").style.display = "none";
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
        document.getElementById("mostrarrut").style.display = "none";
        document.getElementById("mostrarnombre").style.display = "none";
        document.getElementById("mostrarimage").style.display = "none";
        document.getElementById("mostrarapem").style.display = "none";
        document.getElementById("mostrarapep").style.display = "none";
        document.getElementById("mostrardireccion").style.display = "none";
        document.getElementById("mostrarciudad").style.display = "none";
        var ok = true;

        return ok;
    }
	</script>
@stop
