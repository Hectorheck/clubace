@section('title'){{ 'Agendamiento' }}@endsection
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
		<h1>Pagar</h1>
    </div>
</header>

<div class="mt-auto">
    <div class="container">
        <div class="row">
            <div class="col">
                <h4>Metodo de Pago</h4>
            </div>
        </div>
    </div>
    <div class="bloque-footer pd-cuadro box-cuadro pt-25">
        <div class="container">
            <form action="" class="w-100">
                <div class="row">
                   
                    <div class="col-12">
                        <div class="row">
                            <div class="col">
                                <p>Lorem, ipsum dolor, sit amet consectetur adipisicing elit. Hic inventore consectetur id ut velit reiciendis tempora reprehenderit. Eum maiores, fugit assumenda, quam quaerat incidunt possimus laborum voluptate officia et in.</p>
                                <p>Lorem, ipsum dolor, sit amet consectetur adipisicing elit. Hic inventore consectetur id ut velit reiciendis tempora reprehenderit. Eum maiores, fugit assumenda, quam quaerat incidunt possimus laborum voluptate officia et in.</p>
                                <p>Lorem ipsum dolor, sit amet, consectetur adipisicing elit. Minus laudantium obcaecati, eos adipisci ut dicta rerum soluta quae voluptatem incidunt, quidem dolorum quaerat. Deserunt inventore hic nostrum culpa velit natus.</p>
                                <p>Lorem, ipsum dolor, sit amet consectetur adipisicing elit. Hic inventore consectetur id ut velit reiciendis tempora reprehenderit. Eum maiores, fugit assumenda, quam quaerat incidunt possimus laborum voluptate officia et in.</p>
                                <p>Lorem, ipsum dolor, sit amet consectetur adipisicing elit. Hic inventore consectetur id ut velit reiciendis tempora reprehenderit. Eum maiores, fugit assumenda, quam quaerat incidunt possimus laborum voluptate officia et in.</p>
                                <p>Lorem ipsum dolor, sit amet, consectetur adipisicing elit. Minus laudantium obcaecati, eos adipisci ut dicta rerum soluta quae voluptatem incidunt, quidem dolorum quaerat. Deserunt inventore hic nostrum culpa velit natus.</p>
                            </div>
                        </div>
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
