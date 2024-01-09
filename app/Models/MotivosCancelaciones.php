<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotivosCancelaciones extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = "motivos_cancelaciones";
	protected $guarded = [];
	public function clubes ()
	{
		return $this->belongsTo(Clubes::class);
	}
}
