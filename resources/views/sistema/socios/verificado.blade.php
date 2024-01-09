<!doctype html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Usuario verificado | AceClub</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ asset('recursos/css/estilos.css') }}">
	<link rel="stylesheet" href="{{ asset('recursos/css/responsive.css') }}">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100 bg-login">
	@if ($errors->any())
		<div {{-- $attributes --}}>
			<div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

			<ul class="mt-3 list-disc list-inside text-sm text-red-600">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="mt-auto">
		<div class="bloque-footer pd-cuadro box-cuadro pt-25 bloque-footer-radius">
			<div class="container">
				<div class="row">
					<div class="col-12 text-center">
						<img class="logoaceblub" src="{{ asset('recursos/img/logoaceclub.png') }}">
					</div>
					<div class="col-12 text-center">
						<h2>VERIFICADO!</h2>
					</div>
					<div class="col-12 text-center">
						<h4>Cuenta verificada, ya puedes ingresar a la APP</h4>
					</div>
					<div class="col-12 text-center">
						<p class="fz14">
							@if (Route::has('password.request'))
							<a href="{{ route('password.request') }}">Olvidaste tu contraseña?</a>
							@endif
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>