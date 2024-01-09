{{-- @dd($user) --}}
@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Editar Usuario
	@parent
@stop

{{-- page level styles --}}
@section('header_styles')
	<!-- plugin styles-->
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/jasny-bootstrap/css/jasny-bootstrap.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrapvalidator/css/bootstrapValidator.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<!--end of page level css-->
	<style>
		.br-0{
			border-top-right-radius: 0;
			border-bottom-right-radius: 0;
		}
	</style>
@stop
@section('content')
	<header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-lg-6">
					<h4 class="nav_top_align skin_txt">
						<i class="fa fa-pencil"></i>
						Edit User
					</h4>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{URL::to('users')}}">Usuarios</a>
						</li>
						<li class="breadcrumb-item active">Editar usuario</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="outer">
		<div class="inner bg-container">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-body m-t-25">
							<div>
								<h4>Personal Information</h4>
							</div>
							<form class="form-horizontal login_validator" id="tryitForm" action="{{route('users.update', $user->id)}}" method="post" enctype="multipart/form-data">
								@csrf
								@method('PUT')
								<div class="row">
									<div class="col">
										<div class="form-group row m-t-15">
											<div class="col-12 col-lg-3 text-center text-lg-right">
												<label class="col-form-label">Imagen de perfil</label>
											</div>
											<div class="col-12 col-lg-6 text-center text-lg-left">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new img-thumbnail text-center">
														<img src="{{  $user->profile_photo_url }}" data-src="{{ $user->profile_photo_url }}" alt="not found" style="object-fit: cover; max-width: 100%"></div>
													<div class="fileinput-preview fileinput-exists img-thumbnail"></div>
													<div class="m-t-20 text-center">
															<span class="btn btn-primary btn-file">
															<span class="fileinput-new">Select image</span>
															<span class="fileinput-exists">Change</span>
															<input type="file" name="imagen">
															</span>
														<a href="#" class="btn btn-warning fileinput-exists" data-dismiss="fileinput">Remove</a>
													</div>
												</div>
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
														<option value="{{ $tipo->id }}" @if($user->tipo_usuarios_id == $tipo->id) selected @endif>{{ $tipo->tipo }}</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
										<div class="form-group row m-t-25" id="div_clubes" >
											<div class="col-lg-3 text-lg-right">
												<label for="u-name" class="col-form-label"> Club (es) *</label>
											</div>
											<div class="col-xl-6 col-lg-8">
												<div class="input-group input-group-prepend" id="multiple_close">
													<span class="input-group-text br-0 border-right-0 rounded-left"> <i class="fa fa-group text-primary"></i></span>
													{{-- <select class="form-control chzn-select" name="clubes_id[]" id="clubes_id" multiple size="3">
													</select> --}}
                                                    <select  name="clubes_id[]" id="clubes_id" class="form-control"  multiple="multiple" required>
                                                        @foreach ($clubs as $club)
                                                        <option value="{{ $club->id }}"

                                                            @foreach ($clubsselects as $clubsselect)
                                                            {{ $club->id == $clubsselect->clubes_id ? ' selected' : '' }}
                                                            @endforeach

                                                            >{{ $club->display_name }}</option>
                                                        @endforeach
                                                    </select>
												</div>
											</div>
										</div>
										<div class="form-group row m-t-25">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="u-name" class="col-form-label">Nombre *</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text br-0"> <i class="fa fa-user text-primary"></i></span>
													<input type="text" value="{{ $user->nombres }}" name="nombres" id="u-name" class="form-control">
												</div>
											</div>
										</div>
										<div class="form-group row m-t-25">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="u-rut" class="col-form-label">Rut *</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text br-0"> <i class="fa fa-user text-primary"></i></span>
													<input type="text" value="{{ $user->rut }}" name="rut" id="u-rut" class="form-control">
												</div>
											</div>
										</div>
                                        <div class="form-group row m-t-25">
                                            <div class="col-lg-3 text-lg-right">
                                                <label for="u-rut" class="col-form-label"> Fecha de Nacimiento *</label>
                                            </div>
                                            <div class="col-xl-6 col-lg-8">
                                                <div class="input-group input-group-prepend">
                                                    <span class="input-group-text br-0 border-right-0 rounded-left"> <i class="fa fa-user text-primary"></i></span>
                                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" placeholder="Fecha de nacimiento"  value="{{ $user->fecha_nacimiento }}" max="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>
										<div class="form-group row m-t-25">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="u-lastname1" class="col-form-label">Apellido paterno </label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text br-0"> <i class="fa fa-user text-primary"></i></span>
													<input type="text" value="{{ $user->apellido_paterno }}" name="apellido_paterno" id="u-lastname1" class="form-control">
												</div>
											</div>
										</div>
										<div class="form-group row m-t-25">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="u-lastname" class="col-form-label">Apellido materno </label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text br-0"> <i class="fa fa-user text-primary"></i></span>
													<input type="text" value="{{ $user->apellido_materno }}" name="apellido_materno" id="u-lastname" class="form-control">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="email" class="col-form-label">Email *
												</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text  br-0"><i class="fa fa-envelope text-primary"></i></span>
													<input type="text" value="{{ $user->email }}" id="email" name="email" class="form-control">
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
													<input type="text" value="{{ $user->direccion }}" id="address" name="direccion" class="form-control">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="city" class="col-form-label">Ciudad *</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text  br-0"><i class="fa fa-plus text-primary"></i></span>
													<input type="text" value="{{ $user->ciudad }}" name="ciudad" id="city" class="form-control">
												</div>
											</div>
										</div>
										{{-- <div class="form-group row">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="phone" class="col-form-label">Phone *</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text  br-0"><i class="fa fa-phone text-primary"></i></span>
													<input type="text" id="phone" name="cell" class="form-control" value="9999999999">
												</div>
											</div>
										</div> --}}
										{{-- <div class="form-group row">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="address" class="col-form-label">Address *
												</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text  br-0"><i class="fa fa-plus text-primary"></i></span>
													<input type="text" value="Australia" id="address" name="address1" class="form-control">
												</div>
											</div>
										</div> --}}
										{{-- <div class="form-group row">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="city" class="col-form-label">City *</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text  br-0"><i class="fa fa-plus text-primary"></i></span>
													<input type="text" value="Nakia" name="city" id="city" class="form-control">
												</div>
											</div>
										</div> --}}
										<div class="form-group row">
											<div class="col-12 col-lg-9 ml-auto">
												<button class="btn btn-primary" id="submit2" type="submit">Guardar</button>
												<input type="reset" class="btn btn-warning" value='Limpiar' id="clear" />
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.inner -->
	</div>
	<!-- /.outer -->
