@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Agendamiento
	@parent
@stop

@section('header_styles')
	<!--WIZARD-->
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
	<!--page level styles-->
	<link type="text/css" rel="stylesheet" href="{{asset('css/pages/wizards.css')}}"/>
	<!--End of page styles-->
	<!--DATETIME PICKERS-->
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/inputlimiter/css/jquery.inputlimiter.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/jquery-tagsinput/css/jquery.tagsinput.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/daterangepicker/css/daterangepicker.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/datepicker/css/bootstrap-datepicker.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrap-switch/css/bootstrap-switch.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/jasny-bootstrap/css/jasny-bootstrap.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/datetimepicker/css/DateTimePicker.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/j_timepicker/css/jquery.timepicker.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/clockpicker/css/jquery-clockpicker.css')}}" />
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
						Agendamiento
					</h4>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="index1">
								<i class="fa ti-file" data-pack="default" data-tags=""></i>
								Dashboard
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="#">Socio</a>
						</li>
						<li class="breadcrumb-item active">Agendamiento</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="outer">
		<div class="inner bg-light lter bg-container">
			<div class="row">
				<div class="col">
					<div class="card m-t-35">
						<div class="card-header bg-white">
							<i class="fa fa-file-text-o"></i>
							Agendar cancha
						</div>
						<div class="card-body m-t-20">
							<!--main content-->
							<div class="row">
								<div class="col">
									<!-- BEGIN FORM WIZARD WITH VALIDATION -->
									<form id="commentForm" method="post" action="#" class="validate">
										<div id="rootwizard">
											<ul class="nav nav-pills">
												<li class="nav-item m-t-15">
													<a class="nav-link" href="#tab1" data-toggle="tab">
														<span class="userprofile_tab1">1</span>Seleccionar cancha</a>
												</li>
												<li class="nav-item m-t-15">
													<a class="nav-link" href="#tab2" data-toggle="tab">
														<span class="userprofile_tab2">2</span>Seleccionar fecha</a>
												</li>
												<li class="nav-item m-t-15">
													<a class="nav-link" href="#tab3"
													   data-toggle="tab"><span>3</span>Confirmar</a>
												</li>
											</ul>
											<div class="tab-content m-t-20">
												<div class="tab-pane" id="tab1">
													<div class="form-group">
														<label for="userName" class="control-label">Cancha *</label>
														{{-- <input id="userName" name="username" type="text"
															   placeholder="Enter your name"
															   class="form-control required"> --}}
														<select name="cancha" class="form-control required chzn-select">
															<option selected disabled>Selecciona tu cancha preferida</option>
															<optgroup label="Rancagua">
																<option>Cancha 1</option>
																<option>Cancha Palestino</option>
																<option>Cancha El teniente</option>
															</optgroup>
															<optgroup label="San fernando">
																<option>Cancha 2</option>
															</optgroup>
															<optgroup label="Talca">
																<option>Cancha 3</option>
																<option>Cancha Juan Carlos Díaz</option>
															</optgroup>
															<optgroup label="Valparaíso">
																<option>Cancha La Sebastiana</option>
																<option>Cancha Pablo Neruda</option>
																<option>Cancha Sotomayor</option>
															</optgroup>
														</select>
													</div>
													{{-- <div class="form-group">
														<label for="email" class="control-label">Email
															*</label>
														<input id="email" name="email"
															   placeholder="Enter your Email"
															   type="text"
															   class="form-control required email">
													</div>
													<div class="form-group">
														<label for="password" class="control-label">Password
															*</label>
														<input id="password" name="password" type="password"
															   placeholder="Enter your password"
															   class="form-control required">
													</div>
													<div class="form-group">
														<label for="confirm" class="control-label">Confirm
															Password
															*</label>
														<input id="confirm" name="confirm" type="password"
															   placeholder="Confirm your password "
															   class="form-control required">
													</div> --}}
													<ul class="pager wizard pager_a_cursor_pointer">
														<li class="previous">
															<a><i class="fa fa-long-arrow-left"></i>
																Previous</a>
														</li>
														<li class="next">
															<a>Next <i class="fa fa-long-arrow-right"></i>
															</a>
														</li>
														<li class="next finish" style="display:none;">
															<a>Finish</a>
														</li>
													</ul>
												</div>
												<div class="tab-pane" id="tab2">
													@php
													/* ########## DIAS de la semana ########## */
													$start = date_create();
													$finish = date_modify(date_create(), '+1 week');
													/* ########## BLOQUES DEL DIA ########## */
													$inicio = date_create('2020-11-17 09:00:00');
													$termino = date_create('2020-11-17 18:00:00');
													// while ($inicio <= $termino) {
													// 	$inicio->modify('+ 1 hour +30 minutes');
													// 	dump($inicio);
													// }
													@endphp
													<div class="col">
														<!-- BEGIN SAMPLE TABLE PORTLET-->
														<div class="card m-t-35">
															<div class="card-header bg-white">
																<i class="fa fa-table"></i> Fechas
															</div>
															<div class="card-body">
																<div class="table-responsive-sm m-t-35" style="overflow-x:auto;">
																	<table class="table table-striped {{-- table-bordered --}} table-advance {{-- table-hover --}} table-responsive">
																		<thead>
																		<tr>
																			@while($start <= $finish)
																			@php
																			setlocale(LC_TIME, "ES");
																			$start->modify('+1 days');
																			// dump(strftime('%A', $start->format('U')));
																			@endphp
																			<th width="12%">
																				{{ utf8_encode(strftime('%A', $start->format('U'))) }} {{ $start->format('d M') }}
																			</th>
																			@endwhile
																		</tr>
																		</thead>
																		<tbody class="btn-group-toggle" data-toggle="buttons">
																		@while($inicio <= $termino)
																		<tr>
																			<td class="highlight">
																				<label class="btn btn-block btn-primary btn-lg px-2">
																					<input type="radio" name="options" hidden id="option0">
																					{{ $inicio->format('H:i') }} - {{ date_create($inicio->format('Y-m-d H:i:s'))->modify('+1 hour +30 minutes')->format('H:i') }}
																				</label>
																			</td>
																			<td class="highlight">
																				<label class="btn btn-block btn-primary btn-lg">
																					<input type="radio" name="options" hidden id="option0">{{ $inicio->format('H:i') }} - {{ date_create($inicio->format('Y-m-d H:i:s'))->modify('+1 hour +30 minutes')->format('H:i') }}
																				</label>
																			</td>
																			<td class="highlight">
																				<label class="btn btn-block btn-primary btn-lg">
																					<input type="radio" name="options" hidden id="option0">{{ $inicio->format('H:i') }} - {{ date_create($inicio->format('Y-m-d H:i:s'))->modify('+1 hour +30 minutes')->format('H:i') }}
																				</label>
																			</td>
																			<td class="highlight">
																				<label class="btn btn-block btn-primary btn-lg">
																					<input type="radio" name="options" hidden id="option0">{{ $inicio->format('H:i') }} - {{ date_create($inicio->format('Y-m-d H:i:s'))->modify('+1 hour +30 minutes')->format('H:i') }}
																				</label>
																			</td>
																			<td class="highlight">
																				<label class="btn btn-block btn-primary btn-lg" style="background-color: #ff8086; border-color: #ff8086;">
																					<input type="radio" name="options" hidden id="option0">{{ $inicio->format('H:i') }} - {{ date_create($inicio->format('Y-m-d H:i:s'))->modify('+1 hour +30 minutes')->format('H:i') }}
																				</label>
																			</td>
																			<td class="highlight">
																				<label class="btn btn-block btn-primary btn-lg">
																					<input type="radio" name="options" hidden id="option0">{{ $inicio->format('H:i') }} - {{ date_create($inicio->format('Y-m-d H:i:s'))->modify('+1 hour +30 minutes')->format('H:i') }}
																				</label>
																			</td>
																			<td class="highlight">
																				<label class="btn btn-block btn-primary btn-lg">
																					<input type="radio" name="options" hidden id="option0">{{ $inicio->format('H:i') }} - {{ date_create($inicio->format('Y-m-d H:i:s'))->modify('+1 hour +30 minutes')->format('H:i') }}
																				</label>
																			</td>
																			<td class="highlight">
																				<label class="btn btn-block btn-primary btn-lg">
																					<input type="radio" name="options" hidden id="option0">{{ $inicio->format('H:i') }} - {{ date_create($inicio->format('Y-m-d H:i:s'))->modify('+1 hour +30 minutes')->format('H:i') }}
																				</label>
																			</td>
																		</tr>
																		@php
																		$inicio->modify('+ 1 hour +30 minutes');
																		@endphp
																		@endwhile
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
														<!-- END SAMPLE TABLE PORTLET-->
													</div>
													<ul class="pager wizard pager_a_cursor_pointer">
														<li class="previous">
															<a><i class="fa fa-long-arrow-left"></i>
																Previous</a>
														</li>
														<li class="next">
															<a>Next <i class="fa fa-long-arrow-right"></i>
															</a>
														</li>
														<li class="next finish" style="display:none;">
															<a>Finish</a>
														</li>
													</ul>
												</div>
												<div class="tab-pane" id="tab3">
													<div class="form-group">
														<label>Rut acompañante *</label>
														<input type="text" class="form-control" id="phone1"
															   name="rut2"
															   placeholder="11.111.111-1">
													</div>
													<div class="form-group">
														<label>Nombre acompañante *</label>
														<input type="text" class="form-control" id="phone2"
															   name="nombre2"
															   placeholder="Leandro">
													</div>
													<div class="form-group">
														<label>Telefono acompañante *</label>
														<input type="text" class="form-control" id="phone3"
															   name="telefono2"
															   placeholder="(999)999-9999">
													</div>
													<div class="form-group">
														<label>Correo acompañante *</label>
														<input type="text" class="form-control" id="phone3"
															   name="correo2"
															   placeholder="correo@correo.cl">
													</div>
													<div class="form-group">
														<span>Terminos y condiciones *</span>
														<br>
														<label class="custom-control custom-checkbox wizard_label_block">
															<input type="checkbox" id="acceptTerms"
																   name="acceptTerms"
																   class="custom-control-input">
															<span class="custom-control-label"></span>
															<span class="custom-control-description custom_control_description_color">I agree with the Terms and Conditions.</span>
														</label>

													</div>
													<ul class="pager wizard pager_a_cursor_pointer">
														<li class="previous">
															<a><i class="fa fa-long-arrow-left"></i>
																Previous</a>
														</li>
														<li class="next">
															<a>Next <i class="fa fa-long-arrow-right"></i>
															</a>
														</li>
														<li class="next finish" style="display:none;">
															<a>Finish</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div id="myModal" class="modal fade" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header">

														<h4 class="modal-title">Agendamiento</h4>
														<button type="button" class="close"
																data-dismiss="modal">&times;</button>
													</div>
													<div class="modal-body">
														<p>Datos enviados correctamente.</p>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default"
																data-dismiss="modal">
															OK
														</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!--main content end-->
					</div>
				</div>
			</div>
		</div>
		<!-- /.inner -->
	</div>
	<!-- /.outer -->
	<!-- /.content -->
