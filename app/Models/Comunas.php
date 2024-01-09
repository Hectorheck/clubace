<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunas extends Model
{
	use HasFactory;
	public $table = 'comunas';
	public $guarded = [];
	public function regiones ()
	{
		return $this->belongsTo('App\Models\Regiones');
	}
}
