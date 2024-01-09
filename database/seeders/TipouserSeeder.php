<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoUsers;

class TipouserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		TipoUsers::create(['tipo' => 'ENTRENADOR']);
		TipoUsers::create(['tipo' => 'RECEPCIONISTA']);
		TipoUsers::create(['tipo' => 'VISUALIZADOR']);
	}
}
