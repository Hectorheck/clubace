<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDevicesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_devices', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id')->nullable();
			$table->string('os')->nullable();
			$table->string('device')->nullable();
			$table->string('fcm_token')->nullable();
			$table->timestamp('last_activity')->nullable();
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
		Schema::dropIfExists('user_devices');
	}
}
