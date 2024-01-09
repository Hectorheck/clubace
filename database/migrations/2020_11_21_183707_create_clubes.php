<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubes extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clubes', function (Blueprint $table) {
			$table->id();
			$table->string('rut', 10)->unique()->nullable();
			$table->string('razon_social')->nullable();
			$table->string('display_name')->nullable();
			$table->string('representante_legal_rut', 10)->nullable();
			$table->string('representante_legal_nombre')->nullable();
			$table->string('geo_lat')->nullable();
			$table->string('geo_lng')->nullable();
			$table->string('direccion_calle', 100)->nullable();
			$table->string('direccion_numero', 10)->nullable();
			$table->string('direccion_apartado_especial', 20)->nullable();
			$table->boolean('tiene_servicio_agendamiento')->nullable();
			$table->boolean('tiene_servicio_arrendamiento')->nullable();
			$table->boolean('tiene_servicio_escalerilla')->nullable();
			$table->boolean('tiene_servicio_clases')->nullable();
			$table->unsignedBigInteger('comunas_id')->nullable();
			$table->string('color_1', 20);
			$table->string('color_2', 20);
			$table->string('logo_url', 200)->nullable();
			$table->string('horario_defecto_uso_cancha', 45)->nullable();
			$table->string('dias_atencion', 100);
			$table->string('alcance_club', 20)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('clubes');
	}
}
