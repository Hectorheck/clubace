{{-- <li {!! (Request::is('modelos*')? 'class="active"':"") !!}>
	<a href="{{ route('modelos.index') }} ">
		<i class="fa fa-puzzle-piece"></i>
		<span class="link-title menu_hide">&nbsp; Modelos</span>
	</a>
</li> --}}

{{-- <li {!! (Request::is('tipoUsers*')? 'class="active"':"") !!}>
	<a href="{{ route('tipoUsers.index') }} ">
		<i class="fa fa-puzzle-piece"></i>
		<span class="link-title menu_hide">&nbsp; Tipo Users</span>
	</a>
</li> --}}

@if(auth()->user()->tipo_usuarios_id == 1)
{{-- PAPELERA --}}
<li {!! (Request::is('papelera*')? 'class="dropdown_menu active"':'class="dropdown_menu"') !!}>
	<a href="{{-- route('clubes.lista') --}}#">
		<i class="fa fa-trash" aria-hidden="true"></i>
		<span class="link-title menu_hide">&nbsp; Papelera</span>
		<span class="fa arrow menu_hide"></span>
	</a>
	<ul>
		<li {!! (Request::is('clubes/eliminados')? 'class="active"' :"") !!}>
			<a href="{{ route('clubes.eliminados') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Clubes Eliminados
			</a>
		</li>
		<li {!! (Request::is('servicios/eliminados/*')? 'class="active"' :"") !!}>
			<a href="{{ route('servicios.eliminados') }}">
				<i class="fa fa-angle-right"></i>
				&nbsp; Servicios Eliminados
			</a>
		</li>
		<li {!! (Request::is('recintos/eliminados/*')? 'class="active"' :"") !!}>
			<a href="{{ route('papelera.recintos.eliminados') }}">
				<i class="fa fa-angle-right"></i>
				&nbsp; Instalaciones Eliminadas
			</a>
		</li>
	</ul>
</li>
<li {!! (Request::is('terminos-y-condiciones*')? 'class="dropdown_menu active"':'class="dropdown_menu"') !!}>
	<a href="{{-- route('clubes.lista') --}}#">
		<i class="fa fa-font" aria-hidden="true"></i>
		<span class="link-title menu_hide">&nbsp; Terminos y Condiciones</span>
		<span class="fa arrow menu_hide"></span>
	</a>
	<ul>
		<li {!! (Request::is('terminos-y-condiciones/index')? 'class="active"' :"") !!}>
			<a href="{{ route('terminos.index') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Terminos y Condiciones
			</a>
		</li>
	</ul>
</li>
@endif

@if(auth()->user()->tipo_usuarios_id == 2)
<li {!! (Request::is('multi-agenda*')? 'class="dropdown_menu active"':'class="dropdown_menu"') !!}>
	<a href="{{-- route('clubes.lista') --}}#">
		<i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
		<span class="link-title menu_hide">&nbsp; Agendar Multiples</span>
		<span class="fa arrow menu_hide"></span>
	</a>
	<ul>
		<li {!! (Request::is('multi-agenda')? 'class="active"' :"") !!}>
			<a href="{{ route('multi.index') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Agenda Multiple
			</a>
		</li>

		<li {!! (Request::is('multi-agenda/reporte')? 'class="active"' :"") !!}>
			<a href="{{ route('multi.reporte') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Reporte
			</a>
		</li>
	</ul>
</li>
<li {!! (Request::is('estadisticas*')? 'class="dropdown_menu active"':'class="dropdown_menu"') !!}>
	<a href="{{-- route('clubes.lista') --}}#">
		<i class="fa fa-bar-chart" aria-hidden="true"></i>
		<span class="link-title menu_hide">&nbsp; Estadísticas</span>
		<span class="fa arrow menu_hide"></span>
	</a>
	<ul>
		<li {!! (Request::is('estadisticas')? 'class="active"' :"") !!}>
			<a href="{{ route('estadisticas.index') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Estadísticas
			</a>
		</li>
		<li {!! (Request::is('estadisticas/reportes')? 'class="active"' :"") !!}>
			<a href="{{ route('estadisticas.reportes') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Reportes
			</a>
		</li>
	</ul>
</li>
<li {!! (Request::is('transacciones*')? 'class="dropdown_menu active"':'class="dropdown_menu"') !!}>
	<a href="####">
		<i class="fa fa-credit-card" aria-hidden="true"></i>
		<span class="link-title menu_hide">&nbsp; Transacciones</span>
		<span class="fa arrow menu_hide"></span>
	</a>
	<ul>
		<li {!! (Request::is('transacciones')? 'class="active"' :"") !!}>
			<a href="{{ route('transacciones.index') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Transacciones
			</a>
		</li>
		<li {!! (Request::is('transacciones/reembolsos')? 'class="active"' :"") !!}>
			<a href="{{ route('transacciones.reembolsos') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Reembolsos
			</a>
		</li>
	</ul>
