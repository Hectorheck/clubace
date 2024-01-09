<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubesApiInfosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clubes_api_infos', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('clubes_id')->nullable();
			$table->string('token_club', 80)->nullable();
			$table->string('fbase_api_key')->nullable();
			$table->tinyInteger('compartido')->comment('1=si,0=no')->nullable();
			$table->tinyInteger('app')->comment('1=si,0=no')->nullable();
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
		Schema::dropIfExists('clubes_api_infos');
	}
}
