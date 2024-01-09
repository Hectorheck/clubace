<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiTestController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\ApiWebController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\AplicacionesController;
use App\Http\Controllers\CancelacionesController;
use App\Http\Controllers\TerminosYCondController;
use App\Http\Controllers\VerificationApiController;
use App\Http\Controllers\TestApiController as Test;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('test', [ApiTestController::class, 'test']);
// Route::get('productos', function() {
// 	return "productos";
// });

// Ahora estoy haciendo la solicitud de inscripcion a un club y la carga de la agenda desde la api, mas la correccion de un detalle en los datos de la agenda. Esto ultimo de forma local

/* ########## AUTH API ########## */
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/forgot-password', [Laravel\Fortify\Http\Controllers\PasswordResetLinkController::class, 'store']);

Route::group(['prefix' => 'test_api'], function() {
	Route::get('test_club_app', [AplicacionesController::class, 'test']); // PARA CLUBES CON APP PROPIAS
	Route::get('phptest', [Test::class, 'phptest']);
});

Route::get('email/verify/{id}', [VerificationApiController::class,'verify'])->name('verificationapi.verify');
Route::get('email/resend', [VerificationApiController::class,'resend'])
	->name('verificationapi.resend')->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
	// $var = auth()->user();
	// dd($request->bearerToken(), $var->currentAccessToken()->tokenable());
	return $request->user()->makeHidden(['deleted_at','created_at','updated_at','comunas_id','regiones_id','fecha_nacimiento','rol_admin_general','rol_admin_club','rol_socio_club','estado_cuenta','motivo_suspencion','profile_photo_path',]);
});


Route::group(['middleware' => 'check_apps', 'prefix' => 'recursos'], function() {
	Route::get('check_apps', [AplicacionesController::class, 'test']);
	Route::get('clubes', [AplicacionesController::class, 'clubes']);
});

Route::group(['middleware' => 'auth:sanctum', 'verified'], function() {
	Route::get('/logout', [AuthApiController::class, 'logout']);
	Route::post('/update', [AuthApiController::class, 'update'])->middleware('verified');
	Route::post('/aceptar_terminos', [AuthApiController::class, 'aceptarTerminos']);
	Route::delete('eliminar-cuenta', [AuthApiController::class, 'selfDelete']);

	Route::post('device_data', [AuthApiController::class, 'device']);

	Route::get('/dashboard', [ApiWebController::class,'dashboard'])->middleware('verified');
	Route::get('/clubes', [ApiWebController::class,'clubes'])->middleware('verified');
	Route::get('/clubes/{latitud}/{longitud}/{km}', [ApiWebController::class,'clubesDistancia']);
	Route::get('/{id}/mi-club', [ApiWebController::class,'miClub']);
	Route::get('/mis-clubes', [ApiWebController::class,'misClubes']);
	// Route::get('/{id}/solicitar', [ApiWebController::class,'solicitar']); //  YA NO VA
	Route::get('/{id}/recintos', [ApiWebController::class,'recintos']);
	Route::get('/load/{id}/agenda/{date?}', [ApiWebController::class,'loadAgenda']);
	Route::post('agendamiento/agendar',[ApiWebController::class, 'agendar']);
	Route::post('agendar/multiple', [ApiWebController::class, 'agendaMulti']);
	Route::post('agendar/new', [Test::class, 'newAgendar']); // NUEVO
	// Route::get('/{id}/agendamiento',[ApiWebController::class, 'agendamiento']);
	// Route::put('agendamiento/{id}/agendar', [ApiWebController::class,'agendarApi'])->name('agendar.api');
	Route::get('agenda/{mes?}/{ano?}', [ApiWebController::class, 'agenda']);
	Route::post('/confirmar', [ApiWebController::class,'confirmarAsistencia']);
	Route::get('notificaciones', [ApiWebController::class, 'notificaciones']);
	Route::get('notificaciones/{id}/leida', [ApiWebController::class, 'notificacionesleida']);

	/* ########## CANCELAR HORA AGENDADA ########## */
	Route::get('{id}/motivos', [CancelacionesController::class, 'getMotivos']);
	Route::post('cancelar', [CancelacionesController::class, 'cancelar']);

	Route::get('destacados', [ApiWebController::class, 'ClubesDestacados']); // LISTA
	Route::post('destacados/dist', [ApiWebController::class, 'ClubesDestacadosDist']);
});

/* ########## URI para confirmar pago en webview desde app ########## */
Route::get('/agendamiento/{id}/confirmar', [ApiWebController::class, 'urlTransaction']);
Route::get('arrendamiento/respuesta', [ApiWebController::class, 'commitTransaccionMall']);

Route::get('terminos-y-condiciones', [TerminosYCondController::class, 'apiGetTerminos']);

/* ########## TEST NOTIFICACIONES ########## */
// Route::get('/send-notification', [NotificationsController::class, 'sendNotification']);










