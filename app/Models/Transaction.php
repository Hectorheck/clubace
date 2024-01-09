<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	use HasFactory;
	protected $table = "transactions";
	protected $guarded = [];
	protected $appends = ['user_reserva', 'reserva'];

	public function agenda ()
	{
		// agenda_id
		return $this->belongsTo(Agenda::class);
	}
	public function getReserva ()
	{
		$data = $this->agenda->reserva;
		return $data;
	}
	public function getReservaAttribute ()
	{
		$reserva = $this->agenda->reserva;
		return $reserva;
	}
	public function getUserReservaAttribute ()
	{
		$user = $this->getReserva()->users;
		return $user;
	}

}

