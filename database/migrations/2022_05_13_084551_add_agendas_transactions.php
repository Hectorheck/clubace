<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgendasTransactions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transactions', function (Blueprint $table) {
			$table->string('agendas_id')->nullable()->after('agenda_id')->comment('Cuando es mas de una agenda en la transaccion');
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
			//
		});
	}
}
