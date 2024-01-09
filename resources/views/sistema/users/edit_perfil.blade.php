@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Editar Perfil
	@parent
@stop

{{-- page level styles --}}
@section('header_styles')
	<!-- plugin styles-->
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/jasny-bootstrap/css/jasny-bootstrap.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrapvalidator/css/bootstrapValidator.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('css/pages/profile.css')}}"/>
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
						Editar Ususario
					</h4>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="index1">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="#">Usuarios</a>
						</li>
						<li class="breadcrumb-item active">Editar Usuario</li>
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
								<h4>Información Personal</h4>
							</div>
							<form class="form-horizontal login_validator" id="tryitForm" action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col">
										<div class="form-group row m-t-15">
											<div class="col-12 col-lg-3 text-center text-lg-right">
												<label class="col-form-label">Profile Pic</label>
											</div>
											<div class="col-12 col-lg-6 text-center text-lg-left">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new img-thumbnail text-center">
														<img src="{{ auth()->user()->profile_photo_url }}" data-src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->nombres }}" style="object-fit: cover; max-width: 100%">
													</div>
													<div class="fileinput-preview fileinput-exists img-thumbnail"></div>
													<div class="m-t-20 text-center">
															<span class="btn btn-primary btn-file">
															<span class="fileinput-new">Seleccionar imagen</span>
															<span class="fileinput-exists">Cambiar</span>
															<input type="file" name="imagen">
															</span>
														<a href="#" class="btn btn-warning fileinput-exists" data-dismiss="fileinput">Quitar</a>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row m-t-25">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="u-name" class="col-form-label">Nombres *</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text br-0"> <i class="fa fa-user text-primary"></i></span>
													<input type="text" value="{{ auth()->user()->nombres }}" name="nombres" id="u-name" class="form-control">
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
													<input type="text" value="{{ auth()->user()->apellido_paterno }}" name="apellido_paterno" id="u-lastname1" class="form-control">
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
													<input type="text" value="{{ auth()->user()->apellido_materno }}" name="apellido_materno" id="u-lastname" class="form-control">
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
													<input type="text" value="{{ auth()->user()->email }}" id="email" name="email" class="form-control">
												</div>
											</div>
										</div>
										{{-- <div class="form-group row">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="pwd" class="col-form-label">Password *</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text  br-0"><i class="fa fa-lock text-primary"></i></span>
													<input type="password" value="" name="password" id="pwd" class="form-control">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="cpwd" class="col-form-label">Confirm Password *</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text  br-0"><i class="fa fa-lock text-primary"></i></span>
													<input type="password" name="confirmpassword" value="" id="cpwd" class="form-control">
												</div>
											</div>
										</div> 
										<div class="form-group row">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="phone" class="col-form-label">Telefono *</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text  br-0"><i class="fa fa-phone text-primary"></i></span>
													<input type="text" id="phone" name="cell" class="form-control" value="{{ auth()->user()->telefono }}">
												</div>
											</div>
										</div>
										<div class="form-group gender_message row">
											<div class="col-12 col-lg-3 text-lg-right">
												<label class="col-form-label">Gender *</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="custom-controls-stacked">
													<label class="custom-control custom-radio">
														<input id="radio1" type="radio" name="gender" class="custom-control-input" checked>
														<span class="custom-control-label"></span>
														<span class="custom-control-description">Male</span>
													</label>
													<label class="custom-control custom-radio">
														<input id="radio2" type="radio" name="gender" class="custom-control-input">
														<span class="custom-control-label"></span>
														<span class="custom-control-description">Female</span>
													</label>
												</div>
											</div>
										</div> --}}
										<div class="form-group row">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="address" class="col-form-label">Direccion *
												</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div class="input-group">
													<span class="input-group-text  br-0"><i class="fa fa-plus text-primary"></i></span>
													<input type="text" value="{{ auth()->user()->direccion }}" id="address" name="direccion" class="form-control">
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
													<input type="text" value="{{ auth()->user()->ciudad }}" name="ciudad" id="city" class="form-control">
												</div>
											</div>
										</div>
										{{-- <div class="form-group row">
											<div class="col-12 col-lg-3 text-lg-right">
												<label for="checkbox1" class="col-form-label">Status *</label>
											</div>
											<div class="col-12 col-xl-6 col-lg-8">
												<div>
													<label class="custom-control custom-checkbox">
														<input id="checkbox1" type="checkbox" name="activate" class="custom-control-input" checked>
														<span class="custom-control-label"></span>
														<span class="custom-control-description">Activate your account</span>
													</label>
												</div>
											</div>
										</div> --}}
										<div class="form-group row">
											<div class="col-12 col-lg-9 ml-auto">
												<button class="btn btn-primary" id="submit2" type="submit">
													Guardar
												</button>
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
@section('footer_scripts')
	<!-- plugin scripts-->
	<script type="text/javascript" src="{{asset('js/pluginjs/jasny-bootstrap.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/holderjs/js/holder.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
	<!-- end of plugin scripts-->
	<script type="text/javascript" src="{{asset('js/pages/validation.js')}}"></script>
@stop
