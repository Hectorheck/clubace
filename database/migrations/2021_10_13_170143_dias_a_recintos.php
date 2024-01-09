<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DiasARecintos extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('recintos', function (Blueprint $table) {
			$table->string('dias_atencion', 100)->nullable()->after('hora_fin');
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
			$table->dropColumn(['dias_atencion']);
		});
	}
}
