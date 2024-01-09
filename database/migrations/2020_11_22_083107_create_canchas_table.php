<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanchasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('canchas', function (Blueprint $table) {
			$table->id();
			$table->string('codigo')->nullable();
			$table->string('display_name')->nullable();
			$table->unsignedBigInteger('clubes_id')->nullable();
			$table->string('tipo')->nullable();
			$table->string('observaciones_publicas')->nullable();
			$table->string('observaciones_privadas')->nullable();
			$table->year('agno_construccion')->nullable();
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
		Schema::dropIfExists('canchas');
	}
}
