<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminosYCondicionesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('terminos_y_condiciones', function (Blueprint $table) {
			$table->id();
			$table->text('terminos')->nullable();
			$table->datetime('fecha_actualizacion')->nullable();
			$table->unsignedBigInteger('clubes_id')->nullable();
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
		Schema::dropIfExists('terminos_y_condiciones');
	}
}
