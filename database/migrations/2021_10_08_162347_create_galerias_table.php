<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGaleriasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('galerias', function (Blueprint $table) {
			$table->id();
			$table->string('modelo')->nullable();
			$table->unsignedBigInteger('modelo_id')->nullable();
			$table->string('nombre')->nullable();
			$table->string('extension')->nullable();
			$table->string('ruta')->nullable();
			$table->integer('orden')->nullable();
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
		Schema::dropIfExists('galerias');
	}
}
