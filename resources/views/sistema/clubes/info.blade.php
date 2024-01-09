@extends(('layouts/compact_menu'))
{{-- Page title --}}
@section('title')
	Info de Club {{ $club->display_name }}
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
@stop

@section('content')
<div class="outer">
	<div class="inner bg-container forms">
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header bg-white">
						Datos para app móvil
					</div>
					<div class="card-body">
						<form action="{{ route('info.app.club.store', $club->id) }}" method="post">
							@csrf
							@method('PUT')
							<div class="row">
								<div class="col-lg-6 col-md-12 input_field_sections">
									<h5>Pública/Privada</h5>
								</div>
								<div class="col-lg-5 col-md-12 input_field_sections">
									<h5>App Si/No</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-12 input_field_sections">
									<input type="radio" class="form-control col-6" name="compartido" value="1" {{ (!is_null($info)) ? $info->compartido == 1 ? ' checked="true"' : '' : '' }} >Contenido compartido/Pública
								</div>
								<div class="col-lg-3 col-md-12 input_field_sections">
									<input type="radio" class="form-control col-6" name="compartido" value="0" {{ (!is_null($info)) ? $info->compartido == 0 ? ' checked="true"' : '' : '' }}>Acceso exclusivo/Privada
								</div>
								<div class="col-lg-3 col-md-12 input_field_sections">
									<input type="radio" class="form-control col-6" name="app" value="1" {{ (!is_null($info)) ? $info->app == 1 ? ' checked="true"' : '' : '' }}>SI
								</div>
								<div class="col-lg-3 col-md-12 input_field_sections">
									<input type="radio" class="form-control col-6" name="app" value="0" {{ (!is_null($info)) ? $info->app == 0 ? ' checked="true"' : '' : '' }}>NO
								</div>
							</div>
							{{-- </div>
							<div class="row"> --}}
							<div class="row">
								<div class="col-lg input_field_sections">
									<h5>Api Key para Firebase</h5>
									<input type="text" class="form-control" name="fbase_api_key" placeholder="FIRE BASE SERVER API KEY" value="{{ ($info) ? $info->fbase_api_key : '' }}"/>
								</div>
							{{-- </div>
							<div class="row"> --}}
								<div class="col-lg input_field_sections">
									<h5>Token para app móvil</h5>
									<div class="input-group">
										<input type="{{ (!is_null($info)) ? 'password' : 'text' }}" name="token_club" id="token" class="form-control" value="{{ ($info) ? $info->token_club : '' }}">
										<span class="input-group-append">
											<button class="btn btn-success" type="button" id="copy-token">
												<span class="glyphicon glyphicon-search" aria-hidden="true"></span> COPIAR
											</button>
											<button class="btn btn-secondary" type="button" id="ver-token" onclick="hideOrShowPassword()">
												<span class="glyphicon glyphicon-search" aria-hidden="true"></span> VER
											</button>
											<button class="btn btn-primary" type="button" id="generate-token">
												<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Generar
											</button>
										</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg input_field_sections">
									<button class="btn btn-success" type="submit">Guardar</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop

@section('footer_scripts')









<script>
function makeid (length) {
	var result = '';
	var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var charactersLength = characters.length;
	for ( var i = 0; i < length; i++ ) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}
	return result;
}
$('#generate-token').click(function() {
	$("#token").empty();
	let token = makeid(60);
	$("#token").val(token);
});
$('#copy-token').click(function () {
	$('#token-alert').fadeIn(100);
	//creamos un input que nos ayudara a guardar el texto temporalmente
	var $temp = $("<input>");
	//lo agregamos a nuestro body
	$("body").append($temp);
	//agregamos en el atributo value del input el contenido html encontrado
	//en el td que se dio click
	//y seleccionamos el input temporal
	$temp.val($('#token').val()).select();
	//ejecutamos la funcion de copiado
	document.execCommand("copy");
	//eliminamos el input temporal
	$temp.remove();
	$('#token-alert').delay(3500).fadeOut(300);
});
function hideOrShowPassword(){
  var password1,password2,check;

  password1=document.getElementById("token");

  if(password1.type=="password") // Si la checkbox de mostrar contraseña está activada
  {
      password1.type = "text";
  }
  else // Si no está activada
  {
      password1.type = "password";
  }
}
</script>
@stop









