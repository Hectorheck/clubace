<!doctype html>
<html lang="es" class="h-100">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>@yield('title')</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="shortcut icon" href="{{ asset('/recursos/img/logoaceclub.png') }}" />
	<link rel="stylesheet" href="{{ asset('/recursos/css/estilos.css') }}">
	<link rel="stylesheet" href="{{ asset('/recursos/css/responsive.css') }}">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
	@yield('style')
</head>
<body class="d-flex flex-column h-100 @if(Request::is('/') || Request::is('home')) bg-login @endif">
	@yield('content')
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

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<script type="text/javascript" src="{{ asset('/recursos/js/script.js') }}"></script>
	@yield('script')
	<script type="text/javascript">
		function logoutJs () {
			$("#close_session").submit();
		}
	</script>
	<script>
		$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
		// $('#flash-overlay-modal').modal();
	</script>
</body>
</html>
