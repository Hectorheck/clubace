{{-- @dd(auth()->user()->getClubes()) --}}
@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Convenios
	@parent
@stop
@section('header_styles')
<link type="text/css" rel="stylesheet" href="{{asset('css/pages/dataTables.bootstrap.css')}}"/>
<style>
.custom-file-label::after {
	content: "Buscar";
}
*:disabled {
	cursor: no-drop;
}
.progress {
	font-size: .90rem;
}
</style>
@stop
@section('content')

<header class="head">
	<div class="main-bar">
		<div class="row no-gutters">
			<div class="col-lg-6">
				<h4 class="nav_top_align skin_txt">
					<i class="fa fa-file-o"></i>
					Convenios
				</h4>
			</div>
		</div>
	</div>
</header>

<div class="outer">
	<div class="inner bg-container">
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header bg-white">
						Lista de Convenios
					</div>
					<div class="card-header bg-black">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newConvenio"><i class="fa fa-list" aria-hidden="true"></i> Nuevo</button>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered mt-2" id="editable_table_2">
								{{-- motivo	clubes_id --}}
								<thead>
									<tr>
										<th width="5%" style="text-align: center;">#</th>
										<th width="40%" style="text-align: center;">Convenio</th>
										<th width="40%" style="text-align: center;">Club</th>
										<th width="10%"></th>
									</tr>
								</thead>
								<tbody>
									@foreach($convenios as $key => $con)
									<tr>
										<td>{{ ($key + 1) }}</td>
										<td>{{ $con->titulo }}</td>
										<td>{{ $con->clubes->display_name }}</td>
										<td align="center">
											<div class="btn-group">
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-{{ $con->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
												<a href="{{-- route('cancelaciones.motivos.delete', $mot->id) --}}#" data-toggle="modal" data-target="#delete-{{ $con->id }}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
												<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUsers-{{ $con->id }}"><i class="fa fa-user-plus" aria-hidden="true"></i></button>
												<button type="button" class="btn btn-primary usersbtn" data-toggle="modal" data-id="{{ $con->id }}" data-target="#users"><i class="fa fa-users" aria-hidden="true"></i></button>
											</div>
										</td>
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
</div>


{{-- NUEVO MOTIVO --}}
<div class="modal fade" id="newConvenio" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="">
		<form method="post" action="{{ route('convenios.store') }}" onsubmit="return validarconvenio(this)">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">
						<i class="fa fa-info"></i> Nuevo Convenio
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" id="mbody">
					<div class="input-group">
						<div class="container">
							<div class="row">
								<div class="col-12 mt-3 mb-3">
									<div class="form-row">
										<div class="col-12 mb-2">
											<label>Titulo </label>
											<input type="text" name="titulo" id="titulo" class="form-control" placeholder="Titulo">
											<span style="color: red;display:none;" id="mostrartitulo" class="form-group mx-sm-3 mb-2">Debes ingresar un titulo correspondiente</span>
										</div>
										<div class="col-12 mb-2">
											<label>Descripcion (opcional) </label>
											{{-- <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion"> --}}
											<textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion"></textarea>
											<span style="color: red;display:none;" id="mostrardesc" class="form-group mx-sm-3 mb-2">Debes ingresar una descripcion correspondiente</span>
										</div>
										<div class="col">
											@foreach(auth()->user()->getClubes() as $club)
											<label class="p-3">
												<input type="checkbox" name="clubes_id[]" id="clubes_id" class="form-control clubes" value="{{ $club->id }}">{{ $club->display_name }}
											</label>
											@endforeach
											<span style="color: red;display:none;" id="mostrarclub" class="form-group mx-sm-3 mb-2">Debes seleccionar un club correspondiente</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger float-right" data-dismiss="modal">
						Cerrar
						<i class="fa fa-times"></i>
					</button>
					<button type="submit" class="btn btn-success pull-left text_save">Guardar</button>
				</div>
			</div>
		</form>
	</div>
</div>
@foreach($convenios as $key => $conv)
{{-- DELETE --}}
<div class="modal fade" id="delete-{{ $conv->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="container d-flex pl-0"><i class="fa fa-trash {{-- fa-2x --}}"></i>
					<h5 class="modal-title ml-2" id="exampleModalLabel">¿Seguro que desea borrar el registro?</h5>
				</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<p class="text-muted">Si lo borras, este dato no se podrá recuperar</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
				<a href="{{ route('convenios.delete', $conv->id) }}" class="btn btn-danger">Borrar</a>
			</div>
		</div>
	</div>
</div>
{{-- EDIT --}}
<div class="modal fade" id="edit-{{ $conv->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post" action="{{ route('convenios.update', $conv->id) }}" onsubmit="return validaractua(this)">
				@csrf
				@method('PUT')
				<div class="modal-header">
					<div class="container d-flex pl-0">
						<i class="fa fa-pencil" aria-hidden="true"></i>
						<h5 class="modal-title ml-2" id="exampleModalLabel">Editar registro</h5>
					</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<div class="form-row">
						<div class="col-12 mb-2">
							<input type="text" name="titulo" class="form-control" value="{{ $conv->titulo }}" required>
							<span style="color: red;display:none;" id="mostrartita" class="form-group mx-sm-3 mb-2">Debes ingresar un Titulo correspondiente</span>
						</div>
						<div class="col-12 mb-2">
							<textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion" required>{{ $conv->descripcion }}</textarea>
							<span style="color: red;display:none;" id="mostrardesca" class="form-group mx-sm-3 mb-2">Debes ingresar una Descripcion correspondiente</span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-danger">Actualizar</button>
				</div>
			</form>
		</div>
	</div>
</div>
{{-- ADD USERS --}}
<div class="modal fade" id="addUsers-{{ $conv->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="container d-flex pl-0">
					<i class="fa fa-pencil" aria-hidden="true"></i>
					<h5 class="modal-title ml-2" id="exampleModalLabel">Añadir usuarios al convenio {{ $conv->titulo }}</h5>
				</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a href="#agregar{{ $conv->id }}" data-toggle="tab" role="tab" aria-selected="true" class="nav-link active">Añadir usuarios</a>
					</li>
					<li class="nav-item">
						<a href="#agregarCSV{{ $conv->id }}" data-toggle="tab" role="tab" aria-selected="false" class="nav-link">Añadir usuarios CSV</a>
					</li>
				</ul>
				<div class="tab-content pt-2">
					<div class="tab-pane fade show active" id="agregar{{ $conv->id }}" role="tabpanel">
						<form method="post" action="{{ route('convenios.add.users', $conv->id) }}" onsubmit="return validarasig1(this)">
							@csrf
							@method('PUT')
							<input type="text" class="form-control mb-3" id="myInput-{{ $conv->id }}" onkeyup="busqueda({{ $conv->id }})" placeholder="Buscar por nombres..">
							<div class="table-responsive">
								<table class="table table-bordered" id="tabla-conv-{{ $conv->id }}">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Agregar</th>
										</tr>
									</thead>
									<tbody>
									{{-- @dump($usuarios,$usuarios->getOptions()) --}}
									@foreach($usuarios as $usuario)
									<tr>
										<td>{{ $usuario->full_name }}</td>
										<td>
											<input type="checkbox" class="form-control asig" name="usuarios[]" value="{{ $usuario->id }}">
										</td>
									</tr>
									@endforeach
									</tbody>
									{{-- <tfoot>
										<tr>
											<td class="p-0" align="center" colspan="100" style="border:none">
												{{ $usuarios->links('sistema.adminclub.convenios.paginacion') }}
											</td>
										</tr>
									</tfoot> --}}
								</table>
								<span style="color: red;display:none;" id="mostrarasig1">Debe Seleccionar un Usuarios correspondiente</span>
							</div>

							<div class="row text-right">
								<hr class="w-100">
								<div class="col-12">
									<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
									<button type="submit" class="btn btn-danger">Guardar</button>
								</div>
							</div>
						</form>
					</div>

					<div class="tab-pane fade" id="agregarCSV{{ $conv->id }}" role="tabpanel">
						<form {{-- action="{{ route('convenios.add.users.csv', $conv->id) }}" method="POST" enctype="multipart/form-data" --}} id="addConvCsv{{ $conv->id }}">
							@csrf
							<input type="hidden" name="_conv" value="{{ $conv->id }}">
							<div class="mb-3 w-100">
								<a href="{{ asset('recursos/ejemplo.csv') }}" target="_new" class="btn btn-info btn-block">Ver CSV de Ejemplo</a>
							</div>
							<div class="custom-file mb-3">
								<input type="file" name="csv" id="csv{{ $conv->id }}" class="form-control uploadCsv" data-convenio="{{ $conv->id }}" required>
								<label for="csv{{ $conv->id }}" id="upload_label_{{ $conv->id }}" class="custom-file-label">Buscar archivo CSV</label>
							</div>

							<div class="progress" style="height: 20px;">
								<div class="progress-bar" id="progressbar{{ $conv->id }}" style="display: none; width: 0%;">0%</div>
								<div class="progress-bar" id="progressbar2{{ $conv->id }}" style="display: none; width: 0%;">0%</div>
							</div>

							<span style="color: red;display:none;" id="mostrarasig2">Debe Seleccionar un CSV correspondiente</span>

							<div class="row text-right">
								<hr class="w-100">
								<div class="col-12">
									<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
									<button type="button" class="btn btn-danger cargarCsv" data-id="{{ $conv->id }}">Guardar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endforeach
{{-- USERS --}}
<div class="modal fade" id="users" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form method="post" action="{{-- route('convenios.add.users', $conv->id) --}}">
				@csrf
				@method('PUT')
				<div class="modal-header">
					<div class="container d-flex pl-0">
						<i class="fa fa-pencil" aria-hidden="true"></i>
						<h5 class="modal-title ml-2" id="exampleModalLabel">Usuarios con convenio <span id="nombre_convenio"></span><input type="hidden" name="convenio_id" id="convenio_id"></h5>
					</div> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
				</div>
				<div class="modal-body">
					<input type="text" class="form-control mb-3" id="BuscadorTabla" onkeyup="" placeholder="Buscar por nombres..">
					<div class="table-responsive">
						<table class="table table-bordered" id="tableUsers">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tbody id="tbody_users">
								{{-- @foreach($conv->users_convenios as $users)
								@if(!is_null($users->users))
								<tr>
									<td>{{ $users->users->full_name }}</td>
									<td>
										<a href="{{route('convenios.delete.users', $users->id)}}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
									</td>
								</tr>
								@else
								<tr>
									<td>USUARIO NO ENCONTRADO</td>
									<td>
										<a href="{{route('convenios.delete.users', $users->id)}}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
									</td>
								</tr>
								@endif
								@endforeach --}}
							</tbody>
							<tfoot id="tfoot"></tfoot>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					{{-- <button type="submit" class="btn btn-danger">Guardar</button> --}}
				</div>
			</form>
		</div>
	</div>
</div>

@stop
@section('footer_scripts')
<script type="text/javascript" src="{{asset('vendors/datatables/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vendors/datatables/js/dataTables.responsive.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {
	/* ########## TABLA 2 ########## */
	var table = $('#editable_table_2');
	table.DataTable({
		dom: "<'text-right'B><f>lr<'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
		buttons: [
			'copy', 'csv', 'print'
		]
	});
});
$('.uploadCsv').change(function() {
	// console.log($(this)[0].files[0].name);
	let i = $(this).prev('label').clone();
	let file = $(this)[0].files[0].name;
	$(this).next('label').text(file);
});
	$("#BuscadorTabla").keyup(function(event) {
		let texto = $("#BuscadorTabla").val();
		let id = $("#convenio_id").val();
		let uri = `/convenios/${id}/infoUsers/${texto}`;
		// console.log(texto,id,uri);
		$.ajax({
			url: uri,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response, response.data);
			ordenarData(response.data, response.links);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
	$(".usersbtn").click(function(event) {
		/* enviarbtn Act on the event */
		let id = $(this).attr('data-id');
		// let action = `/notificaciones/${id}/sendconvenio`;
		let uri = `/convenios/${id}/infoUsers`;
		// $("#form_sendconvenio").attr('action', action);
		$("#tbody_users").empty();
		$("#tfoot").empty();
		$("#nombre_convenio").empty();
		$("#convenio_id").val(id);
		$.ajax({
			url: `/convenios/${id}/get`,
			type: 'GET',
		})
		.done(function(response) {
			$("#nombre_convenio").append(`'${response.titulo}'`);
		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
		$.ajax({
			url: `/convenios/${id}/infoUsers`,
			type: 'GET',
		})
		.done(function(response) {
			// console.log(response, response.data);
			ordenarData(response.data, response.links);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
	function paginar (obj) {
		let str = ``;
		$.each(obj, function(index, val) {
			str += `<li class="page-item ${(val.active) ? 'active' : ''} ${(!val.url) ? 'disabled' : ''}"><a class="page-link" href="#" onclick="return navPag('${val.url}')">${val.label}</a></li>`;
		});
		return str;
	}
	function navPag (uri) {
		console.log(uri);
		$.ajax({
			url: uri,
			type: 'GET',
		})
		.done(function(response) {
			ordenarData(response.data, response.links);
		});
	}
	function navPag2 (uri) {
		console.log(uri);
	}
	function ordenarData (obj1, obj2) {
		/* ##### obj1 response completo, obj2 => solo links ##### */
		$("#tbody_users").empty();
		$("#tfoot").empty();
		$.each(obj1, function(index, val) {
			// console.log(val);
			$("#tbody_users").append(`
				<tr>
					<td>${ val.users.full_name }</td>
					<td>
						<form action="convenios/delete/${val.id}/users" method="POST">
							@csrf
							@method('DELETE')
						<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
						</form>

					</td>
				</tr>
			`);
		});
		let str = paginar(obj2);
		$("#tfoot").append(`
			<tr>
				<td class="p-0" align="center" colspan="100" style="border:none">
					<nav aria-label="Page navigation">
						<ul class="pagination">
							${str}
						</ul>
					</nav>
				</td>
			</tr>
		`);
	}
</script>
<script>
function busqueda(num) {
	// Declare variables
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById(`myInput-${num}`);
	filter = input.value.toUpperCase();
	table = document.getElementById(`tabla-conv-${num}`);
	tr = table.getElementsByTagName("tr");
	// Loop through all table rows, and hide those who don't match the search query
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}

	function validarconvenio(f) {
		//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
		//document.getElementById("mensajeerroruser").style.display = "none";
		var ok = true;
		//var msg = "Se encontraron los siguientes errores:";

		if(f.elements["titulo"].value == ""){
					//msg += "<br>- Debe ingresar un Nombre.\n";
					document.getElementById("mostrartitulo").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrartitulo").style.display = "none";
		}

		if(f.elements["descripcion"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrardesc").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrardesc").style.display = "none";
		}

		//todos=document.getElementsByTagName('dias');
		todos = document.getElementsByClassName('clubes');
		//console.log(todos);
		var cant = 0;
		for(x=0;x<todos.length;x++){
			if(todos[x].checked){
				cant++;
			}
		}

		if (cant==0) {
			document.getElementById("mostrarclub").style.display = "block";
			ok = false;
		}else{
			document.getElementById("mostrarclub").style.display = "none";

		}







		if(ok == false)
			//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = msg;
			//document.getElementById("mensajeerroruser").style.display = "block";
			//alert(msg);

		return ok;
	}

	function validaractua(f) {
		//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
		//document.getElementById("mensajeerroruser").style.display = "none";
		var ok = true;
		//var msg = "Se encontraron los siguientes errores:";

		if(f.elements["titulo"].value == ""){
					//msg += "<br>- Debe ingresar un Nombre.\n";
					document.getElementById("mostrartita").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrartita").style.display = "none";
		}

		if(f.elements["descripcion"].value == ""){
					//msg += "<br>- Debe ingresar un rut.\n";
					document.getElementById("mostrardesca").style.display = "block";
					ok = false;
		}else{
			document.getElementById("mostrardesca").style.display = "none";
		}


		if(ok == false)
			//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = msg;
			//document.getElementById("mensajeerroruser").style.display = "block";
			//alert(msg);

		return ok;
	}

	function validarasig1(f) {
		//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = '';
		//document.getElementById("mensajeerroruser").style.display = "none";
		var ok = true;
		//var msg = "Se encontraron los siguientes errores:";

		//todos=document.getElementsByTagName('dias');
		todos = document.getElementsByClassName('asig');
		//console.log(todos);
		var cant = 0;
		for(x=0;x<todos.length;x++){
			if(todos[x].checked){
				cant++;
			}
		}

		if (cant==0) {
			document.getElementById("mostrarasig1").style.display = "block";
			ok = false;
		}else{
			document.getElementById("mostrarasig1").style.display = "none";
		}


		if(ok == false)
			//document.getElementsByClassName('textouser')[0].firstElementChild.innerHTML = msg;
			//document.getElementById("mensajeerroruser").style.display = "block";
			//alert(msg);

		return ok;
	}

	$("#newConvenio").on("hidden.bs.modal", function () {
		document.getElementById("mostrarclub").style.display = "none";
		document.getElementById("mostrardesc").style.display = "none";
		document.getElementById("mostrartitulo").style.display = "none";
	});

	function loading(id){
		var time = 400;
		$.each(new Array(101), function(n) {
			setTimeout(function(){
				$(`#progressbar${id}`).css('width', n+'%').text(n+'%');
			}, time);
			time += 400;
		});
	}

	$('.cargarCsv').click(function(){
		let id = $(this).data('id');
		var form = $(`#addConvCsv${id}`)[0];
		var data = new FormData(form);
		let self = $(this);
		self.prop("disabled", true);

		$.ajax({
			type: "POST",
			enctype: "multipart/form-data",
			url: "{{ route('convenios.add.users.csv') }}",
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend: function () {
				$(`#progressbar2${id}`).css('display', 'none');
				$(`#progressbar2${id}`).css('width', '0%').text('0%');
				$(`#progressbar${id}`).css('display', 'inherit');
				loading(id);
			},
			success: function (resp) {
				$(`#progressbar2${id}`).css('display', 'inherit');
				$(`#progressbar2${id}`).css('width', '100%').text('100%');
				$(`#progressbar${id}`).css('display', 'none');
				$(`#progressbar${id}`).css('width', '100%').text('100%');
				alert('Archivo cargado correctamente');

				setTimeout(function () {
					$(`#addUsers-${id}`).modal('toggle');
				}, 2000);
			},
		})
		.fail(function(e) {
			alert(e.responseJSON.errors);

			$(`#progressbar2${id}`).css('display', 'inherit');
			$(`#progressbar2${id}`).css('width', '0%').text('0%');
			$(`#progressbar${id}`).css('display', 'none');
			$(`#progressbar${id}`).css('width', '0%').text('0%');

			location.reload();
			return;
		})
		.always(function() {
			self.removeAttr("disabled");
		});
	});
</script>
@stop
