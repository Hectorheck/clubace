<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asistencia extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = "asistencias";
	protected $guarded = [];
	public function agenda()
	{
		return $this->belongsTo(Agenda::class);
	}
}
