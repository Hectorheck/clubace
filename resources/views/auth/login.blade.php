<!doctype html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Login</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ asset('recursos/css/estilos.css') }}">
	<link rel="stylesheet" href="{{ asset('recursos/css/responsive.css') }}">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100 bg-login">  	
	<div class="mt-auto">
		<div class="bloque-footer pd-cuadro box-cuadro pt-25 bloque-footer-radius">
			<div class="container">
				<form method="POST" action="{{ route('login') }}" class="w-100">
					@csrf
					<div class="row">
						<div class="col-12 text-center">
							<img class="logoaceblub" src="{{ asset('recursos/img/logoaceclub.png') }}">
						</div>
						<div class="col-12 text-center">
							<h2>Login</h2>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group{{ $errors->has('email') ? ' error' : '' }}">
								<label for="email">Email</label>
								<input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required autofocus>
								@if ($errors->has('email'))
								<small class="mensaje-error">Error al ingresar este campo</small>
								@endif
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="form-group{{ $errors->has('password') ? ' error' : '' }}">
								<label for="password">Contraseña</label>
								<input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
								@if ($errors->has('password'))
								<small class="mensaje-error">Error al ingresar este campo</small>
								@endif
							</div>
						</div>
						
						<div class="col-12">
							<div class="row">
								<div class="col">
									<label for="remember_me" class="flex items-center">
										<input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
										<span class="ml-2 text-sm text-gray-600">Recuerdame</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-12 text-center">
							@if (Route::has('register'))
							<p class="fz14">¿Aún no tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
							@endif
						</div>

						<div class="col-12">
							<div class="row">
								<div class="col">
									<button type="submit" class="btn btn-success mb-25 mt-25">Ingresar</button>
								</div>
							</div>
						</div>
						<div class="col-12 text-center">
							<p class="fz14">
								@if (Route::has('password.request'))
								<a href="{{ route('password.request') }}">Olvidaste tu contraseña?</a>
								@endif
							</p>
						</div>
					</div>
				 </form>
				 @include('flash::message')
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
			</div>
		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
