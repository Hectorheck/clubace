@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Registrar Club
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
						<i class="fa fa-pencil"></i>
						Registrar club
					</h4>
				</div>
				<div class="col-sm-7 col-lg-6">
					<ol class="breadcrumb float-right nav_breadcrumb_top_align">
						<li class="breadcrumb-item">
							<a href="{{ route('/') }}">
								<i class="fa fa-home" data-pack="default" data-tags=""></i> Dashboard
							</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route('clubes.lista') }}">Clubes</a>
						</li>
						<li class="active breadcrumb-item">Registrar club</li>
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
						<div class="card-header bg-white">Registra un club</div>

						<div class="card-body">
							<!-- checkbox -->
							<div class="justify-content-center">
								<form action="{{ route('clubes.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal" onsubmit="return validarclub(this)">
									@csrf
									<!-- Name input-->
									<div class="row form-group">
										<div class="col-12 col-md-6 mt-3">
											<label for="rut" class="form-group-horizontal">Rut</label>
											<div class="input-group">
												<input type="text" name="rut" id="rut" maxlength="10" class="form-control rut" placeholder="Rut">
											</div>
											<span style="color: red;display:none;" id="mostrarrut">Debe Ingresar un Rut correspondiente</span>
										</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="razon_social" class="form-group-horizontal">Razon Social</label>
											<div class="input-group">
												<input type="text" name="razon_social" id="razon_social" class="form-control" placeholder="Razon Social">
											</div>
											<span style="color: red;display:none;" id="mostrarrazon">Debe Ingresar una Razon Social correspondiente</span>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-12 col-md-6 mt-3">
											<label for="display_name" class="form-group-horizontal">Nombre</label>
											<div class="input-group">
												<input type="text" name="display_name" id="display_name" class="form-control" placeholder="Nombre">
											</div>
											<span style="color: red;display:none;" id="mostrarnombre">Debe Ingresar un Nombre correspondiente</span>
										</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="rut_rep_legal" class="form-group-horizontal">Rut Representante Legal</label>
											<div class="input-group">
												<input type="text" name="rut_rep_legal" id="rut_rep_legal" maxlength="10" class="form-control rut" placeholder="Rut Representante Legal">
											</div>
											<span style="color: red;display:none;" id="mostrarrutr">Debe Ingresar un Rut de Representante correspondiente</span>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-12 mt-3">
											<label for="nom_rep_legal" class="form-group-horizontal">Nombre Representante Legal</label>
											<div class="input-group">
												<input type="text" name="nom_rep_legal" id="nom_rep_legal" class="form-control" placeholder="Nombre Representante Legal">
											</div>
											<span style="color: red;display:none;" id="mostrarnombrer">Debe Ingresar un Nombre de representante correspondiente</span>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-12 col-md-6 mt-3">
											<label for="" class="form-group-horizontal">Ubicación <span class="font-italic text-muted">(Mueve el puntero hasta la ubicacion que desees)</span></label>
											<div class="w-100">
												<div id="mapa"></div>
												<input type="hidden" name="geo" id="geo">
												<input type="hidden" name="lat" id="lat">
												<input type="hidden" name="lng" id="lng">
											</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="mt-3">
												<label for="direccion" class="form-group-horizontal">Busque aqui su dirección</label>
												<div class="input-group">
													<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Direccion">
												</div>
											</div>
											<span style="color: red;display:none;" id="mostrarcalle">Debe Ingresar una Direccion correspondiente</span>

											<div class="mt-3">
												<label for="numero" class="form-group-horizontal">Numero</label>
												<div class="input-group">
													<input type="text" name="numero" id="numero" class="form-control" placeholder="Numero">
												</div>
											</div>
											<span style="color: red;display:none;" id="mostrarnum">Debe Ingresar un Numero correspondiente</span>

											{{-- <div class="mt-3">
												<label for="apartado" class="form-group-horizontal">Apartado especial</label>
												<div class="input-group">
													<input type="text" name="apartado" id="apartado" class="form-control" placeholder="Apartado especial">
												</div>
											</div> --}}

										</div>
									</div>

									<div class="row form-group">
										<div class="col-12 col-md-6 mt-3">
											<label for="region" class="form-group-horizontal">Region</label>
											<div class="input-group">
												<select name="region" id="region" class="form-control" >
													<option value="" disabled selected>Seleccione</option>
													@foreach ($regiones as $region)
													<option value="{{ $region->id }}">{{ $region->nombre }}</option>
													@endforeach
												</select>
											</div>
											<span style="color: red;display:none;" id="mostrarregion">Debe Ingresar una Region correspondiente</span>
										</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="comuna" class="form-group-horizontal">Comunas</label>
											<div class="input-group">
												<select name="comuna" id="comuna" class="form-control">
												</select>
											</div>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-12 col-md-8">
											{{-- <div class="mt-3">
												<label for="color1" class="form-group-horizontal">Color Agendamiento</label>
												<div class="input-group">
													<input type="text" name="color1" id="color1" class="form-control color" placeholder="Color 1">
												</div>
											</div>

											<div class="mt-3">
												<label for="color2" class="form-group-horizontal">Color Arrendamiento</label>
												<div class="input-group">
													<input type="text" name="color2" id="color2" class="form-control color" placeholder="Color 2">
												</div>
											</div> --}}

											<div class="mt-3">
												<label for="" class="form-group-horizontal">Logotipo</label>
												<div class="custom-file">
													<input type="file" name="logotipo" id="logotipo" class="custom-file-input" accept="image/*" lang="es">
													<label class="custom-file-label" data-browse="Buscar" for="logotipo">Seleccionar Archivo</label>
												</div>
											</div>
										</div>

										<div class="col-12 col-md-4 mt-3 d-flex align-items-center">
											<div class="row">
												<div class="col-sm-6">
													<figure class="card p-2 mb-0">
														<img src="{{ asset('img/clubes/logotipo.png') }}" id="img-logotipo" class="w-100">
													</figure>
												</div>
											</div>
										</div>
									</div>
									<div class="row form-group">
										<div class="col-12 card-title pt-3 head">
											<h4>Configuración Transbank</h4>
										</div>

											<div class="col-12 col-md-6 mt-3">
												<label for="region" class="form-group-horizontal">Ambiente Transbank</label>
												<div class="input-group">
													<select name="estado_transbank" id="estado_transbank" class="form-control" >
														<option value="" disabled selected>Seleccione</option>
														<option value="0">Integración</option>
														<option value="1">Producción</option>
													</select>
												</div>
												<span style="color: red;display:none;" id="mostrarambiente">Debe Ingresar un Ambiente correspondiente</span>
											</div>

										<div class="col-12 col-md-6 mt-3">
											<label for="rut" class="form-group-horizontal">Código Comercio Transbank</label>
											<div class="input-group">
												<input type="text" name="codigo_comercio_transbank" id="codigo_comercio_transbank" maxlength="12" class="form-control" placeholder="Código Comercio Transbank">
											</div>
											<span style="color: red;display:none;" id="mostrarcodigo">Debe Ingresar un Codigo correspondiente</span>
										</div>
									</div>

									<div class="form-group">
										<button type="submit" class="btn btn-primary">Registrar</button>
										<button class="btn btn-warning" type="reset" id="clear" onclick="limpiarerror()">
											<i class="fa fa-refresh"></i>
											Limpiar
										</button>
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
<!-- end of page level js -->
<script src="{{ asset('js/validateRut.js') }}"></script>

