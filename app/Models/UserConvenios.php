<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConvenios extends Model
{
	use HasFactory;
	protected $table = "user_convenios";
	protected $guarded = [];
	public function users ()
	{
		return $this->belongsTo(User::class);
	}
	public function convenios ()
	{
		return $this->belongsTo(Convenios::class);
	}
}
