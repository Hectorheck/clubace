<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bienvenido a {{ env('APP_NAME') }}</title>
</head>
<body>
	<div>
		Nombre: {{ $user->full_name }}
	</div>
	{{-- $message ?? "BIENVENIDO A APP" --}}
</body>
</html>