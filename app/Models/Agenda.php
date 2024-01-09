<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RecintosPrecios;

class Agenda extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = 'agenda';
	protected $guarded = [];
	protected $appends = ['valor_hora','bloque', 'recinto', 'instalacion_full'];
	public function recintos ()
	{
		return $this->belongsTo(Recintos::class);
	}
	public function reserva ()
	{
		return $this->belongsTo(Reservas::class);
	}
	public function asistencia()
	{
		return $this->hasOne(Asistencia::class);
	}
	public function transaction ()
	{
		return $this->hasOne(Transaction::class);
	}
	public function getRecintoAttribute ()
	{
		$instalacion = is_null($this->recintos) ? '' : $this->recintos->nombre;
		return $instalacion;
	}
	public function getInstalacionFullAttribute ()
	{
		$instalacion = is_null($this->recintos) ? '' : $this->recintos->nombre;
		$servicio = is_null($this->recintos->servicios) ? '' : $this->recintos->servicios->nombre;
		return "$servicio $instalacion";
	}
	public function getValorHoraAttribute ()
	{
		/* ########## BUSCAR PRECIO SEGUN HORA ########## */
		$precio = RecintosPrecios::where('recintos_id', $this->recintos_id)
			->where('desde', '<=', $this->hora_inicio_bloque)
			->where('hasta', '>=', $this->hora_fin_bloque)
			->first();
		if (is_null($precio)) {
			$precio = 0;
		} else {
			$precio = $precio->precio;
		}
		return $precio;
	}
	public function getBloqueAttribute ()
	{
		$bloque = date('H:i', strtotime($this->hora_inicio_bloque))." - ".date('H:i', strtotime($this->hora_fin_bloque));
		return $bloque;
	}
}
