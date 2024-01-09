<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cancelaciones extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = "cancelaciones";
	protected $guarded = [];
	// Solo cancelar hasta 8 horas antes de la hora, antes se simplemente no se pueda ?? (CONFIGURABLE)
	// Avisar a usuarios que utilicen servicio y club de cancelacion por medio de notificacion
	// users_id agenda_id reservas_id motivos_cancelaciones_id
	public function users ()
	{
		return $this->belongsTo(User::class);
	}
	public function agenda ()
	{
		return $this->belongsTo(Agenda::class);
	}
	public function reservas ()
	{
		return $this->belongsTo(Reservas::class);
	}
	public function motivos_cancelaciones ()
	{
		return $this->belongsTo(MotivosCancelaciones::class);
	}
}
