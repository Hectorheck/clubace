<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TipoUsers;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		TipoUsers::create(['tipo' => 'SUPERADMIN']);
		TipoUsers::create(['tipo' => 'ADMIN']);
		TipoUsers::create(['tipo' => 'SOCIO']);
		TipoUsers::create(['tipo' => 'INVITADO']);
		User::create([
			'email' => 'leandro161996@gmail.com',
			'rut' => '11111111-1',
			'tipo_usuarios_id' => 1,
			'nombres' => 'Leandro Ignacio',
			'apellido_paterno' => 'Nuñez',
			'apellido_materno' => 'Gonzalez',
			'fecha_nacimiento' => '1996-04-23',
			'direccion' => 'Alameda 107',
			'ciudad' => 'Rancagua',
			'comunas_id' => 79,
			'regiones_id' => 6,
			'rol_admin_general' => '1',
			'rol_admin_club' => '0',
			'rol_socio_club' => '0',
			'estado_cuenta' => '1',
			'password' => bcrypt('123123'),
		]);
		User::create([
			'email' => 'admin@ace.cl',
			'rut' => '22222222-2',
			'tipo_usuarios_id' => 1,
			'nombres' => 'Administrador',
			'apellido_paterno' => NULL,
			'apellido_materno' => NULL,
			'fecha_nacimiento' => '2020-11-21',
			'direccion' => '',
			'ciudad' => 'Rancagua',
			'comunas_id' => 79,
			'regiones_id' => 6,
			'rol_admin_general' => '1',
			'rol_admin_club' => '0',
			'rol_socio_club' => '0',
			'estado_cuenta' => '1',
			'password' => bcrypt('123123'),
		]);
	}
}
