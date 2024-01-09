<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersClubes extends Model
{
	use HasFactory;
	protected $table = "users_clubes";
	protected $guarded = [];
	public function users ()
	{
		return $this->belongsTo('App\Models\User');
	}
	public function clubes ()
	{
		return $this->belongsTo(Clubes::class);
	}
}
