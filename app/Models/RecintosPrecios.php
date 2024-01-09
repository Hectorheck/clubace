<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecintosPrecios extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = "recintos_precios";
	protected $guarded = [];
	public function recintos ()
	{
		return $this->belongsTo(Recintos::class);
	}
}
