<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
	use HasFactory;
	/* ########## CONTENIDO ########## */
	// Lista de notificaciones: texto, id de club, tipo 1 (automatica o creada a mano)
	// y tipo 2 (si es promocion o de que se trata la noti?) Estos datos se podran ir expandiendo
	// Luego otra tabla relacionando el estado de la notificacion enviada con el usuario que recibe
	protected $table = "notificaciones";
	protected $guarded = [];
	public function clubes ()
	{
		return $this->belongsTo('App\Models\Clubes');
	}
	public function users ()
	{
		return $this->hasMany(NotificacionesUsers::class, 'notificaciones_id');
	}
}
