<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Galerias;

class Recintos extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = 'recintos';
	protected $guarded = [];
	protected $appends = ['galerias'];
	public function clubes ()
	{
		return $this->belongsTo('App\Models\Clubes');
	}
	public function servicios ()
	{
		return $this->belongsTo('App\Models\Servicios')->withTrashed();
	}
	public function agenda ()
	{
		return $this->hasMany('App\Models\Agenda');
	}
	public function precios ()
	{
		// recintos_precios es la tabla
		return $this->hasMany(RecintosPrecios::class);
	}
	public function recintos_convenios ()
	{
		return $this->hasMany(RecintosConvenios::class);
	}
	public function getEstado ($state = null)
	{
		if (is_null($state)) {
			return $this->agenda->where('estado','Reservado')
				->where('mes',date('m'))
				->where('agno',date('Y'));
		} else {
			return $this->agenda->where('estado',$state)
				->where('mes',date('m'))
				->where('agno',date('Y'));
		}
	}
	public function getGaleriasAttribute ()
	{
		/* ########## BUSCAR LISTA COMPLETA Y RETORNAR ########## */
		$galerias = Galerias::where(['modelo' => 'Recintos', 'modelo_id' => $this->id])->get();
		return $galerias;
		// return env('APP_URL')."/img/servicios/".$this->id.".png";
	}
}
