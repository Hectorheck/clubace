<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiAgendasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('multi_agendas', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('users_id')->nullable(); //ENTRENADOR
			$table->unsignedBigInteger('clubes_id')->nullable();
			$table->unsignedBigInteger('recintos_id')->nullable();
			$table->date('fecha_inicio')->nullable();
			$table->date('fecha_termino')->nullable();
			$table->time('hora_inicio')->nullable();
			$table->time('hora_termino')->nullable();
			$table->string('dias')->nullable();
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
		Schema::dropIfExists('multi_agendas');
	}
}
