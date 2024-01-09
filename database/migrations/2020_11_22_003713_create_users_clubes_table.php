<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersClubesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_clubes', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('clubes_id')->nullable();
			$table->unsignedBigInteger('users_id')->nullable();
			$table->boolean('socio')->nullable();
			$table->boolean('tenis')->nullable();
			$table->boolean('furbol')->nullable();
			$table->boolean('gimnasio')->nullable();
			$table->boolean('quincho')->nullable();
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
		Schema::dropIfExists('users_clubes');
	}
}
