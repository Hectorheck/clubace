@section('title'){{ 'Participantes Agendamiento' }}@endsection
@extends('sistema.socios.layout')
@section('content')
@include('sistema.socios.menu')
<header class="bg-azul">
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
		<h1>Agendamiento</h1>
    </div>
</header>

<div class="mt-auto">
    <div class="container">
        <div class="row">
            <div class="col">
                <h4>Invitados</h4>
            </div>
        </div>
    </div>
    <div class="bloque-footer pd-cuadro box-cuadro pt-25">
        <div class="container">
            <form action="" class="w-100">
                <!-- FORMULARIO 
                <div class="row">
                    <div class="col-12">
                        <h5>Acompañante 1</h5> <hr>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group error">
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" id="" placeholder="Juan Cancino">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group"> 
                            <label for="">Rut</label>
                            <input type="text" class="form-control" id="" placeholder="11.111.111-1">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group"> 
                            <label for="">Teléfono</label>
                            <input type="text" class="form-control" id="" placeholder="123456789">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group"> 
                            <label for="">E-mail</label>
                            <input type="email" class="form-control" id="" placeholder="example@example.com">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h5>Acompañante 2</h5> <hr>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group error"> 
                            <label for="">Nombre</label>
                            <input type="text" class="form-control" id="" placeholder="Juan Cancino">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group"> 
                            <label for="">Rut</label>
                            <input type="text" class="form-control" id="" placeholder="11.111.111-1">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Teléfono</label>
                            <input type="text" class="form-control" id="" placeholder="123456789">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group"> 
                            <label for="">E-mail</label>
                            <input type="email" class="form-control" id="" placeholder="example@example.com">
                            <small class="mensaje-error">Error al ingresar este campo</small>
                        </div>
                    </div>
                </div>
                -->
                <div class="row">    
                    <div class="col-12">
                        <div class="row">
                            <div class="col ">
                                <a href="#" class="btn btn-primary mb-25 mt-25 bg-azul">Agregar acompañante</a> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>  <br> <!-- eliminar los BR cuando se agreguen formularios -->
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
                                <a href="#" class="btn btn-success mb-25 mt-25" data-toggle="modal" data-target="#Modal">Finalizar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
	
<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Regitro con éxito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing, elit. Vitae earum et recusandae eum obcaecati fugit sunt fuga eius, perspiciatis praesentium harum! Quo vero nulla, cumque eum asperiores blanditiis enim, laudantium!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Volver</button>
            </div>
        </div>
    </div>
</div>
@endsection
