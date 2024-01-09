<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubesDestacados extends Model
{
	use HasFactory;
	protected $table = "clubes_destacados";
	protected $guarded = [];
	public function clubes ()
	{
		return $this->belongsTo(Clubes::class);
	}
}
