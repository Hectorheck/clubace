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
						Blank
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
							<a href="#">Users</a>
						</li>
						<li class="breadcrumb-item active">Blank</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="outer">
		<div class="inner bg-light lter bg-container">
			<div class="row">
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
										<th>
											{{ utf8_encode(strftime('%A', $start->format('U'))) }} {{ $start->format('d M') }}
										</th>
										@endwhile
									</tr>
									</thead>
									<tbody>
									@while($inicio <= $termino)
									<tr>
										<td class="highlight">
											<label class="btn btn-block btn-primary btn-lg">
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
			</div>
		</div>
		<!-- /.inner -->
	</div>
	<!-- /.outer -->
	<!-- /.content -->
@stop

@section('footer_scripts')
<!--Plugin scripts-->
<!--End of plugin scripts-->
<!--Page level scripts-->
{{-- <script type="text/javascript" src="{{asset('js/pages/radio_checkbox.js')}}"></script> --}}
<!--End of Page level scripts-->
@stop
