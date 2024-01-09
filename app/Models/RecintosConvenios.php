<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecintosConvenios extends Model
{
	use HasFactory;
	protected $table = "recintos_convenios";
	protected $guarded = [];
	public function recintos ()
	{
		return $this->belongsTo(Recintos::class);
	}
	public function convenios ()
	{
		return $this->belongsTo(Convenios::class);
	}
}
