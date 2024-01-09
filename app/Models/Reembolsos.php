<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reembolsos extends Model
{
	use HasFactory;
	protected $table = "reembolsos";
	protected $guarded = [];
	protected $appends = ['tipo'];
	public function transactions ()
	{
		return $this->belongsTo(Transaction::class);
	}
	public function users ()
	{
		return $this->belongsTo(User::class);
	}
	public function agenda ()
	{
		return $this->belongsTo(Agenda::class);
	}
	public function getTipoAttribute ()
	{
		$tipo = $this->transactions->tipo;
		return $tipo;
	}
}
