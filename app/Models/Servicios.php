<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicios extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = 'servicios';
	protected $guarded = [];
	protected $appends = ['photo_url',];
	public function clubes ()
	{
		return $this->belongsTo('App\Models\Clubes');
	}
	public function recintos ()
	{
		return $this->hasMany('App\Models\Recintos');
	}
	public function getPhotoUrlAttribute ()
	{
		return env('APP_URL')."/storage/img/servicios/".$this->id.".png";
	}
}
