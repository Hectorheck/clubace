<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecintosHorarios extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('recintos', function (Blueprint $table) {
			$table->string('bloque_horario')->nullable()->after('servicios_id');
			$table->time('hora_inicio')->nullable()->after('bloque_horario');
			$table->time('hora_fin')->nullable()->after('hora_inicio');
			$table->boolean('socios')->nullable()->after('hora_fin');
            $table->boolean('arriendo')->nullable()->after('socios');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('recintos', function (Blueprint $table) {
			$table->dropColumn('bloque_horario');
			$table->dropColumn('hora_inicio');
			$table->dropColumn('hora_fin');
			$table->dropColumn('socios');
			$table->dropColumn('arriendo');
		});
	}
}
