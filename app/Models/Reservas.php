<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservas extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = "reservas";
	protected $guarded = [];
	public function users ()
	{
		return $this->belongsTo('App\Models\User');
	}
}
