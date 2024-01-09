<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ClubesController;
use App\Http\Controllers\RecintosController;
use App\Http\Controllers\SociosController;
use App\Http\Controllers\AplicacionesController;
use App\Http\Controllers\CancelacionesController;
use App\Http\Controllers\TransaccionesController;
use App\Http\Controllers\ConveniosController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\TerminosYCondController;
use App\Http\Controllers\TestApiController as Test;

include('web_builder.php');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* #################### RUTAS TEST #################### */
Route::group(['middleware' => 'tipo_estricto'], function() {
	Route::get('test', [HomeController::class,'test'])->name('test');
	Route::get('tipo_user/test', [UsersController::class,'test']);
	Route::get('notificaciones/test', [NotificationsController::class,'test']);
	Route::get('test/mail/welcome', [Test::class, 'mailView']);
});

// Route::get('test-wp', [FrontController::class,'testWP']);
// Route::get('test-view', [HomeController::class,'testView']);

Route::get('user/{user}/verificado', [UsersController::class, 'verificado'])->name('verificado');

/* #################### RUTAS LOGIN #################### */
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
	return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth:sanctum'], function() {
	/* ########## RUTAS DEL SISTEMA ########## */
	Route::get('/', 'HomeController@index')->name('/');
	Route::get('/home', 'HomeController@home')->name('home'); // OLD USER WEBAPP
	/* ########## USUARIOS ########## */
	Route::group(['prefix' => 'users','as' =>'users.','middleware' => 'tipo_estricto'], function() {
		Route::get('/', [UsersController::class,'index'])->name('index');
		Route::get('/add_user', [UsersController::class,'create'])->name('create');
		Route::post('/store', [UsersController::class,'store'])->name('store');
		Route::get('{id}/view_user', [UsersController::class,'edit'])->name('edit');
		Route::put('{id}/update', [UsersController::class,'update'])->name('update');
		Route::get('{id}/delete', [UsersController::class,'delete'])->name('delete');
		/* ########## BORRADOS ########## */
		Route::get('eliminados', [UsersController::class,'eliminados'])->name('eliminados');
		Route::get('{id}/borrar', [UsersController::class,'borrar'])->name('borrar');
		Route::get('{id}/restaurar', [UsersController::class,'restaurar'])->name('restaurar');
	});
	Route::group(['middleware' => 'tipo_estricto'], function() {
		/* ########## FUNCIONES SOLO PARA SUPER ADMIN ########## */
		Route::get('destacar/{id}/club', [ClubesController::class, 'destacar'])->name('destacar.club');
		Route::get('info/{id}/app', [ClubesController::class, 'infoApp'])->name('info.app.club');
		Route::put('info/{id}/app', [ClubesController::class, 'infoAppStore'])->name('info.app.club.store');
		/* ########## TERMINOS Y CONDICIONES ########## */
		Route::group(['prefix' => 'terminos-y-condiciones', 'as' => 'terminos.'], function() {
			Route::get('index', [TerminosYCondController::class, 'index'])->name('index');
			Route::post('store', [TerminosYCondController::class, 'store'])->name('store');
			Route::put('{id}/update', [TerminosYCondController::class, 'update'])->name('update');
			Route::get('{id}/delete', [TerminosYCondController::class, 'delete'])->name('delete');
			Route::get('{id}/get', [TerminosYCondController::class, 'get']);
		});
	});
	/* ##### PERFIL ##### */
	Route::get('perfil', [UsersController::class, 'perfil'])->name('perfil');
	Route::post('perfil/update', [UsersController::class, 'updatePerfil'])->name('perfil.update');
	Route::post('perfil/update/pass', [UsersController::class, 'updatePass'])->name('perfil.update.pass');
	/* ########## USUARIOS ########## */

	/* ########## FUNCIONES (SUPER)ADMIN ########## */
	Route::group(['prefix' => 'papelera','as' =>'papelera.','middleware' => 'tipo_estricto'], function() {
		Route::group(['prefix' => 'recintos', 'as' => 'recintos.'], function() {
			/* ########## BORRADOS ########## */
			Route::get('/papelera/eliminados', [RecintosController::class,'eliminados'])->name('eliminados');
			Route::get('{id}/borrar', [RecintosController::class,'borrar'])->name('borrar');
			Route::get('{id}/restaurar', [RecintosController::class,'restaurar'])->name('restaurar');
			/* ########## BORRADOS ########## */
		});
	});
	/* ########## FUNCIONES (SUPER)ADMIN ########## */

	//crud builder routes
	// Route::get('builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');
	// Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');
	// Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');
	// Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');
	// Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');
	// Route::post(
	// 	'generator_builder/generate-from-file',
	// 	'\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
	// )->name('io_generator_builder_generate_from_file');

	Route::get('comunas/{id?}', function($id = null){
		!is_null($id) ? : exit;
		return response()->json(App\Models\Comunas::whereRegionesId($id)->get());
	});
	
	Route::group(['middleware' => 'tipo_usuarios'], function() {
		// PERMISOS TIPOS DE USUARIO ADMIN Y VISUALIZADOR
		
		/* ########## AJAX ########## */
		Route::get('load/clubes', [ClubesController::class, 'loadClubes']);
		Route::get('load/{id}/servicios', [ServiciosController::class, 'loadServicios']);
		Route::get('load/{id}/agenda', [RecintosController::class, 'showEvento']);
		Route::get('load/{fecha}/agenda/{id}/servicio', [RecintosController::class, 'showEventoFecha']);
		Route::get('load/{rut}/user', [HomeController::class,'getUser']);
		Route::get('load/{id}/user/from-id', [HomeController::class,'getUserFromId']);
		Route::get('load/{id}/recintos', [ServiciosController::class, 'getRecinto']);
		Route::get('load/{date}/{id}/recintos/{clubid}', [HomeController::class, 'agendaRecintos']);
		Route::get('load/{date}/estadisticas', [HomeController::class, 'getDataDia']);
		Route::get('load/estadisticas/{dia}/{servicio}/{recinto?}', [HomeController::class, 'getDataDiaFiltrado']);
		Route::get('load/{id}/motivos', [CancelacionesController::class, 'getMotivos']);
		Route::get('load/{id}/convenios/{recinto}', [ConveniosController::class, 'getConvenios']);
		Route::get('load/users', [ConveniosController::class, 'getUsersPaginado']); // PAGINACION
		/* ########## AJAX ########## */
	});
	
	Route::group(['middleware' => 'tipo'], function() {
		// PERMISOS TIPOS DE USUARIO ADMIN 
		// TIPO DE USUARIO 3 y 4 VUELVEN
		/* ########## CAMBIO DE MENU ########## */
		Route::get('cambio/menu','HomeController@cambioMenu')->name('cambio.menu');
		/* ########## CAMBIO DE MENU ########## */
		Route::post('agendar/admin', [RecintosController::class, 'agendarAdmin'])->name('agendar.admin');
		Route::put('re-agendar/{id}/admin', [RecintosController::class, 'reAgendarAdmin'])->name('reagendar.admin');
		Route::group(['prefix' => 'clubes'], function() {
			/* ########## RESOURCE ########## */
			Route::get('index', [ClubesController::class, 'index'])->name('clubes.index');
			Route::get('{id}/config', [ClubesController::class, 'config'])->name('clubes.config');
			Route::get('{id}/edit', [ClubesController::class, 'edit'])->name('clubes.edit');
			Route::post('store', [ClubesController::class, 'store'])->name('clubes.store');
			Route::post('config', [ClubesController::class, 'formConfig'])->name('clubes.storeConfig');
			Route::put('{id}/update', [ClubesController::class, 'update'])->name('clubes.update');
			/* ########## RESOURCE ########## */
			Route::get('lista', [ClubesController::class,'lista'])->name('clubes.lista');
			Route::get('lista/admin', [ClubesController::class,'lista_admin'])->name('clubes.lista_admin');
			Route::get('{id}/delete', [ClubesController::class,'destroy'])->name('clubes.destroy');
			Route::group(['middleware' => 'tipo_estricto'], function() {
				/* ########## BORRADOS ########## */
				Route::get('eliminados', [ClubesController::class,'eliminados'])->name('clubes.eliminados');
				Route::get('{id}/borrar', [ClubesController::class,'borrar'])->name('clubes.borrar');
				Route::get('{id}/restaurar', [ClubesController::class,'restaurar'])->name('clubes.restaurar');
				/* ########## BORRADOS ########## */
			});
			/* ########## COMPARTIR ########## */
			Route::get('compartir/{id}/clubes/{club}', [AplicacionesController::class, 'compartirClub']);
			Route::get('compartir', [AplicacionesController::class, 'compartirTodo'])->name('clubes.compartir'); // SOLO TEST
		});

		Route::group(['prefix' => 'servicios', 'as' => 'servicios.'], function() {
			Route::get('todos', [ServiciosController::class,'todos'])->name('todos');
			Route::get('{club}', [ServiciosController::class,'index'])->name('index');
			Route::put('{club}/store', [ServiciosController::class,'store'])->name('store');
			Route::get('/{club}/edit/{id}', [ServiciosController::class,'edit'])->name('edit');
			Route::put('/{club}/update/{id}', [ServiciosController::class,'update'])->name('update');
			Route::get('/{club}/delete/{id}', [ServiciosController::class,'destroy'])->name('destroy');
			Route::get('{club}/get/{id}', [ServiciosController::class,'get'])->name('get');
			Route::group(['middleware' => 'tipo_estricto'], function() {
				/* ########## BORRADOS ########## */
				Route::get('eliminados/todos', [ServiciosController::class,'eliminados'])->name('eliminados');
				Route::get('{id}/borrar', [ServiciosController::class,'borrar'])->name('borrar');
				Route::get('{id}/restaurar', [ServiciosController::class,'restaurar'])->name('restaurar');
				/* ########## BORRADOS ########## */
			});
		});

		Route::group(['prefix' => 'recintos', 'as' => 'recintos.'], function() {
			/* ########## TEST ########## */
			Route::get('test/valores', [RecintosController::class,'test']);
			/* ########## TEST ########## */
			Route::get('todos', [RecintosController::class,'todos'])->name('todos');
			Route::get('{servicio}', [RecintosController::class,'index'])->name('index');
			Route::put('{servicio}/store', [RecintosController::class,'store'])->name('store');
			Route::get('/{servicio}/edit/{id}', [RecintosController::class,'edit'])->name('edit');
			Route::put('/{servicio}/update/{id}', [RecintosController::class,'update'])->name('update');
			Route::get('/{servicio}/delete/{id}', [RecintosController::class,'destroy'])->name('destroy');
			Route::get('/{servicio}/transacciones/{id}', [RecintosController::class,'transacciones'])->name('transacciones');
			Route::post('transacciones/liberacion', [RecintosController::class,'anularPorPagar'])->name('liberacion');
			Route::get('horarios/{id}', [RecintosController::class,'horarios'])->name('horarios');
			/* ########## HORARIOS DATA AJAX ########## */
			Route::get('horarios/{id}/get-data', [RecintosController::class,'getData'])->name('get.data');
			Route::put('horarios/status/{id}', [RecintosController::class,'status']);
			Route::put('horarios/{id}/block/day', [RecintosController::class,'blockDay'])->name('block.day');
			Route::put('horarios/{id}/unblock/day', [RecintosController::class,'unblockDay'])->name('unblock.day');
			// Route::get('horarios/status/{id}', 'RecintosController@horariosStatus')->name('horarios.status');
			/* ########## GALERIAS ########## */
			Route::put('/upload/{id}', [RecintosController::class,'upload'])->name('upload');
			Route::get('{name}/{id}/eliminar', [RecintosController::class, 'eliminar'])->name('eliminar');
			/* ########## PRECIOS HORARIOS ########## */
			Route::put('/store/{id}/precio', [RecintosController::class,'storePrecio'])->name('store.precio');
			Route::get('/delete/{id}/precio/{recinto?}', [RecintosController::class,'deletePrecio'])->name('delete.precio');
		});
		Route::group(['prefix' => 'socios', 'as' => 'socios.'], function() {
			Route::get('/',[SociosController::class,'index'])->name('index');
			Route::post('create',[SociosController::class,'create'])->name('create');
			// Route::get('/{id}/aceptar', [SociosController::class,'aceptar'])->name('aceptar');
			// Route::get('/{id}/rechazar', [SociosController::class,'rechazar'])->name('rechazar');
			Route::post("csv", [SociosController::class, "csv"])->name('csv');
			Route::put('{id}/upgrade', [SociosController::class, 'upgrade'])->name('upgrade');
		});

		Route::group(['prefix' => 'estadisticas', 'as' => 'estadisticas.'], function() {
			Route::get('/', [EstadisticasController::class, 'index'])->name('index');
			Route::get('{data}/periodo', [EstadisticasController::class, 'periodo'])->name('periodo');
			Route::get('test', [EstadisticasController::class, 'test'])->name('test');
			Route::get('reportes', [EstadisticasController::class, 'reportes'])->name('reportes');
			Route::get('instalacion',[EstadisticasController::class,'instalacionSinFecha'])->name('instalacion');
			Route::get('instalaciones/{desde}/{hasta}',[EstadisticasController::class,'instalaciones'])->name('instalaciones');
			Route::get('reporteArriendo', 'EstadisticasController@reportes', 'reporteArriendo')->name('reporteArriendo.pdf');
			Route::get('/data/{desde}/{hasta}/{club}/{servicio}/{recinto?}',
				[EstadisticasController::class, 'dataBoxesFilter']);
		});

		Route::group(['prefix' => 'notificaciones', 'as' => 'notificaciones.'], function() {
			Route::get('index', [NotificationsController::class, 'index'])->name('index');
			Route::post('store', [NotificationsController::class, 'store'])->name('store');
			Route::put('{id}/send', [NotificationsController::class, 'send'])->name('send');
			Route::put('{id}/sendconvenio', [NotificationsController::class, 'sendconvenio'])->name('sendconvenio');
			Route::get('{id}/delete', [NotificationsController::class, 'delete'])->name('delete');
			Route::get('{id}/users', [NotificationsController::class, 'users'])->name('users');
			Route::get('{id}/enviadas', [NotificationsController::class, 'enviadas'])->name('enviadas');
			Route::get('{id}/enviadasconvenio', [NotificationsController::class, 'enviadasconvenio'])->name('enviadasconvenio');
			Route::get('{id}/leidas', [NotificationsController::class, 'leidas'])->name('leidas');
		});

		Route::group(['prefix' => 'cancelaciones', 'as' => 'cancelaciones.'], function() {
			Route::get('/', [CancelacionesController::class, 'index'])->name('index');
			Route::get('motivos', [CancelacionesController::class, 'motivos'])->name('motivos');
			Route::post('motivos/store', [CancelacionesController::class, 'store'])->name('store');
			Route::get('motivos/{id}/delete', [CancelacionesController::class, 'delete'])->name('motivos.delete');
			Route::put('motivos/{id}/edit', [CancelacionesController::class, 'edit'])->name('motivos.edit');
			/* ########## CANCELAR DESDE EL ADMIN ########## */
			Route::put('{users_id}/cancela', [CancelacionesController::class, 'cancelarAdmin']);
		});

		Route::group(['prefix' => 'transacciones', 'as' => 'transacciones.'], function() {
			Route::get('/', [TransaccionesController::class, 'index'])->name('index');
			Route::get('/data/{desde}/{hasta}/{club}/{servicio}/{recinto?}', [TransaccionesController::class, 'dataTransactionsFilter']);
			Route::get('/lista/{desde}/{hasta}/{club}/{servicio}/{recinto?}', [TransaccionesController::class, 'dataListaFilter']);
			Route::get('reembolsos', [TransaccionesController::class, 'reembolsos'])->name('reembolsos');
			Route::put('reembolsos/{id}/store', [TransaccionesController::class, 'storeReembolsos'])->name('reembolsos.store');
		});

		Route::group(['prefix' => 'convenios', 'as' => 'convenios.'], function() {
			Route::get('/', [ConveniosController::class, 'index'])->name('index');
			Route::post('store', [ConveniosController::class, 'store'])->name('store');
			Route::put('{id}/update', [ConveniosController::class, 'update'])->name('update');
			Route::get('{id}/delete', [ConveniosController::class, 'delete'])->name('delete');
			Route::put('add/{id}/users', [ConveniosController::class, 'addUsers'])->name('add.users');
			Route::delete('delete/{id}/users', [ConveniosController::class, 'deleteUsers'])->name('delete.users');
			Route::put('add/{id}/recinto', [ConveniosController::class, 'saveRecintoConvenio'])->name('add.recinto');
			Route::post("add/users/csv", [ConveniosController::class, "addUsersCsv"])->name('add.users.csv');
			Route::get('{id}/infoUsers/{str?}', [ConveniosController::class, 'infoUsers'])->name('infoUsers'); // AJAX
			Route::get('{id}/get', [ConveniosController::class, 'get']); // AJAX
		});

		Route::group(['prefix' => 'multi-agenda', 'as' => 'multi.'], function() {
			Route::get('/', [AgendaController::class, 'index'])->name('index');
			Route::post('store', [AgendaController::class, 'store'])->name('store');
			Route::get('delete/{id}', [AgendaController::class, 'delete'])->name('delete');
			Route::post('load/data', [AgendaController::class, 'preLoadAgenda']);
			Route::get('reporte', [AgendaController::class, 'reporte'])->name('reporte');
			Route::get('reporte/search/{user}/{month}/{year}', [AgendaController::class, 'reporteSearch'])->name('reporte.search');
		});

		Route::group(['prefix' => 'agenda', 'as' => 'agenda.'], function() {
			Route::put('{id}/cambiar-estado', [AgendaController::class, 'cambiarEstadoPago']);
		});
	});

	/* #################### RUTAS MENU USUARIO #################### */
	Route::get('agenda/{mes?}/{ano?}', 'FrontController@agenda')->name('agenda');

	Route::get('agendamiento/{id}/servicio', 'FrontController@agendamiento')->name('agendamiento');
	Route::put('agendamiento/{id}/agendar', 'FrontController@agendar')->name('agendar');
	// AJAX
	Route::get('load/{id}/agenda/{date}', [FrontController::class,'loadAgenda'])->name('load.agenda');

	Route::get('arrendamiento/{id}/servicio', 'FrontController@arrendamiento')->name('arrendamiento');
	Route::put('agendamiento/{id}/arrendar', 'FrontController@arrendar')->name('arrendar');

	Route::any('tb/arrendamiento/respuesta', [FrontController::class,'commitTransaccionMall'])->name('arrendamiento.respuesta');
	Route::post('arrendamiento/reembolso', [FrontController::class,'reembolsoTransaccionMall'])->name('arrendamiento.reembolso');
	Route::post('arrendamiento/estado_transbank', 'FrontController@obtenerEstadoTransaccionMall')->name('arrendamiento.estado');



	Route::get('servicios/{id}/club', 'FrontController@servicios')->name('servicios');

	// Route::get('solicitar/{id}/membresia', [SociosController::class,'solicitar'])->name('solicitar'); YA NO VA

	// Route::get('home', 'FrontController@home')->name('home');

	Route::get('lista-clubes', [FrontController::class, 'listaClubes'])->name('lista-clubes');

	Route::get('pagar', [FrontController::class, 'pagar'])->name('pagar');

	Route::get('editar-perfil', [FrontController::class, 'editarPerfil'])->name('editar-perfil');

	Route::get('participantes-agenda', [FrontController::class, 'participantesAgenda'])->name('participantes-agenda');

	Route::get('participantes-arriendo', [FrontController::class, 'participantesArriendo'])->name('participantes-arriendo');

	// Route::get('perfil', 'FrontController@perfil')->name('perfil');

	Route::get('recuperar', [FrontController::class, 'recuperar'])->name('recuperar');

	Route::get('registro', [FrontController::class, 'registro'])->name('registro');

	/* ########## TEST TOKEN NOTIFICACIONES ########## */
	// Route::post('/save-token', [NotificationsController::class, 'saveToken'])->name('save-token');

	/* #################### RUTAS MENU USUARIO #################### */

	// catch all routes
	Route::get('{name?}', 'Admire2Controller@showView')->middleware('tipo_estricto');
	/* ########## RUTAS DEL SISTEMA ########## */
});
