<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacionesUsers extends Model
{
	use HasFactory;
	protected $table = "notificaciones_users";
	protected $guarded = [];
	public function notificaciones ()
	{
		return $this->belongsTo(Notificaciones::class);
	}
	public function user ()
	{
		return $this->belongsTo(User::class);
	}
}
