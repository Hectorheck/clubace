<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reservas', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('users_id')->nullable();
			$table->string('forma_pago')->nullable();
			$table->text('informacion_pago')->nullable();
			$table->string('estado')->nullable();
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
		Schema::dropIfExists('reservas');
	}
}