{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyYIdOEuJyBpeqi50DKgsP522rF-1HIyY"></script> --}}
<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCIDDrqlGdIvHTkh_hmNzKXLZ5Du9Yv00&callback=initialize&v=weekly&libraries=places&channel=GMPSB_addressselection_v1_cABC"
	async>
</script>
<script>
window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
var map;
function initialize(position) {
	var lat = -34.170297368085244, lng = -70.74073702096939;

	map = new google.maps.Map(document.getElementById('mapa'), {
		zoom: 13,
		center: {
			lat: lat,
			lng: lng
		}
	});
	var marker = new google.maps.Marker({
		position:map.getCenter(),
		map:map,
		draggable:true
	});
	google.maps.event.addListener(marker,'dragend',function(event) {
		// document.getElementById("geo").value = this.getPosition().toString(); // OLD
		fillLatLng(marker.getPosition().lat(),marker.getPosition().lng());
	});
	const input = document.getElementById("direccion");
	const searchBox = new google.maps.places.SearchBox(input);
	searchBox.addListener("places_changed", () => {
		/* ########## LLAMAR FUNCION TAMBIEN PARA ACTUALIZAR MARCADORES ########## */
		const places = searchBox.getPlaces();
		if (places.length == 0) {
			return;
		}
		// For each place, get the icon, name and location.
		const bounds = new google.maps.LatLngBounds();
		places.forEach((place) => {
			if (!place.geometry || !place.geometry.location) {
				console.log("Returned place contains no geometry");
				return;
			}
			const icon = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25),
			};
			if (place.geometry.viewport) {
				// Only geocodes have viewport.
				bounds.union(place.geometry.viewport);
			} else {
				bounds.extend(place.geometry.location);
			}
		});
		map.fitBounds(bounds);
		let centro = map.getCenter().toJSON();
		marker.setPosition(centro);
		fillLatLng(centro.lat,centro.lng, centro);
		// console.log(initialLat, initialLong, centro);
	});
}
// google.maps.event.addDomListener(window, 'load', initialize);

