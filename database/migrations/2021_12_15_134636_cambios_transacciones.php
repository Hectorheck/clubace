<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CambiosTransacciones extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transactions', function (Blueprint $table) {
			$table->string('tipo')->after('agenda_id')->nullable();
			$table->unsignedBigInteger('user_id')->after('tipo')->nullable();
			// $table->integer('monto_reembolso')->after('tipo')->nullable();
			// $table->boolean('reembolsado')->after('monto_reembolso')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('transactions', function (Blueprint $table) {
			$table->dropColumn(['tipo','user_id']);
		});
	}
}
