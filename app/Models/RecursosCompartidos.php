<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecursosCompartidos extends Model
{
	use HasFactory;
	protected $table = "recursos_compartidos";
	protected $guarded = [];
}
