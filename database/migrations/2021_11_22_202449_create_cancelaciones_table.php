<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancelacionesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cancelaciones', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('users_id')->nullable();
			$table->unsignedBigInteger('agenda_id')->nullable();
			$table->unsignedBigInteger('reservas_id')->nullable();
			$table->unsignedBigInteger('motivos_cancelaciones_id')->nullable();
			$table->string('comentario')->nullable();
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
		Schema::dropIfExists('cancelaciones');
	}
}
