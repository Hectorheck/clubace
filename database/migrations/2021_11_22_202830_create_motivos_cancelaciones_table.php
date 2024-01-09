<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotivosCancelacionesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('motivos_cancelaciones', function (Blueprint $table) {
			$table->id();
			$table->string('motivo')->nullable();
			$table->unsignedBigInteger('clubes_id')->nullable(); // OPCIONAL SI SE DEJAN SEGUN CLUBES CREO
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
		Schema::dropIfExists('motivos_cancelaciones');
	}
}
