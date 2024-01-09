@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Terminos y condiciones
	@parent
@stop
{{-- page level styles --}}
@section('header_styles')
	<link type="text/css" rel="stylesheet" href="{{asset('vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min.css')}}" />
	<link type="text/css" rel="stylesheet" href="{{asset('css/pages/mail_box.css')}}"/>
@stop
@section('content')
	<header class="head">
		<div class="main-bar">
			<div class="row no-gutters">
				<div class="col-sm-4">
					<h4 class="nav_top_align">
						<i class="fa fa-eye"></i>
						Terminos y condiciones
					</h4>
				</div>
				<div class="col-sm-8">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
							</a>
						</li>
						{{-- <li class="breadcrumb-item">
							<a href="{{ route('/') }}">Dashboard</a>
						</li> --}}
						<li class="active breadcrumb-item">Terminos y condiciones</li>
					</ol>
				</div>
			</div>
		</div>
	</header>
	<div class="outer">
		<div class="inner bg-container">
			<div class="row web-mail mail_compose">
				<div class="col-lg-3 mail_compose_list">
					<div>
						<ul class="list-group">
							<li class="list-group-item">
								<a href="javascript:void(0)">
									<i class="fa fa-edit"></i>
									Lista de registros
								</a>
							</li>
							@foreach($terminos as $key => $termino)
							<li class="list-group-item btn-group">
								<a href="javascript:void(0)" class="lista" data-id="{{ $termino->id }}" onclick="cambioForm('{{ route('terminos.update', $termino->id) }}', 'put')">
									<i class="fa fa-file-text-o" aria-hidden="true"></i>
									{{ is_null($termino->clubes) ? 'General *' : $termino->clubes->display_name }} {{ date('d-m-Y', strtotime($termino->fecha_actualizacion)) }}
								</a>
								{{-- <a href="javascript:void(0)" class="btn "><i class="fa fa-trash-o"></i> Borrar</a> --}}
							</li>
							@endforeach
							{{--<li class="list-group-item">
								<a href="mail_inbox">
									<i class="fa fa-inbox"></i>
									Inbox
								</a>
							</li>
							<li class="list-group-item bg-success">
								<a href="mail_view" class="mail_inbox_text_col">
									<i class="fa fa-eye"></i>
									View Mail
								</a>
							</li>
							<li class="list-group-item">
								<a href="mail_trash">
									<span class="badge badge-pill badge-primary float-right">16</span>
									<i class="fa fa-trash"></i>
									Trash
								</a>
							</li>
							<li class="list-group-item" id="more_items">
								<a>
									<i class="fa fa-angle-down float-right"></i>
									More
								</a>
							</li>
							<li class="list-group-item starred_mail">
								<a href="#">
									<span class="badge badge-pill badge-primary float-right">3</span>
									<i class="fa fa-star"></i>
									Starred
								</a>
							</li>
							<li class="list-group-item starred_mail">
								<a href="#">
									<span class="badge badge-pill badge-primary float-right">14</span>
									<i class="fa fa-user"></i>
									Personal
								</a>
							</li>
							<li class="list-group-item starred_mail">
								<a href="#">
									<span class="badge badge-pill badge-primary float-right">26</span>
									<i class="fa fa-shield"></i>
									Client
								</a>
							</li>
							<li class="list-group-item starred_mail">
								<a href="#">
									<span class="badge badge-pill badge-primary float-right">36</span>
									<i class="fa fa-briefcase "></i>
									Important
								</a>
							</li> --}}
						</ul>
					</div>
					{{-- <div class="mail_ul_active m-t-35">
						<ul class="list-group">
							<li class="list-group-item bg-success">
								<a href="#" class="mail_inbox_text_col">
									<i class="fa fa-comments"></i>
									Contacts
								</a>
							</li>
						</ul>
					</div> --}}
					{{-- <div>
						<ul class="list-group contact_scroll">
							<li class="list-group-item status_height">
								<a href="#">
									<span class="status-online margin_top10"></span>
									&nbsp; John Cena
									<span class="float-left">
											<img src="{{asset('img/mailbox_imgs/1.jpg')}}"
												 class="rounded-circle img-responsive float-left inbox_contact_img" alt="Image">
										</span>
								</a>
							</li>
							<li class="list-group-item status_height">
								<a href="#">
									<span class="status-online margin_top10"></span>
									&nbsp; Peter Norton
									<span class="float-left">
											<img src="{{asset('img/mailbox_imgs/2.jpg')}}"
												 class="rounded-circle img-responsive float-left inbox_contact_img" alt="Image">
										</span>
								</a>
							</li>
							<li class="list-group-item status_height">
								<a href="#">
									<span class="status-busy margin_top10"></span>
									&nbsp; Marin Robbinson
									<span class="float-left">
											<img src="{{asset('img/mailbox_imgs/3.jpg')}}"
												 class="rounded-circle img-responsive float-left inbox_contact_img" alt="Image"></span>
								</a>
							</li>
							<li class="list-group-item status_height">
								<a href="#">
									<span class="status-away margin_top10"></span>
									&nbsp; Kimy Zorda
									<span class="float-left">
											<img src="{{asset('img/mailbox_imgs/4.jpg')}}"
												 class="rounded-circle img-responsive float-left inbox_contact_img" alt="Image"></span>
								</a>
							</li>
							<li class="list-group-item status_height">
								<a href="#">
									<span class="status-online margin_top10"></span>
									&nbsp; Hally
									<span class="float-left">
											<img src="{{asset('img/mailbox_imgs/5.jpg')}}"
												 class="rounded-circle img-responsive float-left inbox_contact_img" alt="Image"></span>
								</a>
							</li>
							<li class="list-group-item status_height">
								<a href="#">
									<span class="status-busy margin_top10"></span>
									&nbsp; Mike J Mayor
									<span class="float-left">
											<img src="{{asset('img/mailbox_imgs/6.jpg')}}"
												 class="rounded-circle img-responsive float-left inbox_contact_img" alt="Image"></span>
								</a>
							</li>
							<li class="list-group-item status_height">
								<a href="#">
									<span class="status-away margin_top10"></span>
									&nbsp; David Miller
									<span class="float-left">
											<img src="{{asset('img/mailbox_imgs/7.jpg')}}"
												 class="rounded-circle img-responsive float-left inbox_contact_img" alt="Image"></span>
								</a>
							</li>
							<li class="list-group-item status_height">
								<a href="#">
									<span class="status-away m-t-10"></span>
									&nbsp; Adela
									<span class="float-left">
											<img src="{{asset('img/mailbox_imgs/8.jpg')}}"
												 class="rounded-circle img-responsive float-left inbox_contact_img" alt="Image"></span>
								</a>
							</li>
							<li class="list-group-item status_height">
								<a href="#">
									<span class="status-away m-t-10"></span>
									&nbsp; Sandy Chris
									<span class="float-left">
											<img src="{{asset('img/mailbox_imgs/8.jpg')}}"
												 class="rounded-circle img-responsive float-left inbox_contact_img" alt="Image"></span>
								</a>
							</li>
							<li class="list-group-item status_height">
								<a href="#">
									<span class="status-online m-t-10"></span>
									&nbsp; Symons
									<span class="float-left">
											<img src="{{asset('img/mailbox_imgs/2.jpg')}}"
												 class="rounded-circle img-responsive float-left inbox_contact_img" alt="Image"></span>
								</a>
							</li>
							<li class="list-group-item status_height">
								<a href="#">
									<span class="status-busy m-t-10"></span>
									&nbsp; Randy
									<span class="float-left">
											<img src="{{asset('img/mailbox_imgs/1.jpg')}}"
												 class="rounded-circle img-responsive float-left inbox_contact_img" alt="Image"></span>
								</a>
							</li>
						</ul>
					</div> --}}
				</div>
				<div class="col-lg-9">
					<div class="card media_max_991">
						{{-- <div class="card-header bg-white">
							<p class="m-t-20">Subject: Hello, hope you having a great day ahead.</p>
							<p class="m-t-10"><span>From: admin@xyz.com </span><span class="float-right">06:15AM 28 FEB 2016</span></p>
						</div> --}}
						<div class="card-body m-t-35">
							<form action="{{ route('terminos.store') }}" method="post" id="form_target" {{-- class="mail_view_wysi" --}}>
								@csrf
								{{-- @method('PUT') <input type="hidden" name="_method" value="PUT"> --}}
								<input type="hidden" name="_method" id="_method">
								<div class="row form-group">
									<div class="col-12 col-md-6 mt-3">
										<label for="rut" class="form-group-horizontal">Fecha</label>
										<div class="input-group">
											<input type="date" name="fecha_actualizacion" id="fecha_actualizacion" class="form-control" value="{{ date('Y-m-d') }}">
										</div>
										{{-- <span style="color: red;display:none;" id="mostrarrut">Debe Ingresar un Rut correspondiente</span> --}}
									</div>
									<div class="col-12 col-md-6 mt-3">
										<label for="razon_social" class="form-group-horizontal">Club</label>
										<div class="input-group">
											<select class="form-control" name="clubes_id" id="clubes_id">
												<option value="0">Todos</option>
												@foreach($clubes as $club)
												<option value="{{ $club->id }}">{{ $club->display_name }}</option>
												@endforeach
											</select>
											{{-- <input type="text" name="razon_social" id="razon_social" class="form-control" placeholder="Razon Social" > --}}
										</div>
										<span style="color: red;display:none;" id="mostrarrazon">Debe Ingresar una Razon Social correspondiente</span>
									</div>
								</div>
								<textarea name="terminos" id="terminos" class="form-control" rows="20"></textarea>
							{{-- <h5>Hello John Smith!</h5>
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>
							<p>Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi.</p>
							<p>Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum.</p>
							<br/>
							<hr>
							<h4 class="m-t-25"><i class="fa fa-paperclip"></i> &nbsp;Attachments <span>(2)</span></h4>
							<div class="row">
								<div class="col-xl-3 col-lg-4 col-sm-4 col-6 m-t-20">
									<img class="img-thumbnail img-fluid view_admin_img" alt="Admin" src="{{asset('img/mailbox_imgs/1.jpg')}}">
								</div>
								<div class="col-xl-3 col-lg-4 col-sm-4 col-6  m-t-20">
									<img class="img-thumbnail img-fluid view_admin_img" alt="Admin" src="{{asset('img/mailbox_imgs/3.jpg')}}">
								</div>
							</div>
							<br/>
							<hr> --}}
								<div class="m-t-20">
									{{-- <form action="mail_sent" class="mail_view_wysi">
										<div class="form-group">
											<input type="email" class="form-control" id="forward_to" placeholder="To *" required="">
										</div>
										<div class="form-group">
											<textarea class="wysihtml5 form-control m-t-20" placeholder="Reply or Forward"></textarea>
										</div>
										<div class="form-group">
											<button class="btn btn-primary" id="goto_sent_page">Send</button>
											<a class="btn btn-primary" href="mail_view">Back</a>
										</div>
									</form> --}}
									<button class="btn btn-primary" type="submit">{{-- <i class="fa fa-reply"></i> --}} Guardar</button>
									<button class="btn btn-primary" type="button" onclick="resetForm()"> Nuevo</button>
									<a href="javascript:void(0)" class="btn btn-warning" id="borrar_btn"><i class="fa fa-trash-o"></i> Borrar</a>
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
	<script type="text/javascript" src="{{asset('vendors/bootstrap3-wysihtml5-bower/js/bootstrap3-wysihtml5.all.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/pluginjs/bootstrap3_wysihtml5.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/pages/mail_box.js')}}"></script>
	<script type="text/javascript">
		function cambioForm (action, method) {
			// console.log(action, method);
			// let input = `<input type="hidden" name="_method" id="_method" value="${method}">`;
			$('#form_target').attr('action', action);
			$("#_method").val(method);
			// $('#form_target').append(input);
		}
		$('.lista').click(function(event) {
			let id = $(this).attr('data-id');
			$('#clubes_id option').removeAttr('selected');
			{{-- PARA BORRAR --}}
			$("#borrar_btn").attr('href', `/terminos-y-condiciones/${id}/delete`);
			$.ajax({
				url: `/terminos-y-condiciones/${id}/get`,
				type: 'GET',
			})
			.done(function(response) {
				// console.log(response);
				$('#terminos').val(response.terminos);
				$('#fecha_actualizacion').val(response.fecha_js);
				// $('#clubes_id').val('${response.clubes_id}');
				$(`#clubes_id option[value=${response.clubes_id}]`).attr('selected','selected');
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		});
		function resetForm () {
			let action = '{{ route('terminos.store') }}';
			$('#clubes_id option').removeAttr('selected');
			$("#_method").val('post');
			$('#form_target').attr('action', action);
			$('#terminos').val('');
			$('#fecha_actualizacion').val('');
			$(`#clubes_id option[value=0]`).attr('selected','selected');
			$("#borrar_btn").attr('href', `javascript:void(0)`);
		}
	</script>
@stop
