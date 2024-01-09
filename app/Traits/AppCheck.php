<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use Auth;
use Mail;
use View;
use Storage;
use App\Models\Clubes;
use App\Models\Recintos;
use App\Models\Reservas;
use App\Models\Agenda;
use App\Models\Aplicaciones;
use App\Models\RecursosCompartidos;
use App\Models\ClubesDestacados;
use App\Models\ClubesApiInfo;
use App\Models\TerminosYCondiciones;





trait AppCheck
{
	public function checkApp (Request $request)
	{
		$headers = $request->header();
		if(isset($headers['club-token']) && !is_null($headers['club-token'])) {
			$info = ClubesApiInfo::where(['token_club' => $headers['club-token'], 'app' => '1'])->first();
			if (!is_null($info)) {
				// SI VIENE TOKEN ENTONCES ES DE APP, SE RETORNA CLUB SI ES TRUE
				$club = Clubes::find($info->clubes_id);
				return $club;
			} else {
				// TOKEN ERRONEO, No se manda nada
				exit();
			}
			return false;
		} else {
			// Si no viene token, se mandan todos
			return false;
		}
		return false; 
	}
	public function removeClub ()
	{
		// QUITAR CLUBES CON APP
		$data = ClubesApiInfo::where(['app' => 1, 'compartido' => 0])->get()
			->pluck('clubes_id')->toArray();
		return $data;
	}
	public function checkTerminos ($var)
	{
		// Retorna los terminos que estan siendo aceptados o requeridos
		// VAR ACA PUEDE SER CLUB O FALSO
		if ($var) {
			$terminos = TerminosYCondiciones::where('clubes_id', $var->id)
				->whereDate('fecha_actualizacion', '<=', date('Y-m-d'))
				->orderBy('fecha_actualizacion', 'DESC')
				->first();
			return $terminos;
		}
		$terminos = TerminosYCondiciones::where('clubes_id', 0)
			->whereDate('fecha_actualizacion', '<=', date('Y-m-d'))
			->orderBy('fecha_actualizacion', 'DESC')
			->first();
		return $terminos;
	}
}















