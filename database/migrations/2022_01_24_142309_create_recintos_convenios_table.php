<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecintosConveniosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recintos_convenios', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('recintos_id')->nullable();
			$table->unsignedBigInteger('convenios_id')->nullable();
			$table->integer('valor')->nullable();
			$table->integer('porcentaje')->nullable();
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
		Schema::dropIfExists('recintos_convenios');
	}
}
