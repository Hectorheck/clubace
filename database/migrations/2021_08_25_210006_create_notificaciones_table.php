<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notificaciones', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('clubes_id')->nullable();
			$table->string('titulo')->nullable();
			$table->string('mensaje')->nullable();
			$table->string('tipo')->nullable();
			$table->string('creada')->nullable();
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
		Schema::dropIfExists('notificaciones');
	}
}
