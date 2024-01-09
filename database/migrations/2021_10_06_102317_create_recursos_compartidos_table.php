<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecursosCompartidosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recursos_compartidos', function (Blueprint $table) {
			$table->id();
			$table->string('recurso')->nullable();
			$table->string('recurso_id')->nullable();
			$table->string('aplicaciones_id')->nullable();
			$table->string('estado')->nullable(); // ?? por si acaso
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
		Schema::dropIfExists('recursos_compartidos');
	}
}