</li>
<li {!! (Request::is('convenios*')? 'class="dropdown_menu active"':'class="dropdown_menu"') !!}>
	<a href="####">
		<i class="fa fa-handshake-o" aria-hidden="true"></i>
		<span class="link-title menu_hide">&nbsp; Convenios</span>
		<span class="fa arrow menu_hide"></span>
	</a>
	<ul>
		<li {!! (Request::is('convenios')? 'class="active"' :"") !!}>
			<a href="{{ route('convenios.index') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Convenios
			</a>
		</li>
		{{-- <li {!! (Request::is('transacciones/reembolsos')? 'class="active"' :"") !!}>
			<a href="{{ route('transacciones.reembolsos') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Reembolsos
			</a>
		</li> --}}
	</ul>
</li>
<li {!! (Request::is('notificaciones*')? 'class="dropdown_menu active"':'class="dropdown_menu"') !!}>
	<a href="{{-- route('clubes.lista') --}}#">
		<i class="fa fa-bell" aria-hidden="true"></i>
		<span class="link-title menu_hide">&nbsp; Notificaciones</span>
		<span class="fa arrow menu_hide"></span>
	</a>
	<ul>
		<li {!! (Request::is('notificaciones/index')? 'class="active"' :"") !!}>
			<a href="{{ route('notificaciones.index') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Notificaciones
			</a>
		</li>
	</ul>
</li>
<li {!! (Request::is('cancelaciones*')? 'class="dropdown_menu active"':'class="dropdown_menu"') !!}>
	<a href="####">
		<i class="fa fa-ban" aria-hidden="true"></i>
		<span class="link-title menu_hide">&nbsp; Cancelaciones</span>
		<span class="fa arrow menu_hide"></span>
	</a>
	<ul>
		<li {!! (Request::is('cancelaciones')? 'class="active"' :"") !!}>
			<a href="{{ route('cancelaciones.index') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Cancelaciones
			</a>
		</li>
		<li {!! (Request::is('cancelaciones/motivos')? 'class="active"' :"") !!}>
			<a href="{{ route('cancelaciones.motivos') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Motivos
			</a>
		</li>
	</ul>
</li>
@endif

<li {!! (Request::is('clubes*')? 'class="dropdown_menu active"':'class="dropdown_menu"') !!}>
	@if(auth()->user()->tipo_usuarios_id < 7)
	<a href="{{-- route('clubes.lista') --}}#">
		<i class="fa fa-cog" aria-hidden="true"></i>
		<span class="link-title menu_hide">&nbsp; Configuraciones</span>
		<span class="fa arrow menu_hide"></span>
	</a>
	@endif
	@if(auth()->user()->tipo_usuarios_id == 1)
	<ul>
		<li {!! (Request::is('clubes/lista')? 'class="active"' :"") !!}>
			<a href="{{ route('clubes.lista') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Lista de Clubes
			</a>
		</li>
		{{-- <li {!! (Request::is('clubes/eliminados')? 'class="active"' :"") !!}>
			<a href="{{ route('clubes.eliminados') }} ">
				<i class="fa fa-angle-right"></i>
				&nbsp; Clubes eliminados
			</a>
		</li> --}}
		<li {!! (Request::is('servicios/todos')? 'class="active"' :"") !!}>
			<a href="{{ route('servicios.todos') }}">
				<i class="fa fa-angle-right"></i>
				&nbsp; Servicios
			</a>
		</li>
		{{-- <li {!! (Request::is('servicios/eliminados/*')? 'class="active"' :"") !!}>
			<a href="{{ route('servicios.eliminados') }}">
				<i class="fa fa-angle-right"></i>
				&nbsp; Servicios eliminados
			</a>
		</li>
		<li {!! (Request::is('recintos/eliminados/*')? 'class="active"' :"") !!}>
			<a href="{{ route('recintos.eliminados') }}">
				<i class="fa fa-angle-right"></i>
				&nbsp; Recintos eliminados
			</a>
		</li> --}}
	</ul>
	{{-- @elseif(auth()->user()->tipo_usuarios_id == 2) --}}
	@elseif(count(auth()->user()->getClubes()) > 0)
		@php
		$current = !is_null(auth()->user()->clubes) ? auth()->user()->clubes->first()->clubes_id : 0;
		@endphp
		@if($current > 0)
		<ul>
			<li {!! (Request::is('clubes/lista/admin')? 'class="active"' :"") !!}>
				<a href="{{ route('clubes.lista_admin') }} ">
					<i class="fa fa-angle-right"></i>
					&nbsp; Datos del Club
				</a>
			</li>
			<li {!! (Request::is('servicios/*')? 'class="active"' :"") !!}>
				<a href="{{ route('servicios.todos') }} ">
					<i class="fa fa-angle-right"></i>
					&nbsp; Servicios
				</a>
			</li>
			<li {!! (Request::is('recintos/*')? 'class="active"' :"") !!}>
				<a href="{{ route('recintos.todos') }} ">
					<i class="fa fa-angle-right"></i>
					&nbsp; Instalaciones
				</a>
			</li>
			<li {!! (Request::is('socios')? 'class="active"' :"") !!}>
				<a href="{{ route('socios.index') }} ">
					<i class="fa fa-angle-right"></i>
					&nbsp; Usuarios
				</a>
			</li>
			<li {!! (Request::is('parametros/*')? 'class="active"' :"") !!}>
				<a href="{{-- route('socios.index') --}} ">
					<i class="fa fa-angle-right"></i>
					&nbsp; Parametros
				</a>
			</li>
		</ul>
		@endif
	@endif
</li>

