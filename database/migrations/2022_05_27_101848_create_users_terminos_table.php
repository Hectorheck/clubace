<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTerminosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_terminos', function (Blueprint $table) {
			$table->id();
			$table->datetime('fecha_actualizacion')->nullable();
			$table->date('fecha')->nullable();
			$table->time('hora')->nullable();
			$table->foreignId('terminos_y_condiciones_id')->nullable();
			$table->foreignId('users_id')->nullable();
			$table->foreignId('clubes_id')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users_terminos');
	}
}
