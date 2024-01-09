@section('title'){{ 'Agendamiento' }}@endsection
@extends('sistema.socios.layout')
@section('content')
@include('sistema.socios.menu')
<header class="bg-anaranjado">
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
		<h1>Arriendo</h1>
    </div>
</header>

<div class="mt-auto">
    <div class="container">
        <div class="row">
            <div class="col">
                <h4>Agendar Paticipantes</h4>
            </div>
        </div>
    </div>
    <div class="bloque-footer pd-cuadro box-cuadro pt-25">
        <div class="container">
            <form action="" class="w-100">
                <div class="row">
                    <div class="col-12">
                        <h5>Datos Arrendatario</h5> <hr>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group error"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" id="" placeholder="Juan Cancino">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
                            <label for="">Rut</label>
                            <input type="text" class="form-control" id="" placeholder="11.111.111-1">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
                            <label for="">Teléfono</label>
                            <input type="text" class="form-control" id="" placeholder="123456789">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
                            <label for="">E-mail</label>
                            <input type="email" class="form-control" id="" placeholder="example@example.com">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h5>Acompañante 1</h5> <hr>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group error"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" id="" placeholder="Juan Cancino">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
                            <label for="">Rut</label>
                            <input type="text" class="form-control" id="" placeholder="11.111.111-1">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
                            <label for="">Teléfono</label>
                            <input type="text" class="form-control" id="" placeholder="123456789">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
                            <label for="">E-mail</label>
                            <input type="email" class="form-control" id="" placeholder="example@example.com">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                </div>
                <div class="row">    
                    <div class="col-12">
                        <div class="row">
                            <div class="col ">
                                <a href="#" class="btn btn-primary mb-25 mt-25 bg-anaranjado">Agregar otro acompañante</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h5>Terminos y condiciones</h5>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="">
                            <label class="form-check-label" for="">Estoy de acuerdo con los términos y condiciones.</label>
                        </div>
                    </div>
                </div>  
                <div class="row">    
                    <div class="col-12">
                        <div class="row">
                            <div class="col">
                                <a href="pagar.html" class="btn btn-success mb-25 mt-25">Pagar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
