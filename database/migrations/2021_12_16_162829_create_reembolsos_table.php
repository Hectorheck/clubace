<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReembolsosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reembolsos', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('transactions_id')->nullable();
			$table->string('token')->nullable();
			$table->string('buy_order')->nullable();
			$table->string('commerce_code')->nullable();
			$table->integer('amount')->nullable();
			$table->text('response')->nullable();
			$table->string('type')->nullable();
			$table->string('authorization_code')->nullable();
			$table->string('authorization_date')->nullable();
			$table->string('balance')->nullable();
			$table->string('nullified_amount')->nullable();
			$table->string('response_code')->nullable();
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
		Schema::dropIfExists('reembolsos');
	}
}
