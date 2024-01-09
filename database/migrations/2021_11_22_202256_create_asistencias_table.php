<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asistencias', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('users_id')->nullable();
			$table->unsignedBigInteger('agenda_id')->nullable();
			$table->unsignedBigInteger('reservas_id')->nullable();
			$table->string('estado')->nullable(); // CANCELADO ?? CONFIRMADO, ETC
			$table->boolean('confirmado')->nullable();
			$table->datetime('time_confirmado')->nullable(); // FECHA Y HORA DE CONFIRMACION
			$table->softDeletes();
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
		Schema::dropIfExists('asistencias');
	}
}
