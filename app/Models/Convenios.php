<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convenios extends Model
{
	use HasFactory, SoftDeletes;
	protected $table = "convenios";
	protected $guarded = [];
	public function clubes ()
	{
		return $this->belongsTo(Clubes::class);
	}
	public function users_convenios ()
	{
		return $this->hasMany(UserConvenios::class);
	}
}
