<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			// $table->string('name');
			// DATOS
			$table->unsignedBigInteger('tipo_usuarios_id')->nullable();
			$table->string('nombres')->nullable();
			$table->string('apellido_paterno')->nullable();
			$table->string('apellido_materno')->nullable();
			$table->string('rut')->nullable()->unique();
			$table->date('fecha_nacimiento')->nullable();
			$table->string('direccion')->nullable();
			$table->string('ciudad')->nullable();
			$table->unsignedBigInteger('comunas_id')->nullable();
			$table->unsignedBigInteger('regiones_id')->nullable();
			$table->boolean('rol_admin_general')->nullable();
			$table->boolean('rol_admin_club')->nullable();
			$table->boolean('rol_socio_club')->nullable();
			$table->boolean('estado_cuenta')->nullable();
			$table->string('motivo_suspencion')->nullable();
			// DATOS
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->rememberToken();
			// $table->foreignId('current_team_id')->nullable();
			$table->text('profile_photo_path')->nullable();
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
		Schema::dropIfExists('users');
	}
}
