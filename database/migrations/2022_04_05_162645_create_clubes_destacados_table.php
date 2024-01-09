<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubesDestacadosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clubes_destacados', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('clubes_id')->nullable();
			$table->unsignedBigInteger('user_id')->nullable();
			$table->boolean('destacado')->nullable();// [1 => si, 0 => no]
			$table->tinyInteger('lugar')->nullable();
			$table->date('inicio')->nullable();
			$table->date('termino')->nullable();
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
		Schema::dropIfExists('clubes_destacados');
	}
}
