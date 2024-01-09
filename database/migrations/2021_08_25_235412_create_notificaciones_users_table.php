<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 * multicast_id": 383437938688207693
	 * +"success": 1
	 * +"failure": 0
	 * +"canonical_ids
	 */
	public function up()
	{
		Schema::create('notificaciones_users', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id')->nullable();
			$table->unsignedBigInteger('notificaciones_id')->nullable();
			$table->string('estado')->nullable(); // LEIDO, ENTREGADO
			$table->timestamp('leido')->nullable(); // FECHA Y HORA DE CUANDO SE LEYO
			$table->string('message_id')->nullable();
			$table->string('multicast_id')->nullable();
			$table->string('success')->nullable();
			$table->string('failure')->nullable();
			$table->string('canonical_ids')->nullable();
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
		Schema::dropIfExists('notificaciones_users');
	}
}
