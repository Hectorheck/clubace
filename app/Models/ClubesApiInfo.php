<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubesApiInfo extends Model
{
	use HasFactory;
	protected $table = "clubes_api_infos";
	protected $guarded = [];
	public function clubes ()
	{
		return $this->belongsTo(Clubes::class);
	}
}