function fillLatLng (lat, lng) {
	document.getElementById("lat").value = lat;
	document.getElementById("lng").value = lng;
	console.log(lat, lng);
}

$('#region').change(function() {
	let region = this.value;
	// console.log(region);
	$.ajax({
		url: `{{ asset('comunas') }}/${region}`,
		type: 'GET',
		cache: false
	}).done(function(resp) {
		// console.log(resp);
		$('#comuna').empty();
		$.each(resp, function(i, val) {
			$('#comuna').append(`<option value="${val.id}">${val.nombre}</option>`)
		});
	});
});

function visualizar(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$(`#img-logotipo`).attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$('#logotipo').change(function(){
	visualizar(this)
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/js/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript">
$('.color').colorpicker({
	customClass: 'colorpicker-2x',
	format: 'hex',
	colorSelectors: {
		'#000000' : '#000000',
		'#ffffff' : '#ffffff',
		'#FF0000' : '#FF0000',
		'#777777' : '#777777',
		'#337ab7' : '#337ab7',
		'#5cb85c' : '#5cb85c',
		'#5bc0de' : '#5bc0de',
		'#f0ad4e' : '#f0ad4e',
		'#d9534f' : '#d9534f'
	},
	sliders: {
		saturation: {
			maxLeft: 150,
			maxTop: 150
		},
		hue: {
			maxTop: 150
		},
		alpha: {
			maxTop: 150
		}
	}
});

	function validarclub(f) {
			var ok = true;
			//var msg = "Se encontraron los siguientes errores:";


			if(f.elements["rut"].value == ""){
						//msg += "<br>- Debe ingresar un Nombre.\n";
						document.getElementById("mostrarrut").style.display = "block";
						ok = false;
			}else{
				document.getElementById("mostrarrut").style.display = "none";
			}

			if(f.elements["razon_social"].value == ""){
						//msg += "<br>- Debe ingresar un rut.\n";
						document.getElementById("mostrarrazon").style.display = "block";
						ok = false;
			}else{
				document.getElementById("mostrarrazon").style.display = "none";
			}

			if(f.elements["display_name"].value == ""){
						//msg += "<br>- Debe ingresar un rut.\n";
						document.getElementById("mostrarnombre").style.display = "block";
						ok = false;
			}else{
				document.getElementById("mostrarnombre").style.display = "none";
			}

			if(f.elements["rut_rep_legal"].value == ""){
						//msg += "<br>- Debe ingresar un rut.\n";
						document.getElementById("mostrarrutr").style.display = "block";
						ok = false;
			}else{
				document.getElementById("mostrarrutr").style.display = "none";
			}

			if(f.elements["nom_rep_legal"].value == ""){
						//msg += "<br>- Debe ingresar un rut.\n";
						document.getElementById("mostrarnombrer").style.display = "block";
						ok = false;
			}else{
				document.getElementById("mostrarnombrer").style.display = "none";
			}

			if(f.elements["direccion"].value == ""){
						//msg += "<br>- Debe ingresar un rut.\n";
						document.getElementById("mostrarcalle").style.display = "block";
						ok = false;
			}else{
				document.getElementById("mostrarcalle").style.display = "none";
			}

			if(f.elements["numero"].value == ""){
						//msg += "<br>- Debe ingresar un rut.\n";
						document.getElementById("mostrarnum").style.display = "block";
						ok = false;
			}else{
				document.getElementById("mostrarnum").style.display = "none";
			}

			if(f.elements["region"].value == ""){
						//msg += "<br>- Debe ingresar un rut.\n";
						document.getElementById("mostrarregion").style.display = "block";
						ok = false;
			}else{
				document.getElementById("mostrarregion").style.display = "none";
			}


			if(f.elements["estado_transbank"].value == ""){
						//msg += "<br>- Debe ingresar un rut.\n";
						document.getElementById("mostrarambiente").style.display = "block";
						ok = false;
			}else{
				document.getElementById("mostrarambiente").style.display = "none";
			}

			if(f.elements["codigo_comercio_transbank"].value == ""){
						//msg += "<br>- Debe ingresar un rut.\n";
						document.getElementById("mostrarcodigo").style.display = "block";
						ok = false;
			}else{
				document.getElementById("mostrarcodigo").style.display = "none";
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
			document.getElementById("mostrarrazon").style.display = "none";
			document.getElementById("mostrarnombre").style.display = "none";
			document.getElementById("mostrarrutr").style.display = "none";
			document.getElementById("mostrarnombrer").style.display = "none";
			document.getElementById("mostrarcalle").style.display = "none";
			document.getElementById("mostrarnum").style.display = "none";
			document.getElementById("mostrarregion").style.display = "none";
			document.getElementById("mostrarambiente").style.display = "none";
			document.getElementById("mostrarcodigo").style.display = "none";
			var ok = true;

			return ok;
	}
</script>
@stop
