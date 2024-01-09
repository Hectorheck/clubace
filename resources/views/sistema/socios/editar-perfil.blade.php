@section('title'){{ 'Perfil' }}@endsection
@extends('sistema.socios.layout')
@section('content')
@include('sistema.socios.menu')
<header class="">
	<div class="degradado">
		<div class="iconos-header">
			<div class="row">
				<div class="col">
					<a href="{{ asset('/') }}">
						<img class="iconos" src="{{ asset('recursos/img/iconos/volver.svg') }}">
					</a>
				</div>
				<div class="col text-right">
					{{-- <span class="notificacion">412</span> --}}
					<a href="#">
						<img class="iconos" src="{{ asset('recursos/img/iconos/notificacion.svg') }}">
					</a>
					<a onclick="showmenu()" href="#">
						<img class="iconos icono-menu" src="{{ asset('recursos/img/iconos/menu.svg') }}">
					</a>
				</div>
			</div>
		</div>
		<h1>Editar Perfil</h1>
	</div>
</header>

<form method="POST" action="{{ route('user-profile-information.update', auth()->user()) }}" enctype="multipart/form-data">
	@csrf
	@method('PUT')
	<div class="container mt-contenido">
		<div class="row">
			<div class="col-12">
				<div class="bloque-cuadro pd-cuadro">
				<div class="row">
					<div class="col-5">
						<img class="avatar" src="{{ auth()->user()->profile_photo_url ?? asset('recursos/img/generic-profile.jpg') }}" alt="">
					</div>
					<div class="col-7">
						<input type="file" id="imgupload" name="photo" style="display: none;">
						<a href="#" id="OpenImgUpload" class="btn btn-success mb-25 mt-25">Cambiar imagen</a>
					</div>
				</div>
					<div class="row">
					<div class="col-12 col-md-6">
						<div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
							<label for="">Nombre</label>
							<input type="text" required name="nombres" class="form-control" placeholder="" value="{{ auth()->user()->nombres }}">
							<small class="mensaje-error">Error al ingresar este campo</small>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
							<label for="">Rut</label>
							<input type="text" name="rut" class="form-control rut" placeholder="" value="{{ auth()->user()->rut }}">
							<small class="mensaje-error">Error al ingresar este campo</small>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
							<label for="">Apellido Paterno</label>
							<input type="text" name="apellido_paterno" class="form-control" placeholder="" value="{{ auth()->user()->apellido_paterno }}">
							<small class="mensaje-error">Error al ingresar este campo</small>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
							<label for="">Apellido Materno</label>
							<input type="text" name="apellido_materno" class="form-control" placeholder="" value="{{ auth()->user()->apellido_materno }}">
							<small class="mensaje-error">Error al ingresar este campo</small>
						</div>
					</div>
					{{-- <div class="col-12 col-md-6">
						<div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
							<label for="">Teléfono</label>
							<input type="text" class="form-control" placeholder="">
							<small class="mensaje-error">Error al ingresar este campo</small>
						</div>
					</div> --}}
					<div class="col-12 col-md-6">
						<div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
							<label for="">E-mail</label>
							<input type="email" name="email" required class="form-control" value="{{ auth()->user()->email }}">
							<small class="mensaje-error">Error al ingresar este campo</small>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
							<label for="">Ciudad</label>
							<input type="text" name="ciudad" class="form-control" value="{{ auth()->user()->ciudad }}">
							<small class="mensaje-error">Error al ingresar este campo</small>
						</div>
					</div>
					{{-- <div class="col-12 col-md-6">
						<div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
							<label for="">Contraseña</label>
							<input type="text" class="form-control" placeholder="****">
							<small class="mensaje-error">Error al ingresar este campo</small>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
							<label for="">Confirmar Contraseña</label>
							<input type="text" class="form-control" placeholder="****">
							<small class="mensaje-error">Error al ingresar este campo</small>
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</div>

	<div class="row">    
		<div class="col-12">
			<div class="row">
				<div class="col">
					{{-- <a href="#" class="btn btn-success mb-25 mt-25">Actualizar Datos</a> --}}
					<button type="submit" class="btn btn-success mb-25 mt-25">Actualizar Datos</button>
				</div>
			</div>
		</div>
	</div>
</form>

@if (session('status'))
<div class="alert alert-success">
	{{-- session('status') --}}Informacion actualizada correctamente
</div>
@endif

@endsection
@section('script')
<script type="text/javascript">
	$('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
</script>
<script src="{{ asset('js/validateRut.js') }}"></script>
@endsection
