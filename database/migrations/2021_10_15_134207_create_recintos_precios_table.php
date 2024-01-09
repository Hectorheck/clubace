<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecintosPreciosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recintos_precios', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('recintos_id')->nullable();
			$table->time('desde')->nullable();
			$table->time('hasta')->nullable();
			$table->string('nombre')->nullable();
			$table->string('comentario')->nullable();
			$table->string('estado')->nullable();
			$table->integer('precio')->nullable();
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
		Schema::dropIfExists('recintos_precios');
	}
}
