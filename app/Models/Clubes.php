<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clubes extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = 'clubes';
	protected $guarded = [];
	public function comunas ()
	{
		return $this->belongsTo('App\Models\Comunas');
	}
	public function servicios ()
	{
		return $this->hasMany(Servicios::class);
	}
	public function users_clubes ()
	{
		return $this->hasMany(UsersClubes::class, 'clubes_id');
	}
	public function convenios ()
	{
		return $this->hasMany(Convenios::class);
	}
	public function destacados ()
	{
		return $this->hasOne(ClubesDestacados::class);
	}
	public function api_info ()
	{
		return $this->hasOne(ClubesApiInfo::class);
	}
}
