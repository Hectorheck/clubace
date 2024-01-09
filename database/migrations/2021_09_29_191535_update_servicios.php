<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateServicios extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('servicios', function (Blueprint $table) {
			$table->dropColumn(['valor', 'bloque_horario', 'hora_inicio', 'hora_fin']);
			// $table->integer('valor')->nullable()->change();
			// $table->string('bloque_horario')->nullable()->change();
			// $table->time('hora_inicio')->nullable()->change();
			// $table->time('hora_fin')->nullable()->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('servicios', function (Blueprint $table) {
			//
		});
	}
}
