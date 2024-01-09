<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TerminosYCondiciones extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = "terminos_y_condiciones";
	protected $guarded = [];
	protected $appends = ['fecha_js'];
	public function clubes ()
	{
		return $this->belongsTo(Clubes::class);
	}
	public function getFechaJsAttribute ()
	{
		$date = date('Y-m-d', strtotime($this->fecha_actualizacion));
		return $date;
	}
}
