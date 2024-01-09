<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgenda extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agenda', function (Blueprint $table) {
			$table->id();
			$table->year('agno')->nullable();
			$table->string('mes', 2)->nullable();
			$table->string('dia', 2)->nullable();
			$table->date('fecha')->nullable();
			$table->time('hora_inicio_bloque')->nullable();
			$table->time('hora_fin_bloque')->nullable();
			$table->string('estado', 20)->nullable();
			$table->timestamp('reserva_temporal_inicio')->nullable();
			$table->timestamp('reserva_temporal_fin')->nullable();
			$table->unsignedBigInteger('reserva_id')->nullable();
			$table->unsignedBigInteger('recintos_id')->nullable();
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
		Schema::dropIfExists('agenda');
	}
}
