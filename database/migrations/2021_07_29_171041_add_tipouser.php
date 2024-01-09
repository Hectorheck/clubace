<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipouser extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_clubes', function (Blueprint $table) {
			$table->unsignedBigInteger('tipo_usuarios_id')->nullable()->after('estado');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_clubes', function (Blueprint $table) {
			$table->dropColumn('tipo_usuarios_id');
		});
	}
}
