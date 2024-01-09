{{-- <x-guest-layout>
	<x-jet-authentication-card>
		<x-slot name="logo">
			<x-jet-authentication-card-logo />
		</x-slot>

		<div class="mb-4 text-sm text-gray-600">
			{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
		</div>

		@if (session('status'))
			<div class="mb-4 font-medium text-sm text-green-600">
				{{ session('status') }}
			</div>
		@endif

		<x-jet-validation-errors class="mb-4" />

		<form method="POST" action="{{ route('password.email') }}">
			@csrf

			<div class="block">
				<x-jet-label for="email" value="{{ __('Email') }}" />
				<x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
			</div>

			<div class="flex items-center justify-end mt-4">
				<x-jet-button>
					{{ __('Email Password Reset Link') }}
				</x-jet-button>
			</div>
		</form>
	</x-jet-authentication-card>
</x-guest-layout> --}}

<!doctype html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Recuperar contraseña | AceClub</title>
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
				<form method="POST" action="{{ route('password.email') }}" class="w-100">
					@csrf
					{{-- <input type="hidden" name="token" value="{{ $request->route('token') }}"> --}}
					<div class="row">
						<div class="col-12 text-center">
							<img class="logoaceblub" src="{{ asset('img/logoaceclub.png') }}" alt="">
						</div>
						<div class="col-12 text-center">
							<h2>Recuperar</h2>
						</div>
						<div class="mb-4 text-sm text-gray-600">
							{{ __('Olvidaste tu contraseña? No hay problema. Dejanos tu correo y te enviaremos un link que te permitira cambiar tu contraseña.') }}
						</div>

						@if (session('status'))
							<div class="mb-4 font-medium text-sm text-green-600">
								{{-- session('status') --}}
								{{ (session('status') == "We have e-mailed your password reset link!") ? "Te hemos enviado el link a tu correo!" : session('status') }}
							</div>
						@endif
						<div class="col-12 col-md-6">
							<div class="form-group {{-- error --}}"> <!-- AGREGAR LA CLASE ERROR PARA MARCAR EL ERROR -->
								<label for="">Email</label>
								<input class="form-control" type="email" name="email" id="" value="{{ old('email') }}">
								<small class="mensaje-error">Error al ingresar este campo</small>
							</div>
						</div>
						<div class="col-12">
							<div class="row">
								<div class="col">
									<button type="submit" class="btn btn-success mb-25 mt-25">Recuperar</button>
								</div>
							</div>
						</div>
						{{-- <div class="col-12 text-center">
							<p class="fz14">¿Tienes una cuenta? <a href="ingresar.html">Ingresa aquí</a></p>
						</div> --}}
					</div>
				 </form>
			</div>
		</div>
	</div>
	
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>
