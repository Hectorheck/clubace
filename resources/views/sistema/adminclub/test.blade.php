<form action="{{ route('agendar', 14279) }}" method="post">
	@method('PUT')
	@csrf
	<input type="text" name="horario_selected" placeholder="horario" value="14279">
	<input type="text" name="recintos_convenio_id" placeholder="convenio" value="10">
	<input type="text" name="recintos_id" placeholder="convenio" value="1">
	<button type="submit">enviar</button>
</form>