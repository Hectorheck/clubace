<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataReembolsos extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('reembolsos', function (Blueprint $table) {
			$table->unsignedBigInteger('users_id')->after('transactions_id')->nullable();
			$table->unsignedBigInteger('agenda_id')->after('transactions_id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('reembolsos', function (Blueprint $table) {
			$table->dropColumn(['users_id','agenda_id']);
		});
	}
}