@stop
@section('js')






@endsection
@section('footer_scripts')
	<!-- plugin scripts-->
	<script type="text/javascript" src="{{asset('js/pluginjs/jasny-bootstrap.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/holderjs/js/holder.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
	<!-- end of plugin scripts-->
	<script type="text/javascript" src="{{asset('js/pages/validation.js')}}"></script>
    <script src="{{ asset('js/validateRut.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<script type="text/javascript">
         $(document).ready(function() {
                $('#clubes_id').select2({
                    placeholder: 'Seleccionar...'
                });
                var vista = $("#tipo_usuarios_id").val();

                if (vista == 2 || vista == 5) {
                    $("#div_clubes").show();
                }else{
                    $("#div_clubes").hide();
                }
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
		// function loadClubes () {
		// 	$.ajax({
		// 		url: '/load/clubes',
		// 		type: 'GET',
		// 	})
		// 	.done(function(response) {
		// 		console.log(response);
		// 		$("#clubes_id").empty();
		// 		$.each(response, function(index, val) {
		// 			$("#clubes_id").append(`
		// 				<option value="${val.id}">${val.display_name}</option>
		// 			`);
		// 		});
		// 	})
		// 	.fail(function() {
		// 		console.log("error");
		// 	})
		// 	.always(function() {
		// 		console.log("complete");
		// 	});
		// }
	</script>
@stop