@stop
@section('footer_scripts')
	<!--WIZARD-->
	<script type="text/javascript" src="{{asset('vendors/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/twitter-bootstrap-wizard/js/jquery.bootstrap.wizard.min.js')}}"></script>
	<!--End of plugin scripts-->
	<!--Page level scripts-->
	<script type="text/javascript" src="{{asset('js/pages/wizard.js')}}"></script>
	<!-- end page level scripts -->
	<!-- DATETIME PICKER -->
	<!-- plugin scripts -->
	<script type="text/javascript" src="{{asset('vendors/jquery.uniform/js/jquery.uniform.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/inputlimiter/js/jquery.inputlimiter.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/jquery-tagsinput/js/jquery.tagsinput.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/pluginjs/jquery.validVal.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/inputmask/js/jquery.inputmask.bundle.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/moment/js/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/daterangepicker/js/daterangepicker.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/datepicker/js/bootstrap-datepicker.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/autosize/js/jquery.autosize.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/jasny-bootstrap/js/jasny-bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/jasny-bootstrap/js/inputmask.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/datetimepicker/js/DateTimePicker.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/j_timepicker/js/jquery.timepicker.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendors/clockpicker/js/jquery-clockpicker.min.js')}}"></script>
	<!--end of plugin scripts-->
	<script type="text/javascript" src="{{asset('js/form.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/pages/datetime_piker.js')}}"></script>
	<!-- end of global scripts-->
@stop
